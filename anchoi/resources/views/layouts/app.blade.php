<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ăn chơi nét - Tìm địa điểm giải trí, ăn uống hàng đầu Việt Nam')</title>
    <meta name="description" content="@yield('description', 'Khám phá các địa điểm ăn uống, club, karaoke, bar và nhà hàng tốt nhất gần bạn. Ăn chơi nét - Nền tảng tìm kiếm giải trí và ẩm thực hàng đầu.')">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Twitter --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Ăn chơi nét">
    <meta property="og:title" content="@yield('title', 'Ăn chơi nét')">
    <meta property="og:description" content="@yield('description', 'Nền tảng tìm kiếm địa điểm giải trí và ẩm thực hàng đầu Việt Nam.')">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
        <meta name="twitter:card" content="summary_large_image">
    @else
        <meta name="twitter:card" content="summary">
    @endif
    <meta name="twitter:title" content="@yield('title', 'Ăn chơi nét')">
    <meta name="twitter:description" content="@yield('description', 'Nền tảng tìm kiếm địa điểm giải trí và ẩm thực hàng đầu Việt Nam.')">

    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="flex min-h-screen flex-col bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-100">

    <header class="fixed top-0 left-0 z-50 w-full border-b border-black/5 bg-white/90 backdrop-blur dark:border-white/10 dark:bg-gray-900/90">
        <div class="container mx-auto flex items-center justify-between px-4 py-3">
            <a href="/" class="flex items-center gap-2 font-semibold text-brand-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7">
                    <circle cx="12" cy="12" r="1"></circle>
                    <path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path>
                    <path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>
                </svg>
                <span class="text-lg">Ăn chơi nét</span>
            </a>

            <nav class="hidden items-center gap-6 md:flex">
                @foreach (['/' => 'Trang chủ', '/club' => 'Club', '/karaoke' => 'Karaoke', '/bar' => 'Bar', '/nha-hang' => 'Nhà hàng', '/blog' => 'Blog', '/contact' => 'Liên hệ'] as $href => $label)
                    <a href="{{ $href }}" class="text-sm font-medium text-gray-600 transition hover:text-brand-600 dark:text-gray-300 dark:hover:text-brand-500">{{ $label }}</a>
                @endforeach
            </nav>

            <button id="menu-toggle" class="md:hidden" aria-label="Mở menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-gray-700 dark:text-white">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>

        <nav id="mobile-menu" class="hidden flex-col gap-1 border-t border-black/5 bg-white px-4 pb-4 pt-2 dark:border-white/10 dark:bg-gray-900 md:hidden">
            @foreach (['/' => 'Trang chủ', '/club' => 'Club', '/karaoke' => 'Karaoke', '/bar' => 'Bar', '/nha-hang' => 'Nhà hàng', '/blog' => 'Blog', '/contact' => 'Liên hệ'] as $href => $label)
                <a href="{{ $href }}" class="rounded-lg px-2 py-2 text-gray-700 transition hover:bg-brand-50 hover:text-brand-600 dark:text-gray-200">{{ $label }}</a>
            @endforeach
        </nav>
    </header>

    <main class="container mx-auto w-full flex-1 px-4 pb-12 pt-24">
        @yield('content')
    </main>

    @include('footer')

    <script>
        // Ảnh lỗi/thiếu (vd banner NULL) -> thay bằng placeholder, bắt toàn site ở capture phase
        document.addEventListener('error', function (e) {
            const img = e.target;
            // Bỏ qua tile bản đồ Leaflet (cũng là <img>) để không thay bằng placeholder
            if (img.tagName === 'IMG' && img.closest('.leaflet-container')) return;
            if (img.tagName === 'IMG' && !img.dataset.fallback) {
                img.dataset.fallback = '1';
                img.src = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='300'%3E%3Crect width='400' height='300' fill='%23e5e7eb'/%3E%3Ctext x='50%25' y='50%25' fill='%239ca3af' font-family='sans-serif' font-size='20' text-anchor='middle' dominant-baseline='middle'%3EĂn chơi nét%3C/text%3E%3C/svg%3E";
            }
        }, true);

        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenu.classList.toggle('flex');
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
