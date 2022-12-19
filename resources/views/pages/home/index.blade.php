@extends('master')
@section('content')
    <div class="centerItemsAbsolute text-center z-50 text-mainBlue">
        <h2 style="text-shadow: 3px 1px #525252; font-family: monospace" class="text-7xl font-bold tracking-widest ">TO
            <span class="text-cancel">CHANGE</span> <span class="text-cancel">PEOPLE'S</span> LIVES</h2>
    </div>
    @include('pages.home.partial.carousal')
    <div class="lg:px-32 px-2 carousalD">
{{--        <div class="text-center py-10 px-2">--}}
{{--            <h2 class="text-4xl text-mainBlue"> OUR JOB OFFERS</h2>--}}
{{--            <p class="text-cancel">Delivering excellence to all areas of our focus</p>--}}
{{--        </div>--}}
{{--        @include('pages.home.partial.jobs')--}}
{{--        <div class="text-center py-10 mt-10 px-2">--}}
{{--            <h2 class="text-4xl text-mainBlue"> STUDY IN YOUR DREAM COUNTRY</h2>--}}
{{--            <p class="text-cancel">Delivering excellence to all areas of our focus</p>--}}
{{--        </div>--}}
{{--        @include('pages.home.partial.study')--}}
        <div class="flex justify-between px-10">
            <div class="mt-24 w-1/2">
                <h2 class="text-xl text-lightGreen font-bold uppercase tracking-widest">Fly For Your Perfect Job Abroad</h2>
                <hr class="my-2 h-px bg-whiteDark border-0">
                @include('components.jobFlowChart')
            </div>
            <div class="mt-10 w-1/2">
                <h2 class="text-xl text-lightBlue font-bold uppercase tracking-widest">Study In your dream University</h2>
                <hr class="my-2 h-px bg-whiteDark border-0">

                @include('components.studyFlowchart')
            </div>
        </div>

        <div class="">
            @foreach($news as $id=> $info)
                <div class="newsSection">
                    @if($info['title']!=='.')
                        <h2 style="color:#3c9b75;">{{$info['title']}}</h2>
                        {{--                    <h2 style="color:{{$id%2==0?'#19b275':'#ff5151'}};">{{$info['title']}}</h2>--}}
                    @endif
                    {!! $info['description'] !!}
                </div>
            @endforeach
        </div>
        @include('components.blogs',['articles'=>$featuredPosts])
        @include('components.getIinTouch')
    </div>
    <style>
        .newsSection {
            transform: rotate(0deg);
            text-align: center;
            padding: 4rem;
            margin: 1rem 0;
            border-bottom-right-radius: 10%;
            border-top-left-radius: 10%;
            /*background-color: rgba(255, 255, 255, 0.1)*/
        }

        blockquote {
            font-weight: 700;
            border-left: 15px solid #426c5b;
            background: rgba(114, 114, 114, 0.1);
            margin: 15px 3%;
            padding: 10px 15px
        }

        iframe {
            width: 94%;
            margin-left: 3%;
            min-height: 40vh
        }

        @media screen and (max-width: 800px) {
            .newsSection {
                padding: 0;
            }
        }

    </style>
@endsection
