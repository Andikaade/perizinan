<!DOCTYPE html>
<html>
<head>
    <title>Permohonan Disetujui</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo, {{ $permohonan->nama_pemohon }}</h2>
    <p>Selamat! Permohonan perizinan Anda dengan nomor registrasi <strong>{{ $permohonan->no_pengajuan }}</strong> untuk jenis pengajuan <strong>{{ $permohonan->jenis_surat }}</strong> telah **Disetujui & Diterbitkan** oleh Dinas Tata Ruang.</p>

    <p>Dokumen resmi Surat Izin telah kami sertasikan di dalam lampiran (attachment) email ini dalam bentuk format PDF yang sudah dilengkapi dengan fitur pengesahan Tanda Tangan Digital berupa QR Code Validasi.</p>

    <p>Silakan unduh lampiran tersebut untuk digunakan sebagaimana mestinya.</p>

    <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
    <p style="font-size: 11px; color: #777;">Ini adalah email otomatis dari sistem SI-PERIZINAN, harap tidak membalas email ini secara langsung.</p>
</body>
</html>
