<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart1 extends Migration
{
    public function up()
    {
        Schema::create('NR_CSR.NO_AGENDA', function (Blueprint $table) {
                    $table->integer('TAHUN');
                    $table->decimal('LAST_NO', 18, 2);
                });

        Schema::create('NR_CSR.TBL_ALOKASI', function (Blueprint $table) {
                    $table->decimal('ID_ALOKASI', 18, 2)->nullable();
                    $table->decimal('ID_RELOKASI', 18, 2)->nullable();
                    $table->string('PROKER', 200)->nullable();
                    $table->string('PROVINSI', 100)->nullable();
                    $table->string('TAHUN', 4)->nullable();
                    $table->decimal('NOMINAL_ALOKASI', 18, 2)->nullable();
                    $table->string('SEKTOR_BANTUAN', 100)->nullable();
                });

        Schema::create('NR_CSR.TBL_ANGGARAN', function (Blueprint $table) {
                    $table->increments('ID_ANGGARAN');
                    $table->decimal('NOMINAL', 18, 2)->nullable();
                    $table->string('TAHUN', 4)->nullable();
                    $table->string('PERUSAHAAN_OLD', 255)->nullable();
                    $table->decimal('ID_PERUSAHAAN', 18, 2)->nullable();
                    $table->string('PERUSAHAAN', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_ANGGOTA', function (Blueprint $table) {
                    $table->increments('ID_ANGGOTA');
                    $table->string('NAMA_ANGGOTA', 100)->nullable();
                    $table->string('FRAKSI', 150)->nullable();
                    $table->string('KOMISI', 10)->nullable();
                    $table->string('JABATAN', 100)->nullable();
                    $table->string('STAF_AHLI', 100)->nullable();
                    $table->string('NO_TELP', 20)->nullable();
                    $table->string('FOTO_PROFILE', 255)->nullable();
                    $table->string('STATUS', 10)->nullable();
                });

        Schema::create('NR_CSR.TBL_AREA', function (Blueprint $table) {
                    $table->bigInteger('ID_AREA');
                    $table->string('AREA_KERJA', 50)->nullable();
                    $table->timestamp('CREATED_AT')->nullable();
                    $table->timestamp('UPDATED_AT')->nullable();
                });

        Schema::create('NR_CSR.TBL_ASSESSMENT_VENDOR', function (Blueprint $table) {
                    $table->increments('ASSESSMENT_ID');
                    $table->string('TANGGAL', 255)->nullable();
                    $table->string('ID_VENDOR', 255)->nullable();
                    $table->string('TAHUN', 255)->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                });

        Schema::create('NR_CSR.TBL_BAKN', function (Blueprint $table) {
                    $table->increments('BAKN_ID');
                    $table->string('NOMOR', 255)->nullable();
                    $table->string('TANGGAL', 255)->nullable();
                    $table->decimal('PEKERJAAN_ID', 18, 2)->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->string('CATATAN', 255)->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->string('ID_VENDOR', 255)->nullable();
                    $table->string('FILE_BAKN', 255)->nullable();
                    $table->decimal('NILAI_KESEPAKATAN', 18, 2)->nullable();
                    $table->decimal('SPH_ID', 18, 2)->nullable();
                    $table->timestamp('RESPONSE_DATE')->nullable();
                    $table->string('RESPONSE_BY', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_BANK', function (Blueprint $table) {
                    $table->increments('BANK_ID');
                    $table->string('NAMA_BANK', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_BAST_DANA', function (Blueprint $table) {
                    $table->increments('ID_BAST_DANA');
                    $table->string('NO_AGENDA', 50)->nullable();
                    $table->string('PILAR', 100)->nullable();
                    $table->string('BANTUAN_UNTUK', 300)->nullable();
                    $table->string('PROPOSAL_DARI', 100)->nullable();
                    $table->string('ALAMAT', 500)->nullable();
                    $table->string('PROVINSI', 50)->nullable();
                    $table->string('KABUPATEN', 50)->nullable();
                    $table->string('PENANGGUNG_JAWAB', 50)->nullable();
                    $table->string('BERTINDAK_SEBAGAI', 100)->nullable();
                    $table->string('NO_SURAT', 50)->nullable();
                    $table->timestamp('TGL_SURAT')->nullable();
                    $table->string('PERIHAL', 100)->nullable();
                    $table->string('NAMA_BANK', 50)->nullable();
                    $table->string('NO_REKENING', 50)->nullable();
                    $table->string('ATAS_NAMA', 100)->nullable();
                    $table->string('NO_BAST_DANA', 50)->nullable();
                    $table->string('CREATED_BY', 50)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->string('NO_BAST_PIHAK_KEDUA', 100)->nullable();
                    $table->timestamp('TGL_BAST')->nullable();
                    $table->string('NAMA_PEJABAT', 100)->nullable();
                    $table->string('JABATAN_PEJABAT', 100)->nullable();
                    $table->string('NAMA_BARANG', 100)->nullable();
                    $table->decimal('JUMLAH_BARANG', 18, 2)->nullable();
                    $table->string('SATUAN_BARANG', 20)->nullable();
                    $table->string('NO_PELIMPAHAN', 100)->nullable();
                    $table->timestamp('TGL_PELIMPAHAN')->nullable();
                    $table->string('PIHAK_KEDUA', 500)->nullable();
                    $table->string('STATUS', 50)->nullable();
                    $table->string('APPROVED_BY', 50)->nullable();
                    $table->timestamp('APPROVED_DATE')->nullable();
                    $table->string('DESKRIPSI', 500)->nullable();
                    $table->decimal('ID_KELAYAKAN', 18, 2)->nullable();
                    $table->decimal('APPROVER_ID', 18, 2)->nullable();
                });

        Schema::create('NR_CSR.TBL_CITY', function (Blueprint $table) {
                    $table->bigInteger('ID_CITY');
                    $table->string('CITY_NAME', 255)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('NR_CSR.TBL_CITY');
        Schema::dropIfExists('NR_CSR.TBL_BAST_DANA');
        Schema::dropIfExists('NR_CSR.TBL_BANK');
        Schema::dropIfExists('NR_CSR.TBL_BAKN');
        Schema::dropIfExists('NR_CSR.TBL_ASSESSMENT_VENDOR');
        Schema::dropIfExists('NR_CSR.TBL_AREA');
        Schema::dropIfExists('NR_CSR.TBL_ANGGOTA');
        Schema::dropIfExists('NR_CSR.TBL_ANGGARAN');
        Schema::dropIfExists('NR_CSR.TBL_ALOKASI');
        Schema::dropIfExists('NR_CSR.NO_AGENDA');
    }
}
