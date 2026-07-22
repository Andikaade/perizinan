<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\DataPerizinanController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\PublicValidasiController;


// Halaman Depan
Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::post('/perizinan/search', [LandingPageController::class, 'search'])->name('perizinan.search');
Route::get('/ajukan-perizinan', [LandingPageController::class, 'create'])->name('perizinan.create');
Route::post('/ajukan-perizinan', [LandingPageController::class, 'store'])->name('perizinan.store');


// Autentikasi Bawaan Laravel (Breeze/Jetstream)
require __DIR__.'/auth.php';

// Route Publik
Route::post('/kontak/kirim', [ContactController::class, 'kirimEmail'])->name('kontak.kirim');

// ----------------------------------------------------
// ROUTE YANG WAJIB LOGIN (AUTH)
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

    Route::post('/pengajuan/store', [DataPerizinanController::class, 'store'])->name('pengajuan.store');

});
// Group rute untuk manajemen verifikasi internal
Route::middleware(['auth'])->prefix('verifikasi')->name('verifikasi.')->group(function () {

    Route::get('/', [VerifikasiController::class, 'index'])->name('index');

    Route::get('/penerbitan', [PublicValidasiController::class, 'index'])->name('penerbitan.index');
    Route::post('/penerbitan/terbitkan/{id}', [PublicValidasiController::class, 'terbitkanSurat'])->name('penerbitan.eksekusi');

    Route::get('/{id}', [VerifikasiController::class, 'show'])->name('show');
    Route::put('/{id}/validasi', [VerifikasiController::class, 'update'])->name('update');


});

Route::get('/validasi-surat/{no_pengajuan}', [PublicValidasiController::class, 'verifikasi'])->name('public.validasi.surat');
Route::get('/validasi-surat/{no_pengajuan}', [PublicValidasiController::class, 'validasiPublic'])->name('public.validasi.surat');
