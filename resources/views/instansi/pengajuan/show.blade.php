@extends('layouts.app')

@section('page_title', 'Detail Pengajuan')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 mb-4 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-file-invoice text-primary me-2"></i>Rincian Pengajuan</h5>
                
                @if($pengajuan->status === 'Menunggu')
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fa-solid fa-hourglass-half me-1"></i>Menunggu Verifikasi</span>
                @elseif($pengajuan->status === 'Disetujui')
                    <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fa-solid fa-check-circle me-1"></i>Telah Disetujui</span>
                @else
                    <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fa-solid fa-times-circle me-1"></i>Ditolak</span>
                @endif
            </div>
            
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-5 fw-bold text-muted">Kode Pengajuan</div>
                    <div class="col-sm-7 fw-bold text-primary">{{ $pengajuan->kode_pengajuan }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5 fw-bold text-muted">Kategori Sasaran</div>
                    <div class="col-sm-7">{{ $pengajuan->kategori_penerima }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5 fw-bold text-muted">Jumlah Penerima</div>
                    <div class="col-sm-7">{{ number_format($pengajuan->jumlah_penerima) }} orang</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5 fw-bold text-muted">Jumlah Porsi</div>
                    <div class="col-sm-7 fw-bold text-success">{{ number_format($pengajuan->jumlah_porsi) }} porsi</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5 fw-bold text-muted">Tanggal Pengajuan</div>
                    <div class="col-sm-7">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->translatedFormat('d F Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5 fw-bold text-muted">Rencana Distribusi</div>
                    <div class="col-sm-7 fw-semibold text-dark">{{ \Carbon\Carbon::parse($pengajuan->tanggal_distribusi)->translatedFormat('d F Y') }}</div>
                </div>
                
                <hr class="my-4">
                
                <div>
                    <h6 class="fw-bold text-muted mb-2"><i class="fa-solid fa-comment-dots text-primary me-2"></i>Catatan Tambahan:</h6>
                    <p class="text-muted bg-light p-3 rounded border border-light-subtle mb-0" style="min-height: 80px;">{{ $pengajuan->catatan ?? 'Tidak ada catatan khusus.' }}</p>
                </div>
            </div>
            
            @if($pengajuan->status === 'Menunggu')
                <div class="card-footer bg-white border-top-0 d-flex justify-content-end gap-2 pb-4">
                    <a href="{{ route('instansi.pengajuan.edit', $pengajuan->id) }}" class="btn btn-warning rounded-pill px-4 btn-sm">
                        <i class="fa-solid fa-edit me-1"></i> Edit Pengajuan
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Penyaluran / Tanggapan Admin -->
    <div class="col-md-6">
        @if($pengajuan->status !== 'Menunggu')
            <!-- Feedback Admin Card -->
            <div class="card shadow-sm border-0 mb-4 bg-light">
                <div class="card-body">
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="fa-solid fa-reply text-success me-2"></i>Tanggapan SPPG
                    </h5>
                    <p class="mb-2">Keputusan Tanggapan: 
                        @if($pengajuan->status === 'Disetujui')
                            <strong class="text-success">Disetujui</strong>
                        @else
                            <strong class="text-danger">Ditolak</strong>
                        @endif
                    </p>
                    <div class="p-3 border rounded bg-white">
                        <small class="text-muted d-block mb-1">Catatan Verifikasi Admin:</small>
                        <p class="mb-0 fw-semibold">{{ $pengajuan->catatan_verifikasi ?? $pengajuan->catatan ?? 'Pengajuan telah diproses sesuai dengan verifikasi sistem.' }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($pengajuan->penyaluran)
            <!-- Penyaluran Tracking Card -->
            <div class="card shadow-sm border-0 mb-4 border-start border-4 border-success">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold text-success"><i class="fa-solid fa-truck-moving me-2"></i>Status Penyaluran Makanan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-5 fw-bold text-muted">Kode Penyaluran</div>
                        <div class="col-sm-7 fw-bold text-success">{{ $pengajuan->penyaluran->kode_penyaluran }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 fw-bold text-muted">Menu Makanan</div>
                        <div class="col-sm-7 fw-bold text-primary">{{ $pengajuan->penyaluran->menu_makanan->nama_menu }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 fw-bold text-muted">Tanggal Salur</div>
                        <div class="col-sm-7">{{ \Carbon\Carbon::parse($pengajuan->penyaluran->tanggal_penyaluran)->translatedFormat('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 fw-bold text-muted">Jumlah Porsi Salur</div>
                        <div class="col-sm-7 fw-bold">{{ number_format($pengajuan->penyaluran->jumlah_disalurkan) }} porsi</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 fw-bold text-muted">Status Pengiriman</div>
                        <div class="col-sm-7">
                            @if($pengajuan->penyaluran->status_pengiriman === 'Diproses')
                                <span class="badge bg-secondary px-3 py-2 rounded-pill"><i class="fa-solid fa-circle-notch fa-spin me-1"></i>Diproses</span>
                            @elseif($pengajuan->penyaluran->status_pengiriman === 'Dikirim')
                                <span class="badge bg-info px-3 py-2 rounded-pill"><i class="fa-solid fa-truck me-1"></i>Sedang Dikirim</span>
                            @else
                                <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fa-solid fa-circle-check me-1"></i>Selesai</span>
                            @endif
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="p-3 border rounded bg-white">
                        <small class="text-muted d-block mb-1">Keterangan Pengiriman:</small>
                        <p class="mb-0 italic">{{ $pengajuan->penyaluran->keterangan ?? 'Tidak ada keterangan.' }}</p>
                    </div>
                </div>
            </div>
        @elseif($pengajuan->status === 'Disetujui')
            <!-- In preparation message -->
            <div class="card shadow-sm border-0 py-5 text-center text-muted mb-4">
                <div class="card-body">
                    <i class="fa-solid fa-kitchen-set fs-1 mb-3 text-secondary"></i>
                    <h5>Menunggu Penjadwalan Dapur</h5>
                    <p class="mb-0 small px-4">Pengajuan Anda telah disetujui. Tim dapur gizi SPPG sedang memilah ketersediaan menu makanan gizi yang sesuai dan menjadwalkan armada penyaluran.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
