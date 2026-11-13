@extends('layouts.app')

@section('title', 'Blog - Tin tức ăn uống và giải trí | Ăn chơi nét')
@section('description', 'Đọc các bài viết mới nhất về ăn uống, giải trí và các địa điểm hot nhất. Cẩm nang du lịch và trải nghiệm ẩm thực.')

@section('content')
    <div class="flex items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">Blog</h1>
            <p class="mt-1 text-gray-500 dark:text-gray-400">Cẩm nang ăn chơi, review địa điểm &amp; tin tức mới nhất.</p>
        </div>
    </div>

    @if (empty($blogs) || !count($blogs))
        <p class="mt-10 text-center text-gray-500">Chưa có bài viết nào.</p>
    @else
        @php $featured = $blogs[0]; $rest = array_slice($blogs, 1); @endphp

        {{-- Bài nổi bật --}}
        <a href="{{ $featured->url }}" class="group mt-6 grid overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 transition hover:shadow-xl dark:bg-gray-800 dark:ring-white/10 md:grid-cols-2">
            <div class="relative h-64 overflow-hidden bg-gray-100 dark:bg-gray-700 md:h-full">
                <img src="/{{ $featured->banner_image }}" alt="{{ $featured->title }}" loading="lazy"
                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                <span class="absolute left-4 top-4 rounded-full bg-brand-600 px-3 py-1 text-xs font-semibold text-white">Nổi bật</span>
            </div>
            <div class="flex flex-col justify-center p-6 md:p-8">
                @if ($featured->category_name)
                    <span class="text-sm font-semibold text-brand-600">{{ $featured->category_name }}</span>
                @endif
                <h2 class="mt-2 text-2xl font-bold leading-tight tracking-tight md:text-3xl">{{ $featured->title }}</h2>
                <p class="mt-3 text-sm text-gray-400">{{ \Illuminate\Support\Str::of($featured->created_at)->limit(10, '') }}</p>
                <span class="mt-4 inline-flex items-center gap-1 font-semibold text-brand-600">Đọc tiếp &rarr;</span>
            </div>
        </a>

        {{-- Lưới bài còn lại --}}
        @if (count($rest))
            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($rest as $blog)
                    <a href="{{ $blog->url }}" class="group spot-card">
                        <div class="relative h-44 overflow-hidden bg-gray-100 dark:bg-gray-700">
                            <img src="/{{ $blog->banner_image }}" alt="{{ $blog->title }}" loading="lazy"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                        </div>
                        <div class="p-4">
                            @if ($blog->category_name)
                                <span class="text-xs font-semibold text-brand-600">{{ $blog->category_name }}</span>
                            @endif
                            <h2 class="mt-1 line-clamp-2 font-semibold">{{ $blog->title }}</h2>
                            <p class="mt-1 text-xs text-gray-400">{{ \Illuminate\Support\Str::of($blog->created_at)->limit(10, '') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    @endif
@endsection
