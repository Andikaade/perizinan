<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DataPerizinanController;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk pengiriman email kontak
Route::post('/kirim-kontak', [ContactController::class, 'kirimEmail'])->name('kontak.kirim');
