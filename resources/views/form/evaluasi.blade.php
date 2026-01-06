<!DOCTYPE html>
<html lang="en">

<head>
    <title>Form Evaluasi</title>
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

<body style="margin: 0; padding: 0;">
    <div class="container-fluid">
        <center>
            <div style="width:1000px; height:100%; background-color:white;"><br>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" height="100%"
                    class="font">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding: 10px 0 10px 0" align="center" width="200px">
                                        <img src="{{ asset('template/assets/images/logo-pertamina-gas-negara.png') }}"
                                            width="200px;">
                                    </td>
                                    <td align="center">
                                        <b class="font" style="font-size:18px;">FORMULIR VERIFIKASI DAN EVALUASI
                                            PROPOSAL</b><br>
                                        <b class="font" style="font-size:18px;">TANGGUNG JAWAB SOSIAL DAN
                                            LINGKUNGAN<br>
                                            <b class="font" style="font-size:16px;">DIVISI CORPORATE SOCIAL
                                                RESPONSIBILITY</b>
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
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" colspan="2" height="100%"><br>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="width: 350px">&nbsp;Nomor Agenda</td>
                                                <td style="width: 5px; padding-right: 2px">:</td>
                                                <td>{{ $data->no_agenda }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="width: 350px">&nbsp;Tanggal Penerimaan</td>
                                                <td style="width: 5px; padding-right: 2px">:</td>
                                                <td>{{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($data->tgl_terima))) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="width: 350px">&nbsp;Sifat Proposal</td>
                                                <td style="width: 5px; padding-right: 2px">:</td>
                                                <td>{{ $data->sifat }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="width: 350px">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px">1.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Data Permohonan</td>
                                                <td style="width: 5px">&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px; vertical-align: top">Surat / Proposal
                                                    Dari
                                                </td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td style="vertical-align: top">{{ $data->asal_surat }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px; vertical-align: top">Nomor Surat /
                                                    Tanggal
                                                </td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td style="vertical-align: top">{{ $data->no_surat }}
                                                    /
                                                    {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($data->tgl_surat))) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px; vertical-align: top">Perihal</td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td style="vertical-align: top">{{ $data->bantuan_untuk }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px; vertical-align: top">Alamat Proposal
                                                </td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td style="vertical-align: top">{{ $data->alamat }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Nama Yang Mengajukan</td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td>{{ $data->pengaju_proposal }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Bertindak Sebagai</td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td>{{ $data->sebagai }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Contact Person</td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td>{{ $data->contact_person }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="2px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px">2.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Besarnya Permohonan</td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td>{{ 'Rp. ' . number_format($data->nilai_pengajuan, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="2px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px">3.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Akan Digunakan Untuk</td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td>{{ $data->deskripsi }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="2px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px">4.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Rencana Anggaran Biaya</td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td>
                                                    @if ($data->rencana_anggaran == 'ADA')
                                                        ADA /
                                                        <strike>TIDAK ADA</strike>
                                                    @elseif($data->rencana_anggaran == 'TIDAK ADA')
                                                        <strike>ADA</strike> /
                                                        TIDAK ADA
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="2px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px">5.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Foto-Foto / Dokumen</td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td>
                                                    @if ($data->dokumen == 'ADA')
                                                        ADA /
                                                        <strike>TIDAK ADA</strike>
                                                    @elseif($data->dokumen == 'TIDAK ADA')
                                                        <strike>ADA</strike> / TIDAK ADA
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="2px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px">6.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Denah Lokasi Permohonan</td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td>
                                                    @if ($data->denah == 'ADA')
                                                        ADA /
                                                        <strike>TIDAK
                                                            ADA</strike>
                                                    @elseif($data->denah == 'TIDAK ADA')
                                                        <strike>ADA</strike>
                                                        / TIDAK ADA
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="2px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px">7.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Perkiraan Dana Yang Dapat Dibantu</td>
                                                <td style="width: 5px; padding-right: 2px; vertical-align: top">:</td>
                                                <td>{{ 'Rp. ' . number_format($data->nilai_bantuan, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                {{--                            <tr> --}}
                                {{--                                <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td> --}}
                                {{--                                <td colspan="4"> --}}
                                {{--                                    <table width="100%"> --}}
                                {{--                                        <tr> --}}
                                {{--                                            <td height="2px"></td> --}}
                                {{--                                        </tr> --}}
                                {{--                                    </table> --}}
                                {{--                                </td> --}}
                                {{--                            </tr> --}}
                                {{--                            <tr> --}}
                                {{--                                <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px">8.</td> --}}
                                {{--                                <td colspan="4"> --}}
                                {{--                                    <table width="100%"> --}}
                                {{--                                        <tr> --}}
                                {{--                                            <td style="width: 300px">Ruang Lingkup Bantuan</td> --}}
                                {{--                                            <td style="width: 5px">&nbsp;</td> --}}
                                {{--                                            <td>&nbsp;</td> --}}
                                {{--                                        </tr> --}}
                                {{--                                    </table> --}}
                                {{--                                </td> --}}
                                {{--                            </tr> --}}
                                {{--                            <tr> --}}
                                {{--                                <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td> --}}
                                {{--                                <td colspan="4"> --}}
                                {{--                                    <table width="100%"> --}}
                                {{--                                        <tr> --}}
                                {{--                                            <td style="width: 300px"> --}}
                                {{--                                                @if ($data->sektor_bantuan == 'Bencana Alam dan Bencana Non Alam Termasuk Yang Disebabkan Oleh Wabah') --}}
                                {{--                                                    <i class="fa fa-check-square-o"></i>&nbsp;Bencana Alam dan Bencana Non Alam Termasuk Yang Disebabkan Oleh Wabah --}}
                                {{--                                                @else --}}
                                {{--                                                    <i class="fa fa-square-o"></i>&nbsp;Bencana Alam dan Bencana Non Alam Termasuk Yang Disebabkan Oleh Wabah --}}
                                {{--                                                @endif --}}
                                {{--                                            </td> --}}
                                {{--                                            <td style="width: 5px"></td> --}}
                                {{--                                            <td style="width: 300px"> --}}
                                {{--                                                @if ($data->sektor_bantuan == 'Sarana Ibadah') --}}
                                {{--                                                    <i class="fa fa-check-square-o"></i>&nbsp;Sarana Ibadah --}}
                                {{--                                                @else --}}
                                {{--                                                    <i class="fa fa-square-o"></i>&nbsp;Sarana Ibadah --}}
                                {{--                                                @endif --}}
                                {{--                                            </td> --}}
                                {{--                                        </tr> --}}
                                {{--                                    </table> --}}
                                {{--                                </td> --}}
                                {{--                            </tr> --}}
                                {{--                            <tr> --}}
                                {{--                                <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td> --}}
                                {{--                                <td colspan="4"> --}}
                                {{--                                    <table width="100%"> --}}
                                {{--                                        <tr> --}}
                                {{--                                            <td style="width: 300px"> --}}
                                {{--                                                @if ($data->sektor_bantuan == 'Pendidikan dan Pelatihan') --}}
                                {{--                                                    <i class="fa fa-check-square-o"></i>&nbsp;Pendidikan dan Pelatihan --}}
                                {{--                                                @else --}}
                                {{--                                                    <i class="fa fa-square-o"></i>&nbsp;Pendidikan dan/atau Pelatihan --}}
                                {{--                                                @endif --}}
                                {{--                                            </td> --}}
                                {{--                                            <td style="width: 5px"></td> --}}
                                {{--                                            <td style="width: 300px"> --}}
                                {{--                                                @if ($data->sektor_bantuan == 'Pelestarian Alam') --}}
                                {{--                                                    <i class="fa fa-check-square-o"></i>&nbsp;Pelestarian Alam --}}
                                {{--                                                @else --}}
                                {{--                                                    <i class="fa fa-square-o"></i>&nbsp;Pelestarian Alam --}}
                                {{--                                                @endif --}}
                                {{--                                            </td> --}}
                                {{--                                        </tr> --}}
                                {{--                                    </table> --}}
                                {{--                                </td> --}}
                                {{--                            </tr> --}}
                                {{--                            <tr> --}}
                                {{--                                <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td> --}}
                                {{--                                <td colspan="4"> --}}
                                {{--                                    <table width="100%"> --}}
                                {{--                                        <tr> --}}
                                {{--                                            <td style="width: 300px"> --}}
                                {{--                                                @if ($data->sektor_bantuan == 'Peningkatan Kesehatan') --}}
                                {{--                                                    <i class="fa fa-check-square-o"></i>&nbsp;Peningkatan Kesehatan --}}
                                {{--                                                @else --}}
                                {{--                                                    <i class="fa fa-square-o"></i>&nbsp;Peningkatan Kesehatan --}}
                                {{--                                                @endif --}}
                                {{--                                            </td> --}}
                                {{--                                            <td style="width: 5px"></td> --}}
                                {{--                                            <td style="width: 300px"> --}}
                                {{--                                                @if ($data->sektor_bantuan == 'Pengentasan Kemiskinan') --}}
                                {{--                                                    <i class="fa fa-check-square-o"></i>&nbsp;Pengentasan Kemiskinan --}}
                                {{--                                                @else --}}
                                {{--                                                    <i class="fa fa-square-o"></i>&nbsp;Pengentasan Kemiskinan --}}
                                {{--                                                @endif --}}
                                {{--                                            </td> --}}
                                {{--                                        </tr> --}}
                                {{--                                    </table> --}}
                                {{--                                </td> --}}
                                {{--                            </tr> --}}
                                {{--                            <tr> --}}
                                {{--                                <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td> --}}
                                {{--                                <td colspan="4"> --}}
                                {{--                                    <table width="100%"> --}}
                                {{--                                        <tr> --}}
                                {{--                                            <td style="width: 300px"> --}}
                                {{--                                                @if ($data->sektor_bantuan == 'Prasarana dan Sarana Umum') --}}
                                {{--                                                    <i class="fa fa-check-square-o"></i>&nbsp;Prasarana dan Sarana Umum --}}
                                {{--                                                @else --}}
                                {{--                                                    <i class="fa fa-square-o"></i>&nbsp;Prasarana dan Sarana Umum --}}
                                {{--                                                @endif --}}
                                {{--                                            </td> --}}
                                {{--                                            <td style="width: 5px"></td> --}}
                                {{--                                            <td style="width: 300px"> --}}
                                {{--                                                @if ($data->sektor_bantuan == 'Pemberdayaan Ekonomi') --}}
                                {{--                                                    <i class="fa fa-check-square-o"></i>&nbsp;Pemberdayaan Ekonomi --}}
                                {{--                                                @else --}}
                                {{--                                                    <i class="fa fa-square-o"></i>&nbsp;Pemberdayaan Ekonomi --}}
                                {{--                                                @endif --}}
                                {{--                                            </td> --}}
                                {{--                                        </tr> --}}
                                {{--                                    </table> --}}
                                {{--                                </td> --}}
                                {{--                            </tr> --}}
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="2px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px">8.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Kriteria / Kepentingan Perusahaan</td>
                                                <td style="width: 5px">&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <?php
                                                $data1 = DB::table('tbl_detail_kriteria')
                                                    ->select(DB::raw('count(*) as jumlah'))
                                                    ->where([['no_agenda', '=', $data->no_agenda], ['kriteria', '=', 'Wilayah Operasi PGN (Ring I / II / III)']])
                                                    ->first();
                                                ?>
                                                <td style="width: 300px">
                                                    @if ($data1->jumlah > 0)
                                                    <i class="fa fa-check-square-o"></i>@else<i
                                                            class="fa fa-square-o"></i>
                                                    @endif&nbsp;Wilayah
                                                    Operasi PGN (Ring I / II / III)
                                                </td>
                                                <td style="width: 5px"></td>
                                                <?php
                                                $data2 = DB::table('tbl_detail_kriteria')
                                                    ->select(DB::raw('count(*) as jumlah'))
                                                    ->where([['no_agenda', '=', $data->no_agenda], ['kriteria', '=', 'Brand images/citra perusahaan']])
                                                    ->first();
                                                ?>
                                                <td style="width: 300px">
                                                    @if ($data2->jumlah > 0)
                                                    <i class="fa fa-check-square-o"></i>@else<i
                                                            class="fa fa-square-o"></i>
                                                    @endif Brand
                                                    images/citra perusahaan
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <?php
                                                $data3 = DB::table('tbl_detail_kriteria')
                                                    ->select(DB::raw('count(*) as jumlah'))
                                                    ->where([['no_agenda', '=', $data->no_agenda], ['kriteria', '=', 'Kelancaran Operasional/asset PGN']])
                                                    ->first();
                                                ?>
                                                <td style="width: 300px">
                                                    @if ($data3->jumlah > 0)
                                                    <i class="fa fa-check-square-o"></i>@else<i
                                                            class="fa fa-square-o"></i>
                                                    @endif&nbsp;Kelancaran
                                                    Operasional/asset PGN
                                                </td>
                                                <td style="width: 5px"></td>
                                                <?php
                                                $data4 = DB::table('tbl_detail_kriteria')
                                                    ->select(DB::raw('count(*) as jumlah'))
                                                    ->where([['no_agenda', '=', $data->no_agenda], ['kriteria', '=', 'Pengembangan wilayah usaha']])
                                                    ->first();
                                                ?>
                                                <td style="width: 300px">
                                                    @if ($data4->jumlah > 0)
                                                    <i class="fa fa-check-square-o"></i>@else<i
                                                            class="fa fa-square-o"></i>
                                                    @endif&nbsp;Pengembangan
                                                    wilayah usaha
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <?php
                                                $data5 = DB::table('tbl_detail_kriteria')
                                                    ->select(DB::raw('count(*) as jumlah'))
                                                    ->where([['no_agenda', '=', $data->no_agenda], ['kriteria', '=', 'Menjaga hubungan baik shareholders/stakeholders']])
                                                    ->first();
                                                ?>
                                                <td style="width: 300px">
                                                    @if ($data5->jumlah > 0)
                                                    <i class="fa fa-check-square-o"></i>@else<i
                                                            class="fa fa-square-o"></i>
                                                    @endif&nbsp;Menjaga
                                                    hubungan baik shareholders/stakeholders
                                                </td>
                                                <td style="width: 5px"></td>
                                                <td style="width: 300px"><i class="fa fa-square-o"></i>&nbsp;Lainnya :
                                                    .......................................
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="2px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 3px 0 3px 0 ;text-align: center; width: 50px; vertical-align: top">
                                        9.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td rowspan="3" style="width: 300px; vertical-align: top">Dokumen
                                                    legalitas (berupa Akta pendirian lembaga atau dokumen legalitas
                                                    lainnya yang disahkan oleh pejabat yang berwenang)</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 150px">
                                                    <i class="fa fa-check-square-o"></i>&nbsp;Ada
                                                </td>
                                                <td style="width: 350px">
                                                    <i class="fa fa-square-o"></i>&nbsp;Tidak Ada
                                                </td>
                                                <td style="width: 500px">&nbsp;
                                                    &nbsp;
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="2px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px">10.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Memenuhi Syarat Untuk</td>
                                                <td style="width: 5px">&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 150px">
                                                    @if ($data->syarat == 'Survei')
                                                        <i class="fa fa-check-square-o"></i>&nbsp;Survei/Konfirmasi
                                                    @else
                                                        <i class="fa fa-square-o"></i>&nbsp;Survei/Konfirmasi
                                                    @endif
                                                </td>
                                                {{--                                            <td style="width: 150px"> --}}
                                                {{--                                                @if ($data->syarat == 'Konfirmasi') --}}
                                                {{--                                                    <i class="fa fa-check-square-o"></i>&nbsp;Konfirmasi --}}
                                                {{--                                                @else --}}
                                                {{--                                                    <i class="fa fa-square-o"></i>&nbsp;Konfirmasi --}}
                                                {{--                                                @endif --}}
                                                {{--                                            </td> --}}
                                                <td style="width: 350px">
                                                    @if ($data->syarat == 'Tidak Memenuhi Syarat')
                                                        <i class="fa fa-check-square-o"></i>&nbsp;Tidak Memenuhi Syarat
                                                    @else
                                                        <i class="fa fa-square-o"></i>&nbsp;Tidak Memenuhi Syarat
                                                    @endif
                                                </td>
                                                <td style="width: 500px">&nbsp;
                                                    &nbsp;
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="20px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="width: 350px" colspan="3">&nbsp;<b>Tanggal & Paraf
                                                        Kelayakan
                                                        Proposal :
                                                        @if (
                                                            $data->status == 'Approved 1' or
                                                                $data->status == 'Approved 2' or
                                                                $data->status == 'Approved 3' or
                                                                $data->status == 'Survei' or
                                                                $data->status == 'Create Survei')
                                                            {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($data->approve_date))) }}
                                                    </b></td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="2px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 50%; text-align:center">
                                                    <table width="100%" rules="all" border="1">
                                                        <tr>
                                                            <td style="width: 50%">Evaluator 1</td>
                                                            <td style="width: 50%">Evaluator 2</td>
                                                        </tr>
                                                        <tr>
                                                            <td height="50px" style="text-align:center">
                                                                <img src="{{ asset('sign/' . $data->evaluator1 . '.gif') }}"
                                                                    width="100px">
                                                            </td>
                                                            <td height="50px">
                                                                @if (in_array($data->status, [
                                                                        'Approved 2',
                                                                        'Approved 3',
                                                                        'Survei',
                                                                        'Create Survei',
                                                                        'Approved Sekper',
                                                                        'Approved Dirut',
                                                                    ]))
                                                                    <img src="{{ asset('sign/' . $data->evaluator2 . '.gif') }}"
                                                                        width="100px">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                $evaluator1 = DB::table('tbl_user')->where('username', $data->evaluator1)->first();
                                                                ?>
                                                                {{ $evaluator1->nama }}<br>
                                                                <small>{{ date('d-m-Y', strtotime($data->create_date)) }}</small>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $evaluator2 = DB::table('tbl_user')->where('username', $data->evaluator2)->first();
                                                                ?>
                                                                {{ $evaluator2->nama }}<br>
                                                                <small>{{ date('d-m-Y', strtotime($data->approve_date)) }}</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="width: 50%; vertical-align: top; padding-left: 10px">
                                                    <b>Catatan :</b>
                                                    <br>
                                                    {{ $data->catatan1 }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="10px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="width: 350px">&nbsp;<b>TINDAK LANJUT</b></td>
                                                <td style="width: 5px"><span style="margin-left:2px"></span></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="2px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" rules="all" border="1">
                                            <tr>
                                                <td style="width: 300px; padding: 3px 3px 3px 3px ">TAHAP 1
                                                    (Rekomendasi
                                                    /usulan dari Departement Head Operational)
                                                </td>
                                                <td style="width: 120px; padding: 3px 3px 3px 3px; text-align:center">
                                                    Department Head
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="5px"
                                                    style="width: 5px; padding: 3px 3px 3px 3px; vertical-align: top"
                                                    rowspan="2">
                                                    {{ $data->ket_kadin1 }}
                                                </td>
                                                <td height="80px"
                                                    style="width: 5px; padding: 3px 0 3px 0; text-align:center">
                                                    @if (in_array($data->status, [
                                                            'Approved 2',
                                                            'Approved 3',
                                                            'Survei',
                                                            'Create Survei',
                                                            'Approved Sekper',
                                                            'Approved Dirut',
                                                        ]))
                                                        <img src="{{ asset('sign/' . $data->kadep . '.gif') }}"
                                                            width="100px">
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 5px; padding: 3px 0 3px 0; text-align:center">
                                                    <?php
                                                    $kadep = DB::table('tbl_user')->where('username', $data->kadep)->first();
                                                    ?>
                                                    {{ $kadep->nama }}
                                                    <br>
                                                    <small>{{ $data->approve_kadep ? \Carbon\Carbon::parse($data->approve_kadep)->format('d-m-Y') : '' }}</small>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="20px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" rules="all" border="1">
                                            <tr>
                                                <td style="width: 300px; padding: 3px 3px 3px 3px ">TAHAP 2 (Disposisi
                                                    dari
                                                    Division Head CSR)
                                                </td>
                                                <td style="width: 120px; padding: 3px 3px 3px 3px; text-align:center">
                                                    Division Head
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="5px"
                                                    style="width: 5px; padding: 3px 3px 3px 3px; vertical-align: top"
                                                    rowspan="2">
                                                    {{ $data->ket_kadiv }}
                                                </td>
                                                <td height="80px"
                                                    style="width: 5px; padding: 3px 0 3px 0; text-align:center">
                                                    @if (in_array($data->status, ['Survei', 'Create Survei', 'Approved Sekper', 'Approved Dirut']))
                                                        <img src="{{ asset('sign/' . $data->kadiv . '.gif') }}"
                                                            width="100px">
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 5px; padding: 3px 0 3px 0; text-align:center">
                                                    <?php
                                                    $kadiv = DB::table('tbl_user')->where('username', $data->kadiv)->first();
                                                    ?>
                                                    {{ $kadiv->nama }}
                                                    <br>
                                                    <small>{{ $data->approve_kadiv ? \Carbon\Carbon::parse($data->approve_kadiv)->format('d-m-Y') : '' }}</small>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td height="20px"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @if ($data->nilai_bantuan > 500000000)
                                    <tr>
                                        <td colspan="5">
                                            <table width="100%" rules="all" border="1">
                                                <tr>
                                                    <td style="width: 300px; padding: 3px 3px 3px 3px ">TAHAP 3
                                                        (Disposisi
                                                        dari
                                                        Corporate Secretary)
                                                    </td>
                                                    <td
                                                        style="width: 120px; padding: 3px 3px 3px 3px; text-align:center">
                                                        Corporate Secretary
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="5px"
                                                        style="width: 5px; padding: 3px 3px 3px 3px; vertical-align: top"
                                                        rowspan="2">
                                                        {{ $data->ket_sekper }}
                                                    </td>
                                                    <td height="80px"
                                                        style="width: 5px; padding: 3px 0 3px 0; text-align:center">
                                                        @if (in_array($data->status, ['Approved Sekper', 'Approved Dirut']))
                                                            <img src="{{ asset('sign/' . $data->sekper . '.gif') }}"
                                                                width="100px">
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 5px; padding: 3px 0 3px 0; text-align:center">
                                                        @php
                                                            $sekper = DB::table('tbl_user')
                                                                ->where('username', $data->sekper)
                                                                ->first();
                                                        @endphp
                                                        {{ $sekper->nama }}
                                                        <br>
                                                        <small>{{ $data->approve_sekper ? \Carbon\Carbon::parse($data->approve_sekper)->format('d-m-Y') : '' }}</small>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                @endif
                                @if ($data->nilai_bantuan > 2000000000)
                                    <tr>
                                        <td colspan="5">
                                            <table width="100%" rules="all" border="1">
                                                <tr>
                                                    <td style="width: 300px; padding: 3px 3px 3px 3px ">TAHAP 4
                                                        (Disposisi
                                                        dari
                                                        Direktur Utama)
                                                    </td>
                                                    <td
                                                        style="width: 120px; padding: 3px 3px 3px 3px; text-align:center">
                                                        Direktur Utama
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="5px"
                                                        style="width: 5px; padding: 3px 3px 3px 3px; vertical-align: top"
                                                        rowspan="2">
                                                        {{ $data->ket_dirut }}
                                                    </td>
                                                    <td height="80px"
                                                        style="width: 5px; padding: 3px 0 3px 0; text-align:center">
                                                        @if (in_array($data->status, ['Approved Sekper', 'Approved Dirut']))
                                                            <img src="{{ asset('sign/' . $data->dirut . '.gif') }}"
                                                                width="100px">
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 5px; padding: 3px 0 3px 0; text-align:center">
                                                        <?php
                                                        $dirut = DB::table('tbl_user')->where('username', $data->dirut)->first();
                                                        ?>
                                                        {{ $dirut->nama }}
                                                        <br>
                                                        <small>{{ date('d-m-Y', strtotime($data->approve_dirut)) }}</small>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </td>
                </table>
                <br>
            </div>
        </center>
    </div>
</body>

</html>
