<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenyaluranRequest;
use App\Models\MenuMakanan;
use App\Models\Pengajuan;
use App\Models\Penyaluran;
use Illuminate\Http\Request;

class PenyaluranController extends Controller
{
    /**
     * Tampilkan riwayat penyaluran gizi.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $penyaluran = Penyaluran::with(['pengajuan.instansi', 'menu_makanan'])
            ->when($search, function ($query) use ($search) {
                $query->where('kode_penyaluran', 'like', "%{$search}%")
                      ->orWhereHas('pengajuan.instansi', function ($q) use ($search) {
                          $q->where('nama_instansi', 'like', "%{$search}%");
                      })
                      ->orWhereHas('menu_makanan', function ($q) use ($search) {
                          $q->where('nama_menu', 'like', "%{$search}%");
                      });
            })->latest()->paginate(10)->withQueryString();

        return view('admin.penyaluran.index', compact('penyaluran', 'search'));
    }

    /**
     * Form penyaluran baru.
     */
    public function create(Request $request)
    {
        $selectedPengajuanId = $request->input('pengajuan_id');

        // Ambil semua pengajuan yang "Disetujui" dan BELUM memiliki penyaluran
        $pengajuan = Pengajuan::with('instansi')
            ->where('status', 'Disetujui')
            ->whereDoesntHave('penyaluran')
            ->orWhere('id', $selectedPengajuanId)
            ->get();

        $menu = MenuMakanan::all();

        // Generate kode penyaluran otomatis
        $today = date('Ymd');
        $lastDist = Penyaluran::where('kode_penyaluran', 'like', "DIST-{$today}-%")->latest()->first();
        if ($lastDist) {
            $seq = (int) substr($lastDist->kode_penyaluran, -4) + 1;
        } else {
            $seq = 1;
        }
        $kodePenyaluran = 'DIST-' . $today . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);

        return view('admin.penyaluran.create', compact('pengajuan', 'menu', 'kodePenyaluran', 'selectedPengajuanId'));
    }

    /**
     * Simpan penyaluran baru.
     */
    public function store(PenyaluranRequest $request)
    {
        // Generate kode penyaluran di sisi backend untuk keamanan integritas
        $today = date('Ymd');
        $lastDist = Penyaluran::where('kode_penyaluran', 'like', "DIST-{$today}-%")->latest()->first();
        if ($lastDist) {
            $seq = (int) substr($lastDist->kode_penyaluran, -4) + 1;
        } else {
            $seq = 1;
        }
        $kodePenyaluran = 'DIST-' . $today . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);

        $penyaluran = Penyaluran::create(array_merge($request->validated(), [
            'kode_penyaluran' => $kodePenyaluran
        ]));

        return redirect()->route('admin.penyaluran.index')
            ->with('success', "Penyaluran {$kodePenyaluran} berhasil dijadwalkan!");
    }

    /**
     * Detail penyaluran.
     */
    public function show($id)
    {
        $penyaluran = Penyaluran::with(['pengajuan.instansi', 'menu_makanan'])->findOrFail($id);
        return view('admin.penyaluran.show', compact('penyaluran'));
    }

    /**
     * Form edit penyaluran.
     */
    public function edit($id)
    {
        $penyaluran = Penyaluran::findOrFail($id);
        $pengajuan = Pengajuan::with('instansi')->where('id', $penyaluran->pengajuan_id)->get(); // Hanya tampilkan yang bersangkutan
        $menu = MenuMakanan::all();

        return view('admin.penyaluran.edit', compact('penyaluran', 'pengajuan', 'menu'));
    }

    /**
     * Update data penyaluran (misal mengubah status pengiriman).
     */
    public function update(PenyaluranRequest $request, $id)
    {
        $penyaluran = Penyaluran::findOrFail($id);
        $penyaluran->update($request->validated());

        return redirect()->route('admin.penyaluran.index')
            ->with('success', "Penyaluran {$penyaluran->kode_penyaluran} berhasil diperbarui!");
    }

    /**
     * Hapus penyaluran.
     */
    public function destroy($id)
    {
        $penyaluran = Penyaluran::findOrFail($id);
        $kode = $penyaluran->kode_penyaluran;
        $penyaluran->delete();

        return redirect()->route('admin.penyaluran.index')
            ->with('success', "Penyaluran {$kode} berhasil dihapus.");
    }
}
