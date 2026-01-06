<!DOCTYPE html>
<html>
<body>
<div class='container'>
    <p>Kepada Bapak/Ibu {{ $penerima }}</p>
    <p>Anda mendapatkan permohonan untuk melakukan persetujuan survei proposal sebagai berikut :</p>
    <table>
        <tr>
            <td>No Agenda</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $no_agenda }}</td>
        </tr>
        <tr>
            <td>Pengirim</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $pengirim }}</td>
        </tr>
        <tr>
            <td>Tanggal Penerimaan</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ date('d-m-Y', strtotime($tgl_terima)) }}</td>
        </tr>
        <tr>
            <td>Dari</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $dari }}</td>
        </tr>
        <tr>
            <td>No Proposal</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $no_surat }}</td>
        </tr>
        <tr>
            <td>Tanggal Proposal</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ date('d-m-Y', strtotime($tgl_surat)) }}</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $perihal }}</td>
        </tr>
        <tr>
            <td>Besar Permohonan</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ "Rp. ". number_format($permohonan,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Perkiraan Bantuan</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ "Rp. ". number_format($bantuan,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Hasil Survei 1</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $survei1 }}</td>
        </tr>
        <tr>
            <td>Hasil Survei 2</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $survei2 }}</td>
        </tr>
    </table>
    <p>Silahkan login <a href='https://share.pgn.co.id'>https://share.pgn.co.id</a> untuk melakukan persetujuan pada menu tasklist anda.</p>
    <p>
        Catatan :<br>
        Email ini dikirim secara otomatis by system<br>
        Mohon untuk tidak mereply.
    </p>
</div>
</body>
</html>