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
            <select class="search-select w-full p-2 border border-gray-300 rounded-md appearance-none" id="huyen" name="huyen">
                <option value="">Chọn quận/huyện</option>
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
        const loaiHinhSelect = document.querySelector('.search-select[name="loai-hinh"]');
        const tinhSelect = document.querySelector('.search-select[name="tinh"]');
        const huyenSelect = document.querySelector('.search-select[name="huyen"]');
        const xaPhuongSelect = document.querySelector('.search-select[name="xa-phuong"]');
        const domain = 'http://127.0.0.1:8000';
        // Lấy dữ liệu "Loại hình" từ API
        fetch(`${domain}/api/v1/entertainment-types`)
            .then(response => response.json())
            .then(data => {
                data.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.id;
                    option.id = type.slug; // Sử dụng slug làm id
                    option.textContent = type.name;
                    loaiHinhSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));

        // Lấy dữ liệu "Tỉnh/thành" từ API
        fetch(`${domain}/api/v1/provinces`)
            .then(response => response.json())
            .then(data => {
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.id;
                    option.id = province.slug; // Sử dụng slug làm id
                    option.textContent = province.name;
                    tinhSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));

        fetch(`${domain}/api/v1/districts`)
            .then(response => response.json())
            .then(data => {
                data.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.id = district.slug; // Sử dụng slug làm id
                    option.textContent = district.name;
                    huyenSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));

        // lấy dữ liệu xã/phường
        fetch(`${domain}/api/v1/wards`)
            .then(response => response.json())
            .then(data => {
                data.forEach(ward => {
                    const option = document.createElement('option');
                    option.value = ward.id;
                    option.id = ward.slug; // Sử dụng slug làm id
                    option.textContent = ward.name;
                    xaPhuongSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));

        tinhSelect.addEventListener('change', function() {
            const selectedProvince = this.value;
            huyenSelect.innerHTML = '<option value="">Quận/huyện</option>';
            xaPhuongSelect.innerHTML = '<option value="">Xã/phường</option>';
            if (selectedProvince) {
                fetch(`${domain}/api/v1/districts/province/${selectedProvince}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(district => {
                            const option = document.createElement('option');
                            option.value = district.id;
                            option.id = district.slug; // Sử dụng slug làm id
                            option.textContent = district.name;
                            huyenSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        // Sự kiện khi thay đổi lựa chọn quận/huyện
        huyenSelect.addEventListener('change', function() {
            const selectedDistrict = this.value;
            xaPhuongSelect.innerHTML = '<option value="">Xã/phường</option>';
            if (selectedDistrict) {
                fetch(`${domain}/api/v1/wards/district/${selectedDistrict}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(ward => {
                            const option = document.createElement('option');
                            option.value = ward.id;
                            option.id = ward.slug; // Sử dụng slug làm id
                            option.textContent = ward.name;
                            xaPhuongSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    });

    function timKiem() {
        const loaiHinhSelect = document.getElementById('loai-hinh');
        const tinhSelect = document.getElementById('tinh');
        const huyenSelect = document.getElementById('huyen');
        const xaPhuongSelect = document.getElementById('xa-phuong');

        const loaiHinh = loaiHinhSelect.options[loaiHinhSelect.selectedIndex].id;
        const tinh = tinhSelect.options[tinhSelect.selectedIndex].id;
        const huyen = huyenSelect.options[huyenSelect.selectedIndex].id;
        const xaPhuong = xaPhuongSelect.options[xaPhuongSelect.selectedIndex].id;
        console.log(loaiHinh, tinh, huyen, xaPhuong);

        let newUrl = '';
        if (loaiHinh) {
            newUrl += `/${loaiHinh}`;
        }
        if (tinh) {
            newUrl += `-${tinh}`;
        }
        if (huyen) {
            newUrl += `-${huyen}`;
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