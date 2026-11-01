
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FollowUpController;

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::middleware('auth')->group(function () {

    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Testing role
    Route::get('/pelapor', function () {
        return 'Halaman khusus Pelapor';
    })->middleware('role:pelapor');

    Route::get('/pemantau', function () {
        return 'Halaman khusus Pemantau';
    })->middleware('role:pemantau');

    Route::get('/koordinator', function () {
        return 'Halaman khusus Koordinator';
    })->middleware('role:koordinator');


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


    Route::middleware('role:pemantau')->group(function () {

        Route::get('/review', [ReviewController::class, 'index'])
            ->name('reviews.index');

        Route::post('/review/{id}', [ReviewController::class, 'store'])
            ->name('reviews.store');
    });


    Route::middleware('role:koordinator')->group(function () {

        Route::get('/tindak-lanjut', [FollowUpController::class, 'index'])
            ->name('followups.index');

        Route::post('/tindak-lanjut/{id}', [FollowUpController::class, 'store'])
            ->name('followups.store');
    });

});
