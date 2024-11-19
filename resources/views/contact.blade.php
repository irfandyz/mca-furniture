<section class="contact" id="contact" data-aos="fade-up" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4 mb-lg-5" data-aos="fade-up" data-aos-delay="100">
                <h2 class="section-about-us-title">\ Contact Us \</h2>
                <p class="px-2">Get in touch with us. We'd love to hear from you.</p>
            </div>
        </div>

        <div class="row justify-content-between">
            <div class="col-12 col-md-6 mb-4 mb-lg-0" data-aos="fade-right" data-aos-delay="200">
                <div class="contact-form p-4 bg-white rounded shadow-sm">
                    <h4 class="mb-4">Let's Chat</h4>
                    <form action="{{ asset('contact') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="tel" class="form-control form-control-lg" placeholder="Phone" name="phone">
                        </div>
                        <div class="form-group mb-4">
                            <textarea class="form-control form-control-lg" rows="5" placeholder="Message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark px-4 py-2 w-100 w-sm-auto">Send Now</button>
                    </form>
                </div>
            </div>

            <div class="col-12 col-md-5" data-aos="fade-left" data-aos-delay="300">
                <div class="contact-info p-4 bg-light rounded">
                    <h4 class="mb-4">Contact Us</h4>

                    <div class="d-flex mb-3 align-items-start">
                        <i class="fas fa-phone-alt mt-1 me-3"></i>
                        <div>
                            <h6 class="mb-1">Phone</h6>
                            <p class="mb-0">{{ App\Models\Setting::first()->phone }}</p>
                        </div>
                    </div>

                    <div class="d-flex mb-3 align-items-start">
                        <i class="fas fa-envelope mt-1 me-3"></i>
                        <div>
                            <h6 class="mb-1">Email</h6>
                            <p class="mb-0 text-break">{{ App\Models\Setting::first()->email }}</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4 align-items-start">
                        <i class="fas fa-map-marker-alt mt-1 me-3"></i>
                        <div>
                            <h6 class="mb-1">Address</h6>
                            <p class="mb-0">{{ App\Models\Setting::first()->address }}</p>
                        </div>
                    </div>

                    <h6 class="mb-3">Follow Us</h6>
                    <div class="social-links d-flex align-items-center">
                        <a href="{{ App\Models\Setting::first()->linkedin }}" class="social-icon me-3 mb-2 transition-all hover-lift">
                            <i class="fab fa-linkedin-in fa-lg"></i>
                        </a>
                        <a href="{{ App\Models\Setting::first()->facebook }}" class="social-icon me-3 mb-2 transition-all hover-lift">
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                        <a href="{{ App\Models\Setting::first()->instagram }}" class="social-icon me-3 mb-2 transition-all hover-lift">
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                        <a href="{{ App\Models\Setting::first()->twitter }}" class="social-icon me-3 mb-2 transition-all hover-lift">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="{{ App\Models\Setting::first()->youtube }}" class="social-icon me-3 mb-2 transition-all hover-lift">
                            <i class="fab fa-youtube fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="map" data-aos="fade-up" data-aos-delay="400">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mt-5">
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <div class="mapouter">
                            <div class="gmap_canvas">
                                <iframe src="{{ App\Models\Setting::first()->map }}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



