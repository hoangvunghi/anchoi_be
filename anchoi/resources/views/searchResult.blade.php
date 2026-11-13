@extends('layouts.app')

@section('title', $pageTitle . ' | Ăn chơi nét')
@section('description', 'Kết quả tìm kiếm cho ' . strtolower($pageTitle) . '. Khám phá các địa điểm giải trí và ẩm thực phù hợp với bạn.')

@push('head')
    @foreach ($entertainmentSpots as $entertainmentSpot)
        <script type="application/ld+json">@php echo json_encode($entertainmentSpot->header); @endphp</script>
    @endforeach
@endpush

@section('content')
    @include('search')

    <section class="py-6">
        <h2 class="text-2xl font-bold tracking-tight">{{ $title }}</h2>
        @if (!empty($intro))
            <p class="mt-2 max-w-3xl text-gray-500 dark:text-gray-400">{{ $intro }}</p>
        @endif

        <div id="spot-grid" data-next="{{ $nextPageUrl ?? '' }}"
             class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @include('partials.spot-cards')
        </div>

        {{-- Cuộn vô tận tự nạp qua #spot-grid[data-next]; nút dự phòng nếu JS tắt/không cuộn --}}
        @if (!empty($nextPagePlain))
            <div class="mt-8 text-center">
                <a href="{{ $nextPagePlain }}" id="load-more" class="btn-ghost">Tải thêm</a>
            </div>
        @endif
    </section>
@endsection
