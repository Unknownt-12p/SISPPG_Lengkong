<?php

namespace Database\Seeders;

use App\Models\Instansi;
use App\Models\Pengajuan;
use Illuminate\Database\Seeder;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tk = Instansi::where('kode_instansi', 'INST-TK01')->first();
        $sd = Instansi::where('kode_instansi', 'INST-SD01')->first();
        $posyandu = Instansi::where('kode_instansi', 'INST-POS01')->first();
        $puskesmas = Instansi::where('kode_instansi', 'INST-PKM01')->first();

        // 1. Pengajuan Disetujui
        if ($sd) {
            Pengajuan::create([
                'kode_pengajuan' => 'REQ-20260620-0001',
                'instansi_id' => $sd->id,
                'kategori_penerima' => 'Anak SD',
                'jumlah_penerima' => 100,
                'jumlah_porsi' => 100,
                'tanggal_pengajuan' => '2026-06-20',
                'tanggal_distribusi' => '2026-06-25',
                'status' => 'Disetujui',
                'catatan' => 'Mohon dikirim tepat waktu sebelum jam makan siang sekolah (11.30 WITA).',
            ]);
        }

        // 2. Pengajuan Menunggu
        if ($posyandu) {
            Pengajuan::create([
                'kode_pengajuan' => 'REQ-20260622-0001',
                'instansi_id' => $posyandu->id,
                'kategori_penerima' => 'Balita',
                'jumlah_penerima' => 50,
                'jumlah_porsi' => 50,
                'tanggal_pengajuan' => '2026-06-22',
                'tanggal_distribusi' => '2026-06-26',
                'status' => 'Menunggu',
                'catatan' => 'Penyaluran gizi rutin saat agenda Posyandu bulanan desa.',
            ]);
        }

        // 3. Pengajuan Ditolak
        if ($tk) {
            Pengajuan::create([
                'kode_pengajuan' => 'REQ-20260623-0001',
                'instansi_id' => $tk->id,
                'kategori_penerima' => 'Anak TK',
                'jumlah_penerima' => 60,
                'jumlah_porsi' => 60,
                'tanggal_pengajuan' => '2026-06-23',
                'tanggal_distribusi' => '2026-06-27',
                'status' => 'Ditolak',
                'catatan' => 'Permintaan hari libur akhir pekan dibatalkan oleh pihak komite sekolah.',
            ]);
        }

        // 4. Pengajuan Disetujui (untuk disalurkan)
        if ($puskesmas) {
            Pengajuan::create([
                'kode_pengajuan' => 'REQ-20260624-0001',
                'instansi_id' => $puskesmas->id,
                'kategori_penerima' => 'Ibu Hamil',
                'jumlah_penerima' => 30,
                'jumlah_porsi' => 30,
                'tanggal_pengajuan' => '2026-06-24',
                'tanggal_distribusi' => '2026-06-28',
                'status' => 'Disetujui',
                'catatan' => 'Intervensi nutrisi khusus bagi Ibu Hamil dengan indikasi KEK.',
            ]);
        }
    }
}
