<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart5 extends Migration
{
    public function up()
    {
        Schema::create('nr_csr.tbl_pengalaman_kerja', function (Blueprint $table) {
                    $table->increments('pengalaman_id');
                    $table->string('id_vendor', 255)->nullable();
                    $table->string('no_kontrak', 255)->nullable();
                    $table->string('tgl_kontrak', 255)->nullable();
                    $table->string('pekerjaan', 255)->nullable();
                    $table->string('pemberi_kerja', 255)->nullable();
                    $table->string('lokasi', 255)->nullable();
                    $table->string('file', 255)->nullable();
                    $table->string('created_by', 255)->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->decimal('nilai', 18, 2)->nullable();
                });

        Schema::create('nr_csr.tbl_pengembalian_anggaran', function (Blueprint $table) {
                    $table->increments('id');
                    $table->decimal('anggaran_id', 18, 2)->nullable();
                    $table->string('pengembalian', 255)->nullable();
                    $table->string('created_by', 255)->nullable();
                    $table->timestamp('created_date')->nullable();
                });

        Schema::create('nr_csr.tbl_pengirim', function (Blueprint $table) {
                    $table->increments('id_pengirim');
                    $table->string('pengirim', 50)->nullable();
                    $table->timestamp('created_at')->nullable();
                    $table->timestamp('updated_at')->nullable();
                    $table->string('perusahaan', 100)->nullable();
                    $table->decimal('id_perusahaan', 18, 2)->nullable();
                    $table->string('status', 10)->nullable();
                });

        Schema::create('nr_csr.tbl_perusahaan', function (Blueprint $table) {
                    $table->increments('id_perusahaan');
                    $table->string('nama_perusahaan', 100)->nullable();
                    $table->string('kategori', 20)->nullable();
                    $table->string('kode', 10)->nullable();
                    $table->string('foto_profile', 255)->nullable();
                    $table->string('alamat', 500)->nullable();
                    $table->string('no_telp', 15)->nullable();
                    $table->decimal('pic', 18, 2)->nullable();
                    $table->string('status', 20)->nullable();
                });

        Schema::create('nr_csr.tbl_pilar', function (Blueprint $table) {
                    $table->bigIncrements('id_pilar');
                    $table->string('kode', 255)->nullable();
                    $table->string('nama', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_proker', function (Blueprint $table) {
                    $table->increments('id_proker');
                    $table->string('proker', 1000)->nullable();
                    $table->string('id_indikator', 100)->nullable();
                    $table->string('tahun', 4)->nullable();
                    $table->decimal('anggaran', 18, 2)->nullable();
                    $table->string('prioritas', 255)->nullable();
                    $table->string('eb', 255)->nullable();
                    $table->string('pilar', 255)->nullable();
                    $table->string('gols', 255)->nullable();
                    $table->string('perusahaan', 255)->nullable();
                    $table->decimal('id_perusahaan', 18, 2)->nullable();
                    $table->string('kode_tpb', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_provinsi', function (Blueprint $table) {
                    $table->bigInteger('id_provinsi');
                    $table->string('kode_provinsi', 10)->nullable();
                    $table->string('provinsi', 100)->nullable();
                });

        Schema::create('nr_csr.tbl_realisasi_ap', function (Blueprint $table) {
                    $table->bigIncrements('id_realisasi');
                    $table->string('no_proposal', 255)->nullable();
                    $table->timestamp('tgl_proposal')->nullable();
                    $table->string('pengirim', 255)->nullable();
                    $table->timestamp('tgl_realisasi')->nullable();
                    $table->string('sifat', 255)->nullable();
                    $table->string('perihal', 255)->nullable();
                    $table->bigInteger('besar_permohonan')->nullable();
                    $table->string('kategori', 255)->nullable();
                    $table->bigInteger('nilai_bantuan')->nullable();
                    $table->string('status', 255)->nullable();
                    $table->string('provinsi', 255)->nullable();
                    $table->string('kabupaten', 255)->nullable();
                    $table->string('deskripsi', 255)->nullable();
                    $table->bigInteger('id_proker')->nullable();
                    $table->string('proker', 255)->nullable();
                    $table->string('pilar', 255)->nullable();
                    $table->string('gols', 255)->nullable();
                    $table->string('nama_yayasan', 255)->nullable();
                    $table->string('alamat', 255)->nullable();
                    $table->string('pic', 255)->nullable();
                    $table->string('jabatan', 255)->nullable();
                    $table->string('no_telp', 255)->nullable();
                    $table->string('no_rekening', 255)->nullable();
                    $table->string('atas_nama', 255)->nullable();
                    $table->string('nama_bank', 255)->nullable();
                    $table->string('kota_bank', 255)->nullable();
                    $table->string('cabang_bank', 255)->nullable();
                    $table->string('created_by', 255)->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->string('jenis', 255)->nullable();
                    $table->string('perusahaan', 255)->nullable();
                    $table->string('tahun', 4)->nullable();
                    $table->timestamp('status_date')->nullable();
                    $table->string('prioritas', 255)->nullable();
                    $table->bigInteger('id_perusahaan')->nullable();
                    $table->string('kecamatan', 255)->nullable();
                    $table->string('kelurahan', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_relokasi', function (Blueprint $table) {
                    $table->increments('id_relokasi');
                    $table->string('proker_asal', 255)->nullable();
                    $table->decimal('nominal_asal', 18, 2)->nullable();
                    $table->string('proker_tujuan', 255)->nullable();
                    $table->decimal('nominal_tujuan', 18, 2)->nullable();
                    $table->string('request_by', 255)->nullable();
                    $table->timestamp('request_date')->nullable();
                    $table->string('status', 255)->nullable();
                    $table->string('approver', 255)->nullable();
                    $table->string('tahun', 4)->nullable();
                    $table->string('perusahaan', 255)->nullable();
                    $table->timestamp('status_date')->nullable();
                    $table->decimal('nominal_relokasi', 18, 2)->nullable();
                    $table->decimal('id_perusahaan', 18, 2)->nullable();
                });

        Schema::create('nr_csr.tbl_role', function (Blueprint $table) {
                    $table->bigInteger('id_role');
                    $table->string('role', 2);
                    $table->string('role_name', 30)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('nr_csr.tbl_role');
        Schema::dropIfExists('nr_csr.tbl_relokasi');
        Schema::dropIfExists('nr_csr.tbl_realisasi_ap');
        Schema::dropIfExists('nr_csr.tbl_provinsi');
        Schema::dropIfExists('nr_csr.tbl_proker');
        Schema::dropIfExists('nr_csr.tbl_pilar');
        Schema::dropIfExists('nr_csr.tbl_perusahaan');
        Schema::dropIfExists('nr_csr.tbl_pengirim');
        Schema::dropIfExists('nr_csr.tbl_pengembalian_anggaran');
        Schema::dropIfExists('nr_csr.tbl_pengalaman_kerja');
    }
}
