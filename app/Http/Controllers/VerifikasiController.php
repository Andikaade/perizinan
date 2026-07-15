<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Mail\StatusProsesMail;
use App\Mail\StatusDitolakMail;
use Illuminate\Support\Facades\Mail;

class VerifikasiController extends Controller
{
    /**
     * Halaman daftar antrean berkas masuk (Menu: Verifikasi)
     */
    public function index()
    {
        $antrean = Permohonan::with('dokumens')
            ->has('dokumens')
            ->whereIn('status', ['Menunggu', 'Proses'])
            ->latest()
            ->paginate(10);

        return view('verifikasi.index', compact('antrean'));
    }

    /**
     * Halaman detail pemeriksaan berkas permohonan
     */
    public function show($id)
    {
        $permohonan = Permohonan::with('dokumens')->findOrFail($id);
        return view('verifikasi.show', compact('permohonan'));
    }

   /**
     * Proses keputusan verifikasi (Proses / Tolak)
     */
    public function update(Request $request, $id)
    {
        $permohonan = Permohonan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Proses,Ditolak',
            'catatan' => 'required_if:status,Ditolak|nullable|string|max:1000'
        ], [
            'status.required' => 'Keputusan verifikasi wajib dipilih.',
            'catatan.required_if' => 'Alasan penolakan wajib diisi jika Anda menolak berkas.',
        ]);

        // Siapkan data yang akan di-update
        $updateData = [
            'status' => $request->status,
        ];

        // LOGIKA BARU: Jika status berubah menjadi 'Proses'
        if ($request->status === 'Proses') {
            // Isi kolom tanggal proses dengan tanggal hari ini (menggunakan helper now() dari Laravel)
            // *Sesuaikan 'tgl_proses' di bawah ini dengan nama kolom asli di database Anda*
            $updateData['tgl_proses'] = now();
            $updateData['catatan'] = null; // Reset catatan jika sebelumnya ada penolakan

            if (!empty($permohonan->email)) {
                Mail::to($permohonan->email)->send(new StatusProsesMail($permohonan));
            }
        }
        // Jika status ditolak
        elseif ($request->status === 'Ditolak') {
            $updateData['catatan'] = $request->catatan;
            $updateData['tgl_proses'] = null; // Reset tanggal proses jika berkas ditolak/dikembalikan ke draf

            if (!empty($permohonan->email)) {
                Mail::to($permohonan->email)->send(new StatusDitolakMail($permohonan));
            }
        }

        // Eksekusi update data ke database sekaligus
        $permohonan->update($updateData);

        return redirect()->route('verifikasi.index')
            ->with('success', 'Status permohonan ' . $permohonan->no_pengajuan . ' berhasil diperbarui.');
    }
}
