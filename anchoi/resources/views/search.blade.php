<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgY2xhc3M9InctOCBoLTgiPjxjaXJjbGUgY3g9IjEyIiBjeT0iMTIiIHI9IjEiPjwvY2lyY2xlPjxwYXRoIGQ9Ik0yMC4yIDIwLjJjMi4wNC0yLjAzLjAyLTcuMzYtNC41LTExLjktNC41NC00LjUyLTkuODctNi41NC0xMS45LTQuNS0yLjA0IDIuMDMtLjAyIDcuMzYgNC41IDExLjkgNC41NCA0LjUyIDkuODcgNi41NCAxMS45IDQuNVoiPjwvcGF0aD48cGF0aCBkPSJNMTUuNyAxNS43YzQuNTItNC41NCA2LjU0LTkuODcgNC41LTExLjktMi4wMy0yLjA0LTcuMzYtLjAyLTExLjkgNC41LTQuNTIgNC41NC02LjU0IDkuODctNC41IDExLjkgMi4wMyAyLjA0IDcuMzYgLjAyIDExLjktNC41WiI+PC9wYXRoPjwvc3ZnPg==" type="image/svg+xml">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body>
    <header id="header">
        <h1 class="text-2xl font-bold">Tìm điểm ăn chơi</h1>
    </header>



    <div class="search-bar flex flex-wrap gap-4 mt-4 p-4 bg-gray-100 rounded-lg">
        <div class="search-select-container relative w-full sm:w-1/2 md:w-1/4">
            <select class="search-select w-full p-2 border border-gray-300 rounded-md appearance-none" id="loai-hinh" name="loai-hinh">
                <option value="">Chọn loại hình</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>
        <div class="search-select-container relative w-full sm:w-1/2 md:w-1/4">
            <select class="search-select w-full p-2 border border-gray-300 rounded-md appearance-none" id="tinh" name="tinh">
                <option value="">Chọn tỉnh/thành phố</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>
        <div class="search-select-container relative w-full sm:w-1/2 md:w-1/4">
            <select class="search-select w-full p-2 border border-gray-300 rounded-md appearance-none" id="xa-phuong" name="xa-phuong">
                <option value="">Chọn xã/phường</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>
        <div class="search-select-container relative w-full sm:w-1/2 md:w-1/4">
            <button class="search-button w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md"
                onclick="timKiem()">Tìm kiếm</button>

        </div>
        <div class="search-select-container relative w-full sm:w-1/2 md:w-1/4">
            <button class="search-button w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md"
                onclick="timKiemGanDay()">Tìm kiếm gần đây</button>

        </div>

    </div>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const domain = 'http://127.0.0.1:8000';

        // Hàm kiểm tra và xử lý vị trí
        async function handleLocation() {
            try {
                // Kiểm tra vị trí đã lưu trước
                const response = await fetch(`${domain}/get-location`);
                const data = await response.json();
                
                if (data.status === 'success' && data.has_location) {
                    console.log('Đã có vị trí trong session');
                    return;
                }

                // Nếu chưa có vị trí hoặc vị trí đã cũ, yêu cầu vị trí mới
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        position => savePosition(position),
                        error => console.error('Lỗi khi lấy vị trí:', error),
                        { enableHighAccuracy: true }
                    );
                }
            } catch (error) {
                console.error('Lỗi khi kiểm tra vị trí:', error);
            }
        }

        // Hàm lưu vị trí
        function savePosition(position) {
            fetch(`${domain}/save-location`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                })
            })
            .then(response => response.json())
            .then(data => console.log('Vị trí đã được lưu:', data))
            .catch(error => console.error('Lỗi khi lưu vị trí:', error));
        }

        // Khởi động xử lý vị trí
        handleLocation();

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
                if (now - timestamp < expirationHours * 60 * 60 * 1000) {
                    return data;
                }
            }

            try {
                const response = await fetch(`${domain}${apiUrl}`);
                const data = await response.json();
                localStorage.setItem(key, JSON.stringify({
                    data,
                    timestamp: new Date().getTime()
                }));
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
</body>

</html>