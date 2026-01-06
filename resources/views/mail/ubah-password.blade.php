<?php
date_default_timezone_set("Asia/Bangkok");
$tanggalmenit = date("Y-m-d H:i:s");
$tgl = date("Y-m-d");

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

$day = date('D', strtotime($tanggal));
$dayList = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
);

$tglubah = date('Y-m-d', strtotime($tanggal));
$jamubah = date('H:i', strtotime($tanggal));
?>

        <!DOCTYPE html>
<html>
<body>
<div class='container'>
    <p>Hai <b>{{ $nama }}</b></p>
    <p style="text-align: justify">Password anda telah diubah pada Hari {{ $dayList[$day] }},
         {{ tanggal_indo($tglubah)}} Pukul {{ $jamubah }} WIB. Bila anda tidak merasa merubah password segera hubungi
        administrator.</p>
    <p>
        Catatan :<br>
        Email ini dikirim secara otomatis by system<br>
        Mohon untuk tidak mereply.
    </p>
</div>
</body>
</html>