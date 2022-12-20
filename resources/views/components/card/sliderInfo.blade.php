<div class="carousel-item {{ $key ===  0 ? "active" : ''}}">
    <div style="width: 100%; background-color: #737373;height: 45vh;">
        <img src="{{$image}}" alt="{{$title}}"
             style="width: 100vw; height: 45vh; object-fit: cover;box-shadow: 2px 2px 16px 2px rgba(0,0,0,0.5);
         filter: sepia(30%)"
        />
    </div>
    <hr/>
    <a href="#">
        <div class="carousel-caption ">
            <div class="carouselCaptions">
                <h5 style=" margin-bottom: 10px">{{$title}}</h5>
            </div>
        </div>
    </a>
</div>
