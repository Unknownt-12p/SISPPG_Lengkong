@extends('layouts.app')

@section('page_title', 'Instansi Dashboard')

@section('content')
<div class="row">
    <!-- Info Boxes -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm border-0">
            <span class="info-box-icon bg-primary elevation-1 text-white"><i class="fas fa-history"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted fw-semibold">Total Pengajuan</span>
                <span class="info-box-number fs-4 fw-bold">{{ $totalPengajuan }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm border-0">
            <span class="info-box-icon bg-warning elevation-1 text-white"><i class="fas fa-hourglass-half"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted fw-semibold">Menunggu</span>
                <span class="info-box-number fs-4 fw-bold">{{ $menunggu }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm border-0">
            <span class="info-box-icon bg-success elevation-1 text-white"><i class="fas fa-check-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted fw-semibold">Disetujui</span>
                <span class="info-box-number fs-4 fw-bold">{{ $disetujui }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm border-0">
            <span class="info-box-icon bg-danger elevation-1 text-white"><i class="fas fa-times-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted fw-semibold">Ditolak</span>
                <span class="info-box-number fs-4 fw-bold">{{ $ditolak }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Action Card -->
    <div class="col-12 col-lg-4 mb-4 mb-lg-0">
        <div class="card shadow-sm border-0 h-100 py-3" style="background-color: var(--pastel-blue) !important; color: var(--text-dark) !important;">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <h4 class="fw-bold mb-3"><i class="fa-solid fa-utensils me-2"></i>Ajukan Pemesanan Menu Makanan</h4>
                    <p class="mb-4" style="color: rgba(30, 41, 59, 0.8) !important;">Ajukan permintaan pemenuhan gizi untuk anak-anak didik, balita, atau ibu hamil/menyusui di wilayah pelayanan instansi Anda sekarang.</p>
                </div>
                @if(Route::has('instansi.pengajuan.create'))
                    <a href="{{ route('instansi.pengajuan.create') }}" class="btn btn-lg fw-bold w-100 rounded-pill shadow-sm" style="background-color: var(--primary-blue) !important; border: none !important; color: white !important;">
                        <i class="fa-solid fa-plus-circle me-1"></i> Buat Pengajuan Baru
                    </a>
                @else
                    <button class="btn btn-lg fw-bold w-100 rounded-pill shadow-sm" style="background-color: var(--primary-blue) !important; border: none !important; color: white !important;" disabled>
                        <i class="fa-solid fa-plus-circle me-1"></i> Buat Pengajuan Baru
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- History Card -->
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-list-check text-primary me-2"></i>Riwayat Pengajuan Terakhir</h5>
                @if(Route::has('instansi.pengajuan.index'))
                    <a href="{{ route('instansi.pengajuan.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Semua Riwayat</a>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Kode</th>
                                <th>Kategori</th>
                                <th class="text-center">Porsi</th>
                                <th>Tgl Distribusi</th>
                                <th>Status</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatPengajuan as $p)
                                <tr>
                                    <td class="ps-4 fw-semibold text-primary">{{ $p->kode_pengajuan }}</td>
                                    <td>{{ $p->kategori_penerima }}</td>
                                    <td class="text-center fw-semibold">{{ number_format($p->jumlah_porsi) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_distribusi)->translatedFormat('d M Y') }}</td>
                                    <td>
                                        @if($p->status === 'Menunggu')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu</span>
                                        @elseif($p->status === 'Disetujui')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        @if($p->status === 'Menunggu' && Route::has('instansi.pengajuan.edit'))
                                            <a href="{{ route('instansi.pengajuan.edit', $p->id) }}" class="btn btn-sm btn-outline-warning px-3 rounded-pill me-1">
                                                <i class="fa-solid fa-edit"></i> Edit
                                            </a>
                                        @endif
                                        @if(Route::has('instansi.pengajuan.show'))
                                            <a href="{{ route('instansi.pengajuan.show', $p->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                                                <i class="fa-solid fa-eye"></i> Detail
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat pengajuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
