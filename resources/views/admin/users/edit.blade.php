@extends('layouts.app')

@section('page_title', 'Edit User')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-9 col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-user-edit text-primary me-2"></i>Edit User: {{ $user->name }}
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Masukkan nama lengkap"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">
                            Alamat Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="contoh@email.com"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="mb-4">
                        <label for="role" class="form-label fw-semibold">
                            Role / Hak Akses <span class="text-danger">*</span>
                        </label>
                        <select name="role" id="role"
                                class="form-select @error('role') is-invalid @enderror" required>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="instansi" {{ old('role', $user->role) === 'instansi' ? 'selected' : '' }}>
                                Instansi
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($user->id === auth()->id())
                            <small class="text-warning mt-1 d-block">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Hati-hati mengubah role akun Anda sendiri.
                            </small>
                        @endif
                    </div>

                    {{-- Info Reset Password --}}
                    <div class="alert alert-info d-flex align-items-start gap-2 mb-4" style="border-radius: 10px;">
                        <i class="fas fa-info-circle mt-1"></i>
                        <div>
                            <strong>Ingin mengganti password?</strong><br>
                            Gunakan tombol <strong>Reset Password</strong> di halaman daftar user untuk mereset password ke default (<code>SISPPG123</code>).
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2 mt-2 flex-wrap">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
