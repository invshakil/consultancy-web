<div>
    <h1 class="section-header">Contact</h1>
    <div class="lg:flex justify-center lg:px-40 px-10">
        <div>
        <form id="contact-form" class="form-horizontal contact-form" role="form">
            <div class="form-group">
                <input type="text" class="my-1 lg:w-96 w-full border-grey focus:border-lightGreen focus:ring-0"
                       id="name"
                       placeholder="Name..." name="name" value="">
            </div>
            <div class="form-group">
                <input type="email" class="lg:w-96 w-full my-1 border-grey focus:border-lightGreen focus:ring-0"
                       id="email"
                       placeholder="Email..." name="email" value="">
            </div>
            <textarea class="border-grey lg:w-96 w-full my-1 focus:border-lightGreen focus:ring-0" rows="6"
                      placeholder="Your Message..." id="message" name="message"></textarea>
            <section id="loading" class="send-button">
                <div id="loading-content"></div>
            </section>
            <p class="successMsg hidden text-lg text-center text-lightGreen font-extrabold bg-whiteDark px-5 py-3 my-5">
                Your Message Has Been Received! We Will Get Back To You Soon!!</p>
            <p class="errorMsg hidden text-lg text-center text-white font-extrabold bg-cancel px-5 py-3 my-5">
                Something Went Wrong! Please Try Again!
            </p>
        </form>
            <input type="submit"
                   class="submitForm cursor-pointer lg:w-96 w-full px-4 py-2 my-1 bg-lightBlue text-white hover:bg-lightGreen rounded-full"
                   id="submit" value="Send Message"
            />
        </div>
        <div class="lg:ml-20 ml-10 my-10">
            <ul class="contact-list">
                <li class="list-item">
                    <em class="fa fa-map-marker fa-2x">
                        <span
                            class="place text-lightGreen lg:text-lg md:text-sm w-full">36/A, Shegunbagicha, Dhaka, Bangladesh
                        </span>
                    </em>
                </li>
                <li class="list-item">
                    <em class="fa fa-phone fa-2x">
                        <span class="text-lightGreen lg:text-lg md:text-sm phone">
                            <a
                                href="tel:1-212-555-5555" title="Give me a call">{{env('PHONE_NUMBER')}}
                            </a>
                        </span>
                    </em>
                </li>
                <li class="list-item"><em class="fa fa-envelope fa-2x">
                        <span class="text-lightGreen lg:text-lg md:text-sm gmail">
                            <a href="mailto:{{env('RECEIVER_EMAIL')}}"
                               title="Send me an email">{{env('RECEIVER_EMAIL')}}
                            </a>
                        </span>
                    </em>
                </li>
            </ul>
            <hr>
            <ul class="social-media-list">
                <a href="{{env('FACEBOOK')}}" title="Facebook" target="_blank" class="contact-icon">
                    <li>
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </li>
                </a>
                <a href="{{env('LINKEDIN')}}" target="_blank" title="LinkedIn" class="contact-icon">
                    <li>
                        <i class="fa fa-linkedin" aria-hidden="true"></i>
                    </li>
                </a>
                <a href="{{env('TWITTER')}}" target="_blank" title="Twitter" class="contact-icon">
                    <li>
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </li>
                </a>
                <a href="{{env('INSTAGRAM')}}" target="_blank" title="Instagram" class="contact-icon">
                    <li>
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </li>
                </a>
            </ul>
            <hr>
            <div class="copyright mt-2">&copy; ALL OF THE RIGHTS RESERVED</div>
        </div>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    </div>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.submitForm', function (e) {
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
                    $('#submit').css({display: 'none'})
                    showLoading()
                    $.ajax({
                        type: 'POST',
                        url: `/contact-mail`,
                        data: data,
                        dataType: 'json',
                        success: () => {
                            // console.log('response', response)
                            $('.successMsg').show()
                            hideLoading()
                            $("#contact-form").trigger("reset")
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            if (XMLHttpRequest.status === 201) {
                                $('.successMsg').show()
                                $("#contact-form").trigger("reset")
                                hideLoading()
                                $('#submit').css({display: 'block'})
                            } else {
                                hideLoading()
                                $('.errorMsg').show()
                                $('#submit').css({display: 'block'})
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
        .section-header {
            text-align: center;
            margin: 0 auto;
            padding: 40px 0;
            font: 300 40px 'Oswald', sans-serif;
            color: #3c2060;
            text-transform: uppercase;
            letter-spacing: 6px;
        }

        .contact-list {
            list-style-type: none;
            margin-left: -30px;
            padding-right: 20px;
        }

        .list-item {
            line-height: 4;
            color: #4a4b62;
        }

        .place {
            margin-left: 22px;
        }

        .phone {
            margin-left: 15px;
        }

        .gmail {
            margin-left: 15px;
        }

        /* Social Media Icons */
        .social-media-list {
            position: relative;
            font-size: 18px;
            text-align: center;
            width: 100%;
            margin: 0 auto;
            padding: 0;
        }

        .social-media-list a li {
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

        .social-media-list a:hover li {
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

            .social-media-list li {
                height: 40px;
                width: 40px;
                line-height: 40px;
            }

            .social-media-list li:after {
                width: 40px;
                height: 40px;
                line-height: 40px;
            }
        }

        @media screen and (max-width: 569px) {
            .social-media-list {
                left: 0;
            }

            .social-media-list li {
                height: 35px;
                width: 35px;
                line-height: 35px;
                font-size: 1rem;
            }

            .social-media-list li:after {
                width: 35px;
                height: 35px;
                line-height: 35px;
            }
        }

    </style>
</div>
