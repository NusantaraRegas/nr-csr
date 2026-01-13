<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdPerusahaanToIntegerInTblUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Change id_perusahaan from NUMERIC(18,2) to INTEGER
        DB::statement('ALTER TABLE nr_csr.tbl_user ALTER COLUMN id_perusahaan TYPE INTEGER USING id_perusahaan::INTEGER');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert back to NUMERIC(18,2) if needed
        DB::statement('ALTER TABLE nr_csr.tbl_user ALTER COLUMN id_perusahaan TYPE NUMERIC(18,2)');
    }
}
