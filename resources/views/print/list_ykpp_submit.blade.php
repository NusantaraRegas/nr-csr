<!DOCTYPE html>
<html lang="en">

<head>
    <title>Daftar Penyaluran TJSL</title>
    <link rel="icon" type="image/png" href="{{ asset('template/assets/images/logoicon.png') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        @media print {
            .cetak {
                visibility: hidden;
            }
        }
    </style>

</head>

<body style="margin: 0; padding: 0;">
    <div class="container-fluid">
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" height="100%"
                class="font">
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="padding: 10px 0 10px 0" align="center" width="150px">
                                    <img src="{{ asset('template/assets/images/logo-pertamina-gas-negara.png') }}"
                                        width="200px;">
                                </td>
                                <td align="center">
                                    <b style="font-size:18px;">DAFTAR PENYALURAN TJSL TAHAP {{ $penyaluran_ke }}
                                        TAHUN {{ $tahun }}</b><br>
                                    <b style="font-size:18px;">PT Perusahaan Gas Negara Tbk</b><br>
                                    <b style="font-size:16px;">CSR Division</b>
                                </td>
                                <td width="300px">
                                    <table>
                                        <tr>
                                            <td>No Surat</td>
                                            <td>:</td>
                                            <td>{{ $noSurat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal</td>
                                            <td>:</td>
                                            <td>
                                                @if ($tglSurat != '')
                                                    {{ date('d M Y', strtotime($tglSurat)) }}
                                                @endif
                                            </td>
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
                                    <th style="padding: 5px 5px 5px 5px" class="text-center" width="50px">No</th>
                                    <th style="padding: 5px 5px 5px 5px" class="text-center" width="200px">No
                                        Agenda</th>
                                    <th style="padding: 5px 5px 5px 5px" class="text-center" width="300px">Penerima
                                        Manfaat
                                    </th>
                                    <th style="padding: 5px 5px 5px 5px" class="text-center" width="200px">Wilayah
                                    </th>
                                    <th style="padding: 5px 5px 5px 5px" class="text-center" width="300px">
                                        Informasi Bank
                                    </th>
                                    <th style="padding: 5px 5px 5px 5px" class="text-center" width="100px">Jumlah
                                        (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPenyaluran as $data)
                                    <tr>
                                        <td style="padding: 5px 5px 5px 5px; text-align: center; vertical-align: top">
                                            {{ $loop->iteration }}</td>
                                        <td style="padding: 5px 5px 5px 5px; text-align: center; vertical-align: top"
                                            nowrap>{{ strtoupper($data->no_agenda) }}</td>
                                        <td style="padding: 5px 5px 5px 5px; vertical-align: top">
                                            <b class="font-weight-bold text-uppercase">{{ $data->asal_surat }}</b><br>
                                            <span class="text-muted">{{ $data->deskripsi }}</span>
                                        </td>
                                        <td style="padding: 5px 5px 5px 5px; vertical-align: top">
                                            <b class="font-weight-bold">{{ $data->provinsi }}</b><br>
                                            <span class="text-muted">{{ $data->kabupaten }}</span>
                                        </td>
                                        <td style="padding: 5px 5px 5px 5px; vertical-align: top">
                                            <b class="font-weight-bold">{{ $data->nama_bank }}</b><br>
                                            <span class="text-dark">{{ $data->no_rekening }}</span><br>
                                            <span class="text-muted">{{ $data->atas_nama }}</span>
                                        </td>
                                        <td style="padding: 5px 5px 5px 5px; text-align: right; vertical-align: top">
                                            {{ number_format($data->nominal_approved, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr>
                                    <th colspan="5"
                                        style="padding: 5px 5px 5px 5px; text-align: center; vertical-align: top">
                                        TOTAL
                                    </th>
                                    <th style="padding: 5px 5px 5px 5px; text-align: right; vertical-align: top">
                                        {{ number_format($data->sum('nominal_approved'), 0, ',', '.') }}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <br>
                        <br>
                    </td>
            </table>
        </center>
    </div>
</body>

</html>
