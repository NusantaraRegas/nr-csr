<!DOCTYPE html>
<html>
<body>
<div class='container'>
    <p>Kepada Bapak/Ibu {{ $penerima }}</p>
    <p>Dokumen BAST sebagai berikut sudah direview oleh Legal :</p>
    <table>
        <tr>
            <td>No Agenda</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $noAgenda }}</td>
        </tr>
        <tr>
            <td>Sektor Bantuan</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $sektorBantuan }}</td>
        </tr>
        <tr>
            <td>Bantuan Untuk</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $bantuanUntuk }}</td>
        </tr>
        <tr>
            <td>Dari</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $proposalDari }}</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>&nbsp;:</td>
            <td>
                <table>
                    <tr>
                        <td>
                            {{ $perihal }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <p>Mohon untuk dilengkapi Nomor dan Tanggal BAST untuk kebutuhan lampiran permohonan pembayaran.</p>
    <p>Silahkan login <a href='{{ url('/') }}'>{{ url('/') }}</a> untuk melakukan verifikasi pada menu
        tasklist anda.</p>
    <p>
        Catatan :<br>
        Email ini dikirim secara otomatis by system<br>
        Mohon untuk tidak mereply.
    </p>
</div>
</body>
</html>