<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart2 extends Migration
{
    public function up()
    {
        Schema::create('nr_csr.tbl_detail_approval', function (Blueprint $table) {
                    $table->increments('id');
                    $table->decimal('id_kelayakan', 18, 2)->nullable();
                    $table->decimal('id_hirarki', 18, 2)->nullable();
                    $table->decimal('id_user', 18, 2)->nullable();
                    $table->string('catatan', 255)->nullable();
                    $table->string('status', 255)->nullable();
                    $table->timestamp('status_date')->nullable();
                    $table->timestamp('task_date')->nullable();
                    $table->timestamp('action_date')->nullable();
                    $table->string('phase', 255)->nullable();
                    $table->decimal('created_by', 18, 2)->nullable();
                    $table->string('pesan', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_detail_kriteria', function (Blueprint $table) {
                    $table->bigIncrements('id_detail_kriteria');
                    $table->string('no_agenda', 50)->nullable();
                    $table->string('kriteria', 50)->nullable();
                    $table->timestamp('created_at')->nullable();
                    $table->timestamp('updated_at')->nullable();
                    $table->decimal('id_kelayakan', 18, 2)->nullable();
                });

        Schema::create('nr_csr.tbl_detail_spk', function (Blueprint $table) {
                    $table->increments('id_detail_spk');
                    $table->string('no_agenda', 50)->nullable();
                    $table->string('COLUMN1', 200)->nullable();
                    $table->string('COLUMN2', 200)->nullable();
                    $table->string('COLUMN3', 200)->nullable();
                });

        Schema::create('nr_csr.tbl_dokumen', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('nama_dokumen', 255)->nullable();
                    $table->string('mandatori', 10)->nullable();
                });

        Schema::create('nr_csr.tbl_dokumen_mandatori_proyek', function (Blueprint $table) {
                    $table->increments('dokumen_id');
                    $table->string('nama_dokumen', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_dokumen_mandatori_vendor', function (Blueprint $table) {
                    $table->increments('dokumen_id');
                    $table->string('nama_dokumen', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_dokumen_vendor', function (Blueprint $table) {
                    $table->increments('dokumen_id');
                    $table->decimal('id_vendor', 18, 2)->nullable();
                    $table->string('nama_dokumen', 255)->nullable();
                    $table->string('nomor', 255)->nullable();
                    $table->string('tanggal', 255)->nullable();
                    $table->string('masa_berlaku', 255)->nullable();
                    $table->string('keterangan', 255)->nullable();
                    $table->string('catatan', 255)->nullable();
                    $table->string('file', 255)->nullable();
                    $table->string('PARAMETER1', 255)->nullable();
                    $table->string('PARAMETER2', 255)->nullable();
                    $table->string('PARAMETER3', 255)->nullable();
                    $table->string('PARAMETER4', 255)->nullable();
                    $table->string('PARAMETER5', 255)->nullable();
                    $table->string('status', 255)->nullable();
                    $table->timestamp('status_date')->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->string('created_by', 255)->nullable();
                    $table->timestamp('verifikasi_date')->nullable();
                    $table->string('verifikasi_by', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_evaluasi', function (Blueprint $table) {
                    $table->bigInteger('id_evaluasi');
                    $table->string('no_agenda', 50)->nullable();
                    $table->string('rencana_anggaran', 20)->nullable();
                    $table->string('dokumen', 20)->nullable();
                    $table->string('denah', 20)->nullable();
                    $table->string('syarat', 100)->nullable();
                    $table->string('EVALUATOR1', 50)->nullable();
                    $table->text('CATATAN1')->nullable();
                    $table->string('EVALUATOR2', 50)->nullable();
                    $table->text('CATATAN2')->nullable();
                    $table->string('kadep', 50)->nullable();
                    $table->string('kadiv', 50)->nullable();
                    $table->string('status', 50)->nullable();
                    $table->timestamp('approve_date')->nullable();
                    $table->string('ket_kadiv', 150)->nullable();
                    $table->string('KET_KADIN1', 150)->nullable();
                    $table->string('KET_KADIN2', 150)->nullable();
                    $table->string('keterangan', 200)->nullable();
                    $table->timestamp('approve_kadep')->nullable();
                    $table->timestamp('approve_kadiv')->nullable();
                    $table->string('revisi_by', 50)->nullable();
                    $table->timestamp('revisi_date')->nullable();
                    $table->string('reject_by', 50)->nullable();
                    $table->timestamp('reject_date')->nullable();
                    $table->string('create_by', 50)->nullable();
                    $table->timestamp('create_date')->nullable();
                    $table->timestamp('created_at')->nullable();
                    $table->timestamp('updated_at')->nullable();
                    $table->string('CATATAN1_NEW', 200)->nullable();
                    $table->string('CATATAN2_NEW', 200)->nullable();
                    $table->decimal('id_kelayakan', 18, 2)->nullable();
                    $table->decimal('created_by', 18, 2)->nullable();
                    $table->string('sekper', 255)->nullable();
                    $table->string('dirut', 255)->nullable();
                    $table->string('ket_sekper', 255)->nullable();
                    $table->string('ket_dirut', 255)->nullable();
                    $table->timestamp('approve_sekper')->nullable();
                    $table->timestamp('approve_dirut')->nullable();
                });

        Schema::create('nr_csr.tbl_exception', function (Blueprint $table) {
                    $table->increments('error_id');
                    $table->text('exception')->nullable();
                    $table->timestamp('error_date')->nullable();
                    $table->string('error_by', 255)->nullable();
                    $table->string('status', 255)->nullable();
                    $table->string('remark', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_hirarki', function (Blueprint $table) {
                    $table->increments('id');
                    $table->decimal('id_user', 18, 2)->nullable();
                    $table->decimal('id_level', 18, 2)->nullable();
                    $table->string('status', 10)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('nr_csr.tbl_hirarki');
        Schema::dropIfExists('nr_csr.tbl_exception');
        Schema::dropIfExists('nr_csr.tbl_evaluasi');
        Schema::dropIfExists('nr_csr.tbl_dokumen_vendor');
        Schema::dropIfExists('nr_csr.tbl_dokumen_mandatori_vendor');
        Schema::dropIfExists('nr_csr.tbl_dokumen_mandatori_proyek');
        Schema::dropIfExists('nr_csr.tbl_dokumen');
        Schema::dropIfExists('nr_csr.tbl_detail_spk');
        Schema::dropIfExists('nr_csr.tbl_detail_kriteria');
        Schema::dropIfExists('nr_csr.tbl_detail_approval');
    }
}
