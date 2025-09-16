<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\AuthController;


Route::get('/', [AuthController::class, 'index'])->name('login')->middleware('isGuest');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');


Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/realisasi-pengeluaran', [PengeluaranController::class, 'indexRealisasi'])->name('realisasiPengeluaran');
    Route::post('/realisasi-pengeluaran/store', [PengeluaranController::class, 'storeRealisasi'])->name('realisasiPengeluaran.store');
    Route::get('/realisasi/print/{id}', [PengeluaranController::class, 'printRealisasi'])->name('realisasi.print');


    Route::get('pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran');
    Route::post('pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::patch('/pengeluaran/{id}/status', [PengeluaranController::class, 'updateStatus'])->name('pengeluaran.updateStatus');

    Route::get('penerimaan', [PenerimaanController::class, 'index'])->name('penerimaan');
    Route::post('/penerimaan', [PenerimaanController::class, 'store'])->name('penerimaan.store');

    Route::get('/materials', [MaterialController::class, 'index'])->name('materials');
    Route::post('/material', [MaterialController::class, 'store'])->name('material.store');
    Route::put('/material/{id}', [MaterialController::class, 'update'])->name('material.update');
    Route::delete('/material/{id}', [MaterialController::class, 'destroy'])->name('material.destroy');

    Route::post('/notifications/mark-as-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

Route::fallback(function () {
    return response()->view('error', [], 404);
});
