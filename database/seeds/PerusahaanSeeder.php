<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if exists
         = DB::table('nr_csr.tbl_perusahaan')->where('id_perusahaan', 1)->exists();

            DB::table('nr_csr.tbl_perusahaan')->insert([
                'id_perusahaan' => 1,
                'nama_perusahaan' => 'PT Perusahaan Gas Negara Tbk',
                'kategori' => 'Holding',
                'kode' => 'PGN',
                'status' => 'Active'
            ]);
        }
    }
}
