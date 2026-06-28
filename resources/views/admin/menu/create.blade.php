@extends('layouts.app')

@section('page_title', 'Tambah Menu Makanan')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-success btn-sm rounded-circle me-3" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-bowl-medical text-success me-2"></i>Registrasi Menu Makanan Baru</h5>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.menu.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Kode Menu -->
                        <div class="col-md-6 mb-3">
                            <label for="kode_menu" class="form-label fw-bold">Kode Menu</label>
                            <input type="text" name="kode_menu" id="kode_menu" 
                                   class="form-control bg-light @error('kode_menu') is-invalid @enderror" 
                                   value="{{ old('kode_menu', $kodeMenu) }}" readonly required>
                            @error('kode_menu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori Menu -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori_menu" class="form-label fw-bold">Kategori Sasaran Penerima</label>
                            <select name="kategori_menu" id="kategori_menu" 
                                    class="form-select @error('kategori_menu') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih Kategori...</option>
                                <option value="Anak TK" {{ old('kategori_menu') === 'Anak TK' ? 'selected' : '' }}>Anak TK</option>
                                <option value="Anak SD" {{ old('kategori_menu') === 'Anak SD' ? 'selected' : '' }}>Anak SD</option>
                                <option value="Balita" {{ old('kategori_menu') === 'Balita' ? 'selected' : '' }}>Balita</option>
                                <option value="Ibu Hamil" {{ old('kategori_menu') === 'Ibu Hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                                <option value="Ibu Menyusui" {{ old('kategori_menu') === 'Ibu Menyusui' ? 'selected' : '' }}>Ibu Menyusui</option>
                            </select>
                            @error('kategori_menu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nama Menu -->
                    <div class="mb-3">
                        <label for="nama_menu" class="form-label fw-bold">Nama Menu Makanan</label>
                        <input type="text" name="nama_menu" id="nama_menu" 
                               class="form-control @error('nama_menu') is-invalid @enderror" 
                               placeholder="Contoh: Bubur Kacang Hijau Gula Aren" 
                               value="{{ old('nama_menu') }}" required>
                        @error('nama_menu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Kalori -->
                        <div class="col-md-3 col-6 mb-3">
                            <label for="kalori" class="form-label fw-bold">Energi (Kalori)</label>
                            <div class="input-group">
                                <input type="number" name="kalori" id="kalori" 
                                       class="form-control @error('kalori') is-invalid @enderror" 
                                       placeholder="350" value="{{ old('kalori') }}" min="0" required>
                                <span class="input-group-text">kcal</span>
                            </div>
                            @error('kalori')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Protein -->
                        <div class="col-md-3 col-6 mb-3">
                            <label for="protein" class="form-label fw-bold">Protein</label>
                            <div class="input-group">
                                <input type="number" name="protein" id="protein" 
                                       class="form-control @error('protein') is-invalid @enderror" 
                                       placeholder="12" value="{{ old('protein') }}" min="0" required>
                                <span class="input-group-text">g</span>
                            </div>
                            @error('protein')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Karbohidrat -->
                        <div class="col-md-3 col-6 mb-3">
                            <label for="karbohidrat" class="form-label fw-bold">Karbohidrat</label>
                            <div class="input-group">
                                <input type="number" name="karbohidrat" id="karbohidrat" 
                                       class="form-control @error('karbohidrat') is-invalid @enderror" 
                                       placeholder="50" value="{{ old('karbohidrat') }}" min="0" required>
                                <span class="input-group-text">g</span>
                            </div>
                            @error('karbohidrat')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lemak -->
                        <div class="col-md-3 col-6 mb-3">
                            <label for="lemak" class="form-label fw-bold">Lemak</label>
                            <div class="input-group">
                                <input type="number" name="lemak" id="lemak" 
                                       class="form-control @error('lemak') is-invalid @enderror" 
                                       placeholder="8" value="{{ old('lemak') }}" min="0" required>
                                <span class="input-group-text">g</span>
                            </div>
                            @error('lemak')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Menu / Komposisi Gizi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" 
                                  class="form-control @error('deskripsi') is-invalid @enderror" 
                                  placeholder="Tuliskan deskripsi menu atau keterangan penyajian..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fa-solid fa-save me-1"></i> Simpan Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
