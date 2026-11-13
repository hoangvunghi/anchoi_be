@extends('layouts.app')

@section('title', ($pageTitle ?? '404 - Không tìm thấy trang') . ' | Ăn chơi nét')
@section('description', 'Trang bạn tìm kiếm không tồn tại. Quay lại trang chủ để khám phá các địa điểm giải trí và ẩm thực.')

@section('content')
    @include('search')

    <section class="py-12 text-center">
        <h2 class="text-2xl font-bold tracking-tight">{{ $title ?? 'Nội dung' }} đang được cập nhật</h2>
        <p class="mx-auto mt-3 max-w-md text-gray-500 dark:text-gray-400">
            Vui lòng quay lại sau hoặc thử tìm kiếm các loại hình khác.
        </p>
        <a href="/" class="btn-primary mt-6">Về trang chủ</a>
    </section>
@endsection
