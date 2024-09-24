<div class="flex flex-col min-h-screen">
    @include('header')

    <main class="flex-1 flex flex-col scroll-custom overflow-y-auto">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-atom w-8 h-8 text-indigo-500 dark:text-indigo-400">
                            <circle cx="12" cy="12" r="1"></circle>
                            <path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"></path>
                            <path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"></path>
                        </svg>
                        <p class="text-xl font-semibold text-gray-800 dark:text-white">Ăn chơi nét</p>
                    </a>
                    <div class="flex mt-4 md:mt-0">
                        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024. All Rights Reserved.</span>
                    </div>
                    <div class="flex mt-4 md:mt-0 space-x-4"></div>
                </div>
            </div>
        </div>
    </footer>
</div>