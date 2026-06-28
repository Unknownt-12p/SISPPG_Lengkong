<?php

namespace Database\Factories;

use App\Models\Instansi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstansiFactory extends Factory
{
    protected $model = Instansi::class;

    public function definition(): array
    {
        return [
            'kode_instansi' => 'INST-' . $this->faker->unique()->bothify('??##'),
            'nama_instansi' => $this->faker->company(),
            'jenis_instansi' => $this->faker->randomElement(['TK', 'SD', 'Posyandu', 'Puskesmas']),
            'alamat' => $this->faker->address(),
            'penanggung_jawab' => $this->faker->name(),
            'telepon' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'user_id' => User::factory(),
        ];
    }
}
