@extends('layout.master')
@section('title', 'NR SHARE | Dashboard')
@section('content')
    <?php
    $sisa = $anggaran - $realisasi;
    ?>

    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">DASHBOARD
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb model-huruf-family">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="btn-group">
                        <a href="#!" class="btn btn-info d-lg-block ml-3" data-target=".modalFilterAnnual"
                            data-toggle="modal"><i class="fa fa-filter mr-2"></i>Budget Year</a>
                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split active"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#!" data-target=".modalFilterSubsidiary"
                                data-toggle="modal">Subsidiary</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($anggaran > 0)
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title model-huruf-family">TOTAL ANGGARAN</h4>
                            <div class="m-t-40 mb-1">
                                <h3 class="font-weight-bold">{{ 'Rp' . number_format($anggaran, 0, ',', '.') }}</h3>
                                <span class="text-muted model-huruf-family">Tahun {{ $tahun }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title model-huruf-family mb-4">TOTAL REALISASI</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <span class="pie"
                                                data-peity='{ "fill": ["#1de9b6", "#f2f2f2"]}'>{{ round(($realisasi / $anggaran) * 100, 2) }},{{ round(($sisa / $anggaran) * 100, 2) }}</span>
                                            <br>
                                            <small class="text-muted">Status
                                                : {{ round(($realisasi / $anggaran) * 100, 2) . '%' }}</small>
                                        </div>
                                        <div class="ml-auto">
                                            <h3 class="counter">
                                                <b
                                                    class="font-weight-bold">{{ 'Rp' . number_format($realisasi, 0, ',', '.') }}</b>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title model-huruf-family mb-4">SISA ANGGARAN</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <span class="pie"
                                                data-peity='{ "fill": ["#f44236", "#f2f2f2"]}'>{{ round(($sisa / $anggaran) * 100, 2) }},{{ round(($realisasi / $anggaran) * 100, 2) }}</span>
                                            <br>
                                            <small class="text-muted">Status
                                                : {{ round(($sisa / $anggaran) * 100, 2) . '%' }}</small>
                                        </div>
                                        <div class="ml-auto">
                                            <h3 class="counter">
                                                <span
                                                    class="font-weight-bold">{{ 'Rp' . number_format($sisa, 0, ',', '.') }}</span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($realisasi > 0)
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div id="containerPilar" style="width: 100%; height: 300px;"></div>
                            </div>
                            <table class="table-striped" width="100%">
                                <tbody>
                                    @foreach ($totalPilar as $tp)
                                        <tr>
                                            <td width="300px" style="padding: 5px 5px 5px 10px" class="font-weight-bold">
                                                {{ $tp->pilar }}
                                            </td>
                                            <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                                {{ number_format($tp->total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div id="containerPrioritas" style="width: 100%; height: 300px;"></div>
                            </div>
                            <table class="table-striped" width="100%">
                                <tbody>
                                    @foreach ($totalPrioritas as $p)
                                        <tr>
                                            <td width="300px" style="padding: 5px 5px 5px 10px" class="font-weight-bold">
                                                @if ($p->prioritas == '')
                                                    Sosial/Ekonomi
                                                @else
                                                    {{ $p->prioritas }}
                                                @endif
                                            </td>
                                            <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                                {{ number_format($p->total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-8">
                        {{--                        <div class="card"> --}}
                        {{--                            <div class="card-body"> --}}
                        {{--                                <div id="containerTPB" style="width: 100%; height: 300px;"></div> --}}
                        {{--                            </div> --}}
                        {{--                            <table class="table-striped" width="100%"> --}}
                        {{--                                <tbody> --}}
                        {{--                                @foreach ($totalTPB as $tpb) --}}
                        {{--                                    <tr> --}}
                        {{--                                        <td width="300px" style="padding: 5px 5px 5px 10px" class="font-weight-bold"> --}}
                        {{--                                            {{ $tpb->gols }} --}}
                        {{--                                        </td> --}}
                        {{--                                        <td width="150px" --}}
                        {{--                                            style="text-align: right; padding: 5px 10px 5px 5px">{{ number_format($tpb->total,0,',','.') }} --}}
                        {{--                                        </td> --}}
                        {{--                                    </tr> --}}
                        {{--                                @endforeach --}}
                        {{--                                </tbody> --}}
                        {{--                            </table> --}}
                        {{--                        </div> --}}

                        <div class="card">
                            <div class="card-body">
                                <div id="containerMonthly"></div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body p-2">
                                <h5 class="card-title model-huruf-family font-weight-bold">REALISASI PER TRIWULAN</h5>
                                <h6 class="card-subtitle mb-5 model-huruf-family">Tahun {{ $tahun }}</h6>
                                <div class="table-responsive">
                                    <table class="table-striped table-bordered" width="100%">
                                        <?php
                                        $triwulan1 = $dataRealisasiBulan->januari + $dataRealisasiBulan->februari + $dataRealisasiBulan->maret;
                                        $triwulan2 = $dataRealisasiBulan->april + $dataRealisasiBulan->mei + $dataRealisasiBulan->juni;
                                        $triwulan3 = $dataRealisasiBulan->juli + $dataRealisasiBulan->agustus + $dataRealisasiBulan->september;
                                        $triwulan4 = $dataRealisasiBulan->oktober + $dataRealisasiBulan->november + $dataRealisasiBulan->desember;
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
                                                @if ($tahun == '2021')
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
                                                    @if ($triwulan1 > 0)
                                                        {{ round(($triwulan1 / $anggaran) * 100, 2) . '%' }}
                                                    @endif
                                                </td>
                                                <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                                    @if ($triwulan1 > 0)
                                                        {{ 'Rp' . number_format($triwulan1, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                                <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                                    @if ($triwulan2 > 0)
                                                        {{ round(($triwulan2 / $anggaran) * 100, 2) . '%' }}
                                                    @endif
                                                </td>
                                                <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                                    @if ($triwulan2 > 0)
                                                        {{ 'Rp' . number_format($triwulan2, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                                <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                                    @if ($triwulan3 > 0)
                                                        {{ round(($triwulan3 / $anggaran) * 100, 2) . '%' }}
                                                    @endif
                                                </td>
                                                <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                                    @if ($triwulan3 > 0)
                                                        {{ 'Rp' . number_format($triwulan3, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                                @if ($tahun == '2021')
                                                    <td width="150px"
                                                        style="padding: 5px 10px 5px 5px; text-align: center">
                                                        @if ($triwulan4 > 0)
                                                            {{ round(($triwulan4 / $anggaran) * 100, 2) . '%' }}
                                                        @endif
                                                    </td>
                                                    <td width="300px"
                                                        style="padding: 5px 10px 5px 10px; text-align: right">
                                                        @if ($triwulan4 > 0)
                                                            {{ 'Rp' . number_format($triwulan4, 0, ',', '.') }}
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
                                                @if ($tahun == '2021')
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
                                                    @if ($triwulan1 > 0)
                                                        {{ round(($triwulan1 / $anggaran) * 100, 2) . '%' }}
                                                    @endif
                                                </td>
                                                <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                                    @if ($triwulan1 > 0)
                                                        {{ 'Rp' . number_format($triwulan1, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                                <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                                    @if ($triwulan2 > 0)
                                                        {{ round((($triwulan1 + $triwulan2) / $anggaran) * 100, 2) . '%' }}
                                                    @endif
                                                </td>
                                                <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                                    @if ($triwulan2 > 0)
                                                        {{ 'Rp' . number_format($triwulan1 + $triwulan2, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                                <td width="150px" style="padding: 5px 10px 5px 5px; text-align: center">
                                                    @if ($triwulan3 > 0)
                                                        {{ round((($triwulan1 + $triwulan2 + $triwulan3) / $anggaran) * 100, 2) . '%' }}
                                                    @endif
                                                </td>
                                                <td width="300px" style="padding: 5px 10px 5px 10px; text-align: right">
                                                    @if ($triwulan3 > 0)
                                                        {{ 'Rp' . number_format($triwulan1 + $triwulan2 + $triwulan3, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                                @if ($tahun == '2021')
                                                    <td width="150px"
                                                        style="padding: 5px 10px 5px 5px; text-align: center">
                                                        @if ($triwulan4 > 0)
                                                            {{ round((($triwulan1 + $triwulan2 + $triwulan3 + $triwulan4) / $anggaran) * 100, 2) . '%' }}
                                                        @endif
                                                    </td>
                                                    <td width="300px"
                                                        style="padding: 5px 10px 5px 10px; text-align: right">
                                                        @if ($triwulan4 > 0)
                                                            {{ 'Rp' . number_format($triwulan1 + $triwulan2 + $triwulan3 + $triwulan4, 0, ',', '.') }}
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body p-2">
                                <h5 class="card-title model-huruf-family font-weight-bold">REALISASI PER WILAYAH</h5>
                                <h6 class="card-subtitle mb-5 model-huruf-family">Tahun {{ $tahun }}</h6>
                                <div class="table-responsive">
                                    <table class="table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="font-weight-bold" width="400px"
                                                    style="padding: 5px 5px 5px 10px; text-align: center">
                                                    Provinsi
                                                </th>
                                                <th class="font-weight-bold" width="100px"
                                                    style="padding: 5px 10px 5px 5px; text-align: center">
                                                    Bobot
                                                </th>
                                                <th class="font-weight-bold" width="200px"
                                                    style="padding: 5px 10px 5px 5px; text-align: center">
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($totalWilayah as $provinsi)
                                                <tr>
                                                    <td style="padding: 5px 5px 5px 10px">
                                                        {{ $provinsi->provinsi }}
                                                    </td>
                                                    <td style="padding: 5px 10px 5px 5px; text-align: center">
                                                        {{ round(($provinsi->total / $anggaran) * 100, 2) . '%' }}
                                                    </td>
                                                    <td style="padding: 5px 10px 5px 10px; text-align: right">
                                                        {{ number_format($provinsi->total, 0, ',', '.') }}
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
            @endif
        @else
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        <h4 class="model-huruf-family"><i class="fa fa-info-circle"></i> Information</h4>
                        Anggaran tahun {{ $tahun }} belum dibuat
                    </div>
                </div>
            </div>
        @endif
    </div>

    <form method="post" action="{{ action('DashboardController@postSubsidiary') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterAnnual" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i
                                class="fa fa-filter mr-2"></i>Budget
                            Year</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="perusahaan" value="{{ $comp }}">
                        <div class="form-group mb-0">
                            <label>Tahun <span class="text-danger">*</span></label>
                            <select class="form-control" name="tahun">
                                <option value=""></option>
                                @for ($thn = 2022; $thn <= date('Y') + 1; $thn++)
                                    <option value="{{ $thn }}">
                                        {{ $thn }}
                                    </option>
                                @endfor
                            </select>
                            @if ($errors->has('tahun'))
                                <small class="text-danger">Tahun anggaran harus diisi</small>
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

    <form method="post" action="{{ action('DashboardController@postSubsidiary') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterSubsidiary" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i
                                class="fa fa-filter mr-2"></i>Subsidiary</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                        <div class="form-group mb-0">
                            <label>Perusahaan <span class="text-danger">*</span></label>
                            <select class="form-control" name="perusahaan" style="width: 100%">
                                <option>{{ $comp }}</option>
                                @foreach ($dataPerusahaan as $perusahaan)
                                    <option>{{ $perusahaan->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('perusahaan'))
                                <small class="text-danger">Perusahaan harus diisi</small>
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
@endsection

@section('footer')
    <script src="{{ asset('template/assets/node_modules/chart-highchart/js/highcharts.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/chart-highchart/js/highcharts-3d.js') }}"></script>

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

    <script>
        @if (count($errors) > 0)
            toastr.error('Parameter pencarian data belum lengkap', 'Failed', {
                closeButton: true
            });
        @endif
    </script>

    <script>
        const chart = Highcharts.chart('containerPilar', {
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
                text: 'Statistik Pilar SDGs'
            },
            subtitle: {
                style: {
                    color: '#666666',
                    font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                },
                text: "Tahun {{ $tahun }}"
            },
            xAxis: {
                categories: {!! json_encode($pilar) !!},
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
                name: "Status",
                type: 'column',
                colorByPoint: true,
                data: {!! json_encode($statusPilar) !!},
                showInLegend: false
            }]
        });
    </script>

    <script>
        Highcharts.chart('containerPrioritas', {
            colors: ['#1de9b6', '#1dc4e9', '#A389D4', '#899FD4', '#f44236', '#f4c22b'],
            credits: {
                enabled: false,
            },
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 800
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
                text: 'Statistik Prioritas'
            },
            subtitle: {
                style: {
                    color: '#666666',
                    font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                },
                text: "Tahun {{ $tahun }}"
            },
            xAxis: {
                categories: {!! json_encode($prioritas) !!},
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
                name: "Status",
                type: 'column',
                colorByPoint: true,
                data: {!! json_encode($statusPrioritas) !!},
                showInLegend: false
            }]
        });
    </script>

    {{--    <script> --}}
    {{--        Highcharts.chart('containerTPB', { --}}
    {{--            colors: ['#1de9b6', '#1dc4e9', '#A389D4', '#899FD4', '#f44236', '#f4c22b'], --}}
    {{--            credits: { --}}
    {{--                enabled: false, --}}
    {{--            }, --}}
    {{--            responsive: { --}}
    {{--                rules: [{ --}}
    {{--                    condition: { --}}
    {{--                        maxWidth: 800 --}}
    {{--                    }, --}}
    {{--                    chartOptions: { --}}
    {{--                        legend: { --}}
    {{--                            enabled: true --}}
    {{--                        } --}}
    {{--                    } --}}
    {{--                }] --}}
    {{--            }, --}}
    {{--            title: { --}}
    {{--                style: { --}}
    {{--                    color: '#000', --}}
    {{--                    font: 'bold 16px "Trebuchet MS", Verdana, sans-serif' --}}
    {{--                }, --}}
    {{--                text: 'Statistik Realisasi Goals SDGs' --}}
    {{--            }, --}}
    {{--            subtitle: { --}}
    {{--                style: { --}}
    {{--                    color: '#666666', --}}
    {{--                    font: 'bold 12px "Trebuchet MS", Verdana, sans-serif' --}}
    {{--                }, --}}
    {{--                text: "Tahun {{ $tahun }}" --}}
    {{--            }, --}}
    {{--            xAxis: { --}}
    {{--                categories: {!! json_encode($goals) !!}, --}}
    {{--            }, --}}
    {{--            yAxis: { --}}
    {{--                // max: 60, --}}
    {{--                title: { --}}
    {{--                    text: '' --}}
    {{--                } --}}
    {{--            }, --}}
    {{--            tooltip: { --}}
    {{--                pointFormat: '<b>{point.y:.f}%</b>' --}}
    {{--            }, --}}
    {{--            plotOptions: { --}}
    {{--                series: { --}}
    {{--                    dataLabels: { --}}
    {{--                        enabled: true, --}}
    {{--                        format: '{point.y:.f}%' --}}
    {{--                    } --}}
    {{--                } --}}
    {{--            }, --}}
    {{--            series: [{ --}}
    {{--                name: "Status", --}}
    {{--                type: 'column', --}}
    {{--                colorByPoint: true, --}}
    {{--                data: {!! json_encode($statusGoals) !!}, --}}
    {{--                showInLegend: false --}}
    {{--            }] --}}
    {{--        }); --}}
    {{--    </script> --}}

    {{--    <script> --}}
    {{--        $(function () { --}}
    {{--            var chart = Highcharts.chart('containerTPB', { --}}
    {{--                colors: ['#1de9b6', '#1dc4e9', '#A389D4', '#899FD4', '#f44236', '#f4c22b'], --}}
    {{--                title: { --}}
    {{--                    style: { --}}
    {{--                        color: '#000', --}}
    {{--                        font: 'bold 16px "Trebuchet MS", Verdana, sans-serif' --}}
    {{--                    }, --}}
    {{--                    text: 'Statistik Goals SDGs', --}}
    {{--                }, --}}
    {{--                subtitle: { --}}
    {{--                    style: { --}}
    {{--                        color: '#666666', --}}
    {{--                        font: 'bold 12px "Trebuchet MS", Verdana, sans-serif' --}}
    {{--                    }, --}}
    {{--                    text: 'Tahun {{ $tahun }}' --}}
    {{--                }, --}}
    {{--                chart: { --}}
    {{--                    inverted: false, --}}
    {{--                    polar: true, --}}
    {{--                }, --}}
    {{--                responsive: { --}}
    {{--                    rules: [{ --}}
    {{--                        condition: { --}}
    {{--                            maxWidth: 500 --}}
    {{--                        }, --}}
    {{--                        chartOptions: { --}}
    {{--                            legend: { --}}
    {{--                                enabled: true --}}
    {{--                            } --}}
    {{--                        } --}}
    {{--                    }] --}}
    {{--                }, --}}
    {{--                credits: { --}}
    {{--                    enabled: false, --}}
    {{--                }, --}}
    {{--                yAxis: { --}}
    {{--                    title: { --}}
    {{--                        text: '' --}}
    {{--                    }, --}}
    {{--                }, --}}
    {{--                xAxis: { --}}
    {{--                    categories: {!! json_encode($goals) !!}, --}}
    {{--                    title: { --}}
    {{--                        text: '' --}}
    {{--                    }, --}}
    {{--                }, --}}
    {{--                tooltip: { --}}
    {{--                    enabled: false, --}}
    {{--                }, --}}
    {{--                plotOptions: { --}}
    {{--                    series: { --}}
    {{--                        dataLabels: { --}}
    {{--                            enabled: true, --}}
    {{--                            format: '{point.y:.f}%' --}}
    {{--                        } --}}
    {{--                    } --}}
    {{--                }, --}}
    {{--                series: [{ --}}
    {{--                    name: "Total", --}}
    {{--                    type: 'area', --}}
    {{--                    colorByPoint: false, --}}
    {{--                    data: {!! json_encode($statusGoals) !!}, --}}
    {{--                    showInLegend: false, --}}
    {{--                }] --}}
    {{--            }); --}}
    {{--        }); --}}
    {{--    </script> --}}

    <script>
        $(function() {
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
                    text: 'Tahun {{ $tahun }}'
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
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                        'Nov', 'Dec'
                    ],
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
                            formatter: function() {
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
                    type: 'line',
                    colorByPoint: false,
                    data: {!! json_encode($bulanan) !!},
                    showInLegend: false,
                }]
            });
        });
    </script>
@stop
