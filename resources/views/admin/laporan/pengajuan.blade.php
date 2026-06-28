@extends('layouts.app')

@section('page_title', 'Laporan Pengajuan Makanan')

@section('content')
<div class="row">
    <!-- Filter Card -->
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-filter text-success me-2"></i>Filter Laporan Pengajuan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.laporan.pengajuan') }}" method="GET" class="row g-3">
                    <!-- Tanggal Awal -->
                    <div class="col-md-3">
                        <label for="tanggal_awal" class="form-label fw-bold">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ $tglAwal }}">
                    </div>

                    <!-- Tanggal Akhir -->
                    <div class="col-md-3">
                        <label for="tanggal_akhir" class="form-label fw-bold">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ $tglAkhir }}">
                    </div>

                    <!-- Instansi -->
                    <div class="col-md-3">
                        <label for="instansi_id" class="form-label fw-bold">Instansi Mitra</label>
                        <select name="instansi_id" id="instansi_id" class="form-select">
                            <option value="">Semua Instansi</option>
                            @foreach($instansiList as $ins)
                                <option value="{{ $ins->id }}" {{ $instansiId == $ins->id ? 'selected' : '' }}>
                                    {{ $ins->nama_instansi }} ({{ $ins->jenis_instansi }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-3">
                        <label for="status" class="form-label fw-bold">Status Verifikasi</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Menunggu" {{ $status === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Disetujui" {{ $status === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ $status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Filter Data
                        </button>
                        
                        <a href="{{ route('admin.laporan.pengajuan.pdf', request()->query()) }}" class="btn btn-outline-danger rounded-pill px-4">
                            <i class="fa-solid fa-file-pdf me-1"></i> Export PDF
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-list-check text-success me-2"></i>Hasil Laporan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Kode</th>
                                <th>Nama Instansi</th>
                                <th>Jenis</th>
                                <th>Kategori</th>
                                <th class="text-center">Porsi</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Rencana</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $p)
                                <tr>
                                    <td class="ps-4 fw-semibold text-success">{{ $p->kode_pengajuan }}</td>
                                    <td><span class="fw-bold">{{ $p->instansi->nama_instansi }}</span></td>
                                    <td>{{ $p->instansi->jenis_instansi }}</td>
                                    <td>{{ $p->kategori_penerima }}</td>
                                    <td class="text-center fw-semibold">{{ number_format($p->jumlah_porsi) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->translatedFormat('d M Y') }}</td>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fs-1 text-secondary mb-3"></i>
                                        <p class="mb-0">Tidak ada data transaksi yang cocok dengan kriteria filter.</p>
                                    </td>
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
