<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mandiri Cipta Adikarya</title>
    <meta name="description" content="Mandiri Cipta Adikarya is a leading company in the field of furniture manufacturing, offering a wide range of high-quality products for home and office use.">
    <meta name="author" content="CV. Mandiri Cipta Adikarya">

    <link rel="icon" href="{{ asset('assets/img/logo/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/custom/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icon/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />


</head>

<body>


    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg" style="width: 400px; border-radius: 20px;">
            <div class="card-body p-5">
                <img src="{{ asset('logos/' . App\Models\Setting::first()->logo) }}" alt="Logo" class="d-block mx-auto mb-4"
                    style="width: 150px">
                @error('email')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
                <form action="{{ asset('login/auth') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" style="font-size: 14px;"
                            class="form-control rounded p-2 @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" style="font-size: 14px;"
                            class="form-control rounded p-2 @error('email') is-invalid @enderror" id="password"
                            name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-main mt-3 mb-4 rounded-pill w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
