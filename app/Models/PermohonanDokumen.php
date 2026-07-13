<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermohonanDokumen extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'permohonan_dokumens';

    protected $fillable = [
    'permohonan_id',
    'nama_dokumen',
    'file_path',
    'status_validasi',
    'catatan_koreksi',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }
}
