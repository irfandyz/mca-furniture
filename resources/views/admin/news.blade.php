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

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.11/css/froala_editor.pkgd.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.11/js/froala_editor.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.11/js/plugins/draggable.min.js"></script>

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
            @if ($news->count() < 5)
                <div class="col-12 mb-5">
                    <div class="card hover-shadow"
                        style="border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); cursor: pointer; height: 100%; background-color: #F5F5F5;"
                        data-bs-toggle="modal" data-bs-target="#addNewsModal">
                        <div class="card-body text-center d-flex flex-column justify-content-center"
                            style="padding: 20px;">
                            <h5 class="card-title"
                                style="font-family: 'Montserrat', sans-serif; font-weight: bold; font-size: 50px; color: #4F2B00;">
                                <i class="fas fa-plus-circle"></i>
                            </h5>
                        </div>
                    </div>
                </div>
            @endif
            @foreach ($news as $item)
                <div class="col-12 mb-5">
                    <div class="card h-100 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('news/' . $item->image) }}"
                                    class="img-fluid rounded-start w-100 h-100" style="object-fit: cover;"
                                    alt="{{ $item->title }}">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h5 class="card-title mb-4">{{ $item->title }}</h5>
                                    <p class="card-text mb-4">{{ $item->description }}</p>
                                    <p class="card-text"><small class="text-muted">{{ $item->date }}
                                            {{ $item->month }} {{ $item->year }}</small></p>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                            data-bs-target="#editNewsModal"
                                            onclick="openEditNewsModal({{ $item->id }})">Edit</button>
                                        <button class="btn btn-danger"
                                            onclick="confirmDelete({{ $item->id }})">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Add News -->
    <div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="addNewsModalLabel">Add News</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ asset('admin/news/store') }}" method="POST" class="p-5"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Short Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image display</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="text" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="month" class="form-label">Month</label>
                                <input type="text" class="form-control" id="month" name="month" required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="year" class="form-label">Year</label>
                                <input type="text" class="form-control" id="year" name="year" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea name="content" id="content" cols="30" rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add News</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit News -->
    <div class="modal fade" id="editNewsModal" tabindex="-1" aria-labelledby="editNewsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="editNewsModalLabel">Edit News</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ asset('admin/news/update') }}" method="POST" class="p-5"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit-id">
                        <div class="mb-3">
                            <label for="edit-title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit-title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-description" class="form-label">Short Description</label>
                            <input type="text" class="form-control" id="edit-description" name="description"
                                required>
                        </div>
                        <div class="mb-3 text-center">
                            <img src="" class="img-fluid rounded-start w-50" style="object-fit: cover;"
                                id="edit-image-preview">
                        </div>
                        <div class="mb-3">
                            <label for="edit-image" class="form-label">Image display</label>
                            <input type="file" class="form-control" id="edit-image"
                                onchange="updateImagePreview(this)" name="image">
                        </div>
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label for="edit-date" class="form-label">Date</label>
                                <input type="text" class="form-control" id="edit-date" name="date" required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="edit-month" class="form-label">Month</label>
                                <input type="text" class="form-control" id="edit-month" name="month" required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="edit-year" class="form-label">Year</label>
                                <input type="text" class="form-control" id="edit-year" name="year" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-content" class="form-label">Content</label>
                            <textarea name="content" id="edit-content" cols="30" rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update News</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        new FroalaEditor('#content', {
            toolbarButtons: [
                ['fontSize', 'bold', 'italic', 'underline', 'strikeThrough'],
                ['alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'textColor', 'backgroundColor'],
                ['formatOLSimple', 'formatUL', 'insertLink', 'insertImage', 'insertVideo'],
            ],
            imageUploadMethod: 'POST',
            imageUploadURL: '{{ asset('admin/news/upload-media') }}?_token=' + '{{ csrf_token() }}',
            imageUploadParams: {
                _token: '{{ csrf_token() }}'
            },
            videoUploadMethod: 'POST',
            videoUploadURL: '{{ asset('admin/news/upload-media') }}?_token=' + '{{ csrf_token() }}',
            videoUploadParams: {
                _token: '{{ csrf_token() }}'
            },
        });
        new FroalaEditor('#edit-content', {
            toolbarButtons: [
                ['fontSize', 'bold', 'italic', 'underline', 'strikeThrough'],
                ['alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'textColor', 'backgroundColor'],
                ['formatOLSimple', 'formatUL', 'insertLink', 'insertImage', 'insertVideo', 'draggable'],
            ],
            pluginsEnabled: ['image', 'link', 'video'],
            imageUploadMethod: 'POST',
            imageUploadURL: '{{ asset('admin/news/upload-media') }}?_token=' + '{{ csrf_token() }}',
            imageUploadParams: {
                _token: '{{ csrf_token() }}'
            },
            videoUploadMethod: 'POST',
            videoUploadURL: '{{ asset('admin/news/upload-media') }}?_token=' + '{{ csrf_token() }}',
            videoUploadParams: {
                _token: '{{ csrf_token() }}'
            },
        });

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
                    window.location.href = '{{ asset('admin/news/') }}/' + id;
                }
            });
        }
    </script>

    <script>
        function openEditNewsModal(id) {
            $.ajax({
                url: '{{ asset('admin/news/get/') }}/' + id,
                type: 'GET',
                success: function(response) {
                    $('#edit-id').val(response.id);
                    $('#edit-title').val(response.title);
                    $('#edit-description').val(response.description);
                    $('#edit-date').val(response.date);
                    $('#edit-month').val(response.month);
                    $('#edit-year').val(response.year);
                    $('#edit-image-preview').attr('src', '{{ asset('news/') }}/' + response.image);
                    new FroalaEditor('#edit-content').html.set(response.content);
                }
            });
        }

        function updateImagePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#edit-image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire('Success', '{{ session('success') }}', 'success');
        </script>
    @endif

</body>

</html>
