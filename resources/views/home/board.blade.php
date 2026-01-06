@extends('layout.master_board')
@section('title', 'PGN SHARE | Dashboard')
@section('content')
    <style>
        .model-huruf {
            font: bold 16px "Trebuchet MS", Verdana, sans-serif;
        }

        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h4 class="font-weight-bold text-uppercase">Dashboard Realisasi CSR</h4>
            </div>
        </div>
        @if($totalCostProposal > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body bg-light">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="model-huruf-family font-bold">Realisasi CSR</h3>
                                    <h5 class="font-light m-t-0 model-huruf-family">TAHUN {{ $tahun }}</h5></div>
                                <div class="col-6 align-self-center display-6 text-right">
                                    <h2 class="text-success font-bold">
                                        IDR {{ number_format($nilaiPaid,0,',','.') }}</h2></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="container1"></div>
                        </div>
                        <div class="card-body">
                            <div id="container2"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators3" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators3" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators3" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active">
                                    <img class="img-responsive" src="{{ asset('template/assets/images/big/csr3.jpg') }}"
                                         alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h3 class="text-white">SHARE</h3>
                                        <p>Sejahtera, Harmonis, Amanah, Responsif, Empati</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="img-responsive" src="{{ asset('template/assets/images/big/csr1.jpg') }}"
                                         alt="Second slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h3 class="text-white">Peningkatan Kesehatan</h3>
                                        <p>Pemberian bantuan 1 unit ambulance dari PGN untuk Yayasan Mulya Cendikia
                                            Fadillah Kab.Bekasi</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="img-responsive" src="{{ asset('template/assets/images/big/csr2.jpg') }}"
                                         alt="Third slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h3 class="text-white">Peningkatan Kesehatan</h3>
                                        <p>Pemberian bantuan 1 unit ambulance dari PGN untuk Yayasan Mulya Cendikia
                                            Fadillah Kab.Bekasi</p>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family font-bold text-uppercase">Penyaluran Hewan Qurban</h4>
                        <h6 class="card-subtitle model-huruf-family">TAHUN {{ $tahun }}</h6>
                        <div class="table-responsive">
                            <table class="table m-b-0  m-t-30 no-border">
                                <tbody>
                                <tr>
                                    <td style="width:90px;"><img
                                                src="{{ asset('template/assets/images/icon/cow.png') }}" alt="Sapi"/>
                                    </td>
                                    <td style="width:200px;">
                                        <h4 class="card-title model-huruf-family">Sapi</h4>
                                        <h6 class="card-subtitle model-huruf-family">{{ $totalProvinsiSapi }}
                                            Provinsi<br>{{ $totalKabupatenSapi }} Kabupaten/Kota</h6></td>
                                    <td class="vm">
                                        <div class="progress">
                                            <div class="progress-bar bg-purple progress-bar-striped"
                                                 style="width: {{ $persenSapi }}%; height:10px;"
                                                 role="progressbar"></div>
                                        </div>
                                        <small>{{ $persenSapi }}%</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:90px;"><img
                                                src="{{ asset('template/assets/images/icon/goat1.png') }}"
                                                alt="Kambing"/></td>
                                    <td style="width:200px;">
                                        <h4 class="card-title model-huruf-family">Kambing</h4>
                                        <h6 class="card-subtitle model-huruf-family">{{ $totalProvinsiKambing }}
                                            Provinsi<br>{{ $totalKabupatenKambing }} Kabupaten/Kota</h6></td>
                                    <td class="vm">
                                        <div class="progress">
                                            <div class="progress-bar bg-cyan progress-bar-striped"
                                                 style="width: {{ $persenKambing }}%; height:10px;"
                                                 role="progressbar"></div>
                                        </div>
                                        <small>{{ $persenKambing }}%</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <hr>
                    </div>
                    <div class="card-body mb-2">
                        <div class="row">
                            <div class="col-md-4">
                                <font class="display-5 model-huruf-family">{{ $totalSapi }}</font>
                                <h6 class="text-muted model-huruf-family">Sapi</h6></div>
                            <div class="col-md-4">
                                <font class="display-5 model-huruf-family">{{ $totalKambing }}</font>
                                <h6 class="text-muted model-huruf-family">Kambing</h6></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h4 class="font-weight-bold text-uppercase">Testimonials</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Row -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-3 col-md-6">
                        <!-- Card -->
                        <div class="card">
                            <img class="card-img-top img-responsive"
                                 src="{{ asset('template/assets/images/big/img1.jpg') }}" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                                <a href="javascript:void(0)" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                        <!-- Card -->
                    </div>
                    <!-- column -->
                    <!-- column -->
                    <div class="col-lg-3 col-md-6">
                        <!-- Card -->
                        <div class="card">
                            <img class="card-img-top img-responsive"
                                 src="{{ asset('template/assets/images/big/csr1.jpg') }}" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                                <a href="javascript:void(0)" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                        <!-- Card -->
                    </div>
                    <!-- column -->
                    <!-- column -->
                    <div class="col-lg-3 col-md-6">
                        <!-- Card -->
                        <div class="card">
                            <img class="card-img-top img-responsive"
                                 src="{{ asset('template/assets/images/big/csr2.jpg') }}" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                                <a href="javascript:void(0)" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                        <!-- Card -->
                    </div>
                    <!-- column -->
                    <!-- column -->
                    <div class="col-lg-3 col-md-6 img-responsive">
                        <!-- Card -->
                        <div class="card">
                            <img class="card-img-top img-responsive"
                                 src="{{ asset('template/assets/images/big/csr3.jpg') }}" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                                <a href="javascript:void(0)" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                        <!-- Card -->
                    </div>
                    <!-- column -->
                </div>
                <!-- Row -->
            </div>
        </div>
        <!-- End Row -->
    </div>
@endsection

@section('footer')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        function IDRFormatter(angka, prefix) {
            var number_string = angka.toString().replace(/[^,\d]/g, ' '),
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
    </script>

    <script>
        $(function () {
            var chart = Highcharts.chart('container1', {
                title: {
                    style: {
                        color: '#000',
                        font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                    },
                    text: 'REALISASI PER SEKTOR BANTUAN',
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
                    //min: 1000000,
                    title: {
                        text: 'Total Realisasi'
                    },
                    labels: {
                        formatter: function () {
                            if (this.value >= 0) {
                                return IDRFormatter(this.value)
                            } else {
                                return '-' + IDRFormatter(this.value)
                            }
                        }
                    }
                },
                xAxis: {
                    categories: {!! json_encode($dataPerSektor) !!},
                    title: {
                        text: 'SEKTOR BANTUAN'
                    },
                },
                tooltip: {
                    // pointFormatter: function () {
                    //     var value;
                    //     if (this.y >= 0) {
                    //         //value = '$ ' + this.y
                    //         value = IDRFormatter(this.y)
                    //     } else {
                    //         //value = '-$ ' + (-this.y)
                    //         value = '-' + IDRFormatter(this.y)
                    //     }
                    //     return '<span style="color: black">' + this.series.name + '</span>: <b>Rp. ' + value + '</b><br />'
                    // },
                    // shared: true,

                    enabled: false,
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            //format: '{point.y:.f}',
                            pointFormatter: function () {
                                var value;
                                if (this.y >= 0) {
                                    //value = '$ ' + this.y
                                    value = IDRFormatter(this.y)
                                } else {
                                    //value = '-$ ' + (-this.y)
                                    value = '-' + IDRFormatter(this.y)
                                }
                                return '<span style="color: black"> <b> Rp. ' + value + '</b><br />'
                            },
                        },
                    }
                },
                series: [{
                    name: "Total",
                    type: 'column',
                    colorByPoint: true,
                    data: {!! json_encode($dataPerDataSektorTotal) !!},
                    showInLegend: false,
                },
                    {
                        name: 'Bobot',
                        type: 'line',
                        data: {!! json_encode($dataPerDataSektor) !!},
                        //center: [100, 80],
                        //size: 80,
                        colorByPoint: false,
                        showInLegend: false,
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.y:.f}%</b>'
                        }
                    }]
            });
        });
    </script>

    <script>
        $(function () {
            var chart = Highcharts.chart('container2', {
                title: {
                    style: {
                        color: '#000',
                        font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                    },
                    text: 'REALISASI PER PROVINSI',
                },
                subtitle: {
                    style: {
                        color: '#666666',
                        font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                    },
                    text: 'Source: popay.pgn.co.id'
                },
                chart: {
                    inverted: true,
                    polar: false,
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
                        text: 'Total Realisasi'
                    },
                    labels: {
                        formatter: function () {
                            if (this.value >= 0) {
                                return IDRFormatter(this.value)
                            } else {
                                return '-' + IDRFormatter(this.value)
                            }
                        }
                    }
                },
                xAxis: {
                    categories: {!! json_encode($dataPerProvinsi) !!},
                    title: {
                        text: 'PROVINSI'
                    },
                },
                tooltip: {
                    pointFormatter: function () {
                        var value;
                        if (this.y >= 0) {
                            //value = '$ ' + this.y
                            value = IDRFormatter(this.y)
                        } else {
                            //value = '-$ ' + (-this.y)
                            value = '-' + IDRFormatter(this.y)
                        }
                        return '<span style="color: black">' + this.series.name + '</span>: <b>Rp. ' + value + '</b><br />'
                    },
                    shared: true
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            //format: '{point.y:.f}',
                            pointFormatter: function () {
                                var value;
                                if (this.y >= 0) {
                                    //value = '$ ' + this.y
                                    value = IDRFormatter(this.y)
                                } else {
                                    //value = '-$ ' + (-this.y)
                                    value = '-' + IDRFormatter(this.y)
                                }
                                return '<span style="color: black"> <b> Rp. ' + value + '</b><br />'
                            },
                        },
                    }
                },
                series: [{
                    name: "Total",
                    type: 'column',
                    colorByPoint: true,
                    data: {!! json_encode($dataPerDataProvinsiTotal) !!},
                    showInLegend: false,
                }]
            });
        });
    </script>
@stop

