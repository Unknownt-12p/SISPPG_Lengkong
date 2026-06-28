@extends('layouts.app')

@section('page_title', 'Data Menu Makanan')

@section('css')
<style>
    /* Sembunyikan kolom nutrisi di layar kecil */
    @media (max-width: 991px) {
        .col-karbohidrat, .col-lemak { display: none; }
    }
    @media (max-width: 768px) {
        .col-protein { display: none; }
    }
    @media (max-width: 576px) {
        .col-kalori { display: none; }
        .card-header .d-flex { flex-direction: column; width: 100%; }
        .card-header .input-group { max-width: 100%; }
        .card-header .btn { width: 100%; justify-content: center; }
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header -->
            <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <h5 class="card-title mb-0 fw-bold"><i class="fa-solid fa-utensils text-success me-2"></i>Daftar Menu Makanan Bergizi</h5>
                
                <div class="d-flex gap-2 align-items-center">
                    <!-- Search Form -->
                    <form action="{{ route('admin.menu.index') }}" method="GET" class="d-inline-flex m-0">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-start-pill" placeholder="Cari kode atau nama menu..." value="{{ $search }}">
                            <button class="btn btn-success rounded-end-pill px-3" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Add Button -->
                    <a href="{{ route('admin.menu.create') }}" class="btn btn-success rounded-pill px-4">
                        <i class="fa-solid fa-plus-circle me-1"></i> Tambah Menu
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
                                <th>Nama Menu</th>
                                <th>Kategori</th>
                                <th class="text-center col-kalori">Kalori</th>
                                <th class="text-center col-protein">Protein</th>
                                <th class="text-center col-karbohidrat">Karbohidrat</th>
                                <th class="text-center col-lemak">Lemak</th>
                                <th class="text-center pe-4" style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menu as $m)
                                <tr>
                                    <td class="ps-4 fw-semibold text-success">{{ $m->kode_menu }}</td>
                                    <td><span class="fw-bold">{{ $m->nama_menu }}</span></td>
                                    <td>
                                        <span class="badge bg-success text-white px-3 py-2 rounded-pill">{{ $m->kategori_menu }}</span>
                                    </td>
                                    <td class="text-center fw-semibold text-danger col-kalori">{{ $m->kalori }} kcal</td>
                                    <td class="text-center fw-semibold text-primary col-protein">{{ $m->protein }}g</td>
                                    <td class="text-center fw-semibold text-warning-emphasis col-karbohidrat">{{ $m->karbohidrat }}g</td>
                                    <td class="text-center fw-semibold text-success col-lemak">{{ $m->lemak }}g</td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.menu.show', $m->id) }}" class="btn btn-sm btn-outline-info rounded-start-pill px-3" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.menu.edit', $m->id) }}" class="btn btn-sm btn-outline-warning px-3" title="Edit">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-end-pill px-3" 
                                                    onclick="confirmDelete({{ $m->id }}, '{{ $m->nama_menu }}')" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $m->id }}" action="{{ route('admin.menu.destroy', $m->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-bowl-food fs-1 text-secondary mb-3"></i>
                                        <p class="mb-0">Tidak ada data menu makanan ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer Pagination -->
            @if($menu->hasPages())
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                    {!! $menu->links('pagination::bootstrap-5') !!}
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
            title: 'Hapus Menu?',
            text: `Apakah Anda yakin ingin menghapus menu "${name}" secara permanen?`,
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
