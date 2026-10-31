<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        School::updateOrCreate(
            ['npsn' => '20260001'],
            [
                'nama_sekolah' => 'SMA Negeri 1 Bandung',
                'alamat' => 'Jl. Ir. H. Juanda, Bandung',
                'kabupaten_kota' => 'Kota Bandung',
            ]
        );

        School::updateOrCreate(
            ['npsn' => '20260002'],
            [
                'nama_sekolah' => 'SMP Negeri 2 Bandung',
                'alamat' => 'Jl. Sumatera, Bandung',
                'kabupaten_kota' => 'Kota Bandung',
            ]
        );
    }
}