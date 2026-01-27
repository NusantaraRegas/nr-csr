@extends('layout.master')
@section('title', 'NR SHARE | Detail Kelayakan Proposal')

@section('content')
    <style>
        .thumbnail img {
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .thumbnail:hover img {
            transform: scale(1.05);
        }

        #modalImage.transition {
            transition: transform 0.3s ease;
        }
    </style>

    <style>
        .list-group-item:hover {
            background-color: #f8f9fa;
        }
    </style>

    <style>
        .badgeLog {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 8px;
        }
    </style>

    @if (!empty($nextApprover))
        @php
            if ($data->status == 'Evaluasi') {
                if (in_array($nextApprover->level, [1, 2])) {
                    $catatan = '';
                } elseif ($nextApprover->level == 3) {
                    $catatan = 'Untuk ditindaklanjuti sesuai peraturan yang berlaku';
                } elseif ($nextApprover->level == 4) {
                    $catatan = 'Untuk dapat diproses sesuai prosedur';
                } else {
                    $catatan = 'Untuk dapat diproses sesuai prosedur';
                }
            } elseif ($data->status == 'Survei') {
                if (in_array($nextApprover->level, [1])) {
                    $catatan = '';
                } elseif ($nextApprover->level == 2) {
                    $catatan = $survei->hasil_survei;
                } elseif ($nextApprover->level == 3) {
                    $catatan =
                        'Dilengkapi kelengkapan dokumen administrasi sesuai peraturan yang berlaku dengan usulan nilai bantuan Rp. ' .
                        number_format($survei->nilai_bantuan, 0, ',', '.');
                } elseif ($nextApprover->level == 4) {
                    $catatan =
                        'Dapat dibantu senilai Total Rp. ' .
                        number_format($survei->nilai_bantuan, 0, ',', '.') .
                        ' dibagi menjadi ' .
                        $survei->termin .
                        ' termin pembayaran';
                } else {
                    $catatan =
                        'Dapat dibantu senilai Total Rp. ' .
                        number_format($survei->nilai_bantuan, 0, ',', '.') .
                        ' dibagi menjadi ' .
                        $survei->termin .
                        ' termin pembayaran';
                }
            }
        @endphp
    @endif

    @php
        $previous = url()->previous();
        $urlDataKelayakan = route('dataKelayakan');
        $urlListYKPP = route('listPaymentYKPP');
        $urlIndexPembayaran = route('indexPembayaran');

        if (str_contains($previous, $urlDataKelayakan)) {
            $backUrl = $urlDataKelayakan;
        } elseif (str_contains($previous, $urlListYKPP)) {
            $backUrl = $urlListYKPP;
        } elseif (str_contains($previous, $urlIndexPembayaran)) {
            $backUrl = $urlIndexPembayaran;
        } else {
            $backUrl = route('dashboard');
        }
    @endphp

    <link rel="stylesheet" href="{{ asset('template/assets/node_modules/dropify/dist/css/dropify.min.css') }}">

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center justify-content-end">
                <h4 class="font-bold">
                    <a href="{{ $backUrl }}" class="text-c-blue">
                        <i class="fas fa-arrow-alt-circle-left text-info mr-1"></i>
                    </a>
                    DETAIL KELAYAKAN PROPOSAL
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item">Rekap Proposal</li>
                        <li class="breadcrumb-item active">Detail Kelayakan</li>
                    </ol>
                    @if (in_array($data->status, ['Evaluasi', 'Survei']))
                        @if (!empty($nextApprover))
                            @if ($nextApprover->id_user == session('user')->id_user)
                                <button class="btn btn-info d-none d-lg-block m-l-15" data-target=".modal-submit"
                                    data-toggle="modal">
                                    @if ($nextApprover->level == 1)
                                        <i class="fas fa-forward mr-2"></i>Submit {{ $data->status }}
                                    @else
                                        <i class="fas fa-check-circle mr-2"></i>Persetujuan {{ $data->status }}
                                    @endif
                                </button>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-b-0">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title font-weight-bold">
                                    <span class="mr-1">Detail Kelayakan</span>
                                    @if ($data->status == 'Draft')
                                        <span class="badge badge-warning font-bold font-12 text-dark">DRAFT</span>
                                    @elseif($data->status == 'Evaluasi')
                                        <span class="badge badge-success font-bold font-12">EVALUASI
                                            PROPOSAL</span>
                                    @elseif($data->status == 'Survei')
                                        <span class="badge badge-info font-bold font-12">SURVEI
                                            PROPOSAL</span>
                                    @elseif($data->status == 'Approved')
                                        <span class="badge badge-primary font-bold font-12 text-white">APPROVED</span>
                                    @elseif($data->status == 'Rejected')
                                        <span class="badge badge-danger font-bold font-12">REJECTED</span>
                                    @endif
                                </h5>
                                <h6 class="card-subtitle mb-3">
                                    {{ 'ID #' . $data->id_kelayakan }}
                                </h6>
                            </div>
                            <div class="ml-auto">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="far fa-edit text-info mr-2"></i>Update Detail
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            data-target=".modal-updateProposal" data-toggle="modal">Surat/Proposal</a>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            data-target=".modal-updatePenerima" data-toggle="modal">Penerima
                                            Manfaat</a>
                                        @if (!empty($data->nama_bank))
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                data-target=".modal-updateBank" data-toggle="modal">Informasi Bank</a>
                                        @endif
                                        <a class="dropdown-item" href="javascript:void(0)" data-target=".modal-proker"
                                            data-toggle="modal">Program Kerja</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home2"
                                role="tab"><span class="hidden-sm-up"><i class="far fa-file-alt"></i></span>
                                <span class="hidden-xs-down">SURAT/PROPOSAL</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#yayasan" role="tab"><span
                                    class="hidden-sm-up"><i class="fas fa-users"></i></span>
                                <span class="hidden-xs-down">PENERIMA MANFAAT</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messages2" role="tab"><span
                                    class="hidden-sm-up"><i class="fas fa-credit-card"></i></span> <span
                                    class="hidden-xs-down">INFORMASI BANK</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#proker2" role="tab"><span
                                    class="hidden-sm-up"><i class="fas fa-list"></i></span> <span
                                    class="hidden-xs-down">PROGRAM KERJA</span></a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="home2" role="tabpanel">
                            <div class="row p-4">
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Nomor Agenda
                                    </label>
                                    <div class="text-muted">{{ $data->no_agenda }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Tanggal Penerimaan
                                    </label>
                                    <div class="text-muted">
                                        {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($data->tgl_terima))) }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Pengirim
                                    </label>
                                    <div class="text-muted">{{ $data->pengirim }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Perihal
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->bantuan_untuk }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        No Surat
                                    </label>
                                    <div class="text-muted">{{ $data->no_surat }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Tanggal Surat
                                    </label>
                                    <div class="text-muted">
                                        {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($data->tgl_surat))) }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Sifat Surat
                                    </label>
                                    <div class="text-muted">
                                        @if ($data->sifat == 'Biasa')
                                            <span class="badge font-12 badge-success">Biasa</span>
                                        @elseif($data->sifat == 'Segera')
                                            <span class="badge font-12  badge-warning text-dark">Segera</span>
                                        @elseif($data->sifat == 'Amat Segera')
                                            <span class="badge font-12 badge-danger">Amat Segera</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Jenis Proposal
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->jenis }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Dibuat Oleh
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->nama_maker }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Tanggal Input
                                    </label>
                                    <div class="text-muted">
                                        {{ date('d M Y H:i', strtotime($data->created_date)) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="yayasan" role="tabpanel">
                            <div class="row p-4">
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Nama Lembaga/Yayasan
                                    </label>
                                    <div class="text-muted">{{ $data->nama_lembaga }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Penanggung Jawab
                                    </label>
                                    <div class="text-muted">{{ $data->nama_pic }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Bertindak Sebagai
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->jabatan }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        No Telepon/HP
                                    </label>
                                    <div class="text-muted">{{ $data->no_telp }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Alamat
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->alamat }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Email
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->email_pengaju }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Besar Permohonan
                                    </label>
                                    <div class="text-muted">
                                        {{ 'Rp. ' . number_format($data->nilai_pengajuan, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Kategori Bantuan
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->perihal }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Provinsi
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->provinsi }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Kabupaten/Kota
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->kabupaten }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Kecamatan
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->kecamatan }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Kelurahan
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->kelurahan }}
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="d-block font-bold p-0 text-dark">
                                        Deskripsi Bantuan
                                    </label>
                                    <div class="text-muted">
                                        {{ $data->deskripsi }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="messages2" role="tabpanel">
                            @if (!empty($data->nama_bank))
                                <div class="row p-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            Nama Bank
                                        </label>
                                        <div class="text-muted">{{ $data->nama_bank }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            Nomor Rekening
                                        </label>
                                        <div class="text-muted">{{ $data->no_rekening }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            Atas Nama
                                        </label>
                                        <div class="text-muted">
                                            {{ $data->atas_nama }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-4">
                                    <h6 class="text-muted">Informasi Bank penerima manfaat belum lengkap</h6>
                                    <a href="#" class="text-dark" data-target=".modal-updateBank"
                                        data-toggle="modal">
                                        <i class="far fa-edit text-info mr-2"></i>Update Informasi
                                        Bank</a>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="proker2" role="tabpanel">
                            @if (!empty($data->id_proker))
                                <div class="row p-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            Program Kerja
                                        </label>
                                        <div class="text-muted">{{ $data->proker }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            Pilar
                                        </label>
                                        <div class="text-muted">{{ $data->pilar }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            TPB
                                        </label>
                                        <div class="text-muted">
                                            {{ $data->kode_tpb . '. ' . $data->gols }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            Prioritas
                                        </label>
                                        <div class="text-muted">
                                            @if (!empty($data->prioritas))
                                                {{ $data->prioritas }}
                                            @else
                                                <span>Sosial/Ekonomi</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-4">
                                    <h6 class="text-muted">Program Kerja belum ditambahkan</h6>
                                    <a class="text-dark" href="javascript:void(0)" data-target=".modal-proker"
                                        data-toggle="modal">
                                        <i class="far fa-edit text-info mr-2"></i>Update Proker</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-b-0">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title font-weight-bold">
                                    Tindak Lanjut
                                </h5>
                                <h6 class="card-subtitle mb-3">
                                    Evaluasi, Survei, BAST dan Pembayaran
                                </h6>
                            </div>
                            <div class="ml-auto">
                                @if (empty($evaluasi))
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target=".modal-evaluasi"><i class="fa fa-plus-circle mr-2"></i>Buat
                                        Evaluasi</button>
                                @endif
                                @if (!empty($evaluasi) && empty($survei))
                                    {{-- @if (in_array($evaluasi->status, ['Survei']))
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target=".modal-survei">
                                            <i class="fa fa-plus-circle mr-2"></i>Buat Survei
                                        </button>
                                    @endif --}}
                                    @if ($data->nilai_bantuan <= 500000000)
                                        @if (in_array($evaluasi->status, ['Survei']))
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target=".modal-survei">
                                                <i class="fa fa-plus-circle mr-2"></i>Buat Survei
                                            </button>
                                        @endif
                                    @elseif($data->nilai_bantuan <= 2000000000)
                                        @if (in_array($evaluasi->status, ['Approved Sekper']))
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target=".modal-survei">
                                                <i class="fa fa-plus-circle mr-2"></i>Buat Survei
                                            </button>
                                        @endif
                                    @elseif($data->nilai_bantuan > 2000000000)
                                        @if (in_array($evaluasi->status, ['Approved Dirut']))
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target=".modal-survei">
                                                <i class="fa fa-plus-circle mr-2"></i>Buat Survei
                                            </button>
                                        @endif
                                    @endif
                                @endif
                                @if (!empty($evaluasi) && !empty($survei) && empty($bast))
                                    {{-- @if ($survei->status == 'Approved 3')
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target=".modal-bast">
                                            <i class="fa fa-plus-circle mr-2"></i>Buat Berita Acara
                                        </button>
                                    @endif --}}

                                    @if ($data->nilai_bantuan <= 500000000)
                                        @if (in_array($survei->status, ['Approved 3']))
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target=".modal-bast">
                                                <i class="fa fa-plus-circle mr-2"></i>Buat Berita Acara
                                            </button>
                                        @endif
                                    @elseif($data->nilai_bantuan <= 2000000000)
                                        @if (in_array($survei->status, ['Approved Sekper']))
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target=".modal-bast">
                                                <i class="fa fa-plus-circle mr-2"></i>Buat Berita Acara
                                            </button>
                                        @endif
                                    @elseif($data->nilai_bantuan > 2000000000)
                                        @if (in_array($survei->status, ['Approved Dirut']))
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target=".modal-bast">
                                                <i class="fa fa-plus-circle mr-2"></i>Buat Berita Acara
                                            </button>
                                        @endif
                                    @endif
                                @endif
                                @if (!empty($evaluasi) && !empty($survei))
                                    {{-- @if ($survei->status == 'Approved 3')
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target=".modal-pembayaran">
                                            <i class="fa fa-plus-circle mr-2"></i>Buat Pembayaran
                                        </button>
                                    @endif --}}

                                    @if ($data->nilai_bantuan <= 500000000)
                                        @if (in_array($survei->status, ['Approved 3']))
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target=".modal-pembayaran">
                                                <i class="fa fa-plus-circle mr-2"></i>Buat Pembayaran
                                            </button>
                                        @endif
                                    @elseif($data->nilai_bantuan <= 2000000000)
                                        @if (in_array($survei->status, ['Approved Sekper']))
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target=".modal-pembayaran">
                                                <i class="fa fa-plus-circle mr-2"></i>Buat Pembayaran
                                            </button>
                                        @endif
                                    @elseif($data->nilai_bantuan > 2000000000)
                                        @if (in_array($survei->status, ['Approved Dirut']))
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target=".modal-pembayaran">
                                                <i class="fa fa-plus-circle mr-2"></i>Buat Pembayaran
                                            </button>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#evaluasi" role="tab"><span
                                    class="hidden-sm-up"><i class="far fa-file-alt"></i></span>
                                <span class="hidden-xs-down">EVALUASI</span>
                            </a>
                        </li>
                        @if (!empty($evaluasi))
                            {{-- @if (in_array($evaluasi->status, ['Create Survei', 'Survei']))
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#survei"
                                        role="tab"><span class="hidden-sm-up"><i class="far fa-file-alt"></i></span>
                                        <span class="hidden-xs-down">SURVEI</span>
                                    </a>
                                </li>
                            @endif --}}
                            @if ($data->nilai_bantuan <= 500000000)
                                @if (in_array($evaluasi->status, ['Create Survei', 'Survei']))
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#survei"
                                            role="tab"><span class="hidden-sm-up"><i
                                                    class="far fa-file-alt"></i></span>
                                            <span class="hidden-xs-down">SURVEI</span>
                                        </a>
                                    </li>
                                @endif
                            @elseif($data->nilai_bantuan <= 2000000000)
                                @if (in_array($evaluasi->status, ['Approved Sekper']))
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#survei"
                                            role="tab"><span class="hidden-sm-up"><i
                                                    class="far fa-file-alt"></i></span>
                                            <span class="hidden-xs-down">SURVEI</span>
                                        </a>
                                    </li>
                                @endif
                            @elseif($data->nilai_bantuan > 2000000000)
                                @if (in_array($evaluasi->status, ['Approved Dirut']))
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#survei"
                                            role="tab"><span class="hidden-sm-up"><i
                                                    class="far fa-file-alt"></i></span>
                                            <span class="hidden-xs-down">SURVEI</span>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endif
                        @if (!empty($evaluasi) && !empty($survei))
                            @if ($survei->bantuan_berupa == 'Dana')
                                @if ($data->nilai_bantuan <= 500000000)
                                    @if (in_array($survei->status, ['Approved 3']))
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#bast"
                                                role="tab"><span class="hidden-sm-up"><i
                                                        class="far fa-money-bill-alt"></i></span>
                                                <span class="hidden-xs-down">BAST</span>
                                            </a>
                                        </li>
                                    @endif
                                @elseif($data->nilai_bantuan <= 2000000000)
                                    @if (in_array($survei->status, ['Approved Sekper']))
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#bast"
                                                role="tab"><span class="hidden-sm-up"><i
                                                        class="far fa-money-bill-alt"></i></span>
                                                <span class="hidden-xs-down">BAST</span>
                                            </a>
                                        </li>
                                    @endif
                                @elseif($data->nilai_bantuan > 2000000000)
                                    @if (in_array($survei->status, ['Approved Dirut']))
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#bast"
                                                role="tab"><span class="hidden-sm-up"><i
                                                        class="far fa-money-bill-alt"></i></span>
                                                <span class="hidden-xs-down">BAST</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif

                                {{-- @if ($survei->status == 'Approved 3')
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#bast"
                                            role="tab"><span class="hidden-sm-up"><i
                                                    class="far fa-money-bill-alt"></i></span>
                                            <span class="hidden-xs-down">BAST</span>
                                        </a>
                                    </li>
                                @endif --}}
                            @endif
                        @endif
                        @if (!empty($survei))
                            {{-- @if ($survei->status == 'Approved 3')
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pembayaran"
                                        role="tab"><span class="hidden-sm-up"><i
                                                class="far fa-money-bill-alt"></i></span>
                                        <span class="hidden-xs-down">PEMBAYARAN</span>
                                    </a>
                                </li>
                            @endif --}}

                            @if ($data->nilai_bantuan <= 500000000)
                                @if (in_array($survei->status, ['Approved 3']))
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pembayaran"
                                            role="tab"><span class="hidden-sm-up"><i
                                                    class="far fa-money-bill-alt"></i></span>
                                            <span class="hidden-xs-down">PEMBAYARAN</span>
                                        </a>
                                    </li>
                                @endif
                            @elseif($data->nilai_bantuan <= 2000000000)
                                @if (in_array($survei->status, ['Approved Sekper']))
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pembayaran"
                                            role="tab"><span class="hidden-sm-up"><i
                                                    class="far fa-money-bill-alt"></i></span>
                                            <span class="hidden-xs-down">PEMBAYARAN</span>
                                        </a>
                                    </li>
                                @endif
                            @elseif($data->nilai_bantuan > 2000000000)
                                @if (in_array($survei->status, ['Approved Dirut']))
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pembayaran"
                                            role="tab"><span class="hidden-sm-up"><i
                                                    class="far fa-money-bill-alt"></i></span>
                                            <span class="hidden-xs-down">PEMBAYARAN</span>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="evaluasi" role="tabpanel">
                            @if (!empty($evaluasi))
                                <div class="row p-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            Rencana Anggaran
                                        </label>
                                        <div class="text-muted">{{ $evaluasi->rencana_anggaran }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            Dokumentasi
                                        </label>
                                        <div class="text-muted">{{ $evaluasi->dokumen }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            Denah Lokasi
                                        </label>
                                        <div class="text-muted">{{ $evaluasi->denah }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            Perkiraan Bantuan
                                        </label>
                                        <div class="text-muted">
                                            {{ 'Rp. ' . number_format($data->nilai_bantuan, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    @if ($dataKepentingan->count() > 0)
                                        <div class="col-md-6 mb-3">
                                            <label class="d-block font-bold p-0 text-dark">
                                                Kepentingan Perusahaan
                                            </label>
                                            <div class="text-muted">
                                                <ol style="margin-left: -10px">
                                                    @foreach ($dataKepentingan as $kepentingan)
                                                        <li>{{ $kepentingan->kriteria }}</li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">
                                            Memenuhi Syarat2
                                        </label>
                                        <div class="text-muted">
                                            @if ($evaluasi->syarat == 'Survei')
                                                {{-- <i class="fas fa-check-circle text-success mr-1"></i> --}}
                                                ✅ Survei/Konfirmasi
                                            @else
                                                {{-- <i class="fas fa-times-circle text-danger mr-1"></i> --}}
                                                🚫 Tidak Memenuhi Syarat
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <div>
                                        <a target="_blank" href="{{ route('form-evaluasi', $data->id_kelayakan) }}"
                                            type="button" class="btn btn-light">
                                            <i class="fas fa-download text-info mr-2"></i>Form Evaluasi
                                        </a>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary mr-2" data-toggle="modal"
                                            data-target=".modal-logEvaluasi">
                                            <i class="fas fa-history mr-2"></i>Log Approval
                                        </button>
                                        <button type="button" class="btn btn-light" data-toggle="modal"
                                            data-target=".modal-evaluasiEdit">
                                            <i class="far fa-edit text-info mr-2"></i>Edit
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="p-3">
                                    <div class="alert alert-warning d-flex align-items-center shadow-sm mb-0"
                                        role="alert">
                                        <i class="bi bi-exclamation-triangle mr-3" style="font-size: 1.8rem;"></i>
                                        <div>
                                            <h6 class="font-weight-bold mb-1">Perhatian</h6>
                                            <p class="mb-0 text-muted">
                                                Anda belum membuat evaluasi kelayakan proposal
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="survei" role="tabpanel">
                            @if (!empty($survei))
                                <div class="row p-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">Usulan</label>
                                        <div class="text-muted">{{ $survei->usulan }}</div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">Dibantu Berupa</label>
                                        <div class="text-muted">{{ $survei->bantuan_berupa }}</div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">Nilai Bantuan</label>
                                        <div class="text-muted">
                                            {{ 'Rp. ' . number_format($survei->nilai_bantuan, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">Termin Pembayaran</label>
                                        <div class="text-muted">{{ $survei->termin }} Termin</div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <div>
                                        <a target="_blank" href="{{ route('form-survei', $data->id_kelayakan) }}"
                                            type="button" class="btn btn-light">
                                            <i class="fas fa-download text-info mr-2"></i>Form Survei
                                        </a>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary mr-2" data-toggle="modal"
                                            data-target=".modal-logSurvei">
                                            <i class="fas fa-history mr-2"></i>Log Approval
                                        </button>
                                        <button type="button" class="btn btn-light" data-toggle="modal"
                                            data-target=".modal-surveiEdit">
                                            <i class="far fa-edit text-info mr-2"></i>Edit
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="p-3">
                                    <div class="alert alert-warning d-flex align-items-center shadow-sm mb-0"
                                        role="alert">
                                        <i class="bi bi-exclamation-triangle mr-3" style="font-size: 1.8rem;"></i>
                                        <div>
                                            <h6 class="font-weight-bold mb-1">Perhatian</h6>
                                            <p class="mb-0 text-muted">
                                                Anda belum membuat survei kelayakan proposal
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="bast" role="tabpanel">
                            @if (!empty($bast))
                                <div class="row p-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">Nomor</label>
                                        <div class="text-muted">{{ $bast->no_bast_dana ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">Tanggal</label>
                                        <div class="text-muted">
                                            @if (!empty($bast->tgl_bast))
                                                {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($bast->tgl_bast))) }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">Nomor Pihak Kedua</label>
                                        <div class="text-muted">{{ $bast->no_bast_pihak_kedua ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">Disetujui Oleh</label>
                                        <div class="text-muted">
                                            {{ $bast->approver->nama ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="d-block font-bold p-0 text-dark">Jabatan</label>
                                        <div class="text-muted">
                                            {{ $bast->jabatan_pejabat }}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-download text-info mr-2"></i>Form BAST
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" target="_blank"
                                                    href="{{ route('formBASTDana', encrypt($bast->id_kelayakan)) }}">Copy
                                                    1</a>
                                                <a class="dropdown-item" target="_blank"
                                                    href="{{ route('formBASTDana2', encrypt($bast->id_kelayakan)) }}">Copy
                                                    2</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-light" data-toggle="modal"
                                            data-target=".modal-bastEdit">
                                            <i class="far fa-edit text-info mr-2"></i>Edit
                                        </button>
                                        <button type="button" class="btn btn-light deleteBAST"
                                            data-id={{ Crypt::encrypt($bast->id_bast_dana) }}>
                                            <i class="far fa-trash-alt text-danger mr-2"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="p-3">
                                    <div class="alert alert-warning d-flex align-items-center shadow-sm mb-0"
                                        role="alert">
                                        <i class="bi bi-exclamation-triangle mr-3" style="font-size: 1.8rem;"></i>
                                        <div>
                                            <h6 class="font-weight-bold mb-1">Perhatian</h6>
                                            <p class="mb-0 text-muted">
                                                Anda belum membuat dokumen Berita Acara Serah Terima
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="pembayaran" role="tabpanel">
                            @if (!empty($survei))
                                @if ($pembayaran->count() > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach ($pembayaran as $pem)
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-start border-bottom px-4 py-4">
                                                <!-- Kiri -->
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 font-weight-bold text-dark">
                                                        {{ $pem->deskripsi }}
                                                    </h6>
                                                    <h4 class="mb-2 font-weight-bold" style="color: red">
                                                        {{ 'Rp. ' . number_format($pem->subtotal, 0, ',', '.') }}
                                                    </h4>
                                                    @if ($pem->metode == 'YKPP')
                                                        <small>
                                                            <i class="fas fa-star text-warning mr-1"></i>YKPP
                                                        </small>
                                                    @endif

                                                    <div class="mt-2">
                                                        @if ($pem->status == 'Exported')
                                                            Popay ID: {{ $pem->pr_id }}
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Kanan -->
                                                <div class="text-right" style="min-width: 120px;">
                                                    @php
                                                        $statusClasses = [
                                                            'Open' => 'badge-dark',
                                                            'Exported' => 'badge-success',
                                                        ];
                                                    @endphp
                                                    <span
                                                        class="badge font-bold badgeLog {{ $statusClasses[$pem->status] ?? 'badge-secondary' }}">
                                                        {{ $pem->status }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between align-items-center">
                                                <div>
                                                    <a target="_blank"
                                                        href="{{ route('kwitansi', $pem->id_pembayaran) }}"
                                                        type="button" class="btn btn-light">
                                                        <i class="fas fa-download text-info mr-2"></i>Kuitansi
                                                    </a>
                                                </div>
                                                <div>
                                                    @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                        @if ($pem->metode == 'Popay')
                                                            <a href="#" class="btn btn-light exportPopay"
                                                                data-id="{{ Crypt::encrypt($pem->id_pembayaran) }}"
                                                                data-toggle="modal" data-target=".modal-exportPopay">
                                                                <i class="fas fa-paper-plane text-success mr-2"></i>Export
                                                                Popay</a>
                                                        @endif
                                                        @if ($pem->metode == 'YKPP')
                                                            @if ($pem->status_ykpp == 'Open')
                                                                <button type="button" class="btn btn-light approveYKPP"
                                                                    data-id="{{ encrypt($pem->id_pembayaran) }}">
                                                                    <i
                                                                        class="fas fa-check-circle text-success mr-2"></i>Persetujuan
                                                                    YKPP
                                                                </button>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    <a href="#" class="btn btn-light editPembayaran"
                                                        data-id="{{ Crypt::encrypt($pem->id_pembayaran) }}"
                                                        data-deskripsi="{{ $pem->deskripsi }}"
                                                        data-termin="{{ $pem->termin }}"
                                                        data-metode="{{ $pem->metode }}"
                                                        data-jumlah_rupiah="{{ 'Rp. ' . number_format($pem->jumlah_pembayaran, 0, ',', '.') }}"
                                                        data-jumlah="{{ $pem->jumlah_pembayaran }}"
                                                        data-fee="{{ $pem->fee_persen }}" data-toggle="modal"
                                                        data-target=".modal-pembayaranEdit">
                                                        <i class="far fa-edit text-info mr-2"></i>Edit</a>
                                                    <a href="#" class="btn btn-light deletePembayaran"
                                                        data-id={{ Crypt::encrypt($pem->id_pembayaran) }}>
                                                        <i class="far fa-trash-alt text-danger mr-2"></i>Hapus</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-3">
                                        <div class="alert alert-warning d-flex align-items-center shadow-sm mb-0"
                                            role="alert">
                                            <i class="bi bi-exclamation-triangle mr-3" style="font-size: 1.8rem;"></i>
                                            <div>
                                                <h6 class="font-weight-bold mb-1">Perhatian</h6>
                                                <p class="mb-0 text-muted">
                                                    Belum ada daftar pembayaran untuk proposal ini, Silakan klik tombol
                                                    "Buat
                                                    Pembayaran" untuk mulai menambahkan.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-b-0">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title font-weight-bold">Galeri</h5>
                                <h6 class="card-subtitle mb-3">Dokumentasi Foto Kegiatan</h6>
                            </div>
                            <div class="ml-auto">
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target=".modal-dokumentasi">
                                    <i class="fa fa-plus-circle mr-2"></i>Tambah Dokumentasi
                                </button>
                            </div>
                        </div>

                        @if ($dataDokumentasi->count() > 0)
                            <div class="row mt-3" id="gallery">
                                @foreach ($dataDokumentasi as $dokumentasi)
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">
                                        <div class="thumbnail border rounded shadow-sm p-1 h-100 position-relative">

                                            <!-- Icon Hapus -->
                                            <button type="button"
                                                class="btn btn-xs btn-danger position-absolute deleteDokumentasi"
                                                data-id="{{ Crypt::encrypt($dokumentasi->id_lampiran) }}"
                                                style="top: 5px; right: 5px; z-index: 10;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                            <!-- Gambar -->
                                            <img src="{{ asset('storage/' . $dokumentasi->lampiran) }}" alt="Dokumentasi"
                                                class="img-fluid rounded preview-image" data-index="0"
                                                data-src="{{ asset('storage/' . $dokumentasi->lampiran) }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning d-flex align-items-center shadow-sm" role="alert">
                                <i class="bi bi-exclamation-triangle mr-3" style="font-size: 1.8rem;"></i>
                                <div>
                                    <h6 class="font-weight-bold mb-1">Perhatian</h6>
                                    <p class="mb-0 text-muted">
                                        Dokumentasi atau Foto Kegiatan belum ditambahkan.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Modal Preview -->
                <div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog"
                    aria-labelledby="previewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-body text-center position-relative p-0">
                                <button type="button" class="close text-white position-absolute"
                                    style="right: 10px; top: 10px;" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                                <!-- Gambar utama -->
                                <img id="modalImage" src="" alt="Preview" class="img-fluid rounded transition"
                                    style="max-height: 80vh; cursor: zoom-in;" />

                                <!-- Navigasi -->
                                <a id="prevBtn" href="#" class="position-absolute"
                                    style="left: 10px; top: 50%; transform: translateY(-50%); font-size: 2rem; color: white; text-decoration: none;">&#10094;</a>
                                <a id="nextBtn" href="#" class="position-absolute"
                                    style="right: 10px; top: 50%; transform: translateY(-50%); font-size: 2rem; color: white; text-decoration: none;">&#10095;</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                @if (in_array($data->status, ['Evaluasi', 'Survei']))
                    @if (!empty($nextApprover))
                        @if ($nextApprover->id_user == session('user')->id_user)
                            <form method="post" action="{{ route('submitKelayakan') }}" autocomplete="off">
                                @csrf
                                <div class="card d-block d-sm-none">
                                    <div class="card-header bg-info">
                                        <h4 class="m-b-0 text-white">
                                            @if ($nextApprover->level == 1)
                                                Submit {{ $data->status }}
                                            @else
                                                Persetujuan {{ $data->status }}
                                            @endif
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="hirarkiID"
                                            value="{{ Crypt::encrypt($nextApprover->id) }}">
                                        <input type="hidden" class="form-control" name="kelayakanID"
                                            value="{{ encrypt($data->id_kelayakan) }}">
                                        <div class="form-group mb-0">
                                            <label>Catatan <span class="text-danger">*</span></label>
                                            <textarea rows="3" class="form-control" placeholder="Berikan catatan minimal 10 karakter" name="catatan"
                                                autofocus>{{ $catatan }}</textarea>
                                            @error('catatan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-success" name="action" value="Approve">
                                            @if ($nextApprover->level == 1)
                                                <i class="fas fa-forward mr-2"></i>Submit
                                            @else
                                                <i class="fas fa-check-circle mr-2"></i>Approve
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    @endif
                @endif

                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="m-b-0 text-white">Log Activity</h4>
                    </div>
                    <div class="card-body">
                        @if (!empty($nextApprover))
                            @php
                                $approveBy = App\Models\User::where('id_user');
                            @endphp
                            <div class="alert alert-info d-flex align-items-center shadow-sm" role="alert">
                                <i class="bi bi-info-circle mr-3" style="font-size: 1.8rem;"></i>
                                <div>
                                    <h6 class="font-weight-bold mb-1">Informasi</h6>
                                    <p class="mb-0 text-muted">
                                        Kelayakan proposal menunggu persetujuan {{ $nextApprover->phase }} dari
                                        <span class="font-bold">{{ $nextApprover->user->nama }}</span>
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div style="max-height: 300px; overflow-y: auto;">
                            @forelse($groupedLogs as $groupName => $logs)
                                <div class="px-3 pt-2 small text-muted font-weight-bold">{{ $groupName }}</div>
                                @foreach ($logs as $item)
                                    <div class="card mb-2 mx-2 border-0 shadow-sm">
                                        <div class="card-body py-2 px-3">
                                            <div class="d-flex align-items-center">
                                                {{-- Foto User --}}
                                                <div class="mr-3">
                                                    <img class="rounded-circle"
                                                        src="{{ $item->user->foto_profile ? asset('storage/' . $item->user->foto_profile) : asset('template/assets/images/user.png') }}"
                                                        width="45" height="45" alt="User Photo">
                                                </div>

                                                {{-- Informasi Utama --}}
                                                <div class="w-100">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <h6 class="font-bold mb-0 text-dark">
                                                            {{ $item->user->nama ?? 'User #' . $item->created_by }}</h6>
                                                        <small
                                                            class="text-muted">{{ $item->created_date->diffForHumans() }}</small>
                                                    </div>
                                                    <div class="text-muted">
                                                        {{ $item->keterangan }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @empty
                                <h6 class="mb-0">Belum ada log aktivitas</h6>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if (!empty($survei))
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex mb-4">
                                <h5 class="card-title font-weight-bold mb-0">Nilai Bantuan</h5>
                                <div class="ml-auto">
                                    <a href="#" class="text-dark editTermin" data-persen1="{{ $survei->persen1 }}"
                                        data-persen2="{{ $survei->persen2 }}" data-persen3="{{ $survei->persen3 }}"
                                        data-persen4="{{ $survei->persen4 }}" data-toggle="modal"
                                        data-target=".modal-termin">
                                        <i class="far fa-edit text-info mr-2"></i>Edit Termin
                                    </a>
                                </div>
                            </div>

                            <div class="text-center mb-4">
                                <h2 class="font-weight-bold mb-0" style="color: red">
                                    {{ 'Rp. ' . number_format($survei->nilai_bantuan, 0, ',', '.') }}
                                </h2>
                            </div>
                            <ul class="list-group">
                                @for ($i = 1; $i <= 4; $i++)
                                    @php
                                        $persen = $survei->{'persen' . $i} ?? 0;
                                        $rupiah = $survei->{'rupiah' . $i} ?? 0;
                                    @endphp
                                    @if ($i <= $survei->termin)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="font-weight-medium">Termin {{ $i }}</span>
                                            <span class="text-muted">{{ $persen }}% &mdash;
                                                {{ 'Rp. ' . number_format($rupiah, 0, ',', '.') }}</span>
                                        </li>
                                    @endif
                                @endfor
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <h5 class="card-title font-weight-bold mb-0">Dokumen Pendukung</h5>
                            <div class="ml-auto">
                                <a href="#" class="text-dark" data-toggle="modal" data-target=".modal-lampiran">
                                    <i class="fa fa-plus-circle text-info mr-2"></i>Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($dataLampiran->count() > 0)
                        <div style="max-height: 550px; overflow-y: auto;">
                            <div class="list-group list-group-flush">
                                @foreach ($dataLampiran as $dl)
                                    <div
                                        class="list-group-item d-flex justify-content-between align-items-start flex-wrap px-3 py-3 border-bottom">
                                        <div class="d-flex align-items-start">
                                            <a href="#" data-toggle="tooltip" title="Preview PDF"
                                                data-src="/attachment/{{ $dl->lampiran }}" class="previewPdf mr-3">
                                                <img src="{{ asset('template/assets/images/icon/pdf.png') }}"
                                                    width="40" alt="PDF">
                                            </a>
                                            <div>
                                                <div class="font-weight-bold text-dark mb-1">{{ $dl->nama }}</div>
                                                <div class="text-muted small">
                                                    Diunggah oleh: {{ $dl->user->nama ?? 'Unknown' }}<br>
                                                    {{ date('d M Y H:i', strtotime($dl->upload_date)) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mt-2 mt-md-0">
                                            <a href="javascript:void(0)"
                                                class="text-info mr-3 editLampiran tooltip-trigger" title="Edit"
                                                data-id="{{ encrypt($dl->id_lampiran) }}"
                                                data-nama="{{ $dl->nama }}" data-target=".modal-lampiranEdit"
                                                data-toggle="modal">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="text-danger mr-3 deleteLampiran"
                                                data-toggle="tooltip" title="Hapus"
                                                data-id="{{ encrypt($dl->id_lampiran) }}"
                                                data-nama="{{ $dl->nama }}">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="p-3">
                            <div class="alert alert-warning d-flex align-items-center shadow-sm mb-0" role="alert">
                                <i class="bi bi-exclamation-triangle mr-3" style="font-size: 1.8rem;"></i>
                                <div>
                                    <h6 class="font-weight-bold mb-1">Perhatian</h6>
                                    <p class="mb-0 text-muted">
                                        Belum ada dokumen pendukung yang ditambahkan
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview PDF -->
    <div class="modal fade" id="previewPdfModal" tabindex="-1" role="dialog" aria-labelledby="previewPdfModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-bold">Preview Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0" style="height: 80vh;">
                    <iframe id="pdfPreviewFrame" src="" width="100%" height="100%" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-log" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">Log
                        Activity</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div style="max-height: 300px; overflow-y: auto;">
                        @forelse($groupedLogs as $groupName => $logs)
                            <div class="px-3 pt-2 small text-muted font-weight-bold">{{ $groupName }}</div>
                            @foreach ($logs as $item)
                                <div class="card mb-2 mx-2 border-0 shadow-sm">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-center">
                                            {{-- Foto User --}}
                                            <div class="mr-3">
                                                <img class="rounded-circle"
                                                    src="{{ $item->user->foto_profile ? asset('storage/' . $item->user->foto_profile) : asset('template/assets/images/user.png') }}"
                                                    width="45" height="45" alt="User Photo">
                                            </div>

                                            {{-- Informasi Utama --}}
                                            <div class="w-100">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="font-bold mb-0 text-dark">
                                                        {{ $item->user->nama ?? 'User #' . $item->created_by }}</h6>
                                                    <small
                                                        class="text-muted">{{ $item->created_date->diffForHumans() }}</small>
                                                </div>
                                                <div class="text-muted">
                                                    {{ $item->keterangan }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @empty
                            <div class="text-center py-4 text-muted">Belum ada log activity.</div>
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-logEvaluasi" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">Log Approval</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse ($dataApproverEvaluasi as $app)
                        <div class="d-flex justify-content-between align-items-start border-bottom py-3">
                            <!-- Kiri -->
                            <div class="flex-grow-1">
                                <h6 class="mb-1 font-weight-bold text-dark">
                                    {{ $app->hirarki->nama_level }}
                                </h6>
                                <p class="mb-1 text-muted">{{ $app->user->nama }}</p>

                                @if (!empty($app->catatan))
                                    <small class="d-block text-danger">
                                        {{ $app->catatan }}
                                    </small>
                                @endif

                                <div class="mt-2">
                                    <small class="d-block text-muted">
                                        📌 <strong>Task:</strong>
                                        {{ date('d M Y H:i', strtotime($app->task_date)) }}
                                    </small>
                                    @if (in_array($app->status, ['Submitted', 'Approved', 'Rejected']))
                                        <small class="d-block text-muted">
                                            🕒 <strong>Action:</strong>
                                            {{ date('d M Y H:i', strtotime($app->action_date)) }}
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <!-- Kanan -->
                            <div class="text-right" style="min-width: 120px;">
                                @php
                                    $statusClasses = [
                                        'Submitted' => 'badge-success',
                                        'In Progress' => 'badge-warning text-dark',
                                        'Approved' => 'badge-primary text-white',
                                        'Rejected' => 'badge-danger',
                                    ];
                                @endphp
                                <span
                                    class="badge font-bold badgeLog {{ $statusClasses[$app->status] ?? 'badge-secondary' }}">
                                    {{ $app->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <h6 class="mb-0">Belum ada aktivitas persetujuan</h6>
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-logSurvei" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">Log Approval</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse ($dataApproverSurvei as $app)
                        <div class="d-flex justify-content-between align-items-start border-bottom py-3">
                            <!-- Kiri -->
                            <div class="flex-grow-1">
                                <h6 class="mb-1 font-weight-bold text-dark">
                                    {{ $app->hirarki->nama_level }}
                                </h6>
                                <p class="mb-1 text-muted">{{ $app->user->nama }}</p>

                                @if (!empty($app->catatan))
                                    <small class="d-block text-danger">
                                        {{ $app->catatan }}
                                    </small>
                                @endif

                                <div class="mt-2">
                                    <small class="d-block text-muted">
                                        📌 <strong>Task:</strong>
                                        {{ date('d M Y H:i', strtotime($app->task_date)) }}
                                    </small>
                                    @if (in_array($app->status, ['Submitted', 'Approved', 'Rejected']))
                                        <small class="d-block text-muted">
                                            🕒 <strong>Action:</strong>
                                            {{ date('d M Y H:i', strtotime($app->action_date)) }}
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <!-- Kanan -->
                            <div class="text-right" style="min-width: 120px;">
                                @php
                                    $statusClasses = [
                                        'Submitted' => 'badge-success',
                                        'In Progress' => 'badge-warning text-dark',
                                        'Approved' => 'badge-primary text-white',
                                        'Rejected' => 'badge-danger',
                                    ];
                                @endphp
                                <span
                                    class="badge font-bold badgeLog {{ $statusClasses[$app->status] ?? 'badge-secondary' }}">
                                    {{ $app->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <h6 class="mb-0">Belum ada aktivitas persetujuan</h6>
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if (!empty($nextApprover))
        <form method="post" action="{{ route('submitKelayakan') }}" autocomplete="off">
            @csrf
            <div class="modal fade modal-submit" tabindex="-1" role="dialog" aria-hidden="true"
                style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">
                                @if ($nextApprover->level == 1)
                                    Submit {{ $data->status }}
                                @else
                                    Persetujuan {{ $data->status }}
                                @endif
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="hirarkiID" value="{{ Crypt::encrypt($nextApprover->id) }}">
                            <input type="hidden" class="form-control" name="kelayakanID"
                                value="{{ encrypt($data->id_kelayakan) }}">
                            <div class="form-group mb-0">
                                <label>Catatan <span class="text-danger">*</span></label>
                                <textarea rows="3" class="form-control" placeholder="Berikan catatan minimal 10 karakter" name="catatan">{{ $catatan }}</textarea>
                                @error('catatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success shadow-1" name="action" value="Approve">
                                @if ($nextApprover->level == 1)
                                    <i class="fas fa-forward mr-2"></i>Submit
                                @else
                                    <i class="fas fa-check-circle mr-2"></i>Approve
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

    <form method="post" action="{{ route('storeDokumen') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-lampiran" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Tambah Dokumen</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="kelayakanID"
                            value="{{ encrypt($data->id_kelayakan) }}">
                        <div class="form-group">
                            <label>Jenis Dokumen <span class="text-danger">*</span></label>
                            <select class="form-control pilihDokumen" name="nama" required>
                                <option value="" disabled {{ old('nama') ? '' : 'selected' }}>-- Pilih Dokumen --
                                </option>
                                @foreach ($dataDokumen as $dok)
                                    <option value="{{ $dok->nama_dokumen }}"
                                        {{ old('nama') == $dok->nama_dokumen ? 'selected' : '' }}>
                                        {{ $dok->nama_dokumen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Lampiran <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="lampiran" accept="application/pdf"
                                required>
                            <small class="text-muted">Format yang didukung: PDF</small>
                            @error('pampiran')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ route('updateDokumen') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-lampiranEdit" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Edit Dokumen</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="lampiranID" id="lampiranID">
                        <div class="form-group">
                            <label>Jenis Dokumen <span class="text-danger">*</span></label>
                            <select class="form-control pilihDokumen" name="nama" id="nama_dokumen_edit" required>
                                <option value="" disabled {{ old('nama') ? '' : 'selected' }}>-- Pilih Dokumen --
                                </option>
                                @foreach ($dataDokumen as $dok)
                                    <option value="{{ $dok->nama_dokumen }}"
                                        {{ old('nama') == $dok->nama_dokumen ? 'selected' : '' }}>
                                        {{ $dok->nama_dokumen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Lampiran</label>
                            <input type="file" class="form-control" name="lampiran" accept="application/pdf">
                            <small class="text-muted">Format yang didukung: PDF</small>
                            @error('pampiran')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ route('updateBank') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-updateBank" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Informasi Bank</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="kelayakanID"
                            value="{{ Crypt::encrypt($data->id_kelayakan) }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama Bank <span class="text-danger">*</span></label>
                                <select name="namaBank" class="form-control pilihBank" required>
                                    <option value="" disabled {{ !$data->nama_bank ? 'selected' : '' }}>--
                                        Pilih Bank --</option>
                                    @foreach ($dataBank as $bank)
                                        <option value="{{ $bank->nama_bank }}"
                                            {{ $data->nama_bank == $bank->nama_bank ? 'selected' : '' }}>
                                            {{ $bank->nama_bank }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('namaBank')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>No Rekening</label>
                                <input type="text" name="noRekening" id="noRekening"
                                    onkeypress="return hanyaAngka(event)" class="form-control"
                                    value="{{ $data->no_rekening }}">
                                @error('noRekening')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Atas Nama</label>
                            <input type="text" name="atasNama" id="atasNama" class="form-control"
                                value="{{ $data->atas_nama }}">
                            @error('atasNama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ route('updateProposal') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-updateProposal" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Surat/Proposal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="kelayakanID"
                            value="{{ Crypt::encrypt($data->id_kelayakan) }}">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>No Agenda <span class="text-danger">*</span></label>
                                <input type="text" name="noAgenda" class="form-control text-uppercase"
                                    value="{{ $data->no_agenda }}" required>
                                @error('noAgenda')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tanggal Penerimaan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="tglPenerimaan" class="form-control tgl-terima"
                                        value="{{ date('d-M-Y', strtotime($data->tgl_terima)) }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar text-info"></i></span>
                                    </div>
                                </div>
                                @error('tglPenerimaan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Pengirim <span class="text-danger">*</span></label>
                                <select name="pengirim" class="form-control pilihPIC" required>
                                    <option disabled selected>-- Pilih Pengirim --</option>
                                    @foreach ($dataPengirim as $pengirim)
                                        <option value="{{ $pengirim->id_pengirim }}"
                                            {{ old('pengirim', $data->id_pengirim) == $pengirim->id_pengirim ? 'selected' : '' }}>
                                            {{ $pengirim->pengirim }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pengirim')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Nomor Surat <span class="text-danger">*</span></label>
                                <input type="text" name="noSurat" class="form-control text-uppercase"
                                    value="{{ $data->no_surat }}" required>
                                @error('noSurat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tanggal Surat <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="tglSurat" class="form-control tgl-surat"
                                        value="{{ date('d-M-Y', strtotime($data->tgl_surat)) }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar text-info"></i></span>
                                    </div>
                                </div>
                                @error('tglSurat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Sifat <span class="text-danger">*</span></label>
                                @php
                                    $selectedSifat = old('sifat', $data->sifat ?? '');
                                @endphp
                                <select name="sifat" class="form-control" required>
                                    <option disabled {{ $selectedSifat ? '' : 'selected' }}>-- Sifat Surat --</option>
                                    @foreach (['Biasa', 'Segera', 'Amat Segera'] as $sifat)
                                        <option value="{{ $sifat }}"
                                            {{ $selectedSifat == $sifat ? 'selected' : '' }}>
                                            {{ $sifat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sifat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Jenis Proposal <span class="text-danger">*</span></label>
                                @php
                                    $selectedJenis = old('jenis', $data->jenis ?? '');
                                @endphp
                                <select name="jenis" class="form-control" required>
                                    <option value="" disabled {{ $selectedJenis ? '' : 'selected' }}>-- Pilih
                                        Jenis
                                        --
                                    </option>
                                    @foreach (['Bulanan', 'Santunan', 'Idul Adha', 'Natal', 'Aspirasi'] as $jenis)
                                        <option value="{{ $jenis }}"
                                            {{ $selectedJenis == $jenis ? 'selected' : '' }}>
                                            {{ $jenis }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label>Perihal <span class="text-danger">*</span></label>
                                <input type="text" name="digunakanUntuk" class="form-control" maxlength="200"
                                    value="{{ $data->bantuan_untuk }}" required>
                                @error('digunakanUntuk')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ route('updatePenerima') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-updatePenerima" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Penerima Manfaat</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="kelayakanID"
                            value="{{ Crypt::encrypt($data->id_kelayakan) }}">
                        <div class="form-group">
                            <label>Yayasan/Lembaga <span class="text-danger">*</span></label>
                            <select class="form-control pilihLembaga" name="dari" id="dari" required>
                                <option value="" disabled
                                    {{ old('dari', $data->id_lembaga ?? '') == '' ? 'selected' : '' }}>
                                    -- Pilih Lembaga --
                                </option>
                                @foreach ($dataLembaga as $lembaga)
                                    <option value="{{ $lembaga->id_lembaga }}" alamat="{{ $lembaga->alamat }}"
                                        {{ old('dari', $data->id_lembaga ?? '') == $lembaga->id_lembaga ? 'selected' : '' }}>
                                        {{ strtoupper($lembaga->nama_lembaga) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dari')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control bg-white" rows="3" readonly required>{{ old('alamat', $data->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Besar Permohonan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" name="besarPermohonan"
                                    id="besarPermohonan" placeholder="Contoh: Rp. 1.000.000"
                                    value="{{ old('besarPermohonan', 'Rp. ' . number_format($data->nilai_pengajuan ?? '', 0, ',', '.')) }}"
                                    required>
                                <input type="hidden" name="besarPermohonanAsli" id="besarPermohonanAsli"
                                    value="{{ old('besarPermohonanAsli', $data->nilai_pengajuan ?? '') }}">
                                @error('besarPermohonan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" name="perihal" required>
                                    <option value="" disabled
                                        {{ old('perihal', $data->perihal ?? '') == '' ? 'selected' : '' }}>
                                        -- Pilih Kategori --
                                    </option>
                                    @foreach (['Permohonan Bantuan Dana', 'Permohonan Bantuan Barang'] as $kategori)
                                        <option value="{{ $kategori }}"
                                            {{ old('perihal', $data->perihal ?? '') == $kategori ? 'selected' : '' }}>
                                            {{ $kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('perihal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Provinsi <small class="text-muted">(Lokasi Program Bantuan)</small> <span
                                        class="text-danger">*</span></label>
                                <select class="form-control pilihProvinsi" name="provinsi" id="provinsi" required>
                                    <option value="" disabled
                                        {{ old('provinsi', $data->provinsi ?? '') == '' ? 'selected' : '' }}>
                                        -- Pilih Provinsi --
                                    </option>
                                    @foreach ($dataProvinsi as $prov)
                                        <option value="{{ ucwords($prov->provinsi) }}"
                                            {{ old('provinsi', $data->provinsi ?? '') == ucwords($prov->provinsi) ? 'selected' : '' }}>
                                            {{ ucwords($prov->provinsi) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('provinsi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Kabupaten/Kota <span class="text-danger">*</span></label>
                                <select class="form-control pilihKabupaten bg-white" name="kabupaten" id="kabupaten"
                                    required>
                                    @if (old('kabupaten', $data->kabupaten ?? false))
                                        <option value="{{ old('kabupaten', $data->kabupaten) }}" selected>
                                            {{ old('kabupaten', $data->kabupaten) }}
                                        </option>
                                    @else
                                        <option value="" disabled selected>-- Pilih Kabupaten/Kota --</option>
                                    @endif
                                </select>
                                @error('kabupaten')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Kecamatan <span class="text-danger">*</span></label>
                                <select id="kecamatan" name="kecamatan" class="form-control pilihKecamatan" required>
                                    <option disabled selected>-- Pilih Kecamatan --</option>
                                    @if (old('kecamatan', $data->kecamatan ?? false))
                                        <option value="{{ old('kecamatan', $data->kecamatan) }}" selected>
                                            {{ old('kecamatan', $data->kecamatan) }}</option>
                                    @endif
                                </select>
                                @error('kecamatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Kelurahan/Desa <span class="text-danger">*</span></label>
                                <select id="kelurahan" name="kelurahan" class="form-control pilihKelurahan" required>
                                    <option disabled selected>-- Pilih Kelurahan --</option>
                                    @if (old('kelurahan', $data->kelurahan ?? false))
                                        <option value="{{ old('kelurahan', $data->kelurahan) }}" selected>
                                            {{ old('kelurahan', $data->kelurahan) }}</option>
                                    @endif
                                </select>
                                @error('kelurahan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Bantuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="deskripsiBantuan"
                                value="{{ old('deskripsiBantuan', $data->deskripsi ?? '') }}" required>
                            @error('deskripsiBantuan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ route('storeEvaluasi') }}">
        @csrf
        <div class="modal fade modal-evaluasi" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Evaluasi Proposal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="kelayakanID" value="{{ Crypt::encrypt($data->id_kelayakan) }}">

                        <div class="form-row">
                            @foreach (['rencanaAnggaran' => 'Rencana Anggaran', 'dokumen' => 'Dokumentasi', 'denah' => 'Denah Lokasi'] as $name => $label)
                                <div class="form-group col-md-4">
                                    <label>{{ $label }} <span class="text-danger">*</span></label>
                                    <select name="{{ $name }}" class="form-control" required>
                                        <option value="" disabled {{ old($name) ? '' : 'selected' }}>-- Pilih --
                                        </option>
                                        <option value="ADA" {{ old($name) == 'ADA' ? 'selected' : '' }}>Ada</option>
                                        <option value="TIDAK ADA" {{ old($name) == 'TIDAK ADA' ? 'selected' : '' }}>
                                            Tidak
                                            Ada</option>
                                    </select>
                                    @error($name)
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Kepentingan Perusahaan <span
                                    class="text-danger">*</span></label>

                            <div class="row">
                                @php
                                    $kepentinganOptions = [
                                        'Wilayah Operasi NR (Ring I / II / III)',
                                        'Kelancaran Operasional/asset NR',
                                        'Menjaga hubungan baik shareholders/stakeholders',
                                        'Brand images/citra perusahaan',
                                        'Pengembangan wilayah usaha',
                                    ];
                                @endphp

                                @foreach ($kepentinganOptions as $i => $option)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="checkbox-{{ $i }}" name="kepentingan[]"
                                                value="{{ $option }}"
                                                {{ is_array(old('kepentingan')) && in_array($option, old('kepentingan')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="checkbox-{{ $i }}">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @error('kepentingan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Perkiraan Bantuan <span class="text-danger">*</span></label>
                                <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                    name="perkiraanDana" id="perkiraanDana" placeholder="Contoh: Rp. 1.000.000"
                                    value="{{ old('perkiraanDana') }}" required>
                                <input type="hidden" name="perkiraanDanaAsli" id="perkiraanDanaAsli"
                                    value="{{ old('perkiraanDanaAsli') }}">
                                @error('perkiraanDana')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Memenuhi Syarat Untuk <span class="text-danger">*</span></label>
                                <select name="syarat" class="form-control" required>
                                    <option value="" disabled {{ old('syarat') ? '' : 'selected' }}>-- Pilih --
                                    </option>
                                    <option value="Survei" {{ old('syarat') == 'Survei' ? 'selected' : '' }}>
                                        Survei/Konfirmasi</option>
                                    <option value="Tidak Memenuhi Syarat"
                                        {{ old('syarat') == 'Tidak Memenuhi Syarat' ? 'selected' : '' }}>Tidak Memenuhi
                                        Syarat</option>
                                </select>
                                @error('syarat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Reviewer <span class="text-danger">*</span></label>
                            <select class="form-control" name="reviewer" required>
                                <option value="" disabled {{ old('reviewer') ? '' : 'selected' }}>-- Pilih
                                    Reviewer
                                    --
                                </option>
                                @foreach ($dataReviewer as $reviewer)
                                    <option value="{{ $reviewer->username }}"
                                        {{ old('reviewer') == $reviewer->username ? 'selected' : '' }}>
                                        {{ $reviewer->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('reviewer')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if (!empty($evaluasi))
        <form method="post" action="{{ route('updateEvaluasi') }}">
            @csrf
            <div class="modal fade modal-evaluasiEdit" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">Edit Evaluasi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="evaluasiID"
                                value="{{ Crypt::encrypt($evaluasi->id_evaluasi) }}">

                            {{-- Rencana Anggaran, Dokumentasi, Denah Lokasi --}}
                            <div class="form-row">
                                @foreach (['rencana_anggaran' => 'Rencana Anggaran', 'dokumen' => 'Dokumentasi', 'denah' => 'Denah Lokasi'] as $name => $label)
                                    <div class="form-group col-md-4">
                                        <label>{{ $label }} <span class="text-danger">*</span></label>
                                        <select name="{{ $name }}" class="form-control" required>
                                            <option value="" disabled
                                                {{ old($name, $evaluasi->$name) ? '' : 'selected' }}>-- Pilih --</option>
                                            <option value="ADA"
                                                {{ old($name, $evaluasi->$name) == 'ADA' ? 'selected' : '' }}>Ada</option>
                                            <option value="TIDAK ADA"
                                                {{ old($name, $evaluasi->$name) == 'TIDAK ADA' ? 'selected' : '' }}>Tidak
                                                Ada</option>
                                        </select>
                                        @error($name)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            {{-- Kepentingan Perusahaan --}}
                            <div class="form-group">
                                <label class="font-weight-bold">Kepentingan Perusahaan <span
                                        class="text-danger">*</span></label>
                                <div class="row">
                                    @php
                                        $kepentinganOptions = [
                                            'Wilayah Operasi NR (Ring I / II / III)',
                                            'Kelancaran Operasional/asset NR',
                                            'Menjaga hubungan baik shareholders/stakeholders',
                                            'Brand images/citra perusahaan',
                                            'Pengembangan wilayah usaha',
                                        ];
                                    @endphp

                                    @foreach ($kepentinganOptions as $i => $option)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="checkbox-{{ $i }}" name="kepentingan[]"
                                                    value="{{ $option }}"
                                                    {{ in_array($option, old('kepentingan', $kepentinganDipilih)) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="checkbox-{{ $i }}">{{ $option }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('kepentingan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Perkiraan Dana & Syarat --}}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Perkiraan Bantuan <span class="text-danger">*</span></label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                        name="perkiraanDana" id="perkiraanDanaEdit"
                                        placeholder="Contoh: Rp. 1.000.000"
                                        value="{{ old('perkiraanDana', 'Rp. ' . number_format($data->nilai_bantuan, 0, ',', '.')) }}"
                                        required>
                                    <input type="hidden" name="perkiraanDanaAsli" id="perkiraanDanaAsliEdit"
                                        value="{{ old('perkiraanDanaAsli', $data->nilai_bantuan) }}">
                                    @error('perkiraanDana')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Memenuhi Syarat Untuk <span class="text-danger">*</span></label>
                                    <select name="syarat" class="form-control" required>
                                        <option value="" disabled
                                            {{ old('syarat', $evaluasi->syarat) ? '' : 'selected' }}>-- Pilih --</option>
                                        <option value="Survei"
                                            {{ old('syarat', $evaluasi->syarat) == 'Survei' ? 'selected' : '' }}>
                                            Survei/Konfirmasi</option>
                                        <option value="Tidak Memenuhi Syarat"
                                            {{ old('syarat', $evaluasi->syarat) == 'Tidak Memenuhi Syarat' ? 'selected' : '' }}>
                                            Tidak Memenuhi Syarat</option>
                                    </select>
                                    @error('syarat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Reviewer --}}
                            @if ($evaluasi->status == 'Approved 1')
                                <div class="form-group">
                                    <label>Reviewer <span class="text-danger">*</span></label>
                                    <select class="form-control" name="reviewer" required>
                                        <option value="" disabled
                                            {{ old('reviewer', $evaluasi->evaluator2) ? '' : 'selected' }}>-- Pilih
                                            Reviewer
                                            --
                                        </option>
                                        @foreach ($dataReviewer as $reviewer)
                                            <option value="{{ $reviewer->username }}"
                                                {{ old('reviewer', $evaluasi->evaluator2) == $reviewer->username ? 'selected' : '' }}>
                                                {{ $reviewer->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('reviewer')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @else
                                <input type="hidden" name="reviewer" value="{{ $evaluasi->evaluator2 }}">
                            @endif
                        </div>

                        {{-- Footer --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    @endif

    <form method="post" action="{{ route('storeSurvei') }}">
        @csrf
        <div class="modal fade modal-survei" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Survei Proposal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="kelayakanID" value="{{ Crypt::encrypt($data->id_kelayakan) }}">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Untuk Dibantu Berupa <span class="text-danger">*</span></label>
                                <select class="form-control" name="bantuan" required>
                                    <option value="" disabled selected>-- Pilih Bantuan --</option>
                                    @if ($data->jenis == 'Santunan')
                                        <option value="Dana" selected>Dana</option>
                                    @else
                                        <option value="Dana" {{ old('bantuan') == 'Dana' ? 'selected' : '' }}>
                                            Dana
                                        </option>
                                        <option value="Barang" {{ old('bantuan') == 'Barang' ? 'selected' : '' }}>
                                            Barang
                                        </option>
                                    @endif
                                </select>
                                @error('bantuan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Usulan/Rekomendasi <span class="text-danger">*</span></label>
                                <select class="form-control" name="usulan" required>
                                    <option value="" disabled selected>-- Pilih Rekomendasi --</option>
                                    <option value="Disarankan" {{ old('usulan') == 'Disarankan' ? 'selected' : '' }}>
                                        Disarankan</option>
                                    @if ($data->jenis != 'Santunan')
                                        <option value="Dipertimbangkan"
                                            {{ old('usulan') == 'Dipertimbangkan' ? 'selected' : '' }}>Dipertimbangkan
                                        </option>
                                        <option value="Tidak Memenuhi Kriteria"
                                            {{ old('usulan') == 'Tidak Memenuhi Kriteria' ? 'selected' : '' }}>Tidak
                                            Memenuhi Kriteria</option>
                                    @endif
                                </select>
                                @error('usulan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Nilai Bantuan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" onkeypress="return hanyaAngka(event)"
                                    name="nilaiBantuan" id="nilaiBantuan" placeholder="Contoh: Rp. 1.000.000"
                                    value="{{ 'Rp. ' . number_format($data->nilai_bantuan, 0, ',', '.') }}">
                                <input type="hidden" class="form-control" onkeypress="return hanyaAngka(event)"
                                    name="nilaiBantuanAsli" id="nilaiBantuanAsli"
                                    value="{{ $data->nilai_bantuan }}">
                                @error('nilaiBantuanAsli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Reviewer <span class="text-danger">*</span></label>
                            <select class="form-control" name="reviewer" required>
                                <option value="" disabled {{ old('reviewer') ? '' : 'selected' }}>-- Pilih
                                    Reviewer
                                    --
                                </option>
                                @foreach ($dataReviewer as $reviewer)
                                    <option value="{{ $reviewer->username }}"
                                        {{ old('reviewer') == $reviewer->username ? 'selected' : '' }}>
                                        {{ $reviewer->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('reviewer')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ route('storeDokumentasi') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade modal-dokumentasi" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Upload Dokumentasi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="kelayakanID" value="{{ Crypt::encrypt($data->id_kelayakan) }}">
                        <label>Foto Dokumentasi <span class="text-danger">*</span></label>
                        <input type="file" name="dokumentasi" class="dropify" accept="image/*,video/*"
                            data-max-file-size="10M" />
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ route('storeBASTDana') }}">
        @csrf
        <div class="modal fade modal-bast" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Input Berita Acara</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="kelayakanID" value="{{ Crypt::encrypt($data->id_kelayakan) }}">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>No BAST</label>
                                <input type="text" name="noBAST" class="form-control text-uppercase"
                                    value="{{ old('noBAST') }}">
                                @error('noBAST')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tanggal</label>
                                <div class="input-group">
                                    <input type="text" name="tglBAST" class="form-control mdate"
                                        value="{{ old('tglBAST') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar text-info"></i></span>
                                    </div>
                                </div>
                                @error('tglBAST')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>No BAST Pihak Kedua</label>
                                <input type="text" name="noPihakKedua" class="form-control text-uppercase"
                                    value="{{ old('noPihakKedua') }}">
                                @error('noPihakKedua')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Disetujui Oleh <span class="text-danger">*</span></label>
                                <select class="form-control" name="approver" id="approver" required>
                                    <option value="" {{ old('approver') ? '' : 'selected' }}>-- Pilih Approver --
                                    </option>
                                    @foreach ($dataApprover as $approver)
                                        <option value="{{ $approver->id_user }}"
                                            data-jabatan="{{ $approver->jabatan }}"
                                            {{ old('approver') == $approver->id_user ? 'selected' : '' }}>
                                            {{ $approver->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('approver')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input class="form-control bg-white" name="jabatan" id="jabatan" maxlength="200"
                                    readonly value="{{ old('jabatan') }}" required>
                                @error('jabatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ route('updateProker') }}">
        @csrf
        <div class="modal fade modal-proker" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Program Kerja</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="kelayakanID" value="{{ Crypt::encrypt($data->id_kelayakan) }}">
                        <div class="form-group">
                            <label>Program Kerja <span class="text-danger">*</span></label>
                            <select class="form-control pilihProker" name="prokerID" id="prokerID" required>
                                <option value="" disabled
                                    {{ old('prokerID', $data->id_proker ?? '') ? '' : 'selected' }}>
                                    -- Pilih Program --
                                </option>
                                @foreach ($dataProker as $proker)
                                    <option pilar="{{ $proker->pilar }}" tpb="{{ $proker->gols }}"
                                        prioritas="{{ $proker->prioritas }}" value="{{ $proker->id_proker }}"
                                        {{ old('prokerID', $data->id_proker ?? '') == $proker->id_proker ? 'selected' : '' }}>
                                        {{ $proker->proker }}
                                    </option>
                                @endforeach
                            </select>
                            @error('proker')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Pilar <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" name="pilar" id="pilar"
                                    value="{{ $data->pilar ?? '' }}" readonly>
                                @error('pilar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label>TPB <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" name="tpb" id="tpb"
                                    value="{{ $data->gols ?? '' }}" readonly>
                                @error('tpb')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Prioritas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" name="prioritas" id="prioritas"
                                    value="{{ $data->prioritas ?? '' }}" readonly>
                                @error('pilar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if (!empty($survei))
        <form method="post" action="{{ route('updateSurvei') }}">
            @csrf
            <div class="modal fade modal-surveiEdit" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">Edit Survei</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="surveiID" value="{{ Crypt::encrypt($survei->id_survei) }}">

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Untuk Dibantu Berupa <span class="text-danger">*</span></label>
                                    <select class="form-control" name="bantuan" required>
                                        <option value="" disabled {{ $survei->bantuan_berupa ? '' : 'selected' }}>
                                            --
                                            Pilih Bantuan --</option>
                                        @php
                                            $bantuanOptions =
                                                $data->jenis == 'Santunan' ? ['Dana'] : ['Dana', 'Barang'];
                                        @endphp
                                        @foreach ($bantuanOptions as $opt)
                                            <option value="{{ $opt }}"
                                                {{ old('bantuan', $survei->bantuan_berupa) == $opt ? 'selected' : '' }}>
                                                {{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    @error('bantuan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Usulan/Rekomendasi <span class="text-danger">*</span></label>
                                    <select class="form-control" name="usulan" required>
                                        <option value="" disabled {{ $survei->usulan ? '' : 'selected' }}>-- Pilih
                                            Rekomendasi --</option>
                                        @php
                                            $usulanOptions = ['Disarankan'];
                                            if ($data->jenis != 'Santunan') {
                                                $usulanOptions = array_merge($usulanOptions, [
                                                    'Dipertimbangkan',
                                                    'Tidak Memenuhi Kriteria',
                                                ]);
                                            }
                                        @endphp
                                        @foreach ($usulanOptions as $opt)
                                            <option value="{{ $opt }}"
                                                {{ old('usulan', $survei->usulan) == $opt ? 'selected' : '' }}>
                                                {{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    @error('usulan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Nilai Bantuan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" onkeypress="return hanyaAngka(event)"
                                        name="nilaiBantuan" id="nilaiBantuanEdit" placeholder="Contoh: Rp. 1.000.000"
                                        value="{{ 'Rp. ' . number_format($data->nilai_bantuan, 0, ',', '.') }}">
                                    <input type="hidden" class="form-control" onkeypress="return hanyaAngka(event)"
                                        name="nilaiBantuanAsli" id="nilaiBantuanAsliEdit"
                                        value="{{ $data->nilai_bantuan }}">
                                    @error('nilaiBantuan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            @if ($survei->status == 'Forward')
                                <div class="form-group">
                                    <label>Reviewer <span class="text-danger">*</span></label>
                                    <select class="form-control" name="reviewer" required>
                                        <option value="" disabled
                                            {{ old('reviewer', $survei->survei2) ? '' : 'selected' }}>-- Pilih Reviewer --
                                        </option>
                                        @foreach ($dataReviewer as $reviewer)
                                            <option value="{{ $reviewer->username }}"
                                                {{ old('reviewer', $survei->survei2) == $reviewer->username ? 'selected' : '' }}>
                                                {{ $reviewer->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('reviewer')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @else
                                <input type="hidden" name="reviewer" value="{{ $survei->survei2 }}">
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form method="post" action="{{ route('updateTermin') }}">
            @csrf
            <div class="modal fade modal-termin" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">Edit Termin</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="surveiID" value="{{ Crypt::encrypt($survei->id_survei) }}">
                            <div class="form-group">
                                <label>Termin Pembayaran <span class="text-danger">*</span></label>
                                <select class="form-control" name="jumlah_termin" id="jumlahTermin" required>
                                    <option value="" disabled selected>-- Pilih Jumlah Termin --</option>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}">{{ $i }} Termin</option>
                                    @endfor
                                </select>
                                @error('jumlah_termin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div id="persenTerminWrapper" class="form-row">
                                <!-- Kolom persentase akan muncul di sini -->
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

    @if (!empty($bast))
        <div class="modal fade modal-bastEdit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" action="{{ route('updateBASTDana') }}">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">Edit Berita Acara</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="bastID" value="{{ Crypt::encrypt($bast->id_bast_dana) }}">

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>No BAST</label>
                                    <input type="text" name="noBAST" class="form-control text-uppercase"
                                        value="{{ $bast->no_bast_dana }}">
                                    @error('noBAST')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Tanggal</label>
                                    <div class="input-group">
                                        <input type="text" name="tglBAST" class="form-control mdate"
                                            value="{{ $bast->tgl_bast ? \Carbon\Carbon::parse($bast->tgl_bast)->format('d-m-Y') : '' }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i
                                                    class="fas fa-calendar text-info"></i></span>
                                        </div>
                                    </div>
                                    @error('tglBAST')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>No BAST Pihak Kedua</label>
                                    <input type="text" name="noPihakKedua" class="form-control text-uppercase"
                                        value="{{ $bast->no_bast_pihak_kedua }}">
                                    @error('noPihakKedua')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Disetujui Oleh <span class="text-danger">*</span></label>
                                    <select class="form-control" name="approver" id="approver_edit" required>
                                        <option value="" {{ old('approver') ? '' : 'selected' }}>-- Pilih Approver
                                            --</option>

                                        @foreach ($dataApprover as $approver)
                                            <option value="{{ $approver->id_user }}"
                                                data-jabatan="{{ $approver->jabatan }}"
                                                {{ $bast->approver_id == $approver->id_user ? 'selected' : '' }}>
                                                {{ $approver->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('approver')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Jabatan <span class="text-danger">*</span></label>
                                    <input class="form-control bg-white" name="jabatan" id="jabatan_edit"
                                        maxlength="200" readonly value="{{ $bast->jabatan_pejabat }}" required>
                                    @error('jabatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <form method="post" action="{{ route('checklistYKPP') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-ykpp" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">
                            Checklist YKPP
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="kelayakanID" value="{{ Crypt::encrypt($data->id_kelayakan) }}">
                        <div class="form-group mb-0">
                            <label>Tahun Anggaran <span class="text-danger">*</span></label>
                            <select class="form-control mb-2" name="tahun">
                                <option value="" disabled selected>-- Pilih Tahun --</option>
                                @foreach ($dataAnggaran as $da)
                                    <option value="{{ $da->tahun }}">{{ $da->tahun }}</option>
                                @endforeach
                            </select>
                            @error('tahun')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ route('storePembayaran') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-pembayaran" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">
                            Tambah Pembayaran
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="kelayakanID" value="{{ Crypt::encrypt($data->id_kelayakan) }}">
                        <div class="form-group">
                            <label>Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="deskripsi" rows="3" maxlength="500" required>{{ 'Pembayaran atas ' . $data->bantuan_untuk . ' ' . $data->nama_lembaga . ' ' . $data->kabupaten . ' ' . $data->provinsi }}</textarea>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Termin Ke <span class="text-danger">*</span></label>
                                <select class="form-control" name="termin" required>
                                    <option value="" disabled selected>-- Pilih Termin --</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                @error('termin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Metode Pembayaran <span class="text-danger">*</span></label>
                                <select class="form-control" name="metode" required>
                                    <option value="" disabled selected>-- Pilih Metode --</option>
                                    <option value="Popay">Popay</option>
                                    <option value="YKPP">YKPP</option>
                                </select>
                                @error('metode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Jumlah Pembayaran <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off"
                                    name="jumlahPembayaran" id="jumlahPembayaran"
                                    value="{{ old('jumlahPembayaran') }}" required>
                                <input type="hidden" name="jumlahPembayaranAsli" id="jumlahPembayaranAsli"
                                    value="{{ old('jumlahPembayaranAsli') }}">
                                @error('jumlahPembayaranAsli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Fee (%) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" maxlength="3" autocomplete="off"
                                    onkeypress="return hanyaAngka(event)" name="fee" id="fee"
                                    value="{{ old('fee') }}" required>
                                {{-- <input type="hidden" name="feeAsli" id="feeAsli" value="{{ old('feeAsli') }}"> --}}
                                @error('fee')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ route('updatePembayaran') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-pembayaranEdit" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">
                            Edit Pembayaran
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="pembayaranID" id="pembayaranID">
                        <div class="form-group">
                            <label>Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" maxlength="500" required></textarea>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Termin Ke <span class="text-danger">*</span></label>
                                <select class="form-control" name="termin" id="termin" required>
                                    <option value="" disabled selected>-- Pilih Termin --</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                @error('termin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Metode Pembayaran <span class="text-danger">*</span></label>
                                <select class="form-control" name="metode" id="metode" required>
                                    <option value="" disabled selected>-- Pilih Metode --</option>
                                    <option value="Popay">Popay</option>
                                    <option value="YKPP">YKPP</option>
                                </select>
                                @error('metode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Jumlah Pembayaran <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off"
                                    name="jumlahPembayaran" id="jumlahPembayaran_edit"
                                    value="{{ old('jumlahPembayaran') }}" required>
                                <input type="hidden" name="jumlahPembayaranAsli" id="jumlahPembayaranAsli_edit"
                                    value="{{ old('jumlahPembayaranAsli') }}">
                                @error('jumlahPembayaranAsli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Fee (%) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" name="fee"
                                    id="fee_edit" value="{{ old('fee') }}" required>
                                @error('fee')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ route('storePaymentRequest') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-exportPopay" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">
                            Export Pembayaran
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="pembayaranID" id="pembayaranID_popay">
                        <div class="form-group">
                            <label>No Invoice <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" name="noInvoice"
                                value="{{ old('noInvoice') }}">
                            @error('noInvoice')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tanggal Invoice <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="invoiceDate" class="form-control tgl-invoice"
                                        value="{{ old('invoiceDate') }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar text-info"></i></span>
                                    </div>
                                </div>
                                @error('invoiceDate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Due Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="invoiceDueDate" class="form-control duedate"
                                        value="{{ old('invoiceDueDate') }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar text-info"></i></span>
                                    </div>
                                </div>
                                @error('invoiceDueDate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Export to Popay</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script
        src="{{ asset('template/assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
    </script>

    <script src="{{ asset('template/assets/node_modules/dropify/dist/js/dropify.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = Array.from(document.querySelectorAll('.preview-image'));
            const modalImage = document.getElementById('modalImage');
            let currentIndex = 0;
            let isZoomed = false;

            function showImage(index) {
                const src = images[index].getAttribute('data-src');
                modalImage.setAttribute('src', src);
                currentIndex = index;
                isZoomed = false;
                modalImage.style.transform = 'scale(1)';
                modalImage.style.cursor = 'zoom-in';
            }

            // Klik thumbnail
            images.forEach((img, index) => {
                img.addEventListener('click', function() {
                    showImage(index);
                    $('#imagePreviewModal').modal('show');
                });
            });

            // Navigasi
            document.getElementById('prevBtn').addEventListener('click', function(e) {
                e.preventDefault();
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                showImage(currentIndex);
            });

            document.getElementById('nextBtn').addEventListener('click', function(e) {
                e.preventDefault();
                currentIndex = (currentIndex + 1) % images.length;
                showImage(currentIndex);
            });

            // Zoom toggle
            modalImage.addEventListener('click', function() {
                isZoomed = !isZoomed;
                this.style.transform = isZoomed ? 'scale(2)' : 'scale(1)';
                this.style.cursor = isZoomed ? 'zoom-out' : 'zoom-in';
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.tooltip-trigger').tooltip();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#approver').on('change', function() {
                const selected = $(this).find(':selected');
                $('#jabatan').val(selected.data('jabatan') || '');
            });

            // Trigger change if there's old value
            if ($('#approver').val()) {
                $('#approver').trigger('change');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#approver_edit').on('change', function() {
                const selected = $(this).find(':selected');
                $('#jabatan_edit').val(selected.data('jabatan') || '');
            });

            // Trigger change if there's old value
            if ($('#approver_edit').val()) {
                $('#approver_edit').trigger('change');
            }
        });
    </script>

    <script>
        $(document).on('click', '.exportPopay', function(e) {
            document.getElementById("pembayaranID_popay").value = $(this).attr('data-id');
        });
    </script>

    <script>
        $('.mdate').bootstrapMaterialDatePicker({
            format: 'DD-MM-YYYY',
            time: false
        });

        $('.tgl-surat').bootstrapMaterialDatePicker({
            weekStart: 0,
            maxDate: new Date(),
            format: 'DD-MMM-YYYY',
            time: false
        }).on('change', function(e, date) {
            $('.tgl-terima').bootstrapMaterialDatePicker('setMaxDate', date);
        });

        $('.tgl-terima').bootstrapMaterialDatePicker({
            weekStart: 0,
            // maxDate: new Date(),
            format: 'DD-MMM-YYYY',
            time: false
        });

        $('.tgl-invoice').bootstrapMaterialDatePicker({
            weekStart: 0,
            maxDate: new Date(),
            format: 'DD-MMM-YYYY',
            time: false
        }).on('change', function(e, date) {
            $('.duedate').bootstrapMaterialDatePicker('setMinDate', date);
        });

        $('.duedate').bootstrapMaterialDatePicker({
            weekStart: 0,
            // maxDate: new Date(),
            format: 'DD-MMM-YYYY',
            time: false
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const terminSelect = document.getElementById('jumlahTermin');
            const persenWrapper = document.getElementById('persenTerminWrapper');

            terminSelect.addEventListener('change', function() {
                const jumlah = parseInt(this.value);
                persenWrapper.innerHTML = '';

                for (let i = 1; i <= jumlah; i++) {
                    const div = document.createElement('div');
                    div.className = 'form-group col-md-3';
                    div.innerHTML = `
                    <label>Persen Termin ${i}</label>
                    <input type="text"
                           name="persen_termin_${i}"
                           class="form-control"
                           placeholder="Contoh: 50"
                           min="0"
                           max="100"
                           required>
                `;
                    persenWrapper.appendChild(div);
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil tab aktif dari localStorage
            var activeTab = localStorage.getItem('activeTab');

            if (activeTab) {
                // Aktifkan tab menggunakan jQuery Bootstrap 4
                $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
            }

            // Simpan tab aktif saat berpindah
            $('.nav-tabs a').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href');
                localStorage.setItem('activeTab', currentTab);
            });
        });
    </script>

    <script>
        $('.modal-proker').on('shown.bs.modal', function() {
            $(this).find('.pilihProker').select2({
                dropdownParent: $('.modal-proker'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Proker --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.modal-lampiran').on('shown.bs.modal', function() {
            $(this).find('.pilihDokumen').select2({
                dropdownParent: $('.modal-lampiran'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Dokumen --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.modal-lampiranEdit').on('shown.bs.modal', function() {
            $(this).find('.pilihDokumen').select2({
                dropdownParent: $('.modal-lampiranEdit'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Dokumen --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.modal-updateBank').on('shown.bs.modal', function() {
            $(this).find('.pilihBank').select2({
                dropdownParent: $('.modal-updateBank'),
                width: '100%',
                placeholder: "-- Pilih Bank --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.modal-updateProposal').on('shown.bs.modal', function() {
            $(this).find('.pilihPIC').select2({
                dropdownParent: $('.modal-updateProposal'),
                width: '100%',
                placeholder: "-- Pilih Pengirim --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.modal-survei').on('shown.bs.modal', function() {
            $(this).find('.pilihProker').select2({
                dropdownParent: $('.modal-survei'),
                width: '100%',
                placeholder: "-- Pilih Program --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.modal-updatePenerima').on('shown.bs.modal', function() {
            $(this).find('.pilihLembaga').select2({
                dropdownParent: $('.modal-updatePenerima'),
                width: '100%',
                placeholder: "-- Pilih Lembaga --",
                allowClear: true
            });

            $(this).find('.pilihProvinsi').select2({
                dropdownParent: $('.modal-updatePenerima'),
                width: '100%',
                placeholder: "-- Pilih Provinsi --",
                allowClear: true
            });

            $(this).find('.pilihKabupaten').select2({
                dropdownParent: $('.modal-updatePenerima'),
                width: '100%',
                placeholder: "-- Pilih Kabupaten/Kota --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.modal-updatePenerima').on('shown.bs.modal', function() {
            $(this).find('.pilihKecamatan').select2({
                dropdownParent: $('.modal-updatePenerima'),
                width: '100%',
                placeholder: "-- Pilih Kecamatan --",
                allowClear: true
            });

            $(this).find('.pilihKelurahan').select2({
                dropdownParent: $('.modal-updatePenerima'),
                width: '100%',
                placeholder: "-- Pilih Kelurahan --",
                allowClear: true
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            const provOld = "{{ old('provinsi', $data->provinsi ?? '') }}";
            const kabOld = "{{ old('kabupaten', $data->kabupaten ?? '') }}";
            const kecOld = "{{ old('kecamatan', $data->kecamatan ?? '') }}";
            const kelOld = "{{ old('kelurahan', $data->kelurahan ?? '') }}";

            function loadKabupaten(provinsi, callback) {
                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupaten/" + encodeURIComponent(provinsi),
                    success: function(response) {
                        $('#kabupaten').empty().append(
                            '<option disabled selected>-- Pilih Kabupaten --</option>');
                        $.each(response, function(i, kab) {
                            const selected = kab.value === kabOld ? 'selected' : '';
                            $('#kabupaten').append('<option value="' + kab.value + '" ' +
                                selected + '>' + kab.label + '</option>');
                        });
                        $('#kabupaten').prop('disabled', false);
                        if (callback) callback();
                    },
                    error: function() {
                        toastr.error("Gagal memuat kabupaten", "Failed", {
                            closeButton: true
                        });
                    }
                });
            }

            function loadKecamatan(provinsi, kabupaten, callback) {
                $.ajax({
                    type: 'GET',
                    url: `/proposal/data-kecamatan/${provinsi}/${kabupaten}`,
                    success: function(response) {
                        $('#kecamatan').empty().append(
                            '<option disabled selected>-- Pilih Kecamatan --</option>');
                        $.each(response, function(i, kec) {
                            const selected = kec.value === kecOld ? 'selected' : '';
                            $('#kecamatan').append(
                                `<option value="${kec.value}" ${selected}>${kec.label}</option>`
                            );
                        });
                        $('#kecamatan').prop('disabled', false);
                        if (callback) callback();
                    },
                    error: function() {
                        toastr.error("Gagal memuat kecamatan", "Failed", {
                            closeButton: true
                        });
                    }
                });
            }

            function loadKelurahan(provinsi, kabupaten, kecamatan) {
                $.ajax({
                    type: 'GET',
                    url: `/proposal/data-kelurahan/${provinsi}/${kabupaten}/${kecamatan}`,
                    success: function(response) {
                        $('#kelurahan').empty().append(
                            '<option disabled selected>-- Pilih Kelurahan --</option>');
                        $.each(response, function(i, kel) {
                            const selected = kel.value === kelOld ? 'selected' : '';
                            $('#kelurahan').append(
                                `<option value="${kel.value}" ${selected}>${kel.label}</option>`
                            );
                        });
                        $('#kelurahan').prop('disabled', false);
                    },
                    error: function() {
                        toastr.error("Gagal memuat kelurahan", "Failed", {
                            closeButton: true
                        });
                    }
                });
            }

            // Auto-trigger saat halaman edit dimuat
            if (provOld) {
                $('#provinsi').val(provOld);
                loadKabupaten(provOld, function() {
                    if (kabOld) {
                        $('#kabupaten').val(kabOld);
                        loadKecamatan(provOld, kabOld, function() {
                            if (kecOld) {
                                $('#kecamatan').val(kecOld);
                                loadKelurahan(provOld, kabOld, kecOld);
                            }
                        });
                    }
                });
            }

            // Event saat user ubah dropdown secara manual
            $('#provinsi').change(function() {
                const prov = $(this).val();
                loadKabupaten(prov);
                $('#kecamatan').empty().append('<option disabled selected>-- Pilih Kecamatan --</option>');
                $('#kelurahan').empty().append('<option disabled selected>-- Pilih Kelurahan --</option>');
            });

            $('#kabupaten').change(function() {
                const prov = $('#provinsi').val();
                const kab = $(this).val();
                loadKecamatan(prov, kab);
                $('#kelurahan').empty().append('<option disabled selected>-- Pilih Kelurahan --</option>');
            });

            $('#kecamatan').change(function() {
                const prov = $('#provinsi').val();
                const kab = $('#kabupaten').val();
                const kec = $(this).val();
                loadKelurahan(prov, kab, kec);
            });
        });
    </script>

    <script>
        var inputRupiah = document.getElementById('besarPermohonan');
        var inputHidden = document.getElementById('besarPermohonanAsli');

        inputRupiah.addEventListener('input', function() {
            // Simpan posisi kursor
            var cursorPos = this.selectionStart;
            var originalLength = this.value.length;

            // Format tampilan input
            this.value = formatRupiah(this.value, 'Rp. ');

            // Kembalikan posisi kursor
            var updatedLength = this.value.length;
            this.setSelectionRange(cursorPos + (updatedLength - originalLength), cursorPos + (updatedLength -
                originalLength));

            // Set nilai ke hidden input dalam bentuk angka (tanpa Rp dan titik)
            inputHidden.value = convertToAngka(this.value);
        });

        var inputRupiah2 = document.getElementById('perkiraanDana');
        var inputHidden2 = document.getElementById('perkiraanDanaAsli');

        inputRupiah2.addEventListener('input', function() {
            // Simpan posisi kursor
            var cursorPos = this.selectionStart;
            var originalLength = this.value.length;

            // Format tampilan input
            this.value = formatRupiah(this.value, 'Rp. ');

            // Kembalikan posisi kursor
            var updatedLength = this.value.length;
            this.setSelectionRange(cursorPos + (updatedLength - originalLength), cursorPos + (updatedLength -
                originalLength));

            // Set nilai ke hidden input dalam bentuk angka (tanpa Rp dan titik)
            inputHidden2.value = convertToAngka(this.value);
        });

        var inputRupiah3 = document.getElementById('nilaiBantuan');
        var inputHidden3 = document.getElementById('nilaiBantuanAsli');

        inputRupiah3.addEventListener('input', function() {
            // Simpan posisi kursor
            var cursorPos = this.selectionStart;
            var originalLength = this.value.length;

            // Format tampilan input
            this.value = formatRupiah(this.value, 'Rp. ');

            // Kembalikan posisi kursor
            var updatedLength = this.value.length;
            this.setSelectionRange(cursorPos + (updatedLength - originalLength), cursorPos + (updatedLength -
                originalLength));

            // Set nilai ke hidden input dalam bentuk angka (tanpa Rp dan titik)
            inputHidden3.value = convertToAngka(this.value);
        });

        var inputRupiah4 = document.getElementById('perkiraanDanaEdit');
        var inputHidden4 = document.getElementById('perkiraanDanaAsliEdit');

        inputRupiah4.addEventListener('input', function() {
            // Simpan posisi kursor
            var cursorPos = this.selectionStart;
            var originalLength = this.value.length;

            // Format tampilan input
            this.value = formatRupiah(this.value, 'Rp. ');

            // Kembalikan posisi kursor
            var updatedLength = this.value.length;
            this.setSelectionRange(cursorPos + (updatedLength - originalLength), cursorPos + (updatedLength -
                originalLength));

            // Set nilai ke hidden input dalam bentuk angka (tanpa Rp dan titik)
            inputHidden4.value = convertToAngka(this.value);
        });

        var inputRupiah5 = document.getElementById('nilaiBantuanEdit');
        var inputHidden5 = document.getElementById('nilaiBantuanAsliEdit');

        inputRupiah5.addEventListener('input', function() {
            // Simpan posisi kursor
            var cursorPos = this.selectionStart;
            var originalLength = this.value.length;

            // Format tampilan input
            this.value = formatRupiah(this.value, 'Rp. ');

            // Kembalikan posisi kursor
            var updatedLength = this.value.length;
            this.setSelectionRange(cursorPos + (updatedLength - originalLength), cursorPos + (updatedLength -
                originalLength));

            // Set nilai ke hidden input dalam bentuk angka (tanpa Rp dan titik)
            inputHidden5.value = convertToAngka(this.value);
        });

        var inputRupiah6 = document.getElementById('jumlahPembayaran');
        var inputHidden6 = document.getElementById('jumlahPembayaranAsli');

        inputRupiah6.addEventListener('input', function() {
            // Simpan posisi kursor
            var cursorPos = this.selectionStart;
            var originalLength = this.value.length;

            // Format tampilan input
            this.value = formatRupiah(this.value, 'Rp. ');

            // Kembalikan posisi kursor
            var updatedLength = this.value.length;
            this.setSelectionRange(cursorPos + (updatedLength - originalLength), cursorPos + (updatedLength -
                originalLength));

            // Set nilai ke hidden input dalam bentuk angka (tanpa Rp dan titik)
            inputHidden6.value = convertToAngka(this.value);
        });

        var inputRupiah8 = document.getElementById('jumlahPembayaran_edit');
        var inputHidden8 = document.getElementById('jumlahPembayaranAsli_edit');

        inputRupiah8.addEventListener('input', function() {
            // Simpan posisi kursor
            var cursorPos = this.selectionStart;
            var originalLength = this.value.length;

            // Format tampilan input
            this.value = formatRupiah(this.value, 'Rp. ');

            // Kembalikan posisi kursor
            var updatedLength = this.value.length;
            this.setSelectionRange(cursorPos + (updatedLength - originalLength), cursorPos + (updatedLength -
                originalLength));

            // Set nilai ke hidden input dalam bentuk angka (tanpa Rp dan titik)
            inputHidden8.value = convertToAngka(this.value);
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString();
            var split = number_string.split(',');
            var sisa = split[0].length % 3;
            var rupiah = split[0].substr(0, sisa);
            var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix ? prefix + rupiah : rupiah;
        }

        function convertToAngka(rupiah) {
            return rupiah.replace(/[^0-9]/g, '');
        }
    </script>

    <script>
        $(document).on('click', '.previewPdf', function(e) {
            e.preventDefault();
            const fileSrc = $(this).data('src');
            $('#pdfPreviewFrame').attr('src', fileSrc);
            $('#previewPdfModal').modal('show');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dari').on('change', function() {
                const selected = $(this).find(':selected');
                $('#alamat').val(selected.attr('alamat') || '');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#prokerID').on('change', function() {
                const selected = $(this).find(':selected');
                $('#pilar').val(selected.attr('pilar') || '');
                $('#tpb').val(selected.attr('tpb') || '');
                $('#prioritas').val(selected.attr('prioritas') || '');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.editLampiran', function(e) {
                const lampiranID = $(this).data('id');
                const namaDokumen = $(this).data('nama');

                $('#lampiranID').val(lampiranID);
                $('#nama_dokumen_edit').val(namaDokumen).trigger('change');
            });
        });
    </script>

    <script>
        $('.deleteLampiran').click(function() {
            var data_id = $(this).data('id');
            var data_nama = $(this).data('nama');

            swal({
                title: "Konfirmasi Hapus",
                text: "Anda yakin ingin menghapus dokumen " + data_nama +
                    "? Tindakan ini tidak bisa dibatalkan.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-secondary",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                setTimeout(() => {
                    window.location = "/proposal/deleteDokumen/" + data_id;
                }, 1000);
            });
        });
    </script>

    <script>
        $('.deleteDokumentasi').click(function() {
            var data_id = $(this).data('id');

            swal({
                title: "Konfirmasi Hapus",
                text: "Anda yakin ingin menghapus dokumentasi ini? Tindakan ini tidak bisa dibatalkan.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-secondary",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                setTimeout(() => {
                    window.location = "/proposal/deleteDokumen/" + data_id;
                }, 1000);
            });
        });
    </script>

    <script>
        $('.deleteBAST').click(function() {
            var data_id = $(this).data('id');

            swal({
                title: "Konfirmasi Hapus",
                text: "Anda yakin ingin menghapus dokumen BAST ini? Tindakan ini tidak bisa dibatalkan.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-secondary",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                setTimeout(() => {
                    window.location = "/DokumenLegal/deleteBAST/" + data_id;
                }, 1000);
            });
        });
    </script>

    <script>
        $('.deletePembayaran').click(function() {
            var data_id = $(this).data('id');

            swal({
                title: "Konfirmasi Hapus",
                text: "Anda yakin ingin menghapus daftar pembayaran ini? Tindakan ini tidak bisa dibatalkan.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-secondary",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                setTimeout(() => {
                    window.location = "/payment/deletePembayaran/" + data_id;
                }, 1000);
            });
        });
    </script>

    <script>
        $('.approveYKPP').click(function() {
            var data_id = $(this).data('id');

            swal({
                title: "Konfirmasi Persetujuan",
                text: "Anda yakin menyetujui penyaluran TJSL ke YKPP? Tindakan ini tidak bisa dibatalkan.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-info",
                cancelButtonClass: "btn-secondary",
                confirmButtonText: "Ya, Setuju",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                setTimeout(() => {
                    window.location = "/report/approveYKPP/" + data_id;
                }, 1000);
            });
        });
    </script>

    <script>
        $(document).on('click', '.editPembayaran', function(e) {
            document.getElementById("pembayaranID").value = $(this).attr('data-id');
            document.getElementById("deskripsi").value = $(this).attr('data-deskripsi');
            document.getElementById("termin").value = $(this).attr('data-termin');
            document.getElementById("metode").value = $(this).attr('data-metode');
            document.getElementById("jumlahPembayaran_edit").value = $(this).attr('data-jumlah_rupiah');
            document.getElementById("jumlahPembayaranAsli_edit").value = $(this).attr('data-jumlah');
            document.getElementById("fee_edit").value = $(this).attr('data-fee');
        });
    </script>

    <script>
        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
