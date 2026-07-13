<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permohonan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'no_pengajuan',
        'nama_pemohon',
        'no_surat',
        'alamat',
        'phone',
        'email',
        'jenis_surat',
        'tgl_pengajuan',
        'tgl_proses',
        'tgl_selesai',
        'status',
    ];

    public function dokumens()
    {
        return $this->hasMany(PermohonanDokumen::class, 'permohonan_id');
    }
}
