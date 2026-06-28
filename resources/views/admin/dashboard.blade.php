@extends('layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
<div class="row">
    <!-- Info Boxes -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm border-0">
            <span class="info-box-icon bg-success elevation-1 text-white"><i class="fas fa-building"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted fw-semibold">Total Instansi</span>
                <span class="info-box-number fs-4 fw-bold">{{ $totalInstansi }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm border-0">
            <span class="info-box-icon bg-info elevation-1 text-white"><i class="fas fa-utensils"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted fw-semibold">Total Menu</span>
                <span class="info-box-number fs-4 fw-bold">{{ $totalMenu }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm border-0">
            <span class="info-box-icon bg-warning elevation-1 text-white"><i class="fas fa-clipboard-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted fw-semibold">Total Pengajuan</span>
                <span class="info-box-number fs-4 fw-bold">{{ $totalPengajuan }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm border-0">
            <span class="info-box-icon bg-danger elevation-1 text-white"><i class="fas fa-truck-moving"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted fw-semibold">Total Penyaluran</span>
                <span class="info-box-number fs-4 fw-bold">{{ $totalPenyaluran }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Graphs Section -->
<div class="row mt-4">
    <!-- Chart 1: Pengajuan & Penyaluran per Bulan -->
    <div class="col-12 col-lg-8 mb-4 mb-lg-0">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-chart-bar text-primary me-2"></i>Tren Permintaan & Penyaluran ({{ date('Y') }})</h5>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 300px;">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart 2: Pengajuan Berdasarkan Jenis Instansi -->
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-chart-pie text-primary me-2"></i>Proporsi Pengajuan Instansi</h5>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <div style="position: relative; height: 230px; width: 100%;">
                    <canvas id="instansiTypeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Requests Section -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold text-dark"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Pengajuan Kebutuhan Terbaru</h5>
                @if(Route::has('admin.pengajuan.index'))
                    <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Kode</th>
                                <th>Instansi</th>
                                <th>Kategori Penerima</th>
                                <th class="text-center">Porsi</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanTerbaru as $p)
                                <tr>
                                    <td class="ps-4 fw-semibold text-primary">{{ $p->kode_pengajuan }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $p->instansi->nama_instansi }}</div>
                                        <small class="text-muted">{{ $p->instansi->jenis_instansi }}</small>
                                    </td>
                                    <td>{{ $p->kategori_penerima }}</td>
                                    <td class="text-center fw-semibold">{{ number_format($p->jumlah_porsi) }}</td>
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
                                    <td class="text-center pe-4">
                                        @if(Route::has('admin.pengajuan.show'))
                                            <a href="{{ route('admin.pengajuan.show', $p->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                                                <i class="fa-solid fa-eye me-1"></i> Detail
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data pengajuan masuk.</td>
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

@section('scripts')
<script>
    // 1. Chart Tren Bulanan (Pengajuan vs Penyaluran)
    const trendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: 'Pengajuan Masuk',
                    data: {!! json_encode(array_values($pengajuanPerBulan)) !!},
                    backgroundColor: 'rgba(255, 193, 7, 0.85)', // Warning Yellow
                    borderColor: 'rgb(255, 193, 7)',
                    borderWidth: 1,
                    borderRadius: 5
                },
                {
                    label: 'Penyaluran Selesai',
                    data: {!! json_encode(array_values($penyaluranPerBulan)) !!},
                    backgroundColor: 'rgba(44, 124, 143, 0.85)', // Contrast Blue
                    borderColor: 'rgb(44, 124, 143)',
                    borderWidth: 1,
                    borderRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        font: { family: 'Plus Jakarta Sans', weight: '600' }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { family: 'Plus Jakarta Sans' }
                    },
                    grid: {
                        color: '#f1f5f9'
                    }
                },
                x: {
                    ticks: {
                        font: { family: 'Plus Jakarta Sans' }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // 2. Chart Proporsi Kategori Instansi
    const instansiCtx = document.getElementById('instansiTypeChart').getContext('2d');
    new Chart(instansiCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($jenisCategories)) !!},
            datasets: [{
                data: {!! json_encode(array_values($jenisCategories)) !!},
                backgroundColor: [
                    '#2c7c8f', // TK (Contrast Blue)
                    '#b5e0ea', // SD (Pastel Sky Blue)
                    '#ffb74d', // Posyandu (Pastel Orange)
                    '#f48fb1'  // Puskesmas (Pastel Pink)
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        font: { family: 'Plus Jakarta Sans', weight: '600' }
                    }
                }
            },
            cutout: '65%'
        }
    });
</script>
@endsection
