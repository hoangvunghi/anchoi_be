<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ăn chơi nét</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgY2xhc3M9InctOCBoLTgiPjxjaXJjbGUgY3g9IjEyIiBjeT0iMTIiIHI9IjEiPjwvY2lyY2xlPjxwYXRoIGQ9Ik0yMC4yIDIwLjJjMi4wNC0yLjAzLjAyLTcuMzYtNC41LTExLjktNC41NC00LjUyLTkuODctNi41NC0xMS45LTQuNS0yLjA0IDIuMDMtLjAyIDcuMzYgNC41IDExLjkgNC41NCA0LjUyIDkuODcgNi41NCAxMS45IDQuNVoiPjwvcGF0aD48cGF0aCBkPSJNMTUuNyAxNS43YzQuNTItNC41NCA2LjU0LTkuODcgNC41LTExLjktMi4wMy0yLjA0LTcuMzYtLjAyLTExLjkgNC41LTQuNTIgNC41NC02LjU0IDkuODctNC41IDExLjkgMi4wMyAyLjA0IDcuMzYgLjAyIDExLjktNC41WiI+PC9wYXRoPjwvc3ZnPg==" type="image/svg+xml"> 

  <script type="application/ld+json">
    @php
    echo json_encode($entertainmentSpot->header);
    @endphp
  </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

  <header class="bg-white dark:bg-gray-800 py-4 shadow-md">
    <div class="container mx-auto px-4 flex justify-between items-center">
    <a href="/" class="logo cursor-pointer flex items-center flex-row gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                            <circle cx="12" cy="12" r="1"></circle>
                            <path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path>
                            <path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>
                        </svg>
                        <p class="text-xl font-semibold">Ăn chơi nét</p>
                    </a>

      <nav class="hidden md:flex space-x-6">
        <a href="/" class="text-gray-800 dark:text-white hover:underline">Trang chủ</a>
        <a href="/nearest/club" class="text-gray-800 dark:text-white hover:underline">Điểm Club gần</a>
        <a href="/nearest/karaoke" class="text-gray-800 dark:text-white hover:underline">Điểm Karaoke gần</a>
        <a href="/nearest/bar" class="text-gray-800 dark:text-white hover:underline">Điểm Bar gần</a>
        <a href="/nearest/nha-hang" class="text-gray-800 dark:text-white hover:underline">Điểm Nhà hàng gần</a>
        <a href="/blog" class="text-gray-800 dark:text-white hover:underline">Blog</a>
        <a href="/contact" class="text-gray-800 dark:text-white hover:underline">Liên hệ</a>
      </nav>

      <button class="md:hidden" aria-label="Toggle Navigation">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu w-6 h-6 text-gray-800 dark:text-white">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </button>
    </div>
  </header>
  <div class="py-4 space-y-3">
    <nav aria-label="breadcrumb">
      <ol class="flex flex-wrap items-center gap-1.5 break-words text-sm text-muted-foreground sm:gap-2.5">
        <li class="inline-flex items-center gap-1.5">
          <a class="transition-colors hover:text-foreground" href="/">Trang chủ</a>
        </li>
        <li role="presentation" aria-hidden="true" class="[&>svg]:size-3.5">
          <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.1584 3.13508C6.35985 2.94621 6.67627 2.95642 6.86514 3.15788L10.6151 7.15788C10.7954 7.3502 10.7954 7.64949 10.6151 7.84182L6.86514 11.8418C6.67627 12.0433 6.35985 12.0535 6.1584 11.8646C5.95694 11.6757 5.94673 11.3593 6.1356 11.1579L9.565 7.49985L6.1356 3.84182C5.94673 3.64036 5.95694 3.32394 6.1584 3.13508Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
          </svg>
        </li>
        <li class="inline-flex items-center gap-1.5">
          <span role="link" aria-disabled="true" aria-current="page" class="font-normal text-foreground">{{$titlePage}}</span>
        </li>
      </ol>
    </nav>
    <div class="flex flex-row items-end gap-4">
      <p class="text-2xl font-semibold">{{$titlePage}}</p>
    </div>
    <div class="py-4 font-semibold border-y flex flex-row gap-8">
      <div class="flex flex-col gap-2">
        <span>Số điện thoại</span>
        <span>{{$entertainmentSpot->phone_number}}</span>
      </div>
      <div class="flex flex-col gap-2">
        <span>Địa điểm</span>
        <div class="inline-block">
          <a class="hover:underline" href="/{{$entertainmentSpot->url_xa}}">{{$entertainmentSpot->ward_name}}</a>,
          <a class="hover:underline" href="/{{$entertainmentSpot->url_huyen}}">{{$entertainmentSpot->district_name}}</a>,
          <a class="hover:underline" href="/{{$entertainmentSpot->url_tinh}}">{{$entertainmentSpot->province_name}}</a>
        </div>
      </div>
      <div class="flex flex-col gap-2">
        <span>Loại hình</span>
        <a class="hover:underline" href="/nearest/{{$entertainmentSpot->entertainment_type_slug}}">{{$entertainmentSpot->entertainment_type_name}}</a>
      </div>
    </div>
  </div>

  <img src="/{{$entertainmentSpot->banner_image}}" alt="Product Image" class="w-full group-hover:scale-[1.05] transition-all duration-500  h-64 object-cover" />

  <div class="py-3 border-t mt-4">
    <p class="text-lg font-semibold mb-2">Thông tin chi tiết</p>
    <div>
      {!!$entertainmentSpot->description!!}
    </div>
    <p class="font-semibold">Địa chỉ: {{$entertainmentSpot->full_address}}</p>
  </div>

  <div class="border-t py-4">
    <p class="text-lg font-semibold mb-2">Thông tin liên hệ</p>
    <div class="flex flex-row gap-8">
      <div class="flex flex-col gap-2">
        <span>Họ tên</span>
        <span class="font-semibold">{{$entertainmentSpot->name_of_owner}}</span>
      </div>
      <div class="flex flex-col gap-2">
        <span>Số điện thoại</span>
        <span class="font-semibold">{{$entertainmentSpot->phone_number}}</span>
      </div>
    </div>
  </div>

  <div class="py-3 border-t mt-4">
    <p class="text-lg font-semibold mb-2">Địa điểm liên quan</p>
    <div class="grid lg:grid-cols-4 gap-8 md:grid-cols-3 max-[730px]:grid-cols-2 max-[450px]:grid-cols-1">
      @foreach ($realtedEntertainmentSpots as $relatedSpot)
      <a class="overflow-hidden group cursor-pointer" href="/{{$relatedSpot->url}}">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
          <div class="w-full h-64 relative">
            <img src="/{{ $relatedSpot->banner_image }}" alt="{{ $relatedSpot->name }}" class="absolute inset-0 object-cover w-full h-full" />
          </div>
          <div class="px-4 py-2 space-y-1">
            <p class="font-semibold line-clamp-1 text-ellipsis text-xl">{{$relatedSpot->name}}</p>
            <p class="text-muted-foreground line-clamp-1 text-ellipsis text-sm">Địa điểm: {{$relatedSpot->full_address}}</p>
            <p class="text-muted-foreground line-clamp-1 text-ellipsis text-sm">Số điện thoại: {{$relatedSpot->phone_number}}</p>
            <p class="text-muted-foreground line-clamp-1 text-ellipsis text-sm">Khu vực: {{$relatedSpot->ward_name}}</p>
          </div>
        </div>
      </a>
      @endforeach

    </div>
  </div>

  <div class="py-3 border-t mt-4">
  <p class="text-lg font-semibold mb-2">Đánh giá & bình luận</p>
  <div class="flex flex-row items-center gap-2">
    Số sao trung bình:
    <div class="flex flex-row font-semibold items-center gap-1 text-yellow-500">
      {{ $entertainmentSpot->average_rating }}
      @for ($i = 0; $i < 5; $i++)
        @if ($i < $entertainmentSpot->average_rating)
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-4 h-4 fill-yellow-400 stroke-yellow-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        @else
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-4 h-4 stroke-gray-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        @endif
      @endfor
    </div>
  </div>
  <div>
    <div id="comment-container" class="max-h-[500px] overflow-y-auto relative divide-y scroll-custom">
      <!-- Comment sẽ được hiển thị ở đây -->
    </div>

    <div class="border mt-2 rounded-md p-4">
      <form id="comment-form" class="space-y-2">
        @csrf
        <input type="hidden" name="entertainment_spot_id" value="{{ $entertainmentSpot->id }}">
        <input type="hidden" name="parent_id" value="">
        <div class="space-y-1">
          <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="name">Name</label>
          <input class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" placeholder="Name/Unit" id="name" aria-describedby="name-description" aria-invalid="false" name="name" value="" required/>
        </div>
        <div class="space-y-1">
          <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">Email</label>
          <input type="email" class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" placeholder="Email..." id="email" aria-describedby="email-description" aria-invalid="false" name="email" value="" required/>
        </div>
        <div class="space-y-1">
          <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="body">Message</label>
          <textarea class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" placeholder="Message..." name="body" id="body" aria-describedby="body-description" aria-invalid="false" required></textarea>
        </div>
        <div class="space-y-2">
  <label class="text-sm font-medium leading-none" for="number_of_star">Rating</label>
  <div role="radiogroup" aria-required="false" dir="ltr" class="flex flex-row gap-8 flex-wrap" id="number_of_star" aria-describedby="number_of_star-description" aria-invalid="false" tabindex="-1" style="outline:none">
    @for ($i = 1; $i <= 5; $i++)
    <div class="flex flex-row items-center gap-2">
      <input type="radio" id="star-{{$i}}" name="number_of_star" value="{{$i}}" class="cursor-pointer aspect-square h-6 w-6 rounded-full border border-gray-300 focus:ring-2 focus:ring-blue-500" @if ($i == 5) checked @endif required>
      <label class="text-sm font-medium leading-none" for="star-{{$i}}">{{$i}} Star</label>
    </div>
    @endfor
  </div>
</div>
<button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 bg-black text-white shadow hover:bg-gray-800 h-9 px-4 py-2 mt-2" type="submit">Submit</button>
      </form>
    </div>
  </div>
</div>

<script>
        function requestLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // Gửi dữ liệu vị trí lên server (AJAX)
            fetch('/save-location', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({
                latitude,
                longitude
              })
            })
            .then(response => response.json())
            .then(data => {
              console.log("Vị trí đã được lưu vào session.");
              // Chuyển hướng đến trang phù hợp (nếu cần)
            })
            .catch(error => {
              console.error("Lỗi khi lưu vị trí vào session:", error);
              alert("Có lỗi xảy ra khi lưu vị trí. Vui lòng thử lại sau.");
            });
          },
          (error) => {
            console.error('Lỗi khi lấy vị trí:', error);
            alert('Vui lòng cho phép truy cập vị trí của bạn.');
          }
        );
      } else {
        alert('Trình duyệt của bạn không hỗ trợ Geolocation.');
      }
    }

    // Gọi hàm requestLocation khi trang được tải
    window.addEventListener('load', requestLocation);
  // Function để hiển thị comment
  function displayComments(comments) {
    const commentContainer = document.getElementById('comment-container');
    commentContainer.innerHTML = ''; // Xóa comment cũ trước khi hiển thị

    comments.forEach(comment => {
      // Tạo HTML cho comment cha
      const commentElement = document.createElement('div');
      commentElement.classList.add('comment', 'py-4', 'relative');
      commentElement.innerHTML = `
  <div class="flex flex-row items-start gap-4">
    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-lg font-semibold">${comment.name.charAt(0)}</div>
    <div class="flex-1">
      <div class="flex items-start gap-4"> <div>
          <div class="flex items-center gap-4">
            <p class="font-semibold">${comment.name}</p>
            <div class="flex flex-row font-semibold items-center gap-1 text-yellow-500">
              ${displayStars(comment.number_of_star)}
              (${comment.number_of_star})
            </div>
          </div>
          <p class="text-sm text-gray-500">${comment.email}</p>
        </div>
      </div>
      <p class="mt-2">${comment.body}</p>
      <button class="reply-button text-blue-500 hover:underline mt-2" data-comment-id="${comment.id}" data-comment-name="${comment.name}">Trả lời</button>
    </div>
  </div>
`;

      // Hiển thị comment con (nếu có)
      if (comment.replies && comment.replies.length > 0) {
        const repliesElement = document.createElement('div');
        repliesElement.classList.add('replies', 'ml-16', 'mt-4');
        comment.replies.forEach(reply => {
          const replyElement = document.createElement('div');
          replyElement.classList.add('reply', 'py-2', 'relative');
          replyElement.innerHTML = `
            <div class="flex flex-row items-start gap-4">
              <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-lg font-semibold">${reply.name.charAt(0)}</div>
              <div class="flex-1">
                <div>
                  <p class="font-semibold">${reply.name}</p>
                  <p class="text-sm text-gray-500">${reply.email}</p>
                </div>
                <p class="mt-1">${reply.body}</p>
              </div>
            </div>
          `;
          repliesElement.appendChild(replyElement);
        });
        commentElement.appendChild(repliesElement);
      }

      commentContainer.appendChild(commentElement);

      // Thêm event listener cho nút "Trả lời" sau khi comment được thêm vào DOM
      const replyButton = commentElement.querySelector('.reply-button');
      replyButton.addEventListener('click', (event) => {
        handleReplyClick(event);
      });
    });
  }

  // Function để hiển thị sao
  function displayStars(rating) {
    let starsHTML = '';
    for (let i = 1; i <= 5; i++) {
      if (i <= rating) {
        starsHTML += `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-4 h-4 fill-yellow-400 stroke-yellow-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>`;
      } else {
        starsHTML += `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-4 h-4 stroke-gray-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>`;
      }
    }
    return starsHTML;
  }

  // Xử lý click nút "Trả lời"
  function handleReplyClick(event) {
    const commentId = event.target.dataset.commentId;
    const commentName = event.target.dataset.commentName;

    const replyForm = `
      <form class="reply-form space-y-2 mt-4 ml-16" data-comment-id="${commentId}">
        @csrf
        <input type="hidden" name="entertainment_spot_id" value="{{ $entertainmentSpot->id }}">
        <input type="hidden" name="parent_id" value="${commentId}">
        <div class="space-y-1">
          <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="name">Name</label>
          <input class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" placeholder="Name/Unit" id="name" aria-describedby="name-description" aria-invalid="false" name="name" value="" required/>
        </div>
        <div class="space-y-1">
          <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">Email</label>
          <input type="email" class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" placeholder="Email..." id="email" aria-describedby="email-description" aria-invalid="false" name="email" value="" required/>
        </div>
        <div class="space-y-1">
          <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="body">Message</label>
          <textarea class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" placeholder="Message..." name="body" id="body" aria-describedby="body-description" aria-invalid="false" required></textarea>
        </div>
        <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground shadow hover:bg-primary/90 h-9 px-4 py-2 mt-2" type="submit">Trả lời ${commentName}</button>
      </form>
    `;

    // Tìm comment cha dựa vào commentId
    const parentCommentElement = event.target.closest('.comment');

    // Kiểm tra xem form trả lời đã tồn tại hay chưa
    let existingReplyForm = parentCommentElement.querySelector('.reply-form');
    if (existingReplyForm) {
      // Nếu form đã tồn tại, xóa nó
      existingReplyForm.remove();
    } else {
      // Nếu form chưa tồn tại, thêm nó vào
      parentCommentElement.insertAdjacentHTML('beforeend', replyForm);

      // Xử lý form trả lời
      const newReplyForm = parentCommentElement.querySelector('.reply-form');
      newReplyForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const formData = new FormData(newReplyForm);

        fetch('/api/comments', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          // Hiển thị lại comment sau khi thêm comment mới
          fetch('/api/comments/{{ $entertainmentSpot->id }}')
            .then(response => response.json())
            .then(comments => {
              displayComments(comments);
            });
        });
      });
    }
  }

  // Fetch comment khi trang web được load
  document.addEventListener('DOMContentLoaded', () => {
    fetch('/api/comments/{{ $entertainmentSpot->id }}')
      .then(response => response.json())
      .then(comments => {
        displayComments(comments);
      });
  });

  // Xử lý form comment chính
  const commentForm = document.getElementById('comment-form');
  commentForm.addEventListener('submit', (event) => {
    event.preventDefault();

    const formData = new FormData(commentForm);

    fetch('/api/comments', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      // Hiển thị lại comment sau khi thêm comment mới
      fetch('/api/comments/{{ $entertainmentSpot->id }}')
        .then(response => response.json())
        .then(comments => {
          displayComments(comments);
        });

      // Reset form
      commentForm.reset();
      document.querySelector('input[name="parent_id"]').value = ''; // Reset parent_id
    });
  });
</script>