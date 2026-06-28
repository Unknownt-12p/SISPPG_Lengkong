<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Pengajuan;
use App\Models\Penyaluran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Tampilkan filter dan hasil data Laporan Pengajuan.
     */
    public function pengajuan(Request $request)
    {
        $instansiList = Instansi::all();
        
        // Default date range: awal bulan ini s/d hari ini
        $tglAwal = $request->input('tanggal_awal', date('Y-m-01'));
        $tglAkhir = $request->input('tanggal_akhir', date('Y-m-d'));
        $instansiId = $request->input('instansi_id');
        $status = $request->input('status');

        $data = Pengajuan::with('instansi')
            ->whereBetween('tanggal_pengajuan', [$tglAwal, $tglAkhir])
            ->when($instansiId, function ($query) use ($instansiId) {
                $query->where('instansi_id', $instansiId);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

        return view('admin.laporan.pengajuan', compact('instansiList', 'tglAwal', 'tglAkhir', 'instansiId', 'status', 'data'));
    }

    /**
     * Cetak PDF Laporan Pengajuan.
     */
    public function pengajuanPdf(Request $request)
    {
        $tglAwal = $request->input('tanggal_awal', date('Y-m-01'));
        $tglAkhir = $request->input('tanggal_akhir', date('Y-m-d'));
        $instansiId = $request->input('instansi_id');
        $status = $request->input('status');

        $data = Pengajuan::with('instansi')
            ->whereBetween('tanggal_pengajuan', [$tglAwal, $tglAkhir])
            ->when($instansiId, function ($query) use ($instansiId) {
                $query->where('instansi_id', $instansiId);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

        $selectedInstansi = $instansiId ? Instansi::find($instansiId) : null;

        $pdf = Pdf::loadView('admin.laporan.pengajuan_pdf', compact('data', 'tglAwal', 'tglAkhir', 'selectedInstansi', 'status'));
        
        // Atur ukuran kertas A4, landscape agar kolom muat dengan rapi
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Pengajuan_SPPG_' . date('Ymd_His') . '.pdf');
    }

    /**
     * Tampilkan filter dan hasil data Laporan Penyaluran.
     */
    public function penyaluran(Request $request)
    {
        $instansiList = Instansi::all();

        $tglAwal = $request->input('tanggal_awal', date('Y-m-01'));
        $tglAkhir = $request->input('tanggal_akhir', date('Y-m-d'));
        $instansiId = $request->input('instansi_id');

        $data = Penyaluran::with(['pengajuan.instansi', 'menu_makanan'])
            ->whereBetween('tanggal_penyaluran', [$tglAwal, $tglAkhir])
            ->when($instansiId, function ($query) use ($instansiId) {
                $query->whereHas('pengajuan', function ($q) use ($instansiId) {
                    $q->where('instansi_id', $instansiId);
                });
            })
            ->latest()
            ->get();

        return view('admin.laporan.penyaluran', compact('instansiList', 'tglAwal', 'tglAkhir', 'instansiId', 'data'));
    }

    /**
     * Cetak PDF Laporan Penyaluran.
     */
    public function penyaluranPdf(Request $request)
    {
        $tglAwal = $request->input('tanggal_awal', date('Y-m-01'));
        $tglAkhir = $request->input('tanggal_akhir', date('Y-m-d'));
        $instansiId = $request->input('instansi_id');

        $data = Penyaluran::with(['pengajuan.instansi', 'menu_makanan'])
            ->whereBetween('tanggal_penyaluran', [$tglAwal, $tglAkhir])
            ->when($instansiId, function ($query) use ($instansiId) {
                $query->whereHas('pengajuan', function ($q) use ($instansiId) {
                    $q->where('instansi_id', $instansiId);
                });
            })
            ->latest()
            ->get();

        $selectedInstansi = $instansiId ? Instansi::find($instansiId) : null;

        $pdf = Pdf::loadView('admin.laporan.penyaluran_pdf', compact('data', 'tglAwal', 'tglAkhir', 'selectedInstansi'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Penyaluran_SPPG_' . date('Ymd_His') . '.pdf');
    }
}
