<?php

namespace Database\Seeders;

use App\Models\Instansi;
use App\Models\User;
use Illuminate\Database\Seeder;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tkUser = User::where('email', 'tk@sppg.go.id')->first();
        $sdUser = User::where('email', 'sd@sppg.go.id')->first();
        $posyanduUser = User::where('email', 'posyandu@sppg.go.id')->first();
        $puskesmasUser = User::where('email', 'puskesmas@sppg.go.id')->first();

        Instansi::create([
            'kode_instansi' => 'INST-TK01',
            'nama_instansi' => 'TK Pembina',
            'jenis_instansi' => 'TK',
            'alamat' => 'Jl. Pendidikan No. 5, Kota Gizi',
            'penanggung_jawab' => 'Ibu Asri Handayani',
            'telepon' => '081234567890',
            'email' => 'tk@sppg.go.id',
            'user_id' => $tkUser ? $tkUser->id : null,
        ]);

        Instansi::create([
            'kode_instansi' => 'INST-SD01',
            'nama_instansi' => 'SD Negeri 01',
            'jenis_instansi' => 'SD',
            'alamat' => 'Jl. Merdeka No. 12, Kota Gizi',
            'penanggung_jawab' => 'Bpk. Budi Santoso',
            'telepon' => '081234567891',
            'email' => 'sd@sppg.go.id',
            'user_id' => $sdUser ? $sdUser->id : null,
        ]);

        Instansi::create([
            'kode_instansi' => 'INST-POS01',
            'nama_instansi' => 'Posyandu Cempaka',
            'jenis_instansi' => 'Posyandu',
            'alamat' => 'RT 02 RW 04, Dusun Harapan, Kota Gizi',
            'penanggung_jawab' => 'Ibu Citra Lestari',
            'telepon' => '081234567892',
            'email' => 'posyandu@sppg.go.id',
            'user_id' => $posyanduUser ? $posyanduUser->id : null,
        ]);

        Instansi::create([
            'kode_instansi' => 'INST-PKM01',
            'nama_instansi' => 'Puskesmas Mawar',
            'jenis_instansi' => 'Puskesmas',
            'alamat' => 'Jl. Kesehatan No. 8, Kota Gizi',
            'penanggung_jawab' => 'dr. Mawar Sari',
            'telepon' => '081234567893',
            'email' => 'puskesmas@sppg.go.id',
            'user_id' => $puskesmasUser ? $puskesmasUser->id : null,
        ]);
    }
}
