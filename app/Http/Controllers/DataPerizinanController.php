<?php

namespace App\Http\Controllers;

use App\Models\DataPerizinan;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class DataPerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Kita hanya mengambil permohonan yang berstatus 'Menunggu' atau 'Proses'
        // dan yang memiliki berkas dokumen (untuk membedakan dengan jalur manual jika diperlukan)
        $antrean = Permohonan::with('dokumens')
        ->has('dokumens')
        ->whereIn('status', ['Menunggu', 'Proses'])
        ->latest()
        ->paginate(10);

        return view('admin.verifikasi.index', compact('antrean'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DataPerizinan $dataPerizinan)
    {
        // Mengambil data permohonan beserta semua dokumen pendukungnya
        $permohonan = Permohonan::with('dokumens')->findOrFail($id);

        return view('admin.verifikasi.show', compact('permohonan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataPerizinan $dataPerizinan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataPerizinan $dataPerizinan)
    {
        $permohonan = Permohonan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Proses,Selesai,Ditolak',
            'catatan' => 'required_if:status,Ditolak|nullable|string'
        ]);

        // Update status permohonan utama
        $permohonan->update([
            'status' => $request->status,
        ]);

        // Jika status ditolak, kita bisa asumsikan ada catatan yang dikirim ke pemohon
        if ($request->status === 'Ditolak') {
            // Catatan ini nanti bisa disimpan ke kolom permohonan atau diolah lebih lanjut
            // Contoh jika Anda punya kolom catatan di tabel permohonans:
            // $permohonan->update(['catatan_koreksi' => $request->catatan]);
        }

        return redirect()->route('verifikasi.index')
            ->with('success', 'Status permohonan ' . $permohonan->no_pengajuan . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataPerizinan $dataPerizinan)
    {
        //
    }
}
