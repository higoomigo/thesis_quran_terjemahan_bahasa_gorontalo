<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RiwayatValidasiController;
use App\Http\Controllers\Admin\UsulanController;
use App\Http\Controllers\Admin\ValidasiController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\Admin\RiwayatController;\
use App\Http\Controllers\Admin\ValidasiChatController;
use App\Http\Controllers\ProfileController;

// use App\Http\Controllers\Admin\AuthController;


// Group route dengan middleware auth dan prefix admin
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Usulan Management
    Route::prefix('usulan')->name('usulan.')->group(function () {
        Route::get('/', [UsulanController::class, 'index'])->name('index');
        Route::get('/{id}', [UsulanController::class, 'show'])->name('show');
        Route::delete('/{id}', [UsulanController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/status', [UsulanController::class, 'updateStatus'])->name('status');
        Route::patch('/{id}/approve', [UsulanController::class, 'approve'])->name('approve');
        Route::post('/{id}/claim', [UsulanController::class, 'claim'])->name('claim');
        Route::patch('/{id}/reject', [UsulanController::class, 'reject'])->name('reject');
        // Pastikan route ini ditaruh di dalam middleware admin/editor
        Route::patch('/usulan/{id}/arsip', [UsulanController::class, 'arsip'])->name('arsip');
        Route::delete('/usulan/{id}', [UsulanController::class, 'destroy'])->name('destroy');
    });

    Route::get('/profil', [ProfileController::class, 'adminProfile'])->name('profile.show');

    // Validasi (Antrean Otorisasi)
    Route::prefix('validasi')->name('validasi.')->group(function () {
        Route::get('/', [ValidasiController::class, 'index'])->name('index');
        Route::get('/{id}', [ValidasiController::class, 'show'])->name('show');
        Route::get('/chat/{id}', [ValidasiChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{id}/send', [ValidasiChatController::class, 'sendMessage'])->name('chat.send');
        Route::post('/chat/{id}/trigger-voting', [ValidasiChatController::class, 'triggerVoting'])->name('chat.trigger-voting');
        Route::post('/chat/{id}/vote', [ValidasiChatController::class, 'castVote'])->name('chat.vote');
        Route::get('/chat/{id}/messages', [ValidasiChatController::class, 'getNewMessages'])->name('chat.messages');
        Route::put('/chat/{id}/submit-final', [ValidasiChatController::class, 'submitFinal'])->name('chat.submit-final');
    });

    Route::get('/riwayat', [RiwayatValidasiController::class, 'index'])->name('riwayat');
    // Route::middleware(['auth'])->group(function () {
    //     Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
    //     Route::get('/usulan/{id}/chat', function($id) {
    //         return view('usulan.chat', compact('id'));
    //     })->name('usulan.chat');
    // });

    // Chat routes
    // Route::prefix('validasi-chat')->name('validasi.chat.')->group(function () {
    //     Route::get('/{id}', [ValidasiChatController::class, 'show'])->name('show');
    //     Route::post('/{id}/send', [ValidasiChatController::class, 'sendMessage'])->name('send');
    //     Route::post('/{id}/trigger-voting', [ValidasiChatController::class, 'triggerVoting'])->name('trigger-voting');
    //     Route::post('/{id}/vote', [ValidasiChatController::class, 'castVote'])->name('vote');
    //     Route::get('/{id}/messages', [ValidasiChatController::class, 'getNewMessages'])->name('messages');
    //     });
    //     // Validasi Terjemahan
    //     Route::prefix('validasi')->name('validasi.')->group(function () {
    //         Route::get('/', [ValidasiController::class, 'index'])->name('index');
    //         Route::get('/{id}', [ValidasiController::class, 'edit'])->name('edit');
    //         Route::put('/{id}', [ValidasiController::class, 'update'])->name('update');
    //         Route::post('/{id}/approve', [ValidasiController::class, 'approve'])->name('approve');
    //         Route::post('/{id}/reject', [ValidasiController::class, 'reject'])->name('reject');
    //     });

    //     // Riwayat Validasi
    //     Route::prefix('riwayat')->name('riwayat.')->group(function () {
    //         Route::get('/', [RiwayatController::class, 'index'])->name('index');
    //         Route::get('/export', [RiwayatController::class, 'export'])->name('export');
    //         Route::get('/{id}', [RiwayatController::class, 'show'])->name('show');
    //     });

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// // Login route (tanpa middleware auth)
// Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
// Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');