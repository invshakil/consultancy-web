<nav class="w-screen header fixed" style="min-height: 10vh;z-index: 100!important;">
    <div class="cutCorner absolute">
        <div class="pt-3 pl-5 inline-flex">
            <img src="{{asset('assets/images/ccLogo2.png')}}"
                 style="margin-left: 4vw; height: 7vh; object-fit: contain"/>
            <div class="flex flex-col">
                <span class="text-2xl text-mainBlue font-bold uppercase"
                      style="font-family: 'Agency FB',cursive;">Career Challengers</span>
                <hr class="h-px bg-lightGreen border-0">
                <span class="text-cancel text-xs" style="font-family: cursive">To change People's Lives</span>
            </div>
        </div>
    </div>
    <div class="container flex flex-wrap items-center justify-between mx-auto">
        <a href="#" class="flex items-center">
        </a>
        <button data-collapse-toggle="navbar-multi-level" type="button"
                class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-multi-level" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                      clip-rule="evenodd"></path>
            </svg>
        </button>


        <div class="hidden lg:mt-6 mt-10 w-full md:block md:w-96 mr-44" id="navbar-multi-level">
            <ul style="margin-top: 3vh; margin-bottom: 2vh" class="flex md:mt-0">
                <li style="z-index: 100!important;"
                    class="px-3 font-bold tracking-widest bg-lightBlue cursor-pointer text-white li flex items-center"><a
                        class="hover:text-cancel @if(Request::url() == url('/')) text-cancel @endif"
                        href="{{route('home')}}">HOME</a></li>

                <li class="text-white bg-lightBlue li @if(Request::url() == url('/study')) text-cancel @endif font-bold tracking-widest hover:text-cancel"
                    style="z-index: 100!important;">
                    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                            class="px-3 cursor-pointer flex items-center">
                        STUDY
                        <svg class="w-4 h-4 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownNavbar"
                         class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                            <li>
                                <a href="{{route('study', ['country'=>'all'])}}"
                                   class="block px-4 py-2 hover:bg-lightGreen tracking-wide hover:text-white"> STUDY
                                    MODULES</a>
                            </li>
                            <li aria-labelledby="dropdownNavbarLink">
                                <button id="doubleDropdownButton" data-dropdown-toggle="doubleDropdown"
                                        data-dropdown-placement="right-start" type="button"
                                        class="flex items-center tracking-wide justify-between w-full px-4 py-2 hover:bg-lightGreen hover:text-white">
                                    COUNTRIES
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <div id="doubleDropdown"
                                     class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="doubleDropdownButton">
                                        <li>
                                            <a href="{{route('study', ['country'=>'usa'])}}"
                                               class="block px-4 py-2 hover:bg-mainBlue dark:hover:bg-mainBlue hover:text-white">USA</a>
                                        </li>
                                        <li>
                                            <a href="{{route('study', ['country'=>'germany'])}}"
                                               class="block px-4 py-2 hover:bg-mainBlue dark:hover:bg-mainBlue hover:text-white">
                                                UK</a>
                                        </li>
                                        <li>
                                            <a href="{{route('study', ['country'=>'canada'])}}"
                                               class="block px-4 py-2 hover:bg-mainBlue dark:hover:bg-mainBlue hover:text-white">CANADA</a>
                                        </li>
                                        <li>
                                            <a href="{{route('study', ['country'=>'australia'])}}"
                                               class="block px-4 py-2 hover:bg-mainBlue dark:hover:bg-mainBlue hover:text-white">AUSTRALIA</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li style="z-index: 100!important;"
                    class="px-3 @if(Request::url() == url('/jobs')) text-cancel @endif bg-whiteDark cursor-pointer font-bold tracking-widest li text-mainBlue flex items-center">
                    <a
                        class="hover:text-cancel " href="{{route('job')}}">JOBS</a>
                </li>
                <li style="z-index: 100!important;"
                    class="px-3 @if(Request::url() == url('/blog')) text-cancel @endif bg-whiteDark cursor-pointer font-bold tracking-widest li text-mainBlue flex items-center">
                    <a
                        class="hover:text-cancel " href="{{route('blog')}}">BLOG</a>
                </li>
                <li style="z-index: 100!important;"
                    class="px-3 @if(Request::url() == url('/about')) text-cancel @endif cursor-pointer bg-whiteDark font-bold tracking-widest li text-mainBlue flex items-center">
                    <a
                        class="hover:text-cancel " href="{{route('about')}}">CONTACT</a>
                </li>
            </ul>
        </div>
    </div>
    <script>
        $(function () {
            const header = $(".header");
            const cutCorner = $(".cutCorner");
            const list = $(".li");
            $(window).scroll(function () {
                const scroll = $(window).scrollTop();
                if (scroll >= 100) {
                    header.addClass("bg-mainBlue");
                    cutCorner.addClass("bg-offWhite");
                    list.removeClass("text-lightGreen");
                    list.removeClass("font-bold");
                    list.removeClass("bg-whiteDark");
                    list.removeClass("bg-lightBlue");
                    list.addClass("font-lighter");
                    list.addClass("text-white");
                } else {
                    list.removeClass("text-white");
                    list.addClass("text-mainBlue");
                    list.addClass("font-bold");
                    list.addClass("bg-whiteDark");
                    // list.addClass("bg-lightBlue");
                    header.removeClass("bg-mainBlue");
                    cutCorner.removeClass("bg-offWhite");
                }
            });
        });

        // $(window).scroll(function() {
        //     let scroll = $(window).scrollTop();
        //     alert('scrolled')
        //     if (scroll >= 100) {
        //         $('#offWhite').removeClass('bg-transparent');
        //         $('#offWhite').addClass('bg-offWhite');
        //         $('#blue').removeClass('bg-transparent');
        //         $('#blue').addClass('bg-mainBlue');
        //     }
        // });
    </script>
</nav>
<style>
    .cutCorner {
        min-height: 10vh;
        z-index: 100 !important;
        width: 45vw;
        top: 0;
        left: 0;
        overflow: hidden;
        clip-path: polygon(
            0 100%,
            0% 0,
            0% 0,
            60% 0%,
            100% 100%,
            100% 100%,
            100% 100%,
            100% 100%,
            100% 100%
        )
    }

    @media only screen and (max-width: 900px) {
        .cutCorner {
            background-color: #4a4b62;
            width: 100vw!important;
        }
    }
</style>
