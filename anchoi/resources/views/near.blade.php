@extends('layouts.app')

@section('title', $pageTitle . ' | Ăn chơi nét')
@section('description', 'Tìm kiếm ' . strtolower($pageTitle) . ' gần bạn nhất. Khám phá các địa điểm hot với đánh giá cao và dịch vụ tốt nhất.')

@push('head')
    @foreach ($entertainmentSpots as $entertainmentSpot)
        <script type="application/ld+json">@php echo json_encode($entertainmentSpot->header); @endphp</script>
    @endforeach
@endpush

@section('content')
    <nav aria-label="breadcrumb" class="mb-4 text-sm text-gray-500">
        <ol class="flex flex-wrap items-center gap-2">
            <li><a href="/" class="hover:text-brand-600">Trang chủ</a></li>
            <li aria-hidden="true">/</li>
            <li class="text-gray-700 dark:text-gray-300">{{ $pageTitle }}</li>
        </ol>
    </nav>

    <section class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-black/5 dark:bg-gray-800 dark:ring-white/10">
        <div class="flex flex-wrap items-center gap-3">
            <div class="search-select-container relative w-full sm:w-64">
                <select class="search-select" id="loai-hinh" name="loai-hinh">
                    <option value="">Chọn loại hình</option>
                </select>
                <svg class="select-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
            </div>
            <button class="btn-primary" onclick="timKiemGanDay()">Tìm gần đây</button>
        </div>
    </section>

    <section class="py-6">
        <h1 class="text-2xl font-bold tracking-tight">{{ $title }}</h1>

        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($entertainmentSpots as $spot)
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
                        <p class="line-clamp-2 text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($spot->full_address, 48) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection

@push('scripts')
<script>
    async function getDataFromLocalOrAPI(key, apiUrl, expirationHours = 24) {
        const stored = localStorage.getItem(key);
        if (stored) {
            const { data, timestamp } = JSON.parse(stored);
            if (Array.isArray(data) && data.length && Date.now() - timestamp < expirationHours * 3600 * 1000) return data;
        }
        try {
            const res = await fetch(apiUrl);
            const data = await res.json();
            if (Array.isArray(data) && data.length) localStorage.setItem(key, JSON.stringify({ data, timestamp: Date.now() }));
            return data;
        } catch (e) { return []; }
    }

    getDataFromLocalOrAPI('entertainmentTypes', '/api/v1/entertainment-types').then(data => {
        const sel = document.getElementById('loai-hinh');
        data.forEach(type => {
            const opt = document.createElement('option');
            opt.value = type.id; opt.id = type.slug; opt.textContent = type.name;
            sel.appendChild(opt);
        });
    });

    function timKiemGanDay() {
        const sel = document.getElementById('loai-hinh');
        const slug = sel.options[sel.selectedIndex].id;
        window.location.href = slug ? `/nearest/${slug}` : '/nearest';
    }
</script>
@endpush
