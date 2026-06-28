<?php

namespace App\Http\Controllers\Instansi;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanRequest;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    /**
     * Pastikan user instansi memiliki profil terkait.
     */
    private function getInstansi()
    {
        $instansi = Auth::user()->instansi;
        if (!$instansi) {
            abort(403, 'Profil instansi Anda belum terdaftar di sistem. Silakan hubungi Administrator.');
        }
        return $instansi;
    }

    /**
     * Tampilkan riwayat pengajuan instansi saat ini.
     */
    public function index(Request $request)
    {
        $instansi = $this->getInstansi();
        $search = $request->input('search');

        $pengajuan = Pengajuan::where('instansi_id', $instansi->id)
            ->when($search, function ($query) use ($search) {
                $query->where('kode_pengajuan', 'like', "%{$search}%")
                      ->orWhere('kategori_penerima', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
            })->latest()->paginate(10)->withQueryString();

        return view('instansi.pengajuan.index', compact('pengajuan', 'search'));
    }

    /**
     * Form pengajuan baru.
     */
    public function create()
    {
        $this->getInstansi();
        
        // Generate kode pengajuan otomatis
        $today = date('Ymd');
        $lastRequest = Pengajuan::where('kode_pengajuan', 'like', "REQ-{$today}-%")->latest()->first();
        if ($lastRequest) {
            $seq = (int) substr($lastRequest->kode_pengajuan, -4) + 1;
        } else {
            $seq = 1;
        }
        $kodePengajuan = 'REQ-' . $today . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);

        return view('instansi.pengajuan.create', compact('kodePengajuan'));
    }

    /**
     * Simpan pengajuan baru.
     */
    public function store(PengajuanRequest $request)
    {
        $instansi = $this->getInstansi();

        Pengajuan::create([
            'kode_pengajuan' => $request->kode_pengajuan,
            'instansi_id' => $instansi->id,
            'kategori_penerima' => $request->kategori_penerima,
            'jumlah_penerima' => $request->jumlah_penerima,
            'jumlah_porsi' => $request->jumlah_porsi,
            'tanggal_pengajuan' => date('Y-m-d'),
            'tanggal_distribusi' => $request->tanggal_distribusi,
            'status' => 'Menunggu',
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('instansi.pengajuan.index')
            ->with('success', 'Pengajuan makanan gizi berhasil dikirim! Silakan pantau perkembangannya.');
    }

    /**
     * Detail pengajuan instansi.
     */
    public function show($id)
    {
        $instansi = $this->getInstansi();
        $pengajuan = Pengajuan::where('instansi_id', $instansi->id)->findOrFail($id);

        return view('instansi.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Form edit pengajuan (hanya jika status = 'Menunggu').
     */
    public function edit($id)
    {
        $instansi = $this->getInstansi();
        $pengajuan = Pengajuan::where('instansi_id', $instansi->id)->findOrFail($id);

        if ($pengajuan->status !== 'Menunggu') {
            return redirect()->route('instansi.pengajuan.index')
                ->with('error', 'Mohon maaf, pengajuan yang sudah disetujui atau ditolak tidak dapat diubah.');
        }

        return view('instansi.pengajuan.edit', compact('pengajuan'));
    }

    /**
     * Update data pengajuan.
     */
    public function update(PengajuanRequest $request, $id)
    {
        $instansi = $this->getInstansi();
        $pengajuan = Pengajuan::where('instansi_id', $instansi->id)->findOrFail($id);

        if ($pengajuan->status !== 'Menunggu') {
            return redirect()->route('instansi.pengajuan.index')
                ->with('error', 'Gagal memperbarui. Pengajuan sudah dalam tahap pemrosesan.');
        }

        $pengajuan->update($request->validated());

        return redirect()->route('instansi.pengajuan.index')
            ->with('success', 'Pengajuan makanan gizi berhasil diperbarui!');
    }

    /**
     * Batalkan/Hapus pengajuan (hanya jika status = 'Menunggu').
     */
    public function destroy($id)
    {
        $instansi = $this->getInstansi();
        $pengajuan = Pengajuan::where('instansi_id', $instansi->id)->findOrFail($id);

        if ($pengajuan->status !== 'Menunggu') {
            return redirect()->route('instansi.pengajuan.index')
                ->with('error', 'Gagal membatalkan. Pengajuan sudah dalam tahap pemrosesan.');
        }

        $pengajuan->delete();

        return redirect()->route('instansi.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dibatalkan dan dihapus dari sistem.');
    }
}
