@extends('layout.master')
@section('title', 'NR SHARE | Dashboard')
@section('content')

    <style>
        .zoom {
            /*padding: 50px;*/
            /*background-color: green;*/
            transition: transform .2s; /* Animation */
            /*width: 200px;*/
            /*height: 200px;*/
            /*margin: 0 auto;*/
        }

        .zoom:hover {
            transform: scale(1.1); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
        }
    </style>

    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h4 class="font-weight-bold text-uppercase">Dashboard Proposal
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-secondary">{{ $tahun }}</button>
                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('dashboardProposalTahun', $tahun) }}">{{ $tahun }}</a>
                            <a class="dropdown-item" href="{{ route('dashboardProposalTahun', '2018') }}">2018</a>
                            <a class="dropdown-item" href="{{ route('dashboardProposalTahun', '2019') }}">2019</a>
                            <a class="dropdown-item" href="{{ route('dashboardProposalTahun', '2020') }}">2020</a>
                            <a class="dropdown-item" href="{{ route('dashboardProposalTahun', '2021') }}">2021</a>
                        </div>
                    </div>
                </h4>
            </div>
        </div>
        <div class="row">
            <!-- Column -->
            <div class="col-md-2">
                <a href="javascript:void (0)">
                    <div class="card zoom">
                        <div class="box bg-info text-center">
                            <h1 class="font-light text-white">{{ $total }}</h1>
                            <h6 class="text-white">TOTAL</h6>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <div class="col-md-2">
                <a href="javascript:void (0)">
                    <div class="card zoom">
                        <div class="box bg-dark text-center">
                            <h1 class="font-light text-white">{{ $draft }}</h1>
                            <h6 class="text-white">DRAFT</h6>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <div class="col-md-2">
                <a href="javascript:void (0)">
                    <div class="card zoom">
                        <div class="box bg-warning text-center">
                            <h1 class="font-light text-white">{{ $evaluasi }}</h1>
                            <h6 class="text-white">EVALUASI</h6>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <div class="col-md-2">
                <a href="javascript:void (0)">
                    <div class="card zoom">
                        <div class="box bg-success text-center">
                            <h1 class="font-light text-white">{{ $survei }}</h1>
                            <h6 class="text-white">SURVEI</h6>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <div class="col-md-2">
                <a href="javascript:void (0)">
                    <div class="card zoom">
                        <div class="box bg-danger text-center">
                            <h1 class="font-light text-white">{{ $rejected }}</h1>
                            <h6 class="text-white">REJECTED</h6>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <div class="col-md-2">
                <a href="javascript:void (0)">
                    <div class="card zoom">
                        <div class="box bg-primary text-center">
                            <h1 class="font-light text-white">{{ $approved }}</h1>
                            <h6 class="text-white">APPROVED</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="row">
                <div class="col-md-8">
                    <div class="card-body">
                        <h4 class="card-title">SEKTOR BANTUAN</h4>
                        <div id="container1"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-body">
                        <h4 class="card-title">&nbsp;</h4>
                        <table width="100%" class="table-striped" style="font-family: Tahoma">
                            <tbody>
                            @foreach($dataSektor as $s)
                                <tr>
                                    <td class="pt-2 pb-2 p-l-10" width="400px">
                                        @if($s->sektor_bantuan == 'Bencana Alam dan Bencana Non Alam Termasuk Yang Disebabkan Oleh Wabah')
                                            Bencana Alam<br><small style="color: red">Termasuk yang disebabkan oleh wabah</small>
                                        @else
                                            {{ $s->sektor_bantuan }}
                                        @endif
                                    </td>
                                    <td class="pt-2 pb-2 p-r-10 text-right" width="100px">
                                        {{ $s->jumlah }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="row">
                <div class="col-md-8">
                    <div class="card-body">
                        <h4 class="card-title">JENIS PROPOSAL</h4>
                        <div id="container2"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-body">
                        <h4 class="card-title">&nbsp;</h4>
                        <table width="100%" class="table-striped" style="font-family: Tahoma">
                            <tbody>
                            @foreach($dataJenis as $j)
                                <tr>
                                    <td class="pt-2 pb-2 p-l-10" width="400px">
                                        {{ $j->jenis }}
                                    </td>
                                    <td class="pt-2 pb-2 p-r-10 text-right" width="100px">
                                        {{ $j->jumlah }}
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
@endsection

@section('footer')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        $(function () {
            Highcharts.chart('container1', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                credits: {
                    enabled: false,
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '<b>{point.y:.f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: false,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: false,
                            format: '{point.name}<br><b style="color: red">{point.y:.f}</b>'
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Status',
                    colorByPoint: true,
                    data: {!! json_encode($sektor) !!}
                }]
            });
        });
    </script>

    <script>
        $(function () {
            Highcharts.chart('container2', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                credits: {
                    enabled: false,
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '<b>{point.y:.f}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: false,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: false,
                            format: '{point.name}<br><b style="color: red">{point.y:.f}</b>'
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Status',
                    colorByPoint: true,
                    data: {!! json_encode($jenis) !!}
                }]
            });
        });
    </script>
@stop

