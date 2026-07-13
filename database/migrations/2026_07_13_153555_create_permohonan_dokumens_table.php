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
        Schema::create('permohonan_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonans')->onDelete('cascade');

            $table->string('nama_dokumen'); // Nanti otomatis terisi 'KTP', 'Sertifikat', atau 'Gambar Denah' saat upload
            $table->string('file_path');    // Lokasi penyimpanan file

            $table->enum('status_validasi', ['Menunggu', 'Valid', 'Tidak Valid'])->default('Menunggu');
            $table->text('catatan_koreksi')->nullable();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_dokumens');
    }
};
