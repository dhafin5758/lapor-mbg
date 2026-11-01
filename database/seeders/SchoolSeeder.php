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
         School::updateOrCreate(
            ['npsn' => '20260003'],
            [
                'nama_sekolah' => 'SMA Negeri 12 Bandung',
                'alamat' => 'Jl. gatsu',
                'kabupaten_kota' => 'Kota Bandung',
            ]
        );

        School::updateOrCreate(
            ['npsn' => '20260004'],
            [
                'nama_sekolah' => 'SMP Negeri 67 Bandung',
                'alamat' => 'Jl. dago',
                'kabupaten_kota' => 'Kota Bandung',
            ]
        );
         School::updateOrCreate(
            ['npsn' => '20260005'],
            [
                'nama_sekolah' => 'SMA Negeri 25 Bandung',
                'alamat' => 'Jl. cibaduyut, Bandung',
                'kabupaten_kota' => 'Kota Bandung',
            ]
        );

        School::updateOrCreate(
            ['npsn' => '20260006'],
            [
                'nama_sekolah' => 'SMP Negeri 34 Bandung',
                'alamat' => 'Jl. babakan ciparay, Bandung',
                'kabupaten_kota' => 'Kota Bandung',
            ]
        );
         School::updateOrCreate(
            ['npsn' => '20260007'],
            [
                'nama_sekolah' => 'SMA Negeri 234 Bandung',
                'alamat' => 'Jl. cijagro, Bandung',
                'kabupaten_kota' => 'Kota Bandung',
            ]
        );

        School::updateOrCreate(
            ['npsn' => '20260008'],
            [
                'nama_sekolah' => 'SMP Negeri 1232 Bandung',
                'alamat' => 'Jl. kiara artha, Bandung',
                'kabupaten_kota' => 'Kota Bandung',
            ]
        );
      
    }
}