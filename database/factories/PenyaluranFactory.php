<?php

namespace Database\Factories;

use App\Models\MenuMakanan;
use App\Models\Pengajuan;
use App\Models\Penyaluran;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenyaluranFactory extends Factory
{
    protected $model = Penyaluran::class;

    public function definition(): array
    {
        return [
            'kode_penyaluran' => 'DIST-' . $this->faker->unique()->date('Ymd') . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'pengajuan_id' => Pengajuan::factory(),
            'menu_id' => MenuMakanan::factory(),
            'tanggal_penyaluran' => $this->faker->date(),
            'jumlah_disalurkan' => $this->faker->numberBetween(20, 200),
            'status_pengiriman' => $this->faker->randomElement(['Diproses', 'Dikirim', 'Selesai']),
            'keterangan' => $this->faker->sentence(),
        ];
    }
}
