<div id="carouselExample" class="carousel slide carousel-fade" data-ride="carousel" data-interval="5000">
    <div class="carousel-inner">
        @foreach ($sliders as $slider)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img src="{{ asset('sliders/' . $slider->image) }}" class="d-block w-100" alt="Slide">
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<style>

</style>
