<div class="w-screen -mt-4 -ml-5">
    <div id="default-carousel" class="relative duration-700 mb-4 mt-4 ml-4" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="overflow-hidden relative h-56 rounded-lg h-screen">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in active" data-carousel-item style="transition: all 2s">
                <img src="{{asset('assets/images/cs.avif')}}" class="rounded-0" alt="..."
                     style="filter: blur(1px); width: 100%; height: 100vh; object-fit: cover">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-out" data-carousel-item>
                <img src="{{asset('assets/images/hotel.avif')}}" alt="..."
                     style="width: 100%; height: 100vh; object-fit: cover">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in" data-carousel-item>
                <img src="{{asset('assets/images/health.avif')}}" alt="..."
                     style="width: 100%; height: 100vh; object-fit: cover">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-out" data-carousel-item>
                <img src="{{asset('assets/images/eng2.avif')}}" alt="..."
                     style="width: 100%; height: 100vh; object-fit: cover">
            </div>
            <!-- Item 5 -->
            <div class="hidden duration-700 ease-in" data-carousel-item>
                <img src="{{asset('assets/images/law2.avif')}}" alt="..."
                     style="width: 100%; height: 100vh; object-fit: cover">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1"
                    data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                    data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                    data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                    data-carousel-slide-to="3"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
                    data-carousel-slide-to="4"></button>
        </div>
        <!-- Slider controls -->
        <button type="button"
                class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                data-carousel-prev>
        <span
            class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round"
                                                                              stroke-linejoin="round" stroke-width="2"
                                                                              d="M15 19l-7-7 7-7"></path></svg>
            <span class="hidden">Previous</span>
        </span>
        </button>
        <button type="button"
                class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                data-carousel-next>
        <span
            class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round"
                                                                              stroke-linejoin="round" stroke-width="2"
                                                                              d="M9 5l7 7-7 7"></path></svg>
            <span class="hidden">Next</span>
        </span>
        </button>
    </div>
</div>
