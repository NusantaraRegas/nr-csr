<!DOCTYPE html>
<html lang="en">
<head>
    <title>Realisasi Anggaran Program Kerja</title>
    <link rel="icon" type="image/png" href="{{ asset('template/assets/images/printer.png') }}">
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
                                    <b style="font-size:20px; text-transform: uppercase">{{ $comp }}</b><br>
                                    <b style="font-size:16px;">REALISASI ANGGARAN PROGRAM KERJA TAHUN {{ $tahun }}</b><br>
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
                                <th style="padding: 5px 5px 5px 5px" width="50px" nowrap>Proker ID</th>
                                <th style="padding: 5px 5px 5px 5px" width="400px">Program Kerja</th>
                                <th style="padding: 5px 5px 5px 5px" width="300px">SDGs</th>
                                <th style="padding: 5px 5px 5px 5px" width="150px">Anggaran (Rp)</th>
                                <th style="padding: 5px 5px 5px 5px" width="150px">Realisasi (Rp)</th>
                                <th style="padding: 5px 5px 5px 5px" width="150px">Sisa (Rp)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dataProker as $data)
                                <?php
                                $proker = \App\Models\Proker::where('id_proker', $data['proker_id'])->first();
                                $sisa = $proker->anggaran - ($data['progress'] + $data['paid']);
                                ?>
                                <tr>
                                    <td style="text-align:center; padding: 5px 5px 5px 5px; vertical-align: top">{{ "#".$data['proker_id'] }}</td>
                                    <td style="padding: 5px 5px 5px 5px; vertical-align: top">
                                        <span class="font-weight-bold">{{ $proker->proker }}</span>
                                        @if($proker->prioritas != "")
                                            <br>
                                            <span style="color: grey">{{ $proker->prioritas }}</span>
                                        @else
                                            <br>
                                            <span style="color: red">Non Prioritas</span>
                                        @endif
                                    </td>
                                    <td style="padding: 5px 5px 5px 5px; vertical-align: top">
                                        <span class="font-weight-bold">{{ $proker->pilar }}</span>
                                        <br>
                                        <span style="color: grey">{{ $proker->gols }}</span>
                                    </td>
                                    <td style="text-align: right; padding: 5px 5px 5px 5px; vertical-align: top">
                                        {{ number_format($proker->anggaran,0,',','.') }}
                                    </td>
                                    <td style="text-align: right; padding: 5px 5px 5px 5px; vertical-align: top">
                                        {{ number_format($data['paid'] + $data['progress'],0,',','.') }}
                                    </td>
                                    <td style="text-align: right; padding: 5px 5px 5px 5px; vertical-align: top">
                                        @if($sisa >= 0)
                                            <span class="font-weight-bold">{{ number_format($sisa,0,',','.') }}</span>
                                        @else
                                            <span class="font-weight-bold"
                                                  style="color: red">{{ number_format($sisa,0,',','.') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @foreach($prokerNonRelokasi as $dp)
                                <tr>
                                    <td style="text-align:center; padding: 5px 5px 5px 5px; vertical-align: top">{{ "#".$dp->id_proker }}</td>
                                    <td style="padding: 5px 5px 5px 5px; vertical-align: top">
                                        <span class="font-weight-bold">{{ $dp->proker }}</span>
                                        @if($dp->prioritas != "")
                                            <br>
                                            <span style="color: grey">{{ $dp->prioritas }}</span>
                                        @else
                                            <br>
                                            <span style="color: red">Non Prioritas</span>
                                        @endif
                                    </td>
                                    <td style="padding: 5px 5px 5px 5px; vertical-align: top" nowrap>
                                        <span class="font-weight-bold">{{ $dp->pilar }}</span>
                                        <br>
                                        <span style="color: grey">{{ $dp->gols }}</span>
                                    </td>
                                    <td style="text-align: right; padding: 5px 5px 5px 5px; vertical-align: top">
                                        {{ number_format($dp->anggaran,0,',','.') }}
                                    </td>
                                    <td style="text-align: right; padding: 5px 5px 5px 5px; vertical-align: top">
                                        0
                                    </td>
                                    <td style="text-align: right; padding: 5px 5px 5px 5px; vertical-align: top">
                                        <span class="font-weight-bold">{{ number_format($dp->anggaran,0,',','.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" style="text-align:center; padding: 5px 5px 5px 5px; vertical-align: top"><b>TOTAL</b></td>
                                <td style="text-align: right; padding: 5px 5px 5px 5px; vertical-align: top">
                                    <b>{{ number_format($anggaran,0,',','.') }}</b>
                                </td>
                                <td style="text-align: right; padding: 5px 5px 5px 5px; vertical-align: top">
                                    <b>{{ number_format($totalRealisasi,0,',','.') }}</b>
                                </td>
                                <td style="text-align: right; padding: 5px 5px 5px 5px; vertical-align: top">
                                    <b>{{ number_format($anggaran - $totalRealisasi,0,',','.') }}</b>
                                </td>
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