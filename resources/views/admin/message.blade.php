<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Example</title>
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
        <div class="row">
            <div class="col-12">
                <form action="{{ asset('admin/user') }}" method="get" class="mb-4">
                    <div class="input-group input-group-merge speech-to-text bg-white w-100 hover-shadow">
                        <input type="text" name="keyword" class="form-control" placeholder="Search"
                            value="{{ Request::get('keyword') }}" aria-describedby="text-to-speech-addon">
                        <button type="submit" class="btn btn-primary btn-main" style="margin-left: 10px;">
                            <i class='fas fa-magnifying-glass'></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered table-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Message</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($messages->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No messages found.</td>
                        </tr>
                    @else
                        @foreach ($messages as $message)
                            <tr>
                                <th scope="row">
                                    {{ $loop->iteration + $messages->perPage() * ($messages->currentPage() - 1) }}</th>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->phone }}</td>
                                <td>{{ $message->message }}</td>
                                <td>
                                    <form action="{{ asset('admin/message/delete/' . $message->id) }}" method="post"
                                        style="display: inline-block;" onsubmit="return confirmDelete(event, this);">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-5 mb-5">
                {{ $messages->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    </div>



    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 200
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>

    <script>
        function confirmDelete(event, form) {
            event.preventDefault(); // Prevent the form from submitting immediately
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
                    form.submit(); // Submit the form if confirmed
                }
            });
        }
    </script>

    <script>
        function openEditModal(id, name, email) {
            $('#editUserModal').modal('show');
            $('#editUserId').val(id);
            $('#editUserName').val(name);
            $('#editUserEmail').val(email);
        }
    </script>

    @yield('custom-js')

</body>

</html>
