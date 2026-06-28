<?php

namespace Database\Seeders;

use App\Models\MenuMakanan;
use Illuminate\Database\Seeder;

class MenuMakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuMakanan::create([
            'kode_menu' => 'MENU-TK01',
            'nama_menu' => 'Bubur Ayam Wortel + Susu',
            'kategori_menu' => 'Anak TK',
            'kalori' => 350,
            'protein' => 12,
            'karbohidrat' => 50,
            'lemak' => 10,
            'deskripsi' => 'Bubur lembut dengan suwiran daging ayam kampung asli, wortel parut halus, disajikan bersama susu pasteurisasi rasa vanilla.',
        ]);

        MenuMakanan::create([
            'kode_menu' => 'MENU-SD01',
            'nama_menu' => 'Nasi Kuning Ayam Bakar + Telur Rebus',
            'kategori_menu' => 'Anak SD',
            'kalori' => 550,
            'protein' => 25,
            'karbohidrat' => 75,
            'lemak' => 15,
            'deskripsi' => 'Nasi kuning wangi rempah, ayam panggang kecap manis, setengah butir telur rebus, dan sayuran buncis serta wortel rebus.',
        ]);

        MenuMakanan::create([
            'kode_menu' => 'MENU-BAL01',
            'nama_menu' => 'Puree Pisang Alpukat + Bubur Susu',
            'kategori_menu' => 'Balita',
            'kalori' => 250,
            'protein' => 8,
            'karbohidrat' => 40,
            'lemak' => 8,
            'deskripsi' => 'Bubur halus berbahan oat gandum, buah pisang lumat, dan alpukat mentega mentega segar, sangat ramah pencernaan balita.',
        ]);

        MenuMakanan::create([
            'kode_menu' => 'MENU-MIL01',
            'nama_menu' => 'Nasi Merah Sup Ikan Salmon + Buah Jeruk',
            'kategori_menu' => 'Ibu Hamil',
            'kalori' => 650,
            'protein' => 35,
            'karbohidrat' => 85,
            'lemak' => 20,
            'deskripsi' => 'Nasi merah pulen, sup bening ikan salmon kaya omega-3 dan asam folat, brokoli rebus, dan buah jeruk segar pencuci mulut.',
        ]);

        MenuMakanan::create([
            'kode_menu' => 'MENU-BUS01',
            'nama_menu' => 'Nasi Putih Tumis Daun Katuk + Daging Lada Hitam',
            'kategori_menu' => 'Ibu Menyusui',
            'kalori' => 700,
            'protein' => 32,
            'karbohidrat' => 90,
            'lemak' => 22,
            'deskripsi' => 'Nasi putih hangat, tumis daun katuk (booster ASI alami) wortel, empal daging sapi bumbu lada hitam gurih, dan potongan semangka.',
        ]);
    }
}
