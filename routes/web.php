<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PermohonanController;


// Halaman Depan
Route::get('/', function () {
    return view('welcome');
});

// Autentikasi Bawaan Laravel (Breeze/Jetstream)
require __DIR__.'/auth.php';

// Route Publik
Route::post('/kontak/kirim', [ContactController::class, 'kirimEmail'])->name('kontak.kirim');

// ----------------------------------------------------
// SEMUA ROUTE YANG WAJIB LOGIN (AUTH)
// ----------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Dashboard Utama=
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. Manajemen Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/permohonan/export', [PermohonanController::class, 'exportExcel'])->name('permohonan.export');

    // 3. Manajemen Permohonan Berkas
    Route::get('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::get('/permohonan/create', [PermohonanController::class, 'create'])->name('permohonan.create');
    Route::post('/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');

    // DETAIL & UPDATE STATUS (Parameter disamakan menggunakan {id})
    Route::get('/permohonan/{id}', [PermohonanController::class, 'show'])->name('permohonan.show');
    Route::patch('/permohonan/{id}/update', [PermohonanController::class, 'update'])->name('permohonan.update');
    Route::delete('/permohonan/{id}', [PermohonanController::class, 'destroy'])->name('permohonan.destroy');
    Route::get('/permohonan/{id}/edit', [PermohonanController::class, 'edit'])->name('permohonan.edit');
    Route::put('/permohonan/{id}', [PermohonanController::class, 'updateData'])->name('permohonan.updateData');

});
