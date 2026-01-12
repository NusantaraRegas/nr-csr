<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart3 extends Migration
{
    public function up()
    {
        Schema::create('NR_CSR.TBL_IZIN_USAHA', function (Blueprint $table) {
                    $table->increments('IZIN_USAHA_ID');
                    $table->string('ID_VENDOR', 255)->nullable();
                    $table->string('NIB', 255)->nullable();
                    $table->string('JENIS_KBLI', 255)->nullable();
                    $table->string('KODE_KBLI', 255)->nullable();
                    $table->string('ALAMAT', 255)->nullable();
                    $table->string('FILE', 255)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_KEBIJAKAN', function (Blueprint $table) {
                    $table->increments('ID_KEBIJAKAN');
                    $table->string('KEBIJAKAN', 200)->nullable();
                });

        Schema::create('NR_CSR.TBL_KELAYAKAN', function (Blueprint $table) {
                    $table->string('NO_AGENDA', 50)->nullable();
                    $table->timestamp('TGL_TERIMA')->nullable();
                    $table->string('NO_SURAT', 100)->nullable();
                    $table->timestamp('TGL_SURAT')->nullable();
                    $table->string('SEBAGAI', 100)->nullable()->default('');
                    $table->string('PROVINSI', 100)->nullable();
                    $table->string('KABUPATEN', 100)->nullable();
                    $table->string('KELURAHAN', 100)->nullable();
                    $table->string('KODEPOS', 10)->nullable();
                    $table->string('BANTUAN_UNTUK', 200)->nullable();
                    $table->string('CONTACT_PERSON', 100)->nullable();
                    $table->decimal('NILAI_PENGAJUAN', 38, 0)->nullable();
                    $table->string('SEKTOR_BANTUAN', 100)->nullable();
                    $table->string('NAMA_BANK', 50)->nullable();
                    $table->string('ATAS_NAMA', 150)->nullable();
                    $table->string('NO_REKENING', 50)->nullable();
                    $table->decimal('NILAI_BANTUAN', 38, 0)->nullable();
                    $table->string('NAMA_ANGGOTA', 50)->nullable();
                    $table->string('FRAKSI', 255)->nullable();
                    $table->string('JABATAN', 200)->nullable();
                    $table->string('PIC', 255)->nullable();
                    $table->string('ASAL_SURAT', 100)->nullable();
                    $table->string('KOMISI', 100)->nullable();
                    $table->string('SIFAT', 20)->nullable();
                    $table->string('STATUS', 50)->nullable();
                    $table->string('EMAIL_PENGAJU', 50)->nullable();
                    $table->string('NAMA_PERSON', 50)->nullable();
                    $table->string('MATA_UANG_PENGAJUAN', 20)->nullable();
                    $table->string('MATA_UANG_BANTUAN', 20)->nullable();
                    $table->string('PROPOSAL', 255)->nullable();
                    $table->string('CREATE_BY', 50)->nullable();
                    $table->timestamp('CREATE_DATE')->nullable();
                    $table->string('PENGIRIM', 200)->nullable();
                    $table->string('PERIHAL', 200)->nullable();
                    $table->string('PENGAJU_PROPOSAL', 200)->nullable();
                    $table->string('ALAMAT', 400)->nullable();
                    $table->string('CABANG_BANK', 150)->nullable();
                    $table->string('JENIS', 255)->nullable();
                    $table->string('HEWAN_KURBAN', 255)->nullable();
                    $table->bigInteger('JUMLAH_HEWAN')->nullable();
                    $table->string('KODE_BANK', 255)->nullable();
                    $table->string('KODE_KOTA', 255)->nullable();
                    $table->string('KOTA_BANK', 255)->nullable();
                    $table->string('CABANG', 255)->nullable();
                    $table->string('DESKRIPSI', 500)->nullable();
                    $table->string('PILAR', 255)->nullable();
                    $table->string('TPB', 255)->nullable();
                    $table->string('KODE_INDIKATOR', 255)->nullable();
                    $table->string('KETERANGAN_INDIKATOR', 1000)->nullable();
                    $table->string('PROKER', 255)->nullable();
                    $table->string('INDIKATOR', 255)->nullable();
                    $table->string('SMAP', 255)->nullable();
                    $table->string('YKPP', 255)->nullable();
                    $table->string('CHECKLIST_BY', 255)->nullable();
                    $table->timestamp('CHECKLIST_DATE')->nullable();
                    $table->bigInteger('NOMINAL_APPROVED')->nullable();
                    $table->bigInteger('NOMINAL_FEE')->nullable();
                    $table->bigInteger('TOTAL_YKPP')->nullable();
                    $table->string('STATUS_YKPP', 255)->nullable();
                    $table->string('APPROVED_YKPP_BY', 255)->nullable();
                    $table->timestamp('APPROVED_YKPP_DATE')->nullable();
                    $table->string('SUBMITED_YKPP_BY', 255)->nullable();
                    $table->timestamp('SUBMITED_YKPP_DATE')->nullable();
                    $table->string('NO_SURAT_YKPP', 255)->nullable();
                    $table->string('TGL_SURAT_YKPP', 255)->nullable();
                    $table->bigInteger('PENYALURAN_KE_OLD')->nullable();
                    $table->increments('ID_KELAYAKAN');
                    $table->string('SURAT_YKPP', 255)->nullable();
                    $table->string('TAHUN_YKPP', 4)->nullable();
                    $table->string('PENYALURAN_KE', 255)->nullable();
                    $table->decimal('ID_LEMBAGA', 18, 2)->nullable();
                    $table->decimal('ID_PENGIRIM', 18, 2)->nullable();
                    $table->decimal('CREATED_BY', 18, 2)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->decimal('ID_PROKER', 18, 2)->nullable();
                    $table->string('KECAMATAN', 100)->nullable()->default('');
                });

        Schema::create('NR_CSR.TBL_KODE', function (Blueprint $table) {
                    $table->string('KODE', 20)->nullable();
                    $table->string('PROVINSI', 100)->nullable();
                });

        Schema::create('NR_CSR.TBL_KTP_PENGURUS', function (Blueprint $table) {
                    $table->increments('KTP_ID');
                    $table->string('ID_VENDOR', 255)->nullable();
                    $table->string('NOMOR', 255)->nullable();
                    $table->string('NAMA', 255)->nullable();
                    $table->string('JABATAN', 255)->nullable();
                    $table->string('NO_TELP', 255)->nullable();
                    $table->string('EMAIL', 255)->nullable();
                    $table->string('FILE', 255)->nullable();
                    $table->timestamp('CREATED_DATE')->nullable();
                    $table->string('CREATED_BY', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_LAMPIRAN', function (Blueprint $table) {
                    $table->bigInteger('ID_LAMPIRAN');
                    $table->string('NO_AGENDA', 50)->nullable();
                    $table->string('NAMA', 255)->nullable();
                    $table->string('LAMPIRAN', 500)->nullable();
                    $table->string('UPLOAD_BY', 50)->nullable();
                    $table->timestamp('UPLOAD_DATE')->nullable();
                    $table->timestamp('CREATED_AT')->nullable();
                    $table->timestamp('UPDATED_AT')->nullable();
                    $table->decimal('ID_KELAYAKAN', 18, 2)->nullable();
                    $table->decimal('CREATED_BY', 18, 2)->nullable();
                });

        Schema::create('NR_CSR.TBL_LAMPIRAN_AP', function (Blueprint $table) {
                    $table->bigIncrements('ID_LAMPIRAN');
                    $table->bigInteger('ID_REALISASI')->nullable();
                    $table->string('NAMA', 255)->nullable();
                    $table->string('LAMPIRAN', 255)->nullable();
                    $table->string('UPLOAD_BY', 255)->nullable();
                    $table->timestamp('UPLOAD_DATE')->nullable();
                });

        Schema::create('NR_CSR.TBL_LAMPIRAN_PEKERJAAN', function (Blueprint $table) {
                    $table->increments('LAMPIRAN_ID');
                    $table->decimal('ID_VENDOR', 18, 2)->nullable();
                    $table->string('NOMOR', 255)->nullable();
                    $table->string('NAMA_FILE', 255)->nullable();
                    $table->string('FILE', 255)->nullable();
                    $table->string('TYPE', 255)->nullable();
                    $table->decimal('SIZE', 18, 2)->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->string('CATATAN', 255)->nullable();
                    $table->string('UPLOAD_BY', 255)->nullable();
                    $table->timestamp('UPLOAD_DATE')->nullable();
                    $table->string('NAMA_DOKUMEN', 255)->nullable();
                    $table->decimal('PEKERJAAN_ID', 18, 2)->nullable();
                });

        Schema::create('NR_CSR.TBL_LAMPIRAN_VENDOR', function (Blueprint $table) {
                    $table->increments('LAMPIRAN_ID');
                    $table->decimal('ID_VENDOR', 18, 2)->nullable();
                    $table->string('NOMOR', 255)->nullable();
                    $table->string('NAMA_FILE', 255)->nullable();
                    $table->string('FILE', 255)->nullable();
                    $table->string('TYPE', 255)->nullable();
                    $table->decimal('SIZE', 18, 2)->nullable();
                    $table->string('STATUS', 255)->nullable();
                    $table->string('CATATAN', 255)->nullable();
                    $table->string('UPLOAD_BY', 255)->nullable();
                    $table->timestamp('UPLOAD_DATE')->nullable();
                    $table->string('NAMA_DOKUMEN', 255)->nullable();
                });

        Schema::create('NR_CSR.TBL_LEMBAGA', function (Blueprint $table) {
                    $table->increments('ID_LEMBAGA');
                    $table->string('NAMA_LEMBAGA', 255)->nullable();
                    $table->string('NAMA_PIC', 255)->nullable();
                    $table->string('ALAMAT', 255)->nullable();
                    $table->string('NO_TELP', 255)->nullable();
                    $table->string('JABATAN', 255)->nullable();
                    $table->string('NO_REKENING', 255)->nullable();
                    $table->string('ATAS_NAMA', 255)->nullable();
                    $table->string('NAMA_BANK', 255)->nullable();
                    $table->string('CABANG', 255)->nullable();
                    $table->string('KOTA_BANK', 255)->nullable();
                    $table->string('KODE_BANK', 255)->nullable();
                    $table->string('KODE_KOTA', 255)->nullable();
                    $table->string('PERUSAHAAN', 255)->nullable();
                    $table->decimal('ID_PERUSAHAAN', 18, 2)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('NR_CSR.TBL_LEMBAGA');
        Schema::dropIfExists('NR_CSR.TBL_LAMPIRAN_VENDOR');
        Schema::dropIfExists('NR_CSR.TBL_LAMPIRAN_PEKERJAAN');
        Schema::dropIfExists('NR_CSR.TBL_LAMPIRAN_AP');
        Schema::dropIfExists('NR_CSR.TBL_LAMPIRAN');
        Schema::dropIfExists('NR_CSR.TBL_KTP_PENGURUS');
        Schema::dropIfExists('NR_CSR.TBL_KODE');
        Schema::dropIfExists('NR_CSR.TBL_KELAYAKAN');
        Schema::dropIfExists('NR_CSR.TBL_KEBIJAKAN');
        Schema::dropIfExists('NR_CSR.TBL_IZIN_USAHA');
    }
}
