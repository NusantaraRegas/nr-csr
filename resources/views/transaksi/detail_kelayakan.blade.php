@extends('layout.master')
@section('title', 'NR SHARE | Detail Proposal')
<?php

$jumlahLegal = DB::table('TBL_SURVEI')
    ->select(DB::raw('count(*) as jumlah'))
    ->where([['no_agenda', $data->no_agenda], ['bast', 'Oke'], ['spk', 'Oke'], ['pks', 'Oke']])
    ->first();

$jumlahDokumenLegal = DB::table('TBL_SURVEI')->select(DB::raw('count(*) as jumlah'))->where('no_agenda', $data->no_agenda)->where('bast', 'Oke')->orWhere('spk', 'Oke')->orWhere('pks', 'Oke')->first();

$jumlahBAST = DB::table('TBL_SURVEI')
    ->select(DB::raw('count(*) as jumlah'))
    ->where([['no_agenda', $data->no_agenda], ['bast', 'Oke']])
    ->first();

$jumlahSPK = DB::table('TBL_SURVEI')
    ->select(DB::raw('count(*) as jumlah'))
    ->where([['no_agenda', $data->no_agenda], ['spk', 'Oke']])
    ->first();

$jumlahPKS = DB::table('TBL_SURVEI')
    ->select(DB::raw('count(*) as jumlah'))
    ->where([['no_agenda', $data->no_agenda], ['pks', 'Oke']])
    ->first();

$dataBASTDana = DB::table('TBL_BAST_DANA')
    ->select('TBL_BAST_DANA.*')
    ->where([['no_agenda', $data->no_agenda]])
    ->first();

$dataSPK = DB::table('TBL_SPK')
    ->select('TBL_SPK.*')
    ->where([['no_agenda', $data->no_agenda]])
    ->first();
?>
@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid model-huruf-family">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-uppercase model-huruf-family font-weight-bold">Detail Proposal {{ $data->jenis }}<br>
                    <small class="text-muted text-capitalize">
                        @if ($data->status == 'Draft')
                            <i class="fa fa-info-circle mr-2 text-info"></i><span>Draft Proposal</span>
                        @elseif($data->status == 'Evaluasi')
                            @if ($dataEvaluasi->status == 'Draft')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Proposal Sedang Dievaluasi</span>
                            @elseif($dataEvaluasi->status == 'Forward')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Evaluasi Proposal Menunggu Persetujuan
                                    Evaluator 2</span>
                            @elseif($dataEvaluasi->status == 'Approved 1')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Evaluasi Proposal Menunggu Persetujuan
                                    Departmen Head Operation</span>
                            @elseif($dataEvaluasi->status == 'Approved 2')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Evaluasi Proposal Menunggu Persetujuan
                                    Division Head</span>
                            @elseif($dataEvaluasi->status == 'Approved 3')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Evaluasi Proposal Sudah Disetujui
                                    Division
                                    Head</span>
                            @elseif($dataEvaluasi->status == 'Survei')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Evaluasi Proposal Sudah Disetujui
                                    Division
                                    Head</span>
                            @elseif($dataEvaluasi->status == 'Revisi')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Evaluasi Proposal Untuk Direvisi
                                    Evaluator
                                    yang bersangkutan</span>
                            @endif
                        @elseif($data->status == 'Survei')
                            @if ($dataSurvei->status == 'Draft')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Proposal Sedang Disurvei</span>
                            @elseif($dataSurvei->status == 'Forward')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Survei Proposal Menunggu Review
                                    Pelaksana Survei ke 2</span>
                            @elseif($dataSurvei->status == 'Approved 1')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Survei Proposal Menunggu Persetujuan
                                    Departmen
                                    Head Operation</span>
                            @elseif($dataSurvei->status == 'Approved 2')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Survei Proposal Menunggu Persetujuan
                                    Division
                                    Head</span>
                            @elseif($dataSurvei->status == 'Approved 3')
                                <i class="fa fa-check-circle mr-2 text-success"></i><span>Proposal Sudah Disetujui oleh
                                    Division Head</span>
                            @elseif($dataSurvei->status == 'Revisi')
                                <i class="fa fa-info-circle mr-2 text-info"></i><span>Survei Proposal Untuk Direvisi
                                    Pelaksana Survei ke 1</span>
                            @endif
                        @elseif($data->status == 'Approved')
                            <i class="fa fa-check-circle mr-2 font-16 text-success"></i><span>Proposal Sudah Disetujui oleh
                                Division Head</span>
                        @elseif($data->status == 'Rejected')
                            <i class="fa fa-times-circle mr-2 text-danger"></i><span>PROPOSAL DITOLAK</span>
                        @endif
                    </small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cari-kelayakan') }}">Report</a></li>
                        <li class="breadcrumb-item active">Detail Proposal</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-b-0">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title font-weight-bold mb-5 model-huruf-family">KELAYAKAN PROPOSAL</h5>
                            </div>
                            <div class="ml-auto">
                                <div class="btn-group">
                                    <a href="#!" class="btn btn-sm btn-success">Actions</a>
                                    <button type="button"
                                        class="btn btn-sm btn-success active dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item"
                                            href="{{ route('ubahProposal', encrypt($data->id_kelayakan)) }}">Edit
                                            Kelayakan</a>
                                        <a class="dropdown-item edit-bank"
                                            href="{{ route('ubahBank', encrypt($data->no_agenda)) }}">Edit
                                            Bank</a>
                                        @if ($jumlahSurvei > 0)
                                            @if ($dataSurvei->nilai_approved > 0)
                                                <a class="dropdown-item"
                                                    href="{{ route('dataSubProposal', encrypt($data->no_agenda)) }}">Sub
                                                    Proposal</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home2"
                                role="tab"><span class="hidden-sm-up"><i class="fa fa-file-text"></i></span>
                                <span class="hidden-xs-down">DISPOSISI</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#yayasan" role="tab"><span
                                    class="hidden-sm-up"><i class="fa fa-file-text"></i></span>
                                <span class="hidden-xs-down">PENERIMA MANFAAT</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messages2" role="tab"><span
                                    class="hidden-sm-up"><i class="fa fa-bank"></i></span> <span
                                    class="hidden-xs-down">INFORMASI BANK</span></a></li>
                        @if ($jenis == 'Aspirasi')
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messages3"
                                    role="tab"><span class="hidden-sm-up"><i class="fa fa-user"></i></span> <span
                                        class="hidden-xs-down">INFORMASI ANGGOTA</span></a></li>
                        @endif
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="home2" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped m-b-0" width="10%">
                                    <tbody>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Jenis Proposal
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->jenis }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2">
                                                Tanggal Penerimaan
                                            </th>
                                            <td class="pt-2 pb-2">
                                                {{ \App\Http\Controllers\tanggal_indo(date('Y-m-d', strtotime($data->tgl_terima))) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Pengirim
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->pengirim }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Perihal
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->bantuan_untuk }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="250px">
                                                No Agenda
                                            </th>
                                            <td class="pt-2 pb-2 text-uppercase">{{ $data->no_agenda }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="250px">
                                                No Surat
                                            </th>
                                            <td class="pt-2 pb-2 text-uppercase">{{ $data->no_surat }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2">
                                                Tanggal Surat
                                            </th>
                                            <td class="pt-2 pb-2">
                                                {{ \App\Http\Controllers\tanggal_indo(date('Y-m-d', strtotime($data->tgl_surat))) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Sifat
                                            </th>
                                            <td class="pt-2 pb-2">
                                                @if ($data->sifat == 'Biasa')
                                                    <span class="badge badge-success">Biasa</span>
                                                @elseif($data->sifat == 'Segera')
                                                    <span class="badge badge-warning" style="color: black">Segera</span>
                                                @elseif($data->sifat == 'Amat Segera')
                                                    <span class="badge badge-danger">Amat Segera</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Kategori Bantuan
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->perihal }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Deskripsi Bantuan
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->deskripsi }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Besar Permohonan
                                            </th>
                                            <td class="pt-2 pb-2">
                                                Rp. {{ number_format($data->nilai_pengajuan, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Wilayah
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->kabupaten . ', ' }}{{ $data->provinsi }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="250px">
                                                Created By
                                            </th>
                                            <td class="pt-2 pb-2 text-capitalize">
                                                <span class="font-weight-bold">{{ $maker->nama }}</span><br>
                                                <span
                                                    class="text-muted">{{ date('d-m-Y H:i:s', strtotime($data->create_date)) }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="yayasan" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped m-b-0" width="10%">
                                    <tbody>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Asal Proposal
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->asal_surat }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Alamat
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Penanggung Jawab
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->pengaju_proposal }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Bertindak Sebagai
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->sebagai }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                No Telepon
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->contact_person }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Email
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->email_pengaju }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="messages2" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped m-b-0" width="10%">
                                    <tbody>
                                        <tr>
                                            <th class="pt-2 pb-2" width="250px">
                                                Nomor Rekening
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->no_rekening }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Atas Nama
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->atas_nama }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Nama Bank
                                            </th>
                                            <td class="pt-2 pb-2">
                                                {{ $data->nama_bank }}<br>
                                                <small class="text-muted">Kode: {{ $data->kode_bank }}</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Kota
                                            </th>
                                            <td class="pt-2 pb-2">
                                                {{ $data->kota_bank }}<br>
                                                <small class="text-muted">Kode: {{ $data->kode_kota }}</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="pt-2 pb-2" width="200px">
                                                Cabang
                                            </th>
                                            <td class="pt-2 pb-2">{{ $data->cabang_bank }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($jenis == 'Aspirasi')
                            <div class="tab-pane" id="messages3" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped m-b-0" width="10%">
                                        <tbody>
                                            <tr>
                                                <th class="pt-2 pb-2" width="250px">
                                                    Nama Anggota
                                                </th>
                                                <td class="pt-2 pb-2 text-uppercase">{{ $data->nama_anggota }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Fraksi
                                                </th>
                                                <td class="pt-2 pb-2 text-uppercase">{{ $data->fraksi }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Komisi
                                                </th>
                                                <td class="pt-2 pb-2 text-uppercase">{{ $data->komisi }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Jabatan
                                                </th>
                                                <td class="pt-2 pb-2">{{ $data->jabatan }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    PIC
                                                </th>
                                                <td class="pt-2 pb-2">{{ $data->pic }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-b-0">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title font-weight-bold model-huruf-family">TINDAK LANJUT</h5>
                                <h6 class="card-subtitle model-huruf-family mb-5">Evaluasi, Survei dan Pembayaran</h6>
                            </div>
                            <div class="ml-auto">
                                <div class="btn-group">
                                    <a href="#!" class="btn btn-sm btn-success">Actions</a>
                                    <button type="button"
                                        class="btn btn-success btn-sm active dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if ($jumlahEvaluasi > 0)
                                            <a class="dropdown-item"
                                                href="{{ route('edit-evaluasi', encrypt($data->no_agenda)) }}">Edit
                                                Evaluasi</a>
                                        @endif
                                        @if ($jumlahSurvei > 0)
                                            <a class="dropdown-item"
                                                href="{{ route('edit-survei', encrypt($data->no_agenda)) }}">Edit
                                                Survei</a>
                                            {{--                                            <a class="dropdown-item createAmandement" href="#!" data-toggle="modal" --}}
                                            {{--                                               data-target=".modal-amandemen"><i --}}
                                            {{--                                                        class="fa fa-plus-square mr-2 font-18"></i>Create Amendment</a> --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#evaluasi1"
                                role="tab"><span class="hidden-sm-up"><i class="fa fa-folder-open"></i></span>
                                <span class="hidden-xs-down">EVALUASI</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#evaluasi2"
                                role="tab"><span class="hidden-sm-up"><i class="fa fa-folder-open-o"></i></span>
                                <span class="hidden-xs-down">SURVEI</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#evaluasi3"
                                role="tab"><span class="hidden-sm-up"><i class="fa fa-money"></i></span> <span
                                    class="hidden-xs-down">PEMBAYARAN</span></a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="evaluasi1" role="tabpanel">
                            @if ($jumlahEvaluasi > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped m-b-0" width="10%">
                                        <tbody>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Rencana Anggaran
                                                </th>
                                                <td class="pt-2 pb-2 text-uppercase">{{ $dataEvaluasi->rencana_anggaran }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Dokumentasi
                                                </th>
                                                <td class="pt-2 pb-2 text-uppercase">{{ $dataEvaluasi->dokumen }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Denah Lokasi
                                                </th>
                                                <td class="pt-2 pb-2 text-uppercase">{{ $dataEvaluasi->denah }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Perkiraan Bantuan
                                                </th>
                                                <td class="pt-2 pb-2">
                                                    Rp. {{ number_format($data->nilai_bantuan, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Kepentingan Perusahaan
                                                </th>
                                                <td class="pt-2 pb-2">
                                                    <ol class="p-l-15 text-capitalize">
                                                        @foreach ($dataKriteria as $kriteria)
                                                            <li class="p-l-0">{{ $kriteria->kriteria }}</li>
                                                        @endforeach
                                                    </ol>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Memenuhi Syarat
                                                </th>
                                                <td class="pt-2 pb-2">
                                                    @if ($dataEvaluasi->syarat == 'Survei')
                                                        <span><i class="fa fa-check-circle text-success mr-1"></i>
                                                            Survei/Konfirmasi</span>
                                                    @else
                                                        <span><i class="fa fa-times-circle text-danger mr-1"></i>Tidak
                                                            Memenuhi
                                                            Syarat</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Evaluator Ke 1
                                                </th>
                                                <td class="pt-2 pb-2 text-capitalize">
                                                    <?php
                                                    $evaluator1 = DB::table('TBL_USER')->select('TBL_USER.*')->where('username', $dataEvaluasi->evaluator1)->first();
                                                    ?>
                                                    <span class="font-weight-bold">{{ $evaluator1->nama }}</span>
                                                    @if (session('user')->role == 'Admin')
                                                        <a href="#!" data-toggle="modal"
                                                            data-target=".modalEvaluator"
                                                            class="badge badge-warning pull-right komenEvaluator"
                                                            data-tanggal="{{ date('d-M-Y', strtotime($dataEvaluasi->create_date)) }}"
                                                            data-komen="{{ $dataEvaluasi->catatan1 }}"><i
                                                                class="fa fa-pencil mr-1"></i>Edit
                                                        </a>
                                                    @endif
                                                    @if ($dataEvaluasi->catatan1 != '')
                                                        <br>
                                                        <span class="text-muted">
                                                            {{ $dataEvaluasi->catatan1 }}<br>
                                                            {{ date('d-m-Y H:i:s', strtotime($dataEvaluasi->create_date)) }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Evaluator Ke 2
                                                </th>
                                                <td class="pt-2 pb-2 text-capitalize">
                                                    <?php
                                                    $evaluator2 = DB::table('TBL_USER')->select('TBL_USER.*')->where('username', $dataEvaluasi->evaluator2)->first();
                                                    ?>
                                                    <span class="font-weight-bold">{{ $evaluator2->nama }}</span>
                                                    @if (session('user')->role == 'Admin')
                                                        <a href="#!" data-toggle="modal"
                                                            data-target=".modalEvaluator2"
                                                            class="badge badge-warning pull-right komenEvaluator2"
                                                            data-tanggal="{{ date('d-M-Y', strtotime($dataEvaluasi->approve_date)) }}"><i
                                                                class="fa fa-pencil mr-1"></i>Edit
                                                        </a>
                                                    @endif
                                                    <br>
                                                    <span
                                                        class="text-muted">{{ date('d-m-Y H:i:s', strtotime($dataEvaluasi->approve_date)) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Depertment Head Operational
                                                </th>
                                                <td class="pt-2 pb-2 text-capitalize">
                                                    <?php
                                                    $kadep = DB::table('TBL_USER')->select('TBL_USER.*')->where('username', $dataEvaluasi->kadep)->first();
                                                    ?>
                                                    <span class="font-weight-bold">{{ $kadep->nama }}</span>
                                                    @if (
                                                        $dataEvaluasi->status == 'Approved 2' or
                                                            $dataEvaluasi->status == 'Approved 3' or
                                                            $dataEvaluasi->status == 'Survei' or
                                                            $dataEvaluasi->status == 'Rejected' or
                                                            $dataEvaluasi->status == 'Create Survei')
                                                        @if (session('user')->role == 'Admin')
                                                            <a href="#!" data-toggle="modal"
                                                                data-target=".modalKadepEvaluasi"
                                                                class="badge badge-warning pull-right komenKadepEvaluasi"
                                                                data-tanggal="{{ date('d-M-Y', strtotime($dataEvaluasi->approve_kadep)) }}"
                                                                data-komen="{{ $dataEvaluasi->ket_kadin1 }}"><i
                                                                    class="fa fa-pencil mr-1"></i>Edit
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if ($dataEvaluasi->ket_kadin1 != '')
                                                        <br>
                                                        <span class="text-muted">{{ $dataEvaluasi->ket_kadin1 }}</span>
                                                        <br>
                                                        <span
                                                            class="text-muted">{{ date('d-m-Y H:i:s', strtotime($dataEvaluasi->approve_kadep)) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Division Head
                                                </th>
                                                <td class="pt-2 pb-2 text-capitalize">
                                                    <?php
                                                    $kadiv = DB::table('TBL_USER')->select('TBL_USER.*')->where('username', $dataEvaluasi->kadiv)->first();
                                                    ?>
                                                    <span class="font-weight-bold">{{ $kadiv->nama }}</span>
                                                    @if (
                                                        $dataEvaluasi->status == 'Approved 3' or
                                                            $dataEvaluasi->status == 'Survei' or
                                                            $dataEvaluasi->status == 'Rejected' or
                                                            $dataEvaluasi->status == 'Create Survei')
                                                        @if (session('user')->role == 'Admin')
                                                            <a href="#!" data-toggle="modal"
                                                                data-target=".modalKadivEvaluasi"
                                                                class="badge badge-warning pull-right komenKadivEvaluasi"
                                                                data-tanggal="{{ date('d-M-Y', strtotime($dataEvaluasi->approve_kadiv)) }}"
                                                                data-komen="{{ $dataEvaluasi->ket_kadiv }}"><i
                                                                    class="fa fa-pencil mr-1"></i>Edit
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if ($dataEvaluasi->ket_kadiv != '')
                                                        <br>
                                                        <span class="text-muted">{{ $dataEvaluasi->ket_kadiv }}</span>
                                                        <br>
                                                        <span
                                                            class="text-muted">{{ date('d-m-Y H:i:s', strtotime($dataEvaluasi->approve_kadiv)) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="250px">
                                                    Created By
                                                </th>
                                                <td class="pt-2 pb-2 text-capitalize">
                                                    <span class="font-weight-bold">{{ $evaluator1->nama }}</span><br>
                                                    <span
                                                        class="text-muted">{{ date('d-m-Y H:i:s', strtotime($dataEvaluasi->create_date)) }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-20">
                                    <div class="alert alert-warning mb-0">Proposal bantuan belum dievaluasi
                                        <div class="m-t-10">
                                            <a href="{{ route('input-evaluasi', encrypt($data->no_agenda)) }}"
                                                class="btn btn-warning btn-sm text-dark"><i
                                                    class="fa fa-edit mr-2"></i>Evaluasi
                                                Proposal</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="evaluasi2" role="tabpanel">
                            @if ($jumlahSurvei > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped m-b-0" width="10%">
                                        <tbody>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Hasil Survei
                                                </th>
                                                <td class="pt-2 pb-2">{{ $dataSurvei->hasil_survei }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Usulan
                                                </th>
                                                <td class="pt-2 pb-2">{{ $dataSurvei->usulan }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Dibantu Berupa
                                                </th>
                                                <td class="pt-2 pb-2">{{ $dataSurvei->bantuan_berupa }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Nilai Bantuan
                                                </th>
                                                <td class="pt-2 pb-2">
                                                    Rp. {{ number_format($dataSurvei->nilai_bantuan, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Termin Pembayaran
                                                </th>
                                                <td class="pt-2 pb-2">
                                                    <span class="font-weight-bold">{{ $dataSurvei->termin }} Termin</span>
                                                    <br>
                                                    @if ($dataSurvei->termin == 1)
                                                        <ul style="margin-left: -20px; margin-bottom: -5px">
                                                            <li>{{ $dataSurvei->persen1 }}% -
                                                                Rp. {{ number_format($dataSurvei->rupiah1, 0, ',', '.') }}
                                                            </li>
                                                        </ul>
                                                    @elseif($dataSurvei->termin == 2)
                                                        <ul style="margin-left: -20px; margin-bottom: -5px">
                                                            <li>{{ $dataSurvei->persen1 }}% -
                                                                Rp. {{ number_format($dataSurvei->rupiah1, 0, ',', '.') }}
                                                            </li>
                                                            <li>{{ $dataSurvei->persen2 }}% -
                                                                Rp. {{ number_format($dataSurvei->rupiah2, 0, ',', '.') }}
                                                            </li>
                                                        </ul>
                                                    @elseif($dataSurvei->termin == 3)
                                                        <ul style="margin-left: -20px; margin-bottom: -5px">
                                                            <li>{{ $dataSurvei->persen1 }}% -
                                                                Rp. {{ number_format($dataSurvei->rupiah1, 0, ',', '.') }}
                                                            </li>
                                                            <li>{{ $dataSurvei->persen2 }}% -
                                                                Rp. {{ number_format($dataSurvei->rupiah2, 0, ',', '.') }}
                                                            </li>
                                                            <li>{{ $dataSurvei->persen3 }}% -
                                                                Rp. {{ number_format($dataSurvei->rupiah3, 0, ',', '.') }}
                                                            </li>
                                                        </ul>
                                                    @elseif($dataSurvei->termin == 4)
                                                        <ul style="margin-left: -20px; margin-bottom: -5px">
                                                            <li>{{ $dataSurvei->persen1 }}% -
                                                                Rp. {{ number_format($dataSurvei->rupiah1, 0, ',', '.') }}
                                                            </li>
                                                            <li>{{ $dataSurvei->persen2 }}% -
                                                                Rp. {{ number_format($dataSurvei->rupiah2, 0, ',', '.') }}
                                                            </li>
                                                            <li>{{ $dataSurvei->persen3 }}% -
                                                                Rp. {{ number_format($dataSurvei->rupiah3, 0, ',', '.') }}
                                                            </li>
                                                            <li>{{ $dataSurvei->persen4 }}% -
                                                                Rp. {{ number_format($dataSurvei->rupiah4, 0, ',', '.') }}
                                                            </li>
                                                        </ul>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Program Kerja
                                                </th>
                                                <td class="pt-2 pb-2">
                                                    {{ $data->id_proker . ', ' }}{{ $data->proker }}
                                                    @if (session('user')->role == 'Admin')
                                                        <a href="#!" data-target=".modal-editProker"
                                                            data-toggle="modal" class="badge badge-warning pull-right"><i
                                                                class="fa fa-pencil mr-1"></i>Edit
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Pilar
                                                </th>
                                                <td class="pt-2 pb-2">{{ $data->pilar }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Goals
                                                </th>
                                                <td class="pt-2 pb-2">{{ $data->tpb }}</td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Pelaksana Survei 1
                                                </th>
                                                <td class="pt-2 pb-2">
                                                    <?php
                                                    $survei1 = DB::table('TBL_USER')->select('TBL_USER.*')->where('username', $dataSurvei->survei1)->first();
                                                    ?>
                                                    <span class="font-weight-bold">{{ $survei1->nama }}</span>
                                                    @if (session('user')->role == 'Admin')
                                                        <a href="#!" data-toggle="modal" data-target=".modalSurvei1"
                                                            class="badge badge-warning pull-right komenSurvei1"
                                                            data-tanggal="{{ date('d-M-Y', strtotime($dataSurvei->create_date)) }}"
                                                            data-komen="{{ $dataSurvei->hasil_survei }}"><i
                                                                class="fa fa-pencil mr-1"></i>Edit
                                                        </a>
                                                    @endif
                                                    @if ($dataSurvei->hasil_survei != '')
                                                        <br>
                                                        <span
                                                            class="text-muted">{{ $dataSurvei->hasil_survei }}<br>{{ date('d-m-Y H:i:s', strtotime($dataSurvei->create_date)) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Pelaksana Survei 2
                                                </th>
                                                <td class="pt-2 pb-2">
                                                    <?php
                                                    $survei2 = DB::table('TBL_USER')->select('TBL_USER.*')->where('username', $dataSurvei->survei2)->first();
                                                    ?>
                                                    <span class="font-weight-bold">{{ $survei2->nama }}</span>
                                                    @if (
                                                        $dataSurvei->status == 'Approved 1' or
                                                            $dataSurvei->status == 'Approved 2' or
                                                            $dataSurvei->status == 'Approved 3' or
                                                            $dataSurvei->status == 'Rejected')
                                                        @if (session('user')->role == 'Admin')
                                                            <a href="#!" data-toggle="modal"
                                                                data-target=".modalSurvei2"
                                                                class="badge badge-warning pull-right komenSurvei2"
                                                                data-tanggal="{{ date('d-M-Y', strtotime($dataSurvei->approve_date)) }}"
                                                                data-komen="{{ $dataSurvei->hasil_konfirmasi }}"><i
                                                                    class="fa fa-pencil mr-1"></i>Edit
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if ($dataSurvei->hasil_konfirmasi != '')
                                                        <br>
                                                        <span
                                                            class="text-muted">{{ $dataSurvei->hasil_konfirmasi }}<br>{{ date('d-m-Y H:i:s', strtotime($dataSurvei->approve_date)) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Depertment Head Operation
                                                </th>
                                                <td class="pt-2 pb-2 text-capitalize">
                                                    <?php
                                                    $kadep = DB::table('TBL_USER')->select('TBL_USER.*')->where('username', $dataSurvei->kadep)->first();
                                                    ?>
                                                    <span class="font-weight-bold">{{ $kadep->nama }}</span>
                                                    @if ($dataSurvei->status == 'Approved 2' or $dataSurvei->status == 'Approved 3' or $dataSurvei->status == 'Rejected')
                                                        @if (session('user')->role == 'Admin')
                                                            <a href="#!" data-toggle="modal"
                                                                data-target=".modalKadep"
                                                                class="badge badge-warning pull-right komenKadep"
                                                                data-tanggal="{{ date('d-M-Y', strtotime($dataSurvei->approve_kadep)) }}"
                                                                data-komen="{{ $dataSurvei->ket_kadin1 }}"><i
                                                                    class="fa fa-pencil mr-1"></i>Edit
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if ($dataSurvei->ket_kadin1 != '')
                                                        <br>
                                                        <span
                                                            class="text-muted">{{ $dataSurvei->ket_kadin1 }}<br>{{ date('d-m-Y H:i:s', strtotime($dataSurvei->approve_kadep)) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="200px">
                                                    Division Head
                                                </th>
                                                <td class="pt-2 pb-2 text-capitalize">
                                                    <?php
                                                    $kadiv = DB::table('TBL_USER')->select('TBL_USER.*')->where('username', $dataEvaluasi->kadiv)->first();
                                                    ?>
                                                    <span class="font-weight-bold">{{ $kadiv->nama }}</span>
                                                    @if ($dataSurvei->status == 'Approved 3' or $dataSurvei->status == 'Rejected')
                                                        @if (session('user')->role == 'Admin')
                                                            <a href="#!" data-toggle="modal"
                                                                data-target=".modalKadiv"
                                                                class="badge badge-warning pull-right komenKadiv"
                                                                data-tanggal="{{ date('d-M-Y', strtotime($dataSurvei->approve_kadiv)) }}"
                                                                data-komen="{{ $dataSurvei->ket_kadiv }}"><i
                                                                    class="fa fa-pencil mr-1"></i>Edit
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if ($dataSurvei->ket_kadiv != '')
                                                        <br>
                                                        <span
                                                            class="text-muted">{{ $dataSurvei->ket_kadiv }}<br>{{ date('d-m-Y H:i:s', strtotime($dataSurvei->approve_kadiv)) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="pt-2 pb-2" width="250px">
                                                    Created By
                                                </th>
                                                <td class="pt-2 pb-2 text-capitalize">
                                                    <span class="font-weight-bold">{{ $maker->nama }}</span><br>
                                                    <span
                                                        class="text-muted">{{ date('d-m-Y H:i:s', strtotime($dataSurvei->create_date)) }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                @if ($jumlahEvaluasi > 0)
                                    @if ($dataEvaluasi->status == 'Survei')
                                        <div class="p-20">
                                            <div class="alert alert-warning"><i
                                                    class="fa fa-warning text-warning"></i>&nbsp;
                                                Survei proposal belum dilakukan
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-20">
                                            <div class="alert alert-info"><i
                                                    class="fa fa-info-circle text-info"></i>&nbsp;
                                                Survei dilakukan setelah evaluasi proposal disetujui oleh Division Head
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </div>
                        <div class="tab-pane p-2" id="evaluasi3" role="tabpanel">
                            <button class="btn btn-secondary mb-2" data-toggle="modal" data-target=".modal-payment"><i
                                    class="fa fa-plus mr-2"></i>Add Payment
                            </button>
                            @if ($jumlahPembayaran > 0)
                                <table class="table table-sm table-striped table-bordered table-hover">
                                    <thead style="background-color: #FFCCBC;">
                                        <tr>
                                            <th width="350px">Deskripsi</th>
                                            <th class="text-center" width="150px">Nominal</th>
                                            <th class="text-center" width="50px">Termin</th>
                                            <th class="text-center" width="100px">Status</th>
                                            <th class="text-center" width="100px">PR ID</th>
                                            <th class="text-center" width="50px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataPembayaran as $dp)
                                            <tr>
                                                <td>
                                                    Pembayaran
                                                    atas {{ $data->bantuan_untuk }} {{ $data->asal_surat }}
                                                    {{ $data->provinsi }}
                                                </td>
                                                <td class="text-right">
                                                    Rp. {{ number_format($dp->jumlah_pembayaran, 0, ',', '.') }}</td>
                                                <td class="text-center">{{ $dp->termin }}</td>
                                                <td class="text-center">
                                                    @if ($dp->status == 'New')
                                                        <span class="label label-warning text-dark">New</span>
                                                    @elseif($dp->status == 'exported')
                                                        <span class="label label-success">Exported</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-danger font-bold">{{ $dp->pr_id }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"><i
                                                                class="fa fa-gear font-18 text-info"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            @if ($dp->status == 'New' or $dp->status == '')
                                                                <a class="dropdown-item" href="#">
                                                                    <i
                                                                        class="fa fa-pencil text-primary font-18 mr-2"></i>Edit</a>
                                                                <a class="dropdown-item deletePembayaran"
                                                                    data-id="{{ encrypt($dp->id_pembayaran) }}"
                                                                    href="javascript:void(0)"><i
                                                                        class="fa fa-trash text-danger font-18 mr-2"></i>Delete</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('exportPembayaran', encrypt($dp->id_pembayaran)) }}">
                                                                    <i
                                                                        class="fa fa-send text-success font-14 mr-2"></i>Export
                                                                    to Popay</a>
                                                            @elseif($dp->status == 'exported')
                                                                <a class="dropdown-item reset"
                                                                    href="{{ env('BASEURL') . '/app/pr/update/viewPaymentRequest/' . $dp->id_pr }}"><i
                                                                        class="fa fa-info-circle text-info mr-2"></i>Reset</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-warning"><i class="fa fa-warning text-warning"></i>&nbsp;
                                    List Pembayaran belum ada
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                {{--                <div class="card"> --}}
                {{--                    <div class="card-body"> --}}
                {{--                        <h5 class="card-title">Log Status</h5> --}}
                {{--                    </div> --}}
                {{--                    <!-- ============================================================== --> --}}
                {{--                    <!-- Comment widgets --> --}}
                {{--                    <!-- ============================================================== --> --}}
                {{--                    <div class="comment-widgets"> --}}
                {{--                        <!-- Comment Row --> --}}
                {{--                        <div class="d-flex no-block comment-row"> --}}
                {{--                            <div class="p-2"><span class="round"><img --}}
                {{--                                            src="{{ asset('template/assets/images/icon/man.png') }}" --}}
                {{--                                            alt="user" width="50"></span></div> --}}
                {{--                            <div class="comment-text w-100"> --}}
                {{--                                <h5 class="font-medium">James Anderson</h5> --}}
                {{--                                <p class="m-b-10 text-muted">Lorem Ipsum is simply dummy text of the printing and --}}
                {{--                                    type --}}
                {{--                                    setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the --}}
                {{--                                    printing and type setting industry.</p> --}}
                {{--                                <div class="comment-footer"> --}}
                {{--                                    <span class="text-muted pull-right">April 14, 2016</span> <span --}}
                {{--                                            class="badge badge-pill badge-info">Pending</span> <span --}}
                {{--                                            class="action-icons"> --}}
                {{--                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a> --}}
                {{--                                                    <a href="javascript:void(0)"><i class="ti-check"></i></a> --}}
                {{--                                                    <a href="javascript:void(0)"><i class="ti-heart"></i></a> --}}
                {{--                                                </span> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}
                {{--                        </div> --}}
                {{--                        <!-- Comment Row --> --}}
                {{--                        <div class="d-flex no-block comment-row border-top"> --}}
                {{--                            <div class="p-2"><span class="round"><img --}}
                {{--                                            src="{{ asset('template/assets/images/icon/man.png') }}" --}}
                {{--                                            alt="user" width="50"></span></div> --}}
                {{--                            <div class="comment-text active w-100"> --}}
                {{--                                <h5 class="font-medium">Michael Jorden</h5> --}}
                {{--                                <p class="m-b-10 text-muted">Lorem Ipsum is simply dummy text of the printing and --}}
                {{--                                    type --}}
                {{--                                    setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the --}}
                {{--                                    printing and type setting industry..</p> --}}
                {{--                                <div class="comment-footer"> --}}
                {{--                                    <span class="text-muted pull-right">April 14, 2016</span> --}}
                {{--                                    <span class="badge badge-pill badge-success">Approved</span> --}}
                {{--                                    <span class="action-icons active"> --}}
                {{--                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a> --}}
                {{--                                                    <a href="javascript:void(0)"><i class="icon-close"></i></a> --}}
                {{--                                                    <a href="javascript:void(0)"><i --}}
                {{--                                                                class="ti-heart text-danger"></i></a> --}}
                {{--                                                </span> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}
                {{--                        </div> --}}
                {{--                        <!-- Comment Row --> --}}
                {{--                        <div class="d-flex no-block comment-row border-top"> --}}
                {{--                            <div class="p-2"><span class="round"><img --}}
                {{--                                            src="{{ asset('template/assets/images/icon/man.png') }}" --}}
                {{--                                            alt="user" width="50"></span></div> --}}
                {{--                            <div class="comment-text w-100"> --}}
                {{--                                <h5 class="font-medium">Johnathan Doeting</h5> --}}
                {{--                                <p class="m-b-10 text-muted">Lorem Ipsum is simply dummy text of the printing and --}}
                {{--                                    type --}}
                {{--                                    setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the --}}
                {{--                                    printing and type setting industry.</p> --}}
                {{--                                <div class="comment-footer"> --}}
                {{--                                    <span class="text-muted pull-right">April 14, 2016</span> --}}
                {{--                                    <span class="badge badge-pill badge-danger">Rejected</span> --}}
                {{--                                    <span class="action-icons"> --}}
                {{--                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a> --}}
                {{--                                                    <a href="javascript:void(0)"><i class="ti-check"></i></a> --}}
                {{--                                                    <a href="javascript:void(0)"><i class="ti-heart"></i></a> --}}
                {{--                                                </span> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}
                {{--                        </div> --}}
                {{--                        <!-- Comment Row --> --}}
                {{--                        <div class="d-flex no-block comment-row border-top"> --}}
                {{--                            <div class="p-2"> --}}
                {{--                                <span class="round"> --}}
                {{--                                    @if (session('user')->foto == '') --}}
                {{--                                        <img src="{{ asset('template/assets/images/icon/man.png') }}" alt="user" --}}
                {{--                                             width="50"> --}}
                {{--                                    @else --}}
                {{--                                        <img src="{{ asset('avatar/'.session('user')->foto.'.jpg') }}" alt="user" --}}
                {{--                                             width="50"> --}}
                {{--                                    @endif --}}
                {{--                                </span> --}}
                {{--                            </div> --}}
                {{--                            <div class="comment-text active w-100"> --}}
                {{--                                <h5 class="font-medium">Genelia doe</h5> --}}
                {{--                                <p class="m-b-10 text-muted">Lorem Ipsum is simply dummy text of the printing and --}}
                {{--                                    type --}}
                {{--                                    setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the --}}
                {{--                                    printing and type setting industry..</p> --}}
                {{--                                <div class="comment-footer"> --}}
                {{--                                    <span class="text-muted pull-right">April 14, 2016</span> --}}
                {{--                                    <span class="badge badge-pill badge-success">Approved</span> --}}
                {{--                                    <span class="action-icons active"> --}}
                {{--                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a> --}}
                {{--                                                    <a href="javascript:void(0)"><i class="icon-close"></i></a> --}}
                {{--                                                    <a href="javascript:void(0)"><i --}}
                {{--                                                                class="ti-heart text-danger"></i></a> --}}
                {{--                                                </span> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}
                {{--                        </div> --}}
                {{--                    </div> --}}
                {{--                </div> --}}
                <div class="card">
                    <div class="card-body p-b-0">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title mb-5 font-weight-bold model-huruf-family">LAMPIRAN</h5>
                            </div>
                            <div class="ml-auto">
                                @if ($data->ykpp == 'Yes')
                                    @if ($data->status_ykpp == 'Open')
                                        <a href="#!" class="btn btn-sm btn-info approveYKPP"
                                            data-id="{{ encrypt($data->id_kelayakan) }}">
                                            <i class="fa fa-check-circle mr-2"></i>Approve Document
                                        </a>
                                    @endif
                                @endif
                                <button type="button" data-toggle="modal" data-target=".modal-lampiran"
                                    class="btn btn-sm btn-success"><i class="fa fa-plus-circle mr-2"></i>Add
                                    File
                                </button>
                            </div>
                        </div>
                    </div>
                    @if ($jumlahLampiran->jumlah > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="500px">Nama File</th>
                                        <th width="100px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataLampiran as $dl)
                                        <tr>
                                            <td class="pt-2 pb-2">{{ $dl->nama }}</td>
                                            <td class="pt-2 pb-2" nowrap>
                                                <a href="#!" class="edit-lampiran" data-toggle="modal"
                                                    data-target=".modal-lampiran-edit"
                                                    lampiran-id="{{ encrypt($dl->id_lampiran) }}"
                                                    lampiran-tanggal="{{ date('d-M-Y', strtotime($dl->upload_date)) }}"
                                                    lampiran-nama="{{ $dl->nama }}"><i class="fa fa-pencil"
                                                        data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                        style="font-size: 18px"></i>
                                                </a>
                                                <a href="#!" class="delete" data-toggle="tooltip"
                                                    data-placement="bottom" title="Delete"
                                                    lampiran-id="{{ encrypt($dl->id_lampiran) }}"><i
                                                        class="fa fa-trash text-danger" style="font-size: 18px"></i>
                                                </a>
                                                <a href="/attachment/{{ $dl->lampiran }}" data-toggle="tooltip"
                                                    data-placement="bottom" title="Download" target="_blank"><i
                                                        class="fa fa-download text-info" style="font-size: 18px"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mr-3 ml-3">
                            Tidak ada file tersimpan
                        </div>
                    @endif
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold model-huruf-family">DOKUMEN LINK</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="500px">Nama File</th>
                                    <th width="100px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($jumlahEvaluasi > 0)
                                    <tr>
                                        <td class="pt-2 pb-2">Form Evaluasi</td>
                                        <td class="pt-2 pb-2 text-right pr-4" nowrap>
                                            <a href="{{ route('form-evaluasi', $data->id_kelayakan) }}"
                                                data-toggle="tooltip" data-placement="bottom" title="Download"
                                                target="_blank"><i class="fa fa-download text-info"
                                                    style="font-size: 18px"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                                @if ($jumlahSurvei > 0)
                                    <tr>
                                        <td class="pt-2 pb-2">Form Survei</td>
                                        <td class="pt-2 pb-2 text-right pr-4">
                                            <a href="{{ route('form-survei', $data->id_kelayakan) }}"
                                                data-toggle="tooltip" data-placement="bottom" title="Download"
                                                target="_blank"><i class="fa fa-download text-info"
                                                    style="font-size: 18px"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold model-huruf-family">DOKUMEN LEGAL
                            @if ($jumlahSurveiApproved->jumlah > 0)
                                @if ($jumlahLegal->jumlah == 0)
                                    <div class="btn-group pull-right">
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Create Document
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($jumlahBAST->jumlah == 0)
                                                @if ($dataSurvei->bantuan_berupa == 'Barang')
                                                    <a class="dropdown-item"
                                                        href="{{ route('bast-dana', encrypt($data->no_agenda)) }}">BAST
                                                        Barang</a>
                                                @endif
                                                @if ($dataSurvei->bantuan_berupa == 'Dana')
                                                    <a class="dropdown-item"
                                                        href="{{ route('bast-dana', encrypt($data->no_agenda)) }}">BAST
                                                        Dana</a>
                                                @endif
                                                @if ($dataSurvei->bantuan_berupa == 'Barang & Dana')
                                                    <a class="dropdown-item" href="javascript:void(0)">BAST
                                                        Barang &
                                                        Dana</a>
                                                @endif
                                            @endif
                                            @if ($jumlahSPK->jumlah == 0)
                                                <a class="dropdown-item"
                                                    href="{{ route('input-spk', encrypt($data->no_agenda)) }}">SPK</a>
                                            @endif
                                            @if ($jumlahPKS->jumlah == 0)
                                                <a class="dropdown-item" href="javascript:void(0)">PKS</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </h5>
                    </div>
                    @if ($jumlahSurveiApproved->jumlah == 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="500px">Jenis Dokumen</th>
                                        <th width="100px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="pt-2 pb-2">Surat Penolakan</td>
                                        <td class="pt-2 pb-2">
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                href="{{ route('ubah-bast-dana', encrypt($data->no_agenda)) }}">
                                                <i class="fa fa-pencil" style="font-size: 18px"></i>
                                            </a>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Delete"
                                                href="#!" class="deleteBAST"
                                                no-agenda="{{ encrypt($data->no_agenda) }}"><i
                                                    class="fa fa-trash text-danger" style="font-size: 18px"></i>
                                            </a>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                href="{{ route('surat-penolakan', $ID) }}" target="_blank"><i
                                                    class="fa fa-download text-info" style="font-size: 18px"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($jumlahSurveiApproved->jumlah > 0)
                        @if ($jumlahBAST->jumlah > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="500px">Jenis Dokumen</th>
                                            <th width="100px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="pt-2 pb-2">BAST Copy 1</td>
                                            <td class="pt-2 pb-2">
                                                <a data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                    href="{{ route('ubah-bast-dana', encrypt($data->no_agenda)) }}">
                                                    <i class="fa fa-pencil" style="font-size: 18px"></i>
                                                </a>
                                                <a data-toggle="tooltip" data-placement="bottom" title="Delete"
                                                    href="#!" class="deleteBAST"
                                                    no-agenda="{{ encrypt($data->no_agenda) }}"><i
                                                        class="fa fa-trash text-danger" style="font-size: 18px"></i>
                                                </a>
                                                @if ($jenis == 'Bulanan')
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTDana', encrypt($ID)) }}"
                                                        target="_blank"><i class="fa fa-download text-info"
                                                            style="font-size: 18px"></i>
                                                    </a>
                                                @elseif($data->jenis == 'Santunan')
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTDana', encrypt($ID)) }}"
                                                        target="_blank"><i class="fa fa-download text-info"
                                                            style="font-size: 18px"></i>
                                                    </a>
                                                @elseif($jenis == 'Idul Adha')
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTIdulAdha', $ID) }}" target="_blank"><i
                                                            class="fa fa-download text-info" style="font-size: 18px"></i>
                                                    </a>
                                                @elseif($data->jenis == 'Natal')
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTDana', encrypt($ID)) }}"
                                                        target="_blank"><i class="fa fa-download text-info"
                                                            style="font-size: 18px"></i>
                                                    </a>
                                                @elseif($jenis == 'Aspirasi')
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTDana', encrypt($ID)) }}"
                                                        target="_blank"><i class="fa fa-download text-info"
                                                            style="font-size: 18px"></i>
                                                    </a>
                                                @else
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTDana', encrypt($ID)) }}"
                                                        target="_blank"><i class="fa fa-download text-info"
                                                            style="font-size: 18px"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pt-2 pb-2">BAST Copy 2</td>
                                            <td class="pt-2 pb-2">
                                                <a href="javascript:void (0)">
                                                    <i class="fa fa-pencil text-muted" style="font-size: 18px"></i>
                                                </a>
                                                <a href="javascript:void (0)">
                                                    <i class="fa fa-trash text-muted" style="font-size: 18px"></i>
                                                </a>
                                                @if ($jenis == 'Bulanan')
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTDana2', encrypt($ID)) }}"
                                                        target="_blank"><i class="fa fa-download text-info"
                                                            style="font-size: 18px"></i>
                                                    </a>
                                                @elseif($data->jenis == 'Santunan')
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTDana2', encrypt($ID)) }}"
                                                        target="_blank"><i class="fa fa-download text-info"
                                                            style="font-size: 18px"></i>
                                                    </a>
                                                @elseif($jenis == 'Idul Adha')
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTIdulAdha', $ID) }}" target="_blank"><i
                                                            class="fa fa-download text-info" style="font-size: 18px"></i>
                                                    </a>
                                                @elseif($data->jenis == 'Natal')
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTDana2', encrypt($ID)) }}"
                                                        target="_blank"><i class="fa fa-download text-info"
                                                            style="font-size: 18px"></i>
                                                    </a>
                                                @elseif($jenis == 'Aspirasi')
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTDana2', encrypt($ID)) }}"
                                                        target="_blank"><i class="fa fa-download text-info"
                                                            style="font-size: 18px"></i>
                                                    </a>
                                                @else
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('formBASTDana2', encrypt($ID)) }}"
                                                        target="_blank"><i class="fa fa-download text-info"
                                                            style="font-size: 18px"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <?php
                                        $pembayaran = \App\Models\ViewPembayaran::where('no_agenda', $noAgenda)->get();
                                        ?>
                                        @foreach ($pembayaran as $pem)
                                            <tr>
                                                <td class="pt-2 pb-2">Kuitansi {{ $pem->termin }}</td>
                                                <td class="pt-2 pb-2">
                                                    <a href="javascript:void (0)">
                                                        <i class="fa fa-pencil text-muted" style="font-size: 18px"></i>
                                                    </a>
                                                    <a href="javascript:void (0)">
                                                        <i class="fa fa-trash text-muted" style="font-size: 18px"></i>
                                                    </a>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Download"
                                                        href="{{ route('kwitansi', $pem->id_pembayaran) }}"
                                                        target="_blank"><i class="fa fa-download text-info"
                                                            style="font-size: 18px"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-warning mr-3 ml-3">
                                    Tidak ada dokumen tersimpan
                                </div>
                        @endif
                    @else
                        <div class="alert alert-warning mr-3 ml-3">
                            Dokumen legal belum bisa ditambahkan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>

    <form method="post" action="{{ action('EvaluasiController@editkadepEvaluasi') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-ubahKadepEvaluasi" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">CHANGE APPROVAL</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group">
                            <label>Depertment Head Operation <span class="text-danger">*</span></label>
                            <select class="form-control" name="namaKadep">
                                <option value="sigit.sukamto">Sigit Tri Hartanto Sukamto</option>
                                <option value="erick.taufan">Erick Taufan</option>
                            </select>
                            @if ($errors->has('namaKadep'))
                                <small class="text-danger">Depertment Head Operation harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('SurveiController@editkadepSurvei') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-ubahKadepSurvei" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">CHANGE APPROVAL</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group">
                            <label>Depertment Head Operation <span class="text-danger">*</span></label>
                            <select class="form-control" name="namaKadep">
                                <option value="sigit.sukamto">Sigit Tri Hartanto Sukamto</option>
                                <option value="erick.taufan">Erick Taufan</option>
                            </select>
                            @if ($errors->has('namaKadep'))
                                <small class="text-danger">Depertment Head Operation harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('EvaluasiController@editTanggal1') }}">
        {{ csrf_field() }}
        <div class="modal fade modalEvaluator" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">EDIT COMMENT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker-autoclose" name="tanggalEvaluator1"
                                    id="tanggalEvaluator1">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            @if ($errors->has('tanggalEvaluator1'))
                                <small class="text-danger">Tanggal harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Komentar <span class="text-danger">*</span></label>
                            <textarea rows="3" class="form-control" name="komentarEvaluator" id="komentarEvaluator"></textarea>
                            @if ($errors->has('komentarEvaluator'))
                                <small class="text-danger">Komentar harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('EvaluasiController@editTanggal2') }}">
        {{ csrf_field() }}
        <div class="modal fade modalEvaluator2" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">EDIT TANGGAL</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker-autoclose" name="tanggalEvaluator2"
                                    id="tanggalEvaluator2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            @if ($errors->has('tanggalEvaluator2'))
                                <small class="text-danger">Tanggal harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('EvaluasiController@editTanggal3') }}">
        {{ csrf_field() }}
        <div class="modal fade modalKadepEvaluasi" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">EDIT COMMENT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker-autoclose"
                                    name="tanggalKadepEvaluasi" id="tanggalKadepEvaluasi">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            @if ($errors->has('tanggalKadepEvaluasi'))
                                <small class="text-danger">Tanggal harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Komentar <span class="text-danger">*</span></label>
                            <textarea rows="3" class="form-control" name="komentarKadepEvaluasi" id="komentarKadepEvaluasi"></textarea>
                            @if ($errors->has('komentarKadepEvaluasi'))
                                <small class="text-danger">Komentar harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('EvaluasiController@editTanggal4') }}">
        {{ csrf_field() }}
        <div class="modal fade modalKadivEvaluasi" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">EDIT COMMENT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker-autoclose"
                                    name="tanggalKadivEvaluasi" id="tanggalKadivEvaluasi">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            @if ($errors->has('tanggalKadivEvaluasi'))
                                <small class="text-danger">Tanggal harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Komentar <span class="text-danger">*</span></label>
                            <textarea rows="3" class="form-control" name="komentarKadivEvaluasi" id="komentarKadivEvaluasi"></textarea>
                            @if ($errors->has('komentarKadivEvaluasi'))
                                <small class="text-danger">Komentar harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('SurveiController@editTanggal1') }}">
        {{ csrf_field() }}
        <div class="modal fade modalSurvei1" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">EDIT COMMENT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker-autoclose" name="tanggalSurvei1"
                                    id="tanggalSurvei1">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            @if ($errors->has('tanggalSurvei2'))
                                <small class="text-danger">Tanggal harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Komentar <span class="text-danger">*</span></label>
                            <textarea rows="3" class="form-control" name="komentarSurvei1" id="komentarSurvei1"></textarea>
                            @if ($errors->has('komentarSurvei1'))
                                <small class="text-danger">Komentar harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left"
                                data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('SurveiController@editTanggal2') }}">
        {{ csrf_field() }}
        <div class="modal fade modalSurvei2" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">EDIT COMMENT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker-autoclose" name="tanggalSurvei2"
                                    id="tanggalSurvei2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            @if ($errors->has('tanggalSurvei2'))
                                <small class="text-danger">Tanggal harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Komentar <span class="text-danger">*</span></label>
                            <textarea rows="3" class="form-control" name="komentarSurvei2" id="komentarSurvei2"></textarea>
                            @if ($errors->has('komentarSurvei2'))
                                <small class="text-danger">Komentar harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left"
                                data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('SurveiController@editTanggal3') }}">
        {{ csrf_field() }}
        <div class="modal fade modalKadep" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">EDIT COMMENT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker-autoclose" name="tanggalKadep"
                                    id="tanggalKadep">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            @if ($errors->has('tanggalKadep'))
                                <small class="text-danger">Tanggal harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Komentar <span class="text-danger">*</span></label>
                            <textarea rows="3" class="form-control" name="komentarKadep" id="komentarKadep"></textarea>
                            @if ($errors->has('komentarKadep'))
                                <small class="text-danger">Komentar harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left"
                                data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('SurveiController@editTanggal4') }}">
        {{ csrf_field() }}
        <div class="modal fade modalKadiv" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">EDIT COMMENT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker-autoclose" name="tanggalKadiv"
                                    id="tanggalKadiv">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            @if ($errors->has('tanggalKadiv'))
                                <small class="text-danger">Tanggal harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Komentar <span class="text-danger">*</span></label>
                            <textarea rows="3" class="form-control" name="komentarKadiv" id="komentarKadiv"></textarea>
                            @if ($errors->has('komentarKadiv'))
                                <small class="text-danger">Komentar harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left"
                                data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('LampiranController@uploadFile') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-lampiran" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">UPLOAD FILE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group {{ $errors->has('nama') ? ' has-danger' : '' }}">
                            <label>Jenis File <span class="text-danger">*</span></label>
                            <select class="form-control" name="nama">
                                <option></option>
                                <option>Surat Pengantar dan Proposal</option>
                                <option>Lampiran Evaluasi</option>
                                <option>KTP Ketua</option>
                                <option>KTP Bendahara</option>
                                <option>Buku Rekening Lembaga/Bendahara</option>
                                <option>Dokumentasi</option>
                                <option>Dokumentasi Tahap 1</option>
                                <option>Dokumentasi Tahap 2</option>
                                <option>Dokumentasi Tahap 3</option>
                                <option>Dokumentasi Tahap 4</option>
                                <option>BAST</option>
                                <option>SPPH</option>
                                <option>SPH</option>
                                <option>SPK</option>
                                <option>NPWP</option>
                                <option>E-NOFA</option>
                                <option>Amandemen SPK</option>
                                <option>BAST</option>
                                <option>BAP</option>
                                <option>PKS</option>
                                <option>MOM</option>
                                <option>BA Nego</option>
                                <option>Surat Permohonan Perubahan Dokumen</option>
                                <option>Surat Keterangan</option>
                                <option>Memo/Nota Dinas</option>
                                <option>Disposisi</option>
                                <option>BAP Tahap 1</option>
                                <option>BAP Tahap 2</option>
                                <option>BAP Tahap 3</option>
                                <option>BAP Tahap 4</option>
                                <option>Laporan Kegiatan Tahap 1</option>
                                <option>Laporan Kegiatan Tahap 2</option>
                                <option>Laporan Kegiatan Tahap 3</option>
                                <option>Laporan Kegiatan Tahap 4</option>
                                <option>Surat Permohonan Pembayaran Tahap 1</option>
                                <option>Surat Permohonan Pembayaran Tahap 2</option>
                                <option>Surat Permohonan Pembayaran Tahap 3</option>
                                <option>Surat Permohonan Pembayaran Tahap 4</option>
                                <option>Invoice Tahap 1</option>
                                <option>Invoice Tahap 2</option>
                                <option>Invoice Tahap 3</option>
                                <option>Invoice Tahap 4</option>
                                <option>Kwitansi Tahap 1</option>
                                <option>Kwitansi Tahap 2</option>
                                <option>Kwitansi Tahap 3</option>
                                <option>Kwitansi Tahap 4</option>
                                <option>Faktur Pajak Tahap 1</option>
                                <option>Faktur Pajak Tahap 2</option>
                                <option>Faktur Pajak Tahap 3</option>
                                <option>Faktur Pajak Tahap 4</option>
                                <option>Lainnya</option>
                            </select>
                            @if ($errors->has('nama'))
                                <small class="text-danger">Jenis dokumen harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('lampiran') ? ' has-danger' : '' }}">
                            <label>Lampiran <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="lampiran">
                            @if ($errors->has('lampiran'))
                                <small class="text-danger">File dokumen harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left"
                                data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-save mr-2"></i>Save
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('LampiranController@uploadFile') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-amandemen" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">CREATE AMENDMENT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($noAgenda) }}">
                        <div class="form-group {{ $errors->has('nama') ? ' has-danger' : '' }}">
                            <label>Nomor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nomorAmandemen">
                            @if ($errors->has('nomorAmandemen'))
                                <small class="text-danger">Nomor amandemen harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Nilai Amandemen <span class="text-danger">*</span></label>
                            <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                id="nilaiRupiahAmandemen" name="nilaiAmandemen">
                            @if ($errors->has('nilaiAmandemen'))
                                <small class="text-danger">Nilai amandemen harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('lampiran') ? ' has-danger' : '' }}">
                            <label>Lampiran <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="lampiran">
                            @if ($errors->has('lampiran'))
                                <small class="text-danger">File dokumen harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left"
                                data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-save mr-2"></i>Save
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('LampiranController@editFile') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-lampiran-edit" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-bold" id="myLargeModalLabel">EDIT LAMPIRAN</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="idlampiran" id="idlampiran">
                        <div class="form-group">
                            <label>Nama File <span class="text-danger">*</span></label>
                            <select class="form-control" name="nama" id="namaFile">
                                <option></option>
                                <option>Surat Pengantar dan Proposal</option>
                                <option>Lampiran Evaluasi</option>
                                <option>KTP Ketua</option>
                                <option>KTP Bendahara</option>
                                <option>Buku Rekening Lembaga/Bendahara</option>
                                <option>Dokumentasi</option>
                                <option>BAST</option>
                                <option>SPK</option>
                                <option>BAST</option>
                                <option>PKS</option>
                                <option>Amandemen Kontrak</option>
                                <option>MOM</option>
                                <option>BA Nego</option>
                                <option>Memo/Nota Dinas</option>
                                <option>Disposisi</option>
                                <option>Lainnya</option>
                            </select>
                            @if ($errors->has('nama'))
                                <small class="text-danger">Jenis dokumen harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Tanggal Upload <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker-autoclose" name="tanggal"
                                    id="tanggalFile" value="{{ old('tanggal') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            @if ($errors->has('tanggal'))
                                <small class="text-danger">Tanggal harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left"
                                data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('SurveiController@insertSurvei') }}">
        {{ csrf_field() }}
        <div class="modal fade modalNilaiEvaluasi2" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">EDIT NOMINAL</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label>Nominal <span class="text-danger">*</span></label>
                            <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                id="nilaiEvaluasi" name="nilaiEvaluasi">
                            @if ($errors->has('nilaiEvaluasi'))
                                <small class="text-danger">Nominal harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left"
                                data-dismiss="modal"><i class="fa fa-times-circle mr-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check-circle mr-2"></i>Submit
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('SurveiController@updateNilaiSurvei') }}">
        {{ csrf_field() }}
        <div class="modal fade modalNilaiSurvei" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">EDIT NOMINAL</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nominal <span class="text-danger">*</span></label>
                            <input type="hidden" name="noAgenda" value="{{ encrypt($noAgenda) }}">
                            <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                id="nilaiRupiah" name="nilaiSurvei">
                            @if ($errors->has('nilaiSurvei'))
                                <small class="text-danger">Nominal harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <label>Catatan <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="3" name="catatanSurvei" id="catatanSurvei"></textarea>
                            @if ($errors->has('catatanSurvei'))
                                <small class="text-danger">Catatan harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left"
                                data-dismiss="modal"><i class="fa fa-times-circle mr-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check-circle mr-2"></i>Submit
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('PembayaranController@storePembayaran') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-payment" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">ADD PAYMENT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($noAgenda) }}">
                        <div class="form-group">
                            <label>No Invoice <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" name="noInvoice"
                                value="{{ old('noInvoice') }}">
                            @if ($errors->has('noInvoice'))
                                <small class="text-danger">No invoice pembayaran harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Jumlah Pembayaran <span class="text-danger">*</span></label>
                            <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                name="jumlahPembayaran" value="{{ old('jumlahPembayaran') }}" id="jumlahPembayaran">
                            <input type="hidden" class="form-control" name="nilaiPembayaran"
                                value="{{ old('nilaiPembayaran') }}" id="nilaiPembayaran">
                            @if ($errors->has('jumlahPembayaran'))
                                <small class="text-danger">Jumlah pembayaran harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Termin Pembayaran <span class="text-danger">*</span></label>
                            <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                name="termin" value="{{ old('termin') }}">
                            @if ($errors->has('termin'))
                                <small class="text-danger">Termin pembayaran harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left"
                                data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-save mr-2"></i>Save
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('KelayakanController@updateProker') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-editProker" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family">EDIT PROGRAM KERJA</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda"
                            value="{{ encrypt($noAgenda) }}">
                        <input type="hidden" class="form-control" name="prokerID" id="prokerID" readonly>
                        <button type="button" class="btn btn-sm btn-secondary" data-target=".modal-proker"
                            data-toggle="modal"><i class="fa fa-search mr-2"></i>Cari Program Kerja
                        </button>
                        <hr>
                        <div class="form-group mt-4">
                            <label>Program Kerja</label>
                            <textarea rows="2" class="form-control bg-white text-dark" name="proker" id="proker" readonly>Otomatis By System</textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Pilar</label>
                                <input type="text" class="form-control bg-white text-dark" name="pilar"
                                    id="pilar" placeholder="Otomatis By System" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Gols</label>
                                <input type="text" class="form-control bg-white text-dark" name="gols"
                                    id="gols" placeholder="Otomatis By System" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left"
                                data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check-circle mr-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade modal-proker" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title model-huruf-family font-weight-bold">DAFTAR PROGRAM KERJA</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="example5 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="10px" style="text-align:center;">No</th>
                                    <th class="text-center" width="400px">Program Kerja</th>
                                    <th class="text-center" width="300px">SDGs</th>
                                    <th class="text-center" width="50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataProker as $proker)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="font-weight-bold">{{ $proker->proker }}</span>
                                            @if ($proker->prioritas != '')
                                                <br>
                                                <span class="text-muted">{{ $proker->prioritas }}</span>
                                            @else
                                                <br>
                                                <span class="text-danger">Non Prioritas</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="font-weight-bold">{{ $proker->pilar }}</span>
                                            <br>
                                            <span class="text-muted">{{ $proker->gols }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#!" class="pilih btn btn-sm btn-success"
                                                prokerID="{{ $proker->id_proker }}" proker="{{ $proker->proker }}"
                                                prioritas="{{ $proker->prioritas }}" pilar="{{ $proker->pilar }}"
                                                gols="{{ $proker->gols }}">Pilih
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script>
        $(document).on('click', '.pilih', function(e) {
            document.getElementById("prokerID").value = $(this).attr('prokerID');
            document.getElementById("proker").value = $(this).attr('proker');
            document.getElementById("pilar").value = $(this).attr('pilar');
            document.getElementById("gols").value = $(this).attr('gols');
            $('.modal-proker').modal('hide');
        });
    </script>

    <script>
        $(document).on('click', '.updateNilaiSurvei', function(e) {
            document.getElementById("nilaiRupiah").value = $(this).attr('data-nilai');
            document.getElementById("catatanSurvei").value = $(this).attr('data-catatan');
        });
    </script>

    <script>
        $('#namaBank').on('change', function() {
            var kodeBank = $('#namaBank option:selected').attr('kodeBank');
            $('#kodeBank').val(kodeBank);
        });

        $('#kota').on('change', function() {
            var kodeKota = $('#kota option:selected').attr('kodeKota');
            $('#kodeKota').val(kodeKota);
        });
    </script>

    <script>
        var nilai = '';

        function bukaTermin() {
            var x = document.getElementById("selectTermin").value;
            if (x == 1) {
                document.getElementById("termin1").value = 100;
                document.getElementById("termin2").value = '';
                document.getElementById("termin3").value = '';
                document.getElementById("termin4").value = '';
                $(".termin1").show();
                $(".termin2").hide();
                $(".termin3").hide();
                $(".termin4").hide();
            }
            if (x == 2) {
                document.getElementById("termin1").value = 50;
                document.getElementById("termin2").value = 50;
                document.getElementById("termin3").value = '';
                document.getElementById("termin4").value = '';
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").hide();
                $(".termin4").hide();
            }
            if (x == 3) {
                document.getElementById("termin1").value = 50;
                document.getElementById("termin2").value = 30;
                document.getElementById("termin3").value = 20;
                document.getElementById("termin4").value = '';
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").show();
                $(".termin4").hide();
            }
            if (x == 4) {
                document.getElementById("termin1").value = 25;
                document.getElementById("termin2").value = 25;
                document.getElementById("termin3").value = 25;
                document.getElementById("termin4").value = 25;
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").show();
                $(".termin4").show();
            }
        }
    </script>

    <script>
        $(document).on('click', '.komenEvaluator2', function(e) {
            document.getElementById("tanggalEvaluator2").value = $(this).attr('data-tanggal');
        });

        $(document).on('click', '.komenEvaluator', function(e) {
            document.getElementById("tanggalEvaluator1").value = $(this).attr('data-tanggal');
            document.getElementById("komentarEvaluator").value = $(this).attr('data-komen');
        });

        $(document).on('click', '.komenKadepEvaluasi', function(e) {
            document.getElementById("tanggalKadepEvaluasi").value = $(this).attr('data-tanggal');
            document.getElementById("komentarKadepEvaluasi").value = $(this).attr('data-komen');
        });

        $(document).on('click', '.komenKadivEvaluasi', function(e) {
            document.getElementById("tanggalKadivEvaluasi").value = $(this).attr('data-tanggal');
            document.getElementById("komentarKadivEvaluasi").value = $(this).attr('data-komen');
        });

        $(document).on('click', '.komenSurvei1', function(e) {
            document.getElementById("tanggalSurvei1").value = $(this).attr('data-tanggal');
            document.getElementById("komentarSurvei1").value = $(this).attr('data-komen');
        });

        $(document).on('click', '.komenSurvei2', function(e) {
            document.getElementById("tanggalSurvei2").value = $(this).attr('data-tanggal');
            document.getElementById("komentarSurvei2").value = $(this).attr('data-komen');
        });

        $(document).on('click', '.komenKadep', function(e) {
            document.getElementById("tanggalKadep").value = $(this).attr('data-tanggal');
            document.getElementById("komentarKadep").value = $(this).attr('data-komen');
        });

        $(document).on('click', '.komenKadiv', function(e) {
            document.getElementById("tanggalKadiv").value = $(this).attr('data-tanggal');
            document.getElementById("komentarKadiv").value = $(this).attr('data-komen');
        });

        $(document).on('click', '.edit-lampiran', function(e) {
            document.getElementById("idlampiran").value = $(this).attr('lampiran-id');
            document.getElementById("namaFile").value = $(this).attr('lampiran-nama');
            document.getElementById("tanggalFile").value = $(this).attr('lampiran-tanggal');
        });

        $(document).on('click', '.edit-bank', function(e) {
            document.getElementById("noRekening").value = $(this).attr('data-noRekening');
            document.getElementById("atasNama").value = $(this).attr('data-atasNama');
            document.getElementById("namaBank").value = $(this).attr('data-namaBank');
            document.getElementById("kodeBank").value = $(this).attr('data-kodeBank');
            document.getElementById("kota").value = $(this).attr('data-kotaBank');
            document.getElementById("kodeKota").value = $(this).attr('data-kodeKota');
            document.getElementById("cabangBank").value = $(this).attr('data-cabangBank');
        });

        $('.delete').click(function() {
            var lampiran_id = $(this).attr('lampiran-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus file ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "/proposal/delete-file/" + lampiran_id + "";
                });
        });

        $('.deleteBAST').click(function() {
            var no_agenda = $(this).attr('no-agenda');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus BAST ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "/DokumenLegal/delete-BAST/" + no_agenda + "";
                });
        });

        $('.deleteSPK').click(function() {
            var no_agenda = $(this).attr('no-agenda');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus SPK ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "/DokumenLegal/delete-SPK/" + no_agenda + "";
                });
        });

        $('.forward').click(function() {
            var no_agenda = $(this).attr('data-noAgenda');
            swal({
                    title: "Yakin?",
                    text: "Anda akan meneruskan data ini ke Evaluator 2",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonClass: "btn-secondary",
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "/report/forward-evaluasi/" + no_agenda + "";
                });
        });

        $('.forwardSurvei').click(function() {
            var no_agenda = $(this).attr('data-noAgenda');
            swal({
                    title: "Yakin?",
                    text: "Anda akan meneruskan data ini ke Pelaksana Survei ke 2",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "/report/forward-survei/" + no_agenda + "";
                });
        });

        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>

    <script>
        $('.approveYKPP').click(function() {
            var data_id = $(this).attr('data-id');
            swal({
                    title: "Anda Yakin?",
                    text: "Akan memverifikasi kelengkapan dokumen untuk YKPP",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "/report/approveYKPP/" + data_id + "";
                });
        });
    </script>

    <script>
        var nilaiRupiah = document.getElementById('nilaiRupiah');
        nilaiRupiah.addEventListener('keyup', function(e) {
            nilaiRupiah.value = formatRupiah(this.value);
            nilaiBantuan.value = convertToAngka(this.value);
        });

        var nilaiRupiahAmandemen = document.getElementById('nilaiRupiahAmandemen');
        nilaiRupiahAmandemen.addEventListener('keyup', function(e) {
            nilaiRupiahAmandemen.value = formatRupiah(this.value);
            nilaiBantuan2.value = convertToAngka(this.value);
        });

        var jumlahPembayaran = document.getElementById('jumlahPembayaran');
        jumlahPembayaran.addEventListener('keyup', function(e) {
            jumlahPembayaran.value = formatRupiah(this.value);
            nilaiPembayaran.value = convertToAngka(this.value);
        });

        /* Fungsi */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        /* Fungsi */
        function convertToAngka(rupiah) {
            return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
        }
    </script>
@stop
