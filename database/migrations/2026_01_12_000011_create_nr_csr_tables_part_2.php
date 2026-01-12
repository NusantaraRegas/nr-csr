<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart2 extends Migration
{
    public function up()
    {
        Schema::create('NR_CSR.TBL_DETAIL_APPROVAL', function (Blueprint $table) {
                    $table->increments('ID');
                    $table->decimal('ID_KELAYAKAN', 18, 2)->nullable();
                    $table->decimal('ID_HIRARKI', 18, 2)->nullable();
                    $table->decimal('ID_USER', 18, 2)->nullable();
                    $table->string('CATATAN', 255)->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->timestamp('STATUS_DATE')->nullable();
                    $table->timestamp('TASK_DATE')->nullable();
                    $table->timestamp('ACTION_DATE')->nullable();
                    $table->string('PHASE', 255)->nullable();
                    $table->decimal('CREATED_BY', 18, 2)->nullable();
                    $table->string('PESAN', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_DETAIL_KRITERIA', function (Blueprint $table) {
                    $table->bigIncrements('ID_DETAIL_KRITERIA');
                    $table->string('NO_AGENDA', 50)->nullable();
                    $table->string('KRITERIA', 50)->nullable();
                    $table->timestamp('CREATED_AT')->nullable();
                    $table->timestamp('UPDATED_AT')->nullable();
                    $table->decimal('ID_KELAYAKAN', 18, 2)->nullable();
                });

        Schema::create('NR_CSR.TBL_DETAIL_SPK', function (Blueprint $table) {
                    $table->increments('ID_DETAIL_SPK');
                    $table->string('NO_AGENDA', 50)->nullable();
                    $table->string('COLUMN1', 200)->nullable();
                    $table->string('COLUMN2', 200)->nullable();
                    $table->string('COLUMN3', 200)->nullable();
                });

        Schema::create('NR_CSR.TBL_DOKUMEN', function (Blueprint $table) {
                    $table->increments('ID');
                    $table->string('NAMA_DOKUMEN', 255)->nullable();
                    $table->string('MANDATORI', 10)->nullable();
                });

        Schema::create('NR_CSR.TBL_DOKUMEN_MANDATORI_PROYEK', function (Blueprint $table) {
                    $table->increments('DOKUMEN_ID');
                    $table->string('NAMA_DOKUMEN', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_DOKUMEN_MANDATORI_VENDOR', function (Blueprint $table) {
                    $table->increments('DOKUMEN_ID');
                    $table->string('NAMA_DOKUMEN', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_DOKUMEN_VENDOR', function (Blueprint $table) {
                    $table->increments('DOKUMEN_ID');
                    $table->decimal('ID_VENDOR', 18, 2)->nullable();
                    $table->string('NAMA_DOKUMEN', 255)->nullable();
                    $table->string('NOMOR', 255)->nullable();
                    $table->string('TANGGAL', 255)->nullable();
                    $table->string('MASA_BERLAKU', 255)->nullable();
                    $table->string('KETERANGAN', 255)->nullable();
                    $table->string('CATATAN', 255)->nullable();
                    $table->string('FILE', 255)->nullable();
                    $table->string('PARAMETER1', 255)->nullable();
                    $table->string('PARAMETER2', 255)->nullable();
                    $table->string('PARAMETER3', 255)->nullable();
                    $table->string('PARAMETER4', 255)->nullable();
                    $table->string('PARAMETER5', 255)->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->timestamp('STATUS_DATE')->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                    $table->timestamp('VERIFIKASI_DATE')->nullable();
                    $table->string('VERIFIKASI_BY', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_EVALUASI', function (Blueprint $table) {
                    $table->bigInteger('ID_EVALUASI');
                    $table->string('NO_AGENDA', 50)->nullable();
                    $table->string('RENCANA_ANGGARAN', 20)->nullable();
                    $table->string('DOKUMEN', 20)->nullable();
                    $table->string('DENAH', 20)->nullable();
                    $table->string('SYARAT', 100)->nullable();
                    $table->string('EVALUATOR1', 50)->nullable();
                    $table->text('CATATAN1')->nullable();
                    $table->string('EVALUATOR2', 50)->nullable();
                    $table->text('CATATAN2')->nullable();
                    $table->string('KADEP', 50)->nullable();
                    $table->string('KADIV', 50)->nullable();
                    $table->string('STATUS', 50)->nullable();
                    $table->timestamp('APPROVE_DATE')->nullable();
                    $table->string('KET_KADIV', 150)->nullable();
                    $table->string('KET_KADIN1', 150)->nullable();
                    $table->string('KET_KADIN2', 150)->nullable();
                    $table->string('KETERANGAN', 200)->nullable();
                    $table->timestamp('APPROVE_KADEP')->nullable();
                    $table->timestamp('APPROVE_KADIV')->nullable();
                    $table->string('REVISI_BY', 50)->nullable();
                    $table->timestamp('REVISI_DATE')->nullable();
                    $table->string('REJECT_BY', 50)->nullable();
                    $table->timestamp('REJECT_DATE')->nullable();
                    $table->string('CREATE_BY', 50)->nullable();
                    $table->timestamp('CREATE_DATE')->nullable();
                    $table->timestamp('CREATED_AT')->nullable();
                    $table->timestamp('UPDATED_AT')->nullable();
                    $table->string('CATATAN1_NEW', 200)->nullable();
                    $table->string('CATATAN2_NEW', 200)->nullable();
                    $table->decimal('ID_KELAYAKAN', 18, 2)->nullable();
                    $table->decimal('CREATED_BY', 18, 2)->nullable();
                    $table->string('SEKPER', 255)->nullable();
                    $table->string('DIRUT', 255)->nullable();
                    $table->string('KET_SEKPER', 255)->nullable();
                    $table->string('KET_DIRUT', 255)->nullable();
                    $table->timestamp('APPROVE_SEKPER')->nullable();
                    $table->timestamp('APPROVE_DIRUT')->nullable();
                });

        Schema::create('NR_CSR.TBL_EXCEPTION', function (Blueprint $table) {
                    $table->increments('ERROR_ID');
                    $table->text('EXCEPTION')->nullable();
                    $table->timestamp('ERROR_DATE')->nullable();
                    $table->string('ERROR_BY', 255)->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->string('REMARK', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_HIRARKI', function (Blueprint $table) {
                    $table->increments('ID');
                    $table->decimal('ID_USER', 18, 2)->nullable();
                    $table->decimal('ID_LEVEL', 18, 2)->nullable();
                    $table->string('STATUS', 10)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('NR_CSR.TBL_HIRARKI');
        Schema::dropIfExists('NR_CSR.TBL_EXCEPTION');
        Schema::dropIfExists('NR_CSR.TBL_EVALUASI');
        Schema::dropIfExists('NR_CSR.TBL_DOKUMEN_VENDOR');
        Schema::dropIfExists('NR_CSR.TBL_DOKUMEN_MANDATORI_VENDOR');
        Schema::dropIfExists('NR_CSR.TBL_DOKUMEN_MANDATORI_PROYEK');
        Schema::dropIfExists('NR_CSR.TBL_DOKUMEN');
        Schema::dropIfExists('NR_CSR.TBL_DETAIL_SPK');
        Schema::dropIfExists('NR_CSR.TBL_DETAIL_KRITERIA');
        Schema::dropIfExists('NR_CSR.TBL_DETAIL_APPROVAL');
    }
}
