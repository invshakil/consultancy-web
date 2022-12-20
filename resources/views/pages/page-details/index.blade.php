@extends('master')
@section('content')
    <div class="lg:px-52 md:px-10" style="padding-top: 15vh; min-height: 100vh; text-align: unset!important; font-size: unset!important;">
        <h2 class="text-center text-3xl text-lightGreen tracking-widest">{{$page['title']}}</h2>
        <hr class="h-px bg-whiteDark border-0 my-2"/>
        {!! $page['description'] !!}
    </div>
@endsection
