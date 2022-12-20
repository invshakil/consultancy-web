@extends('master')
@section('content')
    <div class="{{$country}} study"></div>
    <div class="header-study flex justify-between">
        <h2 class="text-4xl text-whiteDark tracking-wider font-bold">
            Study
            @if($country!='all') In
            <span
                class="@if ($country==='usa' || $country==='uk') uppercase  @else capitalize @endif">{{$country}}
                </span>
            @else
                Abroad
            @endif
        </h2>
        @include('components.studyMailForm')
    </div>
    <div class="xl:px-32 px-6 pb-8 xl:pt-4 pt-40">
        @if($country=='all')
            @include('pages.study.partial.douments')
            @include('pages.study.partial.package')
            @include('pages.study.partial.chooseCountry')
        @elseif($country=='usa')
            @include('pages.study.partial.usa')
        @endif
        @include('components.getIinTouch')
    </div>

    <style>
        .canada {
            background-image: url("{{asset('assets/images/can.avif')}}");
        }

        .uk {
            background-image: url("{{asset('assets/images/uk.avif')}}");
        }

        .usa {
            background-image: url("{{asset('assets/images/usa.avif')}}");
        }

        .australia {
            background-image: url("{{asset('assets/images/aus.avif')}}");
        }
        .all {
            background-image: url("{{asset('assets/images/study.avif')}}");
        }

        .study {
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
    </style>
@endsection
