<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateNrCsrSchemas extends Migration
{
    public function up()
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS "NR_CSR"');
        DB::statement('CREATE SCHEMA IF NOT EXISTS "NR_PAYMENT"');
    }

    public function down()
    {
        // Keep schemas by default to avoid accidental data loss.
        // DB::statement('DROP SCHEMA IF EXISTS "NR_CSR" CASCADE');
        // DB::statement('DROP SCHEMA IF EXISTS "NR_PAYMENT" CASCADE');
    }
}
