<section class="news py-5 my-5" id="news" data-aos="fade-up">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-about-us-title">\ News \</h2>
            </div>
        </div>

        <div class="row">
            @foreach (App\Models\News::all() as $item)
            <div class="col-12 mb-5" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset('news/' . $item->image) }}" class="img-fluid rounded-start w-100 h-100" style="object-fit: cover;" alt="{{ $item->title }}">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-4">{{ $item->title }}</h5>
                                <p class="card-text mb-4">{{ $item->description }}</p>
                                <p class="card-text"><small class="text-muted">{{ $item->date }} {{ $item->month }} {{ $item->year }}</small></p>
                                @if ($item->content)
                                <a href="{{ asset('news/' . $item->id) }}" class="text-decoration-none mt-3">View Detail <i class="fa-solid fa-arrow-right"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
