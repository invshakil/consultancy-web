<div class="bg-white shadow shadow-offWhite shadow-lg mt-5 lg:ml-10 rounded rounded-md">
    <div class="md:px-14 px-4 pt-7 pb-1">
        <div class="lg:flex justify-between my-2">
            <h2 class="text-lightGreen md:text-2xl text-xl pb-2 font-bold px-3 w-screen break-all">{{$title}}</h2>
            <a href="{{route('verify', ['id' => $code])}}"
               class="bg-lightGreen text-center md:text-lg font-medium rounded-full px-5 py-2 text-white ml-32">
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
        <h2 class="jobTitle">Job Description:</h2>
        <p class=" font-sm jobDesc">{{$description}}</p>
    </div>
    <div class="md:px-14 px-8 pb-5 lg:inline-flex justify-start sm:block">
        <h2 class="jobTitle">Knowledge & Qualification:</h2>
        <p class=" font-sm jobDesc"> {{$quality}}</p>
    </div>
    <div class="md:px-14 px-8 pb-4 lg:inline-flex justify-start sm:block">
        <h2 class="jobTitle">Role & Responsibilities:</h2>
        <p class="font-sm jobDesc">{{$responsibility}}</p>
    </div>
    <div class="md:px-14 px-8 py-2 bg-lightBlue">
        <p class="text-tahiti">Basic Salary: <span class="font-semibold">{{$salary}}</span></p>
    </div>
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
