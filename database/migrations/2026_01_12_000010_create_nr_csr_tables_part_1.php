<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart1 extends Migration
{
    public function up()
    {
        Schema::create('nr_csr.no_agenda', function (Blueprint $table) {
                    $table->integer('tahun');
                    $table->decimal('last_no', 18, 2);
                });

        Schema::create('nr_csr.tbl_alokasi', function (Blueprint $table) {
                    $table->decimal('id_alokasi', 18, 2)->nullable();
                    $table->decimal('id_relokasi', 18, 2)->nullable();
                    $table->string('proker', 200)->nullable();
                    $table->string('provinsi', 100)->nullable();
                    $table->string('tahun', 4)->nullable();
                    $table->decimal('nominal_alokasi', 18, 2)->nullable();
                    $table->string('sektor_bantuan', 100)->nullable();
                });

        Schema::create('nr_csr.tbl_anggaran', function (Blueprint $table) {
                    $table->increments('id_anggaran');
                    $table->decimal('nominal', 18, 2)->nullable();
                    $table->string('tahun', 4)->nullable();
                    $table->string('perusahaan_old', 255)->nullable();
                    $table->decimal('id_perusahaan', 18, 2)->nullable();
                    $table->string('perusahaan', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_anggota', function (Blueprint $table) {
                    $table->increments('id_anggota');
                    $table->string('nama_anggota', 100)->nullable();
                    $table->string('fraksi', 150)->nullable();
                    $table->string('komisi', 10)->nullable();
                    $table->string('jabatan', 100)->nullable();
                    $table->string('staf_ahli', 100)->nullable();
                    $table->string('no_telp', 20)->nullable();
                    $table->string('foto_profile', 255)->nullable();
                    $table->string('status', 10)->nullable();
                });

        Schema::create('nr_csr.tbl_area', function (Blueprint $table) {
                    $table->bigInteger('id_area');
                    $table->string('area_kerja', 50)->nullable();
                    $table->timestamp('created_at')->nullable();
                    $table->timestamp('updated_at')->nullable();
                });

        Schema::create('nr_csr.tbl_assessment_vendor', function (Blueprint $table) {
                    $table->increments('assessment_id');
                    $table->string('tanggal', 255)->nullable();
                    $table->string('id_vendor', 255)->nullable();
                    $table->string('tahun', 255)->nullable();
                    $table->string('created_by', 255)->nullable();
                    $table->timestamp('created_date')->nullable();
                });

        Schema::create('nr_csr.tbl_bakn', function (Blueprint $table) {
                    $table->increments('bakn_id');
                    $table->string('nomor', 255)->nullable();
                    $table->string('tanggal', 255)->nullable();
                    $table->decimal('pekerjaan_id', 18, 2)->nullable();
                    $table->string('status', 255)->nullable();
                    $table->string('catatan', 255)->nullable();
                    $table->string('created_by', 255)->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->string('id_vendor', 255)->nullable();
                    $table->string('file_bakn', 255)->nullable();
                    $table->decimal('nilai_kesepakatan', 18, 2)->nullable();
                    $table->decimal('sph_id', 18, 2)->nullable();
                    $table->timestamp('response_date')->nullable();
                    $table->string('response_by', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_bank', function (Blueprint $table) {
                    $table->increments('bank_id');
                    $table->string('nama_bank', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_bast_dana', function (Blueprint $table) {
                    $table->increments('id_bast_dana');
                    $table->string('no_agenda', 50)->nullable();
                    $table->string('pilar', 100)->nullable();
                    $table->string('bantuan_untuk', 300)->nullable();
                    $table->string('proposal_dari', 100)->nullable();
                    $table->string('alamat', 500)->nullable();
                    $table->string('provinsi', 50)->nullable();
                    $table->string('kabupaten', 50)->nullable();
                    $table->string('penanggung_jawab', 50)->nullable();
                    $table->string('bertindak_sebagai', 100)->nullable();
                    $table->string('no_surat', 50)->nullable();
                    $table->timestamp('tgl_surat')->nullable();
                    $table->string('perihal', 100)->nullable();
                    $table->string('nama_bank', 50)->nullable();
                    $table->string('no_rekening', 50)->nullable();
                    $table->string('atas_nama', 100)->nullable();
                    $table->string('no_bast_dana', 50)->nullable();
                    $table->string('created_by', 50)->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->string('no_bast_pihak_kedua', 100)->nullable();
                    $table->timestamp('tgl_bast')->nullable();
                    $table->string('nama_pejabat', 100)->nullable();
                    $table->string('jabatan_pejabat', 100)->nullable();
                    $table->string('nama_barang', 100)->nullable();
                    $table->decimal('jumlah_barang', 18, 2)->nullable();
                    $table->string('satuan_barang', 20)->nullable();
                    $table->string('no_pelimpahan', 100)->nullable();
                    $table->timestamp('tgl_pelimpahan')->nullable();
                    $table->string('pihak_kedua', 500)->nullable();
                    $table->string('status', 50)->nullable();
                    $table->string('approved_by', 50)->nullable();
                    $table->timestamp('approved_date')->nullable();
                    $table->string('deskripsi', 500)->nullable();
                    $table->decimal('id_kelayakan', 18, 2)->nullable();
                    $table->decimal('approver_id', 18, 2)->nullable();
                });

        Schema::create('nr_csr.tbl_city', function (Blueprint $table) {
                    $table->bigInteger('id_city');
                    $table->string('city_name', 255)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('nr_csr.tbl_city');
        Schema::dropIfExists('nr_csr.tbl_bast_dana');
        Schema::dropIfExists('nr_csr.tbl_bank');
        Schema::dropIfExists('nr_csr.tbl_bakn');
        Schema::dropIfExists('nr_csr.tbl_assessment_vendor');
        Schema::dropIfExists('nr_csr.tbl_area');
        Schema::dropIfExists('nr_csr.tbl_anggota');
        Schema::dropIfExists('nr_csr.tbl_anggaran');
        Schema::dropIfExists('nr_csr.tbl_alokasi');
        Schema::dropIfExists('nr_csr.no_agenda');
    }
}
