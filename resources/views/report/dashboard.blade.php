@extends('layout.master')
@section('title', 'PGN SHARE | Dashboard')
@section('content')
    <?php
    $lastYear = $tahun - 1;
    
    $jumlahAnggaran = \App\Models\Anggaran::where('tahun', $lastYear)->count();
    $budgetLastYear = \App\Models\Anggaran::where('tahun', $lastYear)->first();
    
    if ($jumlahAnggaran > 0) {
        $budget = $budgetLastYear;
    } else {
        $budget = 0;
    }
    ?>

    <style>
        .zoom {
            transition: transform .2s;
            /* Animation */
        }

        .zoom:hover {
            transform: scale(1.05);
            /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold">DASHBOARD
                    <br>
                    <small>Monitoring Anggaran</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <button type="button" class="btn btn-light btn-rounded d-none d-lg-block m-l-15"
                        data-target=".modalTahun" data-toggle="modal" data-bs-toggle="tooltip" data-placement="top"
                        title="Tahun Anggaran">
                        <i class="icon-wallet text-primary mr-2"></i>{{ $tahun }}
                    </button>
                    <a href="{{ route('dashboardOverall') }}" class="btn btn-light btn-rounded d-none d-lg-block m-l-15"
                        data-bs-toggle="tooltip" data-placement="top" title="Dashboard Anak Perusahaan">
                        <i class="icon-chart mr-2 text-info"></i>Anak Perusahaan
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('reviewSurvei') }}">
                    <div class="card zoom">
                        <div class="d-flex flex-row">
                            <div class="p-10 bg-info">
                                <h3 class="text-white box m-b-0"><i class="fa fa-clipboard-list"></i></h3>
                            </div>
                            <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-dark">{{ $jumlahReviewSurvei }}</h3>
                                <h5 class="text-muted">Review Survei</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('tasklistEvaluasi') }}">
                    <div class="card zoom">
                        <div class="d-flex flex-row">
                            <div class="p-10 bg-success">
                                <h3 class="text-white box m-b-0"><i class="fa fa-check-square"></i></h3>
                            </div>
                            <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-dark">{{ $jumlahApproveEvaluasi }}</h3>
                                <h5 class="text-muted">Approval Evaluasi</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('tasklist-survei') }}">
                    <div class="card zoom">
                        <div class="d-flex flex-row">
                            <div class="p-10 bg-warning">
                                <h3 class="text-white box m-b-0"><i class="fa fa-check-square"></i></h3>
                            </div>
                            <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-dark">{{ $jumlahApproveSurvei }}</h3>
                                <h5 class="text-muted">Approval Survei</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('todolist') }}">
                    <div class="card zoom">
                        <div class="d-flex flex-row">
                            <div class="p-10 bg-primary">
                                <h3 class="text-white box m-b-0"><i class="fas fa-file-text"></i></h3>
                            </div>
                            <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-dark">{{ $jumlahCreateSurvei }}</h3>
                                <h5 class="text-muted">Create Survei</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        @if ($totalCostProposal > 0)
            <div class="card-group">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-5">ANGGARAN</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div class="ml-auto">
                                        <h3 class="counter">
                                            <b class="font-weight-bold"><sup><i
                                                        class="{{ $anggaran > $budget ? 'ti-arrow-up text-success' : 'ti-arrow-down text-danger' }}"></i></sup>
                                                {{ 'Rp' . number_format($anggaran, 0, ',', '.') }}
                                            </b>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">REALISASI
                            <button type="button" class="btn btn-xs btn-outline-info btn-rounded float-right"
                                data-toggle="collapse" data-target="#collapseDetail" aria-expanded="false"
                                aria-controls="collapseDetail">
                                Detail Resource
                            </button>
                        </h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <span class="pie"
                                            data-peity='{ "fill": ["#1de9b6", "#f2f2f2"]}'>{{ round(($totalCostProposal / $anggaran) * 100, 2) }},{{ 100 - round(($totalCostProposal / $anggaran) * 100, 2) }}</span>
                                        <br>
                                        <small class="text-muted">Status
                                            :
                                            {{ round(($totalCostProposal / $anggaran) * 100, 2) . '%' }}</small>
                                    </div>
                                    <div class="ml-auto">
                                        @if ($totalCostProposal > 0)
                                            <h3 class="counter">
                                                <b
                                                    class="font-weight-bold">{{ 'Rp' . number_format($totalCostProposal, 0, ',', '.') }}</b>
                                            </h3>
                                        @else
                                            <h3 class="counter">
                                                <b class="font-weight-bold">-</b>
                                            </h3>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="collapseDetail">
                                <div class="col-12">
                                    <table class="table-striped mt-3" width="100%">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="padding: 5px" class="font-weight-bold">
                                                    DATA SOURCE
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="300px" style="padding: 5px">POPAY</td>
                                                <td class="text-right" width="100px" style="padding: 5px">
                                                    {{ number_format($totalPOPAY, 0, ',', '.') }}</td>
                                                <td width="150px" style="text-align: right; padding: 5px">
                                                    @if ($totalPOPAY > 0)
                                                        {{ round(($totalPOPAY / $anggaran) * 100, 2) . '%' }}
                                                    @else
                                                        0%
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="300px" style="padding: 5px">YKPP</td>
                                                <td class="text-right" width="100px" style="padding: 5px">
                                                    {{ number_format($totalYKPP, 0, ',', '.') }}</td>
                                                <td width="150px" style="text-align: right; padding: 5px">
                                                    @if ($totalYKPP > 0)
                                                        {{ round(($totalYKPP / $anggaran) * 100, 2) . '%' }}
                                                    @else
                                                        0%
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">SISA ANGGARAN</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <span class="pie"
                                            data-peity='{ "fill": ["#f44236", "#f2f2f2"]}'>{{ round((($anggaran - $totalCostProposal) / $anggaran) * 100, 2) }},{{ 100 - round((($anggaran - $totalCostProposal) / $anggaran) * 100, 2) }}</span>
                                        <br>
                                        <small class="text-muted">Status
                                            :
                                            {{ round((($anggaran - $totalCostProposal) / $anggaran) * 100, 2) . '%' }}</small>
                                    </div>
                                    <div class="ml-auto">
                                        @if ($totalCostProposal > 0)
                                            <?php
                                            $sisa = $anggaran - $totalCostProposal;
                                            ?>
                                            <h3 class="counter">
                                                <b
                                                    class="font-weight-bold">{{ 'Rp' . number_format($sisa, 0, ',', '.') }}</b>
                                            </h3>
                                        @else
                                            <h3 class="counter">
                                                <b
                                                    class="font-weight-bold">{{ 'Rp' . number_format($anggaran, 0, ',', '.') }}</b>
                                            </h3>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($totalCostProposal > 0)
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="container1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="container2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="containerMonthly"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <form method="post" action="{{ action('DashboardController@postAnnual') }}">
        {{ csrf_field() }}
        <div class="modal fade modalTahun" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <b>TAHUN ANGGARAN</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label>Tahun <span class="text-danger">*</span></label>
                            <select class="form-control" name="tahun">
                                <option></option>
                                @for ($thn = 2023; $thn <= date('Y') + 1; $thn++)
                                    <option>{{ $thn }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('tahun'))
                                <small class="text-danger">Tahun anggaran harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('DashboardController@postSubsidiary') }}">
        {{ csrf_field() }}
        <div class="modal fade modalPerusahaan" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <b>Perusahaan</b>
                        </h5>
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
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        @if (count($errors) > 0)
            toastr.error('Parameter pencarian data belum lengkap', 'Failed', {
                closeButton: true
            });
        @endif
    </script>

    <script>
        var tahun = "<?php echo $tahun; ?>";

        Highcharts.chart('container1', {
            colors: ['#1de9b6', '#1dc4e9', '#A389D4', '#f44236', '#f4c22b'],
            chart: {
                type: 'pie'
            },
            credits: {
                enabled: false,
            },
            title: {
                text: 'Realisasi Berdasarkan Prioritas'
            },
            tooltip: {
                enabled: false,
            },
            subtitle: {
                text: 'RKAP ' + tahun + ''
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<span>' + this.point.name +
                                '</span><br/>' + '<b>Rp' + Highcharts.numberFormat(this.point.y, 0, '.',
                                    ',') + '</b>'
                        },
                        distance: 20
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Realisasi',
                colorByPoint: true,
                data: {!! json_encode($dataTotalPrioritas) !!}
            }]
        });
    </script>

    <script>
        var tahun = "<?php echo $tahun; ?>";

        Highcharts.chart('container2', {
            colors: ['#1de9b6', '#1dc4e9', '#A389D4', '#899FD4', '#f44236', '#f4c22b'],
            chart: {
                type: 'pie'
            },
            credits: {
                enabled: false,
            },
            title: {
                text: 'Realisasi Berdasarkan Pilar SDGs'
            },
            tooltip: {
                enabled: false,
            },
            subtitle: {
                text: 'RKAP ' + tahun + ''
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<span>' + this.point.name +
                                '</span><br/>' + '<b>Rp' + Highcharts.numberFormat(this.point.y, 0, '.',
                                    ',') + '</b>'
                        },
                        distance: 20
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Realisasi',
                colorByPoint: true,
                data: {!! json_encode($dataTotalPilar) !!}
            }]
        });
    </script>

    <script>
        $(function() {
            var chart = Highcharts.chart('containerMonthly', {
                colors: ['#1dc4e9'],
                title: {
                    text: 'Statistik Realisasi Anggaran Per Bulan',
                },
                subtitle: {
                    text: 'RKAP ' + tahun + ''
                },
                credits: {
                    enabled: false,
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
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
                                // Cek apakah nilai adalah 0
                                if (this.point.y === 0) {
                                    return ''; // Tidak menampilkan apa pun jika nilai adalah 0
                                }

                                // Format angka jika nilai bukan 0
                                return '<b>Rp' + Highcharts.numberFormat(this.point.y, 0, '.', ',') +
                                    '</b>';
                            }
                        },
                    }
                },
                series: [{
                    name: "Total",
                    type: 'column',
                    colorByPoint: false,
                    data: [{{ $dataRealisasiBulan['januari'] + $janYKPP }},
                        {{ $dataRealisasiBulan['februari'] + $febYKPP }},
                        {{ $dataRealisasiBulan['maret'] + $marYKPP }},
                        {{ $dataRealisasiBulan['april'] + $aprYKPP }},
                        {{ $dataRealisasiBulan['mei'] + $meiYKPP }},
                        {{ $dataRealisasiBulan['juni'] + $junYKPP }},
                        {{ $dataRealisasiBulan['juli'] + $julYKPP }},
                        {{ $dataRealisasiBulan['agustus'] + $aguYKPP }},
                        {{ $dataRealisasiBulan['september'] + $sepYKPP }},
                        {{ $dataRealisasiBulan['oktober'] + $oktYKPP }},
                        {{ $dataRealisasiBulan['november'] + $novYKPP }},
                        {{ $dataRealisasiBulan['desember'] + $desYKPP }}
                    ],
                    showInLegend: false,
                }]
            });
        });
    </script>
@stop
