@extends('layouts.app')

@section('page_title', 'Periksa Pengajuan')

@section('content')
<div class="row">
    <!-- Left Column: Pengajuan Details & Instansi Profile -->
    <div class="col-md-7">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-outline-success btn-sm rounded-circle me-3" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-clipboard-check text-success me-2"></i>Rincian Pengajuan</h5>
            </div>
            
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Kode Pengajuan</div>
                    <div class="col-sm-8 fw-bold text-success">{{ $pengajuan->kode_pengajuan }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Instansi Pengaju</div>
                    <div class="col-sm-8 fw-semibold text-dark">{{ $pengajuan->instansi->nama_instansi }} ({{ $pengajuan->instansi->jenis_instansi }})</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Kategori Sasaran</div>
                    <div class="col-sm-8">{{ $pengajuan->kategori_penerima }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Jumlah Penerima</div>
                    <div class="col-sm-8">{{ number_format($pengajuan->jumlah_penerima) }} orang</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Jumlah Porsi</div>
                    <div class="col-sm-8 fw-bold text-success">{{ number_format($pengajuan->jumlah_porsi) }} porsi</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Tanggal Pengajuan</div>
                    <div class="col-sm-8">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->translatedFormat('d F Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Tanggal Distribusi</div>
                    <div class="col-sm-8 fw-semibold text-dark">{{ \Carbon\Carbon::parse($pengajuan->tanggal_distribusi)->translatedFormat('d F Y') }}</div>
                </div>

                <hr class="my-4">
                
                <div>
                    <h6 class="fw-bold text-muted mb-2">Catatan Tambahan Instansi:</h6>
                    <p class="text-muted bg-light p-3 rounded border border-light-subtle mb-0" style="min-height: 80px;">{{ $pengajuan->catatan ?? 'Tidak ada catatan.' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Instansi Profile Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-success"><i class="fa-solid fa-building text-success me-2"></i>Kontak & Profil Instansi</h5>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted fw-bold">Penanggung Jawab</div>
                    <div class="col-sm-8">{{ $pengajuan->instansi->penanggung_jawab }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted fw-bold">Telepon / WhatsApp</div>
                    <div class="col-sm-8">{{ $pengajuan->instansi->telepon }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted fw-bold">Alamat Instansi</div>
                    <div class="col-sm-8 text-muted">{{ $pengajuan->instansi->alamat }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Verification Form / Decision details -->
    <div class="col-md-5">
        @if($pengajuan->status === 'Menunggu')
            <!-- Verification Form -->
            <div class="card shadow-sm border-0 mb-4 border-top border-4 border-warning">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold text-warning-emphasis"><i class="fa-solid fa-stamp me-2"></i>Verifikasi Keputusan</h5>
                </div>
                
                <form action="{{ route('admin.pengajuan.verifikasi', $pengajuan->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <p class="text-muted small">Silakan periksa kebutuhan gizi dan kelayakan porsi sebelum menyetujui. Berikan catatan tambahan (alasan persetujuan / penolakan) jika diperlukan.</p>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Tentukan Status Keputusan</label>
                            <div class="d-flex gap-3">
                                <input type="radio" class="btn-check" name="status" id="status_disetujui" value="Disetujui" autocomplete="off" required>
                                <label class="btn btn-outline-success w-50 py-3 rounded-3" for="status_disetujui">
                                    <i class="fa-solid fa-circle-check fs-4 d-block mb-1"></i> Setujui
                                </label>

                                <input type="radio" class="btn-check" name="status" id="status_ditolak" value="Ditolak" autocomplete="off" required>
                                <label class="btn btn-outline-danger w-50 py-3 rounded-3" for="status_ditolak">
                                    <i class="fa-solid fa-circle-xmark fs-4 d-block mb-1"></i> Tolak
                                </label>
                            </div>
                            @error('status')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label fw-bold">Catatan Verifikasi</label>
                            <textarea name="catatan" id="catatan" rows="4" 
                                      class="form-control @error('catatan') is-invalid @enderror" 
                                      placeholder="Tulis alasan atau catatan tambahan..." required></textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success rounded-pill px-4 w-100">
                            <i class="fa-solid fa-circle-check me-1"></i> Simpan Keputusan Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        @else
            <!-- Decision Details -->
            <div class="card shadow-sm border-0 mb-4 {{ $pengajuan->status === 'Disetujui' ? 'border-start border-4 border-success' : 'border-start border-4 border-danger' }}">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fa-solid fa-reply text-success me-2"></i>Status Keputusan Verifikasi
                    </h5>
                    <p class="mb-2">Status: 
                        @if($pengajuan->status === 'Disetujui')
                            <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fa-solid fa-check me-1"></i>Disetujui</span>
                        @else
                            <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fa-solid fa-times me-1"></i>Ditolak</span>
                        @endif
                    </p>
                    
                    <div class="p-3 border rounded bg-light mb-4">
                        <small class="text-muted d-block mb-1">Catatan Verifikasi:</small>
                        <p class="mb-0 fw-semibold">{{ $pengajuan->catatan ?? 'Tidak ada catatan.' }}</p>
                    </div>

                    @if($pengajuan->status === 'Disetujui')
                        @if($pengajuan->penyaluran)
                            <div class="alert alert-info border border-info-subtle mb-0" style="background-color: #f0f9ff;">
                                <h6 class="fw-bold text-info"><i class="fa-solid fa-truck-moving me-2"></i>Penyaluran Makanan Selesai/Diproses</h6>
                                <p class="mb-0 small text-muted">Aksi Penyaluran atas pengajuan ini telah dibuat dengan kode penyaluran <strong>{{ $pengajuan->penyaluran->kode_penyaluran }}</strong>.</p>
                                @if(Route::has('admin.penyaluran.show'))
                                    <a href="{{ route('admin.penyaluran.show', $pengajuan->penyaluran->id) }}" class="btn btn-sm btn-info text-white rounded-pill px-3 mt-3 w-100">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat Penyaluran
                                    </a>
                                @endif
                            </div>
                        @else
                            <!-- Action button to create Penyaluran -->
                            @if(Route::has('admin.penyaluran.create'))
                                <a href="{{ route('admin.penyaluran.create', ['pengajuan_id' => $pengajuan->id]) }}" class="btn btn-success btn-lg w-100 rounded-pill shadow-sm">
                                    <i class="fa-solid fa-truck-ramp-box me-1"></i> Buat Penyaluran Makanan
                                </a>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
