<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\MenuMakanan;
use App\Models\Pengajuan;
use App\Models\Penyaluran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard untuk Admin SPPG.
     */
    public function admin()
    {
        // 1. Statistik Cards
        $totalInstansi = Instansi::count();
        $totalMenu = MenuMakanan::count();
        $totalPengajuan = Pengajuan::count();
        $totalPenyaluran = Penyaluran::count();

        // 2. Data Grafik Bulanan (Tahun Berjalan)
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        $pengajuanPerBulan = array_fill(1, 12, 0);
        $pengajuanData = Pengajuan::selectRaw('MONTH(tanggal_pengajuan) as month, count(*) as total')
            ->whereYear('tanggal_pengajuan', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');
        foreach ($pengajuanData as $month => $total) {
            $pengajuanPerBulan[$month] = $total;
        }

        $penyaluranPerBulan = array_fill(1, 12, 0);
        $penyaluranData = Penyaluran::selectRaw('MONTH(tanggal_penyaluran) as month, count(*) as total')
            ->whereYear('tanggal_penyaluran', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');
        foreach ($penyaluranData as $month => $total) {
            $penyaluranPerBulan[$month] = $total;
        }

        // 3. Data Grafik Jenis Instansi
        $jenisInstansiData = Pengajuan::join('instansi', 'pengajuan.instansi_id', '=', 'instansi.id')
            ->selectRaw('instansi.jenis_instansi, count(*) as total')
            ->groupBy('instansi.jenis_instansi')
            ->pluck('total', 'instansi.jenis_instansi')
            ->toArray();
        
        $jenisCategories = ['TK' => 0, 'SD' => 0, 'Posyandu' => 0, 'Puskesmas' => 0];
        foreach ($jenisInstansiData as $jenis => $total) {
            $jenisCategories[$jenis] = $total;
        }

        // 4. Pengajuan Terbaru (5 Data)
        $pengajuanTerbaru = Pengajuan::with('instansi')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalInstansi',
            'totalMenu',
            'totalPengajuan',
            'totalPenyaluran',
            'months',
            'pengajuanPerBulan',
            'penyaluranPerBulan',
            'jenisCategories',
            'pengajuanTerbaru'
        ));
    }

    /**
     * Dashboard untuk Panel Instansi.
     */
    public function instansi()
    {
        $instansi = Auth::user()->instansi;

        if (!$instansi) {
            $totalPengajuan = 0;
            $menunggu = 0;
            $disetujui = 0;
            $ditolak = 0;
            $riwayatPengajuan = collect();
        } else {
            $totalPengajuan = Pengajuan::where('instansi_id', $instansi->id)->count();
            $menunggu = Pengajuan::where('instansi_id', $instansi->id)->where('status', 'Menunggu')->count();
            $disetujui = Pengajuan::where('instansi_id', $instansi->id)->where('status', 'Disetujui')->count();
            $ditolak = Pengajuan::where('instansi_id', $instansi->id)->where('status', 'Ditolak')->count();
            $riwayatPengajuan = Pengajuan::where('instansi_id', $instansi->id)->latest()->take(5)->get();
        }

        return view('instansi.dashboard', compact(
            'totalPengajuan',
            'menunggu',
            'disetujui',
            'ditolak',
            'riwayatPengajuan'
        ));
    }
}
