<?php

namespace Database\Factories;

use App\Models\MenuMakanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuMakananFactory extends Factory
{
    protected $model = MenuMakanan::class;

    public function definition(): array
    {
        return [
            'kode_menu' => 'MENU-' . $this->faker->unique()->bothify('??##'),
            'nama_menu' => $this->faker->words(3, true),
            'kategori_menu' => $this->faker->randomElement(['Anak TK', 'Anak SD', 'Balita', 'Ibu Hamil', 'Ibu Menyusui']),
            'kalori' => $this->faker->numberBetween(200, 800),
            'protein' => $this->faker->numberBetween(5, 40),
            'karbohidrat' => $this->faker->numberBetween(30, 100),
            'lemak' => $this->faker->numberBetween(5, 30),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
