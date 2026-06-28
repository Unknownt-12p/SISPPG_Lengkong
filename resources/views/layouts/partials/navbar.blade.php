<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto align-items-center">
        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown me-2">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 py-1 px-2 rounded-pill" 
               href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
               style="background: rgba(44,124,143,0.08); transition: all 0.2s;">
                <!-- Avatar -->
                <div class="rounded-circle overflow-hidden flex-shrink-0" style="width:34px;height:34px;border:2px solid #2c7c8f;">
                    @if(Auth::user()->foto_profil)
                        <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" 
                             alt="Foto Profil" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center fw-bold text-white"
                             style="background: linear-gradient(135deg, #2c7c8f, #1f5866); font-size:13px;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <!-- Name & Role (hidden on small screens) -->
                <div class="d-none d-md-block text-start lh-sm">
                    <div class="fw-semibold text-dark" style="font-size:13px;">{{ Auth::user()->name }}</div>
                    <div class="text-capitalize text-muted" style="font-size:11px;">{{ Auth::user()->role }}</div>
                </div>
            </a>

            <!-- Dropdown Menu -->
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-1" 
                aria-labelledby="userDropdown" style="min-width:200px;border-radius:12px;">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-bold text-dark" style="font-size:13px;">{{ Auth::user()->name }}</div>
                    <div class="text-muted" style="font-size:11px;">{{ Auth::user()->email }}</div>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#"
                       data-bs-toggle="modal" data-bs-target="#modalFotoProfil">
                        <i class="fa-solid fa-camera text-primary" style="width:16px;"></i>
                        <span>Ganti Foto Profil</span>
                    </a>
                </li>
                @if(Auth::user()->isInstansi())
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('instansi.profil') }}">
                        <i class="fa-solid fa-user-pen text-warning" style="width:16px;"></i>
                        <span>Edit Profil</span>
                    </a>
                </li>
                @endif
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="#"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket" style="width:16px;"></i>
                        <span>Keluar</span>
                    </a>
                </li>
            </ul>
        </li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </ul>
</nav>
<!-- /.navbar -->
