@extends('layouts.app')

@section('page_title', 'Data Instansi')

@section('css')
<style>
    @media (max-width: 991px) {
        .col-email { display: none; }
    }
    @media (max-width: 768px) {
        .col-telepon { display: none; }
    }
    @media (max-width: 576px) {
        .col-pj { display: none; }
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header -->
            <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-building text-success me-2"></i>Daftar Mitra Instansi SPPG</h5>
                
                <div class="d-flex gap-2 align-items-center">
                    <!-- Search Form -->
                    <form action="{{ route('admin.instansi.index') }}" method="GET" class="d-inline-flex m-0">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-start-pill" placeholder="Cari kode, nama, penanggung jawab..." value="{{ $search }}">
                            <button class="btn btn-success rounded-end-pill px-3" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Add Button -->
                    <a href="{{ route('admin.instansi.create') }}" class="btn btn-success rounded-pill px-4">
                        <i class="fa-solid fa-plus-circle me-1"></i> Tambah Instansi
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
                                <th>Nama Instansi</th>
                                <th>Jenis</th>
                                <th class="col-pj">Penanggung Jawab</th>
                                <th class="col-telepon">Telepon</th>
                                <th class="col-email">Email</th>
                                <th class="text-center pe-4" style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($instansi as $i)
                                <tr>
                                    <td class="ps-4 fw-semibold text-success">{{ $i->kode_instansi }}</td>
                                    <td><span class="fw-bold">{{ $i->nama_instansi }}</span></td>
                                    <td>
                                        @if($i->jenis_instansi === 'TK')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Anak TK</span>
                                        @elseif($i->jenis_instansi === 'SD')
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">Anak SD</span>
                                        @elseif($i->jenis_instansi === 'Posyandu')
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 rounded-pill">Posyandu</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Puskesmas</span>
                                        @endif
                                    </td>
                                    <td class="col-pj">{{ $i->penanggung_jawab }}</td>
                                    <td class="col-telepon">{{ $i->telepon }}</td>
                                    <td class="col-email">{{ $i->email }}</td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.instansi.show', $i->id) }}" class="btn btn-sm btn-outline-info rounded-start-pill px-3" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.instansi.edit', $i->id) }}" class="btn btn-sm btn-outline-warning px-3" title="Edit">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-end-pill px-3" 
                                                    onclick="confirmDelete({{ $i->id }}, '{{ $i->nama_instansi }}')" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $i->id }}" action="{{ route('admin.instansi.destroy', $i->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-building-circle-exclamation fs-1 text-secondary mb-3"></i>
                                        <p class="mb-0">Tidak ada data instansi ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer Pagination -->
            @if($instansi->hasPages())
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                    {!! $instansi->links('pagination::bootstrap-5') !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Instansi?',
            text: `Apakah Anda yakin ingin menghapus "${name}" beserta akun loginnya secara permanen? Data pengajuan instansi ini juga akan hilang.`,
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
