<!DOCTYPE html>
<html lang="en" class="js">
<head>
    <!-- Fav Icon  -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="alternate" href="{{ Request::url() }} hreflang={{str_replace('_', '-', app()->getLocale())}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/flowbite.css') }}" rel="stylesheet">
    <link href="{{ asset('css/intlTelInput.css') }}" rel="stylesheet">
{{--    <script src="https://cdn.tailwindcss.com"></script>--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Site Title  -->
    {!! SEO::generate() !!}
    <meta itemprop="publisher" content="Career Challengers"/>
    <meta itemprop="author" content="Masum Billa"/>
    <meta itemprop="author" content="মাসুম বিল্লাহ"/>
</head>
<body class="bg-offWhite text-text" style="background: linear-gradient(40deg, #ffffff, #d7d7d7, #cad9d1);font-family: Roboto, sans-serif; overflow-x: hidden!important;">
@include('layouts.navigation')
<div>
    @yield('content')
</div>
@include('layouts.footer')

<!-- JavaScript -->
<script defer src="{{ asset('assets/js/scripts.js') }}"></script>
<script defer src="{{ asset('js/flowbite.js') }}"></script>

@yield('scripts')

</body>
</html>

