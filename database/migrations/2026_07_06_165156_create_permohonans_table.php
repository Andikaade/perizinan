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
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengajuan')->unique();
            $table->string('nama_pemohon');
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('no_surat')->nullable();
            $table->string('jenis_surat');

            // Kolom Tanggal Proses Alur
            $table->date('tgl_pengajuan');
            $table->date('tgl_proses')->nullable();
            $table->date('tgl_selesai')->nullable();
            // Kolom Status Manajemen
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->default('Menunggu');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
