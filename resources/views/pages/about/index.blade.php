@extends('master')

@section('content')
    <div style="height: 100vh;">
        <div class="contact"></div>
        <h2 class="text-4xl text-cancel contact-header text-center tracking-wider font-bold">ABOUT US</h2>
        <p class="text-sm text-text text-center contact-message tracking-wider font-light">
            {{$settings['about']}}
        </p>

        <div class="pb-20" style="margin-top: 9vh; height: 330px">
            <iframe
                title="our location"
                src="https://maps.google.com/maps?q=+Dhaka,+Topkhana+Road,26%2FA+Bangladesh&t=&z=13&ie=UTF8&iwloc=&output=embed"
                width="100%" height="330px" style="border:0" allowfullscreen loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
    <div id="contact">
        <br/>
        <br/>
    </div>

    @include('pages.about.partial.contactForm')

    <style>
        .contact {
            background-image: url("{{asset('assets/images/about.avif')}}");
            height: 65vh;
            background-size: 100%;
            background-repeat: no-repeat;
            filter: blur(8px);
            opacity: .7;
            z-index: -1 !important;
            box-shadow: 1px 1px 8px 1px #19b275;
        }

        .contact-header {
            padding: 0 20%;
            text-shadow: 1px 1px oldlace;
            position: relative;
            margin-top: -50vh;
        }

        .contact-message {
            margin: 5vh 20% 0 20%;
            position: relative;
            height: 30vh;
            overflow-y: scroll;
            overflow-x: hidden
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .contact-message::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .contact-message {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }

        @media only screen and (max-width: 800px) {
            .contact-message, .contact-header {
                padding: 0 5%;
            }

            .contact-header {
                margin-top: -52vh;
            }

            .contact-message {
                margin: 1vh 0 1vh 0;
            }

            .contact {
                background-image: unset;
                /*height: 100vh;*/
            }
        }
    </style>
@endsection
