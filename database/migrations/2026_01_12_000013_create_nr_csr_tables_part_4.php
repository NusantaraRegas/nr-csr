<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart4 extends Migration
{
    public function up()
    {
        Schema::create('NR_CSR.TBL_LEVEL_HIRARKI', function (Blueprint $table) {
                    $table->increments('ID');
                    $table->decimal('LEVEL', 18, 2)->nullable();
                    $table->string('NAMA_LEVEL', 20)->nullable();
                });

        Schema::create('NR_CSR.TBL_LOG', function (Blueprint $table) {
                    $table->increments('ID');
                    $table->decimal('ID_KELAYAKAN', 18, 2)->nullable();
                    $table->string('KETERANGAN', 200)->nullable();
                    $table->decimal('CREATED_BY', 18, 2)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                });

        Schema::create('NR_CSR.TBL_LOG_PEKERJAAN', function (Blueprint $table) {
                    $table->increments('LOG_ID');
                    $table->string('PEKERJAAN_ID', 255)->nullable();
                    $table->string('UPDATE_BY', 255)->nullable();
                    $table->timestamp('UPDATE_DATE')->nullable();
                    $table->string('ACTION', 255)->nullable();
                    $table->string('KETERANGAN', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_LOG_RELOKASI', function (Blueprint $table) {
                    $table->increments('ID_LOG');
                    $table->string('ID_PROKER', 255)->nullable();
                    $table->string('KETERANGAN', 255)->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->timestamp('STATUS_DATE')->nullable();
                });

        Schema::create('NR_CSR.TBL_LOG_VENDOR', function (Blueprint $table) {
                    $table->increments('LOG_ID');
                    $table->string('ID_VENDOR', 255)->nullable();
                    $table->string('UPDATE_BY', 255)->nullable();
                    $table->timestamp('UPDATE_DATE')->nullable();
                    $table->string('ACTION', 255)->nullable();
                    $table->string('KETERANGAN', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_PEJABAT', function (Blueprint $table) {
                    $table->increments('ID');
                    $table->string('NAMA', 255)->nullable();
                    $table->string('JABATAN', 255)->nullable();
                    $table->string('SK', 255)->nullable();
                    $table->timestamp('TANGGAL')->nullable();
                });

        Schema::create('NR_CSR.TBL_PEKERJAAN', function (Blueprint $table) {
                    $table->increments('PEKERJAAN_ID');
                    $table->string('NAMA_PEKERJAAN', 255)->nullable();
                    $table->string('TAHUN', 255)->nullable();
                    $table->decimal('PROKER_ID', 18, 2)->nullable();
                    $table->decimal('NILAI_PERKIRAAN', 18, 2)->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->text('RINGKASAN')->nullable();
                    $table->string('KAK', 255)->nullable();
                    $table->string('ID_VENDOR', 255)->nullable();
                    $table->decimal('NILAI_PENAWARAN', 18, 2)->nullable();
                    $table->decimal('NILAI_KESEPAKATAN', 18, 2)->nullable();
                });

        Schema::create('NR_CSR.TBL_PEMBAYARAN', function (Blueprint $table) {
                    $table->bigInteger('ID_PEMBAYARAN');
                    $table->string('NO_AGENDA', 50)->nullable();
                    $table->string('NO_BAST', 50)->nullable();
                    $table->string('NO_BA', 50)->nullable();
                    $table->string('TERMIN', 2)->nullable();
                    $table->decimal('NILAI_APPROVED', 18, 2)->nullable();
                    $table->string('PERSEN', 3)->nullable();
                    $table->string('STATUS', 50)->nullable();
                    $table->string('PR_ID', 50)->nullable();
                    $table->timestamp('CREATE_DATE')->nullable();
                    $table->string('CREATE_BY', 50)->nullable();
                    $table->timestamp('EXPORT_DATE')->nullable();
                    $table->string('EXPORT_BY', 100)->nullable();
                    $table->bigInteger('ID_KELAYAKAN')->nullable();
                    $table->string('DESKRIPSI', 500)->nullable();
                    $table->decimal('FEE', 18, 2)->nullable();
                    $table->decimal('JUMLAH_PEMBAYARAN', 18, 2)->nullable();
                    $table->decimal('SUBTOTAL', 18, 2)->nullable();
                    $table->decimal('FEE_PERSEN', 18, 2)->nullable();
                    $table->string('STATUS_YKPP', 255)->nullable();
                    $table->string('APPROVED_YKPP_BY', 255)->nullable();
                    $table->timestamp('APPROVED_YKPP_DATE')->nullable();
                    $table->string('SUBMITED_YKPP_BY', 255)->nullable();
                    $table->timestamp('SUBMITED_YKPP_DATE')->nullable();
                    $table->string('NO_SURAT_YKPP', 255)->nullable();
                    $table->string('TGL_SURAT_YKPP', 255)->nullable();
                    $table->string('SURAT_YKPP', 255)->nullable();
                    $table->string('TAHUN_YKPP', 4)->nullable();
                    $table->string('PENYALURAN_KE', 255)->nullable();
                    $table->string('METODE', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_PEMBAYARAN_VENDOR', function (Blueprint $table) {
                    $table->bigInteger('ID_PEMBAYARAN');
                    $table->string('PEKERJAAN_ID', 50)->nullable();
                    $table->string('NO_BAST', 50)->nullable();
                    $table->string('NO_BA', 50)->nullable();
                    $table->string('TERMIN', 2)->nullable();
                    $table->decimal('NILAI_KESEPAKATAN', 18, 2)->nullable();
                    $table->string('PERSEN', 3)->nullable();
                    $table->string('JUMLAH_PEMBAYARAN', 255)->nullable();
                    $table->string('STATUS', 50)->nullable();
                    $table->string('PR_ID', 50)->nullable();
                    $table->timestamp('CREATE_DATE')->nullable();
                    $table->string('CREATE_BY', 50)->nullable();
                    $table->timestamp('EXPORT_DATE')->nullable();
                    $table->string('EXPORT_BY', 100)->nullable();
                    $table->string('ID_VENDOR', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_PEMBAYARAN_copy1', function (Blueprint $table) {
                    $table->bigInteger('ID_PEMBAYARAN');
                    $table->string('NO_AGENDA', 50)->nullable();
                    $table->string('NO_BAST', 50)->nullable();
                    $table->string('NO_BA', 50)->nullable();
                    $table->string('TERMIN', 2)->nullable();
                    $table->decimal('NILAI_APPROVED', 18, 2)->nullable();
                    $table->string('PERSEN', 3)->nullable();
                    $table->string('STATUS', 50)->nullable();
                    $table->string('PR_ID', 50)->nullable();
                    $table->timestamp('CREATE_DATE')->nullable();
                    $table->string('CREATE_BY', 50)->nullable();
                    $table->timestamp('EXPORT_DATE')->nullable();
                    $table->string('EXPORT_BY', 100)->nullable();
                    $table->bigInteger('ID_KELAYAKAN')->nullable();
                    $table->string('DESKRIPSI', 500)->nullable();
                    $table->decimal('FEE', 18, 2)->nullable();
                    $table->decimal('JUMLAH_PEMBAYARAN', 18, 2)->nullable();
                    $table->decimal('SUBTOTAL', 18, 2)->nullable();
                    $table->decimal('FEE_PERSEN', 18, 2)->nullable();
                    $table->string('STATUS_YKPP', 255)->nullable();
                    $table->string('APPROVED_YKPP_BY', 255)->nullable();
                    $table->timestamp('APPROVED_YKPP_DATE')->nullable();
                    $table->string('SUBMITED_YKPP_BY', 255)->nullable();
                    $table->timestamp('SUBMITED_YKPP_DATE')->nullable();
                    $table->string('NO_SURAT_YKPP', 255)->nullable();
                    $table->string('TGL_SURAT_YKPP', 255)->nullable();
                    $table->string('SURAT_YKPP', 255)->nullable();
                    $table->string('TAHUN_YKPP', 4)->nullable();
                    $table->string('PENYALURAN_KE', 255)->nullable();
                    $table->string('METODE', 255)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('NR_CSR.TBL_PEMBAYARAN_copy1');
        Schema::dropIfExists('NR_CSR.TBL_PEMBAYARAN_VENDOR');
        Schema::dropIfExists('NR_CSR.TBL_PEMBAYARAN');
        Schema::dropIfExists('NR_CSR.TBL_PEKERJAAN');
        Schema::dropIfExists('NR_CSR.TBL_PEJABAT');
        Schema::dropIfExists('NR_CSR.TBL_LOG_VENDOR');
        Schema::dropIfExists('NR_CSR.TBL_LOG_RELOKASI');
        Schema::dropIfExists('NR_CSR.TBL_LOG_PEKERJAAN');
        Schema::dropIfExists('NR_CSR.TBL_LOG');
        Schema::dropIfExists('NR_CSR.TBL_LEVEL_HIRARKI');
    }
}
