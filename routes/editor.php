<?php

use App\Http\Controllers\Admin\UsulanController;
use Illuminate\Support\Facades\Route;

// Nanti kalau controllernya udah lu bikin, tinggal di-uncomment
use App\Http\Controllers\Editor\AudioController;
use App\Http\Controllers\Editor\DashboardController;
use App\Http\Controllers\Editor\AntreanController;
use App\Http\Controllers\Editor\AudioAyatController;
use App\Http\Controllers\Editor\AudioSurahController;
use App\Http\Controllers\Editor\DataTranslasi;
use App\Http\Controllers\Editor\EditorUsulanController;
use App\Http\Controllers\Editor\LanggamController;
use App\Http\Controllers\Editor\PelantunController;
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

    Route::prefix('usulan')->name('usulan.')->group(function () {
        Route::get('/', [EditorUsulanController::class, 'index'])->name('index');
        Route::get('/{id}', [EditorUsulanController::class, 'show'])->name('show');
            
        Route::patch('/{id}/accept', [EditorUsulanController::class, 'accept'])->name('accept');
        // Route::post('/{id}/claim', [EditorUsulanController::class, 'claim'])->name('claim');
        Route::patch('/{id}/reject', [EditorUsulanController::class, 'reject'])->name('reject');

        Route::patch('/usulan/{id}/arsip', [EditorUsulanController::class, 'arsip'])->name('arsip');
        Route::delete('/usulan/{id}', [EditorUsulanController::class, 'destroy'])->name('destroy');
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

    // Route Manajemen Audio
    Route::prefix('audio')->name('audio.')->group(function () {
        // 1. Audio Per Ayat (Menampilkan List Surah -> Detail Ayat -> Upload ZIP/MP3)
        Route::get('/ayat', [AudioAyatController::class, 'index'])->name('ayat.index');
        Route::get('/ayat/{surah_id}', [AudioAyatController::class, 'show'])->name('ayat.show');
        Route::post('/ayat/{surah_id}/upload-zip', [AudioAyatController::class, 'storeZip'])->name('ayat.storeZip');
        Route::post('/ayat/{surah_id}/upload-single', [AudioAyatController::class, 'storeSingle'])->name('ayat.storeSingle');

        // 2. Audio Full Surah (Untuk Lokal Murottal)
        Route::get('/surah', [AudioSurahController::class, 'index'])->name('surah.index');
        Route::post('/surah', [AudioSurahController::class, 'store'])->name('surah.store');

        // 3. Master Pelantun (CRUD Qari & Pembaca Terjemahan)
        // Route::get('/pelantun', [PelantunController::class, 'index'])->name('pelantun.index');
        // Master Pelantun
        Route::get('/pelantun', [PelantunController::class, 'index'])->name('pelantun.index');
        Route::get('/pelantun/create', [PelantunController::class, 'create'])->name('pelantun.create');
        Route::post('/pelantun', [PelantunController::class, 'store'])->name('pelantun.store');
        Route::get('/pelantun/{id}/edit', [PelantunController::class, 'edit'])->name('pelantun.edit');
        Route::put('/pelantun/{id}', [PelantunController::class, 'update'])->name('pelantun.update');
        Route::delete('/pelantun/{id}', [PelantunController::class, 'destroy'])->name('pelantun.destroy');
        
        Route::get('/langgam', [LanggamController::class, 'index'])->name('langgam.index');
        Route::get('/langgam/create', [LanggamController::class, 'create'])->name('langgam.create');
        Route::post('/langgam', [LanggamController::class, 'store'])->name('langgam.store');
        Route::get('/langgam/{id}/edit', [LanggamController::class, 'edit'])->name('langgam.edit');
        Route::put('/langgam/{id}', [LanggamController::class, 'update'])->name('langgam.update');
        Route::delete('/langgam/{id}', [LanggamController::class, 'destroy'])->name('langgam.destroy');

        // 4. Master Langgam (CRUD Jenis Irama)
        Route::get('/langgam', [LanggamController::class, 'index'])->name('langgam.index');
    });
});
    