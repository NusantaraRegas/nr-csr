<?php
date_default_timezone_set("Asia/Bangkok");

$tglBuat = date('Y-m-d', strtotime($data->tgl_bast));

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

$day = date('D', strtotime($tglBuat));
$dayList = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
);

function kekata($x)
{
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x < 12) {
        $temp = " " . $angka[$x];
    } else if ($x < 20) {
        $temp = kekata($x - 10) . " belas";
    } else if ($x < 100) {
        $temp = kekata($x / 10) . " puluh" . kekata($x % 10);
    } else if ($x < 200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x < 1000) {
        $temp = kekata($x / 100) . " ratus" . kekata($x % 100);
    } else if ($x < 2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x < 1000000) {
        $temp = kekata($x / 1000) . " ribu" . kekata($x % 1000);
    } else if ($x < 1000000000) {
        $temp = kekata($x / 1000000) . " juta" . kekata($x % 1000000);
    } else if ($x < 1000000000000) {
        $temp = kekata($x / 1000000000) . " milyar" . kekata(fmod($x, 1000000000));
    } else if ($x < 1000000000000000) {
        $temp = kekata($x / 1000000000000) . " trilyun" . kekata(fmod($x, 1000000000000));
    }
    return $temp;
}

function hurufTanggal($x, $style = 4)
{
    if ($x < 0) {
        $hasil1 = "minus " . trim(kekata($x));
    } else {
        $hasil1 = trim(kekata($x));
    }
    return ucwords($hasil1);
}


function terbilang($x, $style = 4)
{
    if ($x < 0) {
        $hasil = "minus " . trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }
    return $hasil;
}

$tanggal = terbilang(date('d', strtotime($data->tgl_bast)));
$tglSurat = terbilang(date('d', strtotime($data->tgl_surat)));
$bulan = date('m', strtotime($data->tgl_bast));
$year = date('Y', strtotime($data->tgl_bast));
$tahun = terbilang(date('Y', strtotime($data->tgl_bast)));
$termin = terbilang($data->termin);
$persen1 = terbilang($data->persen1);
$persen2 = terbilang($data->persen2);
$persen3 = terbilang($data->persen3);
$persen4 = terbilang($data->persen4);
$rupiah1 = terbilang($data->rupiah1);
$rupiah2 = terbilang($data->rupiah2);
$rupiah3 = terbilang($data->rupiah3);
$rupiah4 = terbilang($data->rupiah4);
$rupiahKambing = terbilang($jumlahKambing);
$rupiahSapi = terbilang($jumlahSapi);

$jumlahBarang = terbilang($data->jumlah_barang);

$terbilang = terbilang($data->nilai_approved, $style = 2);

if ($bulan == '01') {
    $bulannya = 'Januari';
} elseif ($bulan == '02') {
    $bulannya = 'Februari';
} elseif ($bulan == '03') {
    $bulannya = 'Maret';
} elseif ($bulan == '04') {
    $bulannya = 'April';
} elseif ($bulan == '05') {
    $bulannya = 'Mei';
} elseif ($bulan == '06') {
    $bulannya = 'Juni';
} elseif ($bulan == '07') {
    $bulannya = 'Juli';
} elseif ($bulan == '08') {
    $bulannya = 'Agustus';
} elseif ($bulan == '09') {
    $bulannya = 'September';
} elseif ($bulan == '10') {
    $bulannya = 'Oktober';
} elseif ($bulan == '11') {
    $bulannya = 'November';
} elseif ($bulan == '12') {
    $bulannya = 'Desember';
}

$tglSurat = date('Y-m-d', strtotime($data->tgl_surat));
$tglPelimpahan = date('Y-m-d', strtotime($data->tgl_pelimpahan));

$hewanKurban = \App\Models\Kelayakan::where('no_agenda', $data->no_agenda)->first();

?>

        <!DOCTYPE html>
<html lang="en">
<head>
    <title>Berita Acara</title>
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

        @media print {
            .cetak {
                visibility: hidden;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0;" bgcolor="grey">
<div class="container-fluid">
    <center>
        <div style="width:1000px; height:100%; background-color:white;"><br>
            <a href="javascript:void(0);" onclick="javascript:window.print();" class="cetak"
               style="font-size: 20px; color: #3598DC; margin-right: -900px"><i class="fa fa-print"></i></a>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="90%" height="100%" class="font">
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="padding: 10px 0 25px 0" align="center" width="200px">
                                    <img src="{{ asset('template/assets/images/logo-pertamina-gas-negara.png') }}" width="200px;">
                                </td>
                                <td align="center">
                                    <b class="font" style="font-size:18px;">BERITA ACARA SERAH TERIMA BANTUAN</b><br>
                                    <b class="font"
                                       style="font-size:18px;">SEKTOR {{ strtoupper($data->sektor_bantuan) }}</b><br>
                                    <b class="font" style="font-size:18px;">DALAM RANGKA BANTUAN HEWAN QURBAN
                                        TAHUN {{ $year }}</b><br>
                                    <b class="font"
                                       style="font-size:18px;">PT PERUSAHAAN GAS NEGARA Tbk</b><br>
                                    <br>
                                    <br>
                                </td>
                                <td width="200px">
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
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" colspan="2" height="100%"><br>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="padding: 4px 0 4px 3px ;text-align: justify" colspan="3">
                                    Pada hari ini {{ $dayList[$day] }} tanggal {{ ucwords($tanggal) }}
                                    bulan {{ $bulannya }} tahun {{ ucwords($tahun) }},
                                    ({{ date('d/m/Y', strtotime($data->tgl_bast)) }}), kami yang bertanda
                                    tangan di bawah ini :
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0 4px 3px ;text-align: left; width: 150px" colspan="3">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 0 0px 3px ;text-align: left; width: 150px">Nama</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: center; width: 10px">:</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: left; width: 500px"><b>Anak Agung Raka
                                        Haryana</b></td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 0 0px 3px ;text-align: left; width: 150px">Jabatan</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: center; width: 10px">:</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: left; width: 500px">Division Head Corporate
                                    Social Responsibility PT Perusahaan Gas Negara Tbk
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 0 0px 3px ;text-align: left; width: 150px">Alamat</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: center; width: 10px">:</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: left; width: 500px">Jl. KH. Zainul Arifin
                                    No. 20 Jakarta 11140
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" height="10px"></td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0 4px 3px ;text-align: justify" colspan="3">
                                    Dalam hal ini bertindak untuk dan atas nama PT Perusahaan Gas Negara Tbk,
                                    selanjutnya disebut “Pihak Pertama”.
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0 4px 3px ;text-align: left; width: 150px" colspan="3">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 0 0px 3px ;text-align: left; width: 150px">Nama</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: center; width: 10px">:</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: left; width: 500px">
                                    <b>{{ ucwords($data->penanggung_jawab) }}</b></td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 0 0px 3px ;text-align: left; width: 150px">Jabatan</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: center; width: 10px">:</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: left; width: 500px">{{ ucwords($data->bertindak_sebagai) }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 0 0px 3px ;text-align: left; width: 150px">Nama Lembaga</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: center; width: 10px">:</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: left; width: 500px">{{ ucwords($data->proposal_dari) }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 0 0px 3px ;text-align: left; width: 150px">Alamat</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: center; width: 10px">:</td>
                                <td style="padding: 4px 0 4px 0 ;text-align: left; width: 500px">{{ $data->alamat }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" height="10px"></td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0 4px 3px ;text-align: justify" colspan="3">
                                    Dalam hal ini bertindak untuk dan atas nama lembaga tersebut di
                                    atas, selanjutnya disebut “Pihak Kedua”.
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" height="5px"></td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0 4px 3px ;text-align: justify" colspan="3">
                                    Pihak Pertama telah menyerahkan kepada Pihak Kedua dan Pihak Kedua telah menerima
                                    dari Pihak Pertama bantuan untuk Pengadaan Hewan Qurban sebanyak {{ $jumlahSapi }} ({{ strtolower($rupiahSapi) }}) ekor sapi dan {{ $jumlahKambing }} ({{ strtolower($rupiahKambing) }}) ekor kambing.
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" height="10px"></td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0 4px 3px ;text-align: justify" colspan="3">
                                    Demikian Berita Acara ini dibuat, disetujui dan ditandatangani oleh wakil-wakil yang
                                    berwenang dari Pihak Pertama dan Pihak Kedua pada tanggal sebagaimana tersebut pada
                                    Berita Acara, dalam rangkap 2 (dua) asli, bermeterai cukup, masing-masing mempunyai
                                    kekuatan hukum yang sama dan mengikat masing-masing pihak tanpa tekanan dan paksaan,
                                    serta sekaligus merupakan kuitansi tanda terima.
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="25px"></td>
                            </tr>
                            <tr>
                                <td colspan="5" height="25px"></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table border="0" width="100%">
                                        <tr style="text-align: center">
                                            <td width="50%"><b>PIHAK KEDUA</b></td>
                                            <td><b>PIHAK PERTAMA</b></td>
                                        </tr>
                                        <tr style="text-align: center">
                                            <td>{{ ucwords($data->proposal_dari) }}</td>
                                            <td>PT Perusahaan Gas Negara Tbk,</td>
                                        </tr>
                                        <tr style="text-align: center">
                                            <td height="170px">&nbsp;</td>
                                            <td height="170px">&nbsp;</td>
                                        </tr>
                                        <tr style="text-align: center">
                                            <td><b>{{ ucwords($data->penanggung_jawab) }}</b></td>
                                            <td><b>{{ ucwords($data->nama_pejabat) }}</b></td>
                                        </tr>
                                        <tr style="text-align: center">
                                            <td>{{ ucwords($data->bertindak_sebagai) }}</td>
                                            <td>{{ ucwords($data->jabatan_pejabat) }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="height: 40px"></td>
                </tr>
            </table>
            <br>
        </div>
    </center>
</div>
</body>
</html>