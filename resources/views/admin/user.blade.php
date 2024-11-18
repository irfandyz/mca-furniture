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
            <div class="col-3">
                <button type="button" class="btn btn-success w-100" data-bs-toggle="modal"
                    data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus"></i> Add User
                </button>
            </div>
            <div class="col-9">
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

        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="addUserForm" action="{{ asset('admin/user/store') }}" method="post">
                            @csrf
                            <h5>Add User</h5>
                            <div class="mb-3 mt-5">
                                <label for="userName" class="form-label">User Name</label>
                                <input type="text" class="form-control rounded-3" id="userName" name="name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="userEmail" class="form-label">Email</label>
                                <input type="email" class="form-control rounded-3" id="userEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="userPassword" class="form-label">Password</label>
                                <input type="password" class="form-control rounded-3" id="userPassword" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="userRole" class="form-label">Role</label>
                                <select name="role" id="userRole" class="form-select rounded-3">
                                    <option value="admin">Admin</option>
                                    <option value="superadmin">Super Admin</option>
                                </select>
                            </div>
                            <div class="mt-5">
                                <button type="submit" form="addUserForm" class="btn btn-success">Add</button>
                                <button type="button" class="btn btn-secondary btn-main"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="editUserForm" method="post" action="{{ asset('admin/user/update') }}">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" id="editUserId">
                            <h5>Edit User</h5>
                            <div class="mb-3 mt-5">
                                <label for="editUserName" class="form-label">User Name</label>
                                <input type="text" class="form-control rounded-3" id="editUserName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="editUserEmail" class="form-label">Email</label>
                                <input type="email" class="form-control rounded-3" id="editUserEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="editUserPassword" class="form-label">Password</label>
                                <input type="password" class="form-control rounded-3" id="editUserPassword" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="editUserRole" class="form-label">Role</label>
                                <select name="role" id="editUserRole" class="form-select rounded-3">
                                    <option value="admin">Admin</option>
                                    <option value="superadmin">Super Admin</option>
                                </select>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-secondary btn-main" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="text-center">Role</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">
                                {{ $loop->iteration + $users->perPage() * ($users->currentPage() - 1) }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">@if($user->role == 'superadmin') <span class="badge bg-success">Super Admin</span> @else <span class="badge bg-primary">Admin</span> @endif</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-warning" onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">Edit</a>
                                <form action="{{ asset('admin/user/delete/' . $user->id) }}" method="post"
                                    style="display: inline-block;" onsubmit="return confirmDelete(event, this);">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-5 mb-5">
                {{ $users->links('pagination::bootstrap-4') }}
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
        function openEditModal(id, name, email, role) {
            $('#editUserModal').modal('show');
            $('#editUserId').val(id);
            $('#editUserName').val(name);
            $('#editUserEmail').val(email);
            $('#editUserRole').val(role);
        }
    </script>

    @yield('custom-js')

</body>

</html>
