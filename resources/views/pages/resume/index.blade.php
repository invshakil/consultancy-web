@extends('master')
@section('content')
    <div class="cvPage-header"></div>
    <div class="cvPage xl:px-10 px-2 xl:pl-32 py-2" style="padding-top: 9vh!important;">
        <div class="xl:ml-96 bg-mainBlue xl:px-12 px-3 py-5 form-cv rounded-md xl:w-8/12">
            <div class="w-44 mx-auto">
                <h2 class="text-center text-lg text-white border-b-2 border-b-white font-bold tracking-wider">SUBMIT
                    RESUME</h2>
                {{--                <div class="flex justify-around text-white">--}}
                {{--                    <input type="radio" id="worker" name="type" value="worker">--}}
                {{--                    <label for="worker">Worker</label><br>--}}
                {{--                    <input type="radio" id="stuff" name="type" value="stuff">--}}
                {{--                    <label for="stuff">Stuff</label><br>--}}
                {{--                </div>--}}
            </div>
            <form class="text-center" id="cv-form">
                @csrf
                <input type="hidden" name="_token" value="<?=csrf_token()?>">
                <section class="inputGrid grid xl:grid-cols-2 grid-cols-1 gap-3 py-3">
                    <input required type="text" class="col-span-2" id="name" name="name" placeholder="Name *"/>
                    {{--                    <section class="form-group">--}}
                    {{--                        <input required type="text" value="+88" placeholder="code" style="width: 18.5%!important;"/>--}}
                    {{--                        <input required type="number" name="phone" id="phone" placeholder="Phone Number" style="width: 80%!important;"/>--}}
                    {{--                    </section>--}}
                    {{--                    <input required type="text" id="otp" name="otp" placeholder="OTP"/>--}}
                    <section>
                        <div class="flex">
                            <input required type="number" class="mr-1" id="whatsapp" name="whatsapp"
                                   placeholder="Whatsapp No *" style="width: 70%"/>
                            <div>
                                <input type="checkbox" name="same" id="same"/>
                                <input class="-ml-3" style="background-color: transparent; font-size: 11px; width: 85%"
                                       value="same as phone no?" disabled/>
                            </div>
                        </div>
                    </section>
                    <input required type="email" id="email" name="email" placeholder="Email *"/>
                    <select required name="exp_in" id="exp_in">
                        {{--                        <option value="{{null}}" disabled selected>Select Bangladeshi Exp. In Years</option>--}}
                        <option value="{{null}}">Select Bangladeshi Exp. In Years</option>
                        <option value="0">0</option>
                        <option value="1-3">1-3</option>
                        <option value="3-5">3-5</option>
                        <option value="5-10">5-10</option>
                        <option value="10-15">10-15</option>
                        <option value="15+">15+</option>
                    </select>
                    <select required name="exp_out" id="exp_out">
                        {{--                        <option value="{{null}}" disabled>Select Overseas Exp. In Years</option>--}}
                        <option value="{{null}}">Select Overseas Exp. In Years</option>
                        <option value="0">0</option>
                        <option value="1-3">1-3</option>
                        <option value="3-5">3-5</option>
                        <option value="5-10">5-10</option>
                        <option value="10-15">10-15</option>
                        <option value="15+">15+</option>
                    </select>
                    <input name="jobID" id="jobID" required hidden type="text" value="{{basename(Request::path()) }}"
                           placeholder="Vacancy ID"/>
                    {{--                    <select>--}}
                    {{--                        <option disabled selected>Select Industry Type</option>--}}
                    {{--                        <option>Agriculture</option>--}}
                    {{--                        <option>Automobile</option>--}}
                    {{--                        <option>Civil Construction</option>--}}
                    {{--                    </select>--}}
                    <select name="source" id="source" required>
                        <option value="{{null}}" disabled selected>Select Source *</option>
                        <option value="facebook">Facebook</option>
                        <option value="google">Google</option>
                        <option value="instagram">instagram</option>
                        <option value="friends">Friends</option>
                        <option value="others">Others</option>
                    </select>
                    <input name="passport" id="passport" type="text" placeholder="Passport No."/>
                    <input name="file" required type="file" id="file" class="hidden"/>
                    <label for="file" class="text-xs text-left flex bg-white rounded-md">
                        <span id="fileRef"
                              class="px-3 rounded-md border border-whiteDark bg-whiteDark py-1 pb-5 cursor-pointer">Upload Resume</span>
                        <p id="fileName" class="hidden text-xs mt-3 ml-1" ></p>
                    </label>
                    <input placeholder="dummy" class="opacity-0"/>

                    <section class="text-left">
                        <input id="sub" type="checkbox" class="regular-checkbox" checked/>
                        <label class="text-xs text-white"> Subscribe To Newsletters</label>
                    </section>
                    <input placeholder="dummy" class="opacity-0"/>

                    <section class="text-left" style="margin-top: -15px">
                        <input type="checkbox" class="regular-checkbox" checked/>
                        <label class="text-xs text-white"> I Agree To The Terms & Conditions</label>
                    </section>
                </section>
                <button class="bg-mainBlue px-6 py-2 text-white  rounded-full hover:bg-lightGreen font-bold submitCv"
                        type="submit">Submit
                </button>
            </form>
            <p style="display: none" class="successMsg text-xl text-center text-lightGreen font-extrabold bg-whiteDark px-5 py-3 my-5">
                Your CV Has Been Submitted! We Will Get Back To You Soon!!</p>
            <p style="display: none" class="errorMsg text-xl text-center text-white font-extrabold bg-cancel px-5 py-3 my-5">
                Something Went Wrong! Please Try Again!
            </p>
        </div>
    </div>

    @include('components.getIinTouch')

    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>--}}

    <script>
        $(document).ready(function () {
            $(document).on('click', '.submitCv', function (e) {
                e.preventDefault()
                let verified = $('#exp_out').val() && $('#exp_in').val() && $('#source').val() && $('#file').val() && $('#name').val() && $('#email').val()
                let data = new FormData()
                data.append('file', document.getElementById('file').files[0])
                data.append('name', $('#name').val())
                data.append('email', $('#email').val())
                data.append('passport', $('#passport').val())
                data.append('source', $('#source').val())
                data.append('exp_in', $('#exp_in').val())
                data.append('exp_out', $('#exp_out').val())
                data.append('phone', localStorage.phone)
                data.append('jobID', $('#jobID').val())
                data.append('sub', $('#sub').is(":checked"))
                data.append('whatsapp', $('#same').is(":checked") ? localStorage.phone : $('#whatsapp').val())

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (verified) {
                    $.ajax({
                        type: 'POST',
                        url: `/submit-cv`,
                        data: data,
                        dataType: 'json',
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,
                        success: function (response) {
                            console.log('response', response.status)
                            // localStorage.removeItem('phone')
                            $('.successMsg').show()
                            $("#cv-form").trigger("reset")
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            $('.errorMsg').show()
                        }
                    })
                } else {
                    ['name', 'source', 'exp_in', 'exp_out', 'fileRef', 'jobID', 'file', 'email', 'whatsapp'].map(k => {
                        if ($(`#${k}`).val()) {
                            $(`#${k}`).css('border', '2px solid green');
                        } else {
                            $(`#${k}`).css('border', '1px solid red');
                        }
                    })

                    if (document.getElementById('file').files[0]) {
                        $(`#fileRef`).css('border', '2px solid green');
                    } else {
                        $(`#fileRef`).css('border', '1px solid red');
                    }
                }
                console.log('data', data)
            })
        })
    </script>

    <script>
        ['name', 'source', 'exp_in', 'exp_out', 'file', 'jobID'].map(k => {
            $(`#${k}`).on('input', function () {
                const input = $(this);
                if (input.val() && input.val() !== null) {
                    input.css('border', '2px solid green');
                } else {
                    input.css('border', '1px solid red');
                }
            });
        })

        $('#whatsapp').on('input', function () {
            const input = $(this);
            if (input.val().length === 11) {
                input.css('border', '2px solid green');
            } else {
                input.css('border', '1px solid red');
            }
        });
        $('#file').on('input', function () {
            if (document.getElementById('file').files[0]) {
                $('#fileRef').css('border', '2px solid green');
                let name=document.getElementById('file').files[0].name
                let size=document.getElementById('file').files[0].size
                $('#fileName').text(name+ ' ( ' +(size/1024).toFixed(0)+ ' KB' +' ) ' )
                $('#fileName').show()

            } else {
                $('#fileRef').css('border', '1px solid red');
            }
        });

        $('#same').on('input', function () {
            const input = $(this);
            if (input.is(":checked")) {
                $('#whatsapp').val(localStorage.phone)
                $('#whatsapp').css('border', '2px solid green');
            } else {
                $('#whatsapp').val(input.val())
                if ($('#whatsapp').val().length === 11) {
                    $('#whatsapp').css('border', '2px solid green');
                } else {
                    $('#whatsapp').css('border', '1px solid red');
                }
            }
            // console.log('clicked', input.is(":checked"))
        });

        $('#email').on('input', function () {
            const re = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            const emailFormat = re.test($("#email").val());
            const input = $(this);
            if (emailFormat) {
                input.css('border', '2px solid green');
            } else {
                input.css('border', '1px solid red');
            }
        });
    </script>

    <style>
        .cvPage-header {
            background-image: url("{{asset('assets/images/cvbg.jpg')}}");
            background-size: 100%;
            height: 90vh;
            background-repeat: no-repeat;
            filter: blur(5px);
        }

        .cvPage {
            position: relative;
            margin-top: -88vh;
        }

        .inputGrid input, select {
            padding: 6px 10px;
            background-color: white;
            border-radius: 4px;
            font-size: 12px;
            border: 2px solid transparent;
        }

        .inputGrid select {
            padding: 8px 10px;
        }

        input:focus {
            outline: none;
        }

        .form-cv {
            background: rgb(25, 178, 117, .6);
        }

        .regular-checkbox {
            -webkit-appearance: none;
            background-color: #fafafa;
            border: 1px solid #16182f;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
            height: 18px;
            display: inline-block;
            position: relative;
        }

        .regular-checkbox:active, .regular-checkbox:checked:active {
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .regular-checkbox:checked {
            background-color: #fcf4d5;
            border: 1px solid #faf3d5;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05), inset 15px 10px -12px rgb(88, 227, 172, .1);
            color: #19b275;
            height: 18px;
        }

        .regular-checkbox:checked:after {
            content: '\2713';
            font-size: 12px;
            position: absolute;
            top: 0;
            left: 3px;
            color: #19b275;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

    </style>
@endsection
