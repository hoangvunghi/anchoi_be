{{-- 1 card địa điểm. Cần biến $spot (object). Dùng chung SSR + AJAX. --}}
<a href="/{{ $spot->url }}" class="group spot-card">
    <div class="relative h-56 overflow-hidden bg-gray-100 dark:bg-gray-700">
        <img src="/{{ $spot->banner_image }}" alt="{{ $spot->name }}" loading="lazy"
             class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
    </div>
    <div class="p-4">
        <h3 class="line-clamp-1 text-lg font-semibold">{{ Str::limit($spot->name, 32) }}</h3>
        <p class="mt-1 line-clamp-1 text-sm text-gray-500 dark:text-gray-400">
            <span class="font-medium text-gray-600 dark:text-gray-300">Khu vực:</span> {{ $spot->ward_name }}
        </p>
        <p class="line-clamp-2 text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($spot->full_address, 48) }}</p>
        @if ($spot->phone_number)
            <p class="mt-1 line-clamp-1 text-sm text-brand-600">{{ $spot->phone_number }}</p>
        @endif
    </div>
</a>
