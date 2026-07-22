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

        $antrean = Permohonan::with('dokumens')
        ->has('dokumens')
        ->whereIn('status', ['Menunggu', 'Proses'])
        ->latest()
        ->paginate(10);

        return view('verifikasi.index', compact('antrean'));
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

            //Email
            $dataEmail = [
                'no_pengajuan' => $noPengajuan,
                'nama_pemohon' => $request->nama_pemohon,
                'jenis_surat'  => $request->jenis_surat
            ];

            Mail::to($request->email)->send(new PengajuanSuksesMail($dataEmail));

            DB::commit();

            return redirect('/')
                ->with('success', "Pengajuan berhasil dikirim! Silakan catat Nomor Pengajuan Anda untuk pelacakan berkas: {$noPengajuan}")
                ->withFragment('pengajuan');

        } catch (\Exception $e) {
            // Jika ada error, batalkan semua perubahan data database dan file
            DB::rollBack();

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
        //
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

        if ($request->status === 'Ditolak') {

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
