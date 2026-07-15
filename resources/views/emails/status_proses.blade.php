<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Permohonan Sedang Diproses</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px; }
        .header { background-color: #3b82f6; color: white; padding: 15px; text-align: center; border-radius: 6px 6px 0 0; }
        .content { padding: 20px 10px; }
        .info-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .info-table td { padding: 8px; border-bottom: 1px solid #f1f5f9; }
        .info-table td.label { font-weight: bold; width: 35%; color: #475569; }
        .footer { font-size: 12px; text-align: center; color: #64748b; margin-top: 25px; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>SI-PERIZINAN TATA RUANG</h2>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $permohonan->nama_pemohon }}</strong>,</p>
            <p>Kabar baik! Berkas persyaratan permohonan izin Anda telah selesai diverifikasi oleh petugas admin dan dinyatakan <strong>Lengkap & Sah</strong>.</p>
            <p>Saat ini permohonan Anda sedang masuk ke dalam tahap <strong>Pembuatan & Penerbitan Dokumen Surat Resmi</strong>.</p>

            <table class="info-table">
                <tr>
                    <td class="label">Nomor Registrasi</td>
                    <td>: {{ $permohonan->no_pengajuan }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Perizinan</td>
                    <td>: {{ $permohonan->jenis_izin }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Update</td>
                    <td>: {{ now()->translatedFormat('d F Y H:i') }} WIB</td>
                </tr>
            </table>

            <p>Anda akan menerima notifikasi email baru kembali setelah surat resmi diterbitkan oleh dinas terkait.</p>
            <p>Terima kasih atas kerja samanya.</p>
        </div>
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh Sistem Informasi Perizinan Tata Ruang.<br>Mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
