@extends('layouts.app')

@section('page_title', 'Riwayat Pengajuan Makanan')

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
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header -->
            <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-list-check text-primary me-2"></i>Daftar Riwayat Pengajuan Gizi Anda</h5>
                
                <div class="d-flex gap-2 align-items-center">
                    <!-- Search Form -->
                    <form action="{{ route('instansi.pengajuan.index') }}" method="GET" class="d-inline-flex m-0">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-start-pill" placeholder="Cari kode atau kategori..." value="{{ $search }}">
                            <button class="btn btn-primary rounded-end-pill px-3" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Add Button -->
                    <a href="{{ route('instansi.pengajuan.create') }}" class="btn btn-success rounded-pill px-4">
                        <i class="fa-solid fa-plus-circle me-1"></i> Buat Pengajuan
                    </a>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Kode</th>
                                <th class="col-kategori">Kategori Penerima</th>
                                <th class="text-center col-penerima">Jumlah Penerima</th>
                                <th class="text-center">Jumlah Porsi</th>
                                <th class="col-distribusi">Rencana Distribusi</th>
                                <th>Status</th>
                                <th class="text-center pe-4" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuan as $p)
                                <tr>
                                    <td class="ps-4 fw-semibold text-primary">{{ $p->kode_pengajuan }}</td>
                                    <td class="col-kategori">{{ $p->kategori_penerima }}</td>
                                    <td class="text-center col-penerima">{{ number_format($p->jumlah_penerima) }} orang</td>
                                    <td class="text-center fw-bold text-success">{{ number_format($p->jumlah_porsi) }}</td>
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
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('instansi.pengajuan.show', $p->id) }}" class="btn btn-sm btn-outline-info rounded-start-pill px-3" title="Detail">
                                                <i class="fa-solid fa-eye"></i> Detail
                                            </a>
                                            @if($p->status === 'Menunggu')
                                                <a href="{{ route('instansi.pengajuan.edit', $p->id) }}" class="btn btn-sm btn-outline-warning px-3" title="Edit">
                                                    <i class="fa-solid fa-edit"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-end-pill px-3" 
                                                        onclick="confirmCancel({{ $p->id }}, '{{ $p->kode_pengajuan }}')" title="Batalkan">
                                                    <i class="fa-solid fa-ban"></i> Batal
                                                </button>
                                                <form id="cancel-form-{{ $p->id }}" action="{{ route('instansi.pengajuan.destroy', $p->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @else
                                                <span class="btn btn-sm btn-light disabled rounded-end-pill px-3"><i class="fa-solid fa-lock"></i> Terkunci</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-clipboard-question fs-1 text-secondary mb-3"></i>
                                        <p class="mb-0">Belum ada riwayat pengajuan gizi yang dibuat.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer -->
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
    function confirmCancel(id, code) {
        Swal.fire({
            title: 'Batalkan Pengajuan?',
            text: `Apakah Anda yakin ingin membatalkan pengajuan "${code}" secara permanen?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#2c7c8f',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`cancel-form-${id}`).submit();
            }
        })
    }
</script>
@endsection
