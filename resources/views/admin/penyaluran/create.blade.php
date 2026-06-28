@extends('layouts.app')

@section('page_title', 'Jadwalkan Penyaluran')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <a href="{{ route('admin.penyaluran.index') }}" class="btn btn-outline-success btn-sm rounded-circle me-3" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-truck-ramp-box text-success me-2"></i>Jadwalkan Penyaluran Makanan Baru</h5>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.penyaluran.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Kode Penyaluran -->
                        <div class="col-md-6 mb-3">
                            <label for="kode_penyaluran" class="form-label fw-bold">Kode Penyaluran</label>
                            <input type="text" name="kode_penyaluran" id="kode_penyaluran" 
                                   class="form-control bg-light" 
                                   value="{{ $kodePenyaluran }}" readonly required>
                        </div>

                        <!-- Status Pengiriman -->
                        <div class="col-md-6 mb-3">
                            <label for="status_pengiriman" class="form-label fw-bold">Status Pengiriman Awal</label>
                            <select name="status_pengiriman" id="status_pengiriman" class="form-select @error('status_pengiriman') is-invalid @enderror" required>
                                <option value="Diproses" selected>Diproses (Dapur Gizi)</option>
                                <option value="Dikirim">Dikirim (Kurir)</option>
                                <option value="Selesai">Selesai (Sampai Tujuan)</option>
                            </select>
                            @error('status_pengiriman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Pilih Pengajuan Disetujui -->
                    <div class="mb-3">
                        <label for="pengajuan_id" class="form-label fw-bold">Pilih Pengajuan Instansi</label>
                        <select name="pengajuan_id" id="pengajuan_id" class="form-select @error('pengajuan_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Pengajuan...</option>
                            @foreach($pengajuan as $p)
                                <option value="{{ $p->id }}" 
                                        data-porsi="{{ $p->jumlah_porsi }}"
                                        data-kategori="{{ $p->kategori_penerima }}"
                                        data-instansi="{{ $p->instansi->nama_instansi }}"
                                        {{ (old('pengajuan_id') == $p->id || $selectedPengajuanId == $p->id) ? 'selected' : '' }}>
                                    {{ $p->kode_pengajuan }} - {{ $p->instansi->nama_instansi }} ({{ $p->kategori_penerima }} | {{ $p->jumlah_porsi }} porsi)
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted"><i class="fa-solid fa-circle-info text-info me-1 mt-2"></i>Hanya menampilkan pengajuan berstatus <strong>Disetujui</strong> yang belum disalurkan.</small>
                        @error('pengajuan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Pilih Menu Makanan (Filtered dynamically by category) -->
                        <div class="col-md-7 mb-3">
                            <label for="menu_id" class="form-label fw-bold">Menu Makanan (Disesuaikan Kategori)</label>
                            <select name="menu_id" id="menu_id" class="form-select @error('menu_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Silakan pilih pengajuan terlebih dahulu...</option>
                                @foreach($menu as $m)
                                    <option value="{{ $m->id }}" 
                                            data-kategori="{{ $m->kategori_menu }}"
                                            {{ old('menu_id') == $m->id ? 'selected' : '' }}>
                                        [{{ $m->kategori_menu }}] {{ $m->nama_menu }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-danger d-none" id="category-warning"><i class="fa-solid fa-triangle-exclamation me-1 mt-2"></i>Kategori menu disaring agar sesuai dengan kategori penerima pengajuan.</small>
                            @error('menu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Disalurkan -->
                        <div class="col-md-5 mb-3">
                            <label for="jumlah_disalurkan" class="form-label fw-bold">Jumlah Porsi Disalurkan</label>
                            <div class="input-group">
                                <input type="number" name="jumlah_disalurkan" id="jumlah_disalurkan" 
                                       class="form-control @error('jumlah_disalurkan') is-invalid @enderror" 
                                       value="{{ old('jumlah_disalurkan') }}" min="1" required>
                                <span class="input-group-text">porsi</span>
                            </div>
                            @error('jumlah_disalurkan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Penyaluran -->
                    <div class="mb-3">
                        <label for="tanggal_penyaluran" class="form-label fw-bold">Tanggal Penyaluran</label>
                        <input type="date" name="tanggal_penyaluran" id="tanggal_penyaluran" 
                               class="form-control @error('tanggal_penyaluran') is-invalid @enderror" 
                               value="{{ old('tanggal_penyaluran', date('Y-m-d')) }}" required>
                        @error('tanggal_penyaluran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-bold">Keterangan Pengiriman</label>
                        <textarea name="keterangan" id="keterangan" rows="3" 
                                  class="form-control @error('keterangan') is-invalid @enderror" 
                                  placeholder="Tulis kurir, plat nomor kendaraan, atau info serah terima (opsional)...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.penyaluran.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fa-solid fa-save me-1"></i> Simpan Penyaluran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pengajuanSelect = document.getElementById('pengajuan_id');
        const menuSelect = document.getElementById('menu_id');
        const porsiInput = document.getElementById('jumlah_disalurkan');
        const catWarning = document.getElementById('category-warning');
        
        // Ambil semua opsi menu awal untuk mempermudah filter
        const originalMenuOptions = Array.from(menuSelect.options);

        function handlePengajuanChange() {
            const selectedOption = pengajuanSelect.options[pengajuanSelect.selectedIndex];
            if (!selectedOption || !selectedOption.value) {
                menuSelect.innerHTML = '<option value="" disabled selected>Silakan pilih pengajuan terlebih dahulu...</option>';
                porsiInput.value = '';
                catWarning.classList.add('d-none');
                return;
            }

            // Fill recommended portions
            const porsi = selectedOption.dataset.porsi;
            porsiInput.value = porsi;

            // Filter menu based on category
            const kategori = selectedOption.dataset.kategori;
            
            // Clear current options
            menuSelect.innerHTML = '<option value="" disabled selected>Pilih Menu Makanan...</option>';
            
            let matchCount = 0;
            originalMenuOptions.forEach(option => {
                if (option.value && option.dataset.kategori === kategori) {
                    menuSelect.add(option.cloneNode(true));
                    matchCount++;
                }
            });

            if (matchCount > 0) {
                catWarning.classList.remove('d-none');
            } else {
                menuSelect.innerHTML = '<option value="" disabled selected>Tidak ada menu yang sesuai dengan kategori: ' + kategori + '</option>';
                catWarning.classList.add('d-none');
            }
        }

        pengajuanSelect.addEventListener('change', handlePengajuanChange);
        
        // Trigger on load if there's old input or pre-selected query param
        if (pengajuanSelect.value) {
            handlePengajuanChange();
        }
    });
</script>
@endsection
