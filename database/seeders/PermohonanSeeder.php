<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permohonan;
use Carbon\Carbon;

class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kosongkan tabel terlebih dahulu agar tidak duplikat saat dijalankan ulang
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permohonan::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info("Sedang membuat 20 data permohonan simulasi...");

        // Array bantuan untuk variasi data dummy
        $daftarNama = [
            'Rian Wijaya', 'Siti Aminah', 'Budi Santoso', 'Dewi Lestari', 'Ahmad Fauzi',
            'PT. Maju Mundur Sejahtera', 'CV. Berkah Abadi', 'Roni Purwanto', 'Eka Sari', 'Hendra Kusuma',
            'PT. Sinar Jaya Teknik', 'Slamet Riyadi', 'Yuliani', 'Umar Dt. Rajo Indo', 'Buyung',
            'Rince Oktasari', 'Yondra Zubir', 'Ajis Putra Nedi', 'Rozalina', 'Syafrial'
        ];

        $daftarJenisSurat = [
            'Pendaftaran Tanda Daftar Perusahaan (TDP)',
            'Permohonan Izin Mendirikan Bangunan (IMB)',
            'Izin Gangguan Tempat Usaha',
            'Permohonan Izin Operasional Klinik',
            'Pengajuan Surat Izin'
        ];

        // Daftar status bervariasi sesuai kebutuhan testing Anda
        $daftarStatus = ['Menunggu', 'Proses', 'Selesai'];

        // 2. Lakukan looping untuk membuat 20 data
        for ($i = 1; $i <= 20; $i++) {

            // Mengatur variasi tanggal pengajuan (misal: mundur beberapa hari ke belakang)
            $hariMundur = 20 - $i;
            $carbonTgl = Carbon::now()->subDays($hariMundur);
            $tglPengajuan = $carbonTgl->format('Y-m-d');
            $datePrefix = $carbonTgl->format('Ymd');

            // Format No Pengajuan: PRZ-YYYYMMDD-0001 sampai PRZ-YYYYMMDD-0020
            $noUrutPadded = str_pad($i, 4, '0', STR_PAD_LEFT);
            $noPengajuan = "PRZ-{$datePrefix}-{$noUrutPadded}";

            // Pilih data acak/bergantian dari array bantuan di atas
            $namaPemohon = $daftarNama[$i - 1];
            $jenisSurat  = $daftarJenisSurat[$i % count($daftarJenisSurat)];
            $status      = $daftarStatus[$i % count($daftarStatus)]; // Status bergantian otomatis

            // Tentukan tanggal proses dan selesai berdasarkan status
            $tglProses  = ($status !== 'Menunggu') ? $carbonTgl->addDays(1)->format('Y-m-d') : null;
            $tglSelesai = ($status === 'Selesai') ? $carbonTgl->addDays(3)->format('Y-m-d') : null;

            // Nomor surat resmi jika status sudah diproses/selesai
            $noSurat = ($status !== 'Menunggu') ? "640/" . str_pad($i, 3, '0', STR_PAD_LEFT) . "/DPMPTSP/2026" : null;

            Permohonan::create([
                'no_pengajuan'  => $noPengajuan,
                'nama_pemohon'  => $namaPemohon,
                'no_surat'      => $noSurat,
                'jenis_surat'   => $jenisSurat,
                'phone'         => '0812' . rand(10000000, 99999999),
                'email'         => strtolower(str_replace(['.', ' '], '', $namaPemohon)) . '@mail.com',
                'alamat'        => 'Jl. Merdeka No. ' . rand(1, 150) . ' RT ' . rand(1, 12) . ' RW ' . rand(1, 12),
                'tgl_pengajuan' => $tglPengajuan,
                'tgl_proses'    => $tglProses,
                'tgl_selesai'   => $tglSelesai,
                'status'        => $status,
            ]);
        }

        $this->command->info("Selesai! 20 data permohonan dengan status bervariasi berhasil ditambahkan.");
    }
}
