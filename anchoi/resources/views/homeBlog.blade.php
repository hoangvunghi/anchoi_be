@extends('layouts.app')

@section('title', 'Blog - Tin tức ăn uống và giải trí | Ăn chơi nét')
@section('description', 'Đọc các bài viết mới nhất về ăn uống, giải trí và các địa điểm hot nhất. Cẩm nang du lịch và trải nghiệm ẩm thực.')

@section('content')
    <h1 class="text-2xl font-bold tracking-tight">Blog</h1>

    <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach ($blogs as $blog)
            <a href="{{ $blog->url }}" class="group spot-card">
                <div class="relative h-44 overflow-hidden bg-gray-100 dark:bg-gray-700">
                    <img src="/{{ $blog->banner_image }}" alt="{{ $blog->title }}" loading="lazy"
                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                </div>
                <div class="p-4">
                    <h2 class="line-clamp-2 font-semibold">{{ $blog->title }}</h2>
                    <p class="mt-1 text-sm text-brand-600">{{ $blog->category_name }}</p>
                    <p class="text-xs text-gray-400">{{ \Illuminate\Support\Str::of($blog->created_at)->limit(10, '') }}</p>
                </div>
            </a>
        @endforeach
    </div>
@endsection
