<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SdgSeeder extends Seeder
{
    public function run()
    {
        $table = 'tbl_sdg';

        $tpbList = [
            ['kode' => '1', 'nama' => 'Tanpa Kemiskinan', 'pilar' => 'Pemberdayaan Masyarakat'],
            ['kode' => '2', 'nama' => 'Tanpa Kelaparan', 'pilar' => 'Pemberdayaan Masyarakat'],
            ['kode' => '3', 'nama' => 'Kehidupan Sehat dan Sejahtera', 'pilar' => 'Sosial'],
            ['kode' => '4', 'nama' => 'Pendidikan Berkualitas', 'pilar' => 'Pendidikan & Kebudayaan'],
            ['kode' => '5', 'nama' => 'Kesetaraan Gender', 'pilar' => 'Pemberdayaan Masyarakat'],
            ['kode' => '6', 'nama' => 'Air Bersih dan Sanitasi Layak', 'pilar' => 'Lingkungan'],
            ['kode' => '7', 'nama' => 'Energi Bersih dan Terjangkau', 'pilar' => 'Lingkungan'],
            ['kode' => '8', 'nama' => 'Pekerjaan Layak dan Pertumbuhan Ekonomi', 'pilar' => 'Pemberdayaan Masyarakat'],
            ['kode' => '9', 'nama' => 'Industri, Inovasi dan Infrastruktur', 'pilar' => 'Infrastruktur'],
            ['kode' => '10', 'nama' => 'Berkurangnya Kesenjangan', 'pilar' => 'Sosial'],
            ['kode' => '11', 'nama' => 'Kota dan Permukiman yang Berkelanjutan', 'pilar' => 'Infrastruktur'],
            ['kode' => '12', 'nama' => 'Konsumsi dan Produksi yang Bertanggung Jawab', 'pilar' => 'Lingkungan'],
            ['kode' => '13', 'nama' => 'Penanganan Perubahan Iklim', 'pilar' => 'Lingkungan'],
            ['kode' => '14', 'nama' => 'Ekosistem Laut', 'pilar' => 'Lingkungan'],
            ['kode' => '15', 'nama' => 'Ekosistem Daratan', 'pilar' => 'Lingkungan'],
            ['kode' => '16', 'nama' => 'Perdamaian, Keadilan dan Kelembagaan yang Tangguh', 'pilar' => 'Sosial'],
            ['kode' => '17', 'nama' => 'Kemitraan untuk Mencapai Tujuan', 'pilar' => 'Pemberdayaan Masyarakat'],
        ];

        foreach ($tpbList as $tpb) {
            DB::table($table)->updateOrInsert(
                ['kode' => $tpb['kode']],
                ['nama' => $tpb['nama'], 'pilar' => $tpb['pilar']]
            );
        }
    }
}
