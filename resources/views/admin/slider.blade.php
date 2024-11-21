<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ App\Models\Setting::first()->title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/custom/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icon/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        .position-relative {
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .position-relative:hover .overlay {
            opacity: 1;
        }
    </style>
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
        <div class="row">
            @foreach ($sliders as $slider)
                <div class="col-6 mb-4 position-relative">
                    <img src="{{ asset('sliders/' . $slider->image) }}" alt="Slider {{ $slider->id }}"
                        class="img-fluid w-100">
                    <div class="overlay d-flex justify-content-center align-items-center">
                        <button class="btn btn-warning me-2"
                            onclick="openEditModal({{ $slider->id }}, '{{ $slider->image }}')">Edit</button>
                        <button class="btn btn-danger" onclick="confirmDelete({{ $slider->id }})">Delete</button>
                    </div>
                </div>
            @endforeach
            @if ($sliders->count() < 4)
                <div class="col-sm-6 mt-3 mb-5" data-bs-toggle="modal" data-bs-target="#addSliderModal">
                    <div class="card hover-shadow"
                        style="border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); cursor: pointer; height: 100%; background-color: #F5F5F5;"
                        data-bs-toggle="modal" data-bs-target="#addSliderModal">
                        <div class="card-body text-center d-flex flex-column justify-content-center"
                            style="padding: 20px;">
                            <h5 class="card-title"
                                style="font-family: 'Montserrat', sans-serif; font-weight: bold; font-size: 50px; color: #4F2B00;">
                                <i class="fas fa-plus-circle"></i>
                            </h5>
                        </div>
                    </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="addSliderModal" tabindex="-1" aria-labelledby="addSliderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSliderModalLabel">Add New Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSliderForm" action="{{ asset('admin/slider/store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <img src="" alt="Slider Image Preview" id="sliderImagePreview"
                                class="img-fluid w-100">
                        </div>
                        <div class="mb-3">
                            <label for="sliderImage" class="form-label">Slider Image</label>
                            <input type="file" class="form-control" id="sliderImage" name="image" accept="image/*"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Slider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSliderModal" tabindex="-1" aria-labelledby="editSliderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSliderModalLabel">Edit Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSliderForm" action="{{ asset('admin/slider/update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="editSliderId" name="id">
                        <div class="mb-3">
                            <img src="" alt="Slider Image Preview" id="editSliderImagePreview"
                                class="img-fluid w-100">
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control" id="editSliderImage" name="image"
                                accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Slider</button>
                    </form>
                </div>
            </div>
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
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ asset('admin/slider/') }}/' + id;
                }
            });
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire('Success', '{{ session('success') }}', 'success');
        </script>
    @endif

    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 200
        });
    </script>
    <script>
        document.getElementById('sliderImage').addEventListener('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('sliderImagePreview').src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });

        document.getElementById('editSliderImage').addEventListener('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('editSliderImagePreview').src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });
    </script>
    <script>
        let lastScrollTop = 0;
        const navbar = document.querySelector('.navbar');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop) {
                navbar.style.top = "-80px"; // Hide navbar on scroll down
            } else {
                navbar.style.top = "0"; // Show navbar on scroll up
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For Mobile or negative scrolling
        });
    </script>

    <script>
        function openEditModal(id, image) {
            $('#editSliderModal').modal('show');
            $('#editSliderId').val(id);
            $('#editSliderImagePreview').attr('src', '{{ asset('sliders/') }}/' + image);
        }
    </script>

    @yield('custom-js')

</body>

</html>
