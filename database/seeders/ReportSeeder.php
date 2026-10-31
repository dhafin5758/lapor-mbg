<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use App\Models\Distribution;
use App\Models\Report;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'pelapor@mbg.test')->firstOrFail();

        $school = School::where('npsn', '20260001')->firstOrFail();

        $distribution = Distribution::where(
            'school_id',
            $school->id
        )->firstOrFail();

        Report::updateOrCreate(
            [
                'user_id' => $user->id,
                'judul' => 'Kondisi makanan kurang layak',
            ],
            [
                'school_id' => $school->id,
                'distribution_id' => $distribution->id,
                'deskripsi' => 'Makanan yang diterima memiliki kondisi dan aroma yang kurang baik.',
                'kategori' => 'Kualitas makanan',
                'status' => 'diajukan',
                'evidence_path' => null,
            ]
        );
    }
}