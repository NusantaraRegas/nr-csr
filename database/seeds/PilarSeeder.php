<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PilarSeeder extends Seeder
{
    public function run()
    {
        $table = 'tbl_pilar';

        $pilars = [
            ['kode' => 1, 'nama' => 'Pendidikan & Kebudayaan'],
            ['kode' => 2, 'nama' => 'Pemberdayaan Masyarakat'],
            ['kode' => 3, 'nama' => 'Sosial'],
            ['kode' => 4, 'nama' => 'Lingkungan'],
            ['kode' => 5, 'nama' => 'Infrastruktur'],
        ];

        foreach ($pilars as $pilar) {
            DB::table($table)->updateOrInsert(
                ['kode' => $pilar['kode']],
                ['nama' => $pilar['nama']]
            );
        }
    }
}
