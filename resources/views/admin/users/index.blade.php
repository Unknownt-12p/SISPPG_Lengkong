@extends('layouts.app')

@section('page_title', 'Manajemen User')

@section('css')
<style>
    @media (max-width: 768px) {
        .col-tgl { display: none; }
        .search-box { max-width: 100% !important; }
    }
    @media (max-width: 576px) {
        .col-email-user { display: none; }
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-users-cog text-primary me-2"></i>Daftar Semua User
                </h5>
                <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i> Tambah User
                </a>
            </div>
            <div class="card-body">
                {{-- Search Form --}}
                <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
                <div class="input-group search-box" style="max-width: 380px;">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari nama, email, atau role..." 
                               value="{{ $search ?? '' }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if($search)
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>

                {{-- Tabel User --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3" style="width: 50px;">No</th>
                                <th>Nama</th>
                                <th class="col-email-user">Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center col-tgl">Dibuat</th>
                                <th class="text-center pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $users->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                                 style="width:38px; height:38px; min-width:38px; font-size:15px;
                                                        background-color: {{ $user->role === 'admin' ? '#2c7c8f' : '#6c757d' }};">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                @if($user->id === auth()->id())
                                                    <small class="text-primary">(Anda)</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted col-email-user">{{ $user->email }}</td>
                                    <td class="text-center">
                                        @if($user->role === 'admin')
                                            <span class="badge rounded-pill px-3 py-2" 
                                                  style="background-color: #2c7c8f; font-size: 12px;">
                                                <i class="fas fa-shield-alt me-1"></i>Admin
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-2"
                                                  style="font-size: 12px;">
                                                <i class="fas fa-building me-1"></i>Instansi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center text-muted col-tgl" style="font-size: 13px;">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="text-center pe-3">
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">
                                            {{-- Edit --}}
                                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                               class="btn btn-sm btn-outline-primary px-2 py-1"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Reset Password --}}
                                            <form action="{{ route('admin.users.reset-password', $user->id) }}" 
                                                  method="POST" class="d-inline reset-pw-form">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning px-2 py-1"
                                                        title="Reset Password ke 'SISPPG123'">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                            </form>
                                            {{-- Hapus --}}
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                                      method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1"
                                                            title="Hapus User">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-users fa-2x mb-2 d-block opacity-25"></i>
                                        Tidak ada data user ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($users->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                        <small class="text-muted">
                            Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
                        </small>
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Konfirmasi hapus user
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = this;
            Swal.fire({
                title: 'Hapus User?',
                text: 'Data user ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) btn.submit();
            });
        });
    });

    // Konfirmasi reset password
    document.querySelectorAll('.reset-pw-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = this;
            Swal.fire({
                title: 'Reset Password?',
                text: 'Password akan direset ke: password123',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2c7c8f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) btn.submit();
            });
        });
    });
</script>
@endsection
