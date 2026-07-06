<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permohonan;
use Carbon\Carbon;

class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Kosongkan tabel terlebih dahulu
        Permohonan::truncate();

        $csvFile = database_path('data/permohonan.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("File CSV tidak ditemukan!");
            return;
        }

        $file = fopen($csvFile, 'r');

        // Ambil baris pertama sebagai header, lalu bersihkan whitespace/karakter aneh
        $header = fgetcsv($file);
        $header = array_map('trim', $header);

        // Otomatis mencari nomor urut kolom berdasarkan nama header di Google Sheets Anda
        $indexNoAntrian   = array_search('no_antrian', $header);
        $indexNama        = array_search('nama_pemohon', $header);
        $indexDeskripsi   = array_search('deskripsi_surat', $header);
        $indexPhone       = array_search('phone', $header);
        $indexAlamat      = array_search('alamat', $header);
        $indexTglPengajuan = array_search('tgl_pengajuan', $header);
        $indexTglProses   = array_search('tgl_proses', $header);
        $indexTglSelesai  = array_search('tgl_selesal', $header); // Sesuaikan jika ada typo 'tgl_selesal' di sheet
        if ($indexTglSelesai === false) {
            $indexTglSelesai = array_search('tgl_selesai', $header);
        }
        $indexStatus      = array_search('status', $header);

        $this->command->info("Sedang memproses baris data CSV...");

       while (($row = fgetcsv($file)) !== FALSE) {
            if (empty($row) || !isset($row[$indexNama])) continue;

            // 1. Ambil status asli dari CSV, bersihkan spasi, dan paksa jadi huruf kecil semua untuk memudahkan pengecekan
            $statusAsli = isset($row[$indexStatus]) ? trim(strtolower($row[$indexStatus])) : '';

            // 2. Normalisasi string ke nilai ENUM resmi database Anda ('Baru'/'Menunggu', 'Diproses', 'Selesai', 'Ditolak')
            if (str_contains($statusAsli, 'proses')) {
                // Ini akan menangkap kata 'proses', 'dalam proses', maupun 'diproses'
                $statusDatabase = 'Diproses';
            } elseif ($statusAsli === 'selesai' || $statusAsli === 'sukses') {
                $statusDatabase = 'Selesai';
            } elseif ($statusAsli === 'ditolak' || $statusAsli === 'gagal') {
                $statusDatabase = 'Ditolak';
            } else {
                // Jika status bawaannya 'baru', kosong, atau berupa tanda strip '-', set sesuai keinginan Anda
                // Ubah ke 'Menunggu' jika ENUM database Anda sudah diganti, atau biarkan 'Baru' jika memakai default awal.
                $statusDatabase = 'Diproses'; // Fallback aman jika datanya di luar dugaan
            }

            Permohonan::create([
                'no_pengajuan'  => $row[$indexNoAntrian] ?? null,
                'nama_pemohon'  => $row[$indexNama] ?? null,
                'jenis_surat'   => $row[$indexDeskripsi] ?? null,
                'phone'         => $row[$indexPhone] ?? null,
                'alamat'        => (!empty($row[$indexAlamat]) && $row[$indexAlamat] !== '-') ? $row[$indexAlamat] : 'Belum mengisi alamat atau data kosong',
                'tgl_pengajuan' => $this->parseCsvDate($row[$indexTglPengajuan] ?? null) ?? now()->format('Y-m-d'),
                'tgl_proses'    => $this->parseCsvDate($row[$indexTglProses] ?? null),
                'tgl_selesai'   => $this->parseCsvDate($row[$indexTglSelesai] ?? null),
                'status'        => $statusDatabase,
            ]);
        }

        fclose($file);
        $this->command->info("Impor data dari web petaru sukses dilakukan!");
    }
    /**
     * Helper untuk mengubah format tanggal dari Google Sheets ke format standard database (Y-m-d)
     */
    private function parseCsvDate($dateString)
    {
        if (empty($dateString) || $dateString == '-') {
            return null;
        }

        try {
            // Menangani format bawaan Google Sheet seperti "3-Sep-2025" atau "17-Jun-2026"
            return Carbon::parse($dateString)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
