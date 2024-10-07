<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ăn chơi nét</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgY2xhc3M9InctOCBoLTgiPjxjaXJjbGUgY3g9IjEyIiBjeT0iMTIiIHI9IjEiPjwvY2lyY2xlPjxwYXRoIGQ9Ik0yMC4yIDIwLjJjMi4wNC0yLjAzLjAyLTcuMzYtNC41LTExLjktNC41NC00LjUyLTkuODctNi41NC0xMS45LTQuNS0yLjA0IDIuMDMtLjAyIDcuMzYgNC41IDExLjkgNC41NCA0LjUyIDkuODcgNi41NCAxMS45IDQuNVoiPjwvcGF0aD48cGF0aCBkPSJNMTUuNyAxNS43YzQuNTItNC41NCA2LjU0LTkuODcgNC41LTExLjktMi4wMy0yLjA0LTcuMzYtLjAyLTExLjkgNC41LTQuNTIgNC41NC02LjU0IDkuODctNC41IDExLjkgMi4wMyAyLjA0IDcuMzYgLjAyIDExLjktNC41WiI+PC9wYXRoPjwvc3ZnPg==" type="image/svg+xml"> 

</head>

<body class="bg-gray-100 dark:bg-gray-900">

    <div class="flex flex-col min-h-screen">
        
    <header class="bg-white dark:bg-gray-800 py-4 shadow-md fixed top-0 left-0 w-full z-50">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <a href="/" class="logo cursor-pointer flex items-center flex-row gap-2">
            <!-- Logo and Text -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                <circle cx="12" cy="12" r="1"></circle>
                <path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path>
                <path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>
            </svg>
            <p class="text-xl font-semibold">Ăn chơi nét</p>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex space-x-6">
            <a href="/" class="text-gray-800 dark:text-white hover:underline">Trang chủ</a>
            <a href="/club" class="text-gray-800 dark:text-white hover:underline">Club</a>
            <a href="/karaoke" class="text-gray-800 dark:text-white hover:underline">Karaoke</a>
            <a href="/bar" class="text-gray-800 dark:text-white hover:underline">Bar</a>
            <a href="/nha-hang" class="text-gray-800 dark:text-white hover:underline">Nhà hàng</a>
            <a href="/blog" class="text-gray-800 dark:text-white hover:underline">Blog</a>
            <a href="/contact" class="text-gray-800 dark:text-white hover:underline">Liên hệ</a>
        </nav>

        <!-- Mobile Menu Button -->
        <button id="menu-toggle" class="md:hidden" aria-label="Toggle Navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu w-6 h-6 text-gray-800 dark:text-white">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
    </div>

    <!-- Mobile Navigation -->
    <nav id="mobile-menu" class="hidden md:hidden flex flex-col space-y-4 px-4 pb-4 bg-white dark:bg-gray-800 shadow-md">
    <a href="/" class="text-gray-800 dark:text-white hover:underline">Trang chủ</a>
    <a href="/club" class="text-gray-800 dark:text-white hover:underline">Club</a>
    <a href="/karaoke" class="text-gray-800 dark:text-white hover:underline">Karaoke</a>
    <a href="/bar" class="text-gray-800 dark:text-white hover:underline">Bar</a>
    <a href="/nha-hang" class="text-gray-800 dark:text-white hover:underline">Nhà hàng</a>
    <a href="/blog" class="text-gray-800 dark:text-white hover:underline">Blog</a>
    <a href="/contact" class="text-gray-800 dark:text-white hover:underline">Liên hệ</a>
</nav>
</header>

        <main class="flex-1 py-4  pt-20">
            <div class="container mx-auto">
                <h2 class="text-2xl font-semibold text-center mb-4">Blogs</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                    @foreach ($blogs as $blog)
                    <a href="{{$blog->url}}" class="block rounded-xl border bg-card hover:shadow-lg">
                        <img src="/{{$blog->banner_image}}" alt="Blog Image" class="w-full h-48 object-cover rounded-t-xl" />
                        <div class="p-4">
                            <h3 class="text-xl font-semibold">{{$blog->title}}</h3>
                            <p class="text-sm text-gray-500">Danh mục: {{$blog->category_name}}</p>
                            <p class="text-sm text-gray-500">Tạo lúc: {{$blog->created_at}}</p>
                            <p class="text-sm text-gray-500">Sửa lúc: {{$blog->updated_at}}</p>
                        </div>
                    </a>
                    @endforeach

                </div>
            </div>
        </main>

        <footer class="bg-gray-100 dark:bg-gray-800 mt-2 border-t border-gray-200 dark:border-gray-700 py-4">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <a href="/" class="logo cursor-pointer flex items-center flex-row gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-atom w-8 h-8 text-indigo-500 dark:text-indigo-400">
                                <circle cx="12" cy="12" r="1"></circle>
                                <path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path>
                                <path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>
                            </svg>
                            <p class="text-xl font-semibold text-gray-800 dark:text-white">Ăn chơi nét</p>
                        </a>
                        <div class="flex mt-4 md:mt-0">
                            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024. All Rights Reserved.</span>
                        </div>
                        <div class="flex mt-4 md:mt-0 space-x-4"></div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

</body>
<script>
        document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });
});
    function timKiemGanDayMenu(loaiHinh) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Gửi yêu cầu AJAX lên server
                    fetch("/save-location", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                            },
                            body: JSON.stringify({
                                latitude,
                                longitude,
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            // Kiểm tra phản hồi từ server
                            if (data.success) {
                                console.log("Vị trí đã được lưu vào session.");
                                // Chuyển hướng đến trang tìm kiếm gần nhất
                                let newUrl = `/nearest/${loaiHinh}`;
                                if (newUrl) {
                                    window.location.href = newUrl;
                                }
                            } else {
                                console.error(
                                    "Lỗi khi lưu vị trí vào session:",
                                    data
                                );
                                alert(
                                    "Có lỗi xảy ra khi lưu vị trí. Vui lòng thử lại sau."
                                );
                            }
                        })
                        .catch((error) => {
                            console.error("Lỗi khi lưu vị trí vào session:", error);
                            alert(
                                "Có lỗi xảy ra khi lưu vị trí. Vui lòng thử lại sau."
                            );
                        });
                },
                (error) => {
                    // Xử lý lỗi (người dùng từ chối cấp quyền hoặc lỗi khác)
                    console.error("Lỗi khi lấy vị trí:", error);
                    alert(
                        "Vui lòng cho phép truy cập vị trí của bạn để tìm kiếm gần nhất."
                    );
                }
            );
        } else {
            // Trình duyệt không hỗ trợ Geolocation
            alert("Trình duyệt của bạn không hỗ trợ Geolocation.");
        }
    }

    function timKiemGanDay() {
        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Lưu lat/lon vào session (bằng AJAX)
                fetch('/save-location', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            latitude,
                            longitude
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Xử lý phản hồi từ server (nếu cần)
                        console.log("Vị trí đã được lưu vào session.");
                        // Chuyển hướng đến trang tìm kiếm gần nhất (với tham số loaiHinh nếu có)
                        const loaiHinhSelect = document.getElementById('loai-hinh');
                        const loaiHinh = loaiHinhSelect.options[loaiHinhSelect.selectedIndex].id;
                        let newUrl = '/nearest';
                        if (loaiHinh) {
                            newUrl += `/${loaiHinh}`;
                        }
                        if (newUrl) {
                            window.location.href = newUrl;
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi khi lưu vị trí vào session:", error);
                        alert("Có lỗi xảy ra khi lưu vị trí. Vui lòng thử lại sau.");
                    });
            }, function(error) {
                // Xử lý lỗi (người dùng từ chối cấp quyền hoặc lỗi khác)
                console.error("Lỗi khi lấy vị trí:", error);
                alert("Vui lòng cho phép truy cập vị trí của bạn để tìm kiếm gần nhất.");
            });
        } else {
            // Trình duyệt không hỗ trợ Geolocation
            alert("Trình duyệt của bạn không hỗ trợ Geolocation.");
        }
    }
</script>

</html>