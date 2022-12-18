<div class="py-5 lg:mt-20">
    <h2 class="text-lightGreen font-bold text-4xl tracking-widest text-center">Choose Your Country</h2>
    <hr class="my-3 h-px bg-whiteDark border-0 ">
    <div class="grid lg:grid-cols-2 lg:px-52 md:px-24 countryGrid">
        <a href="{{route('study', ['country'=>'usa'])}}" class="overflow-hidden">
            <img src="{{asset('assets/images/us.jpg')}}" alt=""/>
            <p class="text-center font-bold text-mainBlue tracking-widest">USA</p>
        </a>
        <a href="{{route('study', ['country'=>'uk'])}}" class="overflow-hidden">
            <img src="{{asset('assets/images/uk.png')}}" alt="" />
            <p class="text-center font-bold text-mainBlue tracking-widest">UK</p>
        </a>
        <a href="{{route('study', ['country'=>'australia'])}}" class="overflow-hidden">
            <img src="{{asset('assets/images/aust.jpg')}}" alt="" />
            <p class="text-center font-bold text-mainBlue tracking-widest">Australia</p>
            {{--            <span class="hideDiv mt-2 float-right">Australia</span>--}}
        </a>
        <a href="{{route('study', ['country'=>'canada'])}}" class="overflow-hidden">
            <img src="{{asset('assets/images/cana.jpg')}}" alt="" />
            <p class="text-center font-bold text-mainBlue tracking-widest">Canada</p>
        </a>
    </div>
</div>

<style>
    .countryGrid img {
        width: 100%; height: 200px; padding: 5px; object-fit: cover;transition: all .4s;
    }
    .countryGrid img:hover{
        scale: 1.3;
    }
    .hideDiv{
        display: none;
    }
    .countryGrid img:hover + .hideDiv{
        display: block;
    }
</style>
