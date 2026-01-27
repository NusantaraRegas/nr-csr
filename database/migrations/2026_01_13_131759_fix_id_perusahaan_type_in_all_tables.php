<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixIdPerusahaanTypeInAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop dependent views first
        DB::statement('DROP VIEW IF EXISTS nr_csr.v_anggaran CASCADE');
        DB::statement('DROP VIEW IF EXISTS nr_csr.v_proker CASCADE');
        DB::statement('DROP VIEW IF EXISTS nr_csr.v_pekerjaan CASCADE');
        
        // Fix id_perusahaan in tbl_perusahaan (primary key)
        DB::statement('ALTER TABLE nr_csr.tbl_perusahaan ALTER COLUMN id_perusahaan TYPE INTEGER USING id_perusahaan::INTEGER');
        
        // Fix id_perusahaan in other tables that reference tbl_perusahaan
        $tables = [
            'tbl_anggaran',
            'tbl_proker',
            'tbl_pekerjaan',
            'tbl_vendor',
            'tbl_hirarki',
        ];
        
        foreach ($tables as $table) {
            // Check if table exists and has id_perusahaan column
            $exists = DB::select("SELECT column_name FROM information_schema.columns WHERE table_schema = 'nr_csr' AND table_name = ? AND column_name = 'id_perusahaan'", [$table]);
            
            if (!empty($exists)) {
                DB::statement("ALTER TABLE nr_csr.{$table} ALTER COLUMN id_perusahaan TYPE INTEGER USING id_perusahaan::INTEGER");
            }
        }
        
        // Recreate views - these will now use INTEGER type
        // Note: If you have custom view definitions, you'll need to run them separately
        // The application should continue to work, views can be recreated via database migrations or scripts
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert to NUMERIC(18,2)
        DB::statement('ALTER TABLE nr_csr.tbl_perusahaan ALTER COLUMN id_perusahaan TYPE NUMERIC(18,2)');
        
        $tables = [
            'tbl_anggaran',
            'tbl_proker',
            'tbl_pekerjaan',
            'tbl_vendor',
            'tbl_hirarki',
        ];
        
        foreach ($tables as $table) {
            $exists = DB::select("SELECT column_name FROM information_schema.columns WHERE table_schema = 'nr_csr' AND table_name = ? AND column_name = 'id_perusahaan'", [$table]);
            
            if (!empty($exists)) {
                DB::statement("ALTER TABLE nr_csr.{$table} ALTER COLUMN id_perusahaan TYPE NUMERIC(18,2)");
            }
        }
    }
}
