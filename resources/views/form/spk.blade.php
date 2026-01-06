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

$termin = terbilang($data->termin);
$rupiah1 = terbilang($data->rupiah1);
$rupiah2 = terbilang($data->rupiah2);
$rupiah3 = terbilang($data->rupiah3);
$rupiah4 = terbilang($data->rupiah4);

$terbilang = terbilang($data->nominal, $style = 2);

$tglSPK = date('Y-m-d', strtotime($data->tgl_spk));
$tglSurat = date('Y-m-d', strtotime($data->tgl_penawaran));
$tglBAST = date('Y-m-d', strtotime($data->tgl_berita_acara));
$tglBatasWaktu = date('Y-m-d', strtotime($data->due_date));

$panjangKegiatan = strlen($data->kegiatan);

?>

        <!DOCTYPE html>
<html lang="en">
<head>
    <title>Surat Perintah Kerja</title>
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
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="85%" height="100%" class="font">
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="padding: 10px 0 10px 0" align="left" width="130px">
                                    <img src="{{ asset('template/assets/images/logopgn.png') }}" width="70px;">
                                </td>
                                <td align="center">
                                    <b class="font" style="font-size:18px;">SURAT PERINTAH KERJA</b>
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
                                    <table width="100%" border="0">
                                        <tr>
                                            <td style="width: 200px">Nomor</td>
                                            <td style="width: 5px">:</td>
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
                                            <td style="width: 5px">:</td>
                                            <td>Segera</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td style="width: 200px">Lampiran</td>
                                            <td style="width: 5px">:</td>
                                            <td>-</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td style="width: 200px">Perihal</td>
                                            <td style="width: 5px">:</td>
                                            <td>Surat Perintah Kerja (“SPK”) untuk {{ $data->kegiatan }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td rowspan="3">Jakarta, ..............................</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
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
                                            <td rowspan="3">{{ $data->jabatan }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td rowspan="3">{{ $data->perusahaan }}</td>
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
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align: justify">
                                    Sehubungan dengan rencana PT Perusahaan Gas Negara Tbk. Corporate Social
                                    Responsibility Division (“PGN”) melaksanakan {{ $data->kegiatan }}. Dengan
                                    ini kami menugaskan {{ $data->perusahaan }} untuk melaksanakan {{ $data->kegiatan }}
                                    sebagaimana dimaksud dengan rincian sebagai berikut (untuk
                                    selanjutnya disebut “Program”).
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table cellpadding="0" border="1" rules="all" cellspacing="0" width="100%"
                                           class="font">
                                        <tr>
                                            <th colspan="4">Tabel Rincian</th>
                                        </tr>
                                        <tr>
                                            <th width="50px" style="text-align: center">No</th>
                                            <th width="400px" style="text-align: center">{{ $data->header1 }}</th>
                                            <th width="200px" style="text-align: center">{{ $data->header2 }}</th>
                                            <th width="200px">{{ $data->header3 }}</th>
                                        </tr>
                                        @foreach($dataDetailSPK as $dataDetail)
                                            <tr>
                                                <td width="50px" style="text-align: center">{{ $loop->iteration }}</td>
                                                <td width="400px">&nbsp;{{ $dataDetail->column1 }}</td>
                                                <td width="200px" style="text-align: center">{{ $dataDetail->column2 }}</td>
                                                <td width="200px" style="text-align: center">{{ $dataDetail->column3 }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    Dengan persyaratan sebagai berikut:
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td style="width: 30px; float: left">1.</td>
                                <td colspan="5" width="800px">
                                    <table width="100%">
                                        <tr>
                                            <td style="text-align: justify">
                                                SPK ini berlaku sebagai Perjanjian/dasar Pelaksanaan
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td style="width: 20px; float: left">2.</td>
                                <td colspan="5" width="800px">
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                Kecuali secara tegas dinyatakan lain, kata-kata dan/atau
                                                ungkapan-ungkapan dalam SPK ini mempunyai arti :
                                                <br>
                                                <table style="margin-top: 10px" border="0">
                                                    <tr>
                                                        <td style="float: left; text-align: center; width: 30px">
                                                            a.
                                                        </td>
                                                        <td colspan="4">
                                                            <table width="100%" border="0">
                                                                <tr>
                                                                    <td width="150px">Pengguna Barang dan/atau Jasa</td>
                                                                    <td width="20px"
                                                                        style="float: left; text-align: right">:&nbsp;
                                                                    </td>
                                                                    <td width="500px">PT Perusahaan Gas Negara Tbk,
                                                                        Corporate Social Responsibility Division (“PGN”)
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="float: left; text-align: center; width: 30px">
                                                            b.
                                                        </td>
                                                        <td colspan="4">
                                                            <table width="100%" border="0">
                                                                <tr>
                                                                    <td width="150px">Penyedia Barang dan/atau Jasa</td>
                                                                    <td width="20px"
                                                                        style="float: left; text-align: right">:&nbsp;
                                                                    </td>
                                                                    <td width="500px"
                                                                        style="float: left">
                                                                        &nbsp;{{ $data->perusahaan }}</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="float: left; text-align: center; width: 30px">
                                                            c.
                                                        </td>
                                                        <td colspan="4">
                                                            <table width="100%" border="0">
                                                                <tr>
                                                                    <td width="150px">Para Pihak</td>
                                                                    <td width="20px"
                                                                        style="float: left; text-align: right">:&nbsp;
                                                                    </td>
                                                                    <td width="500px">Pengguna Barang dan/atau Jasa dan
                                                                        Penyedia Barang dan/atau Jasa
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="float: left; text-align: center; width: 30px">
                                                            d.
                                                        </td>
                                                        <td colspan="4">
                                                            <table width="100%" border="0">
                                                                <tr>
                                                                    <td width="150px" style="float: left">Pekerjaan</td>
                                                                    <td width="20px"
                                                                        style="float: left; text-align: right">:&nbsp;
                                                                    </td>
                                                                    <td width="500px">{{ $data->kegiatan }}</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="float: left; text-align: center; width: 30px">
                                                            e.
                                                        </td>
                                                        <td colspan="4">
                                                            <table width="100%" border="0">
                                                                <tr>
                                                                    <td width="150px">Nilai Pekerjaan</td>
                                                                    <td width="20px"
                                                                        style="float: left; text-align: right">:&nbsp;
                                                                    </td>
                                                                    <td width="500px">Definisi sebagaimana diatur dalam
                                                                        angka 7 (tujuh) SPK ini.
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" height="20px"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20px; float: left">3.</td>
                                <td colspan="5" width="800px">
                                    <table width="100%">
                                        <tr>
                                            <td style="text-align: justify">
                                                Lampiran SPK yang ditentukan di bawah ini harus dibaca serta merupakan
                                                bagian yang tidak terpisahkan dari SPK, yaitu :
                                                <br>
                                                <table style="margin-top: 10px" border="0">
                                                    <tr>
                                                        <td style="float: left; text-align: center; width: 30px">
                                                            a.
                                                        </td>
                                                        <td colspan="4">
                                                            Surat Penawaran Nomor: {{ $data->no_penawaran }}
                                                            Tanggal {{ tanggal_indo($tglSurat) }};
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="float: left; text-align: center; width: 30px">
                                                            b.
                                                        </td>
                                                        <td colspan="4">
                                                            Berita Acara Klarifikasi dan Negosiasi Pengadaan Kaos dan
                                                            Topi untuk {{ $data->kegiatan }}
                                                            Nomor {{ $data->no_berita_acara }} Tanggal
                                                            {{ tanggal_indo($tglBAST) }}.
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" height="20px"></td>
                                                    </tr>
                                                </table>
                                                Apabila terdapat perbedaan penafsiran diantara dokumen-dokumen tersebut
                                                di atas, Para Pihak sepakat bahwa dokumen yang berlaku adalah dokumen
                                                yang diterbitkan terakhir.
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td style="width: 20px; float: left">4.</td>
                                <td colspan="5" width="800px">
                                    <table width="100%">
                                        <tr>
                                            <td style="text-align: justify">
                                                Syarat-syarat dalam lampiran SPK sebagaimana dimaksud dalam poin 3
                                                (tiga) diatas mengikat Para Pihak, kecuali diubah dengan kesepakatan
                                                bersama.
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td style="width: 20px; float: left">5.</td>
                                <td colspan="5" width="800px">
                                    <table width="100%">
                                        <tr>
                                            <td style="text-align: justify">
                                                Sesuai dengan ketentuan SPK :
                                                <br>
                                                <table style="margin-top: 10px" border="0">
                                                    <tr>
                                                        <td style="float: left; text-align: center; width: 30px">
                                                            a.
                                                        </td>
                                                        <td colspan="4">
                                                            Penyedia Barang dan Jasa wajib melaksanakan dan
                                                            menyelesaikan Pengadaan tsb secara cermat, akurat dan penuh
                                                            tanggung jawab sesuai dengan rincian sebagaimana ditetapkan
                                                            dalam SPK ini beserta lampirannya.
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="float: left; text-align: center; width: 30px">
                                                            b.
                                                        </td>
                                                        <td colspan="4">
                                                            Pengguna Barang dan Jasa berhak untuk melakukan pengecekan
                                                            atas Pengadaan tsb. Apabila Pengadaan tsb dinyatakan tidak
                                                            melaksanakan dengan baik maka Penyedia Barang dan Jasa
                                                            berkewajiban untuk melaksanakan ulang Pengadaan tsb.
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td style="width: 20px; float: left">6.</td>
                                <td colspan="5" width="800px">
                                    <table width="100%">
                                        <tr>
                                            <td style="text-align: justify">
                                                Pengguna Barang dan Jasa wajib membayar kepada Penyedia Barang dan Jasa
                                                atas Pengadaan dan penyelesaian Pengadaan berdasarkan Nilai Pekerjaan
                                                yang telah disepakati dalam SPK ini.
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td style="width: 20px; float: left">7.</td>
                                <td colspan="5" width="800px">
                                    <table width="100%">
                                        <tr>
                                            <td style="text-align: justify">
                                                Nilai Pekerjaan Pengadaan adalah
                                                Rp{{ number_format($data->nominal,2,',','.') }}
                                                ({{ strtolower($terbilang) }} Rupiah)
                                                sudah termasuk Pajak Pertambahan Nilai (“PPN”) dan pajak-pajak lainnya
                                                sesuai dengan ketentuan peraturan perundang-undangan yang berlaku di
                                                Indonesia (jika ada).
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td style="width: 20px; float: left">8.</td>
                                <td colspan="5" width="800px">
                                    <table width="100%">
                                        <tr>
                                            <td style="text-align: justify">
                                                SPK ini berlaku dan mengikat Para Pihak sejak tanggal ditandatangani.
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" height="20px"></td>
                            </tr>
                            <tr>
                                <td style="width: 20px; float: left">9.</td>
                                <td colspan="5" width="800px">
                                    <table width="100%">
                                        <tr>
                                            <td style="text-align: justify">
                                                Pembayaran
                                                @if($data->termin == '1')
                                                    <br>
                                                    <table style="margin-top: 10px" border="0">
                                                        <tr>
                                                            <td style="float: left; text-align: center; width: 30px">
                                                                a.
                                                            </td>
                                                            <td colspan="4">
                                                                Pembayaran Nilai Pengadaan sebagaimana dimaksud dalam
                                                                angka 7 (tujuh) diatas dilakukan sekaligus, yakni
                                                                sebesar Rp{{ number_format($data->nominal,2,',','.') }}
                                                                ({{ strtolower($terbilang) }} Rupiah) dibayar
                                                                setelah SPK ditandatangani dan Penyedia Barang dan/atau
                                                                Jasa menyampaikan permohonan pembayaran dan laporan
                                                                pelaksanaan kegiatan secara lengkap dan benar;
                                                                @else
                                                                    <br>
                                                                    <table style="margin-top: 10px" border="0">
                                                                        <tr>
                                                                            <td style="float: left; text-align: center; width: 30px">
                                                                                a.
                                                                            </td>
                                                                            <td colspan="4">
                                                                                Pembayaran Nilai Pengadaan sebagaimana
                                                                                dimaksud dalam angka
                                                                                7 (tujuh) diatas dilakukan
                                                                                melalui {{ $data->termin }}
                                                                                ({{strtolower($termin)}}) tahap
                                                                                pembayaran, yakni :
                                                                                <br>
                                                                                <table style="margin-top: 10px"
                                                                                       border="0">
                                                                                    <tr>
                                                                                        <td style="float: left; text-align: center; width: 30px">
                                                                                            i)
                                                                                        </td>
                                                                                        <td colspan="4">
                                                                                            Tahap 1 (satu) sebesar
                                                                                            Rp{{ number_format($data->rupiah1,2,',','.') }}
                                                                                            ({{ strtolower($rupiah1) }}
                                                                                            Rupiah) dibayar
                                                                                            setelah SPK
                                                                                            ditandatangani dan Penyedia
                                                                                            Barang dan/atau Jasa
                                                                                            menyampaikan permohonan
                                                                                            pembayaran secara
                                                                                            lengkap dan benar;
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="5"
                                                                                            height="5px"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="float: left; text-align: center; width: 30px">
                                                                                            ii)
                                                                                        </td>
                                                                                        <td colspan="4">
                                                                                            Tahap 2 (dua) sebesar
                                                                                            Rp{{ number_format($data->rupiah2,2,',','.') }}
                                                                                            ({{ strtolower($rupiah2) }}
                                                                                            Rupiah) dibayar
                                                                                            selambat-lambatnya
                                                                                            14 (Empat Belas) hari
                                                                                            setelah Kegiatan selesai
                                                                                            100% (Seratus persen) yang
                                                                                            dibuktikan dengan
                                                                                            tanda terima dan pemeriksaan
                                                                                            barang dari
                                                                                            Penyedia Barang dan/atau
                                                                                            Jasa kepada Pengguna
                                                                                            Barang dan/atau Jasa serta
                                                                                            setelah diterima dan
                                                                                            dinyatakan lengkap dan
                                                                                            benarnya seluruh dokumen
                                                                                            pembayaran yang
                                                                                            dipersyaratkan oleh Pengguna
                                                                                            Barang dan/atau Jasa kepada
                                                                                            Penyedia Barang
                                                                                            dan/atau Jasa.
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="5"
                                                                                            height="5px"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="float: left; text-align: center; width: 30px">
                                                                                            iii)
                                                                                        </td>
                                                                                        <td colspan="4">
                                                                                            Tahap 3 (tiga) sebesar
                                                                                            Rp{{ number_format($data->rupiah3,2,',','.') }}
                                                                                            ({{ strtolower($rupiah3) }}
                                                                                            Rupiah) dibayar
                                                                                            selambat-lambatnya
                                                                                            14 (Empat Belas) hari
                                                                                            setelah Kegiatan selesai
                                                                                            100% (Seratus persen) yang
                                                                                            dibuktikan dengan
                                                                                            tanda terima dan pemeriksaan
                                                                                            barang dari
                                                                                            Penyedia Barang dan/atau
                                                                                            Jasa kepada Pengguna
                                                                                            Barang dan/atau Jasa serta
                                                                                            setelah diterima dan
                                                                                            dinyatakan lengkap dan
                                                                                            benarnya seluruh dokumen
                                                                                            pembayaran yang
                                                                                            dipersyaratkan oleh Pengguna
                                                                                            Barang dan/atau Jasa kepada
                                                                                            Penyedia Barang
                                                                                            dan/atau Jasa.
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" height="20px"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="float: left; text-align: center; width: 50px">
                                                                                b.
                                                                            </td>
                                                                            <td colspan="4">
                                                                                <table width="100%">
                                                                                    <tr>
                                                                                        <td style="text-align: justify">
                                                                                            Adapun pembayaran atas Nilai
                                                                                            Pengadaan
                                                                                            sebagaimana dimaksud dalam
                                                                                            angka 7 (tujuh) SPK
                                                                                            ini dilakukan melalui dengan
                                                                                            cara transfer ke
                                                                                            rekening yang ditunjuk oleh
                                                                                            Penyedia Barang
                                                                                            dan/atau Jasa sebagai
                                                                                            berikut :
                                                                                            <br>
                                                                                            <table style="margin-top: 5px">
                                                                                                <tr>
                                                                                                    <td>Nama Bank</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $data->nama_bank }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Cabang</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $data->cabang }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>No Rekening&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ $data->no_rekening }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Atas Nama</td>
                                                                                                    <td>:</td>
                                                                                                    <td>{{ strtoupper($data->atas_nama) }}</td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" height="20px"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="float: left; text-align: center; width: 50px">
                                                                                c.
                                                                            </td>
                                                                            <td colspan="5" width="800px">
                                                                                <table width="100%">
                                                                                    <tr>
                                                                                        <td style="text-align: justify">
                                                                                            Sehubungan dengan Pembayaran
                                                                                            Nilai Pekerjaan,
                                                                                            Penyedia Jasa wajib
                                                                                            menyampaikan permohonan
                                                                                            pembayaran yang dilengkapi
                                                                                            dengan dokumen
                                                                                            pembayaran yang terdiri
                                                                                            atas:
                                                                                            <br>
                                                                                            <table style="margin-top: 10px"
                                                                                                   border="0">
                                                                                                <tr>
                                                                                                    <td style="float: left; text-align: center; width: 30px">
                                                                                                        1)
                                                                                                    </td>
                                                                                                    <td colspan="4">
                                                                                                        asli Kuitansi;
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="float: left; text-align: center; width: 30px">
                                                                                                        2)
                                                                                                    </td>
                                                                                                    <td colspan="4">
                                                                                                        asli
                                                                                                        <i>Invoice</i>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="float: left; text-align: center; width: 30px">
                                                                                                        3)
                                                                                                    </td>
                                                                                                    <td colspan="4">
                                                                                                        Faktur Pajak
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="float: left; text-align: center; width: 30px">
                                                                                                        4)
                                                                                                    </td>
                                                                                                    <td colspan="4">
                                                                                                        salinan Surat
                                                                                                        Perintah Kerja
                                                                                                        (SPK);
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="float: left; text-align: center; width: 30px">
                                                                                                        5)
                                                                                                    </td>
                                                                                                    <td colspan="4">
                                                                                                        dokumen
                                                                                                        pendukung
                                                                                                        lainnya
                                                                                                        sebagaimana
                                                                                                        diperysaratkan
                                                                                                        oleh PGN
                                                                                                        berdasarkan
                                                                                                        peraturan yang
                                                                                                        berlaku
                                                                                                        di PGN (apabila
                                                                                                        diperlukan).
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="5"
                                                                                                        height="20px"></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20px; float: left">10.</td>
                                            <td colspan="5" width="800px">
                                                <table width="100%">
                                                    <tr>
                                                        <td style="text-align: justify">
                                                            Perpajakan<br>
                                                            Penyedia Jasa harus mengetahui, memahami dan patuh terhadap
                                                            semua
                                                            peraturan perundang-undangan tentang pajak yang berlaku di
                                                            Indonesia dan
                                                            sudah diperhitungkan dalam Nilai Pekerjaan sebagaimana
                                                            termaksud dalam
                                                            angka 7 (tujuh) Perjanjian.
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" height="20px"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20px; float: left">11.</td>
                                            <td colspan="5" width="800px">
                                                <table width="100%">
                                                    <tr>
                                                        <td style="text-align: justify">
                                                            Jangka Waktu Pengadaan<br>
                                                            Penyedia Barang dan/atau Jasa harus melaksanakan,
                                                            menyelesaikan dan
                                                            memperbaiki Pengadaan sesuai dengan SPK ini dan lampirannya.
                                                            Waktu
                                                            penyelesaian Pengadaan adalah selambat-lambatnya sampai
                                                            tanggal
                                                            {{ tanggal_indo($tglBatasWaktu) }}.
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" height="20px"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20px; float: left">12.</td>
                                            <td colspan="5" width="800px">
                                                <table width="100%">
                                                    <tr>
                                                        <td style="text-align: justify">
                                                            Penyelesaian Sengketa
                                                            <br>
                                                            <table style="margin-top: 10px" border="0">
                                                                <tr>
                                                                    <td style="float: left; text-align: center; width: 30px">
                                                                        a.
                                                                    </td>
                                                                    <td colspan="4">
                                                                        Dalam hal terjadi perselisihan, baik yang
                                                                        bersifat teknis
                                                                        maupun non teknis mengenai isi maupun Pekerjaan
                                                                        SPK ini,
                                                                        maka Pengguna Barang dan/atau Jasa dan Penyedia
                                                                        Barang
                                                                        dan/atau Jasa sepakat menyelesaikannya secara
                                                                        musyawarah
                                                                        mufakat.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="float: left; text-align: center; width: 30px">
                                                                        b.
                                                                    </td>
                                                                    <td colspan="4">
                                                                        Seluruh perselisihan yang timbul dari SPK ini
                                                                        yang tidak
                                                                        dapat diselesaikan secara musyawarah mufakat
                                                                        akan
                                                                        diselesaikan melalui Kepaniteraan Pengadilan
                                                                        Negeri
                                                                        {{ ucwords($data->nama_pengadilan) }}.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" height="20px"></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20px; float: left">14.</td>
                                            <td colspan="5" width="800px">
                                                <table width="100%">
                                                    <tr>
                                                        <td style="text-align: justify">
                                                            Laporan Pengadaan<br>
                                                            Dalam Pekerjaan Pengadaan, Penyedia Barang dan/atau Jasa
                                                            wajib
                                                            melaporkan perkembangan dan Pekerjaan Pengadaan apabila
                                                            diminta
                                                            sewaktu-waktu oleh Pengguna Barang dan/atau Jasa.
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" height="20px"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20px; float: left">15.</td>
                                            <td colspan="5" width="800px">
                                                <table width="100%">
                                                    <tr>
                                                        <td style="text-align: justify">
                                                            Pengalihan<br>
                                                            Penyedia Barang dan/atau Jasa dilarang mengalihkan atau
                                                            mentransfer
                                                            sebagian atau seluruh SPK ini kepada pihak ketiga manapun
                                                            tanpa
                                                            persetujuan tertulis dari Pengguna Barang dan/atau Jasa.
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" height="20px"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20px; float: left">16.</td>
                                            <td colspan="5" width="800px">
                                                <table width="100%">
                                                    <tr>
                                                        <td style="text-align: justify">
                                                            Pengakhiran SPK
                                                            <br>
                                                            <table style="margin-top: 10px" border="0">
                                                                <tr>
                                                                    <td style="float: left; text-align: center; width: 30px">
                                                                        a.
                                                                    </td>
                                                                    <td colspan="4">
                                                                        SPK ini dapat diakhiri oleh Pengguna Barang
                                                                        dan/atau Jasa
                                                                        atas setiap pelanggaran yang dilakukan oleh
                                                                        Penyedia Barang
                                                                        dan/atau Jasa dalam hal Penyedia Barang dan/atau
                                                                        Jasa
                                                                        menolak atau gagal dalam melaksanakan setiap
                                                                        ketentuan SPK
                                                                        ini dan tidak melakukan upaya pemulihan atas
                                                                        kegagalan
                                                                        tersebut dalam waktu 3 (tiga) hari kerja setelah
                                                                        pemberitahuan dari Pengguna Barang dan/atau Jasa
                                                                        atas
                                                                        pelanggaran yang terjadi.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="float: left; text-align: center; width: 30px">
                                                                        b.
                                                                    </td>
                                                                    <td colspan="4">
                                                                        Dalam hal sebagaimana tersebut dalam ketentuan
                                                                        angka 16
                                                                        huruf a di atas, Pengguna Barang dan/atau Jasa
                                                                        berhak untuk
                                                                        mengakhiri SPK ini dengan pemberitahuan secara
                                                                        tertulis
                                                                        kepada Penyedia Barang dan/atau Jasa selambatnya
                                                                        dalam waktu
                                                                        3 (tiga) hari kerja sebelum tanggal pengakhiran.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="float: left; text-align: center; width: 30px">
                                                                        c.
                                                                    </td>
                                                                    <td colspan="4">
                                                                        Dalam hal pengakhiran sebagaimana dimaksud
                                                                        disini atau
                                                                        ditentukan lainnya, Pengguna Barang dan/atau
                                                                        Jasa dan
                                                                        Penyedia Barang dan/atau Jasa dengan ini
                                                                        mengenyampingkan
                                                                        ketentuan Pasal 1266 dan 1267 Kitab
                                                                        Undang-Undang Hukum
                                                                        Perdata.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="float: left; text-align: center; width: 30px">
                                                                        d.
                                                                    </td>
                                                                    <td colspan="4">
                                                                        Dalam hal Penyedia Barang dan/atau Jasa
                                                                        melakukan cidera
                                                                        janji atau tidak mampu memenuhi kewajibannya
                                                                        untuk
                                                                        melaksanakan Pekerjaan Pengadaan sebagaimana
                                                                        diatur dalam
                                                                        SPK ini dengan alasan yang tidak dapat diterima
                                                                        oleh
                                                                        Pengguna Barang dan/atau Jasa, maka Penyedia
                                                                        Barang dan/atau
                                                                        Jasa wajib untuk melakukan pengembalian atas
                                                                        seluruh biaya
                                                                        yang telah dikeluarkan dan/atau dibayarkan oleh
                                                                        Pengguna
                                                                        Barang dan/atau Jasa kepada Penyedia Barang
                                                                        dan/atau Jasa.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" height="20px"></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align: justify">
                                                Demikian SPK ini dibuat dalam rangkap 2 (dua) bermeterai cukup,
                                                masing-masing
                                                mempunyai kekuatan hukum yang sama dengan ditandatangani oleh wakil yang
                                                berwenang
                                                dari Para Pihak pada tanggal sebagaimana tersebut diawal SPK ini.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" height="20px"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" height="20px"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <table border="0" width="100%">
                                                    <tr style="text-align: center">
                                                        <td width="50%"><b>PENYEDIA BARANG DAN/ATAU JASA</b></td>
                                                        <td><b>PENGGUNA JASA</b></td>
                                                    </tr>
                                                    <tr style="text-align: center">
                                                        <td>{{ ucwords($data->perusahaan) }}
                                                            <br>{{ ucwords($data->jabatan) }}</td>
                                                        <td>PT Perusahaan Gas Negara Tbk<br>{{ $data->jabatan_pejabat }}
                                                        </td>
                                                    </tr>
                                                    <tr style="text-align: center">
                                                        <td height="170px">&nbsp;</td>
                                                        <td height="170px">&nbsp;</td>
                                                    </tr>
                                                    <tr style="text-align: center">
                                                        <td><b>{{ $data->nama }}</b></td>
                                                        <td><b>{{ ucwords($data->nama_pejabat) }}</b></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" height="20px"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" height="20px"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td style="height: 0px"></td>
                            </tr>
                        </table>
                        <br>
        </div>
    </center>
</div>
</body>
</html>