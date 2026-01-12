<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart6 extends Migration
{
    public function up()
    {
        Schema::create('NR_CSR.TBL_SDG', function (Blueprint $table) {
                    $table->bigIncrements('ID_SDG');
                    $table->string('NAMA', 255)->nullable();
                    $table->string('KODE', 255)->nullable();
                    $table->string('PILAR', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_SEKTOR', function (Blueprint $table) {
                    $table->bigIncrements('ID_SEKTOR');
                    $table->string('KODE_SEKTOR', 10)->nullable();
                    $table->string('SEKTOR_BANTUAN', 100)->nullable();
                });

        Schema::create('NR_CSR.TBL_SPH', function (Blueprint $table) {
                    $table->increments('SPH_ID');
                    $table->string('NOMOR', 255)->nullable();
                    $table->string('TANGGAL', 255)->nullable();
                    $table->decimal('PEKERJAAN_ID', 18, 2)->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->string('CATATAN', 255)->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->string('ID_VENDOR', 255)->nullable();
                    $table->string('FILE_SPH', 255)->nullable();
                    $table->decimal('NILAI_PENAWARAN', 18, 2)->nullable();
                    $table->decimal('SPPH_ID', 18, 2)->nullable();
                });

        Schema::create('NR_CSR.TBL_SPK', function (Blueprint $table) {
                    $table->increments('SPK_ID');
                    $table->string('NOMOR', 255)->nullable();
                    $table->string('TANGGAL', 255)->nullable();
                    $table->decimal('PEKERJAAN_ID', 18, 2)->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->string('CATATAN', 255)->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->string('ID_VENDOR', 255)->nullable();
                    $table->string('FILE_SPK', 255)->nullable();
                    $table->decimal('NILAI_KESEPAKATAN', 18, 2)->nullable();
                    $table->decimal('SPH_ID', 18, 2)->nullable();
                    $table->decimal('BAKN_ID', 18, 2)->nullable();
                    $table->timestamp('START_DATE')->nullable();
                    $table->timestamp('DUE_DATE')->nullable();
                    $table->decimal('DURASI', 18, 2)->nullable();
                    $table->timestamp('RESPONSE_DATE')->nullable();
                    $table->string('RESPONSE_BY', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_SPPH', function (Blueprint $table) {
                    $table->increments('SPPH_ID');
                    $table->string('NOMOR', 255)->nullable();
                    $table->timestamp('TANGGAL')->nullable();
                    $table->decimal('PEKERJAAN_ID', 18, 2)->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->string('CATATAN', 255)->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->string('ID_VENDOR', 255)->nullable();
                    $table->string('FILE_SPPH', 255)->nullable();
                    $table->timestamp('RESPONSE_DATE')->nullable();
                });

        Schema::create('NR_CSR.TBL_SUB_PILAR', function (Blueprint $table) {
                    $table->bigIncrements('ID_SUB_PILAR');
                    $table->string('TPB', 255)->nullable();
                    $table->string('KODE_INDIKATOR', 255)->nullable();
                    $table->string('KETERANGAN', 1000)->nullable();
                    $table->string('PILAR', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_SUB_PROPOSAL', function (Blueprint $table) {
                    $table->increments('ID_SUB_PROPOSAL');
                    $table->string('NO_AGENDA', 50)->nullable();
                    $table->string('NO_SUB_AGENDA', 255)->nullable();
                    $table->string('NAMA_KETUA', 255)->nullable();
                    $table->string('NAMA_LEMBAGA', 255)->nullable();
                    $table->bigInteger('KAMBING')->nullable();
                    $table->bigInteger('SAPI')->nullable();
                    $table->bigInteger('TOTAL')->nullable();
                    $table->bigInteger('HARGA_KAMBING')->nullable();
                    $table->bigInteger('HARGA_SAPI')->nullable();
                    $table->string('PROVINSI', 255)->nullable();
                    $table->string('KABUPATEN', 255)->nullable();
                    $table->string('ALAMAT', 255)->nullable();
                    $table->bigInteger('FEE')->nullable();
                    $table->bigInteger('SUBTOTAL')->nullable();
                    $table->bigInteger('PPN')->nullable();
                });

        Schema::create('NR_CSR.TBL_SURVEI', function (Blueprint $table) {
                    $table->bigInteger('ID_SURVEI');
                    $table->string('NO_AGENDA', 50)->nullable();
                    $table->text('HASIL_KONFIRMASI')->nullable();
                    $table->text('HASIL_SURVEI')->nullable();
                    $table->string('USULAN', 50)->nullable();
                    $table->string('BANTUAN_BERUPA', 50)->nullable();
                    $table->decimal('NILAI_BANTUAN', 38, 0)->nullable();
                    $table->decimal('NILAI_APPROVED', 38, 0)->nullable();
                    $table->string('TERMIN', 20)->nullable();
                    $table->decimal('RUPIAH1', 38, 0)->nullable();
                    $table->decimal('RUPIAH2', 38, 0)->nullable();
                    $table->decimal('RUPIAH3', 38, 0)->nullable();
                    $table->decimal('RUPIAH4', 38, 0)->nullable();
                    $table->string('SURVEI1', 50)->nullable();
                    $table->string('SURVEI2', 50)->nullable();
                    $table->string('STATUS', 20)->nullable();
                    $table->string('KADEP', 50)->nullable();
                    $table->string('KADIV', 50)->nullable();
                    $table->text('KET_KADIN1')->nullable();
                    $table->text('KET_KADIN2')->nullable();
                    $table->text('KET_KADIV')->nullable();
                    $table->text('KETERANGAN')->nullable();
                    $table->timestamp('APPROVE_DATE')->nullable();
                    $table->timestamp('APPROVE_KADEP')->nullable();
                    $table->timestamp('APPROVE_KADIV')->nullable();
                    $table->string('CREATE_BY', 50)->nullable();
                    $table->timestamp('CREATE_DATE')->nullable();
                    $table->string('REVISI_BY', 50)->nullable();
                    $table->timestamp('REVISI_DATE')->nullable();
                    $table->timestamp('CREATED_AT')->nullable();
                    $table->timestamp('UPDATED_AT')->nullable();
                    $table->string('BAST', 20)->nullable();
                    $table->string('SPK', 20)->nullable();
                    $table->string('PKS', 20)->nullable();
                    $table->decimal('VENDOR_ID', 18, 2)->nullable();
                    $table->decimal('ID_KELAYAKAN', 18, 2)->nullable();
                    $table->decimal('CREATED_BY', 18, 2)->nullable();
                    $table->string('SEKPER', 255)->nullable();
                    $table->string('DIRUT', 255)->nullable();
                    $table->string('KET_SEKPER', 255)->nullable();
                    $table->string('KET_DIRUT', 255)->nullable();
                    $table->timestamp('APPROVE_SEKPER')->nullable();
                    $table->timestamp('APPROVE_DIRUT')->nullable();
                    $table->decimal('PERSEN1', 10, 2)->nullable();
                    $table->decimal('PERSEN2', 10, 2)->nullable();
                    $table->decimal('PERSEN3', 10, 2)->nullable();
                    $table->decimal('PERSEN4', 10, 2)->nullable();
                });

        Schema::create('NR_CSR.TBL_USER', function (Blueprint $table) {
                    $table->increments('ID_USER');
                    $table->string('USERNAME', 100);
                    $table->string('EMAIL', 100);
                    $table->string('NAMA', 100);
                    $table->string('JABATAN', 100);
                    $table->string('PASSWORD', 200);
                    $table->string('ROLE', 100);
                    $table->string('AREA_KERJA', 100)->nullable();
                    $table->string('STATUS', 100)->nullable();
                    $table->string('FOTO_PROFILE', 255)->nullable();
                    $table->string('REMEMBER_TOKEN', 100)->nullable();
                    $table->string('JK', 100)->nullable();
                    $table->string('OLD_EMAIL', 255)->nullable();
                    $table->string('PERUSAHAAN', 255)->nullable();
                    $table->string('VENDOR_ID', 255)->nullable();
                    $table->decimal('ID_PERUSAHAAN', 18, 2)->nullable();
                    $table->string('NO_SK', 255)->nullable();
                    $table->timestamp('TGL_SK')->nullable();
                });

        Schema::create('NR_CSR.TBL_VENDOR', function (Blueprint $table) {
                    $table->increments('VENDOR_ID');
                    $table->string('NAMA_PERUSAHAAN', 200)->nullable();
                    $table->string('ALAMAT', 500)->nullable();
                    $table->string('NO_TELP', 20)->nullable();
                    $table->string('EMAIL', 100)->nullable();
                    $table->string('WEBSITE', 50)->nullable();
                    $table->string('NO_KTP', 50)->nullable();
                    $table->string('NAMA_PIC', 100)->nullable();
                    $table->string('JABATAN', 100)->nullable();
                    $table->string('EMAIL_PIC', 100)->nullable();
                    $table->string('NO_HP', 20)->nullable();
                    $table->string('FILE_KTP', 200)->nullable();
                    $table->timestamp('CREATED_AT')->nullable();
                    $table->timestamp('UPDATED_AT')->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->string('APPROVE_BY', 255)->nullable();
                    $table->timestamp('APPROVE_DATE')->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('NR_CSR.TBL_VENDOR');
        Schema::dropIfExists('NR_CSR.TBL_USER');
        Schema::dropIfExists('NR_CSR.TBL_SURVEI');
        Schema::dropIfExists('NR_CSR.TBL_SUB_PROPOSAL');
        Schema::dropIfExists('NR_CSR.TBL_SUB_PILAR');
        Schema::dropIfExists('NR_CSR.TBL_SPPH');
        Schema::dropIfExists('NR_CSR.TBL_SPK');
        Schema::dropIfExists('NR_CSR.TBL_SPH');
        Schema::dropIfExists('NR_CSR.TBL_SEKTOR');
        Schema::dropIfExists('NR_CSR.TBL_SDG');
    }
}
