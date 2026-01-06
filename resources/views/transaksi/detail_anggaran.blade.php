@extends('layout.master')
@section('title', 'PGN SHARE | Monitoring Budget')

@section('content')
    <?php
    $lastYear = $tahun - 1;

    $jumlahAnggaran = \App\Models\Anggaran::where('tahun', $lastYear)->count();
    $budgetLastYear = \App\Models\Anggaran::where('tahun', $lastYear)->first();

    $totalRealisasi = $realisasi + $progress;
    $sisa = $anggaran - $totalRealisasi;

    if ($jumlahAnggaran > 0) {
        $budget = $budgetLastYear;
    } else {
        $budget = 0;
    }
    ?>

    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">
                    MONITORING REALISASI ANGGARAN TAHUN {{ $tahun }}
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Budget Control</li>
                        <li class="breadcrumb-item active">Monitoring</li>
                    </ol>
                    <div class="btn-group">
                        <a href="#!" class="btn btn-info d-lg-block ml-3" data-target=".modalFilterAnnual"
                           data-toggle="modal"><i class="fa fa-filter mr-2"></i>Budget Year</a>
                        <button type="button"
                                class="btn btn-info dropdown-toggle dropdown-toggle-split active"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#!" data-target=".modalFilterAnnual"
                               data-toggle="modal">Annual Report</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterTanggal"
                               data-toggle="modal">Custom Range</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('monitoringBudget') }}">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title model-huruf-family mb-5">ANGGARAN</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div class="ml-auto">
                                    <h3 class="counter">
                                        <b class="font-weight-bold float-right" style="margin-top: 10px"><sup><i
                                                        class="{{ $anggaran > $budget ? 'ti-arrow-up text-success' : 'ti-arrow-down text-danger' }}"></i></sup> {{ "Rp".number_format($anggaran,0,',','.') }}
                                        </b>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title model-huruf-family mb-4">REALISASI</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <span class="pie" data-peity='{ "fill": ["#1de9b6", "#f2f2f2"]}'>{{ round($totalRealisasi / $anggaran * 100, 2) }},{{ 100 - round($totalRealisasi / $anggaran * 100, 2) }}</span>
                                    <br>
                                    <small class="text-muted">Status
                                        : {{ round($totalRealisasi / $anggaran * 100, 2)."%" }}</small>
                                </div>
                                <div class="ml-auto">
                                    @if($totalRealisasi > 0)
                                        <h3 class="counter">
                                            <b class="font-weight-bold">{{ "Rp".number_format($totalRealisasi,0,',','.') }}</b>
                                        </h3>
                                    @else
                                        <h3 class="counter">
                                            <b class="font-weight-bold">-</b>
                                        </h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <table class="table-striped mt-3" width="100%">
                                <tbody>
                                <tr>
                                    <td width="300px" style="padding: 5px">Progress</td>
                                    <td class="text-right" width="100px"
                                        style="padding: 5px">{{ round($progress / $anggaran * 100, 2)."%" }}</td>
                                    <td width="150px"
                                        style="text-align: right; padding: 5px">{{ number_format($progress,0,',','.') }}</td>
                                </tr>
                                <tr>
                                    <td width="300px" style="padding: 5px">Paid</td>
                                    <td class="text-right" width="100px"
                                        style="padding: 5px">{{ round($realisasi / $anggaran * 100, 2)."%" }}</td>
                                    <td width="150px"
                                        style="text-align: right; padding: 5px">{{ number_format($realisasi,0,',','.') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title model-huruf-family mb-4">SISA ANGGARAN</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <span class="pie" data-peity='{ "fill": ["#f44236", "#f2f2f2"]}'>{{ round($sisa / $anggaran * 100, 2) }},{{ 100 - round($sisa / $anggaran * 100, 2) }}</span>
                                    <br>
                                    <small class="text-muted">Status
                                        : {{ round($sisa / $anggaran * 100, 2)."%" }}</small>
                                </div>
                                <div class="ml-auto">
                                    @if($totalRealisasi > 0)
                                        <h3 class="counter">
                                            <span class="font-weight-bold">{{ "Rp".number_format($sisa,0,',','.') }}</span>
                                        </h3>
                                    @else
                                        <h3 class="counter">
                                            <span class="font-weight-bold">{{ "Rp".number_format($anggaran,0,',','.') }}</span>
                                        </h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="card-title model-huruf-family">PRIORITAS PROGRAM KERJA</h4>
                                <h6 class="card-subtitle model-huruf-family">Achievement Target : <span
                                            style="color: red">{{ "Rp".number_format((60/100)*$anggaran ,0,',','.') }}</span>
                                    - 60%</h6>
                            </div>
                            <div class="col-4 align-self-center display-6 text-right">
                                <h3 class="font-weight-bold">
                                    {{ round($persenPrioritas, 2)."%" }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="containerPrioritas" style="width: 100%; height: 300px;"></div>
                        <div class="text-center mt-2">
                            <button class="btn btn-secondary btn-sm" id="plain">Plain</button>
                            <button class="btn btn-secondary btn-sm" id="inverted">Inverted</button>
                        </div>
                    </div>
                    <table class="table-striped" width="100%">
                        <tbody>
                        @foreach($dataPrioritas as $dp)
                            <tr>
                                <td width="300px" style="padding: 5px 5px 5px 10px" class="font-weight-bold">
                                    {{ $dp['prioritas'] }}
                                </td>
                                <td width="150px"
                                    style="text-align: right; padding: 5px 10px 5px 5px">{{ number_format($dp['total'],0,',','.') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td width="300px" style="padding: 5px 5px 5px 10px; color: #f44236"
                                class="font-weight-bold">
                                TOTAL
                            </td>
                            <td width="150px" class="font-weight-bold"
                                style="text-align: right; padding: 5px 10px 5px 5px; color: #f44236">{{ number_format($totalPrioritas,0,',','.') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div id="containerPilar" style="width: 100%; height: 300px;"></div>
                    </div>
                    <table class="table-striped" width="100%">
                        <tbody>
                        @foreach($dataTPB as $dtpb)
                            <tr>
                                <td width="300px" style="padding: 5px 5px 5px 10px" class="font-weight-bold">
                                    {{ $dtpb['tpb'] }}
                                </td>
                                <td width="150px"
                                    style="text-align: right; padding: 5px 10px 5px 5px">{{ number_format($dtpb['total'],0,',','.') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="containerMonthly"></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family">REALISASI TRIWULAN</h4>
                        <h6 class="card-subtitle mb-5 model-huruf-family">Source: popay.pgn.co.id</h6>
                        <div class="table-responsive">
                            <table class="table-striped table-bordered" width="100%">
                                <?php
                                $triwulan1 = $dataRealisasiBulan['januari'] + $dataRealisasiBulan['februari'] + $dataRealisasiBulan['maret'];
                                $triwulan2 = $dataRealisasiBulan['april'] + $dataRealisasiBulan['mei'] + $dataRealisasiBulan['juni'];
                                $triwulan3 = $dataRealisasiBulan['juli'] + $dataRealisasiBulan['agustus'] + $dataRealisasiBulan['september'];
                                $triwulan4 = $dataRealisasiBulan['oktober'] + $dataRealisasiBulan['november'] + $dataRealisasiBulan['desember'];
                                ?>
                                <thead>
                                <tr>
                                    <th class="font-weight-bold" colspan="2" width="300px"
                                        style="padding: 5px 5px 5px 10px; text-align: center">
                                        TRIWULAN I
                                    </th>
                                    <th class="font-weight-bold" colspan="2" width="150px"
                                        style="text-align: right; padding: 5px 10px 5px 5px; text-align: center">
                                        TRIWULAN II
                                    </th>
                                    <th class="font-weight-bold" colspan="2" width="150px"
                                        style="text-align: right; padding: 5px 10px 5px 5px; text-align: center">
                                        TRIWULAN III
                                    </th>
                                    @if($tahun == '2021')
                                        <th class="font-weight-bold" colspan="2" width="150px"
                                            style="text-align: right; padding: 5px 10px 5px 5px; text-align: center">
                                            TRIWULAN IV
                                        </th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                        @if($triwulan1 > 0)
                                            {{ round($triwulan1/$anggaran*100, 2)."%" }}
                                        @endif
                                    </td>
                                    <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                        @if($triwulan1 > 0)
                                            {{ "Rp".number_format($triwulan1,0,',','.') }}
                                        @endif
                                    </td>
                                    <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                        @if($triwulan2 > 0)
                                            {{ round($triwulan2/$anggaran*100, 2)."%" }}
                                        @endif
                                    </td>
                                    <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                        @if($triwulan2 > 0)
                                            {{ "Rp".number_format($triwulan2,0,',','.') }}
                                        @endif
                                    </td>
                                    <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                        @if($triwulan3 > 0)
                                            {{ round($triwulan3/$anggaran*100, 2)."%" }}
                                        @endif
                                    </td>
                                    <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                        @if($triwulan3 > 0)
                                            {{ "Rp".number_format($triwulan3,0,',','.') }}
                                        @endif
                                    </td>
                                    @if($tahun == '2021')
                                        <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                            @if($triwulan4 > 0)
                                                {{ round($triwulan4/$anggaran*100, 2)."%" }}
                                            @endif
                                        </td>
                                        <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                            @if($triwulan4 > 0)
                                                {{ "Rp".number_format($triwulan4,0,',','.') }}
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                                </tbody>
                                <thead>
                                <tr>
                                    <th class="font-weight-bold" colspan="2" width="300px"
                                        style="padding: 5px 5px 5px 10px; text-align: center">
                                        TOTAL TW I
                                    </th>
                                    <th class="font-weight-bold" colspan="2" width="150px"
                                        style="text-align: right; padding: 5px 10px 5px 5px; text-align: center">
                                        TOTAL TW I + TW II
                                    </th>
                                    <th class="font-weight-bold" colspan="2" width="150px"
                                        style="text-align: right; padding: 5px 10px 5px 5px; text-align: center">
                                        TOTAL TW I + TW II + TW III
                                    </th>
                                    @if($tahun == '2021')
                                        <th class="font-weight-bold" colspan="2" width="150px"
                                            style="text-align: right; padding: 5px 10px 5px 5px; text-align: center">
                                            TOTAL TW I + TW II + TW III + TW IV
                                        </th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                        @if($triwulan1 > 0)
                                            {{ round($triwulan1/$anggaran*100, 2)."%" }}
                                        @endif
                                    </td>
                                    <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                        @if($triwulan1 > 0)
                                            {{ "Rp".number_format($triwulan1,0,',','.') }}
                                        @endif
                                    </td>
                                    <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                        @if($triwulan2 > 0)
                                            {{ round(($triwulan1 + $triwulan2)/$anggaran*100, 2)."%" }}
                                        @endif
                                    </td>
                                    <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                        @if($triwulan2 > 0)
                                            {{ "Rp".number_format($triwulan1 + $triwulan2,0,',','.') }}
                                        @endif
                                    </td>
                                    <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                        @if($triwulan3 > 0)
                                            {{ round(($triwulan1 + $triwulan2 + $triwulan3)/$anggaran*100, 2)."%" }}
                                        @endif
                                    </td>
                                    <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                        @if($triwulan3 > 0)
                                            {{ "Rp".number_format($triwulan1 + $triwulan2 + $triwulan3,0,',','.') }}
                                        @endif
                                    </td>
                                    @if($tahun == '2021')
                                        <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                            @if($triwulan4 > 0)
                                                {{ round(($triwulan1 + $triwulan2 + $triwulan3 + $triwulan4)/$anggaran*100, 2)."%" }}
                                            @endif
                                        </td>
                                        <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                            @if($triwulan4 > 0)
                                                {{ "Rp".number_format($triwulan1 + $triwulan2 + $triwulan3 + $triwulan4,0,',','.') }}
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h4 class="card-title model-huruf-family">REALISASI PROGRAM KERJA</h4>
                                <h6 class="card-subtitle model-huruf-family mb-4">
                                    <a href="#!" data-target=".modal-proker" data-toggle="modal">
                                        {{ $jumlahProkerNonRelokasi }} dari {{ $jumlahProker }} program kerja belum ada
                                        realisasi</a>
                                </h6>
                            </div>
                            <div class="ml-auto">
                                <a href="{{ route('exportRealisasiProker', $tahun) }}"
                                   class="btn active btn-sm btn-secondary"><i
                                            class="fa fa-file-text-o mr-2"></i>Export Excel</a>
                                <a href="{{ route('printRealisasiProker', $tahun) }}" target="_blank"
                                   class="btn active btn-sm btn-secondary"><i class="fa fa-print mr-2"></i>Print</a>
                            </div>
                        </div>
                        @if($realisasi > 0)
                            <div class="table-responsive">
                                <table class="example5 table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th width="50px" class="text-center" nowrap>Proker ID</th>
                                        <th width="400px" class="text-center">Program Kerja</th>
                                        <th width="300px" class="text-center">SDGs</th>
                                        <th width="150px" class="text-center">Anggaran</th>
                                        <th width="150px" class="text-center">Paid</th>
                                        <th width="150px" class="text-center">Progress</th>
                                        <th width="150px" class="text-center">Sisa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataProker as $data)
                                        <?php
                                        $proker = \App\Models\Proker::where('id_proker', $data['proker_id'])->first();
                                        $sisa = $proker->anggaran - ($data['progress'] + $data['paid']);
                                        ?>
                                        <tr>
                                            <td class="text-center">{{ "#".$data['proker_id'] }}</td>
                                            <td>
                                                <a target="_blank"
                                                   href="{{ route('listPaymentRequestProker', ['year'=> encrypt($tahun), 'prokerID'=> $data['proker_id']]) }}"
                                                   class="font-weight-bold"
                                                   style="color: blue">{{ $proker->proker }}</a>
                                                @if($proker->prioritas != "")
                                                    <br>
                                                    <span class="text-muted">{{ $proker->prioritas }}</span>
                                                @else
                                                    <br>
                                                    <span class="text-danger">Non Prioritas</span>
                                                @endif
                                            </td>
                                            <td nowrap>
                                                <span class="font-weight-bold">{{ $proker->pilar }}</span>
                                                <br>
                                                <span class="text-muted">{{ $proker->gols }}</span>
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($proker->anggaran,0,',','.') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($data['paid'],0,',','.') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($data['progress'],0,',','.') }}
                                            </td>
                                            <td class="text-right">
                                                @if($sisa >= 0)
                                                    <span class="font-weight-bold">{{ number_format($sisa,0,',','.') }}</span>
                                                @else
                                                    <span class="font-weight-bold"
                                                          style="color: red">{{ number_format($sisa,0,',','.') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach($prokerNonRelokasi as $dp)
                                        <tr>
                                            <td class="text-center">{{ "#".$dp->id_proker }}</td>
                                            <td>
                                                <span class="font-weight-bold">{{ $dp->proker }}</span>
                                                @if($dp->prioritas != "")
                                                    <br>
                                                    <span class="text-muted">{{ $dp->prioritas }}</span>
                                                @else
                                                    <br>
                                                    <span class="text-danger">Non Prioritas</span>
                                                @endif
                                            </td>
                                            <td nowrap>
                                                <span class="font-weight-bold">{{ $dp->pilar }}</span>
                                                <br>
                                                <span class="text-muted">{{ $dp->gols }}</span>
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($dp->anggaran,0,',','.') }}
                                            </td>
                                            <td class="text-right">
                                                0
                                            </td>
                                            <td class="text-right">
                                                0
                                            </td>
                                            <td class="text-right">
                                                <span class="font-weight-bold">{{ number_format($dp->anggaran,0,',','.') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                <h3 class="model-huruf-family"><i class="fa fa-warning"></i> Warning</h3> Belum
                                ada
                                realisasi program kerja tahun {{ $tahun }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                <th width="50px" class="text-center" nowrap>Proker ID</th>
                                <th width="300px" class="text-center">Program Kerja</th>
                                <th width="300px" class="text-center">SDGs</th>
                                <th width="150px" class="text-center">Anggaran</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($prokerNonRelokasi as $dpo)
                                <tr>
                                    <td class="text-center">{{ "#".$dpo->id_proker }}</td>
                                    <td>
                                        <span class="font-weight-bold">{{ $dpo->proker }}</span>
                                        @if($dpo->prioritas != "")
                                            <br>
                                            <span class="text-muted">{{ $dpo->prioritas }}</span>
                                        @else
                                            <br>
                                            <span class="text-danger">Non Prioritas</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="font-weight-bold">{{ $dpo->pilar }}</span>
                                        <br>
                                        <span class="text-muted">{{ $dpo->gols }}</span>
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($dpo->anggaran,0,',','.') }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('AnggaranController@postMonitoringAnnual') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterAnnual" tabindex="-1" role="dialog" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i class="fa fa-filter mr-2"></i>Budget
                            Year</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label>Tahun <span
                                        class="text-danger">*</span></label>
                            <select class="form-control mb-2" name="tahun">
                                <option value="" disabled selected>Pilih Tahun</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
{{--                                <option value="2024">2024</option>--}}
{{--                                <option value="2025">2025</option>--}}
                            </select>
                            @if($errors->has('tahun'))
                                <small class="text-danger mt-0">Tahun anggaran harus diisi</small>
                            @endif
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

    <form method="post" action="{{ action('AnggaranController@postMonitoringMonthly') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterTanggal" tabindex="-1" role="dialog" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i class="fa fa-filter mr-2"></i>Custom
                            Range</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Periode Awal <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="date-start"
                                           class="form-control" onchange="ubahTanggal()"
                                           name="tanggal1" value="{{ old('tanggal1') }}">
                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                    class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                @if($errors->has('tanggal1'))
                                    <small class="text-danger">Periode awal harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Periode Akhir <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="date-end"
                                           class="form-control"
                                           name="tanggal2" value="{{ old('tanggal2') }}">
                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                    class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                @if($errors->has('tanggal1'))
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
@endsection

@section('footer')
    <script src="{{ asset('template/assets/node_modules/chart-highchart/js/highcharts.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/chart-highchart/js/highcharts-3d.js') }}"></script>

    <script>
        function ubahTanggal() {
            document.getElementById("date-end").value = '';
        }
    </script>

    <script>
        function IDRFormatter(angka, prefix) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
        }
    </script>

    @if($tahun == '2021')
        <script>
            $(function () {
                var chart = Highcharts.chart('containerMonthly', {
                    colors: ['#f44236'],
                    title: {
                        style: {
                            color: '#000',
                            font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                        },
                        text: 'Statistik Realisasi Per Bulan',
                    },
                    subtitle: {
                        style: {
                            color: '#666666',
                            font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                        },
                        text: 'Source: popay.pgn.co.id'
                    },
                    chart: {
                        inverted: false,
                        polar: true,
                    },
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    enabled: true
                                }
                            }
                        }]
                    },
                    credits: {
                        enabled: false,
                    },
                    yAxis: {
                        title: {
                            text: ''
                        },
                        // labels: {
                        //     formatter: function () {
                        //         if (this.value >= 0) {
                        //             return IDRFormatter(this.value, 'Rp')
                        //         } else {
                        //             return '-' + IDRFormatter(this.value, 'Rp')
                        //         }
                        //     }
                        // }
                    },
                    xAxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        //     'Jul'],
                        title: {
                            text: ''
                        },
                    },
                    tooltip: {
                        enabled: false,
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                enabled: true,
                                formatter: function () {
                                    if (this.y >= 0) {
                                        return IDRFormatter(this.y, 'Rp')
                                    } else {
                                        return '-' + IDRFormatter(this.y, 'Rp')
                                    }
                                },
                            },
                        }
                    },
                    series: [{
                        name: "Total",
                        type: 'area',
                        colorByPoint: false,
                        {{--data: [{{ $dataRealisasiBulan['januari'] }}, {{ $dataRealisasiBulan['februari'] }}, {{ $dataRealisasiBulan['maret'] }}, {{ $dataRealisasiBulan['april'] }}, {{ $dataRealisasiBulan['mei'] }}, {{ $dataRealisasiBulan['juni'] }}, {{ $dataRealisasiBulan['juli'] }}],--}}
                        data: [{{ $dataRealisasiBulan['januari'] }}, {{ $dataRealisasiBulan['februari'] }}, {{ $dataRealisasiBulan['maret'] }}, {{ $dataRealisasiBulan['april'] }}, {{ $dataRealisasiBulan['mei'] }}, {{ $dataRealisasiBulan['juni'] }}, {{ $dataRealisasiBulan['juli'] }}, {{ $dataRealisasiBulan['agustus'] }}, {{ $dataRealisasiBulan['september'] }}, {{ $dataRealisasiBulan['oktober'] }}, {{ $dataRealisasiBulan['november'] }}, {{ $dataRealisasiBulan['desember'] }}],
                        showInLegend: false,
                    }]
                });
            });
        </script>
    @else
        <script>
            $(function () {
                var chart = Highcharts.chart('containerMonthly', {
                    colors: ['#f44236'],
                    title: {
                        style: {
                            color: '#000',
                            font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                        },
                        text: 'Statistik Realisasi Per Bulan',
                    },
                    subtitle: {
                        style: {
                            color: '#666666',
                            font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                        },
                        text: 'Source: popay.pgn.co.id'
                    },
                    chart: {
                        inverted: false,
                        polar: true,
                    },
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    enabled: true
                                }
                            }
                        }]
                    },
                    credits: {
                        enabled: false,
                    },
                    yAxis: {
                        title: {
                            text: ''
                        },
                        // labels: {
                        //     formatter: function () {
                        //         if (this.value >= 0) {
                        //             return IDRFormatter(this.value, 'Rp')
                        //         } else {
                        //             return '-' + IDRFormatter(this.value, 'Rp')
                        //         }
                        //     }
                        // }
                    },
                    xAxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        //categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Agu', 'Sep'],
                        title: {
                            text: ''
                        },
                    },
                    tooltip: {
                        enabled: false,
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                enabled: true,
                                formatter: function () {
                                    if (this.y >= 0) {
                                        return IDRFormatter(this.y, 'Rp')
                                    } else {
                                        return '-' + IDRFormatter(this.y, 'Rp')
                                    }
                                },
                            },
                        }
                    },
                    series: [{
                        name: "Total",
                        type: 'area',
                        colorByPoint: false,
                        {{--data: [{{ $dataRealisasiBulan['januari'] }}, {{ $dataRealisasiBulan['februari'] }}, {{ $dataRealisasiBulan['maret'] }}, {{ $dataRealisasiBulan['april'] }}, {{ $dataRealisasiBulan['mei'] }}, {{ $dataRealisasiBulan['juni'] }}, {{ $dataRealisasiBulan['juli'] }}],--}}
                        data: [{{ $dataRealisasiBulan['januari'] }}, {{ $dataRealisasiBulan['februari'] }}, {{ $dataRealisasiBulan['maret'] }}, {{ $dataRealisasiBulan['april'] }}, {{ $dataRealisasiBulan['mei'] }}, {{ $dataRealisasiBulan['juni'] }}, {{ $dataRealisasiBulan['juli'] }}, {{ $dataRealisasiBulan['agustus'] }}, {{ $dataRealisasiBulan['september'] }}, {{ $dataRealisasiBulan['oktober'] }}, {{ $dataRealisasiBulan['november'] }}, {{ $dataRealisasiBulan['desember'] }}],
                        showInLegend: false,
                    }]
                });
            });
        </script>
    @endif

    <script>
        const chart = Highcharts.chart('containerPrioritas', {
            colors: ['#1de9b6', '#1dc4e9', '#A389D4', '#899FD4', '#f44236', '#f4c22b'],
            credits: {
                enabled: false,
            },
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            enabled: true
                        }
                    }
                }]
            },
            title: {
                style: {
                    color: '#000',
                    font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                },
                text: '',
            },
            subtitle: {
                style: {
                    color: '#666666',
                    font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                },
                text: ''
            },
            xAxis: {
                categories: {!! json_encode($dataNamaPrioritas) !!},
            },
            yAxis: {
                // max: 60,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<b>{point.y:.f}%</b>'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.f}%'
                    }
                }
            },
            series: [{
                name: "Total",
                type: 'column',
                colorByPoint: true,
                data: {!! json_encode($dataPersenPrioritas) !!},
                showInLegend: false
            }]
        });

        document.getElementById('plain').addEventListener('click', () => {
            chart.update({
                chart: {
                    inverted: false,
                    polar: false
                },
                subtitle: {
                    style: {
                        color: '#666666',
                        font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                    },
                    text: ''
                },
            });
        });

        document.getElementById('inverted').addEventListener('click', () => {
            chart.update({
                chart: {
                    inverted: true,
                    polar: false
                },
                subtitle: {
                    style: {
                        color: '#666666',
                        font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                    },
                    text: ''
                },
            });
        });
    </script>

    <script>
        $(function () {
            var chart = Highcharts.chart('containerPilar', {
                colors: ['#1de9b6', '#1dc4e9', '#A389D4', '#899FD4', '#f44236', '#f4c22b', '#4DB6AC', '#D4E157', '#FFA726', '#0288D1'],
                title: {
                    style: {
                        color: '#000',
                        font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                    },
                    text: 'Statistik Realisasi SDGs',
                },
                subtitle: {
                    style: {
                        color: '#666666',
                        font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                    },
                    text: 'Source: popay.pgn.co.id'
                },
                chart: {
                    inverted: false,
                    polar: true,
                },
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                enabled: true
                            }
                        }
                    }]
                },
                credits: {
                    enabled: false,
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                    labels: {
                        formatter: function () {
                            if (this.value >= 0) {
                                return IDRFormatter(this.value, 'Rp')
                            } else {
                                return '-' + IDRFormatter(this.value, 'Rp ')
                            }
                        }
                    }
                },
                xAxis: {
                    categories: {!! json_encode($dataNamaPilar) !!},
                    title: {
                        text: ''
                    },
                },
                tooltip: {
                    enabled: false,
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            formatter: function () {
                                if (this.y >= 0) {
                                    return IDRFormatter(this.y, 'Rp')
                                } else {
                                    return '-' + IDRFormatter(this.y, 'Rp')
                                }
                            },
                        },
                    }
                },
                series: [{
                    name: "Total",
                    type: 'column',
                    colorByPoint: true,
                    data: {!! json_encode($dataTotalPilar) !!},
                    showInLegend: false,
                }]
            });
        });
    </script>
@stop