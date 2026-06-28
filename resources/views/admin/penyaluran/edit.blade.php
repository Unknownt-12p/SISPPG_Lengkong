@extends('layouts.app')

@section('page_title', 'Edit Penyaluran')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <a href="{{ route('admin.penyaluran.index') }}" class="btn btn-outline-success btn-sm rounded-circle me-3" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-truck-ramp-box text-success me-2"></i>Ubah Jadwal & Status Penyaluran</h5>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.penyaluran.update', $penyaluran->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <!-- Kode Penyaluran -->
                        <div class="col-md-6 mb-3">
                            <label for="kode_penyaluran" class="form-label fw-bold">Kode Penyaluran</label>
                            <input type="text" name="kode_penyaluran" id="kode_penyaluran" 
                                   class="form-control bg-light" 
                                   value="{{ $penyaluran->kode_penyaluran }}" readonly required>
                        </div>

                        <!-- Status Pengiriman -->
                        <div class="col-md-6 mb-3">
                            <label for="status_pengiriman" class="form-label fw-bold">Status Pengiriman</label>
                            <select name="status_pengiriman" id="status_pengiriman" class="form-select @error('status_pengiriman') is-invalid @enderror" required>
                                <option value="Diproses" {{ old('status_pengiriman', $penyaluran->status_pengiriman) === 'Diproses' ? 'selected' : '' }}>Diproses (Dapur Gizi)</option>
                                <option value="Dikirim" {{ old('status_pengiriman', $penyaluran->status_pengiriman) === 'Dikirim' ? 'selected' : '' }}>Dikirim (Kurir)</option>
                                <option value="Selesai" {{ old('status_pengiriman', $penyaluran->status_pengiriman) === 'Selesai' ? 'selected' : '' }}>Selesai (Sampai Tujuan)</option>
                            </select>
                            @error('status_pengiriman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Pilih Pengajuan Disetujui -->
                    <div class="mb-3">
                        <label for="pengajuan_id" class="form-label fw-bold">Pengajuan Instansi</label>
                        <select name="pengajuan_id" id="pengajuan_id" class="form-select bg-light @error('pengajuan_id') is-invalid @enderror" readonly required>
                            @foreach($pengajuan as $p)
                                <option value="{{ $p->id }}" {{ $penyaluran->pengajuan_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->kode_pengajuan }} - {{ $p->instansi->nama_instansi }} ({{ $p->kategori_penerima }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <!-- Pilih Menu Makanan -->
                        <div class="col-md-7 mb-3">
                            <label for="menu_id" class="form-label fw-bold">Menu Makanan</label>
                            <select name="menu_id" id="menu_id" class="form-select @error('menu_id') is-invalid @enderror" required>
                                @foreach($menu as $m)
                                    <option value="{{ $m->id }}" {{ old('menu_id', $penyaluran->menu_id) == $m->id ? 'selected' : '' }}>
                                        [{{ $m->kategori_menu }}] {{ $m->nama_menu }}
                                    </option>
                                @endforeach
                            </select>
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
                                       value="{{ old('jumlah_disalurkan', $penyaluran->jumlah_disalurkan) }}" min="1" required>
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
                               value="{{ old('tanggal_penyaluran', $penyaluran->tanggal_penyaluran) }}" required>
                        @error('tanggal_penyaluran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-bold">Keterangan Pengiriman</label>
                        <textarea name="keterangan" id="keterangan" rows="3" 
                                  class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $penyaluran->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.penyaluran.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fa-solid fa-save me-1"></i> Perbarui Penyaluran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
