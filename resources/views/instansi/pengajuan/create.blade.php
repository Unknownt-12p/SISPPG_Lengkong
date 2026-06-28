@extends('layouts.app')

@section('page_title', 'Buat Pengajuan Makanan')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <a href="{{ route('instansi.pengajuan.index') }}" class="btn btn-outline-primary btn-sm rounded-circle me-3" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-file-circle-plus text-primary me-2"></i>Form Pengajuan Makanan Bergizi</h5>
            </div>

            <!-- Form -->
            <form action="{{ route('instansi.pengajuan.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Kode Pengajuan -->
                        <div class="col-md-6 mb-3">
                            <label for="kode_pengajuan" class="form-label fw-bold">Kode Pengajuan</label>
                            <input type="text" name="kode_pengajuan" id="kode_pengajuan" 
                                   class="form-control bg-light @error('kode_pengajuan') is-invalid @enderror" 
                                   value="{{ old('kode_pengajuan', $kodePengajuan) }}" readonly required>
                            @error('kode_pengajuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori Sasaran Penerima -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori_penerima" class="form-label fw-bold">Kategori Sasaran Penerima</label>
                            <select name="kategori_penerima" id="kategori_penerima" 
                                    class="form-select @error('kategori_penerima') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih Kategori...</option>
                                <option value="Anak TK" {{ old('kategori_penerima') === 'Anak TK' ? 'selected' : '' }}>Anak TK</option>
                                <option value="Anak SD" {{ old('kategori_penerima') === 'Anak SD' ? 'selected' : '' }}>Anak SD</option>
                                <option value="Balita" {{ old('kategori_penerima') === 'Balita' ? 'selected' : '' }}>Balita</option>
                                <option value="Ibu Hamil" {{ old('kategori_penerima') === 'Ibu Hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                                <option value="Ibu Menyusui" {{ old('kategori_penerima') === 'Ibu Menyusui' ? 'selected' : '' }}>Ibu Menyusui</option>
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
                                       placeholder="Contoh: 100" value="{{ old('jumlah_penerima') }}" min="1" required>
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
                                       placeholder="Contoh: 100" value="{{ old('jumlah_porsi') }}" min="1" required>
                                <span class="input-group-text">porsi</span>
                            </div>
                            <small class="text-muted text-xs"><i class="fa-solid fa-lightbulb text-warning me-1"></i>Porsi disarankan disesuaikan 1-to-1 dengan jumlah penerima.</small>
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
                               value="{{ old('tanggal_distribusi') }}" required>
                        @error('tanggal_distribusi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label for="catatan" class="form-label fw-bold">Catatan Kebutuhan Khusus / Alergi</label>
                        <textarea name="catatan" id="catatan" rows="3" 
                                  class="form-control @error('catatan') is-invalid @enderror" 
                                  placeholder="Tuliskan catatan tambahan (misal: pengiriman sebelum jam 10 pagi, alergi seafood, dll)...">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('instansi.pengajuan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fa-solid fa-paper-plane me-1"></i> Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Micro-interaction: automatic 1-to-1 matching for recipients and portions
    document.getElementById('jumlah_penerima').addEventListener('input', function() {
        const value = this.value;
        const portionInput = document.getElementById('jumlah_porsi');
        if (!portionInput.value || portionInput.value == 0 || portionInput.dataset.userEdited !== 'true') {
            portionInput.value = value;
        }
    });

    document.getElementById('jumlah_porsi').addEventListener('input', function() {
        this.dataset.userEdited = 'true';
    });
</script>
@endsection
