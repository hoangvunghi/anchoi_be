@extends('layouts.app')

@section('title', $entertainmentSpot->name . ' - ' . $titlePage . ' | Ăn chơi nét')
@section('description', Str::limit(strip_tags($entertainmentSpot->description), 155))
@section('og_image', url('/' . $entertainmentSpot->banner_image))

@push('head')
    <script type="application/ld+json">@php echo json_encode($entertainmentSpot->header); @endphp</script>
@endpush

@section('content')
  @php
    $hasCoords = (float) $entertainmentSpot->latitude != 0 && (float) $entertainmentSpot->longitude != 0;
    $destination = $hasCoords
      ? $entertainmentSpot->latitude . ',' . $entertainmentSpot->longitude
      : trim(($entertainmentSpot->full_address ?? '') . ', ' . ($entertainmentSpot->ward_name ?? '') . ', ' . ($entertainmentSpot->province_name ?? ''), ', ');
    $directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($destination);
  @endphp

  <div class="flex flex-col gap-6 md:flex-row">
    <div class="w-full md:w-9/12">
      <div class="space-y-3">
        <nav aria-label="breadcrumb" class="text-sm text-gray-500">
          <ol class="flex flex-wrap items-center gap-2">
            <li><a class="hover:text-brand-600" href="/">Trang chủ</a></li>
            <li aria-hidden="true">/</li>
            <li class="text-gray-700 dark:text-gray-300">{{ $titlePage }}</li>
          </ol>
        </nav>

        <h1 class="text-2xl font-bold tracking-tight">{{ $titlePage }}</h1>

        <div class="flex flex-row flex-wrap gap-8 border-y border-gray-200 py-4 font-semibold dark:border-gray-700">
          <div class="flex flex-col gap-2">
            <span class="text-gray-500">Số điện thoại</span>
            <span>{{ $entertainmentSpot->phone_number }}</span>
          </div>
          <div class="flex flex-col gap-2">
            <span class="text-gray-500">Địa điểm</span>
            <div class="inline-block">
              <a class="hover:text-brand-600 hover:underline" href="/{{ $entertainmentSpot->url_xa }}">{{ $entertainmentSpot->ward_name }}</a>,
              <a class="hover:text-brand-600 hover:underline" href="/{{ $entertainmentSpot->url_tinh }}">{{ $entertainmentSpot->province_name }}</a>
            </div>
          </div>
          <div class="flex flex-col gap-2">
            <span class="text-gray-500">Loại hình</span>
            <a class="hover:text-brand-600 hover:underline" href="/nearest/{{ $entertainmentSpot->entertainment_type_slug }}">{{ $entertainmentSpot->entertainment_type_name }}</a>
          </div>
        </div>

        <img src="/{{ $entertainmentSpot->banner_image }}" alt="{{ $entertainmentSpot->name }}" class="h-64 w-full rounded-xl object-cover" />

        <div class="mt-4 border-t border-gray-200 py-3 dark:border-gray-700">
          <h2 class="mb-2 text-lg font-semibold">Thông tin chi tiết</h2>
          <div class="leading-relaxed text-gray-700 dark:text-gray-200">{!! $entertainmentSpot->description !!}</div>
          <p class="mt-2 font-semibold">Địa chỉ: {{ $entertainmentSpot->full_address }}</p>
        </div>

        <div class="border-t border-gray-200 py-4 dark:border-gray-700">
          <h2 class="mb-2 text-lg font-semibold">Thông tin liên hệ</h2>
          <div class="flex flex-row flex-wrap gap-8">
            <div class="flex flex-col gap-2">
              <span class="text-gray-500">Họ tên</span>
              <span class="font-semibold">{{ $entertainmentSpot->name_of_owner }}</span>
            </div>
            <div class="flex flex-col gap-2">
              <span class="text-gray-500">Số điện thoại</span>
              <span class="font-semibold">{{ $entertainmentSpot->phone_number }}</span>
            </div>
          </div>
        </div>

        @if ((float) $entertainmentSpot->latitude != 0 && (float) $entertainmentSpot->longitude != 0)
        <div class="border-t border-gray-200 py-4 dark:border-gray-700">
          <h2 class="mb-2 text-lg font-semibold">Bản đồ</h2>
          <iframe class="h-72 w-full rounded-xl ring-1 ring-black/5" loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade" title="Bản đồ {{ $entertainmentSpot->name }}"
                  src="https://maps.google.com/maps?q={{ $entertainmentSpot->latitude }},{{ $entertainmentSpot->longitude }}({{ urlencode($entertainmentSpot->name) }})&z=16&output=embed"></iframe>
          <div class="mt-3 flex flex-wrap gap-4 text-sm font-medium">
            {{-- Link của mình: search?query=toạ-độ -> mở Google Maps CÓ pin đỏ đúng điểm --}}
            <a href="https://www.google.com/maps/search/?api=1&query={{ $entertainmentSpot->latitude }},{{ $entertainmentSpot->longitude }}"
               target="_blank" rel="noopener" class="text-brand-600 hover:underline">📍 Mở trên Google Maps</a>
            <a href="{{ $directionsUrl }}" target="_blank" rel="noopener" class="text-brand-600 hover:underline">🧭 Chỉ đường</a>
          </div>
        </div>
        @endif

        <div class="mt-4 border-t border-gray-200 py-3 dark:border-gray-700">
          <h2 class="mb-2 text-lg font-semibold">Địa điểm liên quan</h2>
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($realtedEntertainmentSpots as $relatedSpot)
              <a class="group spot-card" href="/{{ $relatedSpot->url }}">
                <div class="relative h-48 overflow-hidden bg-gray-100 dark:bg-gray-700">
                  <img src="/{{ $relatedSpot->banner_image }}" alt="{{ $relatedSpot->name }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                </div>
                <div class="p-4">
                  <h3 class="line-clamp-1 font-semibold">{{ Str::limit($relatedSpot->name, 20) }}</h3>
                  <p class="line-clamp-1 text-sm text-gray-500">Khu vực: {{ $relatedSpot->ward_name }}</p>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    {{-- Sidebar liên hệ (card tối) --}}
    <aside class="w-full md:w-3/12">
      <div class="rounded-xl border border-gray-700 bg-gradient-to-br from-gray-800 to-gray-900 p-6 shadow-2xl md:sticky md:top-24">
        <div class="mb-6 text-center">
          <h3 class="mb-2 text-xl font-bold text-white">{{ $entertainmentSpot->name }}</h3>
          @if($entertainmentSpot->average_rating > 0)
            <div class="mb-2 flex items-center justify-center gap-1">
              @for ($i = 1; $i <= 5; $i++)
                <svg class="h-4 w-4 fill-current {{ $i <= $entertainmentSpot->average_rating ? 'text-yellow-400' : 'text-gray-500' }}" viewBox="0 0 20 20">
                  <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                </svg>
              @endfor
              <span class="ml-2 text-sm text-gray-300">({{ $entertainmentSpot->average_rating }}/5)</span>
            </div>
          @endif
        </div>

        <a href="tel:{{ $entertainmentSpot->phone_number }}" class="mb-4 block w-full rounded-lg bg-gradient-to-r from-red-500 to-red-600 px-4 py-3 text-center font-bold text-white shadow-lg transition hover:from-red-600 hover:to-red-700">
          📞 {{ $entertainmentSpot->phone_number }}
        </a>

        @php
          $additionalInfo = json_decode($entertainmentSpot->additional_info, true);
          $openingHours = $additionalInfo['opening_hours'] ?? [];
          $hasCoords = (float) $entertainmentSpot->latitude != 0 && (float) $entertainmentSpot->longitude != 0;
          $destination = $hasCoords
            ? $entertainmentSpot->latitude . ',' . $entertainmentSpot->longitude
            : trim(($entertainmentSpot->full_address ?? '') . ', ' . ($entertainmentSpot->ward_name ?? '') . ', ' . ($entertainmentSpot->province_name ?? ''), ', ');
          $directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($destination);
        @endphp

        <a href="{{ $directionsUrl }}" target="_blank" rel="noopener"
           class="mb-4 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-500">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
          </svg>
          Chỉ đường
        </a>

        @if(!empty($openingHours['weekday_descriptions']))
          <div class="border-t border-gray-700 pt-4 text-xs text-gray-300">
            <h4 class="mb-2 text-sm font-semibold text-white">Giờ hoạt động</h4>
            @foreach(array_slice($openingHours['weekday_descriptions'], 0, 3) as $day)
              <p>{{ $day }}</p>
            @endforeach
          </div>
        @endif

        @if(!empty($additionalInfo['website']) || !empty($additionalInfo['google_maps_uri']))
          <div class="mt-4 space-y-2 border-t border-gray-700 pt-4 text-xs">
            @if(!empty($additionalInfo['website']))
              <a href="{{ $additionalInfo['website'] }}" target="_blank" rel="noopener" class="block truncate text-blue-400 hover:text-blue-300">🌐 Website</a>
            @endif
            @if(!empty($additionalInfo['google_maps_uri']))
              <a href="{{ $additionalInfo['google_maps_uri'] }}" target="_blank" rel="noopener" class="block truncate text-blue-400 hover:text-blue-300">📍 Xem trên Google Maps</a>
            @endif
          </div>
        @endif
      </div>
    </aside>
  </div>

  {{-- Đánh giá & bình luận --}}
  <section class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-700 md:w-9/12">
    <h2 class="mb-2 text-lg font-semibold">Đánh giá &amp; bình luận</h2>
    <div class="mb-4 flex items-center gap-2">
      Số sao trung bình:
      <span class="flex items-center gap-1 font-semibold text-yellow-500">
        {{ $entertainmentSpot->average_rating }}
        @for ($i = 0; $i < 5; $i++)
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4 {{ $i < $entertainmentSpot->average_rating ? 'fill-yellow-400 stroke-yellow-400' : 'fill-none stroke-gray-400' }}" stroke-width="2">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
          </svg>
        @endfor
      </span>
    </div>

    <div id="comment-container" class="max-h-[500px] divide-y overflow-y-auto"></div>

    <div class="mt-2 rounded-xl border border-gray-200 p-4 dark:border-gray-700">
      <form id="comment-form" class="space-y-3">
        @csrf
        <input type="hidden" name="entertainment_spot_id" value="{{ $entertainmentSpot->id }}">
        <input type="hidden" name="parent_id" value="">
        <div class="space-y-1">
          <label class="text-sm font-medium" for="name">Tên</label>
          <input class="search-select" placeholder="Tên của bạn" id="name" name="name" required />
        </div>
        <div class="space-y-1">
          <label class="text-sm font-medium" for="email">Email</label>
          <input type="email" class="search-select" placeholder="Email..." id="email" name="email" required />
        </div>
        <div class="space-y-1">
          <label class="text-sm font-medium" for="body">Nội dung</label>
          <textarea class="search-select min-h-[80px]" placeholder="Viết đánh giá..." name="body" id="body" required></textarea>
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium">Đánh giá</label>
          <div class="flex flex-row flex-wrap gap-6">
            @for ($i = 1; $i <= 5; $i++)
              <label class="flex items-center gap-2 text-sm">
                <input type="radio" name="number_of_star" value="{{ $i }}" class="h-5 w-5" @if ($i==5) checked @endif required>
                {{ $i }} sao
              </label>
            @endfor
          </div>
        </div>
        <button class="btn-primary" type="submit">Gửi đánh giá</button>
      </form>
    </div>
  </section>
@endsection

@push('scripts')
<script>
    function displayStars(rating) {
        let html = '';
        for (let i = 1; i <= 5; i++) {
            const cls = i <= rating ? 'fill-yellow-400 stroke-yellow-400' : 'fill-none stroke-gray-400';
            html += `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4 ${cls}" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>`;
        }
        return html;
    }

    function displayComments(comments) {
        const container = document.getElementById('comment-container');
        container.innerHTML = '';
        comments.forEach(comment => {
            const el = document.createElement('div');
            el.classList.add('comment', 'py-4', 'relative');
            el.innerHTML = `
                <div class="flex flex-row items-start gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 text-lg font-semibold">${comment.name.charAt(0)}</div>
                    <div class="flex-1">
                        <div class="flex items-center gap-4">
                            <p class="font-semibold">${comment.name}</p>
                            <div class="flex items-center gap-1 font-semibold text-yellow-500">${displayStars(comment.number_of_star)} (${comment.number_of_star})</div>
                        </div>
                        <p class="text-sm text-gray-500">${comment.email}</p>
                        <p class="mt-2">${comment.body}</p>
                        <button class="reply-button mt-2 text-brand-600 hover:underline" data-comment-id="${comment.id}" data-comment-name="${comment.name}">Trả lời</button>
                    </div>
                </div>`;
            if (comment.replies && comment.replies.length) {
                const wrap = document.createElement('div');
                wrap.classList.add('ml-16', 'mt-4');
                comment.replies.forEach(reply => {
                    const r = document.createElement('div');
                    r.classList.add('py-2');
                    r.innerHTML = `
                        <div class="flex flex-row items-start gap-4">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 font-semibold">${reply.name.charAt(0)}</div>
                            <div class="flex-1">
                                <p class="font-semibold">${reply.name}</p>
                                <p class="text-sm text-gray-500">${reply.email}</p>
                                <p class="mt-1">${reply.body}</p>
                            </div>
                        </div>`;
                    wrap.appendChild(r);
                });
                el.appendChild(wrap);
            }
            container.appendChild(el);
            el.querySelector('.reply-button').addEventListener('click', handleReplyClick);
        });
    }

    function handleReplyClick(event) {
        const commentId = event.target.dataset.commentId;
        const commentName = event.target.dataset.commentName;
        const parent = event.target.closest('.comment');
        const existing = parent.querySelector('.reply-form');
        if (existing) { existing.remove(); return; }

        const form = document.createElement('form');
        form.className = 'reply-form mt-4 ml-16 space-y-2';
        form.innerHTML = `
            @csrf
            <input type="hidden" name="entertainment_spot_id" value="{{ $entertainmentSpot->id }}">
            <input type="hidden" name="parent_id" value="${commentId}">
            <input class="search-select" placeholder="Tên" name="name" required />
            <input type="email" class="search-select" placeholder="Email" name="email" required />
            <textarea class="search-select min-h-[60px]" placeholder="Trả lời..." name="body" required></textarea>
            <button class="btn-primary" type="submit">Trả lời ${commentName}</button>`;
        parent.appendChild(form);
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            fetch('/api/comments', { method: 'POST', body: new FormData(form) })
                .then(r => r.json())
                .then(() => loadComments());
        });
    }

    function loadComments() {
        fetch('/api/comments/{{ $entertainmentSpot->id }}')
            .then(r => r.json())
            .then(displayComments);
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadComments();
        const commentForm = document.getElementById('comment-form');
        commentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            fetch('/api/comments', { method: 'POST', body: new FormData(commentForm) })
                .then(r => r.json())
                .then(() => { loadComments(); commentForm.reset(); });
        });
    });
</script>
@endpush
