@extends('layouts.app')

@section('title', ($pageTitle ?? '404 - Không tìm thấy trang') . ' | Ăn chơi nét')
@section('description', 'Trang bạn tìm kiếm không tồn tại. Quay lại trang chủ để khám phá các địa điểm giải trí và ẩm thực.')

@section('content')
    @include('search')

    <section class="py-12 text-center">
        <h2 class="text-2xl font-bold tracking-tight">{{ $title ?? 'Nội dung' }} đang được cập nhật</h2>
        <p class="mx-auto mt-3 max-w-md text-gray-500 dark:text-gray-400">
            Vui lòng quay lại sau hoặc khám phá các loại hình nổi bật bên dưới.
        </p>

        <div class="mt-6 flex flex-wrap justify-center gap-2">
            @foreach (['/all' => 'Tất cả', '/club' => 'Club', '/karaoke' => 'Karaoke', '/bar' => 'Bar', '/nha-hang' => 'Nhà hàng', '/nearest' => 'Gần bạn'] as $href => $label)
                <a href="{{ $href }}" class="rounded-full border border-brand-100 bg-white px-4 py-2 text-sm font-medium text-brand-600 transition hover:bg-brand-50 dark:border-gray-700 dark:bg-gray-800">{{ $label }}</a>
            @endforeach
        </div>

        <a href="/" class="btn-primary mt-8">Về trang chủ</a>
    </section>
@endsection
