@extends('master')
@section('content')
    <div class="px-20 lg:flex lg:justify-around text-justify" style="padding: 15vh 15% 0 15%">
        <div class="w-2/3">
            <h2 class="capitalize text-mainBlue border px-4 py-1 mb-4 border-y-0 border-r-0 border-l-8 border-l-lightGreen shadow-lg shadow-offWhite text-4xl">{{$article['title']}}</h2>
            <hr/>
            <br/>
            {!! $article['description'] !!}
            <br/>
            <hr/>
            <br/>
            @include('pages.articleDetail.partial.disquss')
        </div>
        <div class="w-32 lg:ml-16">
            <div class="fixed" style="overflow-y: scroll; height: 80vh;">
                <h2 class="text-2xl" style="margin-top: 1vh;" >Similar Articles</h2>
                <hr style="width: 70%;"/>
                @foreach($similarArticles as $sArticle)
                    <div class="mt-5">
                        <a href="{{ route('article-details', ['slug' =>  $sArticle['slug']]) }}" >
                            <img src="{{asset($sArticle['image'])}}" style="height: 20vh;width: 70%;border-radius: 6px; object-fit: cover; box-shadow: 2px 5px 7px 2px #383838;" alt=""/>
                            <h2 class="capitalize text-xs mt-2">{{$sArticle['categories'][0]['name']}}</h2>
                            <div class="flex justify-between" style="width: 70%;">
                                <h2 class="capitalize text-right tracking-wide font-bold text-mainBlue mb-2">{{$sArticle['title']}}</h2>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
