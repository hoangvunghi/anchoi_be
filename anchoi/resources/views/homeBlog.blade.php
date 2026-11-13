@extends('layouts.app')

@section('title', 'Blog - Tin tức ăn uống và giải trí | Ăn chơi nét')
@section('description', 'Đọc các bài viết mới nhất về ăn uống, giải trí và các địa điểm hot nhất. Cẩm nang du lịch và trải nghiệm ẩm thực.')

@section('content')
    <div>
        <h1 class="text-3xl font-extrabold tracking-tight">Blog</h1>
        <p class="mt-1 text-gray-500 dark:text-gray-400">Cẩm nang ăn chơi, review địa điểm &amp; tin tức mới nhất.</p>
    </div>

    @if (empty($blogs) || !count($blogs))
        <p class="mt-10 text-center text-gray-500">Chưa có bài viết nào.</p>
    @else
        @php
            $all = collect($blogs);
            $featured = $all->get(0);
            $heroSide = $all->slice(1, 2);   // 2 bài cạnh hero
            $row = $all->slice(3, 3);        // hàng 3 card
            $list = $all->slice(6, 4);       // danh sách ngang
            $more = $all->slice(10);         // lưới còn lại
        @endphp

        {{-- BLOCK 1: Hero lớn + 2 bài dọc bên cạnh --}}
        <div class="mt-6 grid gap-6 lg:grid-cols-3">
            <a href="{{ $featured->url }}" class="group relative overflow-hidden rounded-2xl lg:col-span-2 lg:row-span-2">
                <div class="relative h-72 w-full overflow-hidden bg-gray-100 dark:bg-gray-700 lg:h-full">
                    <img src="/{{ $featured->banner_image }}" alt="{{ $featured->title }}" loading="lazy"
                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                </div>
                <div class="absolute bottom-0 left-0 p-6 text-white">
                    <span class="rounded-full bg-brand-600 px-3 py-1 text-xs font-semibold">Nổi bật</span>
                    <h2 class="mt-3 text-2xl font-bold leading-tight md:text-3xl">{{ $featured->title }}</h2>
                    <p class="mt-2 text-sm text-white/80">{{ $featured->category_name }} · {{ \Illuminate\Support\Str::of($featured->created_at)->limit(10, '') }}</p>
                </div>
            </a>

            @foreach ($heroSide as $blog)
                @include('partials.blog-card')
            @endforeach
        </div>

        {{-- BLOCK 2: hàng 3 card đều --}}
        @if ($row->count())
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($row as $blog)
                    @include('partials.blog-card')
                @endforeach
            </div>
        @endif

        {{-- BLOCK 3: danh sách ngang (ảnh trái, chữ phải) --}}
        @if ($list->count())
            <section class="mt-12">
                <h2 class="text-xl font-bold tracking-tight">Mới cập nhật</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    @foreach ($list as $blog)
                        <a href="{{ $blog->url }}" class="group flex gap-4 overflow-hidden rounded-xl bg-white p-3 shadow-sm ring-1 ring-black/5 transition hover:shadow-md dark:bg-gray-800 dark:ring-white/10">
                            <div class="h-24 w-32 shrink-0 overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-700">
                                <img src="/{{ $blog->banner_image }}" alt="{{ $blog->title }}" loading="lazy"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-xs font-semibold text-brand-600">{{ $blog->category_name }}</span>
                                <h3 class="mt-0.5 line-clamp-2 font-semibold">{{ $blog->title }}</h3>
                                <p class="mt-1 text-xs text-gray-400">{{ \Illuminate\Support\Str::of($blog->created_at)->limit(10, '') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- BLOCK 4: lưới 4 cột còn lại --}}
        @if ($more->count())
            <section class="mt-12">
                <h2 class="text-xl font-bold tracking-tight">Tất cả bài viết</h2>
                <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($more as $blog)
                        @include('partials.blog-card')
                    @endforeach
                </div>
            </section>
        @endif
    @endif
@endsection
