<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\UsulanController;
use App\Http\Controllers\ProfileController;

// Import Controller Forum yang bakal kita bikin nanti
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ReplyController;

// ==========================================
// GUEST ROUTES (Bisa diakses siapa saja)
// ==========================================

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Taro di luar middleware admin ya, biar semua orang bisa lihat
Route::get('/profil/{id}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');

Route::get('mushaf', [SurahController::class, 'index'])->name('mushaf');
Route::get('surah/{id}', [SurahController::class, 'show'])->name('surah.show');

// Usulan Terjemahan
Route::prefix('usulan')->name('usulan.')->group(function () {
    Route::get('/{surah_id}/{ayat_id}', [UsulanController::class, 'index'])->name('index');
    Route::post('/store', [UsulanController::class, 'store'])->name('store');
});

// Forum Diskusi (Publik)
Route::prefix('forum')->name('forum.')->group(function () {
    Route::get('/', [ThreadController::class, 'index'])->name('index'); // Daftar semua thread
    Route::get('/kategori/{slug}', [ThreadController::class, 'category'])->name('category'); // Filter by kategori
    Route::get('/thread/{slug}', [ThreadController::class, 'show'])->name('thread.show'); // Baca isi thread & balasan
});

// ==========================================
// AUTH ROUTES (Wajib Login)
// ==========================================

Route::middleware('auth')->group(function () {
    // Manajemen Profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Forum Diskusi (Interaksi yang butuh user_id)
    Route::prefix('forum')->name('forum.')->group(function () {
        Route::get('/thread/buat/baru', [ThreadController::class, 'create'])->name('thread.create'); // Tampilan form bikin thread
        Route::post('/thread/store', [ThreadController::class, 'store'])->name('thread.store'); // Proses simpan thread
        Route::delete('/thread/{id}', [ThreadController::class, 'destroy'])->name('thread.destroy'); // Hapus thread
        Route::post('/thread/{thread_id}/reply', [ReplyController::class, 'store'])->name('reply.store'); // Proses kirim balasan
        Route::delete('/reply/{id}', [ReplyController::class, 'destroy'])->name('reply.destroy'); // Hapus balasan
    });
});

// ==========================================
// SEPARATED REQUIRE ROUTES
// ==========================================
require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
require __DIR__.'/editor.php';