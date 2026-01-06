<!DOCTYPE html>
<html lang="en">

<head>
    <title>Form Survei</title>
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
                                                <td style="width: 300px; vertical-align: top">&bull; Surat / Proposal
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
                                                <td style="width: 300px; vertical-align: top">&bull; Nomor Surat /
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
                                                <td style="width: 300px; vertical-align: top">&bull; Perihal</td>
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
                                                <td style="width: 300px; vertical-align: top">&bull; Alamat Proposal
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
                                                <td style="width: 300px">&bull; Nama Yang Mengajukan</td>
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
                                                <td style="width: 300px">&bull; Bertindak Sebagai</td>
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
                                                <td style="width: 300px">&bull; Contact Person</td>
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
                                                        ADA / <strike>TIDAK ADA</strike>
                                                    @elseif($data->rencana_anggaran == 'TIDAK ADA')
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
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">HASIL SURVEI PERTAMA</td>
                                                <td style="width: 5px">:</td>
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
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <table width="100%" rules="all" border="1">
                                                        <tr>
                                                            <td height="60px" style="padding: 3px 10px 3px 10px ;">
                                                                {{ $data->hasil_survei }}</td>
                                                        </tr>
                                                    </table>
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
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">HASIL SURVEI KEDUA</td>
                                                <td style="width: 5px">:</td>
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
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <table width="100%" rules="all" border="1">
                                                        <tr>
                                                            <td height="60px" style="padding: 3px 10px 3px 10px ;">
                                                                {{ $data->hasil_konfirmasi }}</td>
                                                        </tr>
                                                    </table>
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
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Usulan / Rekomendasi</td>
                                                <td style="width: 5px">:</td>
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
                                                <td>
                                                    @if ($data->usulan == 'Disarankan')
                                                        (Disarankan / <strike>Dipertimbangkan</strike> / <strike>Tidak
                                                            Memenuhi Kriteria</strike>) Untuk dibantu
                                                    @elseif ($data->usulan == 'Dipertimbangkan')
                                                        (<strike>Disarankan</strike> / Dipertimbangkan / <strike>Tidak
                                                            Memenuhi Kriteria</strike>) Untuk dibantu
                                                    @elseif ($data->usulan == 'Tidak Memenuhi Kriteria')
                                                        (<strike>Disarankan</strike> / <strike>Dipertimbangkan</strike>
                                                        /
                                                        Tidak Memenuhi Kriteria) Untuk dibantu
                                                    @else
                                                        (Disarankan / Dipertimbangkan / Tidak Memenuhi Kriteria)
                                                        Untuk dibantu
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
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Bantuan Berupa</td>
                                                <td style="width: 5px">:</td>
                                                @if ($data->bantuan_berupa == 'Dana')
                                                    <td>&nbsp;<i
                                                            class="fa fa-check-square-o"></i>&nbsp;Dana&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                            class="fa fa-square-o"></i>&nbsp;Barang
                                                    </td>
                                                @elseif ($data->bantuan_berupa == 'Barang')
                                                    <td><i
                                                            class="fa fa-square-o"></i>&nbsp;Dana&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                            class="fa fa-check-square-o"></i>&nbsp;Barang
                                                    </td>
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
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Nilai Bantuan</td>
                                                <td style="width: 5px">:</td>
                                                <td>
                                                    &nbsp;{{ 'Rp. ' . number_format($data->nilai_bantuan, 0, ',', '.') }}
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
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px">Jumlah Termin Pembayaran</td>
                                                <td style="width: 5px">:</td>
                                                <td>&nbsp;{{ $data->termin }}</td>
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
                                        <table width="100%">
                                            <tr>
                                                <td style="width: 300px; text-align:center">
                                                    <table width="100%" rules="all" border="1">
                                                        <tr>
                                                            <td>Surveyor 1</td>
                                                            <td>Surveyor 2</td>
                                                        </tr>
                                                        <tr>
                                                            <td height="50px" style="text-align:center">
                                                                <img src="{{ asset('sign/' . $data->survei1 . '.gif') }}"
                                                                    width="100px">
                                                            </td>
                                                            <td height="50px">
                                                                @if (in_array($data->status, ['Approved 1', 'Approved 2', 'Approved 3', 'Survei', 'Approved Sekper', 'Approved Dirut']))
                                                                    <img src="{{ asset('sign/' . $data->survei2 . '.gif') }}"
                                                                        width="100px">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                $survei1 = DB::table('tbl_user')->select('tbl_user.*')->where('username', $data->survei1)->first();
                                                                ?>
                                                                {{ $survei1->nama }}
                                                                <br>
                                                                <small>{{ date('d-m-Y', strtotime($data->create_date)) }}</small>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $survei2 = DB::table('tbl_user')->select('tbl_user.*')->where('username', $data->survei2)->first();
                                                                ?>
                                                                {{ $survei2->nama }}
                                                                <br>
                                                                <small>{{ date('d-m-Y', strtotime($data->approve_date)) }}</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="width: 300px; text-align:center">&nbsp;</td>
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
                                                    Departement Head
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
                                                    @if (in_array($data->status, ['Approved 2', 'Approved 3', 'Survei', 'Approved Sekper', 'Approved Dirut']))
                                                        <img src="{{ asset('sign/' . $data->kadep . '.gif') }}"
                                                            width="100px">
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 5px; padding: 3px 0 3px 0; text-align:center">
                                                    <?php
                                                    $kadep = DB::table('tbl_user')->select('tbl_user.*')->where('username', $data->kadep)->first();
                                                    ?>
                                                    {{ $kadep->nama }}
                                                    @if (in_array($data->status, ['Approved 2', 'Approved 3', 'Survei', 'Approved Sekper', 'Approved Dirut']))
                                                        <br>
                                                        <small>{{ date('d-m-Y', strtotime($data->approve_kadep)) }}</small>
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
                                                    @if (in_array($data->status, ['Approved 3', 'Survei', 'Approved Sekper', 'Approved Dirut']))
                                                        <img src="{{ asset('sign/' . $data->kadiv . '.gif') }}"
                                                            width="100px">
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 5px; padding: 3px 0 3px 0; text-align:center">
                                                    <?php
                                                    $kadiv = DB::table('tbl_user')->select('tbl_user.*')->where('username', $data->kadiv)->first();
                                                    ?>
                                                    {{ $kadiv->nama }}
                                                    @if (in_array($data->status, ['Approved 3', 'Survei', 'Approved Sekper', 'Approved Dirut']))
                                                        <br>
                                                        <small>{{ date('d-m-Y', strtotime($data->approve_kadiv)) }}</small>
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
