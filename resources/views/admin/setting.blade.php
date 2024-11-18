<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ App\Models\Setting::first()->title }}

    </title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/custom/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icon/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

</head>

<body>

    @include('admin.navbar')


    <div class="container mt-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="container card p-5 mb-5 rounded">
            <h4 class="text-center mb-3">Setting Website</h4>
            <form action="{{ asset('admin/setting/update') }}" method="POST" enctype="multipart/form-data" class="mb-3">

            @csrf
            <img src="{{ asset('logos/' . $settings->logo) }}" alt="Logo" id="logo-img" class="img-fluid mt-3 mb-3" style="width: 100px;">
            <div class="form-group mb-3">
                <label for="logo">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $settings->title }}">
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $settings->email }}">
            </div>

            <div class="form-group mb-3">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $settings->phone }}">
            </div>

            <div class="form-group mb-3">
                <label for="address">Address</label>
                <textarea name="address" class="form-control">{{ $settings->address }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="linkedin">Linkedin</label>
                <input type="text" name="linkedin" class="form-control" value="{{ $settings->linkedin }}">
            </div>

            <div class="form-group mb-3">
                <label for="facebook">Facebook</label>
                <input type="text" name="facebook" class="form-control" value="{{ $settings->facebook }}">
            </div>


            <div class="form-group mb-3">
                <label for="instagram">Instagram</label>
                <input type="text" name="instagram" class="form-control" value="{{ $settings->instagram }}">
            </div>

            <div class="form-group mb-3">
                <label for="twitter">Twitter</label>
                <input type="text" name="twitter" class="form-control" value="{{ $settings->twitter }}">
            </div>

            <div class="form-group mb-3">
                <label for="youtube">Youtube</label>
                <input type="text" name="youtube" class="form-control" value="{{ $settings->youtube }}">
            </div>

            <div class="form-group mb-3">
                <label for="meta_description">Meta Description</label>
                <input type="text" name="meta_description" class="form-control" value="{{ $settings->meta_description }}">
            </div>

            <div class="form-group mb-3">
                <label for="meta_author">Meta Author</label>
                <input type="text" name="meta_author" class="form-control" value="{{ $settings->meta_author }}">
            </div>

            <div class="form-group mb-3">
                <label for="copyright">Copyright</label>
                <input type="text" name="copyright" class="form-control" value="{{ $settings->copyright }}">
            </div>

                <button type="submit" class="btn btn-primary mt-4 w-25">Save</button>
            </form>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    @if (session('success'))
        <script>
            Swal.fire('Success', '{{ session('success') }}', 'success');
        </script>
    @endif

    <script>
        document.getElementById('logo').addEventListener('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logo-img').src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });
    </script>
    @yield('custom-js')

</body>

</html>
