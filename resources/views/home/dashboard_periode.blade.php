@extends('layout.master')
@section('title', 'PGN SHARE | Home')
@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h4 class="text-themecolor text-uppercase">Dashboard Realisasi
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-secondary">Budget Year</button>
                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('dashboard-tahun', $tahun) }}">{{ $tahun }}</a>
                            <a class="dropdown-item" href="{{ route('dashboard-tahun', '2018') }}">2018</a>
                            <a class="dropdown-item" href="{{ route('dashboard-tahun', '2019') }}">2019</a>
                            <a class="dropdown-item" href="{{ route('dashboard-tahun', '2020') }}">2020</a>
                            <a class="dropdown-item" href="{{ route('dashboard-tahun', '2021') }}">2021</a>
                        </div>
                    </div>
{{--                    <button type="submit" class="btn btn-primary pull-right" data-toggle="collapse"--}}
{{--                            data-target="#pencarian" aria-expanded="false"--}}
{{--                            aria-controls="pencarian"><i class="fa fa-search"></i>--}}
{{--                        Search--}}
{{--                    </button>--}}
                </h4>
            </div>
        </div>
        <div class="collapse" id="pencarian">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">REALISASI PEMBAYARAN</h4>
                            <h6 class="card-subtitle font-12" style="color: red; font-family: Tahoma">Pencarian data
                                berdasarkan periode tanggal invoice</h6>
                            <br>
                            <form method="post" action="{{ action('DashboardController@inputPeriode') }}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-xl-3 col-md-12 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Tanggal Awal</label>
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control datepicker-autoclose text-uppercase"
                                                       name="tanggal1" value="{{ $tanggal1 }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                            @if($errors->has('tanggal1'))
                                                <small class="text-danger">Tanggal awal belum diisi</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-12 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Tanggal Akhir</label>
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control datepicker-autoclose text-uppercase"
                                                       name="tanggal2" value="{{ $tanggal2 }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                            @if($errors->has('tanggal2'))
                                                <small class="text-danger">Tanggal akhir belum diisi</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>&nbsp;</label><br>
                                            <button type="submit" class="btn btn-success">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Column -->
            <div class="col-md-4">
                <div class="card">
                    <div class="box bg-info text-center">
                        <h2 class="font-light text-white" style="font-family: Tahoma;">
                            IDR {{ number_format($anggaran,0,',','.') }}</h2>
                        <h5 class="text-white" style="font-family: Tahoma">TOTAL ANGGARAN</h5>
                        <h3 class="text-white" style="font-family: Tahoma">
                            {{ round($anggaran / $anggaran * 100, 2) }}%
                        </h3>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-4">
                <div class="card">
                    <div class="box bg-success text-center">
                        @if($totalProposal->total > 0)
                            <h2 class="font-light text-white" style="font-family: Tahoma">
                                IDR {{ number_format($totalProposal->total,0,',','.') }}
                            </h2>
                        @else
                            <h2 class="font-light text-white" style="font-family: Tahoma">
                                IDR 0
                            </h2>
                        @endif
                        <h5 class="text-white" style="font-family: Tahoma">TOTAL REALISASI</h5>
                        <h3 class="text-white" style="font-family: Tahoma">
                            {{ round($totalProposal->total / $anggaran * 100, 2) }}%
                        </h3>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-4">
                <div class="card">
                    <div class="box bg-danger text-center">
                        @if($totalProposal->total > 0)
                            <?php
                            $sisa = $anggaran - $totalProposal->total;
                            ?>
                            <h2 class="font-light text-white" style="font-family: Tahoma">
                                IDR {{ number_format($sisa,0,',','.') }}
                            </h2>
                        @else
                            <h2 class="font-light text-white" style="font-family: Tahoma">
                                IDR {{ number_format($anggaran,0,',','.') }}
                            </h2>
                        @endif
                        <h5 class="text-white" style="font-family: Tahoma">SISA ANGGARAN</h5>
                        <h3 class="text-white" style="font-family: Tahoma">
                            {{ round(($anggaran - $totalProposal->total) / $anggaran * 100, 2) }}%
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Column -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="container1" style="min-width: 310px; height: 362px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-b-0">
                        <h4 class="card-title">STATUS PEMBAYARAN</h4>
                        <h6 class="card-subtitle font-12" style="color: red; font-family: Tahoma">Realisasi anggaran
                            periode {{ $tahun }}</h6>
                    </div>
                    <table class="table table-striped m-b-0" width="10%">
                        <tbody>
                        <tr>
                            <th class="pt-3 pb-3">
                                DRAFT
                            </th>
                            <td class="pt-3 pb-3 text-right">
                                <span class="badge badge-pill font-12 text-white"
                                      style="background-color: #4B515D">{{ number_format($nilaiDraft,0,',','.') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="pt-3 pb-3">
                                ON PROGRESS
                            </th>
                            <td class="pt-3 pb-3 text-right">
                                <span class="badge badge-pill font-12 text-white"
                                      style="background-color: #ffbb33">{{ number_format($nilaiOnProgress,0,',','.') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="pt-3 pb-3">
                                REJECTED
                            </th>
                            <td class="pt-3 pb-3 text-right">
                                <span class="badge badge-pill font-12 text-white"
                                      style="background-color: #ff4444">{{ number_format($nilaiRejected,0,',','.') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="pt-3 pb-3">
                                RELEASED
                            </th>
                            <td class="pt-3 pb-3 text-right">
                                <span class="badge badge-pill font-12 text-white"
                                      style="background-color: #33b5e5">{{ number_format($nilaiReleased,0,',','.') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="pt-3 pb-3">
                                PAID
                            </th>
                            <td class="pt-3 pb-3 text-right">
                                <span class="badge badge-pill font-12 text-white"
                                      style="background-color: #00C851">{{ number_format($nilaiPaid,0,',','.') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="pt-3 pb-3">
                                TOTAL PEMBAYARAN
                            </th>
                            <td class="pt-3 pb-3 text-right">
                                <span class="badge badge-pill font-12 text-white"
                                      style="background-color: #aa66cc">{{ number_format($nominalStatus->total,0,',','.') }}</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Column -->
        </div>

        @if($totalProposal->total > 0)
            <div class="row">
                <!-- Column -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div id="container2" style="min-width: 310px; height: 500px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body p-b-0">
                            <h4 class="card-title">SEKTOR BANTUAN</h4>
                            <h6 class="card-subtitle font-12" style="color: red; font-family: Tahoma">Total sektor
                                bantuan
                                periode {{ $tahun }}</h6>
                        </div>
                        <table class="table table-striped m-b-0" width="10%">
                            <tbody>
                            <tr>
                                <th class="pt-3 pb-3">
                                    Korban Bencana Alam
                                </th>
                                <td class="pt-3 pb-3 text-right">
                                    <span class="badge badge-danger badge-pill font-12">{{ number_format($nilaiSektor1,0,',','.') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="pt-3 pb-3">
                                    Pendidikan dan/atau Pelatihan
                                </th>
                                <td class="pt-3 pb-3 text-right">
                                    <span class="badge badge-danger badge-pill font-12">{{ number_format($nilaiSektor2,0,',','.') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="pt-3 pb-3">
                                    Peningkatan Kesehatan
                                </th>
                                <td class="pt-3 pb-3 text-right">
                                    <span class="badge badge-danger badge-pill font-12">{{ number_format($nilaiSektor3,0,',','.') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="pt-3 pb-3">
                                    Pengembangan Prasarana dan/atau Sarana Umum
                                </th>
                                <td class="pt-3 pb-3 text-right">
                                    <span class="badge badge-danger badge-pill font-12">{{ number_format($nilaiSektor4,0,',','.') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="pt-3 pb-3">
                                    Sarana Ibadah
                                </th>
                                <td class="pt-3 pb-3 text-right">
                                    <span class="badge badge-danger badge-pill font-12">{{ number_format($nilaiSektor5,0,',','.') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="pt-3 pb-3">
                                    Pelestarian Alam
                                </th>
                                <td class="pt-3 pb-3 text-right">
                                    <span class="badge badge-danger badge-pill font-12">{{ number_format($nilaiSektor6,0,',','.') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="pt-3 pb-3">
                                    Pengentasan Kemiskinan
                                </th>
                                <td class="pt-3 pb-3 text-right">
                                    <span class="badge badge-danger badge-pill font-12">{{ number_format($nilaiSektor7,0,',','.') }}</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <!-- Column -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="container3" style="min-width: 310px; height: 610px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-b-0">
                        <h4 class="card-title">NOMINAL PROPOSAL</h4>
                        <h6 class="card-subtitle font-12" style="color: red; font-family: Tahoma">Jumlah proposal
                            periode {{ $tahun }}</h6>
                    </div>
                    <table class="table table-striped m-b-0" width="10%">
                        <tbody>
                        @foreach($nominalProposal as $sponsor)
                            <tr>
                                <th class="pt-3 pb-3">
                                    @if($sponsor->bulan == "01")
                                        Januari
                                    @elseif($sponsor->bulan == "02")
                                        Pebruari
                                    @elseif($sponsor->bulan == "03")
                                        Maret
                                    @elseif($sponsor->bulan == "04")
                                        April
                                    @elseif($sponsor->bulan == "05")
                                        Mei
                                    @elseif($sponsor->bulan == "06")
                                        Juni
                                    @elseif($sponsor->bulan == "07")
                                        Juli
                                    @elseif($sponsor->bulan == "08")
                                        Agustus
                                    @elseif($sponsor->bulan == "09")
                                        September
                                    @elseif($sponsor->bulan == "10")
                                        Oktober
                                    @elseif($sponsor->bulan == "11")
                                        November
                                    @elseif($sponsor->bulan == "12")
                                        Desember
                                    @endif
                                </th>
                                <td class="pt-3 pb-3 text-right">
                                    <span class="badge badge-info badge-pill font-12">{{ number_format($sponsor->jumlah,0,',','.') }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Column -->
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $('.delete').click(function () {
            var kelayakan_id = $(this).attr('kelayakan-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus proposal ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function () {
                    window.location = "/report/delete-kelayakan/" + kelayakan_id + "";
                });
        });
    </script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <script>
        $(function () {
            Highcharts.setOptions({
                colors: ['#4B515D', '#ffbb33', '#ff4444', '#33b5e5', '#00C851']
            });
            var chart = Highcharts.chart('container1', {
                title: {
                    text: 'PROGRESS PEMBAYARAN'
                },
                subtitle: {
                    text: 'Periode {{ $tahun }}'
                },
                chart: {
                    inverted: true,
                },
                credits: {
                    enabled: false,
                },
                yAxis: {
                    max: 100,
                    title: {
                        text: ''
                    }
                },
                xAxis: {
                    categories: ['DRAFT', 'ON PROGRESS', 'REJECTED', 'RELEASED', 'PAID']
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
                    name: "Value",
                    type: 'column',
                    colorByPoint: true,
                    data: [{{ $persenDraft }},{{ $persenOnProgress }},{{ $persenRejected }},{{ $persenReleased }},{{ $persenPaid }}],
                    showInLegend: false,
                }]
            });
        });
    </script>

    <script>
        Highcharts.chart('container2', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            credits: {
                enabled: false,
            },
            title: {
                text: 'PERSENTASE SEKTOR BANTUAN (PAID)'
            },
            subtitle: {
                text: 'Periode {{ $tahun }}'
            },
            tooltip: {
                pointFormat: '<b>{point.y:.f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: false,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}<br><b>{point.y:.f}%</b>'
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Sektor',
                colorByPoint: true,
                data: [{
                    name: 'Korban Bencana Alam',
                    y: {{ $persenSektor1 }},
                    color: '#ff4444',
                }, {
                    name: 'Pelestarian Alam',
                    y: {{ $persenSektor2 }},
                    color: '#ffbb33',
                }, {
                    name: 'Pendidikan Dan/atau Pelatihan',
                    y: {{ $persenSektor3 }},
                    color: '#00C851',
                }, {
                    name: 'Pengembangan Prasarana Dan/atau Sarana Umum',
                    y: {{ $persenSektor4 }},
                    color: '#33b5e5',
                }, {
                    name: 'Pengentasan Kemiskinan',
                    y: {{ $persenSektor5 }},
                    color: '#2BBBAD',
                }, {
                    name: 'Peningkatan Kesehatan',
                    y: {{ $persenSektor6 }},
                    color: '#4285F4',
                }, {
                    name: 'Sarana Ibadah',
                    y: {{ $persenSektor7 }},
                    color: '#aa66cc',
                }]
            }]
        });
    </script>

    <script>
        var chart = Highcharts.chart('container3', {
            title: {
                text: 'GRAFIK PROPOSAL PER BULAN'
            },
            subtitle: {
                text: 'Periode {{ $tahun }}'
            },
            chart: {
                inverted: false,
            },
            credits: {
                enabled: false,
            },
            xAxis: {
                categories: {!! json_encode($dataBulan) !!}
            },
            yAxis: {
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<b>{point.y:.f}</b>'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.f}'
                    }
                }
            },
            series: [{
                type: 'column',
                name: 'Jumlah',
                colorByPoint: true,
                data: {!! json_encode($dataJumlah) !!},
                showInLegend: false
            }]

        });
    </script>
@stop

