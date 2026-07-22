<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Mail\StatusDisetujuiMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class PublicValidasiController extends Controller
{
    public function index()
    {
        $daftarPermohonan = Permohonan::whereIn('status', ['Ready to Cetak', 'Disetujui', 'Proses'])
            ->latest()
            ->get();

        return view('penerbitan.index', compact('daftarPermohonan'));
    }

    public function verifikasi($no_pengajuan)
    {
        $permohonan = Permohonan::where('no_pengajuan', $no_pengajuan)->first();

        if (!$permohonan) {
            return view('public.validasi_gagal', ['pesan' => 'Dokumen tidak terdaftar di sistem SI-PERIZINAN.']);
        }

        if ($permohonan->status !== 'Selesai') {
            return view('public.validasi_gagal', ['pesan' => 'Dokumen ditemukan, namun status perizinan belum sah/diterbitkan.']);
        }

        return view('public.validasi_sukses', compact('permohonan'));
    }

    public function terbitkanSurat($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        // 1. URL Validasi Publik
        $urlValidasi = route('public.validasi.surat', ['no_pengajuan' => $permohonan->no_pengajuan]);

        // 2. Buat folder sementara untuk QR Code jika belum ada
        $tempDir = public_path('temp_qr');
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0777, true, true);
        }

        // 3. Simpan QR Code SVG ke file sementara (Margin 2 & Size 180 agar tajam & cepat di-scan HP)
        $qrFileName = 'qr_' . $permohonan->id . '_' . time() . '.svg';
        $qrFilePath = $tempDir . '/' . $qrFileName;

        $qrCodeRaw = QrCode::format('svg')
            ->size(150)
            ->margin(2)
            ->errorCorrection('M')
            ->generate($urlValidasi);

        $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeRaw);

        // 4. Data untuk PDF View
        $data = [
            'permohonan'   => $permohonan,
            'qrCodeBase64' => $qrCodeBase64,
            'tgl_cetak'    => now()->translatedFormat('d F Y')
        ];

        // 5. Render PDF

        $pdf = Pdf::loadView('pdf.surat_izin', $data)
        ->setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);

        $namaFile = 'surat_izin_' . $permohonan->no_pengajuan . '.pdf';
        Storage::disk('public')->put('surat_izin/' . $namaFile, $pdf->output());


        // 7. Hapus file temporary QR Code agar folder public tidak menumpuk file sampah
        if (File::exists($qrFilePath)) {
            File::delete($qrFilePath);
        }

        // 8. Update Status
        $permohonan->status = 'Selesai';
        $permohonan->file_surat = $namaFile;
        $permohonan->save();

        // 9. Penentuan Email Tujuan
        $targetEmail = $permohonan->email
            ?? $permohonan->email_pemohon
            ?? 'andika.test@gmail.com';

        // 10. Pengiriman Email
        try {
            Mail::to($targetEmail)->send(new StatusDisetujuiMail($permohonan, $namaFile));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email perizinan: ' . $e->getMessage());

            return redirect()->back()->with('success', 'Surat Izin diterbitkan, TETAPI email gagal dikirim. Cek error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Surat Izin berhasil diterbitkan dan dikirim ke email!');
    }

    public function validasiPublic($no_pengajuan)
    {
        $permohonan = Permohonan::where('no_pengajuan', $no_pengajuan)->firstOrFail();

        return view('public.validasi_surat', compact('permohonan'));
    }
}
