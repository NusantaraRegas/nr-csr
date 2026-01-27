<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddNrCsrConstraintsAndIndexes extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE nr_csr.tbl_anggaran ADD CONSTRAINT tahun_unique UNIQUE (tahun, id_perusahaan)');
        DB::statement('ALTER TABLE nr_csr.tbl_bast_dana ADD CONSTRAINT tbl_bast_dana_uk1 UNIQUE (no_agenda)');
        DB::statement('ALTER TABLE nr_csr.tbl_kelayakan ADD CONSTRAINT tbl_kelayakan_uk1 UNIQUE (no_agenda)');
        DB::statement('ALTER TABLE nr_csr.tbl_sektor ADD CONSTRAINT tbl_sektor_uk1 UNIQUE (kode_sektor)');
        DB::statement('ALTER TABLE nr_csr.tbl_user ADD CONSTRAINT tbl_user_uk1 UNIQUE (username)');
        DB::statement('ALTER TABLE nr_csr.tbl_user ADD CONSTRAINT tbl_user_uk2 UNIQUE (email)');
        // In PostgreSQL, INDEX objects belong to a schema, but the name itself is not schema-qualified in CREATE INDEX.
        // Use SET search_path so the index is created under the nr_csr schema.
        DB::statement('SET search_path TO nr_csr');
        DB::statement('CREATE UNIQUE INDEX no_bakn ON nr_csr.tbl_bakn (nomor)');
        DB::statement('CREATE UNIQUE INDEX no_sph ON nr_csr.tbl_sph (nomor)');
        DB::statement('CREATE UNIQUE INDEX no_spph ON nr_csr.tbl_spph (nomor)');
        DB::statement('SET search_path TO nr_csr, public');
    }

    public function down()
    {
        // Dropping constraints/indexes is intentionally omitted (safety).
    }
}
