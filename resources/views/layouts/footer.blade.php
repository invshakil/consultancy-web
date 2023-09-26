<div class="border-x-0 border-y-2 mt-10 border-y-whiteDark bg-offWhite" style="z-index: 1000; position: relative">
    <div class="grid grid-cols-2 gap-4 py-4 lg:pl-40 pl-10 md:grid-cols-3">
        <div>
            <h2 class="mb-6 text-sm font-semibold text-lightGreen uppercase dark:text-gray-400">Company</h2>
            <ul class="text-gray-500">
                <li class="mb-4">
                    <a href="{{route('blog')}}" class="hover:underline">Blog</a>
                </li>
                <li class="mb-4">
                    <a href="{{route('study', ['country'=>'all'])}}" class="hover:underline">Study Modules</a>
                </li>
                <li class="mb-4">
                    <a href="{{route('job')}}" class="hover:underline">Job Listing</a>
                </li>
                <li class="mb-4">
                    <a href="{{route('about')}}" class=" hover:underline">About Us</a>
                </li>
            </ul>
        </div>
        <div>
            <h2 class="mb-6 text-sm font-semibold text-lightGreen uppercase dark:text-gray-400">Help center</h2>
            <ul class="text-gray-500">
                <li class="mb-4">
                    <a href="https://api.whatsapp.com/send?phone={{env('WHATSAPP')}}"
                       class="hover:underline" target="_blank">Whatsapp</a>
                </li>
                <li class="mb-4">
                    <a href="https://www.facebook.com/messages/t/111237520716053" target="_blank" class="hover:underline">Facebook</a>
                </li>
                <li class="mb-4">
                    <a href="/about/#contact" class="hover:underline" target="_blank">Contact Us</a>
                </li>
            </ul>
        </div>
        {{--        <div>--}}
        {{--            <h2 class="mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Legal</h2>--}}
        {{--            <ul class="text-gray-500 dark:text-gray-400">--}}

        {{--            </ul>--}}
        {{--        </div>--}}
        <div>
            <h2 class="mb-6 text-sm font-semibold text-lightGreen uppercase dark:text-gray-400">Important</h2>
            <ul class="text-gray-500">
                @foreach($footerPages as $pageLink)
                    <li class="mb-4">
                        <a class="hover:underline"
                           href="{{ route('article-details', ['slug' => $pageLink['page']['slug']]) }}">{{ $pageLink['page']['title'] }}</a>
                    </li>
                @endforeach
                <li class="mb-4">
                    <a class="hover:underline" href="{{ route('sitemap') }}">Sitemap</a>
                </li>
            </ul>
        </div>
    </div>
    <hr class="h-px border-0 bg-whiteDark"/>
    <div class="pt-4 pb-7 px-4 text-gray-500 md:flex md:items-center md:justify-between">
        <span class="text-sm text-gray-500 sm:text-center">©2022-<?php echo date("Y"); ?><a
                href="https://flowbite.com/"> {{env('APP_NAME')}}™</a>. All Rights Reserved.
        </span>
        <div class="flex mt-4 space-x-6 sm:justify-center md:mt-0">
            <p class="tracking-widest text-sm">Follow Us: </p>
            <a href="{{$settings['li']}}" target="_blank" class=" hover:text-lightGreen dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="2 1 26 26"
                     aria-hidden="true">
                    <path
                        d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M10.496,8.403 c0.842,0,1.403,0.561,1.403,1.309c0,0.748-0.561,1.309-1.496,1.309C9.561,11.022,9,10.46,9,9.712C9,8.964,9.561,8.403,10.496,8.403z M12,20H9v-8h3V20z M22,20h-2.824v-4.372c0-1.209-0.753-1.488-1.035-1.488s-1.224,0.186-1.224,1.488c0,0.186,0,4.372,0,4.372H14v-8 h2.918v1.116C17.294,12.465,18.047,12,19.459,12C20.871,12,22,13.116,22,15.628V20z"/>
                </svg>
                <span class="sr-only">LinkedIn page</span>
            </a>
            <a href="{{$settings['fb']}}" target="_blank" class=" hover:text-lightGreen dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                          clip-rule="evenodd"/>
                </svg>
                <span class="sr-only">Facebook page</span>
            </a>
            <a href="{{$settings['in']}}" target="_blank" class="hover:text-lightGreen dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                          clip-rule="evenodd"/>
                </svg>
                <span class="sr-only">Instagram page</span>
            </a>
            <a href="{{$settings['tw']}}" target="_blank" class="hover:text-lightGreen dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                </svg>
                <span class="sr-only">Twitter page</span>
            </a>
        </div>
        <div>
            <form id="formsub" class="flex text-lightBlue md:mt-4 justify-center content-center px-3"
                  style="border: 1px solid #cccccc">
                <input name="email" id="email" type="email"
                       style="border: none"
                       class="bg-offWhite focus:ring-0 text-text text-sm tracking-wide rounded-md"
                       placeholder="Subscribe NewsLetter..."
                />
                <button type="submit" id="subscribe" class="flex subscribe justify-center content-center">
                    <img src="{{asset('assets/images/send.png')}}" alt=""
                         style="width: 26px;height: 46px; object-fit: contain"/>
                </button>
                <section id="loading" class="send-button" style="height: 20px!important;">
                    <div id="loading-content"></div>
                </section>
            </form>
            <p class="successMsg text-xs text-center w-full break-all p-2.5 text-offWhite"
               style="background-color: #679b87;display: none;">
                We Got You!!</p>
            <p class="errorMsg text-xs text-center p-2.5 text-text2" style="display: none; background-color: #eab3b3;">
                Something Went Wrong! Please Try Again!
            </p>
            <p class="already text-xs text-center p-2.5 text-offWhite"
               style="display: none; background-color: #636b6b;">
                Its Okay! You already subscribed.
            </p>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(document).on('click', '.subscribe', function (e) {
            e.preventDefault()
            let verified = $('#email').val()
            let data = {
                'email': $('#email').val(),
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (verified) {
                showLoading()
                $('#subscribe').css({display: 'none'})
                $.ajax({
                    type: 'POST',
                    url: `/subscribe`,
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        hideLoading()
                        $("#sendForm").trigger("reset")
                        $('.successMsg').show()
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log('XMLHttpRequest', XMLHttpRequest, textStatus, errorThrown)
                        if (XMLHttpRequest.status === 201) {
                            hideLoading()
                            $('.successMsg').show()
                            $('.already').hide()
                            $('.errorMsg').hide()
                            $("#sendForm").trigger("reset")
                        } else if (XMLHttpRequest.status === 422) {
                            hideLoading()
                            $('.already').show()
                            $('.successMsg').hide()
                            $('.errorMsg').hide()
                        } else {
                            hideLoading()
                            $('.errorMsg').show()
                            $('.successMsg').hide()
                            $('.already').hide()
                        }
                    }
                })
                $('#subscribe').css({display: 'block'})
            } else {
                ['formsub'].map(k => {
                    if ($(`#${k}`).val()) {
                        $(`#${k}`).css('border', '1px solid green');
                    } else {
                        $(`#${k}`).css('border', '1px solid red');
                    }
                })
            }
        })
    })

    $('#email').on('input', function () {
        const re = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        const emailFormat = re.test($("#email").val());
        if (emailFormat) {
            $('#formsub').css('border', '1px solid green');
        } else {
            $('#formsub').css('border', '1px solid red');
        }
    });

    function showLoading() {
        document.querySelector('#loading').classList.add('loading');
        document.querySelector('#loading-content').classList.add('loading-content');
    }

    function hideLoading() {
        document.querySelector('#loading').classList.remove('loading');
        document.querySelector('#loading-content').classList.remove('loading-content');
    }
</script>
