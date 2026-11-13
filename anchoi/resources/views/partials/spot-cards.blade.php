{{-- Lặp card, dùng cho cả lưới SSR lẫn response AJAX "tải thêm". Cần $entertainmentSpots. --}}
@foreach ($entertainmentSpots as $spot)
    @include('partials.spot-card')
@endforeach
