<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$blog->title}}</title>
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

        <main class="flex-1 overflow-y-auto  pt-20">
        <div class="container mx-auto py-4">
            <div class="flex flex-col items-center pb-2">
                <p class="text-2xl font-semibold">{{$blog->title}}</p>
                <p class="text-sm text-gray-500">Tạo lúc: {{$blog->created_at}}</p>
            </div>
            <div class="flex flex-col items-center gap-4">
            {!!$blog->body!!}
            </div>
        </div>
    </main>

        <footer class="bg-gray-100 dark:bg-gray-800 mt-2 border-t border-gray-200 dark:border-gray-700 py-4">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <a href="/" class="logo cursor-pointer flex items-center flex-row gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                            <circle cx="12" cy="12" r="1"></circle>
                            <path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path>
                            <path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>
                        </svg>
                        <p class="text-xl font-semibold">Ăn chơi nét</p>
                    </a>
                    <div class="mt-4 md:mt-0 text-gray-500 text-sm text-center">© 2024. All Rights Reserved.</div>
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
</script>
</html> 