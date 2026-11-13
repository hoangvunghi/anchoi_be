/**
 * Location Request Handler
 * Xử lý việc yêu cầu và lưu vị trí của user
 * Tránh hỏi liên tục bằng cách sử dụng localStorage
 */

async function requestLocation() {
    try {
        // Kiểm tra localStorage trước để tránh hỏi liên tục
        const lastAsked = localStorage.getItem('location_last_asked');
        const now = Date.now();
        
        // Nếu đã hỏi trong vòng 24 giờ qua thì không hỏi nữa
        if (lastAsked && (now - parseInt(lastAsked)) < 24 * 60 * 60 * 1000) {
            console.log('Đã hỏi vị trí gần đây, bỏ qua');
            return;
        }

        // Kiểm tra vị trí đã lưu trên server
        const response = await fetch('/get-location');
        const data = await response.json();
        
        if (data.status === 'success' && data.has_location) {
            console.log('Đã có vị trí trong session');
            return;
        }

        // Nếu chưa có vị trí, yêu cầu vị trí mới (chỉ 1 lần)
        if (navigator.geolocation) {
            // Lưu thời điểm hỏi để tránh hỏi lại
            localStorage.setItem('location_last_asked', now.toString());
            
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        console.error('CSRF token not found');
                        return;
                    }

                    fetch('/save-location', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                        },
                        body: JSON.stringify({ latitude, longitude })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Vị trí đã được lưu:', data);
                        localStorage.setItem('location_saved', 'true');
                    })
                    .catch(error => console.error('Lỗi khi lưu vị trí:', error));
                },
                (error) => {
                    console.error('Lỗi khi lấy vị trí:', error);
                    // Không alert để tránh làm phiền user
                    // User có thể từ chối location mà không cần thông báo
                },
                { 
                    enableHighAccuracy: false, 
                    timeout: 10000, 
                    maximumAge: 3600000 // Cache vị trí trong 1 giờ
                }
            );
        } else {
            console.log('Trình duyệt không hỗ trợ Geolocation.');
        }
    } catch (error) {
        console.error('Lỗi khi kiểm tra vị trí:', error);
    }
}

// Tự động gọi khi trang load
if (typeof window !== 'undefined') {
    window.addEventListener('load', requestLocation);
}
