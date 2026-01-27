<!DOCTYPE html>
<html lang="en">
<head>
    <title>SHARE | Laporan Realisasi Proposal</title>
    <link rel="icon" type="image/png" href="{{ asset('template/assets/images/logoicon.png') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        window.print()
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
<body style="margin: 0; padding: 0;" bgcolor="grey">
<div class="container-fluid">
    <center>
        <div class="model-huruf-family" style="height:100%; background-color:white;"><br>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" height="100%" class="font">
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="padding: 10px 0 10px 0" align="center" width="130px">
                                    <img src="{{ asset('template/assets/images/logopgn.png') }}" width="70px;">
                                </td>
                                <td align="center">
                                    <b style="font-size:18px;">LAPORAN REALISASI PROPOSAL</b><br>
                                    <b style="font-size:18px;">PERIODE {{ date('d M Y', strtotime($tanggal1)) }} S.d {{ date('d M Y', strtotime($tanggal2)) }}</b>
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
                                <th style="padding: 5px 5px 5px 5px" width="100px">Date</th>
                                <th style="padding: 5px 5px 5px 5px" width="100px">PR ID</th>
                                <th style="padding: 5px 5px 5px 5px" width="300px">Description</th>
                                <th style="padding: 5px 5px 5px 5px" width="100px">Type</th>
                                <th style="padding: 5px 5px 5px 5px" width="200px">Sector</th>
                                <th style="padding: 5px 5px 5px 5px" width="150px">Region</th>
                                <th style="padding: 5px 5px 5px 5px" width="150px">Billing Amount</th>
                                <th style="padding: 5px 5px 5px 5px" width="150px">Deduction</th>
                                <th style="padding: 5px 5px 5px 5px" width="150px">Total Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dataPayment as $data)
                                <tr>
                                    <td nowrap style="text-align: center">{{ date('d-m-Y', strtotime($data['action_date'])) }}</td>
                                    <td style="text-align: center">{{ $data['id'] }}</td>
                                    <td style="padding: 5px 5px 5px 5px">
                                        <b style="color: red">{{ $data['invoice_num'] }}</b>
                                        <br>
                                        <small style="color: gray">{{ date('d-m-Y', strtotime($data['invoice_date'])) }}</small>
                                        <br>
                                        {{ $data['description_detail'] }}
                                    </td>
                                    <td style="text-align: center">{{ $data['attribute1'] }}</td>
                                    <td style="padding: 5px 5px 5px 5px">{{ $data['attribute2'] }}</td>
                                    <td style="padding: 5px 5px 5px 5px">
                                        <b>{{ $data['attribute3'] }}</b><br>
                                        <small style="color: gray">{{ $data['attribute4'] }}</small>
                                    </td>
                                    <td nowrap style="text-align: right; padding-right: 5px">Rp. {{ number_format($data['invoice_amount'],0,',','.') }}</td>
                                    <td nowrap style="text-align: right; padding-right: 5px">Rp. {{ number_format($data['invoice_refund'],0,',','.') }}</td>
                                    <td nowrap style="text-align: right; padding-right: 5px">Rp. {{ number_format($data['invoice_amount_paid'],0,',','.') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
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