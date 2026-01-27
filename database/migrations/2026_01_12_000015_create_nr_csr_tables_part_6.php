<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart6 extends Migration
{
    public function up()
    {
        Schema::create('nr_csr.tbl_sdg', function (Blueprint $table) {
                    $table->bigIncrements('id_sdg');
                    $table->string('nama', 255)->nullable();
                    $table->string('kode', 255)->nullable();
                    $table->string('pilar', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_sektor', function (Blueprint $table) {
                    $table->bigIncrements('id_sektor');
                    $table->string('kode_sektor', 10)->nullable();
                    $table->string('sektor_bantuan', 100)->nullable();
                });

        Schema::create('nr_csr.tbl_sph', function (Blueprint $table) {
                    $table->increments('sph_id');
                    $table->string('nomor', 255)->nullable();
                    $table->string('tanggal', 255)->nullable();
                    $table->decimal('pekerjaan_id', 18, 2)->nullable();
                    $table->string('status', 255)->nullable();
                    $table->string('catatan', 255)->nullable();
                    $table->string('created_by', 255)->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->string('id_vendor', 255)->nullable();
                    $table->string('file_sph', 255)->nullable();
                    $table->decimal('nilai_penawaran', 18, 2)->nullable();
                    $table->decimal('spph_id', 18, 2)->nullable();
                });

        Schema::create('nr_csr.tbl_spk', function (Blueprint $table) {
                    $table->increments('spk_id');
                    $table->string('nomor', 255)->nullable();
                    $table->string('tanggal', 255)->nullable();
                    $table->decimal('pekerjaan_id', 18, 2)->nullable();
                    $table->string('status', 255)->nullable();
                    $table->string('catatan', 255)->nullable();
                    $table->string('created_by', 255)->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->string('id_vendor', 255)->nullable();
                    $table->string('file_spk', 255)->nullable();
                    $table->decimal('nilai_kesepakatan', 18, 2)->nullable();
                    $table->decimal('sph_id', 18, 2)->nullable();
                    $table->decimal('bakn_id', 18, 2)->nullable();
                    $table->timestamp('start_date')->nullable();
                    $table->timestamp('due_date')->nullable();
                    $table->decimal('durasi', 18, 2)->nullable();
                    $table->timestamp('response_date')->nullable();
                    $table->string('response_by', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_spph', function (Blueprint $table) {
                    $table->increments('spph_id');
                    $table->string('nomor', 255)->nullable();
                    $table->timestamp('tanggal')->nullable();
                    $table->decimal('pekerjaan_id', 18, 2)->nullable();
                    $table->string('status', 255)->nullable();
                    $table->string('catatan', 255)->nullable();
                    $table->string('created_by', 255)->nullable();
                    $table->timestamp('created_date')->nullable();
                    $table->string('id_vendor', 255)->nullable();
                    $table->string('file_spph', 255)->nullable();
                    $table->timestamp('response_date')->nullable();
                });

        Schema::create('nr_csr.tbl_sub_pilar', function (Blueprint $table) {
                    $table->bigIncrements('id_sub_pilar');
                    $table->string('tpb', 255)->nullable();
                    $table->string('kode_indikator', 255)->nullable();
                    $table->string('keterangan', 1000)->nullable();
                    $table->string('pilar', 255)->nullable();
                });

        Schema::create('nr_csr.tbl_sub_proposal', function (Blueprint $table) {
                    $table->increments('id_sub_proposal');
                    $table->string('no_agenda', 50)->nullable();
                    $table->string('no_sub_agenda', 255)->nullable();
                    $table->string('nama_ketua', 255)->nullable();
                    $table->string('nama_lembaga', 255)->nullable();
                    $table->bigInteger('kambing')->nullable();
                    $table->bigInteger('sapi')->nullable();
                    $table->bigInteger('total')->nullable();
                    $table->bigInteger('harga_kambing')->nullable();
                    $table->bigInteger('harga_sapi')->nullable();
                    $table->string('provinsi', 255)->nullable();
                    $table->string('kabupaten', 255)->nullable();
                    $table->string('alamat', 255)->nullable();
                    $table->bigInteger('fee')->nullable();
                    $table->bigInteger('subtotal')->nullable();
                    $table->bigInteger('ppn')->nullable();
                });

        Schema::create('nr_csr.tbl_survei', function (Blueprint $table) {
                    $table->bigInteger('id_survei');
                    $table->string('no_agenda', 50)->nullable();
                    $table->text('hasil_konfirmasi')->nullable();
                    $table->text('hasil_survei')->nullable();
                    $table->string('usulan', 50)->nullable();
                    $table->string('bantuan_berupa', 50)->nullable();
                    $table->decimal('nilai_bantuan', 38, 0)->nullable();
                    $table->decimal('nilai_approved', 38, 0)->nullable();
                    $table->string('termin', 20)->nullable();
                    $table->decimal('RUPIAH1', 38, 0)->nullable();
                    $table->decimal('RUPIAH2', 38, 0)->nullable();
                    $table->decimal('RUPIAH3', 38, 0)->nullable();
                    $table->decimal('RUPIAH4', 38, 0)->nullable();
                    $table->string('SURVEI1', 50)->nullable();
                    $table->string('SURVEI2', 50)->nullable();
                    $table->string('status', 20)->nullable();
                    $table->string('kadep', 50)->nullable();
                    $table->string('kadiv', 50)->nullable();
                    $table->text('KET_KADIN1')->nullable();
                    $table->text('KET_KADIN2')->nullable();
                    $table->text('ket_kadiv')->nullable();
                    $table->text('keterangan')->nullable();
                    $table->timestamp('approve_date')->nullable();
                    $table->timestamp('approve_kadep')->nullable();
                    $table->timestamp('approve_kadiv')->nullable();
                    $table->string('create_by', 50)->nullable();
                    $table->timestamp('create_date')->nullable();
                    $table->string('revisi_by', 50)->nullable();
                    $table->timestamp('revisi_date')->nullable();
                    $table->timestamp('created_at')->nullable();
                    $table->timestamp('updated_at')->nullable();
                    $table->string('bast', 20)->nullable();
                    $table->string('spk', 20)->nullable();
                    $table->string('pks', 20)->nullable();
                    $table->decimal('vendor_id', 18, 2)->nullable();
                    $table->decimal('id_kelayakan', 18, 2)->nullable();
                    $table->decimal('created_by', 18, 2)->nullable();
                    $table->string('sekper', 255)->nullable();
                    $table->string('dirut', 255)->nullable();
                    $table->string('ket_sekper', 255)->nullable();
                    $table->string('ket_dirut', 255)->nullable();
                    $table->timestamp('approve_sekper')->nullable();
                    $table->timestamp('approve_dirut')->nullable();
                    $table->decimal('PERSEN1', 10, 2)->nullable();
                    $table->decimal('PERSEN2', 10, 2)->nullable();
                    $table->decimal('PERSEN3', 10, 2)->nullable();
                    $table->decimal('PERSEN4', 10, 2)->nullable();
                });

        Schema::create('nr_csr.tbl_user', function (Blueprint $table) {
                    $table->increments('id_user');
                    $table->string('username', 100);
                    $table->string('email', 100);
                    $table->string('nama', 100);
                    $table->string('jabatan', 100);
                    $table->string('password', 200);
                    $table->string('role', 100);
                    $table->string('area_kerja', 100)->nullable();
                    $table->string('status', 100)->nullable();
                    $table->string('foto_profile', 255)->nullable();
                    $table->string('remember_token', 100)->nullable();
                    $table->string('jk', 100)->nullable();
                    $table->string('old_email', 255)->nullable();
                    $table->string('perusahaan', 255)->nullable();
                    $table->string('vendor_id', 255)->nullable();
                    $table->decimal('id_perusahaan', 18, 2)->nullable();
                    $table->string('no_sk', 255)->nullable();
                    $table->timestamp('tgl_sk')->nullable();
                });

        Schema::create('nr_csr.tbl_vendor', function (Blueprint $table) {
                    $table->increments('vendor_id');
                    $table->string('nama_perusahaan', 200)->nullable();
                    $table->string('alamat', 500)->nullable();
                    $table->string('no_telp', 20)->nullable();
                    $table->string('email', 100)->nullable();
                    $table->string('website', 50)->nullable();
                    $table->string('no_ktp', 50)->nullable();
                    $table->string('nama_pic', 100)->nullable();
                    $table->string('jabatan', 100)->nullable();
                    $table->string('email_pic', 100)->nullable();
                    $table->string('no_hp', 20)->nullable();
                    $table->string('file_ktp', 200)->nullable();
                    $table->timestamp('created_at')->nullable();
                    $table->timestamp('updated_at')->nullable();
                    $table->string('status', 255)->nullable();
                    $table->string('approve_by', 255)->nullable();
                    $table->timestamp('approve_date')->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('nr_csr.tbl_vendor');
        Schema::dropIfExists('nr_csr.tbl_user');
        Schema::dropIfExists('nr_csr.tbl_survei');
        Schema::dropIfExists('nr_csr.tbl_sub_proposal');
        Schema::dropIfExists('nr_csr.tbl_sub_pilar');
        Schema::dropIfExists('nr_csr.tbl_spph');
        Schema::dropIfExists('nr_csr.tbl_spk');
        Schema::dropIfExists('nr_csr.tbl_sph');
        Schema::dropIfExists('nr_csr.tbl_sektor');
        Schema::dropIfExists('nr_csr.tbl_sdg');
    }
}
