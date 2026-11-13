import './bootstrap';

/**
 * Hiệu ứng động (progressive enhancement, SEO-safe):
 * - .reveal CHỈ do JS gắn -> crawler/không JS vẫn thấy nội dung.
 * - Fallback 3s hiện hết dù chưa cuộn tới (phòng Googlebot không cuộn).
 */
function initReveal() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) return;
    const targets = document.querySelectorAll('.spot-card, main section > h1, main section > h2, .hero-banner');
    if (!targets.length) return;

    targets.forEach((el) => el.classList.add('reveal'));
    const io = new IntersectionObserver((entries, obs) => {
        entries.forEach((e) => {
            if (e.isIntersecting) { e.target.classList.add('in'); obs.unobserve(e.target); }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
    targets.forEach((el) => io.observe(el));

    setTimeout(() => targets.forEach((el) => el.classList.add('in')), 3000);
}

// Thanh loading mảnh khi chuyển trang (cảm giác mượt)
function initRouteProgress() {
    const bar = document.createElement('div');
    bar.id = 'route-progress';
    document.body.appendChild(bar);
    let active = false;

    document.addEventListener('click', (e) => {
        const a = e.target.closest('a');
        if (!a || e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey) return;
        const href = a.getAttribute('href') || '';
        if (!href || a.target === '_blank' || a.hasAttribute('download') ||
            href.startsWith('#') || href.startsWith('mailto') || href.startsWith('tel') ||
            (a.hostname && a.hostname !== location.hostname)) return;
        active = true;
        bar.style.opacity = '1';
        bar.style.width = '0';
        requestAnimationFrame(() => { bar.style.width = '80%'; });
    });

    window.addEventListener('pageshow', () => {
        if (!active) return;
        bar.style.width = '100%';
        setTimeout(() => { bar.style.opacity = '0'; active = false; }, 250);
    });
}

/**
 * Cuộn vô tận: #spot-grid[data-next] chứa URL trang kế (?page=N&ajax=1).
 * Trang 1 là SSR (SEO ok); JS nạp thêm khi cuộn gần đáy. Nút "Tải thêm" là fallback no-JS.
 */
function initInfiniteScroll() {
    const grid = document.getElementById('spot-grid');
    if (!grid) return;
    let next = grid.dataset.next;
    if (!next) return;

    const btn = document.getElementById('load-more');
    if (btn) btn.style.display = 'none'; // JS lo việc nạp -> ẩn nút fallback
    let loading = false;

    const sentinel = document.createElement('div');
    sentinel.style.height = '1px';
    grid.parentNode.insertBefore(sentinel, grid.nextSibling);

    const io = new IntersectionObserver(async (entries) => {
        if (!entries[0].isIntersecting || loading || !next) return;
        loading = true;
        try {
            const res = await fetch(next, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            grid.insertAdjacentHTML('beforeend', data.html);
            next = data.nextPageUrl || null;
            initReveal(); // hiệu ứng cho card mới
        } catch (e) {
            if (btn) btn.style.display = ''; // lỗi -> trả lại nút bấm tay
        }
        loading = false;
        if (!next) io.disconnect();
    }, { rootMargin: '400px' });

    io.observe(sentinel);
}

document.addEventListener('DOMContentLoaded', () => { initReveal(); initRouteProgress(); initInfiniteScroll(); });

/**
 * Vị trí người dùng: xin quyền ĐÚNG 1 LẦN, và CHỈ đọc GPS khi cần.
 * - Mỗi lần vào: hỏi server; nếu đã có vị trí còn mới (< 30 phút) -> dùng luôn, KHÔNG đọc GPS.
 * - Nếu chưa có / đã cũ -> đọc GPS một lần (getCurrentPosition), không theo dõi liên tục.
 * - Permissions API: nếu đã 'granted' thì đọc thẳng, không hỏi lại.
 * - localStorage 'geo_asked': chỉ bật prompt một lần duy nhất.
 */
(function initGeolocation() {
    if (!('geolocation' in navigator)) return;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrf) return;

    const FRESH_SECONDS = 1800; // 30 phút

    const save = (pos) => {
        fetch('/save-location', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ latitude: pos.coords.latitude, longitude: pos.coords.longitude }),
        }).catch(() => {});
    };

    const readGpsOnce = () =>
        navigator.geolocation.getCurrentPosition(save, () => {}, {
            enableHighAccuracy: false,
            timeout: 15000,
            maximumAge: 600000,
        });

    const readIfAllowed = () => {
        if (navigator.permissions?.query) {
            navigator.permissions.query({ name: 'geolocation' }).then((status) => {
                if (status.state === 'granted') readGpsOnce();          // đã cấp -> đọc, không hỏi
                else if (status.state === 'prompt') askOnce();          // chưa hỏi -> hỏi 1 lần
                // 'denied' -> bỏ qua
            }).catch(askOnce);
        } else {
            askOnce();
        }
    };

    const askOnce = () => {
        if (localStorage.getItem('geo_asked')) return;
        localStorage.setItem('geo_asked', '1');
        readGpsOnce();
    };

    // Chỉ đọc GPS khi server chưa có vị trí mới
    fetch('/get-location')
        .then((r) => r.json())
        .then((d) => {
            if (d.status === 'success' && d.has_location && d.age_seconds < FRESH_SECONDS) return; // còn mới, dùng luôn
            readIfAllowed();
        })
        .catch(readIfAllowed);
})();
