@extends('layouts.app')

@section('page_title', 'Profil Instansi')

@section('content')
<div class="row">
    <div class="col-12 col-md-10 col-lg-8 mx-auto">
        <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-primary"><i class="fa-solid fa-user-circle text-primary me-2"></i>Pengaturan Profil Instansi</h5>
            </div>

            <!-- Form -->
            <form action="{{ route('instansi.profil.update') }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <!-- General Warning Info -->
                    <div class="alert alert-info-light border border-info-subtle p-3 rounded mb-4" style="background-color: #f0f9ff;">
                        <h6 class="fw-bold text-info mb-1"><i class="fa-solid fa-circle-info me-2"></i>Informasi Akun</h6>
                        <p class="mb-0 text-muted small">Email login Anda terdaftar sebagai: <strong>{{ $user->email }}</strong>. Email login tidak dapat diubah secara langsung oleh instansi demi alasan keamanan. Hubungi Admin jika Anda perlu menggantinya.</p>
                    </div>

                    <!-- Kode & Jenis Instansi (Read-only) -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kode Instansi</label>
                            <input type="text" class="form-control bg-light" value="{{ $instansi->kode_instansi }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis Instansi Mitra</label>
                            <input type="text" class="form-control bg-light" value="{{ $instansi->jenis_instansi }}" readonly>
                        </div>
                    </div>

                    <!-- Nama Instansi -->
                    <div class="mb-3">
                        <label for="nama_instansi" class="form-label fw-bold">Nama Instansi</label>
                        <input type="text" name="nama_instansi" id="nama_instansi" 
                               class="form-control @error('nama_instansi') is-invalid @enderror" 
                               value="{{ old('nama_instansi', $instansi->nama_instansi) }}" required>
                        @error('nama_instansi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-bold">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="3" 
                                  class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $instansi->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Penanggung Jawab -->
                        <div class="col-md-6 mb-3">
                            <label for="penanggung_jawab" class="form-label fw-bold">Nama Penanggung Jawab</label>
                            <input type="text" name="penanggung_jawab" id="penanggung_jawab" 
                                   class="form-control @error('penanggung_jawab') is-invalid @enderror" 
                                   value="{{ old('penanggung_jawab', $instansi->penanggung_jawab) }}" required>
                            @error('penanggung_jawab')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label fw-bold">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="telepon" id="telepon" 
                                   class="form-control @error('telepon') is-invalid @enderror" 
                                   value="{{ old('telepon', $instansi->telepon) }}" required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-key text-primary me-2"></i>Ubah Password Akun Login</h5>
                    <p class="text-muted small">Kosongkan kolom di bawah ini jika Anda tidak ingin mengubah password akun Anda.</p>

                    <div class="row">
                        <!-- Password Baru -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-bold">Password Baru</label>
                            <input type="password" name="password" id="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Minimal 6 karakter">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end justify-content-sm-end gap-2 flex-wrap">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 w-100 w-sm-auto">
                        <i class="fa-solid fa-circle-check me-1"></i> Perbarui Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
