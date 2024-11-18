<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white shadow-sm" style="transition: all 0.3s ease;">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('logos/' . App\Models\Setting::first()->logo) }}" alt="Logo" style="height: 45px; transition: transform 0.3s ease;">
        </a>
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav text-center">
                <li class="nav-item mx-2">
                    <a class="nav-link px-3" href="#about" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                        About Us
                        <span class="hover-line" style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background-color: #000; transition: width 0.3s ease;"></span>
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link px-3" href="#product" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                        Product
                        <span class="hover-line" style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background-color: #000; transition: width 0.3s ease;"></span>
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link px-3" href="#service" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                        Service
                        <span class="hover-line" style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background-color: #000; transition: width 0.3s ease;"></span>
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link px-3" href="#news" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                        News
                        <span class="hover-line" style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background-color: #000; transition: width 0.3s ease;"></span>
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link px-3" href="#contact" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                        Contact Us
                        <span class="hover-line" style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background-color: #000; transition: width 0.3s ease;"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY === 0) {
        navbar.style.position = 'relative';
        navbar.style.backgroundColor = 'transparent';
        navbar.style.boxShadow = 'none';
    } else {
        navbar.style.position = 'fixed';
        navbar.style.backgroundColor = 'white';
        navbar.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
    }
});
</script>
