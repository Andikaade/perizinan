<?php

namespace App\Http\Controllers;

use App\Models\DataPerizinan;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengajuanSuksesMail;

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
        // 1. Validasi Input Form
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'required|email|max:255',
            'jenis_surat'  => 'required|string',
            'alamat'       => 'required|string',
            'dokumen_ktp'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'dokumen_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Gunakan Database Transaction agar jika salah satu upload gagal, data tidak pincang
        DB::beginTransaction();

        try {
            // 2. Generate Nomor Pengajuan Otomatis (Format: REG-YYYYMMDD-0001)
            $tanggal = date('Ymd');

            // Cari nomor urut terakhir pada hari ini
            $terakhir = DB::table('permohonans')
                ->where('no_pengajuan', 'LIKE', "REG-{$tanggal}-%")
                ->orderBy('id', 'desc')
                ->first();

            if ($terakhir) {
                // Ambil 4 angka terakhir, lalu tambah 1
                $nomorUrut = substr($terakhir->no_pengajuan, -4);
                $urut = str_pad((int)$nomorUrut + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $urut = '0001';
            }

            $noPengajuan = "REG-{$tanggal}-{$urut}";

            // 3. Simpan Data Utama ke Tabel `permohonans`
            $permohonanId = DB::table('permohonans')->insertGetId([
                'no_pengajuan'  => $noPengajuan,
                'nama_pemohon'  => $request->nama_pemohon,
                'phone'         => $request->phone,
                'email'         => $request->email,
                'jenis_surat'   => $request->jenis_surat,
                'alamat'        => $request->alamat,
                'tgl_pengajuan' => date('Y-m-d'),
                'status'        => 'Menunggu',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // 4. Proses Upload Dokumen ke Tabel `permohonan_dokumens`
            $dokumenDibutuhkan = [
                'dokumen_ktp' => 'KTP Pemohon',
                'dokumen_sertifikat' => 'Sertifikat Tanah'
            ];

            foreach ($dokumenDibutuhkan as $inputName => $namaDokumen) {
                if ($request->hasFile($inputName)) {
                    $file = $request->file($inputName);

                    // Simpan fisik file ke folder storage/app/public/dokumen_permohonan
                    $path = $file->store('dokumen_permohonan', 'public');

                    // Catat data file ke database permohonan_dokumens
                    DB::table('permohonan_dokumens')->insert([
                        'permohonan_id'  => $permohonanId,
                        'nama_dokumen'   => $namaDokumen,
                        'file_path'      => $path,
                        'status_validasi'=> 'Menunggu',
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }
            }

            // ==================== KODE BARU: KIRIM EMAIL NOTIFIKASI ====================
            // Siapkan data minimal yang ingin ditampilkan di dalam template email
            $dataEmail = [
                'no_pengajuan' => $noPengajuan,
                'nama_pemohon' => $request->nama_pemohon,
                'jenis_surat'  => $request->jenis_surat
            ];

            // Kirim email ke alamat email yang dimasukkan oleh pemohon di formulir
            Mail::to($request->email)->send(new PengajuanSuksesMail($dataEmail));
            // ===========================================================================

            // Jika semua berhasil, komit data ke database
            DB::commit();

            // Kembalikan ke halaman sebelumnya dengan membawa pesan sukses dan nomor regis
            return redirect('/')
                ->with('success', "Pengajuan berhasil dikirim! Silakan catat Nomor Pengajuan Anda untuk pelacakan berkas: {$noPengajuan}")
                ->withFragment('pengajuan');

        } catch (\Exception $e) {
            // Jika ada error, batalkan semua perubahan data database dan file
            DB::rollBack();

            // return redirect('/')
            //     ->with('error_cari', 'Terjadi kesalahan sistem saat menyimpan pengajuan. Silakan coba beberapa saat lagi.')
            //     ->withFragment('pengajuan');
            return redirect('/')
                ->with('error_cari', 'Gagal menyimpan: ' . $e->getMessage())
                ->withFragment('pengajuan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
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
    public function update(Request $request, $id)
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
