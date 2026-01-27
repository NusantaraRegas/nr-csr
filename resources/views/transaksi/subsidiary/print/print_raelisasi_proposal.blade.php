<!DOCTYPE html>
<html lang="en">
<head>
    <title>NR SHARE | Print Realisasi Proposal</title>
    <link rel="icon" type="image/png" href="{{ asset('template/assets/images/logoicon.png') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        //window.print()
    </script>

    <style>
        @media print {
            .cetak {
                visibility: hidden;
            }
        }

        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

</head>
<body style="margin: 0; padding: 0;">
<div class="container-fluid">
    <center>
        <div class="model-huruf-family"><br>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" height="100%" class="font">
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="padding: 10px 0 10px 0" align="center" width="130px">
                                    <img src="{{ asset('template/assets/images/logo-pertamina-gas-negara.png') }}"
                                         width="200px;">
                                </td>
                                <td align="center">
                                    <b style="font-size:18px; text-transform: uppercase">{{ $comp }}</b><br>
                                    <b style="font-size:16px;">LAPORAN REALISASI ANGGARAN TAHUN {{ $tahun }}</b><br>
                                    <b style="font-size:16px;">CORPORATE SOCIAL RESPONSIBILITY</b>
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
                        <table border="1" rules="all" cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="padding: 5px 5px 5px 5px" width="50px">No</th>
                                <th style="padding: 5px 5px 5px 5px" width="100px">Tanggal</th>
                                <th style="padding: 5px 5px 5px 5px" width="300px" nowrap>Program Kerja</th>
                                <th style="padding: 5px 5px 5px 5px" width="300px">Penerima Bantuan</th>
                                <th style="padding: 5px 5px 5px 5px" width="200px">Wilayah</th>
                                <th style="padding: 5px 5px 5px 5px" width="100px" nowrap>Jumlah (Rp)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dataRealisasi as $data)
                                <tr>
                                    <td style="text-align:center; padding: 5px 5px 5px 5px; vertical-align: top">{{ $loop->iteration }}</td>
                                    <td style="text-align:center; padding: 5px 5px 5px 5px; vertical-align: top">{{ date('d-m-Y', strtotime($data->tgl_realisasi)) }}</td>
                                    <td style="padding: 5px 5px 5px 5px; vertical-align: top">
                                        <b>{{ $data->proker }}</b><br>
                                        <span>{{ $data->pilar }}</span><br>
                                        <span style="color: gray">{{ $data->gols }}</span><br>
                                        <span style="color: red">{{ $data->prioritas }}</span>
                                    </td>
                                    <td style="padding: 5px 5px 5px 5px; vertical-align: top">
                                        <b style="text-transform: uppercase">{{ $data->nama_yayasan }}</b><br>
                                        <span style="color: gray">{{ $data->deskripsi }}</span>
                                    </td>
                                    <td style="padding: 5px 5px 5px 5px; vertical-align: top">
                                        <b>{{ $data->provinsi }}</b><br>
                                        <span style="color: gray">{{ $data->kabupaten }}</span>
                                    </td>
                                    <td style="text-align: right;padding: 5px 5px 5px 5px; vertical-align: top" nowrap>
                                        {{ number_format($data->nilai_bantuan,0,',','.') }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" style="text-align: center;padding: 5px 5px 5px 5px; vertical-align: top" nowrap><b>TOTAL</b></td>
                                <td style="text-align: right;padding: 5px 5px 5px 5px; vertical-align: top" nowrap><b>{{ number_format($total,0,',','.') }}</b></td>
                            </tr>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <br>
                    </td>
            </table>
        </div>
    </center>
</div>
</body>
</html>