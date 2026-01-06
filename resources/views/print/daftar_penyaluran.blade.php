<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Penyaluran TJSL</title>
    <link rel="icon" type="image/png" href="{{ asset('template/assets/images/logoicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 13px;
            color: #000;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 6px;
            border: 1px solid #000;
            vertical-align: top;
        }

        .no-border td {
            border: none;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .font-bold {
            font-weight: bold;
        }

        .header-table td {
            vertical-align: top;
        }

        .header-table img {
            max-width: 150px;
        }

        .info-table td {
            padding: 2px 4px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="text-align: right; margin: 10px 0;">
        <button onclick="window.print()"
            style="padding: 6px 12px; font-size: 13px; border: none; border-radius: 4px; cursor: pointer;">
            🖨️ Print
        </button>
    </div>

    <table class="header-table no-border">
        <tr>
            <td width="200px">
                <img src="{{ asset('template/assets/images/logo-pertamina-gas-negara.png') }}" alt="Logo">
            </td>
            <td class="text-center" width="50%">
                <div class="font-bold" style="font-size: 16px;">
                    DAFTAR PENYALURAN TJSL TAHAP {{ $penyaluran_ke }}
                    TAHUN {{ $tahun }}
                </div>
                <div class="font-bold" style="font-size: 14px;">
                    PT Perusahaan Gas Negara Tbk
                </div>
                <div class="font-bold" style="font-size: 12px;">CSR Division</div>
            </td>
            <td width="200px">
                <table class="info-table">
                    <tr>
                        <td class="font-bold">No Surat</td>
                        <td>:</td>
                        <td>{{ $noSurat }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Tanggal</td>
                        <td>:</td>
                        <td>
                            {{ \Carbon\Carbon::parse($tglSurat)->translatedFormat('d F Y') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br>

    <table>
        <thead style="background-color: lightgray">
            <tr class="text-center font-bold">
                <th width="40px">No</th>
                <th width="160px">Disposisi</th>
                <th width="300px">Penerima Manfaat</th>
                <th width="160px">Wilayah</th>
                <th width="260px">Informasi Bank</th>
                <th width="120px">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataPenyaluran as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $data->no_agenda }}</strong><br>
                        {{ \Carbon\Carbon::parse($data->tgl_terima)->format('d-M-Y') }}
                    </td>
                    <td>
                        <strong>{{ strtoupper($data->nama_lembaga) }}</strong><br>
                        {{ $data->deskripsi }}
                    </td>
                    <td>
                        <strong>{{ $data->provinsi }}</strong><br>
                        {{ $data->kabupaten }}
                    </td>
                    <td>
                        <strong>{{ $data->nama_bank }}</strong><br>
                        Norek: {{ $data->no_rekening }}<br>
                        Atas Nama: {{ $data->atas_nama }}
                    </td>
                    <td class="text-right">
                        {{ number_format($data->jumlah_pembayaran, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-center">TOTAL</th>
                <th class="text-right">
                    {{ number_format($dataPenyaluran->sum('jumlah_pembayaran'), 0, ',', '.') }}
                </th>
            </tr>
        </tfoot>
    </table>

</body>

</html>
