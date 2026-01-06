<!DOCTYPE html>
<html>
<body>
<div class='container'>
    <p>Hai <b>{{ $nama }}</b></p>
    <p style="text-align: justify">Kami mendapatkan permohonan untuk melakukan perubahan terhadap password anda, jika itu memang benar silahkan klik
        link reset password dibawah ini.</p>
    <p><a href='{{ route('update-password', ['email' => encrypt($email), 'token' => encrypt($token)]) }}'>RESET PASSWORD</a></p>
    <p>
        Catatan :<br>
        Email ini dikirim secara otomatis by system<br>
        Mohon untuk tidak mereply.
    </p>
</div>
</body>
</html>