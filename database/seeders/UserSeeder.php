<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin SPPG',
            'email' => 'admin@sppg.go.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Instansi TK
        User::create([
            'name' => 'TK Pembina',
            'email' => 'tk@sppg.go.id',
            'password' => Hash::make('password'),
            'role' => 'instansi',
        ]);

        // Instansi SD
        User::create([
            'name' => 'SD Negeri 01',
            'email' => 'sd@sppg.go.id',
            'password' => Hash::make('password'),
            'role' => 'instansi',
        ]);

        // Instansi Posyandu
        User::create([
            'name' => 'Posyandu Cempaka',
            'email' => 'posyandu@sppg.go.id',
            'password' => Hash::make('password'),
            'role' => 'instansi',
        ]);

        // Instansi Puskesmas
        User::create([
            'name' => 'Puskesmas Mawar',
            'email' => 'puskesmas@sppg.go.id',
            'password' => Hash::make('password'),
            'role' => 'instansi',
        ]);
    }
}
