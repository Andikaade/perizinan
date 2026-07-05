<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_perizinans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_izin')->unique(); // Nomor surat izin
            $table->string('nama_pemohon'); // Nama orang/perusahaan
            $table->string('alamat');
            $table->string('email');
            $table->string('phone');
            $table->string('jenis_perizinan'); // Contoh: IMB, SIUP, dll
            $table->date('tanggal_diajukan'); // Tanggal pengajuan
            $table->enum('status', ['proses', 'selesai', 'ditolak'])->default('proses'); // Status izin
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_perizinans');
    }
};
