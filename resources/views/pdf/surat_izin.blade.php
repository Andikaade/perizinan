<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Izin Pemanfaatan Ruang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2, .header h3 {
            margin: 2px 0;
            text-transform: uppercase;
        }
        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            text-decoration: underline;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .content-table td {
            padding: 5px;
            vertical-align: top;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .footer-table td {
            vertical-align: top;
        }
        .notes {
            font-size: 9pt;
            color: #555;
        }
    </style>
</head>
<body>

    <!-- Header / Kop Surat -->
    <div class="header">
        <h2>Pemerintah Kabupaten / Kota</h2>
        <h3>Dinas Tata Ruang dan Perizinan</h3>
        <p style="font-size: 9pt; margin: 0;">Jl. Raya Pusat Pemerintahan No. 123, Kode Pos 12345</p>
    </div>

    <!-- Judul Dokumen -->
    <div class="title">
        SURAT IZIN PEMANFAATAN RUANG (IPR)<br>
        <span style="font-weight: normal; font-size: 10pt;">NOMOR: {{ $permohonan->no_pengajuan }}</span>
    </div>

    <p>Berdasarkan hasil verifikasi tim teknis Dinas Tata Ruang, dengan ini memberikan izin pemanfaatan ruang kepada:</p>

    <!-- Tabel Detail -->
    <table class="content-table">
        <tr>
            <td style="width: 25%;">Nama Pemohon</td>
            <td style="width: 2%;">:</td>
            <td><strong>{{ $permohonan->nama_pemohon ?? $permohonan->nama ?? 'Pemohon' }}</strong></td>
        </tr>
        <tr>
            <td>Jenis Perizinan</td>
            <td>:</td>
            <td>{{ $permohonan->jenis_perizinan ?? 'Izin Pemanfaatan Ruang (IPR)' }}</td>
        </tr>
        <tr>
            <td>Tanggal Persetujuan</td>
            <td>:</td>
            <td>{{ $tgl_cetak }}</td>
        </tr>
        <tr>
            <td>Status Dokumen</td>
            <td>:</td>
            <td style="color: green; font-weight: bold;">SAH & DITERBITKAN</td>
        </tr>
    </table>

    <p>Dokumen ini sah dan dikeluarkan secara elektronik oleh sistem <strong>SI-PERIZINAN</strong>. Segala ketentuan dan aturan penataan ruang wajib dipatuhi sesuai undang-undang yang berlaku.</p>

    <!-- Table TTD dan QR Code (Aman dari Cellmap Error) -->
    <table class="footer-table">
        <tr>
            <td style="width: 55%;" class="notes">
                <p>*Catatan:<br>
                Dokumen ini ditandatangani secara digital.<br>
                Silakan scan QR Code di samping untuk melakukan verifikasi keaslian dokumen fisik ini secara online.</p>
            </td>
            <td style="width: 45%; text-align: center;">
                <p style="margin: 0;">Diterbitkan tanggal:<br>{{ $tgl_cetak }}</p>
                <p style="font-weight: bold; margin: 5px 0 10px 0;">Kepala Dinas Tata Ruang</p>

                <!-- Menampilkan QR Code SVG -->
              @if(!empty($qrCodeBase64))
                    <img src="{{ $qrCodeBase64 }}" width="130" height="130" alt="QR Code Validasi">
                @else
                    <p style="color: red; font-size: 10px;">[QR CODE GAGAL LOAD]</p>
                @endif
            </td>
        </tr>
    </table>

</body>
</html>
