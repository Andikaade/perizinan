<!DOCTYPE html>
<html>
<head>
    <title>Pesan Baru dari Website Perizinan</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2 style="color: #211B3D; border-bottom: 2px solid #F59E0B; padding-bottom: 10px;">Pesan Masuk Baru</h2>
        <p>Anda menerima pesan baru melalui formulir kontak website Perizinan Tata Ruang Kabupaten Sijunjung.</p>
        
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 130px; font-weight: bold; padding: 8px 0;">Nama Lengkap</td>
                <td style="padding: 8px 0;">: {{ $data['nama'] }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">Email Pengirim</td>
                <td style="padding: 8px 0;">: {{ $data['email'] }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">Subjek</td>
                <td style="padding: 8px 0;">: {{ $data['subjek'] }}</td>
            </tr>
        </table>

        <div style="margin-top: 20px; padding: 15px; background-color: #f9f9f9; border-left: 4px solid #F59E0B;">
            <p style="margin: 0; font-weight: bold;">Isi Pesan:</p>
            <p style="margin: 5px 0 0 0; white-space: pre-line;">{{ $data['pesan'] }}</p>
        </div>

        <p style="margin-top: 30px; font-size: 0.85rem; color: #777; text-align: center;">
            Sistem Notifikasi Otomatis Website Perizinan Kab. Sijunjung © 2026
        </p>
    </div>
</body>
</html>