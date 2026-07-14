<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Berhasil</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h3 style="color: #1e3a8a;">Halo, {{ $data['nama_pemohon'] }}</h3>
        <p>Terima kasih, permohonan perizinan tata ruang Anda telah berhasil kami terima di dalam sistem.</p>

        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 6px; margin: 20px 0;">
            <p style="margin: 5px 0;"><strong>Nomor Pengajuan Anda:</strong></p>
            <p style="font-size: 20px; color: #2563eb; font-weight: bold; margin: 5px 0; letter-spacing: 1px;">
                {{ $data['no_pengajuan'] }}
            </p>
            <hr style="border: 0; border-top: 1px solid #d1d5db; my: 10px;">
            <p style="margin: 5px 0;"><strong>Jenis Perizinan:</strong> {{ $data['jenis_surat'] }}</p>
            <p style="margin: 5px 0;"><strong>Status Awal:</strong> <span style="background-color: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px; font-size: 12px;">Menunggu Verifikasi</span></p>
        </div>

        <p>Silakan simpan nomor pengajuan di atas untuk melakukan pelacakan status berkas Anda secara berkala melalui halaman utama website kami.</p>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #666;">
            Salam,<br>
            <strong>Dinas Perizinan Tata Ruang Kab. Sijunjung</strong><br>
            <small>Email ini dikirim otomatis oleh sistem, mohon untuk tidak membalas email ini.</small>
        </p>
    </div>
</body>
</html>
