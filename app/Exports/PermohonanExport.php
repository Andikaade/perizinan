<?php

namespace App\Exports;

use App\Models\Permohonan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PermohonanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $queryData;

    public function __construct($queryData)
    {
        $this->queryData = $queryData;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->queryData->get();
    }

    // Menentukan teks Judul Kolom (Baris Pertama) di file Excel nanti
    public function headings(): array
    {
        return [
            'No. Pengajuan',
            'Nama Pemohon',
            'Jenis Surat',
            'Tanggal Masuk',
            'Status',
        ];
    }

    // Memetakan data dari database agar urutan kolomnya pas sesuai dengan headings di atas
    public function map($permohonan): array
    {
        return [
            $permohonan->no_pengajuan,
            $permohonan->nama_pemohon,
            $permohonan->jenis_surat,
            \Carbon\Carbon::parse($permohonan->tgl_pengajuan)->format('d/m/Y'),
            $permohonan->status,
        ];
    }
}

