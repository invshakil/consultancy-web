@extends('master')
@section('content')
    <div class="lg:px-52 px-6 lg:flex lg:justify-around" style="padding-top: 15vh">
        <div class="lg:w-2/3 w-full">
            <h2 class="capitalize text-mainBlue border px-4 py-3 mb-4 border-y-0 border-r-0 border-l-8 border-l-lightGreen shadow-lg shadow-offWhite lg:text-4xl text-xl">{{$article['title']}}</h2>
            <hr/>
            <br/>
            <div class=" text-justify">
                {!! $article['description'] !!}
            </div>
            <br/>
            <hr/>
            <br/>
            @include('pages.articleDetail.partial.disquss')
        </div>
        <div class="lg:w-1/3 w-full lg:ml-16">
            <div class="lg:fixed relative" style="overflow-y: scroll; height: 80vh;">
                <h2 class="text-3xl text-lightGreen" style="margin-top: 1vh;" >Similar Articles</h2>
                <hr style="width: 70%;"/>
                @foreach($similarArticles as $sArticle)
                    <div class="mt-5">
                        <a href="{{ route('article-details', ['slug' =>  $sArticle['slug']]) }}" >
                            <img src="{{asset($sArticle['image'])}}" class="lg:w-8/12 w-full" style="height: 20vh;border-radius: 6px; object-fit: cover; box-shadow: 2px 5px 7px 2px #383838;" alt=""/>
                            <h2 class="capitalize text-xs mt-2">{{$sArticle['categories'][0]['name']}}</h2>
                            <div class="flex justify-between lg:w-8/12 w-full" >
                                <h4 class="capitalize text-right text-lg tracking-wide font-bold text-mainBlue mb-2">{{$sArticle['title']}}</h4>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
