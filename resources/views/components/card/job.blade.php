<div class="bg-white shadow shadow-offWhite shadow-lg mt-5 lg:ml-10 rounded rounded-md">
    <div class="md:px-14 px-4 pt-7 pb-1">
        <div class="lg:flex justify-between my-2">
            <h2 class="text-lightGreen lg:text-left text-center md:text-2xl text-xl pb-2 font-bold px-3  break-all">{{$title}}</h2>
            <a href="{{route('verify', ['id' => $code])}}"
               class="{{ $detail===true ? 'hidden' :'bg-lightGreen text-center md:text-lg font-medium hover:bg-lightBlue rounded-full px-5 py-2 text-white ml-36' }}">
                Apply
            </a>
        </div>
        <div class="inline-flex flex-wrap justify-center text-sm jobInfo">
            <img src="{{asset('assets/images/ic1.png')}}"/>
            <span class="ml-2">{{$exp_min}}- {{$exp_max}} years</span>
            <span class="mx-4">|</span>
            <img src="{{asset('assets/images/ic2.png')}}"/>
            <span class="ml-2">{{$country[0]['name']}}</span>
            <span class="mx-4">|</span>
            <img src="{{asset('assets/images/ic3.png')}}"/>
            <span class="ml-2">{{$date}}</span>
            <span class="mx-4">|</span>
            <span class="ml-2">Vacancy Code : {{$code}}</span>
        </div>
    </div>

    <div class="px-14 pb-5">
        <div class="inline-flex flex-wrap justify-center text-sm jobInfo text-lightgrey">
            <span class="underline">Job Type :</span>
            <span class="ml-2">{{$type}},</span>
            <span class="mx-2">|</span>
            <span class="underline">Industry :</span>
            <span class="ml-2"> {{$industry}},</span>
            <span class="mx-2">|</span>
            <span class="underline">Contract Length :</span>
            <span class="ml-2"> {{$length}},</span>
            <span class="mx-2">|</span>
            <span class="underline">Total Vacancy : </span>
            <span class="ml-2"> {{$vacancy}}</span>
        </div>
    </div>

    <div class="md:px-14 px-8 pb-5 lg:inline-flex justify-start sm:block">
        <p class="jobTitle">Job Description:</p>
        <p class=" font-sm jobDesc">{{$description}}</p>
    </div>
    <div class="md:px-14 px-8 pb-5 lg:inline-flex justify-start sm:block">
        <p class="jobTitle">Knowledge & Qualification:</p>
        <p class=" font-sm jobDesc"> {{$quality}}</p>
    </div>
    <div class="md:px-14 px-8 pb-4 lg:inline-flex justify-start sm:block">
        <p class="jobTitle">Role & Responsibilities:</p>
        <p class="font-sm jobDesc">{{$responsibility}}</p>
    </div>
    <div class="md:px-14 px-8 py-2 bg-lightBlue">
        <p class="text-white">Basic Salary: <span class="font-semibold">{{$salary}}</span></p>
    </div>
{{--    <ul class="flex justify-start flex-wrap gap-2 text-sm py-10">--}}
{{--        <li class="px-4 py-1 text-lightBlue tracking-widest font-bold text-lg">SHARE: </li>--}}
{{--        @foreach($shareLinks as $key=>$link)--}}
{{--            <li class="px-4 py-2 bg-lightGreen hover:bg-mainBlue text-white rounded-full"><a href="{{$link}}" target="_blank" class="pin fab fa-{{$key}}">{{$key}}</a></li>--}}
{{--        @endforeach--}}
{{--    </ul>--}}
</div>
<style>
    .jobTitle {
        font-weight: 600;
        width: 18vw;
    }

    .jobDesc {
        width: 39vw;
        font-size: 15px!important;
        /*text-align: justify;*/
    }

    @media only screen and (max-width: 600px) {
        .jobTitle {
            width: 100%;
            text-align: center;
        }

        .jobDesc {
            width: unset;
            text-align: justify;
        }
    }
</style>
