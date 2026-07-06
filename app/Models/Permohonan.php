<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_pengajuan',
        'nama_pemohon',
        'alamat',
        'phone',
        'email',
        'no_surat',
        'jenis_surat',
        'tgl_pengajuan',
        'tgl_proses',
        'tgl_selesai',
        'status',
    ];
}
