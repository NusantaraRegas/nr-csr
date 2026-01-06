<!DOCTYPE html>
<html>
<body>
<div class='container'>
    <p>Hai {{ $penerima }}</p>
    <p>Anda mendapatkan Permintaan Penawaran Harga sebagai berikut :</p>
    <table>
        <tr>
            <td>Nomor</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $no_spph }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($tanggal))) }}</td>
        </tr>
        <tr>
            <td>Nama Proyek</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $namaProyek }}</td>
        </tr>
    </table>
    <p>Mohon untuk melakukan respon permintaan tersebut pada Menu My Task di Aplikasi <a href='https://share.pgn.co.id'>https://share.pgn.co.id</a>.</p>
    <p>
        Catatan :<br>
        Email ini dikirim secara otomatis by system<br>
        Mohon untuk tidak mereply.
    </p>
</div>
</body>
</html>