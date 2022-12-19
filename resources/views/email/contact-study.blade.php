{{--@component('mail::message')--}}
{{--    <h2>Hello Admin,</h2>--}}
{{--    <p>You received an email from : <b>{{ $data['name'] }}</b></p>--}}
{{--    <p>Here are the details:</p>--}}
{{--    <b>Name:</b> {{ $data['name'] }} <br>--}}
{{--    <b>Email:</b> {{ $data['email'] }} <br>--}}
{{--    <b>Subject:</b> {{ $data['subject'] }} <br>--}}
{{--    <b>Message:</b> <br/> {!! nl2br($data['message']) !!}--}}
{{--    <br/>--}}

{{--    -  Thank You, {{ env('APP_NAME') }}--}}
{{--@endcomponent--}}

<h2 style="color: black!important;">{{$hello}}</h2>

<p style="font-size: 13px; font-weight: 500;color: #1e1862!important;">{{$name}} is Interested in studying abroad.They are seeking contact.</p>
<hr/>

<p style="font-size: 16px; font-weight: 500;color: #212121!important;">
    their phone number: {{$phone}}
{{--    <span><a style="font-size: 14px; color: #18099d" href="{{$link}}">{{$link}}</a></span>--}}
</p>
<p style="font-size: 16px; font-weight: 500;color: #363636!important;">
    their whatsapp number: {{$whatsapp}}
{{--    <span><a style="font-size: 14px; color: #18099d" href="{{$link}}">{{$link}}</a></span>--}}
</p>
{{--<p style="font-size: 13px; font-weight: 500; color: #042c06">{{$contact}} {{ $email }}</p>--}}

{{--<br/><br/><br/>--}}
{{--<p style="font-size: 16px; font-weight: 500; color: #3d040b"> {!! nl2br($body_bn) !!}--}}
{{--    <span><a style="font-size: 14px; color: #18099d" href="{{$link_bn}}">{{$link_bn}}</a></span>--}}
{{--</p>--}}

<p style="font-size: 13px; font-weight: 500;">Contact with {{$name}}: {{ $email }} </p>  <br>

<br/>
-  {{'Thanks'}}, {{ env('APP_NAME') }}

