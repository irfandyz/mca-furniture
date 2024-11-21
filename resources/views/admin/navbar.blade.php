<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="transition: all 0.3s ease;">
    <div class="container">
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <a class="navbar-brand" href="#" style="margin-left: 0;">
                <img src="{{ asset('logos/' . App\Models\Setting::first()->logo) }}" alt="Logo"
                    style="height: 45px; transition: transform 0.3s ease;">
            </a>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <a href="{{ asset('/admin') }}" class="text-decoration-none navbar-text"
                    style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                    Collection
                </a>
                <a href="{{ asset('/admin/message') }}" class="text-decoration-none navbar-text ms-5"
                    style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                    Messages
                </a>
                <a href="{{ asset('/admin/slider') }}" class="text-decoration-none navbar-text ms-5"
                    style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                    Slider
                </a>
                <a href="{{ asset('/admin/news') }}" class="text-decoration-none navbar-text ms-5"
                    style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                    News
                </a>
                <a href="{{ asset('/admin/faq') }}" class="text-decoration-none navbar-text ms-5"
                    style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                    FAQ
                </a>
                @if (Auth::user()->role == 'superadmin')
                    <a href="{{ asset('/admin/user') }}" class="text-decoration-none navbar-text ms-5"
                        style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                        Users
                    </a>

                    <a href="{{ asset('/admin/setting') }}" class="text-decoration-none navbar-text ms-5"
                        style="font-weight: 500; letter-spacing: 0.5px; position: relative;">
                        Setting
                    </a>
                @endif
            </div>
            <div class="d-flex align-items-center justify-content-end">
                <span class=""></span>
                <div class="dropdown">
                    <a class="dropdown-toggle d-flex align-items-center text-muted me-2 text-decoration-none"
                        href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Welcome, {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                        <li class="dropdown-item">
                            <p class="text-dark small"><span class="fw-bold">Name:</span> {{ Auth::user()->name }}</p>
                            <p class="text-dark small"><span class="fw-bold">Email:</span> {{ Auth::user()->email }}</p>
                            <p class="text-dark small"><span class="fw-bold">Role:</span> {{ Auth::user()->role }}</p>
                        <li><a class="dropdown-item text-danger" href="{{ asset('/admin/logout') }}"><i
                                    class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
