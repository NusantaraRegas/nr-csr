<?php
date_default_timezone_set("Asia/Bangkok");

function tanggal_indo($tanggal)
{
    $bulan = array(1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}

$tglSurat = date('Y-m-d', strtotime($data->tgl_surat));
//$tglTolak = date('Y-m-d', strtotime($data->revisi_date));
?>

        <!DOCTYPE html>
<html lang="en">
<head>
    <title>Surat Penolakan</title>
    <link rel="icon" type="image/png" href="{{ asset('template/assets/images/logoicon.png') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .font {
            font-family: sans-serif
        }
    </style>

</head>
<body style="margin: 0; padding: 0;" bgcolor="grey">
<div class="container-fluid">
    <center>
        <div style="width:1000px; height:100%; background-color:white;"><br>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="90%" height="100%" class="font">
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="padding: 10px 0 10px 0" align="center" width="150px">
                                    &nbsp;
                                </td>
                                <td align="center">

                                </td>
                                <td width="130px">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td style="text-align:center"><b>&nbsp;</b></td>
                                        </tr>
                                        <tr>
                                            <td style="height: 90px; text-align:center"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" colspan="2" height="100%"><br>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td colspan="5">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td style="width: 200px">Nomor</td>
                                            <td style="width: 5px"><span style="margin-left:2px">:</span></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td style="width: 200px">Sifat</td>
                                            <td style="width: 5px"><span style="margin-left:2px">:</span></td>
                                            <td>&nbsp;Segera</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td style="width: 200px">Lampiran</td>
                                            <td style="width: 5px"><span style="margin-left:2px">:</span></td>
                                            <td>&nbsp;-</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td style="width: 200px">Perihal</td>
                                            <td style="width: 5px"><span style="margin-left:2px">:</span></td>
                                            <td>&nbsp;Tanggapan atas Permohonan Dukungan</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td rowspan="3">Jakarta,</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td rowspan="3">Yang Terhormat,</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td rowspan="3">{{ $data->sebagai }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td rowspan="3">{{ $data->asal_surat }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td rowspan="3">{{ $data->alamat }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td rowspan="3" style="text-align: justify">Menanggapi surat dan proposal Saudara tanggal
                                                {{ tanggal_indo($tglSurat) }} perihal {{ ucwords($data->perihal) }}, pada dasarnya kami menyambut baik kegiatan
                                                dalam permohonan tersebut. Namun demikian, tanpa mengurangi dukungan,
                                                dengan sangat menyesal Perusahaan kami belum dapat memenuhi permohonan
                                                tersebut.
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td rowspan="3" style="text-align: justify">
                                                Atas perhatian Saudara, kami sampaikan terima kasih.
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td rowspan="3" style="text-align: justify">
                                                Division Head, Corporate Social Responsibility
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="100px">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td rowspan="3" style="text-align: justify">
                                                Anak Agung Raka Haryana
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
            </table>
            <table>
                <tr>
                    <td style="height: 50px"></td>
                </tr>
            </table>
            <br>
        </div>
    </center>
</div>
</body>
</html>