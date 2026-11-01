<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Report;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PelaporBSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Pelapor B
        $pelaporB = User::firstOrCreate(
            ['email' => 'pelaporb@mbg.test'],
            [
                'name' => 'Pelapor B',
                'password' => Hash::make('password123'),
                'role' => 'pelapor',
            ]
        );

        // Mengambil sekolah yang sudah tersedia
        $school = School::firstOrFail();

        // Membuat laporan milik Pelapor B
        Report::firstOrCreate(
            [
                'user_id' => $pelaporB->id,
                'judul' => 'Laporan Uji AC-05 Pelapor B',
            ],
            [
                'school_id' => $school->id,
                'distribution_id' => null,
                'kategori' => 'Keamanan Makanan',
                'deskripsi' => 'Laporan untuk pengujian ownership dan privacy AC-05.',
                'status' => 'diajukan',
                'evidence_path' => null,
            ]
        );
    }
}
