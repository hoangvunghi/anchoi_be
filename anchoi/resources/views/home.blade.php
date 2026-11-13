@extends('layouts.app')

@section('title', 'Ăn chơi nét - Tìm kiếm địa điểm giải trí, ăn uống hàng đầu Việt Nam')
@section('description', 'Khám phá các địa điểm ăn uống, club, karaoke, bar và nhà hàng tốt nhất gần bạn. Ăn chơi nét - Nền tảng tìm kiếm giải trí và ẩm thực hàng đầu.')

@push('head')
    @foreach ($entertainmentSpots as $entertainmentSpot)
        <script type="application/ld+json">@php echo json_encode($entertainmentSpot->header); @endphp</script>
    @endforeach
@endpush

@section('content')
    @include('search')

    @php
        $sections = [
            ['Địa điểm hot', '/all', $entertainmentSpots],
            ['Điểm Karaoke', '/karaoke', $entertainmentSpots_karaoke],
            ['Điểm Bar', '/bar', $entertainmentSpots_bar],
            ['Nhà hàng', '/nha-hang', $entertainmentSpots_nha_hang],
        ];
    @endphp

    @foreach ($sections as [$heading, $link, $spots])
        @continue (count($spots) === 0)
        <section class="py-6">
            <div class="flex items-end justify-between gap-4">
                <h2 class="text-2xl font-bold tracking-tight">{{ $heading }}</h2>
                <a href="{{ $link }}" class="text-sm font-medium text-brand-600 hover:underline">Xem tất cả &rarr;</a>
            </div>

            <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($spots as $spot)
                    <a href="/{{ $spot->url }}" class="group spot-card">
                        <div class="relative h-56 overflow-hidden bg-gray-100 dark:bg-gray-700">
                            <img src="/{{ $spot->banner_image }}" alt="{{ $spot->name }}" loading="lazy"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                        </div>
                        <div class="p-4">
                            <h3 class="line-clamp-1 font-semibold text-lg">{{ Str::limit($spot->name, 32) }}</h3>
                            <p class="mt-1 line-clamp-1 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Khu vực:</span> {{ $spot->ward_name }}
                            </p>
                            <p class="line-clamp-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ Str::limit($spot->full_address, 48) }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endforeach
@endsection
