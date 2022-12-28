@extends('master')
@section('content')
    <div class="flex justify-start md:flex-row flex-col-reverse" style="padding-top: 20vh;min-height: 90vh">

        <div class="jobCard md:-mb-48">
            {{--            <h2 class="lg:text-2xl text-center text-xl text-mainBlue uppercase px-2">You are applying for:</h2>--}}
            @include('components.card.job',
                [
                    'title'=>$job['title'],
                    'slug' => $job['slug'],
                    'quality' => $job['quality'],
                    'description' => $job['description'],
                    'country' => $job['country'],
                    'industry' => $job['industry'],
                    'salary' => $job['salary'],
                    'responsibility' => $job['responsibility'],
                    'vacancy' => $job['vacancy'],
                    'length' => $job['length'],
                    'exp_min' => $job['exp_min'],
                    'exp_max' => $job['exp_max'],
                    'code' => $job['id'],
                    'date' => $job['created_at'],
                    'type' => $job['type'],
                    'detail' => true,
                ])
        </div>

        <div class="mt-20 text-center applyCard">
            <h2 class="lg:text-2xl text-xl text-lightGreen capitalize px-2">Verify your phone number first</h2>
            <div class="pb-24 lg:px-2 pt-4">
                <hr/>
                <form id="sendForm" style="margin-top: 2vh;" onsubmit="process(event)" method="post">
                    {{--                <p>Enter your phone number:</p>--}}
                    <div class="flex justify-center content-center">
                        <input id="number" type="tel" name="number"/>
                        <input type="submit"
                               class="btn cursor-pointer bg-lightGreen hover:bg-mainBlue text-white font-bold py-2 px-4"
                               value="Send OTP"/>
                    </div>
                    <p class="text-red-600 text-sm px-14 py-3" id="error"
                       style="display: none;font-size: 12px; text-transform: capitalize"></p>
                    <div id="recaptcha-container" class="flex justify-center content-center mt-1"></div>
                    {{--                <br>--}}

                </form>
                <div style="margin-top: 10px; display: none" id="verifyForm" class="pb-24 px-2 pt-4">
                    <p class="text-sm text-mainBlue mb-3">A verification code was sent</p>
                    <form>
                        <input type="text" id="verificationCode" class="md:w-full"
                               placeholder="Enter Verification Code"><br>
                        <button type="button"
                                class="mt-4 bg-lightGreen hover:bg-mainBlue text-white font-bold py-2 px-4 rounded"
                                onclick="VerifyCode();">
                            Verify Code
                        </button>
                    </form>
                    <br/>
                    <p class="text-red-600 text-sm px-14 py-3" id="error2"
                       style="display: none;font-size: 12px; text-transform: capitalize"></p>
                    <br/>
                    <br/>
                    <button type="button"

                            class="bg-lightBlue hover:bg-mainBlue text-white px-2 py-3 text-xs rounded-md"
                            onclick="reload();">
                        Didn't Get The Code
                    </button>
{{--                    <a onclick="reload()" style="margin-top: 5vh!important;" class="cursor-pointer bg-lightBlue text-white mt-20 px-10 py-3 text-xs rounded-md">--}}
{{--                        --}}
{{--                    </a>--}}
                </div>
            </div>
        </div>



    </div>

    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        const API = '{{ env('APIKEY') }}';
        const firebaseConfig = {
            apiKey: API,
            authDomain: "career-challangers.firebaseapp.com",
            projectId: "career-challangers",
            storageBucket: "career-challangers.appspot.com",
            messagingSenderId: "855250108850",
            appId: "1:855250108850:web:3405021a58cba057f1a4ab",
            measurementId: "G-H1QKHNF6E0"
        };
        window.onload = function () {
            render();
        };
        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }
        firebase.initializeApp(firebaseConfig);
        const info = document.querySelector(".alert-info");
        const phoneInputField = document.querySelector("#number");
        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "auto",
            geoIpLookup: getIp,
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
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
            // console.log('phoneInputField',phoneInputField.value)
            // phoneInputField.value = phoneNumber;
            firebase.auth().signInWithPhoneNumber(phoneNumber, window.recaptchaVerifier).then(function (confirmationResult) {
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                $("#sentSuccess").text("Enter Verification code");
                $("#sentSuccess").show();
                $("#sendForm").css('display', 'none');
                $("#verifyForm").show();
            }).catch(error => {
                console.log('err', error.message)
                $("#number").css('border', '1px solid red');
                // $("#number").css('color', 'red');
                $("#error").text('Please Enter A Valid Number!');
                $("#error").show();
            });
        }
        function VerifyCode() {
            const code = $("#verificationCode").val();
            coderesult.confirm(code).then(function (result) {
                const user = result.user;
                $("#successRegsiter").text("A verification code was sent to you phone");
                $("#successRegsiter").show();
                let path=window.location.pathname.slice(-1)
                localStorage.phone=phoneInput.getNumber()
                window.location.replace(`/upload-cv/${path}`)
            }).catch(error => {
                $("#error2").text(error.message);
                $("#error2").show();
            });
        }
        function reload(){
            window.location.reload()
        }
    </script>
    <style>
        .jobCard{
            width: 66vw;
        }
        .applyCard{
            width: 30vw;
        }
        @media only screen and (max-width: 768px) {
            .jobCard {
                width: 100%;
            }
            .applyCard {
                width: 100%;
            }
        }
    </style>
@endsection
