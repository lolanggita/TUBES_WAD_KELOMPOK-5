<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('minAdmin'), // password
            'role' => 'admin',
            'is_verified' => true,
        ]);

        // UKM (Penyelenggara)
        User::factory()->create([
            'name' => 'UKM Musik',
            'username' => 'ukmmusik',
            'email' => 'ukm@example.com',
            'password' => Hash::make('UUKM'),
            'role' => 'ukm',
            'is_verified' => false, // bisa diganti true jika ingin langsung diverifikasi
        ]);

        // 10 Mahasiswa
        User::factory(10)->create([
            'role' => 'mahasiswa',
            'is_verified' => true,
            'password' => Hash::make('MahaSigma'), // <-- tambahkan ini
        ]);
    }
}