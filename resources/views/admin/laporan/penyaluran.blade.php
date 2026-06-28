@extends('layouts.app')

@section('page_title', 'Laporan Penyaluran Makanan')

@section('content')
<div class="row">
    <!-- Filter Card -->
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-filter text-success me-2"></i>Filter Laporan Penyaluran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.laporan.penyaluran') }}" method="GET" class="row g-3">
                    <!-- Tanggal Awal -->
                    <div class="col-md-4">
                        <label for="tanggal_awal" class="form-label fw-bold">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ $tglAwal }}">
                    </div>

                    <!-- Tanggal Akhir -->
                    <div class="col-md-4">
                        <label for="tanggal_akhir" class="form-label fw-bold">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ $tglAkhir }}">
                    </div>

                    <!-- Instansi -->
                    <div class="col-md-4">
                        <label for="instansi_id" class="form-label fw-bold">Instansi Penerima</label>
                        <select name="instansi_id" id="instansi_id" class="form-select">
                            <option value="">Semua Instansi</option>
                            @foreach($instansiList as $ins)
                                <option value="{{ $ins->id }}" {{ $instansiId == $ins->id ? 'selected' : '' }}>
                                    {{ $ins->nama_instansi }} ({{ $ins->jenis_instansi }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Filter Data
                        </button>
                        
                        <a href="{{ route('admin.laporan.penyaluran.pdf', request()->query()) }}" class="btn btn-outline-danger rounded-pill px-4">
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
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-truck-ramp-box text-success me-2"></i>Hasil Laporan Penyaluran</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Kode Salur</th>
                                <th>Kode Pengajuan</th>
                                <th>Instansi</th>
                                <th>Menu Makanan</th>
                                <th class="text-center">Jumlah Disalurkan</th>
                                <th>Tanggal Penyaluran</th>
                                <th>Status Pengiriman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $p)
                                <tr>
                                    <td class="ps-4 fw-semibold text-success">{{ $p->kode_penyaluran }}</td>
                                    <td>{{ $p->pengajuan->kode_pengajuan }}</td>
                                    <td><span class="fw-bold">{{ $p->pengajuan->instansi->nama_instansi }}</span></td>
                                    <td>{{ $p->menu_makanan->nama_menu }}</td>
                                    <td class="text-center fw-semibold text-success">{{ number_format($p->jumlah_disalurkan) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_penyaluran)->translatedFormat('d M Y') }}</td>
                                    <td>
                                        @if($p->status_pengiriman === 'Diproses')
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">Diproses</span>
                                        @elseif($p->status_pengiriman === 'Dikirim')
                                            <span class="badge bg-info px-3 py-2 rounded-pill">Dikirim</span>
                                        @else
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fs-1 text-secondary mb-3"></i>
                                        <p class="mb-0">Tidak ada data penyaluran yang cocok dengan kriteria filter.</p>
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
