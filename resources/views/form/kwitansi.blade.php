@php
    $terbilang = App\Helper\terbilang::terbilang($data->jumlah_pembayaran, 3);
    $termin = App\Helper\terbilang::terbilang($data->termin, 3);
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kuitansi Pembayaran</title>
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
            <div style="width:1000px; height:100%; background-color:white;">
                <br>
                <br>
                <br>
                <table align="center" border=1" cellpadding="0" rules="all" cellspacing="0" width="90%"
                    height="100%" class="font">
                    <tr>
                        <td bgcolor="#ffffff" colspan="2" height="100%"><br>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td colspan="5" style="text-align: center">
                                        &nbsp;<b style="font-size: 25px">KUITANSI</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="50px">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="width: 200px">&nbsp;Sudah terima dari</td>
                                                <td style="width: 5px; padding-right: 5px; vertical-align: top">:</td>
                                                <td>PT Perusahaan Gas Negara Tbk</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="height: 5px"></td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="width: 200px">&nbsp;Banyaknya uang</td>
                                                <td style="width: 5px; padding-right: 5px; vertical-align: top">:</td>
                                                <td>Rp. {{ number_format($data->jumlah_pembayaran, 2, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="width: 200px">&nbsp;</td>
                                                <td style="width: 5px">&nbsp;</td>
                                                <td>&nbsp;<i>{{ $terbilang }} Rupiah</i></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="height: 5px"></td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="width: 200px; vertical-align: top">&nbsp;Untuk Pembayaran
                                                </td>
                                                <td style="width: 5px; padding-right: 5px; vertical-align: top">:</td>
                                                @if ($dataSurvei->termin > 1)
                                                    <td style="vertical-align: top">Tahap ke {{ $data->termin }}
                                                        ({{ $termin }}) Bantuan Dana Dalam Rangka
                                                        {{ $dataAgenda->deskripsi }}, {{ $dataAgenda->asal_surat }} di
                                                        {{ $dataAgenda->kabupaten }} {{ $dataAgenda->provinsi }}</td>
                                                @else
                                                    <td style="vertical-align: top">Bantuan Dana Dalam Rangka
                                                        {{ $dataAgenda->deskripsi }}, {{ $dataAgenda->asal_surat }} di
                                                        {{ $dataAgenda->kabupaten }} {{ $dataAgenda->provinsi }}</td>
                                                @endif
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
                                    <td colspan="5" style="margin-left: 100px">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td rowspan="3" style="padding-left: 520px">
                                                    Jakarta,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="height: 5px"></td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td rowspan="3" style="text-align: justify; padding-left: 520px">
                                                    Penerima,
                                                    <br>
                                                    {{ ucwords($dataAgenda->asal_surat) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="height: 100px; padding-left: 520px">
                                        <small><i>Materai</i></small>
                                        <br>
                                        <small><i>ttd</i></small>
                                        <br>
                                        <small><i>Stempel</i></small>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td rowspan="3" style="padding-left: 520px">
                                                    <b>{{ ucwords($dataAgenda->pengaju_proposal) }}</b>
                                                    <br>
                                                    {{ ucwords($dataAgenda->sebagai) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="height: 50px">
                                        &nbsp;
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
