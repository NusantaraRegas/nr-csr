<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddNrCsrConstraintsAndIndexes extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE "NR_CSR"."TBL_ANGGARAN" ADD CONSTRAINT "TAHUN" UNIQUE ("TAHUN", "ID_PERUSAHAAN")');
        DB::statement('ALTER TABLE "NR_CSR"."TBL_BAST_DANA" ADD CONSTRAINT "TBL_BAST_DANA_UK1" UNIQUE ("NO_AGENDA")');
        DB::statement('ALTER TABLE "NR_CSR"."TBL_KELAYAKAN" ADD CONSTRAINT "TBL_KELAYAKAN_UK1" UNIQUE ("NO_AGENDA")');
        DB::statement('ALTER TABLE "NR_CSR"."TBL_SEKTOR" ADD CONSTRAINT "TBL_SEKTOR_UK1" UNIQUE ("KODE_SEKTOR")');
        DB::statement('ALTER TABLE "NR_CSR"."TBL_USER" ADD CONSTRAINT "TBL_USER_UK1" UNIQUE ("USERNAME")');
        DB::statement('ALTER TABLE "NR_CSR"."TBL_USER" ADD CONSTRAINT "TBL_USER_UK2" UNIQUE ("EMAIL")');
        // In PostgreSQL, INDEX objects belong to a schema, but the name itself is not schema-qualified in CREATE INDEX.
        // Use SET search_path so the index is created under the NR_CSR schema.
        DB::statement('SET search_path TO "NR_CSR"');
        DB::statement('CREATE UNIQUE INDEX "NO_BAKN" ON "NR_CSR"."TBL_BAKN" ("NOMOR")');
        DB::statement('CREATE UNIQUE INDEX "NO_SPH" ON "NR_CSR"."TBL_SPH" ("NOMOR")');
        DB::statement('CREATE UNIQUE INDEX "NO_SPPH" ON "NR_CSR"."TBL_SPPH" ("NOMOR")');
        DB::statement('SET search_path TO public');
    }

    public function down()
    {
        // Dropping constraints/indexes is intentionally omitted (safety).
    }
}
