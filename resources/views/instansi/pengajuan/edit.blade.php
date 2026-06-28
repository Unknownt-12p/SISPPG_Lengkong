@extends('layouts.app')

@section('page_title', 'Ubah Pengajuan Makanan')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <a href="{{ route('instansi.pengajuan.index') }}" class="btn btn-outline-primary btn-sm rounded-circle me-3" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-file-pen text-primary me-2"></i>Ubah Data Pengajuan</h5>
            </div>

            <!-- Form -->
            <form action="{{ route('instansi.pengajuan.update', $pengajuan->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <!-- Kode Pengajuan -->
                        <div class="col-md-6 mb-3">
                            <label for="kode_pengajuan" class="form-label fw-bold">Kode Pengajuan</label>
                            <input type="text" name="kode_pengajuan" id="kode_pengajuan" 
                                   class="form-control bg-light @error('kode_pengajuan') is-invalid @enderror" 
                                   value="{{ $pengajuan->kode_pengajuan }}" readonly required>
                            @error('kode_pengajuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori Sasaran Penerima -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori_penerima" class="form-label fw-bold">Kategori Sasaran Penerima</label>
                            <select name="kategori_penerima" id="kategori_penerima" 
                                    class="form-select @error('kategori_penerima') is-invalid @enderror" required>
                                <option value="" disabled>Pilih Kategori...</option>
                                <option value="Anak TK" {{ old('kategori_penerima', $pengajuan->kategori_penerima) === 'Anak TK' ? 'selected' : '' }}>Anak TK</option>
                                <option value="Anak SD" {{ old('kategori_penerima', $pengajuan->kategori_penerima) === 'Anak SD' ? 'selected' : '' }}>Anak SD</option>
                                <option value="Balita" {{ old('kategori_penerima', $pengajuan->kategori_penerima) === 'Balita' ? 'selected' : '' }}>Balita</option>
                                <option value="Ibu Hamil" {{ old('kategori_penerima', $pengajuan->kategori_penerima) === 'Ibu Hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                                <option value="Ibu Menyusui" {{ old('kategori_penerima', $pengajuan->kategori_penerima) === 'Ibu Menyusui' ? 'selected' : '' }}>Ibu Menyusui</option>
                            </select>
                            @error('kategori_penerima')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Jumlah Penerima -->
                        <div class="col-md-6 mb-3">
                            <label for="jumlah_penerima" class="form-label fw-bold">Jumlah Penerima Manfaat</label>
                            <div class="input-group">
                                <input type="number" name="jumlah_penerima" id="jumlah_penerima" 
                                       class="form-control @error('jumlah_penerima') is-invalid @enderror" 
                                       value="{{ old('jumlah_penerima', $pengajuan->jumlah_penerima) }}" min="1" required>
                                <span class="input-group-text">orang</span>
                            </div>
                            @error('jumlah_penerima')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Porsi -->
                        <div class="col-md-6 mb-3">
                            <label for="jumlah_porsi" class="form-label fw-bold">Jumlah Porsi Diminta</label>
                            <div class="input-group">
                                <input type="number" name="jumlah_porsi" id="jumlah_porsi" 
                                       class="form-control @error('jumlah_porsi') is-invalid @enderror" 
                                       value="{{ old('jumlah_porsi', $pengajuan->jumlah_porsi) }}" min="1" required>
                                <span class="input-group-text">porsi</span>
                            </div>
                            @error('jumlah_porsi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Distribusi -->
                    <div class="mb-3">
                        <label for="tanggal_distribusi" class="form-label fw-bold">Rencana Tanggal Distribusi</label>
                        <input type="date" name="tanggal_distribusi" id="tanggal_distribusi" 
                               class="form-control @error('tanggal_distribusi') is-invalid @enderror" 
                               value="{{ old('tanggal_distribusi', $pengajuan->tanggal_distribusi) }}" required>
                        @error('tanggal_distribusi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label for="catatan" class="form-label fw-bold">Catatan Kebutuhan Khusus / Alergi</label>
                        <textarea name="catatan" id="catatan" rows="3" 
                                  class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $pengajuan->catatan) }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('instansi.pengajuan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fa-solid fa-save me-1"></i> Perbarui Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
