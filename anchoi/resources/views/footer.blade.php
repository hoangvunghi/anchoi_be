<footer class="mt-auto border-t border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
    <div class="container mx-auto px-4 py-10">
        <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
            {{-- Thương hiệu --}}
            <div class="col-span-2 md:col-span-1">
                <a href="/" class="flex items-center gap-2 font-semibold text-brand-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7">
                        <circle cx="12" cy="12" r="1"></circle>
                        <path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path>
                        <path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>
                    </svg>
                    <span class="text-lg">Ăn chơi nét</span>
                </a>
                <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                    Nền tảng tìm kiếm địa điểm ăn uống &amp; giải trí hàng đầu Việt Nam.
                </p>
            </div>

            {{-- Loại hình --}}
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">Loại hình</h3>
                <ul class="mt-3 space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    @foreach (['/club' => 'Club', '/karaoke' => 'Karaoke', '/bar' => 'Bar', '/nha-hang' => 'Nhà hàng'] as $href => $label)
                        <li><a href="{{ $href }}" class="transition hover:text-brand-600">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Khám phá --}}
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">Khám phá</h3>
                <ul class="mt-3 space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li><a href="/all" class="transition hover:text-brand-600">Tất cả địa điểm</a></li>
                    <li><a href="/nearest" class="transition hover:text-brand-600">Gần bạn</a></li>
                    <li><a href="/blog" class="transition hover:text-brand-600">Blog</a></li>
                    <li><a href="/contact" class="transition hover:text-brand-600">Liên hệ</a></li>
                </ul>
            </div>

            {{-- Liên hệ --}}
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">Liên hệ</h3>
                <ul class="mt-3 space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>Hotline: <span class="font-medium text-gray-700 dark:text-gray-300">0971 578 680</span></li>
                    <li>Email: hoangvunghi2004@gmail.com</li>
                </ul>
            </div>
        </div>

        <div class="mt-10 border-t border-gray-200 pt-6 text-center text-sm text-gray-500 dark:border-gray-800 dark:text-gray-400">
            © {{ date('Y') }} Ăn chơi nét. All Rights Reserved.
        </div>
    </div>
</footer>
