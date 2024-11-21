@php
    use App\Models\Faq;
@endphp

@if (Faq::all()->count() > 0)
<section class="our-expertise mt-5" data-aos="fade-up" id="service">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-about-us-title">\ FAQ \</h2>
            <h3 class="section-about-us-subtitle">Frequently Asked Questions</h3>
        </div>

        <div class="row">
            @foreach (Faq::all() as $faq)
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="expertise-card">
                        <h4>{{ $faq->question }}</h4>
                        <p>{!! $faq->answer !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </section>
@endif
