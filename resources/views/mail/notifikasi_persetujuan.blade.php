<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Selamat {{ $phase }} Proposal Disetujui</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #1e1e1e; padding: 30px;">
    <div
        style="max-width: 600px; margin: auto; background-color: #2c2c2c; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.3); color: #ffffff;">

        <h2 style="text-align: center; color: #28a745; margin-bottom: 25px;">🎉 Selamat, {{ $phase }} Proposal
            Disetujui</h2>

        <p style="font-size: 16px; line-height: 1.6;">
            Hai <strong style="color: #ffffff;">{{ $nama_penerima }}</strong>,<br><br>
            Kami dengan senang hati menginformasikan bahwa {{ $phase }} Proposal berikut telah
            <strong>disetujui</strong>:
        </p>

        <table style="width: 100%; font-size: 14px; color: #dddddd; margin: 20px 0;">
            <tr>
                <td style="font-weight: bold; width: 160px;">No Agenda</td>
                <td>{{ $no_agenda }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Tanggal Penerimaan</td>
                <td>{{ $tanggal_terima }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Pengirim</td>
                <td>{{ $pengirim }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Nama Lembaga/Yayasan</td>
                <td>{{ $nama_lembaga }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Perihal</td>
                <td>{{ $perihal }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Besar Permohonan</td>
                <td>{{ $besar_permohonan }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Perkiraan Bantuan</td>
                <td>{{ $perkiraan_bantuan }}</td>
            </tr>
        </table>

        <div style="text-align: center; margin: 35px 0;">
            <a href="{{ route('detailKelayakan', Crypt::encrypt($id)) }}"
                style="background-color: #0d6efd; color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
                Lihat Detail
            </a>
        </div>

        <p style="font-size: 14px; color: #cccccc;">
            Silakan cek sistem untuk informasi lebih lanjut dan langkah berikutnya.
        </p>

        <hr style="margin: 40px 0; border: none; border-top: 1px solid #444;">

        <p style="font-size: 12px; color: #888888; text-align: center;">
            Email ini dikirim otomatis oleh sistem kemitraan. Abaikan jika Anda merasa tidak berkaitan.
        </p>
    </div>
</body>

</html>
