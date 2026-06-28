<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPerizinan extends Model
{
    protected $table = 'data_perizinans'; 

    protected $fillable = [
        'nomor_izin',
        'nama_pemohon',
        'alamat',       
        'email',        
        'phone',        
        'jenis_perizinan',
        'tanggal_diajukan',
        'tanggal_terbit',
        'status',
        'keterangan'
    ];
}
