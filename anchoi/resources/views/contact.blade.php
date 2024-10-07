<div class="flex flex-col min-h-screen">
    @include('header')

    <main class="flex-1 flex flex-col scroll-custom overflow-y-auto  pt-20">
        <div class="flex-1">
            <div class="container mx-auto">
                <div class="flex flex-col">
                    <h2 class="mb-4 mt-8 text-4xl tracking-tight font-extrabold text-center text-gray-800 dark:text-white">Contact Us</h2>
                    <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">Got a technical issue? Want to send feedback about a beta feature? Need details about our Business plan? Let us know.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-16 mx-auto">
                    <div class="flex flex-col gap-2 items-center">
                        <p class="text-gray-800 dark:text-white">Số điện thoại</p>
                        <p class="font-semibold text-gray-800 dark:text-white">0971578680</p>
                    </div>
                    <div class="flex flex-col gap-2 items-center">
                        <p class="text-gray-800 dark:text-white">Họ tên</p>
                        <p class="font-semibold text-gray-800 dark:text-white">Hoàng Vũ Nghị</p>
                    </div>
                    <div class="flex flex-col gap-2 items-center">
                        <p class="text-gray-800 dark:text-white">Gmail</p>
                        <p class="font-semibold text-gray-800 dark:text-white">hoangvunghi2004@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-100 dark:bg-gray-800 mt-2 border-t border-gray-200 dark:border-gray-700 py-4">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="">
                <div class="flex flex-col md:flex-row justify-between items-center">
                <a href="/" class="logo cursor-pointer flex items-center flex-row gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                            <circle cx="12" cy="12" r="1"></circle>
                            <path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path>
                            <path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>
                        </svg>
                        <p class="text-xl font-semibold">Ăn chơi nét</p>
                    </a>
                    <div class="flex mt-4 md:mt-0">
                        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024. All Rights Reserved.</span>
                    </div>
                    <div class="flex mt-4 md:mt-0 space-x-4"></div>
                </div>
            </div>
        </div>
    </footer>
    <script>
          document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });
});
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
    </script>
</div>