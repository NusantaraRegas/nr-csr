@extends('layout.master')
@section('title', 'PGN SHARE | List Payment Request')
@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>
    <div class="container-fluid model-huruf-family">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">LIST PAYMENT REQUEST</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">List Payment Request</li>
                    </ol>
                    <div class="btn-group">
                        <a href="#!" class="btn btn-info d-lg-block ml-3" data-target=".modalFilterTanggal"
                            data-toggle="modal"><i class="fa fa-filter mr-2"></i>Filter</a>
                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split active"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item"
                                href="{{ route('listPaymentRequestToday', ['tanggal1' => $tanggal, 'tanggal2' => $tanggal]) }}">Today</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterMonthly"
                                data-toggle="modal">Monthly</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterAnnual"
                                data-toggle="modal">Annual</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterTanggal"
                                data-toggle="modal">Custom Range</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('listPaymentRequest') }}">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h4 class="card-title model-huruf-family mb-1">TOTAL REALISASI</h4>
                                <h3 class="card-subtitle text-dark font-weight-bold">
                                    {{ 'Rp' . number_format($total, 0, ',', '.') }}
                                    <span class="model-huruf-family ml-2">({{ $persen . '%' }})</span>
                                </h3>
                            </div>
                            <div class="ml-auto">
                                @if ($status == 'All Data')
                                    <a href="{{ route('exportPaymentRequest', $tahun) }}"
                                        class="btn active btn-sm btn-secondary"><i class="fa fa-file-text-o mr-2"></i>Export
                                        Excel</a>
                                    <a href="{{ route('printPaymentRequest', $tahun) }}" target="_blank"
                                        class="btn active btn-sm btn-secondary"><i class="fa fa-print mr-2"></i>Print</a>
                                @elseif($status == 'Monthly')
                                    <a href="{{ route('exportPaymentRequestMonthly', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                                        class="btn active btn-sm btn-secondary"><i class="fa fa-file-text-o mr-2"></i>Export
                                        Excel</a>
                                    <a href="{{ route('printPaymentRequestMonthly', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                                        target="_blank" class="btn active btn-sm btn-secondary"><i
                                            class="fa fa-print mr-2"></i>Print</a>
                                @elseif($status == 'Periode')
                                    <a href="{{ route('exportPaymentRequestPeriode', ['tanggal1' => $tanggal1, 'tanggal2' => $tanggal2]) }}"
                                        class="btn active btn-sm btn-secondary"><i class="fa fa-file-text-o mr-2"></i>Export
                                        Excel</a>
                                    <a href="{{ route('printPaymentRequestPeriode', ['tanggal1' => $tanggal1, 'tanggal2' => $tanggal2]) }}"
                                        target="_blank" class="btn active btn-sm btn-secondary"><i
                                            class="fa fa-print mr-2"></i>Print</a>
                                @elseif($status == 'Provinsi')
                                    <a href="{{ route('exportPaymentRequestProvinsi', ['tahun' => $tahun, 'provinsi' => $provinsi]) }}"
                                        class="btn active btn-sm btn-secondary"><i class="fa fa-file-text-o mr-2"></i>Export
                                        Excel</a>
                                    <a href="{{ route('printPaymentRequestProvinsi', ['tahun' => $tahun, 'provinsi' => $provinsi]) }}"
                                        target="_blank" class="btn active btn-sm btn-secondary"><i
                                            class="fa fa-print mr-2"></i>Print</a>
                                @elseif($status == 'Kabupaten')
                                    <a href="{{ route('exportPaymentRequestKabupaten', ['tahun' => $tahun, 'provinsi' => $provinsi, 'kabupaten' => $kabupaten]) }}"
                                        class="btn active btn-sm btn-secondary"><i class="fa fa-file-text-o mr-2"></i>Export
                                        Excel</a>
                                    <a href="{{ route('printPaymentRequestKabupaten', ['tahun' => $tahun, 'provinsi' => $provinsi, 'kabupaten' => $kabupaten]) }}"
                                        target="_blank" class="btn active btn-sm btn-secondary"><i
                                            class="fa fa-print mr-2"></i>Print</a>
                                @elseif($status == 'Proker')
                                    <a href="{{ route('exportPaymentRequestProker', ['prokerID' => $prokerID]) }}"
                                        class="btn active btn-sm btn-secondary"><i class="fa fa-file-text-o mr-2"></i>Export
                                        Excel</a>
                                    <a href="#!" class="btn active btn-sm btn-secondary"><i
                                            class="fa fa-print mr-2"></i>Print</a>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="example5 table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center" width="50px">Actions</th>
                                        <th style="text-align: center" width="100px">Tanggal</th>
                                        <th style="text-align: center" width="100px">PR ID</th>
                                        <th style="text-align: center" width="100px" nowrap>Poker ID</th>
                                        <th style="text-align: center" width="100px">Status</th>
                                        <th style="text-align: center" width="150px">Type Pembayaran</th>
                                        <th style="text-align: center" width="600px">Deskripsi</th>
                                        <th style="text-align: center" width="200px">Jumlah</th>
                                        <th style="text-align: center" width="200px">Pengurangan</th>
                                        <th style="text-align: center" width="200px">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataPayment as $data)
                                        <tr>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"><i
                                                            class="fa fa-gear font-18 text-info"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" target="_blank"
                                                            href="{{ route('logApproval', $data['id']) }}"><i
                                                                class="fa fa-calendar mr-2"></i>Log Approval</a>
                                                        @if (session('user')->role == 'Admin' or
                                                                session('user')->role == 'Finance' or
                                                                session('user')->role == 'Budget' or
                                                                session('user')->role == 'Payment')
                                                            {{--                                                        <a class="dropdown-item" --}}
                                                            {{--                                                           href="{{ route('viewPaymentRequest', $data['id']) }}">Next --}}
                                                            {{--                                                            Update</a> --}}
                                                            <a class="dropdown-item edit" href="javascript:void (0)"
                                                                data-id="{{ $data['id'] }}"
                                                                data-provinsi="{{ $data['attribute3'] }}"
                                                                data-kabupaten="{{ $data['attribute4'] }}"
                                                                data-target=".modal-edit" data-toggle="modal"><i
                                                                    class="fa fa-pencil mr-2"></i>Update
                                                                Attribute</a>
                                                            @if ($data['status'] == 'DRAFT' or $data['status'] == 'REJECTED')
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item delete" id="{{ $data['id'] }}"
                                                                    href="javascript:void(0)"><i
                                                                        class="fa fa-trash mr-2"></i>Delete</a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center" nowrap>
                                                {{ date('d-m-Y', strtotime($data['created_at'])) }}<br>
                                                <span
                                                    class="text-muted">{{ date('H:i:s', strtotime($data['created_at'])) }}</span>
                                            </td>
                                            <td class="text-center">
                                                {{ $data['id'] }}
                                            </td>
                                            <td class="text-center">
                                                @if (!empty($data['budget_name']))
                                                    <?php
                                                    $proker = \App\Models\Proker::where('id_proker', $data['budget_name'])->first();
                                                    ?>
                                                    <span style="cursor: pointer" class="font-weight-bold"
                                                        data-toggle="tooltip" data-placement="right" title=""
                                                        data-original-title="{{ $proker->proker }}">{{ '#' . $data['budget_name'] }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($data['status'] == 'DRAFT')
                                                    <span class="badge text-dark"
                                                        style="background-color: #FFA900">{{ $data['status'] }}</span>
                                                @elseif($data['status'] == 'IN PROGRESS')
                                                    <span class="badge text-white"
                                                        style="background-color: #1dc4e9">{{ $data['status'] }}</span>
                                                @elseif($data['status'] == 'PAID')
                                                    <span class="badge text-white"
                                                        style="background-color: #1de9b6">{{ $data['status'] }}</span>
                                                @elseif($data['status'] == 'RELEASED')
                                                    <span class="badge text-white"
                                                        style="background-color: #B23CFD">{{ $data['status'] }}</span>
                                                @elseif($data['status'] == 'REJECTED')
                                                    <span class="badge text-white"
                                                        style="background-color: #f44236">{{ $data['status'] }}</span>
                                                @elseif($data['status'] == 'READY TO RELEASE')
                                                    <span class="badge text-white"
                                                        style="background-color: #00B74A">{{ $data['status'] }}</span>
                                                @else
                                                    <span class="badge badge-info">{{ $data['status'] }}</span>
                                                @endif
                                            </td>
                                            <td nowrap>
                                                {{ $data['payment_type'] }}
                                                @if ($data['attribute1'] == 'Proposal')
                                                    <br>
                                                    <span class="text-muted">Realisasi Proposal</span>
                                                @else
                                                    <br>
                                                    <span class="text-muted">{{ $data['attribute1'] }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="font-weight-bold"
                                                    style="color: #f44236">{{ $data['invoice_num'] }}</span>
                                                <br>
                                                <span style="text-align: justify">{{ $data['description_detail'] }}</span>
                                            </td>
                                            <td class="text-right" nowrap>
                                                {{ number_format($data['invoice_amount'], 0, ',', '.') }}</td>
                                            <td class="text-right" nowrap>
                                                @if ($data['invoice_refund'] > 0)
                                                    {{ number_format($data['invoice_refund'], 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-right" nowrap>
                                                {{ number_format($data['invoice_amount_paid'], 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('APIController@postPaymentRequestAnnual') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterAnnual" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i
                                class="fa fa-filter mr-2"></i>Annual
                            Report</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <select class="form-control" name="tahun">
                                    <option value="" disabled selected>Pilih Tahun</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                </select>
                                @if ($errors->has('tahun'))
                                    <small class="text-danger">Tahun harus diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input openWilayah" onchange="openWilayah()"
                                id="checkBookWilayah" name="checkBookWilayah" style="cursor: pointer">
                            <label class="custom-control-label" for="checkBookWilayah"
                                style="cursor: pointer">Wilayah</label>
                        </div>
                        <div class="wilayah" style="display: none">
                            <div class="form-group mb-0">
                                <label>Provinsi <span class="text-danger">*</span></label>
                                <select class="form-control mb-2" name="provinsi" id="provinsi2">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach ($dataProvinsi as $provinsi)
                                        <option value="{{ ucwords($provinsi->provinsi) }}">
                                            {{ ucwords($provinsi->provinsi) }}</option>
                                    @endforeach
                                </select>
                                <select class="form-control" name="kabupaten" id="kabupaten2">
                                </select>
                                @if ($errors->has('provinsi'))
                                    <small class="text-danger mt-0">Wilayah harus
                                        diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect text-left"><i
                                class="fa fa-search mr-2"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('APIController@postRealisasiAllMonthly') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterMonthly" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i
                                class="fa fa-filter mr-2"></i>Monthly
                            Report</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group mb-0 col-md-8">
                                <label>Bulan <span class="text-danger">*</span></label>
                                <select class="form-control" name="bulan">
                                    <option value="" disabled selected>Pilih Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                @if ($errors->has('bulan'))
                                    <small class="text-danger mt-0">Bulan harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group mb-0 col-md-4">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <select class="form-control" name="tahun">
                                    <option value="" disabled selected>Pilih Tahun</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                </select>
                                @if ($errors->has('tahun'))
                                    <small class="text-danger mt-0">Tahun harus diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect text-left"><i
                                class="fa fa-search mr-2"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('APIController@listPaymentRequestPeriode') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterTanggal" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i
                                class="fa fa-filter mr-2"></i>Custom
                            Range</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row mb-0">
                            <div class="form-group col-md-6">
                                <label>Start <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="date-start" class="form-control" onchange="ubahTanggal()"
                                        name="tanggal1" value="{{ old('tanggal1') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                @if ($errors->has('tanggal1'))
                                    <small class="text-danger">Periode awal harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>End <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="date-end" class="form-control" name="tanggal2"
                                        value="{{ old('tanggal2') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                @if ($errors->has('tanggal1'))
                                    <small class="text-danger">Periode awal harus diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect text-left"><i
                                class="fa fa-search mr-2"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('APIController@updatePaymentRequestPopayV4') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family">UPDATE ATTRIBUTE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="paymentID" id="paymentID" readonly>
                        <input type="hidden" class="form-control" name="prokerID" id="prokerID" readonly>
                        <button type="button" class="btn btn-sm btn-secondary active" data-target=".modal-proker"
                            data-toggle="modal"><i class="fa fa-search mr-2"></i>Cari Program Kerja
                        </button>
                        <hr>
                        <div class="form-group mt-4">
                            <label>Program Kerja</label>
                            <textarea rows="2" class="form-control bg-white text-dark" name="proker" id="proker" readonly>Otomatis By System</textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Ketegori</label>
                                <select class="form-control" onchange="bukaWilayah()" id="kategori" name="kategori">
                                    <option value="Proposal">Realisasi Proposal</option>
                                    <option value="Operasional">Operasional</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 prioritas">
                                <label>Prioritas</label>
                                <input type="text" class="form-control bg-white text-dark" id="prioritas"
                                    name="prioritas" placeholder="Otomatis By System" readonly>
                            </div>
                        </div>
                        <div class="wilayah">
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
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Provinsi</label>
                                    <select class="form-control" name="provinsi" id="provinsi">
                                        <option></option>
                                        @foreach ($dataProvinsi as $provinsi)
                                            <option>{{ ucwords($provinsi->provinsi) }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('provinsi'))
                                        <small class="text-danger">Provinsi harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kota/Kabupaten</label>
                                    <select class="form-control" name="kabupaten" id="kabupaten">
                                        <option></option>
                                        @foreach ($dataKabupaten as $kabupaten)
                                            <option>{{ ucwords($kabupaten->city_name) }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('kabupaten'))
                                        <small class="text-danger">Kota/Kabupaten harus diisi</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
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
                                    <th width="10px" style="text-align:center;" nowrap>Proker ID</th>
                                    <th class="text-center" width="400px">Program Kerja</th>
                                    <th class="text-center" width="300px">SDGs</th>
                                    <th class="text-center" width="50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataProker as $proker)
                                    <tr>
                                        <td style="text-align:center;">{{ '#' . $proker->id_proker }}</td>
                                        <td>
                                            <span class="font-weight-bold">{{ $proker->proker }}</span>
                                            @if ($proker->prioritas != '')
                                                <br>
                                                <span class="text-muted">{{ $proker->prioritas }}</span>
                                            @else
                                                <br>
                                                <span class="text-muted">Sosial/Ekonomi</span>
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
        $(document).on('click', '.edit', function(e) {
            document.getElementById("paymentID").value = $(this).attr('data-id');
            document.getElementById("provinsi").value = $(this).attr('data-provinsi');
            document.getElementById("kabupaten").value = $(this).attr('data-kabupaten');
        });
    </script>

    <script>
        $(document).on('click', '.pilih', function(e) {
            document.getElementById("prokerID").value = $(this).attr('prokerID');
            document.getElementById("proker").value = $(this).attr('proker');
            document.getElementById("prioritas").value = $(this).attr('prioritas');
            document.getElementById("pilar").value = $(this).attr('pilar');
            document.getElementById("gols").value = $(this).attr('gols');
            $('.modal-proker').modal('hide');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                var provinsi_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupaten/" + provinsi_id + "",
                    success: function(response) {
                        $('#kabupaten').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        function openWilayah() {
            if ($('.openWilayah').is(":checked")) {
                $(".wilayah").show();
            } else {
                $(".wilayah").hide();
            }
        }

        function openPilar() {
            if ($('.openPilar').is(":checked")) {
                $(".pilar").show();
            } else {
                $(".pilar").hide();
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#provinsi2').change(function() {
                var provinsi_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupatenPencarian/" + provinsi_id + "",
                    success: function(response) {
                        $('#kabupaten2').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        function bukaWilayah() {
            var x = document.getElementById("kategori").value;
            if (x == "Proposal") {
                $(".wilayah").show();
                $(".prioritas").show();
            }

            if (x == "Operasional") {
                $(".wilayah").hide();
                $(".prioritas").hide();
            }
        }
    </script>

    <script>
        function ubahTanggal() {
            document.getElementById("date-end").value = '';
        }
    </script>

    <script>
        $('.delete').click(function() {
            var id = $(this).attr('id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus Payment Request ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "/exportPopay/deletePaymentRequest/" + id + "";
                });
        });
    </script>

    <script>
        @if (count($errors) > 0)
            toastr.error('Lengkapi parameter pencarian data anda', 'Failed', {
                closeButton: true
            });
        @endif
    </script>
@stop
