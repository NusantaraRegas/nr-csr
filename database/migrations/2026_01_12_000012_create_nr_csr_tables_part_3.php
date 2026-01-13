<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart3 extends Migration
{
    public function up()
    {
        Schema::create('nr_csr.tbl_izin_usaha', function (Blueprint $table) {
                    $table->increments('izin_usaha_id');
                    $table->string('id_vendor', 255)->nullable();
                    $table->string('nib', 255)->nullable();
                    $table->string('jenis_kbli', 255)->nullable();
                    $table->string('kode_kbli', 255)->nullable();
                    $table->string('alamat', 255)->nullable();
                    $table->string('file', 255)->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->string('created_by', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_kebijakan', function (Blueprint $table) {
                    $table->increments('id_kebijakan');
                    $table->string('kebijakan', 200)->nullable();
                });

        Schema::create('nr_csr.tbl_kelayakan', function (Blueprint $table) {
                    $table->string('no_agenda', 50)->nullable();
                    $table->timestamp('tgl_terima')->nullable();
                    $table->string('no_surat', 100)->nullable();
                    $table->timestamp('tgl_surat')->nullable();
                    $table->string('sebagai', 100)->nullable()->default('');
                    $table->string('provinsi', 100)->nullable();
                    $table->string('kabupaten', 100)->nullable();
                    $table->string('kelurahan', 100)->nullable();
                    $table->string('kodepos', 10)->nullable();
                    $table->string('bantuan_untuk', 200)->nullable();
                    $table->string('contact_person', 100)->nullable();
                    $table->decimal('nilai_pengajuan', 38, 0)->nullable();
                    $table->string('sektor_bantuan', 100)->nullable();
                    $table->string('nama_bank', 50)->nullable();
                    $table->string('atas_nama', 150)->nullable();
                    $table->string('no_rekening', 50)->nullable();
                    $table->decimal('nilai_bantuan', 38, 0)->nullable();
                    $table->string('nama_anggota', 50)->nullable();
                    $table->string('fraksi', 255)->nullable();
                    $table->string('jabatan', 200)->nullable();
                    $table->string('pic', 255)->nullable();
                    $table->string('asal_surat', 100)->nullable();
                    $table->string('komisi', 100)->nullable();
                    $table->string('sifat', 20)->nullable();
                    $table->string('status', 50)->nullable();
                    $table->string('email_pengaju', 50)->nullable();
                    $table->string('nama_person', 50)->nullable();
                    $table->string('mata_uang_pengajuan', 20)->nullable();
                    $table->string('mata_uang_bantuan', 20)->nullable();
                    $table->string('proposal', 255)->nullable();
                    $table->string('create_by', 50)->nullable();
                    $table->timestamp('create_date')->nullable();
                    $table->string('pengirim', 200)->nullable();
                    $table->string('perihal', 200)->nullable();
                    $table->string('pengaju_proposal', 200)->nullable();
                    $table->string('alamat', 400)->nullable();
                    $table->string('cabang_bank', 150)->nullable();
                    $table->string('jenis', 255)->nullable();
                    $table->string('hewan_kurban', 255)->nullable();
                    $table->bigInteger('jumlah_hewan')->nullable();
                    $table->string('kode_bank', 255)->nullable();
                    $table->string('kode_kota', 255)->nullable();
                    $table->string('kota_bank', 255)->nullable();
                    $table->string('cabang', 255)->nullable();
                    $table->string('deskripsi', 500)->nullable();
                    $table->string('pilar', 255)->nullable();
                    $table->string('tpb', 255)->nullable();
                    $table->string('kode_indikator', 255)->nullable();
                    $table->string('keterangan_indikator', 1000)->nullable();
                    $table->string('proker', 255)->nullable();
                    $table->string('indikator', 255)->nullable();
                    $table->string('smap', 255)->nullable();
                    $table->string('ykpp', 255)->nullable();
                    $table->string('checklist_by', 255)->nullable();
                    $table->timestamp('checklist_date')->nullable();
                    $table->bigInteger('nominal_approved')->nullable();
                    $table->bigInteger('nominal_fee')->nullable();
                    $table->bigInteger('total_ykpp')->nullable();
                    $table->string('status_ykpp', 255)->nullable();
                    $table->string('approved_ykpp_by', 255)->nullable();
                    $table->timestamp('approved_ykpp_date')->nullable();
                    $table->string('submited_ykpp_by', 255)->nullable();
                    $table->timestamp('submited_ykpp_date')->nullable();
                    $table->string('no_surat_ykpp', 255)->nullable();
                    $table->string('tgl_surat_ykpp', 255)->nullable();
                    $table->bigInteger('penyaluran_ke_old')->nullable();
                    $table->increments('id_kelayakan');
                    $table->string('surat_ykpp', 255)->nullable();
                    $table->string('tahun_ykpp', 4)->nullable();
                    $table->string('penyaluran_ke', 255)->nullable();
                    $table->decimal('id_lembaga', 18, 2)->nullable();
                    $table->decimal('id_pengirim', 18, 2)->nullable();
                    $table->decimal('created_by', 18, 2)->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->decimal('id_proker', 18, 2)->nullable();
                    $table->string('kecamatan', 100)->nullable()->default('');
                });

        Schema::create('nr_csr.tbl_kode', function (Blueprint $table) {
                    $table->string('kode', 20)->nullable();
                    $table->string('provinsi', 100)->nullable();
                });

        Schema::create('nr_csr.tbl_ktp_pengurus', function (Blueprint $table) {
                    $table->increments('ktp_id');
                    $table->string('id_vendor', 255)->nullable();
                    $table->string('nomor', 255)->nullable();
                    $table->string('nama', 255)->nullable();
                    $table->string('jabatan', 255)->nullable();
                    $table->string('no_telp', 255)->nullable();
                    $table->string('email', 255)->nullable();
                    $table->string('file', 255)->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->string('created_by', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_lampiran', function (Blueprint $table) {
                    $table->bigInteger('id_lampiran');
                    $table->string('no_agenda', 50)->nullable();
                    $table->string('nama', 255)->nullable();
                    $table->string('lampiran', 500)->nullable();
                    $table->string('upload_by', 50)->nullable();
                    $table->timestamp('upload_date')->nullable();
                    $table->timestamp('created_at')->nullable();
                    $table->timestamp('updated_at')->nullable();
                    $table->decimal('id_kelayakan', 18, 2)->nullable();
                    $table->decimal('created_by', 18, 2)->nullable();
                });

        Schema::create('nr_csr.tbl_lampiran_ap', function (Blueprint $table) {
                    $table->bigIncrements('id_lampiran');
                    $table->bigInteger('id_realisasi')->nullable();
                    $table->string('nama', 255)->nullable();
                    $table->string('lampiran', 255)->nullable();
                    $table->string('upload_by', 255)->nullable();
                    $table->timestamp('upload_date')->nullable();
                });

        Schema::create('nr_csr.tbl_lampiran_pekerjaan', function (Blueprint $table) {
                    $table->increments('lampiran_id');
                    $table->decimal('id_vendor', 18, 2)->nullable();
                    $table->string('nomor', 255)->nullable();
                    $table->string('nama_file', 255)->nullable();
                    $table->string('file', 255)->nullable();
                    $table->string('type', 255)->nullable();
                    $table->decimal('size', 18, 2)->nullable();
                    $table->string('status', 255)->nullable();
                    $table->string('catatan', 255)->nullable();
                    $table->string('upload_by', 255)->nullable();
                    $table->timestamp('upload_date')->nullable();
                    $table->string('nama_dokumen', 255)->nullable();
                    $table->decimal('pekerjaan_id', 18, 2)->nullable();
                });

        Schema::create('nr_csr.tbl_lampiran_vendor', function (Blueprint $table) {
                    $table->increments('lampiran_id');
                    $table->decimal('id_vendor', 18, 2)->nullable();
                    $table->string('nomor', 255)->nullable();
                    $table->string('nama_file', 255)->nullable();
                    $table->string('file', 255)->nullable();
                    $table->string('type', 255)->nullable();
                    $table->decimal('size', 18, 2)->nullable();
                    $table->string('status', 255)->nullable();
                    $table->string('catatan', 255)->nullable();
                    $table->string('upload_by', 255)->nullable();
                    $table->timestamp('upload_date')->nullable();
                    $table->string('nama_dokumen', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_lembaga', function (Blueprint $table) {
                    $table->increments('id_lembaga');
                    $table->string('nama_lembaga', 255)->nullable();
                    $table->string('nama_pic', 255)->nullable();
                    $table->string('alamat', 255)->nullable();
                    $table->string('no_telp', 255)->nullable();
                    $table->string('jabatan', 255)->nullable();
                    $table->string('no_rekening', 255)->nullable();
                    $table->string('atas_nama', 255)->nullable();
                    $table->string('nama_bank', 255)->nullable();
                    $table->string('cabang', 255)->nullable();
                    $table->string('kota_bank', 255)->nullable();
                    $table->string('kode_bank', 255)->nullable();
                    $table->string('kode_kota', 255)->nullable();
                    $table->string('perusahaan', 255)->nullable();
                    $table->decimal('id_perusahaan', 18, 2)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('nr_csr.tbl_lembaga');
        Schema::dropIfExists('nr_csr.tbl_lampiran_vendor');
        Schema::dropIfExists('nr_csr.tbl_lampiran_pekerjaan');
        Schema::dropIfExists('nr_csr.tbl_lampiran_ap');
        Schema::dropIfExists('nr_csr.tbl_lampiran');
        Schema::dropIfExists('nr_csr.tbl_ktp_pengurus');
        Schema::dropIfExists('nr_csr.tbl_kode');
        Schema::dropIfExists('nr_csr.tbl_kelayakan');
        Schema::dropIfExists('nr_csr.tbl_kebijakan');
        Schema::dropIfExists('nr_csr.tbl_izin_usaha');
    }
}
