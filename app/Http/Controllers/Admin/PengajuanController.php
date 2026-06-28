<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    /**
     * Tampilkan semua daftar pengajuan (untuk Admin).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $pengajuan = Pengajuan::with('instansi')
            ->when($search, function ($query) use ($search) {
                $query->where('kode_pengajuan', 'like', "%{$search}%")
                      ->orWhereHas('instansi', function ($q) use ($search) {
                          $q->where('nama_instansi', 'like', "%{$search}%");
                      });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengajuan.index', compact('pengajuan', 'search', 'status'));
    }

    /**
     * Detail pengajuan dan form verifikasi persetujuan.
     */
    public function show($id)
    {
        $pengajuan = Pengajuan::with('instansi')->findOrFail($id);
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Verifikasi status pengajuan (Setuju / Tolak).
     */
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan' => 'nullable|string|max:500',
        ], [
            'status.required' => 'Keputusan status persetujuan wajib ditentukan.',
            'status.in' => 'Status tidak valid.',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);

        // Jika sudah diproses penyaluran, tidak boleh ditolak kembali
        if ($pengajuan->penyaluran && $request->status === 'Ditolak') {
            return back()->with('error', 'Gagal menolak. Pengajuan sudah masuk dalam proses penyaluran makanan.');
        }

        $pengajuan->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        $statusText = $request->status === 'Disetujui' ? 'disetujui' : 'ditolak';

        return redirect()->route('admin.pengajuan.show', $pengajuan->id)
            ->with('success', "Pengajuan {$pengajuan->kode_pengajuan} berhasil {$statusText}!");
    }

    /**
     * Hapus data pengajuan (Admin).
     */
    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        // Cegah penghapusan jika sudah ada penyaluran terkait
        if ($pengajuan->penyaluran) {
            return back()->with('error', 'Pengajuan tidak dapat dihapus karena sudah terhubung dengan data penyaluran.');
        }

        $kode = $pengajuan->kode_pengajuan;
        $pengajuan->delete();

        return redirect()->route('admin.pengajuan.index')
            ->with('success', "Pengajuan {$kode} berhasil dihapus.");
    }
}
