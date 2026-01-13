<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart4 extends Migration
{
    public function up()
    {
        Schema::create('nr_csr.tbl_level_hirarki', function (Blueprint $table) {
                    $table->increments('id');
                    $table->decimal('level', 18, 2)->nullable();
                    $table->string('nama_level', 20)->nullable();
                });

        Schema::create('nr_csr.tbl_log', function (Blueprint $table) {
                    $table->increments('id');
                    $table->decimal('id_kelayakan', 18, 2)->nullable();
                    $table->string('keterangan', 200)->nullable();
                    $table->decimal('created_by', 18, 2)->nullable();
                    $table->timestamp('created_date')->nullable();
                });

        Schema::create('nr_csr.tbl_log_pekerjaan', function (Blueprint $table) {
                    $table->increments('log_id');
                    $table->string('pekerjaan_id', 255)->nullable();
                    $table->string('update_by', 255)->nullable();
                    $table->timestamp('update_date')->nullable();
                    $table->string('action', 255)->nullable();
                    $table->string('keterangan', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_log_relokasi', function (Blueprint $table) {
                    $table->increments('id_log');
                    $table->string('id_proker', 255)->nullable();
                    $table->string('keterangan', 255)->nullable();
                    $table->string('status', 255)->nullable();
                    $table->timestamp('status_date')->nullable();
                });

        Schema::create('nr_csr.tbl_log_vendor', function (Blueprint $table) {
                    $table->increments('log_id');
                    $table->string('id_vendor', 255)->nullable();
                    $table->string('update_by', 255)->nullable();
                    $table->timestamp('update_date')->nullable();
                    $table->string('action', 255)->nullable();
                    $table->string('keterangan', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_pejabat', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('nama', 255)->nullable();
                    $table->string('jabatan', 255)->nullable();
                    $table->string('sk', 255)->nullable();
                    $table->timestamp('tanggal')->nullable();
                });

        Schema::create('nr_csr.tbl_pekerjaan', function (Blueprint $table) {
                    $table->increments('pekerjaan_id');
                    $table->string('nama_pekerjaan', 255)->nullable();
                    $table->string('tahun', 255)->nullable();
                    $table->decimal('proker_id', 18, 2)->nullable();
                    $table->decimal('nilai_perkiraan', 18, 2)->nullable();
                    $table->string('status', 255)->nullable();
                    $table->string('created_by', 255)->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->text('ringkasan')->nullable();
                    $table->string('kak', 255)->nullable();
                    $table->string('id_vendor', 255)->nullable();
                    $table->decimal('nilai_penawaran', 18, 2)->nullable();
                    $table->decimal('nilai_kesepakatan', 18, 2)->nullable();
                });

        Schema::create('nr_csr.tbl_pembayaran', function (Blueprint $table) {
                    $table->bigInteger('id_pembayaran');
                    $table->string('no_agenda', 50)->nullable();
                    $table->string('no_bast', 50)->nullable();
                    $table->string('no_ba', 50)->nullable();
                    $table->string('termin', 2)->nullable();
                    $table->decimal('nilai_approved', 18, 2)->nullable();
                    $table->string('persen', 3)->nullable();
                    $table->string('status', 50)->nullable();
                    $table->string('pr_id', 50)->nullable();
                    $table->timestamp('create_date')->nullable();
                    $table->string('create_by', 50)->nullable();
                    $table->timestamp('export_date')->nullable();
                    $table->string('export_by', 100)->nullable();
                    $table->bigInteger('id_kelayakan')->nullable();
                    $table->string('deskripsi', 500)->nullable();
                    $table->decimal('fee', 18, 2)->nullable();
                    $table->decimal('jumlah_pembayaran', 18, 2)->nullable();
                    $table->decimal('subtotal', 18, 2)->nullable();
                    $table->decimal('fee_persen', 18, 2)->nullable();
                    $table->string('status_ykpp', 255)->nullable();
                    $table->string('approved_ykpp_by', 255)->nullable();
                    $table->timestamp('approved_ykpp_date')->nullable();
                    $table->string('submited_ykpp_by', 255)->nullable();
                    $table->timestamp('submited_ykpp_date')->nullable();
                    $table->string('no_surat_ykpp', 255)->nullable();
                    $table->string('tgl_surat_ykpp', 255)->nullable();
                    $table->string('surat_ykpp', 255)->nullable();
                    $table->string('tahun_ykpp', 4)->nullable();
                    $table->string('penyaluran_ke', 255)->nullable();
                    $table->string('metode', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_pembayaran_vendor', function (Blueprint $table) {
                    $table->bigInteger('id_pembayaran');
                    $table->string('pekerjaan_id', 50)->nullable();
                    $table->string('no_bast', 50)->nullable();
                    $table->string('no_ba', 50)->nullable();
                    $table->string('termin', 2)->nullable();
                    $table->decimal('nilai_kesepakatan', 18, 2)->nullable();
                    $table->string('persen', 3)->nullable();
                    $table->string('jumlah_pembayaran', 255)->nullable();
                    $table->string('status', 50)->nullable();
                    $table->string('pr_id', 50)->nullable();
                    $table->timestamp('create_date')->nullable();
                    $table->string('create_by', 50)->nullable();
                    $table->timestamp('export_date')->nullable();
                    $table->string('export_by', 100)->nullable();
                    $table->string('id_vendor', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_PEMBAYARAN_copy1', function (Blueprint $table) {
                    $table->bigInteger('id_pembayaran');
                    $table->string('no_agenda', 50)->nullable();
                    $table->string('no_bast', 50)->nullable();
                    $table->string('no_ba', 50)->nullable();
                    $table->string('termin', 2)->nullable();
                    $table->decimal('nilai_approved', 18, 2)->nullable();
                    $table->string('persen', 3)->nullable();
                    $table->string('status', 50)->nullable();
                    $table->string('pr_id', 50)->nullable();
                    $table->timestamp('create_date')->nullable();
                    $table->string('create_by', 50)->nullable();
                    $table->timestamp('export_date')->nullable();
                    $table->string('export_by', 100)->nullable();
                    $table->bigInteger('id_kelayakan')->nullable();
                    $table->string('deskripsi', 500)->nullable();
                    $table->decimal('fee', 18, 2)->nullable();
                    $table->decimal('jumlah_pembayaran', 18, 2)->nullable();
                    $table->decimal('subtotal', 18, 2)->nullable();
                    $table->decimal('fee_persen', 18, 2)->nullable();
                    $table->string('status_ykpp', 255)->nullable();
                    $table->string('approved_ykpp_by', 255)->nullable();
                    $table->timestamp('approved_ykpp_date')->nullable();
                    $table->string('submited_ykpp_by', 255)->nullable();
                    $table->timestamp('submited_ykpp_date')->nullable();
                    $table->string('no_surat_ykpp', 255)->nullable();
                    $table->string('tgl_surat_ykpp', 255)->nullable();
                    $table->string('surat_ykpp', 255)->nullable();
                    $table->string('tahun_ykpp', 4)->nullable();
                    $table->string('penyaluran_ke', 255)->nullable();
                    $table->string('metode', 255)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('NR_CSR.TBL_PEMBAYARAN_copy1');
        Schema::dropIfExists('nr_csr.tbl_pembayaran_vendor');
        Schema::dropIfExists('nr_csr.tbl_pembayaran');
        Schema::dropIfExists('nr_csr.tbl_pekerjaan');
        Schema::dropIfExists('nr_csr.tbl_pejabat');
        Schema::dropIfExists('nr_csr.tbl_log_vendor');
        Schema::dropIfExists('nr_csr.tbl_log_relokasi');
        Schema::dropIfExists('nr_csr.tbl_log_pekerjaan');
        Schema::dropIfExists('nr_csr.tbl_log');
        Schema::dropIfExists('nr_csr.tbl_level_hirarki');
    }
}
