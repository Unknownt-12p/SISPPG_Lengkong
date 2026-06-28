<?php

namespace Database\Factories;

use App\Models\Instansi;
use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengajuanFactory extends Factory
{
    protected $model = Pengajuan::class;

    public function definition(): array
    {
        $jumlah = $this->faker->numberBetween(20, 200);
        return [
            'kode_pengajuan' => 'REQ-' . $this->faker->unique()->date('Ymd') . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'instansi_id' => Instansi::factory(),
            'kategori_penerima' => $this->faker->randomElement(['Anak TK', 'Anak SD', 'Balita', 'Ibu Hamil', 'Ibu Menyusui']),
            'jumlah_penerima' => $jumlah,
            'jumlah_porsi' => $jumlah,
            'tanggal_pengajuan' => $this->faker->date(),
            'tanggal_distribusi' => $this->faker->dateTimeBetween('+1 days', '+7 days')->format('Y-m-d'),
            'status' => 'Menunggu',
            'catatan' => $this->faker->text(100),
        ];
    }
}
