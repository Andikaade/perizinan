<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Permohonan - SI-PERIZINAN</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef2f5;
        }
        .email-header {
            background-color: #dc3545; /* Warna merah penolakan yang soft */
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .email-body {
            padding: 30px 25px;
            line-height: 1.6;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #f8f9fa;
            border-radius: 6px;
            overflow: hidden;
        }
        .info-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eef2f5;
            font-size: 14px;
        }
        .info-table td.label {
            font-weight: bold;
            color: #666666;
            width: 40%;
        }
        .info-table td.value {
            color: #111111;
        }
        .rejection-box {
            background-color: #fff5f5;
            border-left: 4px solid #dc3545;
            padding: 15px 20px;
            margin: 25px 0;
            border-radius: 0 6px 6px 0;
        }
        .rejection-title {
            color: #bd2130;
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 8px;
        }
        .rejection-reason {
            color: #495057;
            font-size: 14px;
            margin: 0;
            font-style: italic;
        }
        .btn-action {
            display: inline-block;
            background-color: #dc3545;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 25px;
            font-weight: bold;
            border-radius: 6px;
            margin: 20px 0;
            font-size: 14px;
            text-align: center;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888888;
            border-top: 1px solid #eef2f5;
        }
        .email-footer a {
            color: #dc3545;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>SI-PERIZINAN</h1>
            <div style="font-size: 13px; margin-top: 5px; opacity: 0.9;">Pemberitahuan Status Berkas</div>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p class="greeting">Halo, <strong>{{ $permohonan->nama_pemohon }}</strong>,</p>

            <p>Terima kasih telah menggunakan layanan mandiri SI-PERIZINAN. Kami ingin menginformasikan bahwa berkas permohonan yang Anda ajukan saat ini <strong>belum dapat kami setujui</strong> dengan detail sebagai berikut:</p>

            <!-- Informasi Permohonan -->
            <table class="info-table">
                <tr>
                    <td class="label">Nomor Pengajuan</td>
                    <td class="value"><strong>{{ $permohonan->no_pengajuan }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Jenis Perizinan</td>
                    <td class="value">{{ $permohonan->jenis_surat }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Pengajuan</td>
                    <td class="value">{{ \Carbon\Carbon::parse($permohonan->tgl_pengajuan)->translatedFormat('d F Y') }}</td>
                </tr>
            </table>

            <!-- Alasan Penolakan -->
            <div class="rejection-box">
                <div class="rejection-title">⚠️ Catatan / Alasan Penolakan:</div>
                <p class="rejection-reason">
                    "{{ $permohonan->catatan ?? 'Terdapat berkas persyaratan yang belum memenuhi standar validasi kami. Silakan periksa kembali kelengkapan dokumen Anda.' }}"
                </p>
            </div>

            <p>Anda dapat memperbaiki dokumen atau data yang bermasalah tersebut, kemudian mengirimkan kembali pengajuan baru melalui halaman utama portal kami.</p>

            <!-- Tombol Aksi -->
            <div style="text-align: center;">
                <a href="{{ url('/') }}#pengajuan" class="btn-action">Ajukan Ulang Permohonan</a>
            </div>

            <p style="font-size: 13px; color: #666666; margin-top: 30px;">
                Jika Anda merasa ada kekeliruan atau membutuhkan bantuan lebih lanjut mengenai penolakan ini, jangan ragu untuk menghubungi layanan bantuan kami.
            </p>

            <p style="margin-top: 25px; margin-bottom: 0;">Salam hangat,<br><strong>Tim Pelayanan SI-PERIZINAN</strong></p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>Email ini dikirimkan secara otomatis oleh sistem kami, mohon tidak membalas email ini secara langsung.</p>
            <p>&copy; {{ date('Y') }} SI-PERIZINAN Kabupaten. All Rights Reserved.</p>
            <p><a href="{{ url('/') }}">Kunjungi Website Kami</a></p>
        </div>
    </div>

</body>
</html>
