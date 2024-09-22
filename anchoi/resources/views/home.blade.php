<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ăn chơi nét</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900">

    <header class="bg-white dark:bg-gray-800 py-4 shadow-md">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <a href="/" class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-atom w-8 h-8 text-indigo-500">
                    <circle cx="12" cy="12" r="1"></circle>
                    <path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path>
                    <path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>
                </svg>
                <span class="text-xl font-semibold ml-2 text-gray-800 dark:text-white">Ăn chơi nét</span>
            </a>

            <nav class="hidden md:flex space-x-6">
                <a href="/" class="text-gray-800 dark:text-white hover:underline">Trang chủ</a>
                <a href="/nearest/club" class="text-gray-800 dark:text-white hover:underline">Điểm Club gần</a>
                <a href="/nearest/karaoke" class="text-gray-800 dark:text-white hover:underline">Điểm Karaoke gần</a>
                <a href="/nearest/bar" class="text-gray-800 dark:text-white hover:underline">Điểm Bar gần</a>
                <a href="/nearest/nha-hang" class="text-gray-800 dark:text-white hover:underline">Điểm Nhà hàng gần</a>
                <a href="/blog" class="text-gray-800 dark:text-white hover:underline">Blog</a>
                <a href="/contact" class="text-gray-800 dark:text-white hover:underline">Liên hệ</a>
            </nav>

            <button class="md:hidden" aria-label="Toggle Navigation">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu w-6 h-6 text-gray-800 dark:text-white">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">

        <section class="py-4">
            <h2 class="text-2xl font-semibold mb-4">Tìm điểm ăn chơi</h2>
            <form class="space-y-6">
                <div class="flex flex-row gap-4 flex-wrap">
                    <div class="space-y-2 flex flex-col">
                        <button class="bg-white dark:bg-gray-700 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md py-2 px-4 flex items-center justify-between w-full md:w-[200px]" type="button">
                            Chọn loại hình
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 opacity-50">
                                <path d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-2 flex flex-col">
                        <button class="bg-white dark:bg-gray-700 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md py-2 px-4 flex items-center justify-between w-full md:w-[200px]" type="button">
                            Chọn tỉnh/thành phố
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 opacity-50">
                                <path d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- ... other location filters -->
                    <button class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-md" type="submit">Tìm kiếm</button>
                    <button class="bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md py-2 px-4" type="button">Tìm kiếm gần đây</button>
                </div>
            </form>
        </section>

        <section class="py-4">
            <div class="flex flex-row items-end gap-4">
                <h2 class="text-2xl font-semibold">Địa điểm hot</h2>
                <a href="/list-all/all" class="hover:underline text-sm text-gray-600 dark:text-gray-400 cursor-pointer">Xem tất cả</a>
            </div>
            <div class="grid lg:grid-cols-4 gap-8 md:grid-cols-3 max-[730px]:grid-cols-2 max-[450px]:grid-cols-1 mt-4">

                @foreach ($entertainmentSpots as $spot)
                <a href="/detail/{{ $spot->slug }}" class="overflow-hidden group">
                    <div class="rounded-xl shadow-lg bg-white dark:bg-gray-800 hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                        <div class="relative h-64">
                            <img src="{{ $spot->banner_image }}" alt="{{ $spot->name }}" class="absolute inset-0 object-cover w-full h-full" />
                        </div>
                        <div class="px-4 py-2">
                            <h3 class="font-semibold text-xl line-clamp-1 text-ellipsis">{{ $spot->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-1 text-ellipsis">Địa điểm: {{ $spot->full_address }}</p>
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-1 text-ellipsis">Số điện thoại: {{ $spot->phone_number }}</p>
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-1 text-ellipsis">Khu vực: {{ $spot->ward->name }}</p>
                        </div>
                    </div>
                </a>
                @endforeach

            </div>
        </section>

        <section class="py-4">
            <div class="flex flex-row items-end gap-4">
                <h2 class="text-2xl font-semibold">Điểm ăn nét</h2>
                <a href="/list-all/eat" class="hover:underline text-sm text-gray-600 dark:text-gray-400 cursor-pointer">Xem tất cả</a>
            </div>
            <div class="grid lg:grid-cols-4 gap-8 md:grid-cols-3 max-[730px]:grid-cols-2 max-[450px]:grid-cols-1 mt-4">
                @foreach ($entertainmentSpots as $spot)
                @if ($spot->entertainmentType && $spot->entertainmentType->type === 'an')
                <a href="/detail/{{ $spot->slug }}" class="overflow-hidden group">
                    <div class="rounded-xl shadow-lg bg-white dark:bg-gray-800 hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                        <div class="relative h-64">
                            <img src="{{ $spot->image_url }}" alt="{{ $spot->name }}" class="absolute inset-0 object-cover w-full h-full" />
                        </div>
                        <div class="px-4 py-2">
                            <h3 class="font-semibold text-xl line-clamp-1 text-ellipsis">{{ $spot->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-1 text-ellipsis">Địa điểm: {{ $spot->address }}</p>
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-1 text-ellipsis">Số điện thoại: {{ $spot->phone }}</p>
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-1 text-ellipsis">Khu vực: {{ $spot->area }}</p>
                        </div>
                    </div>
                </a>
                @endif
                @endforeach
            </div>
        </section>

        <section class="py-4">
            <div class="flex flex-row items-end gap-4">
                <h2 class="text-2xl font-semibold">Điểm chơi nét</h2>
                <a href="/list-all/play" class="hover:underline text-sm text-gray-600 dark:text-gray-400 cursor-pointer">Xem tất cả</a>
            </div>
            <div class="grid lg:grid-cols-4 gap-8 md:grid-cols-3 max-[730px]:grid-cols-2 max-[450px]:grid-cols-1 mt-4">
                @foreach ($entertainmentSpots as $spot)
                @if ($spot->entertainmentType && $spot->entertainmentType->type === 'choi')
                <a href="/detail/{{ $spot->slug }}" class="overflow-hidden group">
                    <div class="rounded-xl shadow-lg bg-white dark:bg-gray-800 hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                        <div class="relative h-64">
                            <img src="{{ $spot->image_url }}" alt="{{ $spot->name }}" class="absolute inset-0 object-cover w-full h-full" />
                        </div>
                        <div class="px-4 py-2">
                            <h3 class="font-semibold text-xl line-clamp-1 text-ellipsis">{{ $spot->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-1 text-ellipsis">Địa điểm: {{ $spot->address }}</p>
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-1 text-ellipsis">Số điện thoại: {{ $spot->phone }}</p>
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-1 text-ellipsis">Khu vực: {{ $spot->area }}</p>
                        </div>
                    </div>
                </a>
                @endif
                @endforeach
            </div>
        </section>

    </main>

    <footer class="bg-gray-800 py-4 mt-8">
        <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
            <a href="/" class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-atom w-8 h-8 text-indigo-400">
                    <circle cx="12" cy="12" r="1"></circle>
                    <path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path>
                    <path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>
                </svg>
                <span class="text-xl font-semibold ml-2 text-white">Ăn chơi nét</span>
            </a>
            <span class="text-sm text-gray-400 sm:text-center mt-4 md:mt-0">© 2024. All Rights Reserved.</span>
        </div>
    </footer>

</body>

</html>