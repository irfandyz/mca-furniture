<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="transition: all 0.3s ease;">
    <div class="container">
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <a class="navbar-brand" href="#" style="margin-left: 0;">
                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo" style="height: 45px; transition: transform 0.3s ease;">
            </a>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <a href="{{ asset('/admin') }}" class="text-decoration-none navbar-text" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                    Collection
                </a>
                <a href="{{ asset('/admin/user') }}" class="text-decoration-none navbar-text ms-5" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                    Users
                </a>
                <a href="{{ asset('/admin/message') }}" class="text-decoration-none navbar-text ms-5" style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                    Messages
                </a>
            </div>
            <a href="{{ asset('/admin/logout') }}" class="btn btn-outline-danger" style="margin-right: 0;">Logout</a>
        </div>
    </div>
</nav>
