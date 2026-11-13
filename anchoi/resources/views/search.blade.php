{{-- Hero + bộ lọc tìm kiếm. Đây là FRAGMENT include vào <main>, KHÔNG phải trang HTML riêng. --}}
<section class="hero-banner relative overflow-hidden rounded-2xl px-6 py-10 sm:px-10 sm:py-14 text-white">
    <div class="relative z-10 max-w-3xl">
        <h1 class="text-3xl sm:text-4xl font-bold leading-tight tracking-tight text-balance">
            Tìm địa điểm ăn chơi khắp Việt Nam
        </h1>
        <p class="mt-3 text-white/80 text-base sm:text-lg text-pretty">
Club, karaoke, bar, nhà hàng &mdash; chọn khu vực hoặc tìm ngay gần bạn.
        </p>
    </div>

    <form action="/tim-kiem" method="GET" class="relative z-10 mt-6 flex gap-2">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Tìm theo tên quán, địa điểm..."
               class="w-full rounded-xl border-0 bg-white/95 px-4 py-3 text-gray-800 shadow-lg placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-white" />
        <button type="submit" class="shrink-0 rounded-xl bg-white px-5 py-3 font-semibold text-brand-600 shadow-lg transition hover:bg-brand-50">Tìm</button>
    </form>

    <div class="search-bar relative z-10 mt-3 flex flex-wrap gap-3 rounded-xl bg-white/95 backdrop-blur p-4 shadow-xl">
        <div class="search-select-container relative w-full sm:w-[calc(50%-0.375rem)] lg:w-[calc(20%-0.6rem)]">
            <select class="search-select" id="loai-hinh" name="loai-hinh">
                <option value="">Chọn loại hình</option>
            </select>
            <svg class="select-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
        </div>
        <div class="search-select-container relative w-full sm:w-[calc(50%-0.375rem)] lg:w-[calc(20%-0.6rem)]">
            <select class="search-select" id="tinh" name="tinh">
                <option value="">Chọn tỉnh/thành phố</option>
            </select>
            <svg class="select-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
        </div>
        <div class="search-select-container relative w-full sm:w-[calc(50%-0.375rem)] lg:w-[calc(20%-0.6rem)]">
            <select class="search-select" id="xa-phuong" name="xa-phuong">
                <option value="">Chọn xã/phường</option>
            </select>
            <svg class="select-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
        </div>
        <div class="w-full sm:w-[calc(50%-0.375rem)] lg:w-[calc(20%-0.6rem)]">
            <button class="btn-primary w-full" onclick="timKiem()">Tìm kiếm</button>
        </div>
        <div class="w-full sm:w-[calc(50%-0.375rem)] lg:w-[calc(20%-0.6rem)]">
            <button class="btn-ghost w-full" onclick="timKiemGanDay()">Gần bạn</button>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const domain = ''; // geolocation được xử lý tập trung trong resources/js/app.js

        const loaiHinhSelect = document.querySelector('.search-select[name="loai-hinh"]');
        const tinhSelect = document.querySelector('.search-select[name="tinh"]');
        const xaPhuongSelect = document.querySelector('.search-select[name="xa-phuong"]');

        // Disable các select phụ thuộc ban đầu
        tinhSelect.disabled = true;
        xaPhuongSelect.disabled = true;

        // Hàm lấy dữ liệu từ localStorage hoặc API
        async function getDataFromLocalOrAPI(key, apiUrl, expirationHours = 24) {
            const stored = localStorage.getItem(key);
            if (stored) {
                const { data, timestamp } = JSON.parse(stored);
                const now = new Date().getTime();
                // chỉ dùng cache khi còn hạn VÀ không rỗng (tránh kẹt mảng rỗng 24h)
                if (Array.isArray(data) && data.length && now - timestamp < expirationHours * 60 * 60 * 1000) {
                    return data;
                }
            }

            try {
                const response = await fetch(`${domain}${apiUrl}`);
                const data = await response.json();
                if (Array.isArray(data) && data.length) {
                    localStorage.setItem(key, JSON.stringify({ data, timestamp: new Date().getTime() }));
                }
                return data;
            } catch (error) {
                console.error('Error:', error);
                return [];
            }
        }

        // Hàm reset và disable select
        function resetSelect(select, disable = true, value) {
            select.innerHTML = `<option value="">Chọn ${value}</option>`;
            select.disabled = disable;
        }

        // Load dữ liệu loại hình
        getDataFromLocalOrAPI('entertainmentTypes', '/api/v1/entertainment-types')
            .then(data => {
                data.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.id;
                    option.id = type.slug;
                    option.textContent = type.name;
                    loaiHinhSelect.appendChild(option);
                });
            });

        // Xử lý sự kiện khi chọn loại hình
        loaiHinhSelect.addEventListener('change', function() {
            resetSelect(tinhSelect, false, "tỉnh/thành phố");
            resetSelect(xaPhuongSelect, true, "xã/phường");

            if (this.value) {
                getDataFromLocalOrAPI('provinces', '/api/v1/provinces')
                    .then(data => {
                        data.forEach(province => {
                            const option = document.createElement('option');
                            option.value = province.id;
                            option.id = province.slug;
                            option.textContent = province.name;
                            tinhSelect.appendChild(option);
                        });
                    });
            }
        });

        // Xử lý sự kiện khi chọn tỉnh
        tinhSelect.addEventListener('change', function() {
            resetSelect(xaPhuongSelect, false, "xã/phường");

            if (this.value) {
                getDataFromLocalOrAPI(`wards_${this.value}`, `/api/v1/wards/province/${this.value}`)
                    .then(data => {
                        data.forEach(ward => {
                            const option = document.createElement('option');
                            option.value = ward.id;
                            option.id = ward.slug;
                            option.textContent = ward.name;
                            xaPhuongSelect.appendChild(option);
                        });
                    });
            }
        });
    });

    function timKiem() {
        const loaiHinhSelect = document.getElementById('loai-hinh');
        const tinhSelect = document.getElementById('tinh');
        const xaPhuongSelect = document.getElementById('xa-phuong');

        const loaiHinh = loaiHinhSelect.options[loaiHinhSelect.selectedIndex].id;
        const tinh = tinhSelect.options[tinhSelect.selectedIndex].id;
        const xaPhuong = xaPhuongSelect.options[xaPhuongSelect.selectedIndex].id;

        let newUrl = '';
        if (loaiHinh) {
            newUrl += `/${loaiHinh}`;
        }
        if (tinh) {
            newUrl += `-${tinh}`;
        }
        if (xaPhuong) {
            newUrl += `-${xaPhuong}`;
        }
        if (newUrl) {
            window.location.href = newUrl;
        }
    }

    function timKiemGanDay() {
        const loaiHinhSelect = document.getElementById('loai-hinh');
        const loaiHinh = loaiHinhSelect.options[loaiHinhSelect.selectedIndex].id;
        let newUrl = '/nearest';
        if (loaiHinh) {
            newUrl += `/${loaiHinh}`;
        }
        if (newUrl) {
            window.location.href = newUrl;
        }
    }
</script>
