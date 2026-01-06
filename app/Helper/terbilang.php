<?php
namespace App\Helper;

class terbilang
{
    // Fungsi utama
    public static function terbilang($x, $style = 4)
    {
        if ($x < 0) {
            $hasil = "minus " . trim(self::kekata($x));
        } else {
            $hasil = trim(self::kekata($x));
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

    // Fungsi bantu internal
    protected static function kekata($x)
    {
        $x = abs($x);
        $angka = [
            "", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
        ];
        $temp = "";

        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = self::kekata($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = self::kekata($x / 10) . " puluh" . self::kekata($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . self::kekata($x - 100);
        } else if ($x < 1000) {
            $temp = self::kekata($x / 100) . " ratus" . self::kekata($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . self::kekata($x - 1000);
        } else if ($x < 1000000) {
            $temp = self::kekata($x / 1000) . " ribu" . self::kekata($x % 1000);
        } else if ($x < 1000000000) {
            $temp = self::kekata($x / 1000000) . " juta" . self::kekata($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = self::kekata($x / 1000000000) . " milyar" . self::kekata(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = self::kekata($x / 1000000000000) . " trilyun" . self::kekata(fmod($x, 1000000000000));
        }

        return $temp;
    }

    public static function instance()
    {
        return new self();
    }
}
