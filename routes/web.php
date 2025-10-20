<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelolaUserController;
use App\Http\Controllers\ProfileController;
use App\Exports\StokMaterialExport;
use Maatwebsite\Excel\Facades\Excel;
use Database\Factories\PengeluaranFactory;

Route::get('/', [AuthController::class, 'index'])->name('login')->middleware('isGuest');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// rute scan cetak
Route::get('/realisasi/scan/{id}', [PengeluaranController::class, 'scanUpdate'])->name('realisasi.scan');



Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data/{year}', [DashboardController::class, 'getChartData']);
    Route::get('/dashboard/export-excel', [DashboardController::class, 'exportExcel'])->name('dashboard.export.excel');

    Route::get('/test-export', function () {
        return Excel::download(new StokMaterialExport(2025, 9), 'stok_material.xlsx');
    });

    Route::post('/realisasi/print-multiple', [PengeluaranController::class, 'printMultiple'])
    ->name('realisasi.printMultiple');
    Route::get('/realisasi-pengeluaran', [PengeluaranController::class, 'indexRealisasi'])->name('realisasiPengeluaran');
    Route::post('/realisasi-pengeluaran/store', [PengeluaranController::class, 'storeRealisasi'])->name('realisasiPengeluaran.store');
    Route::get('/realisasi/print/{id}', [PengeluaranController::class, 'printRealisasi'])->name('realisasi.print');
    Route::put('/realisasi-pengeluaran/{id}', [PengeluaranController::class, 'updateRealisasi'])->name('realisasiPengeluaran.update');
    Route::delete('/realisasiPengeluaran/{id}', [PengeluaranController::class, 'destroyRealisasi'])->name('realisasiPengeluaran.destroy');


    Route::get('/users', [KelolaUserController::class, 'index'])->name('users');
    Route::put('/users/{id}', [KelolaUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [KelolaUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users', [KelolaUserController::class, 'store'])->name('users.store');

    // Tampilkan form profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');

    // Update data profile
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');


    Route::get('pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran');
    Route::post('pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::patch('/pengeluaran/{id}/status', [PengeluaranController::class, 'updateStatus'])->name('pengeluaran.updateStatus');

    Route::get('/penerimaan', [PenerimaanController::class, 'index'])->name('penerimaan');
    Route::post('/penerimaan', [PenerimaanController::class, 'store'])->name('penerimaan.store');
    Route::put('penerimaan/{id}', [PenerimaanController::class, 'update'])->name('penerimaan.update');
    Route::delete('/penerimaan/{id}', [PenerimaanController::class, 'destroy'])->name('penerimaan.destroy');

    Route::get('/materials', [MaterialController::class, 'index'])->name('materials');
    Route::post('/material', [MaterialController::class, 'store'])->name('material.store');
    Route::put('/material/{id}', [MaterialController::class, 'update'])->name('material.update');
    Route::delete('/material/{id}', [MaterialController::class, 'destroy'])->name('material.destroy');

    Route::post('/notifications/mark-as-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

Route::fallback(function () {
    return response()->view('error', [], 404);
});
