<!DOCTYPE html>
<html>
<body>
<div class='container'>
    <p>Kepada Bapak/Ibu {{ $penerima }}</p>
    <p>Survei proposal yang anda buat telah disetujui :</p>
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
            <td>Sektor Bantuan</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $sektor }}</td>
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
        <tr>
            <td>Besar Permohonan</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ "Rp. ". number_format($permohonan,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Nilai Bantuan</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ "Rp. ". number_format($bantuan,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Termin Pembayaran</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $termin }}</td>
        </tr>
        <tr>
            <td>Surveyor 1</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $survei1 }}</td>
        </tr>
        <tr>
            <td>Surveyor 2</td>
            <td>&nbsp;:</td>
            <td>&nbsp;{{ $survei2 }}</td>
        </tr>
    </table>
    <p>
        Catatan :<br>
        Email ini dikirim secara otomatis by system<br>
        Mohon untuk tidak mereply.
    </p>
</div>
</body>
</html>