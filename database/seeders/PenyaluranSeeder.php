<?php

namespace Database\Seeders;

use App\Models\MenuMakanan;
use App\Models\Pengajuan;
use App\Models\Penyaluran;
use Illuminate\Database\Seeder;

class PenyaluranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari pengajuan SD yang statusnya Disetujui
        $pengajuanSD = Pengajuan::where('kode_pengajuan', 'REQ-20260620-0001')->first();
        $menuSD = MenuMakanan::where('kode_menu', 'MENU-SD01')->first();

        if ($pengajuanSD && $menuSD) {
            Penyaluran::create([
                'kode_penyaluran' => 'DIST-20260625-0001',
                'pengajuan_id' => $pengajuanSD->id,
                'menu_id' => $menuSD->id,
                'tanggal_penyaluran' => '2026-06-25',
                'jumlah_disalurkan' => 100,
                'status_pengiriman' => 'Selesai',
                'keterangan' => 'Makanan selesai disalurkan tepat pukul 11:00 WITA. Diserahkan kepada Bapak Budi Santoso.',
            ]);
        }

        // Cari pengajuan Puskesmas yang statusnya Disetujui
        $pengajuanPkm = Pengajuan::where('kode_pengajuan', 'REQ-20260624-0001')->first();
        $menuMil = MenuMakanan::where('kode_menu', 'MENU-MIL01')->first();

        if ($pengajuanPkm && $menuMil) {
            Penyaluran::create([
                'kode_penyaluran' => 'DIST-20260628-0001',
                'pengajuan_id' => $pengajuanPkm->id,
                'menu_id' => $menuMil->id,
                'tanggal_penyaluran' => '2026-06-28',
                'jumlah_disalurkan' => 30,
                'status_pengiriman' => 'Diproses',
                'keterangan' => 'Sedang dalam pengadaan bahan baku segar sup salmon oleh bagian dapur gizi SPPG.',
            ]);
        }
    }
}
