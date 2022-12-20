@extends('master')
@section('content')
    <div style="padding-top: 20vh; height: 90vh; text-align: center">
        <h2 class="lg:text-3xl text-xl text-lightGreen uppercase px-2">First, We need to verify your phone number</h2>
        <div class="pb-24 lg:px-72 px-10 pt-4">
            <hr/>
            <form id="sendForm" style="margin-top: 2vh" onsubmit="process(event)" method="post">
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
            <div style="margin-top: 10px; display: none" id="verifyForm" class="pb-24 px-52 pt-4">
                    <p class="text-sm text-mainBlue mb-3">A verification code was sent to you phone</p>
                    <form>
                        <input type="text" id="verificationCode" class="form-control"
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
                <a onclick="reload()" style="margin-top: 5vh!important;" class="cursor-pointer bg-lightBlue text-white mt-20 px-10 py-3 rounded-md">Didn't Get The
                    Code?Try Again
                </a>
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


@endsection
