{{-- 1 card blog. Cần $blog (object). --}}
<a href="{{ $blog->url }}" class="group spot-card">
    <div class="relative h-44 overflow-hidden bg-gray-100 dark:bg-gray-700">
        <img src="/{{ $blog->banner_image }}" alt="{{ $blog->title }}" loading="lazy"
             class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
    </div>
    <div class="p-4">
        @if ($blog->category_name)
            <span class="text-xs font-semibold text-brand-600">{{ $blog->category_name }}</span>
        @endif
        <h3 class="mt-1 line-clamp-2 font-semibold">{{ $blog->title }}</h3>
        <p class="mt-1 text-xs text-gray-400">{{ \Illuminate\Support\Str::of($blog->created_at)->limit(10, '') }}</p>
    </div>
</a>
