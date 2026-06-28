@extends('layouts.app')

@section('page_title', 'Detail Menu Makanan')

@section('content')
<div class="row">
    <div class="col-md-5">
        <!-- Main Card -->
        <div class="card shadow-sm border-0 py-4 mb-4">
            <div class="card-body text-center">
                <div class="bg-success text-white d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-bowl-food fs-1"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $menu->nama_menu }}</h4>
                <p class="text-muted mb-3">{{ $menu->kode_menu }}</p>
                <span class="badge bg-success px-4 py-2 rounded-pill fs-6">{{ $menu->kategori_menu }}</span>
                
                <hr class="my-4">
                
                <h5 class="fw-bold text-start mb-3"><i class="fa-solid fa-circle-info text-success me-2"></i>Komposisi Nutrisi</h5>
                
                <!-- Nutrition Grid -->
                <div class="row text-start g-3">
                    <div class="col-6">
                        <div class="p-3 border rounded bg-light">
                            <small class="text-muted d-block mb-1"><i class="fa-solid fa-fire text-danger me-1"></i> Kalori</small>
                            <span class="fs-5 fw-bold text-danger">{{ $menu->kalori }} <small class="fs-6 text-muted">kcal</small></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded bg-light">
                            <small class="text-muted d-block mb-1"><i class="fa-solid fa-egg text-primary me-1"></i> Protein</small>
                            <span class="fs-5 fw-bold text-primary">{{ $menu->protein }} <small class="fs-6 text-muted">g</small></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded bg-light">
                            <small class="text-muted d-block mb-1"><i class="fa-solid fa-wheat-awn text-warning me-1"></i> Karbohidrat</small>
                            <span class="fs-5 fw-bold text-warning-emphasis">{{ $menu->karbohidrat }} <small class="fs-6 text-muted">g</small></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded bg-light">
                            <small class="text-muted d-block mb-1"><i class="fa-solid fa-droplet text-success me-1"></i> Lemak</small>
                            <span class="fs-5 fw-bold text-success">{{ $menu->lemak }} <small class="fs-6 text-muted">g</small></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top-0 d-flex justify-content-center gap-2">
                <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-warning rounded-pill px-4 btn-sm">
                    <i class="fa-solid fa-edit me-1"></i> Edit Menu
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <!-- Description Card -->
        <div class="card shadow-sm border-0 mb-4 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-align-left text-success me-2"></i>Deskripsi Menu & Kandungan Gizi</h5>
            </div>
            <div class="card-body">
                <p class="fs-5 text-muted" style="line-height: 1.8;">{{ $menu->deskripsi }}</p>
                
                <div class="alert alert-success-light border border-success-subtle rounded p-3 mt-4" style="background-color: #f4faf6;">
                    <h6 class="fw-bold text-success mb-2"><i class="fa-solid fa-circle-check me-2"></i>Status Kesiapan Menu</h6>
                    <p class="mb-0 text-muted small">Menu ini telah lolos verifikasi standar gizi SPPG (Satuan Pelayanan Pemenuhan Gizi) dan siap digunakan untuk penyaluran bantuan makanan bagi kategori sasaran <strong>{{ $menu->kategori_menu }}</strong>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
