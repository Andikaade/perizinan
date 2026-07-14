<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\PermohonanDokumen;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    /**
     * Menampilkan halaman depan utama (Landing Page)
     */
    public function index()
    {
        // Berdasarkan struktur folder Anda, file view depannya adalah welcome.blade.php
        return view('welcome');
    }

    /**
     * Menampilkan form pengajuan online di halaman depan
     */
    public function create()
    {
        return view('welcome.ajukan');
    }

    /**
     * Memproses data permohonan dan upload berkas dokumen
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'jenis_surat' => 'required|string',
            'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $noPengajuan = 'PRZ-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $permohonan = Permohonan::create([
            'no_pengajuan' => $noPengajuan,
            'nama_pemohon' => $request->nama_pemohon,
            'jenis_surat' => $request->jenis_surat,
            'status' => 'Menunggu',
        ]);

        if ($request->hasFile('file_ktp')) {
            $pathKtp = $request->file('file_ktp')->store('dokumen_perizinan', 'public');
            PermohonanDokumen::create([
                'permohonan_id' => $permohonan->id,
                'nama_dokumen' => 'KTP Pemohon',
                'file_path' => $pathKtp,
                'status_validasi' => 'Menunggu',
            ]);
        }

        if ($request->hasFile('file_sertifikat')) {
            $pathSertifikat = $request->file('file_sertifikat')->store('dokumen_perizinan', 'public');
            PermohonanDokumen::create([
                'permohonan_id' => $permohonan->id,
                'nama_dokumen' => 'Sertifikat Tanah',
                'file_path' => $pathSertifikat,
                'status_validasi' => 'Menunggu',
            ]);
        }

        return redirect()->route('perizinan.create')->with('sukses_pengajuan', $noPengajuan);
    }

    /**
     * Memproses pencarian status permohonan berdasarkan No Pengajuan
     */
    public function search(Request $request)
    {
        $keyword = $request->input('no_pengajuan');

        if (empty($keyword)) {
            return redirect()->route('landing')->with('error_cari', 'Silakan masukkan nomor pengajuan Anda terlebih dahulu.');
        }

        $permohonan = Permohonan::where('no_pengajuan', $keyword)->first();

        if (!$permohonan) {
            return redirect()->route('landing')->with('error_cari', 'Nomor pengajuan tidak ditemukan. Periksa kembali kode Anda.');
        }

        // Diarahkan kembali ke view 'welcome' sambil membawa data hasil pencarian
        return view('welcome', compact('permohonan'));
    }
}
