@extends('layouts.app')

@section('page_title', 'Penyaluran Menu Makanan')

@section('css')
<style>
    @media (max-width: 991px) {
        .col-menu { display: none; }
    }
    @media (max-width: 768px) {
        .col-tgl-salur { display: none; }
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header -->
            <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-truck-moving text-success me-2"></i>Daftar Distribusi Penyaluran MBG</h5>
                
                <div class="d-flex gap-2 align-items-center">
                    <!-- Search Form -->
                    <form action="{{ route('admin.penyaluran.index') }}" method="GET" class="d-inline-flex m-0">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-start-pill" placeholder="Cari kode atau instansi..." value="{{ $search }}">
                            <button class="btn btn-success rounded-end-pill px-3" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Add Button -->
                    <a href="{{ route('admin.penyaluran.create') }}" class="btn btn-success rounded-pill px-4">
                        <i class="fa-solid fa-plus-circle me-1"></i> Penyaluran Baru
                    </a>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Kode Salur</th>
                                <th>Pengajuan (Instansi)</th>
                                <th class="col-menu">Menu Makanan</th>
                                <th class="text-center">Jumlah Porsi</th>
                                <th class="col-tgl-salur">Tanggal Salur</th>
                                <th>Status Pengiriman</th>
                                <th class="text-center pe-4" style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penyaluran as $p)
                                <tr>
                                    <td class="ps-4 fw-semibold text-success">{{ $p->kode_penyaluran }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $p->pengajuan->instansi->nama_instansi }}</div>
                                        <small class="text-muted">{{ $p->pengajuan->kode_pengajuan }}</small>
                                    </td>
                                    <td class="col-menu">
                                        <div class="fw-semibold">{{ $p->menu_makanan->nama_menu }}</div>
                                        <small class="badge bg-light text-muted border">{{ $p->menu_makanan->kategori_menu }}</small>
                                    </td>
                                    <td class="text-center fw-bold">{{ number_format($p->jumlah_disalurkan) }}</td>
                                    <td class="col-tgl-salur">{{ \Carbon\Carbon::parse($p->tanggal_penyaluran)->translatedFormat('d M Y') }}</td>
                                    <td>
                                        @if($p->status_pengiriman === 'Diproses')
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill"><i class="fa-solid fa-circle-notch fa-spin me-1"></i>Diproses</span>
                                        @elseif($p->status_pengiriman === 'Dikirim')
                                            <span class="badge bg-info px-3 py-2 rounded-pill"><i class="fa-solid fa-truck me-1"></i>Dikirim</span>
                                        @else
                                            <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fa-solid fa-check-circle me-1"></i>Selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.penyaluran.show', $p->id) }}" class="btn btn-sm btn-outline-info rounded-start-pill px-3" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.penyaluran.edit', $p->id) }}" class="btn btn-sm btn-outline-warning px-3" title="Edit">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-end-pill px-3" 
                                                    onclick="confirmDelete({{ $p->id }}, '{{ $p->kode_penyaluran }}')" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $p->id }}" action="{{ route('admin.penyaluran.destroy', $p->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-truck-ramp-box fs-1 text-secondary mb-3"></i>
                                        <p class="mb-0">Tidak ada riwayat penyaluran ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer Pagination -->
            @if($penyaluran->hasPages())
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                    {!! $penyaluran->links('pagination::bootstrap-5') !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(id, code) {
        Swal.fire({
            title: 'Hapus Penyaluran?',
            text: `Apakah Anda yakin ingin menghapus catatan penyaluran "${code}" secara permanen?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#2c7c8f',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        })
    }
</script>
@endsection
