<?php

use Illuminate\Support\Facades\Route;

// Nanti kalau controllernya udah lu bikin, tinggal di-uncomment
use App\Http\Controllers\Editor\DashboardController;
use App\Http\Controllers\Editor\AntreanController;
use App\Http\Controllers\Editor\DataTranslasi;
use App\Http\Controllers\Editor\RiwayatController;

// use App\Http\Controllers\Editor\RiwayatController;

// Group route dengan middleware auth dan prefix editor
Route::prefix('editor')->name('editor.')->middleware(['auth'])->group(function () {
    
    // 1. Dashboard Editor
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Meja Redaksi (Antrean Publikasi)
    Route::prefix('antrean')->name('antrean.')->group(function () {
        Route::get('/', [AntreanController::class, 'index'])->name('index');

        Route::get('/{id}', [AntreanController::class, 'show'])->name('show');
            

        // Route untuk tombol ketuk palu (Publikasi)
        Route::post('/{id}/publikasi', [AntreanController::class, 'publikasi'])->name('publikasi');
    });

    // 3. Riwayat Tayang (Arsip)
    Route::prefix('/riwayat')->name('riwayat.')->group(function () {
        Route::get('/', [RiwayatController::class, 'index'])->name('index');
    });
    
    // Route::get('/data-terjemahan', [DataTranslasi::class, 'index'])->name('data-terjemahan.index');
    Route::prefix('/data-terjemahan')->name('data-terjemahan.')->group(function () {
        Route::get('/', [DataTranslasi::class, 'index'])->name('index');
        Route::get('/{id}', [DataTranslasi::class, 'show'])->name('show');
        Route::put('/{id}/update', [DataTranslasi::class, 'updateAyat'])->name('update');
        Route::post('/{no_surah}/import', [DataTranslasi::class, 'importExcel'])->name('import');
    });

});