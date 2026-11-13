@extends('layouts.app')

@section('title', $blog->title . ' | Ăn chơi nét')
@section('description', Str::limit(strip_tags($blog->body), 155))
@section('og_image', url('/' . $blog->banner_image))

@push('head')
    {{-- Schema BlogPosting + Breadcrumb giúp Google hiểu cấu trúc bài & hiện rich result --}}
    <script type="application/ld+json">
    @php
        echo json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $blog->title,
            'image' => [url('/' . $blog->banner_image)],
            'datePublished' => (string) $blog->created_at,
            'dateModified' => (string) ($blog->updated_at ?? $blog->created_at),
            'author' => ['@type' => 'Organization', 'name' => 'Ăn chơi nét'],
            'publisher' => ['@type' => 'Organization', 'name' => 'Ăn chơi nét'],
            'articleSection' => $blog->category_name,
            'mainEntityOfPage' => url()->current(),
        ], JSON_UNESCAPED_UNICODE);
    @endphp
    </script>
    <script type="application/ld+json">
    @php
        echo json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Trang chủ', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => url('/blog')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $blog->title],
            ],
        ], JSON_UNESCAPED_UNICODE);
    @endphp
    </script>
@endpush

@section('content')
    <article class="mx-auto max-w-3xl">
        <nav aria-label="breadcrumb" class="mb-4 text-sm text-gray-500">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="/" class="hover:text-brand-600">Trang chủ</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="/blog" class="hover:text-brand-600">Blog</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-gray-700 dark:text-gray-300">{{ Str::limit($blog->title, 40) }}</li>
            </ol>
        </nav>

        <header class="border-b border-gray-200 pb-4 dark:border-gray-700">
            @if ($blog->category_name)
                <a href="/blog" class="text-sm font-semibold text-brand-600">{{ $blog->category_name }}</a>
            @endif
            <h1 class="mt-1 text-3xl font-bold leading-tight tracking-tight">{{ $blog->title }}</h1>
            <p class="mt-2 flex flex-wrap gap-x-4 text-sm text-gray-500">
                <span>{{ \Illuminate\Support\Str::of($blog->created_at)->limit(10, '') }}</span>
                <span>{{ max(1, (int) ceil(str_word_count(strip_tags($blog->body)) / 200)) }} phút đọc</span>
            </p>
        </header>

        {{-- Mục lục (chia đoạn) — JS tự tạo từ các thẻ H2 trong bài --}}
        <nav id="toc" hidden class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800/50">
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-300">Nội dung bài viết</p>
            <ul id="toc-list" class="space-y-1 text-sm"></ul>
        </nav>

        <div id="article-body"
             class="mt-6 space-y-4 leading-relaxed text-gray-700 dark:text-gray-200 [&_img]:rounded-lg [&_h2]:mt-8 [&_h2]:scroll-mt-24 [&_h2]:text-xl [&_h2]:font-semibold [&_a]:text-brand-600 [&_a]:underline">
            {!! $blog->body !!}
        </div>

        @if (!empty($suggestedSpots) && count($suggestedSpots))
            <div class="mt-8 rounded-xl border border-brand-100 bg-brand-50/50 p-5 dark:border-gray-700 dark:bg-gray-800/40">
                <p class="font-semibold">📍 Địa điểm nổi bật</p>
                <ul class="mt-2 space-y-1.5 text-sm">
                    @foreach ($suggestedSpots as $s)
                        <li>
                            <a href="/{{ $s->url }}" class="font-medium text-brand-600 hover:underline">{{ $s->name }}</a>
                            <span class="text-gray-400">· {{ $s->type }}, {{ $s->ward }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </article>

    @if (!empty($related) && count($related))
        <section class="mx-auto mt-12 max-w-5xl border-t border-gray-200 pt-8 dark:border-gray-700">
            <h2 class="text-xl font-bold tracking-tight">Bài viết liên quan</h2>
            <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($related as $item)
                    <a href="{{ $item->url }}" class="group spot-card">
                        <div class="relative h-40 overflow-hidden bg-gray-100 dark:bg-gray-700">
                            <img src="/{{ $item->banner_image }}" alt="{{ $item->title }}" loading="lazy"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                        </div>
                        <div class="p-4">
                            <h3 class="line-clamp-2 font-semibold">{{ $item->title }}</h3>
                            <p class="mt-1 text-xs text-brand-600">{{ $item->category_name }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection

@push('scripts')
<script>
    // Tự tạo mục lục từ H2: gắn id + anchor, cuộn mượt
    document.addEventListener('DOMContentLoaded', () => {
        const body = document.getElementById('article-body');
        const toc = document.getElementById('toc');
        const list = document.getElementById('toc-list');
        if (!body || !toc || !list) return;
        const heads = body.querySelectorAll('h2');
        if (heads.length < 2) return; // ít hơn 2 mục thì không cần mục lục

        heads.forEach((h, i) => {
            const id = 'muc-' + (i + 1);
            h.id = id;
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = '#' + id;
            a.textContent = h.textContent;
            a.className = 'text-brand-600 hover:underline';
            li.appendChild(a);
            list.appendChild(li);
        });
        toc.hidden = false;
    });
</script>
@endpush
