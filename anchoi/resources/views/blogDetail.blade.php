@extends('layouts.app')

@section('title', $blog->title . ' | Ăn chơi nét')
@section('description', Str::limit(strip_tags($blog->description ?? $blog->body), 155))

@section('content')
    <article class="mx-auto max-w-3xl">
        <header class="border-b border-gray-200 pb-4 dark:border-gray-700">
            <h1 class="text-3xl font-bold leading-tight tracking-tight">{{ $blog->title }}</h1>
            <p class="mt-2 text-sm text-gray-500">{{ $blog->created_at }}</p>
        </header>
        <div class="mt-6 space-y-4 leading-relaxed text-gray-700 dark:text-gray-200 [&_img]:rounded-lg [&_h2]:mt-6 [&_h2]:text-xl [&_h2]:font-semibold [&_a]:text-brand-600 [&_a]:underline">
            {!! $blog->body !!}
        </div>
    </article>
@endsection
