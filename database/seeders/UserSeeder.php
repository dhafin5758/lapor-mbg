<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'pelapor@mbg.test'],
            [
                'name' => 'Budi Pelapor',
                'password' => Hash::make('password123'),
                'role' => 'pelapor',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pemantau@mbg.test'],
            [
                'name' => 'Siti Pemantau',
                'password' => Hash::make('password123'),
                'role' => 'pemantau',
            ]
        );

        User::updateOrCreate(
            ['email' => 'koordinator@mbg.test'],
            [
                'name' => 'Andi Koordinator',
                'password' => Hash::make('password123'),
                'role' => 'koordinator',
            ]
        );
    }
}