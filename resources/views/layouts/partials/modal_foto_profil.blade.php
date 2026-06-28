<!-- Modal Ganti Foto Profil -->
<div class="modal fade" id="modalFotoProfil" tabindex="-1" aria-labelledby="modalFotoProfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">

            <!-- Modal Header -->
            <div class="modal-header border-0 pb-0" style="background: linear-gradient(135deg, #2c7c8f, #b5e0ea); padding: 24px 24px 16px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width:42px;height:42px;">
                        <i class="fa-solid fa-camera text-white fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0" id="modalFotoProfilLabel">Ganti Foto Profil</h5>
                        <small class="text-white opacity-75">JPG, PNG, WEBP — maks. 2MB</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">

                <!-- Preview Avatar -->
                <div class="text-center mb-4">
                    <div class="position-relative d-inline-block">
                        <div id="avatar-preview-container" class="rounded-circle overflow-hidden mx-auto shadow"
                             style="width:110px;height:110px;border:4px solid #e2e8f0;">
                            @if(Auth::user()->foto_profil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                                     alt="Foto Profil" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center fw-bold text-white fs-2"
                                     style="background: linear-gradient(135deg, #2c7c8f, #1f5866);">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <label for="foto_profil_input"
                               class="position-absolute bottom-0 end-0 rounded-circle d-flex align-items-center justify-content-center"
                               style="width:32px;height:32px;background:#2c7c8f;border:2px solid white;cursor:pointer;">
                            <i class="fa-solid fa-pen text-white" style="font-size:11px;"></i>
                        </label>
                    </div>
                    <p class="text-muted small mt-2 mb-0">Klik ikon <i class="fa-solid fa-pen text-primary"></i> untuk memilih foto</p>
                </div>

                <!-- Form Upload Foto (terpisah dari hapus) -->
                <form action="{{ route('profile.foto.update') }}" method="POST"
                      enctype="multipart/form-data" id="form-upload-foto">
                    @csrf
                    <div class="mb-3">
                        <label for="foto_profil_input" class="form-label fw-semibold">Pilih Foto Baru</label>
                        <input type="file" name="foto_profil" id="foto_profil_input"
                               class="form-control @error('foto_profil') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp">
                        @error('foto_profil')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format: JPG, JPEG, PNG, WEBP. Ukuran maks: 2MB.</div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end flex-wrap">
                        @if(Auth::user()->foto_profil)
                            <button type="button" class="btn btn-outline-danger rounded-pill px-3"
                                    onclick="confirmHapusFoto()">
                                <i class="fa-solid fa-trash me-1"></i> Hapus Foto
                            </button>
                        @endif
                        <button type="button" class="btn btn-light rounded-pill px-3"
                                data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4"
                                id="btn-simpan-foto" disabled>
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Form Hapus Foto (di luar modal agar tidak nested) -->
<form action="{{ route('profile.foto.delete') }}" method="POST" id="form-hapus-foto" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script>
    // Preview gambar sebelum diupload
    document.getElementById('foto_profil_input').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const btnSimpan = document.getElementById('btn-simpan-foto');

        if (file) {
            // Validasi ukuran di sisi klien
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran foto maksimal adalah 2MB.',
                    confirmButtonColor: '#2c7c8f'
                });
                this.value = '';
                btnSimpan.disabled = true;
                return;
            }

            const reader = new FileReader();
            reader.onload = function (ev) {
                document.getElementById('avatar-preview-container').innerHTML =
                    `<img src="${ev.target.result}" alt="Preview"
                          style="width:100%;height:100%;object-fit:cover;">`;
            };
            reader.readAsDataURL(file);
            btnSimpan.disabled = false;
        } else {
            btnSimpan.disabled = true;
        }
    });

    function confirmHapusFoto() {
        Swal.fire({
            title: 'Hapus Foto Profil?',
            text: 'Foto profil Anda akan dihapus dan kembali ke avatar default.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-foto').submit();
            }
        });
    }

    // Otomatis buka modal jika ada error validasi foto
    @if($errors->has('foto_profil'))
        document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('modalFotoProfil'));
            modal.show();
        });
    @endif
</script>
