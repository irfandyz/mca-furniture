<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ App\Models\Setting::first()->title }}</title>
    <meta name="description" content="Mandiri Cipta Adikarya is a leading company in the field of furniture manufacturing, offering a wide range of high-quality products for home and office use.">
    <meta name="author" content="CV. Mandiri Cipta Adikarya">

    <link rel="icon" href="{{ asset('assets/img/logo/logo.png') }}" type="image/png">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/custom/style.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/icon/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="transition: all 0.3s ease;">
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
                        <a class="nav-link px-3" href="{{ asset('/') }}#about" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                            About Us
                            <span class="hover-line" style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background-color: #000; transition: width 0.3s ease;"></span>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link px-3" href="{{ asset('/') }}#product" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                            Product
                            <span class="hover-line" style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background-color: #000; transition: width 0.3s ease;"></span>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link px-3" href="{{ asset('/') }}#service" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                            Service
                            <span class="hover-line" style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background-color: #000; transition: width 0.3s ease;"></span>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link px-3" href="{{ asset('/') }}#news" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                            News
                            <span class="hover-line" style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background-color: #000; transition: width 0.3s ease;"></span>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link px-3" href="{{ asset('/') }}#contact" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                            Contact Us
                            <span class="hover-line" style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background-color: #000; transition: width 0.3s ease;"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container p-5">
        {!! $news->content !!}
    </div>

    @include('footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

</body>

</html>
