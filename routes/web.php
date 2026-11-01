<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\DistributionController;

// Halaman utama
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Semua route berikut membutuhkan autentikasi
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Hak akses Pelapor
    Route::middleware('role:pelapor')->group(function () {

        Route::get('/laporan', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/laporan/create', [ReportController::class, 'create'])
            ->name('reports.create');

        Route::post('/laporan', [ReportController::class, 'store'])
            ->name('reports.store');

        Route::get('/laporan/{id}', [ReportController::class, 'show'])
            ->name('reports.show');

        Route::get('/laporan/{id}/edit', [ReportController::class, 'edit'])
            ->name('reports.edit');

        Route::put('/laporan/{id}', [ReportController::class, 'update'])
            ->name('reports.update');

        Route::get('/sekolah/{school}/distribusi', [ReportController::class, 'getDistributions'])
            ->name('reports.distributions');
    });

    // Hak akses Pemantau
    Route::middleware('role:pemantau')->group(function () {

        Route::get('/review', [ReviewController::class, 'index'])
            ->name('reviews.index');

        Route::post('/review/{id}', [ReviewController::class, 'store'])
            ->name('reviews.store');
    });

    // Hak akses Koordinator
    Route::middleware('role:koordinator')->group(function () {

        // Tindak lanjut
        Route::get('/tindak-lanjut', [FollowUpController::class, 'index'])
            ->name('followups.index');

        Route::post('/tindak-lanjut/{id}', [FollowUpController::class, 'store'])
            ->name('followups.store');

        // Rekap laporan
        Route::get('/rekap-laporan', [FollowUpController::class, 'recap'])
            ->name('followups.recap');

        // Pengelolaan sekolah
        Route::get('/sekolah', [SchoolController::class, 'index'])
            ->name('schools.index');

        Route::get('/sekolah/tambah', [SchoolController::class, 'create'])
            ->name('schools.create');

        Route::post('/sekolah', [SchoolController::class, 'store'])
            ->name('schools.store');

        Route::get('/sekolah/{id}/edit', [SchoolController::class, 'edit'])
            ->name('schools.edit');

        Route::put('/sekolah/{id}', [SchoolController::class, 'update'])
            ->name('schools.update');

        Route::delete('/sekolah/{id}', [SchoolController::class, 'destroy'])
            ->name('schools.destroy');

        // Pengelolaan distribusi
        Route::get('/distribusi', [DistributionController::class, 'index'])
            ->name('distributions.index');

        Route::get('/distribusi/tambah', [DistributionController::class, 'create'])
            ->name('distributions.create');

        Route::post('/distribusi', [DistributionController::class, 'store'])
            ->name('distributions.store');

        Route::get('/distribusi/{id}/edit', [DistributionController::class, 'edit'])
            ->name('distributions.edit');

        Route::put('/distribusi/{id}', [DistributionController::class, 'update'])
            ->name('distributions.update');

        Route::delete('/distribusi/{id}', [DistributionController::class, 'destroy'])
            ->name('distributions.destroy');
    });
});