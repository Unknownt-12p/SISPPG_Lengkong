<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link text-center">
        <span class="brand-text font-weight-bold"><img src="{{ asset('images/logo-mbg.png') }}" alt="Logo SPPG" style="width: 50px; height: 50px; object-fit: contain;">SISPPG Lengkong</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalFotoProfil" title="Ganti Foto Profil"
                   class="d-block position-relative" style="width:38px;height:38px;">
                    <div class="rounded-circle overflow-hidden w-100 h-100" style="border:2px solid rgba(255,255,255,0.5);">
                        @if(Auth::user()->foto_profil)
                            <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                                 alt="Foto" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center fw-bold text-white"
                                 style="background: linear-gradient(135deg, #2c7c8f, #1f5866); font-size:14px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <span class="position-absolute bottom-0 end-0 rounded-circle d-flex align-items-center justify-content-center"
                          style="width:14px;height:14px;background:#2c7c8f;border:1.5px solid white;">
                        <i class="fa-solid fa-camera text-white" style="font-size:7px;"></i>
                    </span>
                </a>
            </div>
            <div class="info ms-2">
                <a href="#" class="d-block text-black" style="text-decoration: none; font-size:13px;">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                @if(Auth::user()->isAdmin())
                    <!-- MENU ADMIN -->
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}" 
                           class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">Master Data</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.instansi.index') ? route('admin.instansi.index') : '#' }}" 
                           class="nav-link {{ request()->is('admin/instansi*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Data Instansi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.menu.index') ? route('admin.menu.index') : '#' }}" 
                           class="nav-link {{ request()->is('admin/menu*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-utensils"></i>
                            <p>Data Menu</p>
                        </a>
                    </li>

                    <li class="nav-header">Transaksi</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.pengajuan.index') ? route('admin.pengajuan.index') : '#' }}" 
                           class="nav-link {{ request()->is('admin/pengajuan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Pengajuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.penyaluran.index') ? route('admin.penyaluran.index') : '#' }}" 
                           class="nav-link {{ request()->is('admin/penyaluran*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-truck-moving"></i>
                            <p>Penyaluran</p>
                        </a>
                    </li>

                    <li class="nav-header">Laporan</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.laporan.pengajuan') ? route('admin.laporan.pengajuan') : '#' }}" 
                           class="nav-link {{ request()->is('admin/laporan/pengajuan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>Laporan Pengajuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.laporan.penyaluran') ? route('admin.laporan.penyaluran') : '#' }}" 
                           class="nav-link {{ request()->is('admin/laporan/penyaluran*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice"></i>
                            <p>Laporan Penyaluran</p>
                        </a>
                    </li>

                    <li class="nav-header">Pengaturan</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.users.index') ? route('admin.users.index') : '#' }}" 
                           class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Manajemen User</p>
                        </a>
                    </li>

                @elseif(Auth::user()->isInstansi())
                    <!-- MENU INSTANSI -->
                    <li class="nav-item">
                        <a href="{{ Route::has('instansi.dashboard') ? route('instansi.dashboard') : '#' }}" 
                           class="nav-link {{ request()->is('instansi/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">Layanan Gizi</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('instansi.pengajuan.create') ? route('instansi.pengajuan.create') : '#' }}" 
                           class="nav-link {{ request()->is('instansi/pengajuan/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <p>Buat Pengajuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Route::has('instansi.pengajuan.index') ? route('instansi.pengajuan.index') : '#' }}" 
                           class="nav-link {{ request()->is('instansi/pengajuan') && !request()->is('instansi/pengajuan/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Riwayat Pengajuan</p>
                        </a>
                    </li>

                    <li class="nav-header">Pengaturan Akun</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('instansi.profil') ? route('instansi.profil') : '#' }}" 
                           class="nav-link {{ request()->is('instansi/profil*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>Profil</p>
                        </a>
                    </li>
                @endif

                <li class="nav-header">Keluar</li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-danger" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
