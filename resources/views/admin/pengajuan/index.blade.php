@extends('layouts.app')

@section('page_title', 'Pengajuan Menu Makanan')

@section('css')
<style>
    @media (max-width: 991px) {
        .col-penerima { display: none; }
    }
    @media (max-width: 768px) {
        .col-distribusi { display: none; }
    }
    @media (max-width: 576px) {
        .col-kategori { display: none; }
        .filter-form { flex-direction: column !important; width: 100%; }
        .filter-form select, .filter-form .input-group { width: 100% !important; }
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header -->
            <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-clipboard-list text-success me-2"></i>Daftar Pengajuan Menu Makanan</h5>
                
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <!-- Status Filter -->
                    <form action="{{ route('admin.pengajuan.index') }}" method="GET" class="d-inline-flex m-0 gap-2 filter-form flex-wrap">
                        <select name="status" class="form-select rounded-pill" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="Menunggu" {{ $status === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Disetujui" {{ $status === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ $status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>

                        <!-- Search Box -->
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-start-pill" placeholder="Cari kode atau instansi..." value="{{ $search }}">
                            <button class="btn btn-success rounded-end-pill px-3" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Kode</th>
                                <th>Instansi Pengaju</th>
                                <th class="col-kategori">Kategori Sasaran</th>
                                <th class="text-center col-penerima">Jumlah Penerima</th>
                                <th class="text-center">Jumlah Porsi</th>
                                <th class="col-distribusi">Rencana Distribusi</th>
                                <th>Status</th>
                                <th class="text-center pe-4" style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuan as $p)
                                <tr>
                                    <td class="ps-4 fw-semibold text-success">{{ $p->kode_pengajuan }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $p->instansi->nama_instansi }}</div>
                                        <span class="badge bg-light text-muted border px-2 py-1 small">{{ $p->instansi->jenis_instansi }}</span>
                                    </td>
                                    <td class="col-kategori">{{ $p->kategori_penerima }}</td>
                                    <td class="text-center col-penerima">{{ number_format($p->jumlah_penerima) }} orang</td>
                                    <td class="text-center fw-semibold text-success">{{ number_format($p->jumlah_porsi) }}</td>
                                    <td class="col-distribusi">{{ \Carbon\Carbon::parse($p->tanggal_distribusi)->translatedFormat('d M Y') }}</td>
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
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.pengajuan.show', $p->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3" title="Periksa">
                                                <i class="fa-solid fa-eye me-1"></i> Periksa
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                    onclick="confirmDelete({{ $p->id }}, '{{ $p->kode_pengajuan }}')" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $p->id }}" action="{{ route('admin.pengajuan.destroy', $p->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-clipboard-question fs-1 text-secondary mb-3"></i>
                                        <p class="mb-0">Tidak ada data pengajuan makanan masuk.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer Pagination -->
            @if($pengajuan->hasPages())
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                    {!! $pengajuan->links('pagination::bootstrap-5') !!}
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
            title: 'Hapus Pengajuan?',
            text: `Pengajuan "${code}" akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
@endsection
