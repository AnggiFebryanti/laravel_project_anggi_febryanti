<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">TokoKu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bstarget="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="">Produk</a></li>
                {{-- Muncul hanya kalau sudah login --}}
                @auth
                    <li class="nav-item"><a class="nav-link" href="">Pesanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="">Pembayaran</a></li>
                @endauth
            </ul>
            {{-- Kalau belum login tampilkan tombol Login --}}
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary ms-lg-3">Login</a>
            @endguest

            {{-- Kalau sudah login tampilkan info user dan tombol Logout --}}
            @auth
                <div class="dropdown ms-lg-3">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-user"></i>
                        {{ auth()->user()->name ?? 'User' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <h6 class="dropdown-header">{{ auth()->user()->email }}</h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                <i class="bx bx-home-circle me-2"></i>Dashboard
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bx bx-user-circle me-2"></i>Profile
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bx bx-log-out me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</nav>
