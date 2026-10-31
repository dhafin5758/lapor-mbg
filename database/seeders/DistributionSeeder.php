<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Distribution;
use Illuminate\Database\Seeder;

class DistributionSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::where('npsn', '20260001')->firstOrFail();

        Distribution::updateOrCreate(
            [
                'school_id' => $school->id,
                'tanggal_penyaluran' => now()->toDateString(),
            ],
            [
                'menu' => 'Nasi, ayam, sayur, dan buah',
                'status_penyaluran' => 'terlaksana',
            ]
        );
    }
}