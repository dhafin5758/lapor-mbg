
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

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
});
});
