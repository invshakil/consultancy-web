@extends('master')
@section('content')
    <div style="padding-top: 15vh">
        <div class="lg:px-32 px-5 text-center">
            <h2 class="text-lightGreen tracking-widest font-bold text-4xl">Career Challengers Blog</h2>
            {{--        <hr/>--}}
            <div class="grid py-10 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-2">
                @foreach($publishedArticles as $key=> $article)
                    <div class="text-left ">
                        <div class=" p-4 rounded-md border border-1 border-whiteDark">
                            <a href="{{route('article-details', ['slug'=>$article['slug']])}}">
                                <img src="{{asset($article['image'])}}" width="100%" alt=""
                                     class="mb-2 object-cover rounded-lg" style="height: 250px;"/>
                                <p class="text-lightGreen text-sm">{{$article['categories'][0]['name']}}</p>
                                <h2 class="text-lg py-2 font-bold text-gray-500 tracking-tighter">{{$article['title']}}</h2>
                                <div class="flex justify-between">
                                    <h2 class="text-xs">{{$article['created_at']->format('d/m/Y')}}</h2>
                                    <a href="{{ route('article-details', ['slug' =>  $article['slug']]) }}"
                                       class="inline-flex items-center font-medium text-lightGreen hover:underline">
                                        Read more
                                        <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                  d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center items-center content-center py-6">
                {!! $publishedArticles->links() !!}
            </div>

            <div class="py-4 px-4 mx-auto max-w-screen-xl lg:pb-16 lg:px-6">
                <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
                    <h2 class="mb-4 text-3xl lg:text-4xl font-bold text-lightGreen tracking tracking-widest">Featured Posts</h2>
                </div>
                @include('components.card.blogs',['articles'=>$featuredArticles])
                <div/>
            </div>

            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:pb-16 lg:px-6">
                <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
                    <h2 class="mb-4 text-3xl lg:text-4xl font-bold text-lightGreen">Most Read Posts</h2>
                </div>
                @foreach($mostReadArticles as $article)
                    <div class="py-4">
                        <h2 class="text-3xl tracking-tighter text-gray-500">{{$article['title']}}</h2>
                        <p class="font-light text-gray-500 dark:text-gray-400">{{str_limit($article['excerpt'], 300)}}</p>
                        <a href="{{ route('article-details', ['slug' =>  $article['slug']]) }}"
                           class="inline-flex items-center font-medium text-lightGreen hover:underline">
                            Read more
                            <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                @endforeach
                <div/>
            </div>
        </div>
        </div>
@endsection
