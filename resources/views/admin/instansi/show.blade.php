@extends('layouts.app')

@section('page_title', 'Detail Instansi')

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Profile Card -->
        <div class="card shadow-sm border-0 text-center py-4 mb-4">
            <div class="card-body">
                <div class="bg-success text-white d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-building fs-1"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $instansi->nama_instansi }}</h4>
                <p class="text-muted mb-3">{{ $instansi->kode_instansi }}</p>
                
                @if($instansi->jenis_instansi === 'TK')
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Anak TK</span>
                @elseif($instansi->jenis_instansi === 'SD')
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">Anak SD</span>
                @elseif($instansi->jenis_instansi === 'Posyandu')
                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 rounded-pill">Posyandu</span>
                @else
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Puskesmas</span>
                @endif
                
                <hr class="my-4">
                
                <div class="text-start">
                    <p class="mb-2"><strong><i class="fa-solid fa-user me-2 text-success"></i>Penanggung Jawab:</strong><br><span class="ms-4 text-muted">{{ $instansi->penanggung_jawab }}</span></p>
                    <p class="mb-2"><strong><i class="fa-solid fa-phone me-2 text-success"></i>Telepon / WA:</strong><br><span class="ms-4 text-muted">{{ $instansi->telepon }}</span></p>
                    <p class="mb-0"><strong><i class="fa-solid fa-envelope me-2 text-success"></i>Email Kredensial:</strong><br><span class="ms-4 text-muted">{{ $instansi->email }}</span></p>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 d-flex justify-content-center gap-2">
                <a href="{{ route('admin.instansi.edit', $instansi->id) }}" class="btn btn-warning rounded-pill px-4 btn-sm">
                    <i class="fa-solid fa-edit me-1"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Address & History Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-map-location-dot text-success me-2"></i>Alamat & Lokasi</h5>
            </div>
            <div class="card-body">
                <p class="mb-0 fs-5 text-muted">{{ $instansi->alamat }}</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-list-check text-success me-2"></i>Riwayat Pengajuan Makanan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Kode Pengajuan</th>
                                <th>Kategori</th>
                                <th class="text-center">Jumlah Porsi</th>
                                <th>Tgl Pengajuan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($instansi->pengajuan as $p)
                                <tr>
                                    <td class="ps-4 fw-semibold text-success">{{ $p->kode_pengajuan }}</td>
                                    <td>{{ $p->kategori_penerima }}</td>
                                    <td class="text-center fw-bold">{{ number_format($p->jumlah_porsi) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->translatedFormat('d M Y') }}</td>
                                    <td>
                                        @if($p->status === 'Menunggu')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu</span>
                                        @elseif($p->status === 'Disetujui')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Instansi ini belum pernah melakukan pengajuan kebutuhan.</td>
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
