<div>
    <h1 class="section-header">Contact</h1>
    <div class="contact-wrapper">
        <form id="contact-form" class="form-horizontal contact-form" role="form">
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" class="form-control border-grey focus:border-lightGreen focus:ring-0" id="name"
                           placeholder="NAME" name="name" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="email" class="form-control border-grey focus:border-lightGreen focus:ring-0" id="email"
                           placeholder="EMAIL" name="email" value="">
                </div>
            </div>
            <textarea class="form-control border-grey focus:border-lightGreen focus:ring-0" rows="6"
                      placeholder="MESSAGE" id="message" name="message"></textarea>
            <button class="btn send-button btn-primary px-4 py-2 bg-lightBlue text-white hover:bg-lightGreen rounded-full" id="submit" type="submit">
                SEND
            </button>
            <section id="loading" class="send-button">
                <div id="loading-content"></div>
            </section>
            <p class="successMsg hidden text-lg text-center text-lightGreen font-extrabold bg-whiteDark px-5 py-3 my-5">
                Your Message Has Been Received! We Will Get Back To You Soon!!</p>
            <p class="errorMsg hidden text-lg text-center text-white font-extrabold bg-cancel px-5 py-3 my-5">
                Something Went Wrong! Please Try Again!
            </p>
        </form>

        <div class="direct-contact-container">
            <ul class="contact-list">
                <li class="list-item"><i class="fa fa-map-marker fa-2x"><span
                            class="contact-text place">Dhaka, Bangladesh</span></i></li>
                <li class="list-item"><i class="fa fa-phone fa-2x"><span class="contact-text phone"><a
                                href="tel:1-212-555-5555" title="Give me a call">{{env('PHONE_NUMBER')}}</a></span></i></li>
                <li class="list-item"><i class="fa fa-envelope fa-2x"><span class="contact-text gmail"><a
                                href="mailto:{{env('RECEIVER_EMAIL')}}" title="Send me an email">{{env('RECEIVER_EMAIL')}}</a></span></i></li>
            </ul>
            <hr>
            <ul class="social-media-list">
                <li><a href="{{env('FACEBOOK')}}" target="_blank" class="contact-icon">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                </li>
                <li><a href="{{env('LINKEDIN')}}" target="_blank" class="contact-icon">
                        <i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </li>
                <li><a href="{{env('TWITTER')}}" target="_blank" class="contact-icon">
                        <i class="fa fa-twitter" aria-hidden="true"></i></a>
                </li>
                <li><a href="{{env('INSTAGRAM')}}" target="_blank" class="contact-icon">
                        <i class="fa fa-instagram" aria-hidden="true"></i></a>
                </li>
            </ul>
            <hr>
            <div class="copyright mt-2">&copy; ALL OF THE RIGHTS RESERVED</div>
        </div>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    </div>

    <script>
        $(document).ready(function () {
            $(document).on('submit', '.contact-form', function (e) {
                e.preventDefault()
                let verified = $('#email').val() && $('#message').val()

                let data = {
                    'name': $('#name').val(),
                    'email': $('#email').val(),
                    'message': $('#message').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (verified) {
                    $('#submit').css({ opacity: 0 })
                    showLoading()
                    $.ajax({
                        type: 'POST',
                        url: `/contact-mail`,
                        data: data,
                        dataType: 'json',
                        success: ()=> {
                            // console.log('response', response)
                            $('.successMsg').show()
                            $("#contact-form").trigger("reset")
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            if(XMLHttpRequest.status===201){
                                $('.successMsg').show()
                                $("#contact-form").trigger("reset")
                                hideLoading()
                                $('#submit').css({ opacity: 100 })
                            }
                            else{
                                hideLoading()
                                $('.errorMsg').show()
                                $('#submit').css({ opacity: 100 })
                            }
                        }
                    })
                } else {
                    ['email', 'message'].map(k => {
                        if ($(`#${k}`).val()) {
                            $(`#${k}`).css('border', '1px solid green');
                        } else {
                            $(`#${k}`).css('border', '1px solid red');
                        }
                    })
                }
            })
        })

        $('#message').on('input', function () {
            const input = $(this);
            if (input.val()) {
                input.css('border', '1px solid green');
            } else {
                input.css('border', '1px solid red');
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

        #contact {
            width: 100%;
            height: 100%;
        }

        .section-header {
            text-align: center;
            margin: 0 auto;
            padding: 40px 0;
            font: 300 40px 'Oswald', sans-serif;
            color: #3c2060;
            text-transform: uppercase;
            letter-spacing: 6px;
        }

        .contact-wrapper {
            display: flex;
            flex-direction: row;
            justify-content: center;
            /*margin-left: 50px;*/
            padding: 0 20%;
            margin: 20px auto 100px auto;
            /*padding: 20px;*/
            position: relative;

            /*max-width: 840px;*/
        }

        /* Left contact page */
        .form-horizontal {
            /*float: left;*/
            /*max-width: 400px;*/
            font-family: 'Lato';
            font-weight: 400;
        }

        .form-control,
        textarea {
            width: 30vw;
            margin: 2px;
            padding: 5px 10px;
            background-color: #d5d5d5;
            color: #000000;
            /*letter-spacing: 1px;*/
        }

        .form-control,
        textarea:focus {
            outline: none;
        }

        .send-button {
            margin-top: 15px;
            height: 34px;
            width: 30vw;
            overflow: hidden;
            transition: all .2s ease-in-out;
        }
        /* Begin Right Contact Page */
        .direct-contact-container {
            /*max-width: 400px;*/
        }

        /* Location, Phone, Email Section */
        .contact-list {
            list-style-type: none;
            margin-left: -30px;
            padding-right: 20px;
        }

        .list-item {
            line-height: 4;
            color: #4a4b62;
        }

        .contact-text {
            font: 300 18px 'Lato', sans-serif;
            letter-spacing: 2px;
            color: #de5a06;
        }

        .place {
            margin-left: 62px;
        }

        .phone {
            margin-left: 56px;
        }

        .gmail {
            margin-left: 53px;
        }

        .contact-text a {
            color: #de5a06;
            text-decoration: none;
            transition-duration: 0.2s;
        }

        .contact-text a:hover {
            color: #2da676;
            text-decoration: none;
        }


        /* Social Media Icons */
        .social-media-list {
            position: relative;
            font-size: 22px;
            text-align: center;
            width: 100%;
            margin: 0 auto;
            padding: 0;
        }

        .social-media-list li a {
            color: #fff;
        }

        .social-media-list li {
            position: relative;
            display: inline-block;
            height: 60px;
            width: 60px;
            margin: 10px 3px;
            line-height: 60px;
            border-radius: 50%;
            color: #19b275;
            background-color: #4a4b62;
            cursor: pointer;
            transition: all .2s ease-in-out;
        }

        .social-media-list li:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 60px;
            height: 60px;
            line-height: 60px;
            border-radius: 50%;
            opacity: 0;
            box-shadow: 0 0 0 1px #fff;
            transition: all .2s ease-in-out;
        }

        .social-media-list li:hover {
            background-color: #e1e1e1;
        }

        .social-media-list li:hover:after {
            opacity: 1;
            transform: scale(1.12);
            transition-timing-function: cubic-bezier(0.37, 0.74, 0.15, 1.65);
        }

        .social-media-list li:hover a {
            color: #19b275;
        }

        .copyright {
            font: 200 14px 'Oswald', sans-serif;
            color: #555;
            letter-spacing: 1px;
            text-align: center;
        }

        hr {
            border-color: rgba(162, 162, 162, 0.6);
        }

        /* Begin Media Queries*/
        @media screen and (max-width: 850px) {
            .contact-wrapper {
                display: flex;
                flex-direction: column;
            }
            .form-control, textarea {
                width: 50vw;
                margin: 0 auto;
            }
            .direct-contact-container, .form-horizontal {
                margin: 0 auto;
            }

            .direct-contact-container {
                margin-top: 60px;
                max-width: 300px;
            }

            .social-media-list li {
                height: 60px;
                width: 60px;
                line-height: 60px;
            }

            .social-media-list li:after {
                width: 60px;
                height: 60px;
                line-height: 60px;
            }
        }

        @media screen and (max-width: 569px) {

            .direct-contact-container, .form-wrapper {
                float: none;
                margin: 0 auto;
            }

            .form-control, textarea {
                width: 70vw;
                margin: 0 auto;
            }


            .name, .email, textarea {
                width: 280px;
            }

            .direct-contact-container {
                margin-top: 60px;
                max-width: 280px;
            }

            .social-media-list {
                left: 0;
            }

            .social-media-list li {
                height: 55px;
                width: 55px;
                line-height: 55px;
                font-size: 2rem;
            }

            .social-media-list li:after {
                width: 55px;
                height: 55px;
                line-height: 55px;
            }

        }

        @media screen and (max-width: 410px) {
            .send-button {
                width: 99%;
            }
        }
    </style>
</div>
