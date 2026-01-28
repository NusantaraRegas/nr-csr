@php
    $tanggal = App\Helper\terbilang::terbilang(date('d', strtotime($data->tgl_bast)));
    $tahun = App\Helper\terbilang::terbilang(date('Y', strtotime($data->tgl_bast)));
    $termin = App\Helper\terbilang::terbilang($data->termin);
    $persen1 = App\Helper\terbilang::terbilang($data->persen1);
    $persen2 = App\Helper\terbilang::terbilang($data->persen2);
    $persen3 = App\Helper\terbilang::terbilang($data->persen3);
    $persen4 = App\Helper\terbilang::terbilang($data->persen4);
    $rupiah1 = App\Helper\terbilang::terbilang($data->rupiah1);
    $rupiah2 = App\Helper\terbilang::terbilang($data->rupiah2);
    $rupiah3 = App\Helper\terbilang::terbilang($data->rupiah3);
    $rupiah4 = App\Helper\terbilang::terbilang($data->rupiah4);

    $jumlahBarang = App\Helper\terbilang::terbilang($data->jumlah_barang);
    $terbilang = App\Helper\terbilang::terbilang($data->nilai_approved, 3);

    $approver = App\Models\User::where('id_user', $data->approver_id)->first();

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Berita Acara Serah Terima</title>
    <link rel="icon" type="image/png" href="{{ asset('template/assets/images/logoicon.png') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .font {
            font-family: sans-serif
        }

        @media print {
            .cetak {
                display: none;
            }

            @page {
                size: A4;
                margin: 20mm;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0;" bgcolor="grey">
    <div class="container-fluid">
        <center>
            <div style="width:1000px; height:100%; background-color:white;"><br>
                <a href="javascript:void(0);" onclick="javascript:window.print();" class="cetak" title="Cetak Dokumen"
                    style="font-size: 20px; color: #3598DC; margin-right: -900px"><i class="fas fa-print"></i></a>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="90%" height="100%"
                    class="font">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding: 10px 0 80px 0" align="center" width="200px">
                                        <img src="{{ asset('template/assets/images/logo-pertamina-gas-negara.png') }}"
                                            width="200px;">
                                    </td>
                                    <td align="center">
                                        @if ($data->bantuan_berupa == 'Dana')
                                            <b class="font" style="font-size:18px;">BERITA ACARA SERAH TERIMA BANTUAN
                                                DANA</b><br>
                                        @else
                                            <b class="font" style="font-size:18px;">BERITA ACARA SERAH TERIMA BANTUAN
                                                BARANG</b><br>
                                        @endif
                                        <b class="font" style="font-size:18px;">PILAR
                                            {{ strtoupper($data->pilar) }}</b><br>
                                        <b class="font" style="font-size:18px;">BANTUAN
                                            {{ strtoupper($data->deskripsi) }}</b><br>
                                        <b class="font"
                                            style="font-size:18px;">{{ strtoupper($data->nama_lembaga) }}</b><br>
                                        <b class="font" style="font-size:18px;">{{ strtoupper($data->kabupaten) }}
                                            - {{ strtoupper($data->provinsi) }}</b><br>
                                        <br>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="width: 43%">Nomor PIHAK PERTAMA</td>
                                                <td style="width: 2%">:&nbsp;</td>
                                                <td style="width: 45%">{{ $data->no_bast_dana }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nomor PIHAK KEDUA</td>
                                                <td>:&nbsp;</td>
                                                <td>{{ $data->no_bast_pihak_kedua }}</td>
                                            </tr>
                                        </table>
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
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="text-align: justify">
                                                    Berita Acara Serah Terima Bantuan {{ $data->bantuan_berupa }} Dalam
                                                    Rangka {{ ucwords($data->deskripsi) }}
                                                    {{ ucwords($data->nama_lembaga) }}
                                                    Kabupaten/Kota {{ ucwords($data->kabupaten) }}
                                                    – {{ ucwords($data->provinsi) }}
                                                    (untuk selanjutnya
                                                    disebut “<b>BAST</b>”) ini dibuat di <b>Jakarta</b>, pada hari
                                                    <b>{{ \App\Helper\formatTanggal::nama_hari(date('Y-m-d', strtotime($data->tgl_bast))) }}</b>,
                                                    tanggal
                                                    <b>{{ ucwords($tanggal) }}</b>,
                                                    bulan
                                                    <b>{{ \App\Helper\formatTanggal::nama_bulan(date('Y-m-d', strtotime($data->tgl_bast))) }}</b>,
                                                    tahun
                                                    <b>{{ ucwords($tahun) }}</b>
                                                    (<b>{{ date('d - m - Y', strtotime($data->tgl_bast)) }}</b>), oleh
                                                    dan antara:
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"><b>I.</b></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td><b>PT Nusantara Regas,</b></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                @if ($data->no_pelimpahan == '-')
                                                    <td style="text-align: justify">
                                                        Berkedudukan dan berkantor pusat di Jalan
                                                        K.H Zainul Arifin No. 20, Jakarta 11140, dalam hal ini
                                                        diwakili
                                                        oleh
                                                        <b>{{ $approver->nama }}</b>, dalam
                                                        kedudukannya
                                                        sebagai
                                                        <b>{{ $approver->jabatan }}</b> berdasarkan
                                                        Petikan
                                                        Keputusan Direksi PT Nusantara Regas Nomor:
                                                        {{ $approver->no_sk }} tanggal
                                                        {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($approver->tgl_sk))) }},
                                                        dengan
                                                        demikian
                                                        berwenang bertindak untuk dan atas nama
                                                        PT Nusantara Regas, untuk selanjutnya disebut
                                                        sebagai
                                                        “<b>PIHAK
                                                            PERTAMA</b>”; dan
                                                    </td>
                                                @else
                                                    <td style="text-align: justify">
                                                        Berkedudukan dan berkantor pusat di Jalan
                                                        K.H Zainul Arifin No. 20, Jakarta 11140, dalam hal ini
                                                        diwakili
                                                        oleh
                                                        <b>{{ $approver->nama }}</b>, dalam
                                                        kedudukannya
                                                        sebagai
                                                        <b>{{ $approver->jabatan }}</b> berdasarkan
                                                        Petikan
                                                        Keputusan Direksi PT Nusantara Regas Nomor:
                                                        {{ $approver->no_sk }} tanggal
                                                        {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($approver->tgl_sk))) }},
                                                        dengan
                                                        demikian
                                                        berwenang bertindak untuk dan atas nama
                                                        PT Nusantara Regas, untuk selanjutnya disebut
                                                        sebagai
                                                        “<b>PIHAK
                                                            PERTAMA</b>”; dan
                                                    </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0 3px 0 ;text-align: center; width: 50px"><b>II.</b></td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td><b>{{ ucwords($data->nama_lembaga) }}</b>
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
                                                <td style="text-align: justify">
                                                    Berkedudukan di {{ ucwords($data->alamat) }}
                                                    Kabupaten/Kota {{ ucwords($data->kabupaten) }}
                                                    – {{ ucwords($data->provinsi) }} yang dalam hal ini diwakili
                                                    oleh <b>{{ ucwords($data->nama_pic) }}</b> dalam
                                                    kedudukannya selaku <b>{{ ucwords($data->jabatan) }}</b>,
                                                    berdasarkan proposal kegiatan, dengan demikian berwenang
                                                    bertindak untuk dan atas nama
                                                    tersebut diatas, untuk selanjutnya disebut sebagai “<b>PIHAK
                                                        KEDUA</b>”.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="text-align: justify">
                                                    Selanjutnya <b>PIHAK PERTAMA</b> dan <b>PIHAK KEDUA</b> secara
                                                    bersama-sama disebut sebagai <b>PARA PIHAK</b>, dan dalam
                                                    kedududukannya
                                                    tersebut diatas, terlebih dahulu menerangkan hal-hal sebagai
                                                    berikut:
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 50px; float: left">1.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="text-align: justify">
                                                    Bahwa, PIHAK PERTAMA adalah subholding gas PT Pertamina (Persero)
                                                    yang bergerak di bidang transmisi dan niaga gas bumi di Indonesia
                                                    dan
                                                    bermaksud untuk melaksanakan kewajiban Tanggung Jawab Sosial dan
                                                    Lingkungan (“Corporate Social Responsibility”) sebagaimana
                                                    diamanatkan
                                                    oleh Pasal 74 Undang-Undang Nomor 40 Tahun 2007 tentang Perseroan
                                                    Terbatas jo. Peraturan Pemerintah No. 72 Tahun 2016 tentang
                                                    Perubahan
                                                    Atas Peraturan Pemerintah Nomor 44 Tahun 2005 Tentang Tata Cara
                                                    Penyertaan dan Penatausahaan Modal Negara Pada Badan Usaha Milik
                                                    Negara
                                                    dan Perseroan Terbatas jo. Peraturan Menteri BUMN Nomor
                                                    PER-1/MBU/03/2023 Tentang Penugasan Khusus dan Program Tanggung
                                                    Jawab
                                                    Sosial dan Lingkungan Badan Usaha Milik Negara (untuk selanjutnya
                                                    disebut “Program Tanggung Jawab Sosial dan Lingkungan”);
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="float: left; text-align: center; width: 50px">2.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                @if ($data->bantuan_berupa == 'Dana')
                                                    <td style="text-align: justify">
                                                        Bahwa, PIHAK KEDUA telah mengajukan permohonan bantuan dana
                                                        kepada
                                                        PIHAK
                                                        PERTAMA melalui pengajuan proposal dan surat tertulis Nomor:
                                                        {{ strtoupper($data->no_surat) }}
                                                        Tanggal:
                                                        {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($data->tgl_surat))) }}
                                                        Perihal: {{ ucwords($data->bantuan_untuk) }}.
                                                    </td>
                                                @elseif($data->bantuan_berupa == 'Barang')
                                                    <td style="text-align: justify">
                                                        Bahwa, PIHAK KEDUA telah mengajukan permohonan bantuan kepada
                                                        PIHAK
                                                        PERTAMA melalui pengajuan proposal dan surat tertulis Nomor:
                                                        {{ strtoupper($data->no_surat) }}
                                                        Tanggal:
                                                        {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($data->tgl_surat))) }}
                                                        Perihal: {{ ucwords($data->bantuan_untuk) }}.
                                                    </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                @if ($data->bantuan_berupa == 'Dana')
                                                    <td style="text-align: justify">
                                                        Berdasarkan hal-hal tersebut diatas, PARA PIHAK sepakat untuk
                                                        memberi
                                                        dan menerima bantuan
                                                        untuk {{ ucwords($data->deskripsi) }}
                                                        {{ ucwords($data->nama_lembaga) }}
                                                        Kabupaten/Kota {{ ucwords($data->kabupaten) }}
                                                        – {{ ucwords($data->provinsi) }} (untuk
                                                        selanjutnya disebut "Kegiatan Bantuan") dengan ketentuan dan
                                                        syarat-syarat sebagai berikut:
                                                    </td>
                                                @elseif($data->bantuan_berupa == 'Barang')
                                                    <td style="text-align: justify">
                                                        Berdasarkan hal-hal tersebut diatas, PARA PIHAK sepakat untuk
                                                        memberi dan menerima bantuan berupa
                                                        bantuan {{ $data->jumlah_barang }}
                                                        ({{ strtolower($jumlahBarang) }})
                                                        {{ ucwords($data->satuan_barang) }}
                                                        {{ ucwords($data->nama_barang) }}
                                                        beserta
                                                        perlengkapannya (“untuk selanjutnya disebut
                                                        “{{ ucwords($data->nama_barang) }}”) dengan ketentuan dan
                                                        syarat-syarat
                                                        sebagai
                                                        berikut:
                                                    </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: center">
                                        <b>PASAL 1</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: center">
                                        <b>RUANG LINGKUP</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="float: left; text-align: center; width: 50px">1.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                @if ($data->bantuan_berupa == 'Dana')
                                                    <td style="text-align: justify">
                                                        PIHAK PERTAMA memberikan bantuan dalam bentuk dana untuk
                                                        pelaksanaan
                                                        Kegiatan Bantuan, sesuai dengan ketersediaan dana dari PIHAK
                                                        PERTAMA
                                                        kepada PIHAK KEDUA sebagai bentuk bagian dari Tanggung Jawab
                                                        Sosial
                                                        dan
                                                        Lingkungan PIHAK PERTAMA (untuk
                                                        selanjutnya disebut “Bantuan”).
                                                    </td>
                                                @elseif($data->bantuan_berupa == 'Barang')
                                                    <td style="text-align: justify">
                                                        PIHAK PERTAMA memberikan bantuan dalam bentuk barang
                                                        berupa {{ $data->jumlah_barang }}
                                                        ({{ strtolower($jumlahBarang) }})
                                                        {{ ucwords($data->satuan_barang) }}
                                                        {{ ucwords($data->nama_barang) }}
                                                        , sesuai dengan
                                                        ketersediaan dana dari PIHAK
                                                        PERTAMA kepada PIHAK KEDUA sebagai bentuk bagian dari Tanggung
                                                        Jawab
                                                        Sosial dan Lingkungan PIHAK PERTAMA (untuk selanjutnya disebut
                                                        “Bantuan”).
                                                    </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="float: left; text-align: center; width: 50px">2.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="text-align: justify">
                                                    PIHAK KEDUA bertindak dan bertanggungjawab sebagai pihak pengelola
                                                    dan pelaksana Kegiatan Bantuan yang diperlukan untuk mendukung
                                                    pelaksanaannya.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: center">
                                        <b>PASAL 2</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: center">
                                        <b>PELAKSANAAN</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="float: left; text-align: center; width: 50px">1.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                @if ($data->bantuan_berupa == 'Dana')
                                                    <td style="text-align: justify">
                                                        PIHAK PERTAMA memberikan Bantuan Dana kepada PIHAK KEDUA senilai
                                                        <b>Rp{{ number_format($data->nilai_approved, 2, ',', '.') }}
                                                            ({{ strtolower($terbilang) }} rupiah)</b> dan PIHAK KEDUA
                                                        menerima
                                                        dengan baik Bantuan Dana tersebut.
                                                    </td>
                                                @elseif($data->bantuan_berupa == 'Barang')
                                                    <td style="text-align: justify">
                                                        PIHAK PERTAMA memberikan Bantuan
                                                        Berupa {{ ucwords($data->nama_barang) }}
                                                        kepada
                                                        PIHAK KEDUA dan
                                                        PIHAK KEDUA menerima dengan baik Bantuan tersebut, dengan
                                                        spesifikasi sebagaimana terlampir.
                                                    </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="50px"></td>
                                </tr>
                                @if ($data->bantuan_berupa == 'Dana')
                                    @if ($data->termin == 1)
                                        <tr>
                                            <td style="float: left; text-align: center; width: 50px">2.</td>
                                            <td colspan="4">
                                                <table width="100%">
                                                    <tr>
                                                        <td style="text-align: justify">
                                                            Pemberian Bantuan Dana yang dilakukan oleh PIHAK PERTAMA
                                                            kepada
                                                            PIHAK
                                                            KEDUA sebagaimana dimaksud ayat (1) Pasal ini dilakukan
                                                            setelah
                                                            ditandatanganinya BAST ini dan diterimanya seluruh dokumen
                                                            pembayaran
                                                            yang dipersyaratkan oleh PIHAK PERTAMA kepada PIHAK KEDUA
                                                            yakni
                                                            meliputi
                                                            salinan kartu identitas, salinan buku tabungan, kuitansi
                                                            dan/atau
                                                            bukti
                                                            tanda terima lainnya secara baik dan lengkap.
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td style="float: left; text-align: center; width: 50px">2.</td>
                                            <td colspan="4">
                                                <table width="100%">
                                                    <tr>
                                                        <td style="text-align: justify">
                                                            Pemberian Bantuan Dana yang dilakukan oleh PIHAK PERTAMA
                                                            kepada
                                                            PIHAK KEDUA sebagaimana dimaksud ayat (1) Pasal ini
                                                            dilakukan
                                                            dalam
                                                            {{ $data->termin }} ({{ strtolower($termin) }}) tahap,
                                                            yaitu:
                                                            <br>
                                                            <table style="margin-top: 10px" border="0">
                                                                <tr>
                                                                    <td
                                                                        style="float: left; text-align: center; width: 30px">
                                                                        a.
                                                                    </td>
                                                                    <td colspan="4" style="text-align: justify">
                                                                        Tahap 1 sebesar <b>{{ $data->persen1 }}%
                                                                            ({{ strtolower($persen1) }} persen)</b>
                                                                        atau senilai
                                                                        <b>Rp{{ number_format($data->rupiah1, 2, ',', '.') }}
                                                                            ({{ strtolower($rupiah1) }} rupiah)</b>
                                                                        diberikan
                                                                        setelah ditandatanganinya BAST ini dan PIHAK
                                                                        KEDUA menyampaikan dokumen pembayaran yang
                                                                        meliputi
                                                                        salinan kartu identitas, salinan buku tabungan,
                                                                        kuitansi
                                                                        dan/atau bukti tanda terima lainnya secara baik
                                                                        dan
                                                                        lengkap.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" height="25px"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="float: left; text-align: center; width: 30px">
                                                                        b.
                                                                    </td>
                                                                    <td colspan="4" style="text-align: justify">
                                                                        Tahap 2 sebesar <b>{{ $data->persen2 }}%
                                                                            ({{ strtolower($persen2) }} persen)</b>
                                                                        atau senilai
                                                                        <b>Rp{{ number_format($data->rupiah2, 2, ',', '.') }}
                                                                            ({{ strtolower($rupiah2) }} rupiah)</b>
                                                                        diberikan
                                                                        setelah
                                                                        disampaikannya laporan pengelolaan dan/atau
                                                                        pemanfaatan
                                                                        dana Bantuan, kuitansi, dan/atau bukti tanda
                                                                        terima
                                                                        lainnya dari PIHAK KEDUA kepada PIHAK PERTAMA.
                                                                    </td>
                                                                </tr>
                                                                @if ($data->termin >= 3)
                                                                    <tr>
                                                                        <td colspan="5" height="25px"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="float: left; text-align: center; width: 30px">
                                                                            b.
                                                                        </td>
                                                                        <td colspan="4"
                                                                            style="text-align: justify">
                                                                            Tahap 3 sebesar <b>{{ $data->persen3 }}%
                                                                                ({{ strtolower($persen3) }} persen)</b>
                                                                            atau senilai
                                                                            <b>Rp{{ number_format($data->rupiah3, 2, ',', '.') }}
                                                                                ({{ strtolower($rupiah3) }} rupiah)</b>
                                                                            diberikan
                                                                            setelah
                                                                            disampaikannya laporan pengelolaan dan/atau
                                                                            pemanfaatan
                                                                            dana Bantuan, kuitansi, dan/atau bukti tanda
                                                                            terima
                                                                            lainnya dari PIHAK KEDUA kepada PIHAK
                                                                            PERTAMA.
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                @if ($data->termin == 4)
                                                                    <tr>
                                                                        <td colspan="5" height="25px"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="float: left; text-align: center; width: 30px">
                                                                            b.
                                                                        </td>
                                                                        <td colspan="4"
                                                                            style="text-align: justify">
                                                                            Tahap 4 sebesar <b>{{ $data->persen4 }}%
                                                                                ({{ strtolower($persen4) }} persen)</b>
                                                                            atau senilai
                                                                            <b>Rp{{ number_format($data->rupiah4, 2, ',', '.') }}
                                                                                ({{ strtolower($rupiah4) }} rupiah)</b>
                                                                            diberikan
                                                                            setelah
                                                                            disampaikannya laporan pengelolaan dan/atau
                                                                            pemanfaatan
                                                                            dana Bantuan, kuitansi, dan/atau bukti tanda
                                                                            terima
                                                                            lainnya dari PIHAK KEDUA kepada PIHAK
                                                                            PERTAMA.
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    @endif
                                @elseif($data->bantuan_berupa == 'Barang')
                                    <tr>
                                        <td style="float: left; text-align: center; width: 50px">2.</td>
                                        <td colspan="4">
                                            <table width="100%">
                                                <tr>
                                                    <td style="text-align: justify">
                                                        Dengan diterimanya Bantuan dari PIHAK PERTAMA tersebut, segala
                                                        bentuk tanggung
                                                        jawab beralih dari PIHAK PERTAMA kepada PIHAK KEDUA. PIHAK KEDUA
                                                        bertanggung jawab
                                                        sepenuhnya atas penerimaan, pengelolaan, pemanfaatan, perawatan,
                                                        dan
                                                        pengurusan seluruh
                                                        bentuk perizinan atas Bantuan yang diberikan oleh PIHAK PERTAMA.
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                @if ($data->bantuan_berupa == 'Dana')
                                    <tr>
                                        <td style="float: left; text-align: center; width: 50px">3.</td>
                                        <td colspan="4">
                                            <table width="100%">
                                                <tr>
                                                    <td style="text-align: justify">
                                                        Pemberian Bantuan Dana dilakukan melalui pemindahbukuan atau
                                                        transfer
                                                        bank ke rekening bank yang ditunjuk oleh PIHAK KEDUA yaitu:
                                                        <br>
                                                        <table style="margin-top: 5px">
                                                            <tr>
                                                                <td>Bank</td>
                                                                <td>:</td>
                                                                <td>{{ $data->nama_bank }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Nama</td>
                                                                <td>:</td>
                                                                <td>{{ strtoupper($data->atas_nama) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>No Rekening&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                <td>:</td>
                                                                <td>{{ $data->no_rekening }}</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="float: left; text-align: center; width: 50px">
                                        @if ($data->bantuan_berupa == 'Dana')
                                            4.
                                        @elseif($data->bantuan_berupa == 'Barang')
                                            3.
                                        @endif
                                    </td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="text-align: justify">
                                                    PIHAK KEDUA wajib dan bertanggung jawab sepenuhnya untuk menggunakan
                                                    dan
                                                    mengelola Bantuan yang telah diperoleh dari PIHAK PERTAMA sesuai
                                                    dengan peruntukkannya sebagaimana dimaksud Pasal 1 ayat (2) dengan
                                                    berdasarkan pada iktikad baik. Dengan diterimanya Bantuan dari
                                                    PIHAK PERTAMA tersebut, segala bentuk tanggung jawab beralih dari
                                                    PIHAK
                                                    PERTAMA kepada PIHAK KEDUA.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="float: left; text-align: center; width: 50px">
                                        @if ($data->bantuan_berupa == 'Dana')
                                            5.
                                        @elseif($data->bantuan_berupa == 'Barang')
                                            4.
                                        @endif
                                    </td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="text-align: justify">
                                                    Dalam hal Bantuan terdapat branding PIHAK PERTAMA, PIHAK KEDUA
                                                    dilarang
                                                    untuk melepas, mengubah, menutup, menghilangkan dan/atau merusak
                                                    keberadaan logo atau branding yang ditempatkan oleh PIHAK PERTAMA
                                                    pada
                                                    Bantuan bersangkutan.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="float: left; text-align: center; width: 50px">
                                        @if ($data->bantuan_berupa == 'Dana')
                                            6.
                                        @elseif($data->bantuan_berupa == 'Barang')
                                            5.
                                        @endif
                                    </td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="text-align: justify">
                                                    PIHAK KEDUA dilarang untuk menambah dan/atau memasang logo atau
                                                    melakukan branding untuk kepentingan pihak ketiga lainnya baik pada
                                                    Bantuan maupun pada pelaksanaan penyerahan Bantuan dari PIHAK
                                                    PERTAMA
                                                    kepada PIHAK KEDUA, tanpa mendapat persetujuan tertulis terlebih
                                                    dahulu
                                                    dari PIHAK PERTAMA.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: center">
                                        <b>PASAL 3</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: center">
                                        <b>PENUTUP</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="float: left; text-align: center; width: 50px">1.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="text-align: justify">
                                                    PARA PIHAK secara masing-masing wajib menjaga kerahasiaan isi dan
                                                    ketentuan dalam BAST ini dan seluruh informasi atau data, baik
                                                    secara
                                                    lisan, elektronik, atau tertulis yang diterima dari PIHAK lainnya,
                                                    dan
                                                    tidak akan memberikan hal tersebut kepada pihak ketiga tanpa
                                                    pemberitahuan dan persetujuan tertulis terlebih dahulu dari PIHAK
                                                    lainnya kecuali atas perintah pengadilan dan/atau instansi
                                                    pemerintah
                                                    yang berwenang lainnya sesuai dengan ketentuan peraturan perundangan
                                                    yang berlaku.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="float: left; text-align: center; width: 50px">2.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="text-align: justify">
                                                    PIHAK PERTAMA berhak untuk mempublikasikan hasil pemberian Bantuan
                                                    atau
                                                    hasil pelaksanaan Kegiatan Bantuan sebagaimana diatur dalam
                                                    BAST ini.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="float: left; text-align: center; width: 50px">3.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="text-align: justify">
                                                    PIHAK KEDUA dengan ini menyatakan dan menjamin bahwa PIHAK KEDUA
                                                    maupun pihak terkait lainnya tidak akan menuntut dan/atau menggugat
                                                    PIHAK PERTAMA di kemudian hari atas pemberian Bantuan yang
                                                    diselenggarakan berdasarkan BAST ini.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td style="float: left; text-align: center; width: 50px">4.</td>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td style="text-align: justify">
                                                    PIHAK PERTAMA dan PIHAK KEDUA serta pihak terkait lainnya menyatakan
                                                    selama pelaksanaan Kegiatan
                                                    Bantuan tidak terjadi Korupsi, Kolusi, dan Nepotisme (KKN), dan/atau
                                                    Tindakan Penyuapan.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" height="25px"></td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td style="text-align: justify">
                                                    BAST ini dibuat, disetujui dan ditandatangani oleh wakil-wakil yang
                                                    berwenang dari PARA PIHAK pada tanggal sebagaimana tersebut di
                                                    bagian
                                                    awal BAST, dalam 2 (dua) rangkap asli, bermeterai cukup,
                                                    masing-masing
                                                    mempunyai kekuatan hukum yang sama dan mengikat
                                                    PARA PIHAK tanpa tekanan dan paksaan.
                                                </td>
                                            </tr>
                                        </table>
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
                                                <td>{{ ucwords($data->nama_lembaga) }}</td>
                                                <td>PT Nusantara Regas,</td>
                                            </tr>
                                            <tr style="text-align: center">
                                                <td style="vertical-align: middle" height="170px">
                                                    <small style="margin-left: -150px"><i>Materai</i></small>
                                                    <br>
                                                    <small style="margin-left: -150px"><i>ttd</i></small>
                                                    <br>
                                                    <small style="margin-left: -150px"><i>Stempel</i></small>
                                                </td>
                                                <td height="170px">&nbsp;</td>
                                            </tr>
                                            <tr style="text-align: center">
                                                <td><b>{{ ucwords($data->nama_pic) }}</b></td>
                                                <td>
                                                    <b>{{ $approver->nama }}</b>
                                                </td>
                                            </tr>
                                            <tr style="text-align: center">
                                                <td>{{ ucwords($data->jabatan) }}</td>
                                                <td>
                                                    {{ $approver->jabatan }}
                                                </td>
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
                        <td style="height: 0px"></td>
                    </tr>
                </table>
                <br>
            </div>
        </center>
    </div>
</body>

</html>
