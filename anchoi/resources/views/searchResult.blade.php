<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$pageTitle}}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgY2xhc3M9InctOCBoLTgiPjxjaXJjbGUgY3g9IjEyIiBjeT0iMTIiIHI9IjEiPjwvY2lyY2xlPjxwYXRoIGQ9Ik0yMC4yIDIwLjJjMi4wNC0yLjAzLjAyLTcuMzYtNC41LTExLjktNC41NC00LjUyLTkuODctNi41NC0xMS45LTQuNS0yLjA0IDIuMDMtLjAyIDcuMzYgNC41IDExLjkgNC41NCA0LjUyIDkuODcgNi41NCAxMS45IDQuNVoiPjwvcGF0aD48cGF0aCBkPSJNMTUuNyAxNS43YzQuNTItNC41NCA2LjU0LTkuODcgNC41LTExLjktMi4wMy0yLjA0LTcuMzYtLjAyLTExLjkgNC41LTQuNTIgNC41NC02LjU0IDkuODctNC41IDExLjkgMi4wMyAyLjA0IDcuMzYgLjAyIDExLjktNC41WiI+PC9wYXRoPjwvc3ZnPg==" type="image/svg+xml"> 

    @foreach ($entertainmentSpots as $entertainmentSpot)
    <script type="application/ld+json">
        @php
        echo json_encode($entertainmentSpot->header);
        @endphp
    </script>
    @endforeach
</head>

<body class="bg-gray-100 dark:bg-gray-900">

    <div class="flex flex-col min-h-screen">  <!-- Wrap everything in a container -->
        
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
        <main class="container mx-auto px-4 py-8  pt-20">

            @include('search')

            <section class="py-4">
                <div class="flex flex-row items-end gap-4">
                    <h2 class="text-2xl font-semibold">{{$title}}</h2>
                </div>
                <div class="grid lg:grid-cols-4 gap-8 md:grid-cols-3 sm:grid-cols-2 max-[450px]:grid-cols-1 mt-4">
                    @foreach ($entertainmentSpots as $spot)
                    <a href="{{ $spot->url }}" class="overflow-hidden group">
                        <div class="rounded-xl shadow-lg bg-white dark:bg-gray-800 hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                            <div class="relative h-64">
                                <img src="/{{ $spot->banner_image }}" alt="{{ $spot->name }}" class="absolute inset-0 object-cover w-full h-full" />
                            </div>
                            <div class="px-4 py-2">
                                <h3 class="font-semibold text-xl line-clamp-1 text-ellipsis">{{ Str::limit($spot->name, 32, '...') }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-2 text-ellipsis">
                                    Địa điểm:
                                    {{ Str::limit($spot->full_address, 35, '...') }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-1 text-ellipsis">Số điện thoại: {{ $spot->phone_number }}</p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-1 text-ellipsis">Khu vực: {{ $spot->ward_name }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach

                </div>
            </section>
        </main>

        <footer class="bg-gray-100 dark:bg-gray-800 mt-2 border-t border-gray-200 dark:border-gray-700 py-4">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <a href="/" class="logo cursor-pointer flex items-center flex-row gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                                <circle cx="12" cy="12" r="1"></circle>
                                <path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path>
                                <path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>
                            </svg>
                            <p class="text-xl font-semibold">Ăn chơi nét</p>
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

    <script>
            document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });
    
});

        function requestLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        // Gửi dữ liệu vị trí lên server (AJAX)
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
                            console.log("Vị trí đã được lưu vào session.");
                            // Chuyển hướng đến trang phù hợp (nếu cần)
                        })
                        .catch(error => {
                            console.error("Lỗi khi lưu vị trí vào session:", error);
                            alert("Có lỗi xảy ra khi lưu vị trí. Vui lòng thử lại sau.");
                        });
                    },
                    (error) => {
                        console.error('Lỗi khi lấy vị trí:', error);
                        alert('Vui lòng cho phép truy cập vị trí của bạn.');
                    }
                );
            } else {
                alert('Trình duyệt của bạn không hỗ trợ Geolocation.');
            }
        }

        // Gọi hàm requestLocation khi trang được tải
        window.addEventListener('load', requestLocation);
    </script>
</body>

</html>