@extends('master')
@section('content')
    <div>
        <div class="study"></div>
        <div class="header-study flex justify-between">
            <h2 class="text-4xl text-whiteDark tracking-wider font-bold">Study Abroad</h2>

            <form id="sendForm" class="form-study flex flex-col px-6 py-8 submit rounded-sm" onsubmit="process(event)"
                  method="post">
                {{--                <p>Enter your phone number:</p>--}}
                <input id="name" type="text" name="name" placeholder="Name"/>
                <input id="number" type="tel" name="number"/>

                <input id="email" type="email" name="email" placeholder="Email"/>
                <div class="flex justify-center text-mainBlue py-2 text-xs bg-white"
                     style="text-shadow:0 0 black;margin: 1px 0;">
                    <p class="mr-2">Same whatsapp number?</p>
                    <input id="same" type="checkbox"/>
                    {{--                    <div class="flex justify-center items-center content-center">--}}
                    {{--                        <input type="radio" id="whatsapp_mobile_yes" name="whatsapp_mobile" value="yes">--}}
                    {{--                        <label class="mx-1">Yes</label><br>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="flex justify-center items-center content-center" style="margin-left: 5px">--}}
                    {{--                        <input type="radio" id="whatsapp_mobile_no" name="whatsapp_mobile" value="no">--}}
                    {{--                        <label class="mx-1">No</label><br>--}}
                    {{--                    </div>--}}
                </div>
                <input id="whatsapp" type="tel" name="whatsapp" placeholder="Whatsapp Number"/>
                <input type="submit"
                       class="btn cursor-pointer bg-lightGreen hover:bg-lightBlue text-white font-bold py-2 px-4"
                       value="Submit"/>
                <p class="text-red-600 text-sm px-14 py-3" id="error"
                   style="display: none;font-size: 12px; text-transform: capitalize"></p>
                {{--                <br>--}}

            </form>
        </div>

        <div class="xl:px-32 px-6 pb-8 xl:pt-24 pt-40">
            @include('pages.study.partial.douments')
            @include('pages.study.partial.package')
            @include('pages.study.partial.chooseCountry')
            @include('components.getIinTouch')
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        const phoneInputField = document.querySelector("#number");
        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "auto",
            geoIpLookup: getIp,
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        $('#number').on('input', function () {
            const input = $('#same');
            if (input.is(":checked")) {
                $('#whatsapp').val(phoneInput.getNumber())
                // $('#whatsapp').css('display', 'none');
            }
            else{
                $('#whatsapp').val('')
            }
        });

        $('#same').on('input', function () {
            const input = $('#same');
            if (input.is(":checked")) {
                $('#whatsapp').val(phoneInput.getNumber())
                // $('#whatsapp').css('display', 'none');
            }
            else{
                $('#whatsapp').val('')
            }
        });

        $('#whatsapp').on('input', function () {
            if ($('#whatsapp').val().length === 11 || $('#whatsapp').val().length === 14) {
                // $('#whatsapp').css('display', 'block');
                $('#whatsapp').css('border', '1px solid green');
            } else {
                // $('#whatsapp').css('display', 'block');
                $('#whatsapp').css('border', '1px solid red');
            }
        });

        $('#number').on('input', function () {
            if ($('#number').val().length === 11) {
                $('#number').css('border', '1px solid green');
            } else {
                $('#number').css('border', '1px solid red');
            }
        });

        $('#email').on('input', function () {
            const re = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            const emailFormat = re.test($("#email").val());
            const input = $(this);
            if (emailFormat) {
                input.css('border', '1px solid green');
            } else {
                input.css('border', '1px solid red');
            }
        });

        function getIp(callback) {
            fetch('https://ipinfo.io/json?token=1cadfc8d3a18ad', {
                headers: {
                    'Accept': 'application/json',
                    'Access-Control-Allow-Origin': '*'
                }
            })
                .then((resp) => resp.json())
                .catch(() => {
                    return {
                        country: 'BD',
                    };
                })
                .then((resp) => callback(resp.country));
        }

        function process(event) {
            event.preventDefault();
            const phoneNumber = phoneInput.getNumber();
            let verified = $('#email').val() && $('#number').val() && $('#whatsapp').val() && $('#name').val()
            let data = new FormData()
            data.append('name', $('#name').val())
            data.append('email', $('#email').val())
            data.append('phone', phoneNumber)
            data.append('whatsapp', $('#same').is(":checked") ? phoneNumber : $('#whatsapp').val())

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (verified) {
                console.log('data', data)
                // $.ajax({
                //     type: 'POST',
                //     url: `/contact-study`,
                //     data: data,
                //     dataType: 'json',
                //     success: function (response) {
                //         console.log('response', response.status)
                //         // localStorage.removeItem('phone')
                //         $('.successMsg').show()
                //         $("#cv-form").trigger("reset")
                //     },
                //     error: function (XMLHttpRequest, textStatus, errorThrown) {
                //         $('.errorMsg').show()
                //     }
                // })
            } else {
                ['name', 'email', 'whatsapp', 'number'].map(k => {
                    if ($(`#${k}`).val()) {
                        $(`#${k}`).css('border', '2px solid green');
                    } else {
                        $(`#${k}`).css('border', '1px solid red');
                    }
                })
            }
        }

        $(`#name`).on('input', function () {
            const input = $(this);
            if (input.val() && input.val() !== null) {
                input.css('border', '1px solid green');
            } else {
                input.css('border', '1px solid red');
            }
        });

    </script>

    <style>
        .study {
            background-image: url("{{asset('assets/images/study.avif')}}");
            height: 45vh;
            background-size: 100%;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(4px);
            /*z-index: -1!important;*/
            /*mask-image: rgba(-40deg ,244,233,211.1);*/
        }

        .header-study {
            text-shadow: 2px 2px #000000;
            position: relative;
            margin-top: -15vh;
            margin-left: 50px;
        }

        .form-study {
            background: rgb(25, 178, 117, .1);
            text-shadow: 0 0 black;
            /*position: relative;*/
            margin-top: -15vh;
            margin-right: 2%;
        }

        .form-study input {
            /*padding: 2px;*/
            margin: 1px 0;
            /*height: 3px;*/
        }
    </style>
@endsection
