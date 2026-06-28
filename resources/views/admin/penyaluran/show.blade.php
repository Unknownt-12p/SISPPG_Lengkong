@extends('layouts.app')

@section('page_title', 'Detail Penyaluran')

@section('content')
<div class="row">
    <div class="col-md-7">
        <!-- Distribution details card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.penyaluran.index') }}" class="btn btn-outline-success btn-sm rounded-circle me-3" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-truck-flatbed text-success me-2"></i>Rincian Distribusi</h5>
                </div>
                
                @if($penyaluran->status_pengiriman === 'Diproses')
                    <span class="badge bg-secondary px-3 py-2 rounded-pill"><i class="fa-solid fa-circle-notch fa-spin me-1"></i>Diproses</span>
                @elseif($penyaluran->status_pengiriman === 'Dikirim')
                    <span class="badge bg-info px-3 py-2 rounded-pill"><i class="fa-solid fa-truck me-1"></i>Dalam Pengiriman</span>
                @else
                    <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fa-solid fa-circle-check me-1"></i>Telah Diterima</span>
                @endif
            </div>
            
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Kode Salur</div>
                    <div class="col-sm-8 fw-bold text-success">{{ $penyaluran->kode_penyaluran }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Kode Pengajuan</div>
                    <div class="col-sm-8 fw-semibold text-dark">{{ $penyaluran->pengajuan->kode_pengajuan }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Instansi Penerima</div>
                    <div class="col-sm-8 fw-bold text-dark">{{ $penyaluran->pengajuan->instansi->nama_instansi }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Menu Makanan</div>
                    <div class="col-sm-8 fw-bold text-primary">{{ $penyaluran->menu_makanan->nama_menu }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Jumlah Porsi</div>
                    <div class="col-sm-8 fw-bold text-success">{{ number_format($penyaluran->jumlah_disalurkan) }} porsi</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold text-muted">Tanggal Penyaluran</div>
                    <div class="col-sm-8">{{ \Carbon\Carbon::parse($penyaluran->tanggal_penyaluran)->translatedFormat('d F Y') }}</div>
                </div>
                
                <hr class="my-4">
                
                <div>
                    <h6 class="fw-bold text-muted mb-2"><i class="fa-solid fa-file-invoice text-success me-2"></i>Keterangan Logistik Pengiriman:</h6>
                    <p class="text-muted bg-light p-3 rounded border border-light-subtle mb-0" style="min-height: 80px;">{{ $penyaluran->keterangan ?? 'Tidak ada keterangan tambahan.' }}</p>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top-0 d-flex justify-content-end gap-2 pb-4">
                <a href="{{ route('admin.penyaluran.edit', $penyaluran->id) }}" class="btn btn-warning rounded-pill px-4 btn-sm">
                    <i class="fa-solid fa-edit me-1"></i> Ubah Status/Data
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column: Nutrition / Instansi contact overview -->
    <div class="col-md-5">
        <!-- Instansi Profile Overview -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-success"><i class="fa-solid fa-building me-2"></i>Kontak & Penerima</h5>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Penanggung Jawab:</strong> {{ $penyaluran->pengajuan->instansi->penanggung_jawab }}</p>
                <p class="mb-2"><strong>Telepon / WA:</strong> {{ $penyaluran->pengajuan->instansi->telepon }}</p>
                <p class="mb-0 text-muted"><strong>Alamat Pengiriman:</strong><br>{{ $penyaluran->pengajuan->instansi->alamat }}</p>
            </div>
        </div>

        <!-- Menu Nutrition Overview -->
        <div class="card shadow-sm border-0 border-top border-4 border-success">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-success"><i class="fa-solid fa-wheat-awn me-2"></i>Detail Menu Gizi</h5>
            </div>
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">{{ $penyaluran->menu_makanan->nama_menu }}</h6>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="p-2 border rounded text-center">
                            <small class="text-muted d-block mb-1">Kalori</small>
                            <span class="fw-bold text-danger">{{ $penyaluran->menu_makanan->kalori }} kcal</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded text-center">
                            <small class="text-muted d-block mb-1">Protein</small>
                            <span class="fw-bold text-primary">{{ $penyaluran->menu_makanan->protein }}g</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded text-center">
                            <small class="text-muted d-block mb-1">Karbohidrat</small>
                            <span class="fw-bold text-warning-emphasis">{{ $penyaluran->menu_makanan->karbohidrat }}g</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded text-center">
                            <small class="text-muted d-block mb-1">Lemak</small>
                            <span class="fw-bold text-success">{{ $penyaluran->menu_makanan->lemak }}g</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
