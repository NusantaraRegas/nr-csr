<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kode OTP Anda</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 30px;">

    <div
        style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <h2 style="color: #333333; text-align: center;">🔐 Verifikasi Dua Langkah</h2>
        <p style="font-size: 16px; color: #555555;">
            Hai <strong>{{ $nama }}</strong>,<br><br>
            Berikut adalah kode OTP Anda untuk verifikasi login:
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; letter-spacing: 8px; color: #000000; font-weight: bold;">
                {{ $otp }}
            </span>
        </div>

        <p style="font-size: 14px; color: #777777;">
            Kode ini hanya berlaku selama <strong>5 menit</strong>. Jangan bagikan kode ini kepada siapa pun.
        </p>

        <hr style="margin: 40px 0; border: none; border-top: 1px solid #eaeaea;">

        <p style="font-size: 12px; color: #aaaaaa; text-align: center;">
            Jika Anda tidak merasa melakukan permintaan ini, harap abaikan email ini.
        </p>

    </div>

</body>

</html>
