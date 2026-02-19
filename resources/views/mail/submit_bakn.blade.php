<!DOCTYPE html>
<html>
<body>
<div class='container'>
    <p>Yth, {{ $penerima }}</p>
    <p>Berdasarkan hasil negosiasi yang mengacu pada Surat Penawaran Harga {{ $namaProyek }} Nomor <b>{{ $no_sph }}</b>, dengan ini kami sampaikan Berita Acara Klarifikasi dan Negosiasi dengan rincian sebagai berikut :</p>
    <table>
        <tr>
            <td style="padding-right: 10px; vertical-align: top">Nomor</td>
            <td style="padding-right: 10px; vertical-align: top">:</td>
            <td style="vertical-align: top">{{ $no_bakn }}</td>
        </tr>
        <tr>
            <td style="padding-right: 10px; vertical-align: top">Tanggal</td>
            <td style="padding-right: 10px; vertical-align: top">:</td>
            <td style="vertical-align: top">{{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($tanggal))) }}</td>
        </tr>
        <tr>
            <td style="padding-right: 10px; vertical-align: top">Nama Proyek</td>
            <td style="padding-right: 10px; vertical-align: top">:</td>
            <td style="vertical-align: top">{{ $namaProyek }}</td>
        </tr>
        <tr>
            <td style="padding-right: 10px; vertical-align: top">Nilai Kesepakatan</td>
            <td style="padding-right: 10px; vertical-align: top">:</td>
            <td style="vertical-align: top">{{ "Rp. ".number_format($nilaiKesepakatan,0,',','.') }}</td>
        </tr>
    </table>
    <p>Untuk detailnya silahkan lihat pada Aplikasi <a href='{{ url('/') }}'>{{ url('/') }}</a>.</p>
    <p>
        Catatan :<br>
        Email ini dikirim secara otomatis by system<br>
        Mohon untuk tidak mereply.
    </p>
</div>
</body>
</html>