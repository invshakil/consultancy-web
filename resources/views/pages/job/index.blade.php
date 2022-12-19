@extends('master')

@section('content')
    {{--    <div class="fixed right-0" style="left:89.85vw; top:30vh;">--}}
    {{--        <a href="{{route('upload-cv')}}">--}}
    {{--            <button class="rotate-90 bg-lightGreen text-offWhite w-52 h-12">Submit Resume Here</button>--}}
    {{--        </a>--}}
    {{--    </div>--}}
    <div class="text-center md:px-16 px-2 py-6">
        {{--        {{$jobs[0]}}--}}
        {{--            FILTER--}}
        <form class="grid lg:grid-cols-10 sm:grid-cols-4 gap-5 px-5 bg-mainBlue py-2 rounded rounded-md"
              style="margin-top:10vh"
        >
            <input name="search" required class="p-3 lg:col-span-3 sm:col-span-4" type="search"
                   placeholder="* Job Industry..."/>

            <select name="country[]" class="bg-white p-3 col-span-2">
                <option value="all" selected>--Location--</option>
                @foreach($countries as $country)
                    <option value="{{$country['id']}}">{{$country['name']}}</option>
                @endforeach
            </select>

            <select name="exp" class="bg-white p-3 col-span-2">
                <option value="all" selected>--Experience--</option>
                <option value="0-3">0-3 Years</option>
                <option value="3-6">3-6 years</option>
                <option value="6-9">6-9 years</option>
                <option value="9-12">9-12 years</option>
                <option value="12-15">12-15 years</option>
                <option value="15-18">15-18 years</option>
                <option value="18-21">18-21 years</option>
                <option value="21-24">21-24 years</option>
                <option value="24-27">24-27 years</option>
                <option value="27-30">27-30 years</option>
            </select>

            <select name="type[]" class="bg-white p-3 col-span-2">
                <option value="all" selected>--Collar--</option>
                <option value="Stuff">Blue Collar</option>
                <option value="Worker">White Collar</option>
            </select>

            <button class="bg-lightGreen px-3 lg:col-span-1 sm:col-span-2 text-white" type="submit">
                <img src="{{asset('assets/images/search.png')}}"
                     style="margin: auto; width: 30px; height: 30px; object-fit: contain" alt=""/>
            </button>
        </form>
        {{--            FILTER--}}
        {{--            FILTER--}}
        <div class="lg:flex justify-between md:block py-10">
            <form name="autoSubmitForm" id="autoSubmitForm" class="lg:w-3/12 md:w-screen lg:mr-3 mb-5 ">
                <div class="bg-mainBlue px-4 py-5">
{{--                    <p class="text-lightGreen font-bold text-lightGreen text-sm bg-mainBlue py-2">Select Desired Filters, Then Apply</p>--}}
{{--                    <hr/>--}}
{{--                    <br/>--}}
                    <div class="flex text-white justify-between">
                        <p type="submit" class="rounded-full px-5 py-2">Filter</p>
                        <a href="{{route('job')}}" class="rounded-full bg-lightBlue px-3 py-2">Clear All</a>
                    </div>
                    <div class="bg-white text-left px-4 py-5 my-4">
                        <h3>Locations</h3>
                        <hr class="my-2"/>
                        @foreach($countries as $country)
                            <section>
                                <input id="autoForm" name="country[]" value="{{$country['id']}}"
                                       class="regular-checkbox" type="checkbox"/>
                                <label>{{$country['name']}}</label>
                            </section>
                        @endforeach
                    </div>
                    <div class="bg-white text-left px-4 py-5 my-4">
                        <h3>Job Type</h3>
                        <hr class="my-2"/>
                        <section>
                            <input id="autoForm" name="type[]" value="Worker"
                                   class="regular-checkbox" type="checkbox"/>
                            <label>Worker</label>
                        </section>
                        <section>
                            <input id="autoForm" name="type[]" value="Stuff"
                                   class="regular-checkbox" type="checkbox"/>
                            <label>Stuff</label>
                        </section>
                    </div>
                    <div class="bg-white text-left px-4 py-5 my-4">
                        <h3>Industries</h3>
                        <hr class="my-2"/>
                        @foreach($industries as $industry)
                            <section>
                                <input name="industry[]" id="autoForm" value="{{$industry['title']}}"
                                       class="regular-checkbox" type="checkbox"/>
                                <label>{{$industry['title']}}</label>
                            </section>
                        @endforeach
                    </div>
                    <div class="bg-white text-left px-4 py-5 my-4">
                        <h3>Contract Length</h3>
                        <hr class="my-2"/>
                        <section>
                            <input id="autoForm" name="length[]" value=0 class="regular-checkbox"
                                   type="checkbox"/>
                            <label>Non Limited</label>
                        </section>
                        <section>
                            <input name="length[]" id="autoForm" value=1 class="regular-checkbox"
                                   type="checkbox"/>
                            <label>1 Month</label>
                        </section>
                        <section>
                            <input name="length[]" id="autoForm" value="2" class="regular-checkbox"
                                   type="checkbox"/>
                            <label>2 Months</label>
                        </section>
                        <section>
                            <input name="length[]" id="autoForm" value="3" class="regular-checkbox"
                                   type="checkbox"/>
                            <label>3 Months</label>
                        </section>
                        <section>
                            <input name="length[]" id="autoForm" value="6" class="regular-checkbox"
                                   type="checkbox"/>
                            <label>6 Months</label>
                        </section>
                        <section>
                            <input name="length[]" id="autoForm" value="12" class="regular-checkbox"
                                   type="checkbox"/>
                            <label>12 Months</label>
                        </section>
                        <section>
                            <input name="length[]" id="autoForm" value="18" class="regular-checkbox"
                                   type="checkbox"/>
                            <label>18 Months</label>
                        </section>
                        <section>
                            <input name="length[]" id="autoForm" value="24" class="regular-checkbox"
                                   type="checkbox"/>
                            <label>24 Months</label>
                        </section>
                        <section>
                            <input name="length[]" id="autoForm" value="36" class="regular-checkbox"
                                   type="checkbox"/>
                            <label>36 Months</label>
                        </section>
                    </div>
                </div>
            </form>
            {{--            FILTER--}}
            {{--            JOB--}}
            <div class="lg:w-9/12 md:w-screen text-left">
                @if(count($requestedCountries)>0)
                    <p class="ml-10">Showing <span class="text-lightGreen">{{count($jobs)}}</span> Out Of <span
                            class="text-lightGreen">{{$jobs->total()}}</span> Job @if($jobs->total()>1) 's @endif
                        in @foreach($requestedCountries as $job){{$job}}, @endforeach
                    </p>
                @endif
                @if(count($jobs) > 0)
                    @foreach($jobs as $job)
                        @include('components.card.job',
                            [
                                'title'=>$job['title'],
                                'slug' => $job['slug'],
                                'quality' => $job['quality'],
                                'description' => $job['description'],
                                'country' => $job['country'],
                                'industry' => $job['industry'],
                                'salary' => $job['salary'],
                                'responsibility' => $job['responsibility'],
                                'vacancy' => $job['vacancy'],
                                'length' => $job['length'],
                                'exp_min' => $job['exp_min'],
                                'exp_max' => $job['exp_max'],
                                'code' => $job['id'],
                                'date' => $job['created_at'],
                                'type' => $job['type'],
                            ])
                    @endforeach
                @else
                    @include('components.noData')
                @endif
            </div>
            {{--            JOB--}}
        </div>
        <div class="flex justify-center items-center content-center">
            {!! $jobs->links() !!}
        </div>
    </div>

    <script>
        function debounce(callback, wait) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(function () { callback.apply(this, args); }, wait);
            };
        }
        let myInput = document.getElementById('autoSubmitForm');
        myInput.addEventListener('input', debounce( () => {
            document.autoSubmitForm.submit()
        }, 4000))

    </script>

    <style>
        .regular-checkbox {
            -webkit-appearance: none;
            background-color: #fafafa;
            border: 1px solid #16182f;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
            padding: 9px;
            border-radius: 3px;
            display: inline-block;
            position: relative;
        }

        .regular-checkbox:active, .regular-checkbox:checked:active {
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .regular-checkbox:checked {
            background-color: #16182f;
            border: 1px solid #16182f;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05), inset 15px 10px -12px rgb(88, 227, 172, .1);
            /*color: #19b275;*/
        }

        .regular-checkbox:checked:after {
            content: '\2713';
            font-size: 14px;
            position: absolute;
            top: 0px;
            left: 3px;
            color: #19b275;
        }

        .jobInfo img {
            height: 15px;
            width: 15px;
            object-fit: contain;
        }
    </style>
@endsection
