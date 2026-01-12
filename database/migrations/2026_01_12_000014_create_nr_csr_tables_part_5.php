<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart5 extends Migration
{
    public function up()
    {
        Schema::create('NR_CSR.TBL_PENGALAMAN_KERJA', function (Blueprint $table) {
                    $table->increments('PENGALAMAN_ID');
                    $table->string('ID_VENDOR', 255)->nullable();
                    $table->string('NO_KONTRAK', 255)->nullable();
                    $table->string('TGL_KONTRAK', 255)->nullable();
                    $table->string('PEKERJAAN', 255)->nullable();
                    $table->string('PEMBERI_KERJA', 255)->nullable();
                    $table->string('LOKASI', 255)->nullable();
                    $table->string('FILE', 255)->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->decimal('NILAI', 18, 2)->nullable();
                });

        Schema::create('NR_CSR.TBL_PENGEMBALIAN_ANGGARAN', function (Blueprint $table) {
                    $table->increments('ID');
                    $table->decimal('ANGGARAN_ID', 18, 2)->nullable();
                    $table->string('PENGEMBALIAN', 255)->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                });

        Schema::create('NR_CSR.TBL_PENGIRIM', function (Blueprint $table) {
                    $table->increments('ID_PENGIRIM');
                    $table->string('PENGIRIM', 50)->nullable();
                    $table->timestamp('CREATED_AT')->nullable();
                    $table->timestamp('UPDATED_AT')->nullable();
                    $table->string('PERUSAHAAN', 100)->nullable();
                    $table->decimal('ID_PERUSAHAAN', 18, 2)->nullable();
                    $table->string('STATUS', 10)->nullable();
                });

        Schema::create('NR_CSR.TBL_PERUSAHAAN', function (Blueprint $table) {
                    $table->increments('ID_PERUSAHAAN');
                    $table->string('NAMA_PERUSAHAAN', 100)->nullable();
                    $table->string('KATEGORI', 20)->nullable();
                    $table->string('KODE', 10)->nullable();
                    $table->string('FOTO_PROFILE', 255)->nullable();
                    $table->string('ALAMAT', 500)->nullable();
                    $table->string('NO_TELP', 15)->nullable();
                    $table->decimal('PIC', 18, 2)->nullable();
                    $table->string('STATUS', 20)->nullable();
                });

        Schema::create('NR_CSR.TBL_PILAR', function (Blueprint $table) {
                    $table->bigIncrements('ID_PILAR');
                    $table->string('KODE', 255)->nullable();
                    $table->string('NAMA', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_PROKER', function (Blueprint $table) {
                    $table->increments('ID_PROKER');
                    $table->string('PROKER', 1000)->nullable();
                    $table->string('ID_INDIKATOR', 100)->nullable();
                    $table->string('TAHUN', 4)->nullable();
                    $table->decimal('ANGGARAN', 18, 2)->nullable();
                    $table->string('PRIORITAS', 255)->nullable();
                    $table->string('EB', 255)->nullable();
                    $table->string('PILAR', 255)->nullable();
                    $table->string('GOLS', 255)->nullable();
                    $table->string('PERUSAHAAN', 255)->nullable();
                    $table->decimal('ID_PERUSAHAAN', 18, 2)->nullable();
                    $table->string('KODE_TPB', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_PROVINSI', function (Blueprint $table) {
                    $table->bigInteger('ID_PROVINSI');
                    $table->string('KODE_PROVINSI', 10)->nullable();
                    $table->string('PROVINSI', 100)->nullable();
                });

        Schema::create('NR_CSR.TBL_REALISASI_AP', function (Blueprint $table) {
                    $table->bigIncrements('ID_REALISASI');
                    $table->string('NO_PROPOSAL', 255)->nullable();
                    $table->timestamp('TGL_PROPOSAL')->nullable();
                    $table->string('PENGIRIM', 255)->nullable();
                    $table->timestamp('TGL_REALISASI')->nullable();
                    $table->string('SIFAT', 255)->nullable();
                    $table->string('PERIHAL', 255)->nullable();
                    $table->bigInteger('BESAR_PERMOHONAN')->nullable();
                    $table->string('KATEGORI', 255)->nullable();
                    $table->bigInteger('NILAI_BANTUAN')->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->string('PROVINSI', 255)->nullable();
                    $table->string('KABUPATEN', 255)->nullable();
                    $table->string('DESKRIPSI', 255)->nullable();
                    $table->bigInteger('ID_PROKER')->nullable();
                    $table->string('PROKER', 255)->nullable();
                    $table->string('PILAR', 255)->nullable();
                    $table->string('GOLS', 255)->nullable();
                    $table->string('NAMA_YAYASAN', 255)->nullable();
                    $table->string('ALAMAT', 255)->nullable();
                    $table->string('PIC', 255)->nullable();
                    $table->string('JABATAN', 255)->nullable();
                    $table->string('NO_TELP', 255)->nullable();
                    $table->string('NO_REKENING', 255)->nullable();
                    $table->string('ATAS_NAMA', 255)->nullable();
                    $table->string('NAMA_BANK', 255)->nullable();
                    $table->string('KOTA_BANK', 255)->nullable();
                    $table->string('CABANG_BANK', 255)->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->string('JENIS', 255)->nullable();
                    $table->string('PERUSAHAAN', 255)->nullable();
                    $table->string('TAHUN', 4)->nullable();
                    $table->timestamp('STATUS_DATE')->nullable();
                    $table->string('PRIORITAS', 255)->nullable();
                    $table->bigInteger('ID_PERUSAHAAN')->nullable();
                    $table->string('KECAMATAN', 255)->nullable();
                    $table->string('KELURAHAN', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_RELOKASI', function (Blueprint $table) {
                    $table->increments('ID_RELOKASI');
                    $table->string('PROKER_ASAL', 255)->nullable();
                    $table->decimal('NOMINAL_ASAL', 18, 2)->nullable();
                    $table->string('PROKER_TUJUAN', 255)->nullable();
                    $table->decimal('NOMINAL_TUJUAN', 18, 2)->nullable();
                    $table->string('REQUEST_BY', 255)->nullable();
                    $table->timestamp('REQUEST_DATE')->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->string('APPROVER', 255)->nullable();
                    $table->string('TAHUN', 4)->nullable();
                    $table->string('PERUSAHAAN', 255)->nullable();
                    $table->timestamp('STATUS_DATE')->nullable();
                    $table->decimal('NOMINAL_RELOKASI', 18, 2)->nullable();
                    $table->decimal('ID_PERUSAHAAN', 18, 2)->nullable();
                });

        Schema::create('NR_CSR.TBL_ROLE', function (Blueprint $table) {
                    $table->bigInteger('ID_ROLE');
                    $table->string('ROLE', 2);
                    $table->string('ROLE_NAME', 30)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('NR_CSR.TBL_ROLE');
        Schema::dropIfExists('NR_CSR.TBL_RELOKASI');
        Schema::dropIfExists('NR_CSR.TBL_REALISASI_AP');
        Schema::dropIfExists('NR_CSR.TBL_PROVINSI');
        Schema::dropIfExists('NR_CSR.TBL_PROKER');
        Schema::dropIfExists('NR_CSR.TBL_PILAR');
        Schema::dropIfExists('NR_CSR.TBL_PERUSAHAAN');
        Schema::dropIfExists('NR_CSR.TBL_PENGIRIM');
        Schema::dropIfExists('NR_CSR.TBL_PENGEMBALIAN_ANGGARAN');
        Schema::dropIfExists('NR_CSR.TBL_PENGALAMAN_KERJA');
    }
}
