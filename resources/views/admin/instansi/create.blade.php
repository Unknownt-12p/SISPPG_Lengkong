@extends('layouts.app')

@section('page_title', 'Tambah Instansi')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <a href="{{ route('admin.instansi.index') }}" class="btn btn-outline-success btn-sm rounded-circle me-3" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-building-circle-add text-success me-2"></i>Registrasi Instansi Baru</h5>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.instansi.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Kode Instansi -->
                        <div class="col-md-6 mb-3">
                            <label for="kode_instansi" class="form-label fw-bold">Kode Instansi</label>
                            <input type="text" name="kode_instansi" id="kode_instansi" 
                                   class="form-control bg-light @error('kode_instansi') is-invalid @enderror" 
                                   value="{{ old('kode_instansi', $kodeInstansi) }}" readonly required>
                            @error('kode_instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Instansi -->
                        <div class="col-md-6 mb-3">
                            <label for="jenis_instansi" class="form-label fw-bold">Jenis Instansi</label>
                            <select name="jenis_instansi" id="jenis_instansi" 
                                    class="form-select @error('jenis_instansi') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih Jenis...</option>
                                <option value="TK" {{ old('jenis_instansi') === 'TK' ? 'selected' : '' }}>Taman Kanak-kanak (TK)</option>
                                <option value="SD" {{ old('jenis_instansi') === 'SD' ? 'selected' : '' }}>Sekolah Dasar (SD)</option>
                                <option value="Posyandu" {{ old('jenis_instansi') === 'Posyandu' ? 'selected' : '' }}>Posyandu</option>
                                <option value="Puskesmas" {{ old('jenis_instansi') === 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                            </select>
                            @error('jenis_instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nama Instansi -->
                    <div class="mb-3">
                        <label for="nama_instansi" class="form-label fw-bold">Nama Instansi</label>
                        <input type="text" name="nama_instansi" id="nama_instansi" 
                               class="form-control @error('nama_instansi') is-invalid @enderror" 
                               placeholder="Contoh: SD Negeri 02 Gizi" 
                               value="{{ old('nama_instansi') }}" required>
                        @error('nama_instansi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-bold">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="3" 
                                  class="form-control @error('alamat') is-invalid @enderror" 
                                  placeholder="Tuliskan alamat lengkap..." required>{{ old('alamat') }}</textarea>
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
                                   placeholder="Contoh: Ibu Ani Rahmawati" 
                                   value="{{ old('penanggung_jawab') }}" required>
                            @error('penanggung_jawab')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label fw-bold">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="telepon" id="telepon" 
                                   class="form-control @error('telepon') is-invalid @enderror" 
                                   placeholder="Contoh: 08123456789" 
                                   value="{{ old('telepon') }}" required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email (Akun Login) -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Alamat Email (Digunakan untuk Login)</label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               placeholder="Contoh: sdnegeri02@sppg.go.id" 
                               value="{{ old('email') }}" required>
                        <small class="text-muted"><i class="fa-solid fa-circle-info text-info me-1 mt-2"></i>Setelah didaftarkan, instansi dapat login menggunakan email ini dengan password default: <strong>password</strong></small>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.instansi.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fa-solid fa-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
