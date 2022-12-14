<form id="sendForm" class="form-study flex flex-col px-2 py-4 submit rounded-sm" onsubmit="process(event)"
      method="post">
    {{--                <p>Enter your phone number:</p>--}}
    <input class="input focus:ring-0" id="name" type="text" name="name" placeholder="Name"/>
    <input class="input focus:ring-0" id="number" type="tel" name="number"/>

    <input class="input focus:ring-0" id="email" type="email" name="email" placeholder="Email"/>
    <div class="flex justify-start text-gray-400 pl-3 py-2 text-xs"
         style="text-shadow:0 0 black;margin: 1px 0;">
        <p class="mr-2">Same whatsapp number?</p>
        <input id="same" class="input focus:ring-0 border-whiteDark" type="checkbox"/>
    </div>
    <input class="input focus:ring-0" id="whatsapp" type="tel" name="whatsapp" placeholder="Whatsapp Number"/>
    <input type="submit"
           id="submit"
           class="submitStudy my-2 btn cursor-pointer bg-tahiti hover:bg-lightGreen text-white font-bold py-2 px-4"
           value="Submit"/>
    <section id="loading" class="send-button" style="height: 20px!important;">
        <div id="loading-content"></div>
    </section>
    <p class="successMsg text-xs text-center w-full break-all p-2.5 text-mainBlue" style="background-color: #679b87;display: none; ">
        We Will Get Back To You Soon!!</p>
    <p class="errorMsg text-xs text-center p-2.5 text-text2 "style="background-color: #eab3b3;display: none; ">
        Something Went Wrong! Please Try Again!
    </p>
</form>

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
        } else {
            $('#whatsapp').val('')
        }
    });

    $('#same').on('input', function () {
        const input = $('#same');
        if (input.is(":checked")) {
            $('#whatsapp').val(phoneInput.getNumber())
            // $('#whatsapp').css('display', 'none');
        } else {
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

    $(document).ready(function () {
        $(document).on('click', '.submitStudy', function (e) {
            e.preventDefault();
            const phoneNumber = phoneInput.getNumber();
            let verified = $('#email').val() && $('#number').val() && $('#whatsapp').val() && $('#name').val()
            let data = {
                'name': $('#name').val(),
                'email': $('#email').val(),
                'phone': phoneNumber,
                'whatsapp': $('#same').is(":checked") ? phoneNumber : $('#whatsapp').val()
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (verified) {
                showLoading()
                // console.log('data', data)
                $('#submit').css({display: 'none'})
                $.ajax({
                    type: 'POST',
                    url: `/contact-study`,
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        hideLoading()
                        $("#sendForm").trigger("reset")
                        $('#submit').css({display: 'block'})
                        $('.successMsg').show()
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        if (XMLHttpRequest.status === 201) {
                            hideLoading()
                            $('.successMsg').show()
                            $("#sendForm").trigger("reset")
                            $('#submit').css({display: 'block'})
                        } else {
                            hideLoading()
                            $('.errorMsg').show()
                            $('#submit').css({display: 'block'})
                        }

                    }
                })
            } else {
                ['name', 'email', 'whatsapp', 'number'].map(k => {
                    if ($(`#${k}`).val()) {
                        $(`#${k}`).css('border', '2px solid green');
                    } else {
                        $(`#${k}`).css('border', '1px solid red');
                    }
                })
            }
        })
    })

    $(`#name`).on('input', function () {
        const input = $(this);
        if (input.val() && input.val() !== null) {
            input.css('border', '1px solid green');
        } else {
            input.css('border', '1px solid red');
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

<style>
    .form-study {
        /*background: rgb(25, 178, 117, .1);*/
        background-color: #392650;
        text-shadow: 0 0 black;
        position: relative;
        margin-top: -10vh;
        height: 315px;
        margin-right: 2%;
    }

    .input {
        border: 1px solid #4a4b62;
        margin: 4px 0;
        color: #2da676;
        background-color: inherit;
        /*padding: 2px;*/
        /*height: 3px;*/
    }
</style>
