<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\KontakMasuk;

class ContactController extends Controller
{
    public function kirimEmail(Request $request)
    {
        // 1. Validasi Input Form
        $validatedData = $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'pesan'  => 'required|string',
        ]);

        try {
            // 2. Kirim Email ke Alamat Email Kantor/Tujuan
            Mail::to('admin.perizinan@sijunjung.go.id')->send(new KontakMasuk($validatedData));

            // 3. Kembali dengan status sukses
            return redirect()->to(url()->previous() . '#kontak')->with('success_email', 'Pesan Anda telah berhasil dikirim ke Email Admin Dinas!');
            
        } catch (\Exception $e) {
            return redirect()->to(url()->previous() . '#kontak')
                     ->withInput()
                     ->with('error_email', 'Gagal mengirim email. Silakan periksa konfigurasi mail server Anda atau hubungi kami via WhatsApp.');
        }
    }
}