<?php

namespace App\Helper;

class formatTanggal
{
    protected static function daftarBulan()
    {
        return [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }

    protected static function daftarHari()
    {
        return [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];
    }

    public static function tanggal_indo($tanggal)
    {
        $timestamp = strtotime($tanggal);
        $day = date('d', $timestamp);
        $month = (int) date('m', $timestamp);
        $year = date('Y', $timestamp);

        $bulan = self::daftarBulan();

        return $day . ' ' . $bulan[$month] . ' ' . $year;
    }

    public static function hari_indo($tanggal)
    {
        $timestamp = strtotime($tanggal);
        $namaHari = self::daftarHari()[date('l', $timestamp)];

        return $namaHari . ', ' . self::tanggal_indo($tanggal);
    }

    public static function nama_hari($tanggal)
    {
        $timestamp = strtotime($tanggal);
        return self::daftarHari()[date('l', $timestamp)];
    }

    public static function nama_bulan($tanggal)
    {
        $timestamp = strtotime($tanggal);
        $bulan = self::daftarBulan();
        return $bulan[(int) date('m', $timestamp)];
    }

    public static function instance()
    {
        return new formatTanggal();
    }
}
