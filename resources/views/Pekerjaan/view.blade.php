@extends('layout.master_vendor')
@section('title', 'NR SHARE | Detail Project')

@section('content')
    <style>
        .scroll-lampiran {
            max-height: 1000px;
            overflow-y: auto;
        }
    </style>

    <style>
        .scroll-log {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>

    <div class="pcoded-inner-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">
                                <b>Detail Project</b>
                                <div class="btn-group fa-pull-right">
                                    <button class="btn btn-rounded font-weight-bold btn-light mr-0 dropdown-toggle"
                                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Optional Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if (in_array(session('user')->role, ['Admin']))
                                            <a class="dropdown-item updateStatus" href="javascript:void(0)"
                                                data-toggle="modal" data-target=".modal-status">Update Status</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item resetStatus"
                                                data-id="{{ encrypt($data->pekerjaan_id) }}" href="javascript:void(0)">Reset
                                                Status</a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('indexPekerjaan') }}">Back</a>
                                    </div>
                                </div>

                                @if ($jumlahSPH > 0 and $data->id_vendor == '')
                                    <button class="btn btn-rounded btn-light font-weight-bold fa-pull-right mr-2"
                                        type="button" data-toggle="modal" data-target=".modal-selectVendor">
                                        Select Vendor
                                    </button>
                                @endif
                                @if ($data->id_vendor != '')
                                    @if (in_array($data->status, ['Procurement']))
                                        <button
                                            class="btn btn-rounded btn-light text-danger font-weight-bold fa-pull-right mr-2 resetExecutor"
                                            data-id="{{ encrypt($data->pekerjaan_id) }}" type="button">
                                            Reset Vendor
                                        </button>
                                    @endif
                                @endif
                            </h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboardVendor') }}"><i
                                        class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#!">Project List</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="#!">Detail Project</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-body">
            <div class="page-wrapper">
                <div class="row">
                    <div class="col-xl-8 col-lg-12">
                        <div class="card">
                            <div class="card-block p-3">
                                <h5 class="card-title font-weight-bold">
                                    Detail Project <span style="color: red">{{ '#' . $data->pekerjaan_id }}</span>
                                </h5>
                                <h6 class="card-subtitle mb-4">
                                    @if ($data->status == 'Open')
                                        <span class="badge badge-secondary f-12">Open</span>
                                    @elseif($data->status == 'Procurement')
                                        <span class="badge badge-warning f-12">Procurement</span>
                                    @elseif($data->status == 'In Progress')
                                        <span class="badge badge-primary f-12">In Progress</span>
                                    @elseif($data->status == 'Pending')
                                        <span class="badge badge-danger f-12">Pending</span>
                                    @else
                                        <span class="badge badge-danger f-12">Non Active</span>
                                    @endif
                                </h6>
                                <table width="100%">
                                    <tr>
                                        <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">Nama
                                            Proyek
                                        </th>
                                        <td>{{ $data->nama_pekerjaan }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                            Ringkasan Pekerjaan
                                        </th>
                                        <td>{{ $data->ringkasan }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">Program
                                            Kerja
                                        </th>
                                        <td>{{ $data->proker }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                            Prioritas
                                        </th>
                                        <td>
                                            @if ($data->prioritas != '')
                                                {{ $data->prioritas }}
                                            @else
                                                Sosial/Ekonomi
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">Pilar
                                        </th>
                                        <td>{{ $data->pilar }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">Gols
                                        </th>
                                        <td>{{ $data->gols }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">Tahun
                                            Anggaran
                                        </th>
                                        <td>{{ 'RKA ' . $data->tahun }}</td>
                                    </tr>
                                    @if ($data->id_vendor != '')
                                        <?php
                                        $eksekutor = \App\Models\Vendor::where('vendor_id', $data->id_vendor)->first();
                                        ?>
                                        <tr>
                                            <th colspan="2"
                                                style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                <h5 class="font-weight-bold mt-3">Detail Vendor</h5>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                Nama Vendor
                                            </th>
                                            <td>{{ $eksekutor->nama_perusahaan }}</td>
                                        </tr>
                                        <tr>
                                            <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                Alamat
                                            </th>
                                            <td>{{ $eksekutor->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                Telepon
                                            </th>
                                            <td>{{ $eksekutor->no_telp }}</td>
                                        </tr>
                                        <tr>
                                            <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                Email Perusahaan
                                            </th>
                                            <td>{{ $eksekutor->email }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active font-weight-bold text-uppercase" id="home-tab" data-toggle="tab"
                                    href="#spph" role="tab" aria-controls="spph" aria-selected="true">SPPH</a>
                            </li>
                            @if ($jumlahSPH > 0)
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold text-uppercase" id="profile-tab" data-toggle="tab"
                                        href="#sph" role="tab" aria-controls="sph" aria-selected="false">SPH</a>
                                </li>
                            @endif
                            @if ($SPHApproved > 0)
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold text-uppercase" id="contact-tab" data-toggle="tab"
                                        href="#bakn" role="tab" aria-controls="bakn" aria-selected="false">BAKN</a>
                                </li>
                                @if ($jumlahBAKN > 0)
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold text-uppercase" id="contact-tab"
                                            data-toggle="tab" href="#spk" role="tab" aria-controls="spk"
                                            aria-selected="false">SPK</a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                        <div class="tab-content mb-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="spph" role="tabpanel"
                                aria-labelledby="home-tab">
                                @if (in_array(session('user')->role, ['Admin']))
                                    @if ($data->id_vendor == '')
                                        <a href="javascript:void(0)"
                                            class="label theme-bg2 text-white font-weight-bold f-12" data-toggle="modal"
                                            data-target=".modal-spph">
                                            Create New
                                        </a>
                                        <br>
                                        <br>
                                    @endif
                                @endif
                                @if ($jumlahSPPH > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped m-b-0">
                                            <tbody>
                                                @foreach ($dataSPPH as $spph)
                                                    <?php
                                                    $namaVendor = \App\Models\Vendor::where('vendor_id', $spph->id_vendor)->first();
                                                    ?>
                                                    <tr>
                                                        <td width="200px" nowrap style="vertical-align: top">
                                                            <h6 class="mb-1 font-weight-bold">
                                                                <a target="_blank"
                                                                    href="/attachment/{{ $spph->file_spph }}">{{ strtoupper($spph->nomor) }}</a>
                                                            </h6>
                                                            <h6 class="mb-1">
                                                                {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($spph->tanggal))) }}
                                                            </h6>
                                                        </td>
                                                        <td width="200px" nowrap style="vertical-align: top">
                                                            <h6 class="mb-1 font-weight-bold">
                                                                {{ $namaVendor->nama_perusahaan }}</h6>
                                                            <p class="m-0">
                                                                <span>{{ date('d M Y H:i', strtotime($spph->created_date)) }}</span>
                                                            </p>
                                                        </td>
                                                        <td width="200px" style="vertical-align: top">
                                                            @if ($spph->status == 'DRAFT')
                                                                <span class="badge badge-secondary">DRAFT</span>
                                                            @elseif($spph->status == 'Submitted')
                                                                <span class="badge badge-warning f-12 text-dark">Waiting
                                                                    for response</span>
                                                            @elseif($spph->status == 'Accepted')
                                                                <span class="badge badge-success f-12">Responded</span>
                                                            @elseif($spph->status == 'Declined')
                                                                <span class="badge badge-danger f-12">Declined</span>
                                                            @endif
                                                            @if ($spph->catatan != '')
                                                                <br>
                                                                <span class="text-muted">{{ $spph->catatan }}</span>
                                                            @endif
                                                        </td>
                                                        <td width="200px" nowrap
                                                            style="vertical-align: top; text-align: right">
                                                            @if ($spph->status == 'DRAFT')
                                                                <a href="#!" data-id="{{ encrypt($spph->spph_id) }}"
                                                                    data-nama="{{ $namaVendor->nama_perusahaan }}"
                                                                    class="label bg-c-red text-white font-weight-bold f-12 deleteSPPH">Delete</a>
                                                                <a href="#!" data-id="{{ encrypt($spph->spph_id) }}"
                                                                    data-nama="{{ $namaVendor->nama_perusahaan }}"
                                                                    class="label theme-bg text-dark font-weight-bold f-12 submitSPPH">Submit</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-danger mb-0" role="alert">
                                        <b>Permintaan Penawaran Harga belum dibuat</b>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="sph" role="tabpanel" aria-labelledby="profile-tab">
                                @if ($jumlahSPH > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <tbody>
                                                @foreach ($dataSPH as $sph)
                                                    <?php
                                                    $namaVendor = \App\Models\Vendor::where('vendor_id', $sph->id_vendor)->first();
                                                    ?>
                                                    <tr>
                                                        <td width="200px" nowrap style="vertical-align: top">
                                                            <h6 class="mb-1 font-weight-bold">
                                                                <a target="_blank"
                                                                    href="/attachment/{{ $sph->file_sph }}">{{ strtoupper($sph->nomor) }}</a>
                                                            </h6>
                                                            <h6 class="mb-1">
                                                                {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($sph->tanggal))) }}
                                                            </h6>
                                                        </td>
                                                        <td width="400px" nowrap style="vertical-align: top">
                                                            <h6 class="mb-1 font-weight-bold">
                                                                {{ $namaVendor->nama_perusahaan }}</h6>
                                                            <p class="m-0">
                                                                <span>{{ date('d M Y H:i', strtotime($sph->created_date)) }}</span>
                                                            </p>
                                                        </td>
                                                        <td width="200px" style="vertical-align: top">
                                                            <span
                                                                class="font-weight-bold f-16 text-dark">{{ 'Rp' . number_format($sph->nilai_penawaran, 0, ',', '.') }}</span>
                                                            @if ($sph->nilai_penawaran > $data->nilai_perkiraan)
                                                                <i
                                                                    class="font-weight-bold feather icon-arrow-up text-c-red f-16 m-r-10"></i>
                                                            @else
                                                                <i
                                                                    class="font-weight-bold feather icon-arrow-down text-c-green f-16 m-r-10"></i>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-danger mb-0" role="alert">
                                        <b>Penawaran Harga belum disubmit oleh Vendor</b>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="bakn" role="tabpanel" aria-labelledby="contact-tab">
                                @if ($jumlahBAKN > 0)
                                    @foreach ($dataBAKN as $bakn)
                                        <?php
                                        $namaVendorBAKN = \App\Models\Vendor::where('vendor_id', $bakn->id_vendor)->first();
                                        ?>
                                        <table width="100%" class="mb-3">
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Nomor
                                                </th>
                                                <td>
                                                    <a target="_blank" class="font-weight-bold"
                                                        href="/attachment/{{ $bakn->file_bakn }}">{{ strtoupper($bakn->nomor) }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Tanggal
                                                </th>
                                                <td>
                                                    {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($bakn->tanggal))) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Kesepakatan Biaya
                                                </th>
                                                <td>
                                                    <span
                                                        class="font-weight-bold f-16 text-dark">{{ 'Rp' . number_format($bakn->nilai_kesepakatan, 0, ',', '.') }}</span>
                                                    @if ($bakn->nilai_kesepakatan > $data->nilai_perkiraan)
                                                        <i
                                                            class="font-weight-bold feather icon-arrow-up text-c-red f-16 m-r-10"></i>
                                                    @else
                                                        <i
                                                            class="font-weight-bold feather icon-arrow-down text-c-green f-16 m-r-10"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                @else
                                    @if (in_array(session('user')->role, ['Admin']))
                                        <a href="javascript:void(0)"
                                            class="label theme-bg2 text-white font-weight-bold f-12" data-toggle="modal"
                                            data-target=".modal-bakn">
                                            Create New
                                        </a>
                                        <br>
                                        <br>
                                    @endif
                                    <div class="alert alert-danger mb-0" role="alert">
                                        <b>Berita Acara Klarifikasi dan Negosiasi belum dibuat</b>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="spk" role="tabpanel" aria-labelledby="contact-tab">
                                @if ($jumlahSPK > 0)
                                    @foreach ($dataSPK as $spk)
                                        <?php
                                        $namaVendorSPK = \App\Models\Vendor::where('vendor_id', $bakn->id_vendor)->first();
                                        ?>
                                        <table width="100%" class="mb-3">
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Nomor
                                                </th>
                                                <td>
                                                    <a target="_blank" class="font-weight-bold"
                                                        href="/attachment/{{ $spk->file_spk }}">{{ strtoupper($spk->nomor) }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Tanggal
                                                </th>
                                                <td>
                                                    {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($spk->tanggal))) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Kesepakatan Biaya
                                                </th>
                                                <td>
                                                    <span
                                                        class="font-weight-bold f-16 text-dark">{{ 'Rp' . number_format($spk->nilai_kesepakatan, 0, ',', '.') }}</span>
                                                    @if ($spk->nilai_kesepakatan > $data->nilai_perkiraan)
                                                        <i
                                                            class="font-weight-bold feather icon-arrow-up text-c-red f-16 m-r-10"></i>
                                                    @else
                                                        <i
                                                            class="font-weight-bold feather icon-arrow-down text-c-green f-16 m-r-10"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Durasi
                                                </th>
                                                <td>
                                                    <b>{{ $spk->durasi . ' Hari' }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Tanggal Penyelesaian
                                                </th>
                                                <td>
                                                    {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($spk->due_date))) }}
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                @else
                                    @if (in_array(session('user')->role, ['Admin']))
                                        <a href="javascript:void(0)"
                                            class="label theme-bg2 text-white font-weight-bold f-12" data-toggle="modal"
                                            data-target=".modal-spk">
                                            Create New
                                        </a>
                                        <br>
                                        <br>
                                    @endif
                                    <div class="alert alert-danger mb-0" role="alert">
                                        <b>Surat Perintah Kerja belum dibuat</b>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($jumlahSPK > 0)
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="font-weight-bold">Payment Method</h5>
                                    <div class="card-header-right">
                                        @if ($jumlahPembayaran == 0)
                                            <a href="javascript:void(0)" class="btn font-weight-bold text-muted f-12 mr-0"
                                                data-toggle="modal" data-target=".modal-payment">
                                                <i class="feather icon-plus mr-1"></i>Create New
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-block p-3">
                                    @if ($jumlahPembayaran > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped m-b-0">
                                                <tbody>
                                                    @foreach ($dataPembayaran as $pembayaran)
                                                        <?php
                                                        $namaVendorPembayaran = \App\Models\Vendor::where('vendor_id', $pembayaran->id_vendor)->first();
                                                        ?>
                                                        <tr>
                                                            <td width="200px" nowrap style="vertical-align: top">
                                                                <h6 class="mb-1 font-weight-bold">
                                                                    {{ 'Termin Ke ' . $pembayaran->termin }}
                                                                </h6>
                                                                <h6 class="mb-1">{{ $pembayaran->persen . '%' }}</h6>
                                                            </td>
                                                            <td width="200px" nowrap style="vertical-align: top">
                                                                <span
                                                                    class="font-weight-bold f-16 text-dark">{{ 'Rp' . number_format($pembayaran->jumlah_pembayaran, 0, ',', '.') }}</span>
                                                            </td>
                                                            <td width="200px" style="vertical-align: top">
                                                                @if ($pembayaran->status == 'Open')
                                                                    <span class="badge badge-secondary">Open</span>
                                                                @elseif($pembayaran->status == 'Submitted')
                                                                    <span
                                                                        class="badge badge-warning f-12 text-dark">Waiting
                                                                        for response</span>
                                                                @elseif($pembayaran->status == 'Accepted')
                                                                    <span class="badge badge-success f-12">Responded</span>
                                                                @elseif($pembayaran->status == 'Declined')
                                                                    <span class="badge badge-danger f-12">Declined</span>
                                                                @endif
                                                                @if ($pembayaran->catatan != '')
                                                                    <br>
                                                                    <span
                                                                        class="text-muted">{{ $pembayaran->catatan }}</span>
                                                                @endif
                                                            </td>
                                                            <td width="200px" nowrap
                                                                style="vertical-align: top; text-align: right">
                                                                @if ($pembayaran->status == 'Open')
                                                                    <a href="#!"
                                                                        data-id="{{ encrypt($pembayaran->pembayaran_id) }}"
                                                                        data-nama="{{ $namaVendorPembayaran->nama_perusahaan }}"
                                                                        class="label bg-c-red text-white font-weight-bold f-12 deleteSPPH">Delete</a>
                                                                    <a href="#!"
                                                                        data-id="{{ encrypt($pembayaran->pembayaran_id) }}"
                                                                        data-nama="{{ $namaVendorPembayaran->nama_perusahaan }}"
                                                                        class="label theme-bg text-dark font-weight-bold f-12 submitSPPH">Submit</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-danger mb-0" role="alert">
                                            <b>Metode pembayaran belum dibuat</b>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="col-xl-4 col-lg-12">
                        @if (!empty($data->id_vendor))
                            <?php
                            $eksekutor = \App\Models\Vendor::where('vendor_id', $data->id_vendor)->first();
                            ?>
                            <div class="card table-card">
                                <div class="row-table">
                                    <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                        <i class="feather icon-award f-30"></i>
                                    </div>
                                    <div class="col text-center">
                                        <span class="d-block font-weight-bold m-b-10">PROJECT VENDOR</span>
                                        <h5 class="f-w-300 font-weight-bold">{{ $eksekutor->nama_perusahaan }}</h5>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (session('user')->role == 'Admin')
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0 font-weight-bold">
                                            <a href="#!" class="collapsed" data-toggle="collapse"
                                                data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo">Log Activity</a>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse show card-body p-3 scroll-log"
                                        aria-labelledby="headingTwo" data-parent="#accordionExample">
                                        @if ($jumlahLog > 0)
                                            @foreach ($dataLog as $log)
                                                <?php
                                                $updateBy = \App\Models\User::where('id_user', $log->update_by)->first();
                                                ?>
                                                <div class="media mb-2">
                                                    <div class="media-left mr-3">
                                                        <a href="#">
                                                            <img class="media-object img-radius comment-img"
                                                                src="{{ asset('template_vendor/assets/images/user.png') }}"
                                                                alt="User" width="40px">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <b class="text-dark font-weight-bold">{{ $updateBy->nama }}</b>
                                                        <br>
                                                        <h6 class="mt-0 mb-0">{{ $log->action }}</h6>
                                                        <p class="m-0">
                                                            <small>{{ date('d M Y H:i', strtotime($log->update_date)) }}</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-danger mb-0" role="alert">
                                                <b>Tidak ada log aktivitas yang tersimpan</b>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0 font-weight-bold">
                                            <a href="#!" data-toggle="collapse" data-target="#collapseOne"
                                                aria-expanded="true" aria-controls="collapseOne">Cost Story
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="card-body collapse p-3" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="col text-center">
                                            <span class="d-block font-weight-bold m-b-10">Estimation</span>
                                            <h3 class="f-w-300 font-weight-bold">
                                                {{ 'Rp' . number_format($data->nilai_perkiraan, 0, ',', '.') }}</h3>
                                            @if (!empty($data->nilai_penawaran))
                                                <i class="font-weight-bold feather icon-arrow-down text-c-green f-30"></i>
                                                <span class="d-block font-weight-bold mt-2 m-b-10">Offering</span>
                                                <h3 class="f-w-300 font-weight-bold">
                                                    {{ 'Rp' . number_format($data->nilai_penawaran, 0, ',', '.') }}</h3>
                                            @endif
                                            @if (!empty($data->nilai_kesepakatan))
                                                <?php
                                                $saving = round($data->nilai_perkiraan - $data->nilai_kesepakatan);
                                                ?>
                                                <i class="font-weight-bold feather icon-arrow-down text-c-green f-30"></i>
                                                <span class="d-block font-weight-bold mt-2 m-b-10">Deal</span>
                                                <h3 class="f-w-300 font-weight-bold">
                                                    {{ 'Rp' . number_format($data->nilai_kesepakatan, 0, ',', '.') }}</h3>
                                                <hr>
                                                <span class="d-block font-weight-bold mt-2 m-b-10">BUDGET SAVINGS</span>
                                                <h3 class="f-w-300 font-weight-bold" style="color: darkgreen">
                                                    {{ 'Rp' . number_format($saving, 0, ',', '.') }}</h3>
                                                <span
                                                    class="d-block font-weight-bold mt-2 m-b-10">{{ round((($data->nilai_perkiraan - $data->nilai_kesepakatan) / $data->nilai_perkiraan) * 100, 2) . '%' }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h5 class="mb-0 font-weight-bold">
                                            <a href="#!" class="collapsed" data-toggle="collapse"
                                                data-target="#collapseThree" aria-expanded="false"
                                                aria-controls="collapseThree">All Documents</a>
                                        </h5>
                                    </div>
                                    <div id="collapseThree" class="card-body p-3 scroll-log collapse"
                                        aria-labelledby="headingThree" data-parent="#accordionExample">
                                        @if ($jumlahLampiran > 0)
                                            @foreach ($dataLampiran as $lampiran)
                                                <?php
                                                $makerLampiran = \App\Models\User::where('id_user', $lampiran->upload_by)->first();
                                                ?>
                                                <div class="media mb-2">
                                                    <div class="media-left mr-3">
                                                        <a href="#">
                                                            @if ($lampiran->type == 'pdf')
                                                                <img src="{{ asset('template/assets/images/icon/pdf.png') }}"
                                                                    style="width:40px;">
                                                            @elseif($lampiran->type == 'xls' or $lampiran->type == 'xlsx' or $lampiran->type == 'csv')
                                                                <img src="{{ asset('template/assets/images/icon/excel.png') }}"
                                                                    style="width:40px;">
                                                            @elseif($lampiran->type == 'doc' or $lampiran->type == 'docx')
                                                                <img src="{{ asset('template/assets/images/icon/word.png') }}"
                                                                    style="width:40px;">
                                                            @elseif($lampiran->type == 'ppt')
                                                                <img src="{{ asset('template/assets/images/icon/powerpoint.png') }}"
                                                                    style="width:40px;">
                                                            @elseif($lampiran->type == 'jpg' or $lampiran->type == 'jpeg' or $lampiran->type == 'gif')
                                                                <img src="{{ asset('template/assets/images/icon/jpg.png') }}"
                                                                    style="width:40px;">
                                                            @elseif($lampiran->type == 'png')
                                                                <img src="{{ asset('template/assets/images/icon/png.png') }}"
                                                                    style="width:40px;">
                                                            @elseif($lampiran->type == 'svg')
                                                                <img src="{{ asset('template/assets/images/icon/svg.png') }}"
                                                                    style="width:40px;">
                                                            @else
                                                                <img src="{{ asset('template/assets/images/icon/pdf.png') }}"
                                                                    style="width:40px;">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        @if ($lampiran->nama_dokumen == 'KAK')
                                                            <b class="text-dark font-weight-bold">
                                                                <a target="_blank"
                                                                    href="/attachment/{{ $lampiran->file }}">{{ $lampiran->nama_dokumen }}</a>
                                                            </b>
                                                            <br>
                                                        @elseif($lampiran->nama_dokumen == 'SPPH')
                                                            <b class="text-dark font-weight-bold">
                                                                <a target="_blank"
                                                                    href="/attachment/{{ $lampiran->file }}">{{ $lampiran->nama_file }}</a>
                                                            </b>
                                                            <br>
                                                            {{ $lampiran->nomor }}
                                                            <br>
                                                        @elseif($lampiran->nama_dokumen == 'SPH')
                                                            <b class="text-dark font-weight-bold">
                                                                <a target="_blank"
                                                                    href="/attachment/{{ $lampiran->file }}">{{ $lampiran->nama_file }}</a>
                                                            </b>
                                                            <br>
                                                            {{ $lampiran->nomor }}
                                                            <br>
                                                        @else
                                                            <b class="text-dark font-weight-bold">
                                                                <a target="_blank"
                                                                    href="/attachment/{{ $lampiran->file }}">{{ $lampiran->nama_dokumen }}</a>
                                                            </b>
                                                            <br>
                                                            {{ $lampiran->nomor }}
                                                            <br>
                                                        @endif
                                                        <h6 class="mt-1 mb-0">{{ $makerLampiran->nama }}</h6>
                                                        <p class="m-0">
                                                            <small>{{ date('d M Y H:i', strtotime($lampiran->upload_date)) }}</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-danger mb-0" role="alert">
                                                <b>Tidak ada file atau dokumen yang tersimpan</b>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h5 class="font-weight-bold">Documents Verified</h5>
                                <div class="card-header-right">
                                    <a href="javascript:void(0)" class="btn font-weight-bold text-muted f-12 mr-0"
                                        data-toggle="modal" data-target=".modal-dokumen">
                                        <i class="fas fa-paperclip mr-1"></i>Attach File
                                    </a>
                                </div>
                            </div>
                            <div class="card-block p-3 scroll-log">
                                @if ($jumlahLampiranApproved > 0)
                                    @foreach ($dataLampiranApproved as $lampiranApproved)
                                        <?php
                                        $makerLampiranApproved = \App\Models\User::where('id_user', $lampiranApproved->upload_by)->first();
                                        ?>
                                        <div class="media mb-2">
                                            <div class="media-left mr-3">
                                                <a href="#">
                                                    @if ($lampiranApproved->type == 'pdf')
                                                        <img src="{{ asset('template/assets/images/icon/pdf.png') }}"
                                                            style="width:40px;">
                                                    @elseif($lampiranApproved->type == 'xls' or $lampiranApproved->type == 'xlsx' or $lampiranApproved->type == 'csv')
                                                        <img src="{{ asset('template/assets/images/icon/excel.png') }}"
                                                            style="width:40px;">
                                                    @elseif($lampiranApproved->type == 'doc' or $lampiranApproved->type == 'docx')
                                                        <img src="{{ asset('template/assets/images/icon/word.png') }}"
                                                            style="width:40px;">
                                                    @elseif($lampiranApproved->type == 'ppt')
                                                        <img src="{{ asset('template/assets/images/icon/powerpoint.png') }}"
                                                            style="width:40px;">
                                                    @elseif($lampiranApproved->type == 'jpg' or $lampiranApproved->type == 'jpeg' or $lampiranApproved->type == 'gif')
                                                        <img src="{{ asset('template/assets/images/icon/jpg.png') }}"
                                                            style="width:40px;">
                                                    @elseif($lampiranApproved->type == 'png')
                                                        <img src="{{ asset('template/assets/images/icon/png.png') }}"
                                                            style="width:40px;">
                                                    @elseif($lampiranApproved->type == 'svg')
                                                        <img src="{{ asset('template/assets/images/icon/svg.png') }}"
                                                            style="width:40px;">
                                                    @else
                                                        <img src="{{ asset('template/assets/images/icon/pdf.png') }}"
                                                            style="width:40px;">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                @if ($lampiranApproved->nama_dokumen == 'KAK')
                                                    <b class="text-dark font-weight-bold">
                                                        <a target="_blank"
                                                            href="/attachment/{{ $lampiranApproved->file }}">{{ $lampiranApproved->nama_dokumen }}</a>
                                                    </b>
                                                    <br>
                                                    {{ $makerLampiranApproved->nama }}
                                                    <br>
                                                @elseif($lampiranApproved->nama_dokumen == 'SPPH')
                                                    <b class="text-dark font-weight-bold">
                                                        <a target="_blank"
                                                            href="/attachment/{{ $lampiranApproved->file }}">{{ $lampiranApproved->nama_dokumen }}</a>
                                                    </b>
                                                    <br>
                                                    {{ $lampiranApproved->nomor }}
                                                    <br>
                                                @elseif($lampiranApproved->nama_dokumen == 'SPH')
                                                    <b class="text-dark font-weight-bold">
                                                        <a target="_blank"
                                                            href="/attachment/{{ $lampiranApproved->file }}">{{ $lampiranApproved->nama_dokumen }}</a>
                                                    </b>
                                                    <br>
                                                    {{ $lampiranApproved->nomor }}
                                                    <br>
                                                @else
                                                    <b class="text-dark font-weight-bold">
                                                        <a target="_blank"
                                                            href="/attachment/{{ $lampiranApproved->file }}">{{ $lampiranApproved->nama_dokumen }}</a>
                                                    </b>
                                                    <br>
                                                    {{ $lampiranApproved->nomor }}
                                                    <br>
                                                @endif
                                                <p class="m-0">
                                                    @if ($lampiranApproved->size > 1000000)
                                                        <small class="f-6">
                                                            {{ round($lampiranApproved->size / 1000000, 1) . ' Mb' }}
                                                        </small>
                                                    @else
                                                        <small class="f-6">
                                                            {{ round($lampiranApproved->size / 1000, 1) . ' Kb' }}
                                                        </small>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-danger mb-0" role="alert">
                                        <b>Tidak ada file atau dokumen yang tersimpan</b>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('PekerjaanController@storeSPPH') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-spph" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLiveLabel">Create SPPH</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="hidden" name="pekerjaanID" id="pekerjaanID"
                            value="{{ encrypt($data->pekerjaan_id) }}">
                        <input class="form-control" type="hidden" name="namaDokumen" value="SPPH">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nomor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-uppercase" name="nomor">
                                @if ($errors->has('nomor'))
                                    <small class="text-danger">Nomor dokumen harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="feather icon-calendar"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="date-start" name="tanggal"
                                        value="{{ old('tanggal') }}">
                                </div>
                                @if ($errors->has('tanggal'))
                                    <small class="text-danger">Tanggal harus diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Penerima <span class="text-danger">*</span></label>
                            <select class="form-control" name="namaVendor">
                                <option value=""></option>
                                @foreach ($dataVendor as $vendor)
                                    <option value="{{ $vendor->vendor_id }}">{{ $vendor->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('nomor'))
                                <small class="text-danger">Penerima harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Lampiran <span class="text-danger">*</span></label>
                            <br>
                            <input type="file" name="lampiran" value="{{ old('lampiran') }}"
                                accept="application/pdf">
                            @if ($errors->has('lampiran'))
                                <br>
                                <small class="text-danger">Lampiran harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success font-weight-bold text-dark">Save Data</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('PekerjaanController@storeBAKN') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-bakn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLiveLabel">Create BAKN</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="hidden" name="pekerjaanID" id="pekerjaanID"
                            value="{{ encrypt($data->pekerjaan_id) }}">
                        <input class="form-control" type="hidden" name="namaDokumen" value="BAKN">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nomor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-uppercase" name="nomor">
                                @if ($errors->has('nomor'))
                                    <small class="text-danger">Nomor dokumen harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="feather icon-calendar"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="date" name="tanggal"
                                        value="{{ old('tanggal') }}">
                                </div>
                                @if ($errors->has('tanggal'))
                                    <small class="text-danger">Tanggal harus diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Kesepakatan Biaya (Rp) <span class="text-danger">*</span></label>
                                <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                    name="nilaiKesepakatan" id="nilaiKesepakatan"
                                    value="{{ old('nilaiKesepakatan') }}">
                                @if ($errors->has('nilaiKesepakatan'))
                                    <small class="text-danger">Kesepakatan biaya harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Lampiran BAKN <span class="text-danger">*</span></label>
                                <br>
                                <input type="file" name="lampiran" value="{{ old('lampiran') }}"
                                    accept="application/pdf">
                                @if ($errors->has('lampiran'))
                                    <br>
                                    <small class="text-danger">Lampiran BAKN harus diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success font-weight-bold text-dark">Save Data</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('PekerjaanController@storeSPK') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-spk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLiveLabel">CREATE SPK</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="hidden" name="pekerjaanID" id="pekerjaanID"
                            value="{{ encrypt($data->pekerjaan_id) }}">
                        <input class="form-control" type="hidden" name="namaDokumen" value="SPK">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nomor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-uppercase" name="nomor">
                                @if ($errors->has('nomor'))
                                    <small class="text-danger">Nomor dokumen harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="feather icon-calendar"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="date2" name="tanggal"
                                        value="{{ old('tanggal') }}">
                                </div>
                                @if ($errors->has('tanggal'))
                                    <small class="text-danger">Tanggal harus diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Durasi Pekerjaan (Hari) <span class="text-danger">*</span></label>
                                <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                    name="durasi" value="{{ old('durasi') }}">
                                @if ($errors->has('durasi'))
                                    <small class="text-danger">Durasi pekerjaan biaya harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Lampiran SPK <span class="text-danger">*</span></label>
                                <br>
                                <input type="file" name="lampiran" value="{{ old('lampiran') }}"
                                    accept="application/pdf">
                                @if ($errors->has('lampiran'))
                                    <br>
                                    <small class="text-danger">Lampiran BAKN harus diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success font-weight-bold text-dark">Save Data</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('PekerjaanController@approveSPH') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-selectVendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLiveLabel">Select Vendor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="hidden" name="pekerjaanID" id="pekerjaanID"
                            value="{{ encrypt($data->pekerjaan_id) }}">
                        <div class="form-group">
                            <label>Nama Vendor <span class="text-danger">*</span></label>
                            <select class="form-control" name="namaVendor">
                                <option value=""></option>
                                @foreach ($dataSPH as $p)
                                    <?php
                                    $namaVendor = \App\Models\Vendor::where('vendor_id', $p->id_vendor)->first();
                                    ?>
                                    <option value="{{ $p->id_vendor }}">{{ $namaVendor->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('nomor'))
                                <small class="text-danger">Pilihan vendor harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success font-weight-bold text-dark">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('PekerjaanController@storeLampiran') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-dokumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLiveLabel">Attach Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="hidden" name="pekerjaanID" id="pekerjaanID"
                            value="{{ encrypt($data->pekerjaan_id) }}">
                        <div class="form-group">
                            <label>Nama Dokumen <span class="text-danger">*</span></label>
                            <select class="form-control" name="namaDokumen">
                                <option>{{ old('namaDokumen') }}</option>
                                @foreach ($dokumenMandatori as $dm)
                                    <option>{{ $dm->nama_dokumen }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('namaDokumen'))
                                <small class="text-danger">Nama dokumen harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Lampiran <span class="text-danger">*</span></label>
                            <br>
                            <input type="file" name="lampiran" value="{{ old('lampiran') }}"
                                accept="application/pdf">
                            @if ($errors->has('lampiran'))
                                <br>
                                <small class="text-danger">Lampiran harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success font-weight-bold text-dark">Save Data</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('PekerjaanController@storePaymentMethod') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLiveLabel">Create Payment Method</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="hidden" name="pekerjaanID"
                            value="{{ encrypt($data->pekerjaan_id) }}">
                        <div class="form-group">
                            <label>Jumlah Termin <span class="text-danger">*</span></label>
                            <select onchange="bukaTermin()" id="selectTermin" class="form-control bukaTermin"
                                name="termin">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            @if ($errors->has('termin'))
                                <small class="text-danger">Termin pembayaran harus diisi</small>
                            @endif
                        </div>
                        <div id="persentase" class="form-group persentase">
                            <label>Persentase (%) <span class="text-danger">*</span></label>
                            <input maxlength="3" onkeypress="return hanyaAngka(event)" type="text"
                                class="form-control termin1" value="100" name="termin1" id="termin1"
                                placeholder="Termin 1" style="margin-bottom: 5px;">
                            <input maxlength="2" onkeypress="return hanyaAngka(event)" type="text"
                                class="form-control termin2" name="termin2" id="termin2" placeholder="Termin 2"
                                style="margin-bottom: 5px; display: none">
                            <input maxlength="2" onkeypress="return hanyaAngka(event)" type="text"
                                class="form-control termin3" name="termin3" id="termin3" placeholder="Termin 3"
                                style="margin-bottom: 5px; display: none">
                            <input maxlength="2" onkeypress="return hanyaAngka(event)" type="text"
                                class="form-control termin4" name="termin4" id="termin4" placeholder="Termin 4"
                                style="display: none">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success font-weight-bold text-dark">Save Data</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('PekerjaanController@updateStatus') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLiveLabel">Update Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="hidden" name="pekerjaanID" id="pekerjaanID"
                            value="{{ encrypt($data->pekerjaan_id) }}">
                        <div class="form-group">
                            <label>Project Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status">
                                <option>{{ old('status') }}</option>
                                <option>Procurement</option>
                                <option>In Progress</option>
                                <option>Pending</option>
                                <option>Finish</option>
                            </select>
                            @if ($errors->has('status'))
                                <small class="text-danger">Status pekerjaan harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success font-weight-bold text-dark">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $(document).on('click', '.reject', function(e) {
            document.getElementById("dokumenIDKTP").value = $(this).attr('data-id');
        });
    </script>

    <script>
        $(document).on('click', '.submitRevisi', function(e) {
            document.getElementById("dokumenIDKTP2").value = $(this).attr('data-id');
        });
    </script>

    <script>
        var nilaiKesepakatan = document.getElementById('nilaiKesepakatan');
        nilaiKesepakatan.addEventListener('keyup', function(e) {
            nilaiKesepakatan.value = formatRupiah(this.value);
        });
    </script>

    <script>
        $('.deleteSPPH').click(function() {
            var data_id = $(this).attr('data-id');
            var data_nama = $(this).attr('data-nama');
            swal({
                    title: "Are You Sure?",
                    text: "Akan menghapus Permintaan Penawaran Harga dari " + data_nama + "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/Pekerjaan/deleteSPPH/" + data_id + "";
                    }
                });

        });
    </script>

    <script>
        $('.deleteBAKN').click(function() {
            var data_id = $(this).attr('data-id');
            var data_nama = $(this).attr('data-nama');
            swal({
                    title: "Are You Sure?",
                    text: "Akan menghapus Berita Acara Klarifikasi dan Negosiasi untuk " + data_nama + "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/Pekerjaan/deleteBAKN/" + data_id + "";
                    }
                });

        });
    </script>

    <script>
        $('.submitSPPH').click(function() {
            var data_id = $(this).attr('data-id');
            var data_nama = $(this).attr('data-nama');
            swal({
                    title: "Are You Sure?",
                    text: "Anda akan submit Permintaan Penawaran Harga ke " + data_nama + "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: false,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/Pekerjaan/submitSPPH/" + data_id + "";
                    }
                });

        });
    </script>

    <script>
        $('.submitBAKN').click(function() {
            var data_id = $(this).attr('data-id');
            var data_nama = $(this).attr('data-nama');
            swal({
                    title: "Are You Sure?",
                    text: "Anda akan submit Berita Acara Klarifikasi dan Negosiasi ke " + data_nama + "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: false,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/Pekerjaan/submitBAKN/" + data_id + "";
                    }
                });

        });
    </script>

    <script>
        $('.submitSPK').click(function() {
            var data_id = $(this).attr('data-id');
            var data_nama = $(this).attr('data-nama');
            swal({
                    title: "Are You Sure?",
                    text: "Anda akan submit Surat Perintah Kerja ke " + data_nama + "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: false,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/Pekerjaan/submitSPK/" + data_id + "";
                    }
                });

        });
    </script>

    <script>
        $('.resetExecutor').click(function() {
            var data_id = $(this).attr('data-id');
            swal({
                    title: "Are You Sure?",
                    text: "Anda akan mereset pelaksana proyek ini",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/Pekerjaan/resetExecutor/" + data_id + "";
                    }
                });

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
        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
