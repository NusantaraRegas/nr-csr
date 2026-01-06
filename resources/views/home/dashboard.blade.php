@extends('layout.master')
@section('title', 'PGN SHARE | Dashboard')
@section('content')
    <style>
        .card-summary-chart {
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            /* padding: 20px; */
            transition: transform 0.3s ease;
        }

        .card-summary-penyaluran {
            border: none;
            background: #f8f9fa;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-summary-penyaluran:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }
    </style>

    @php
        $lastYear = $tahun - 1;

        $jumlahAnggaran = \App\Models\Anggaran::where('tahun', $lastYear)->count();
        $budgetLastYear = \App\Models\Anggaran::where('tahun', $lastYear)->first();

        if ($jumlahAnggaran > 0) {
            $budget = $budgetLastYear;
        } else {
            $budget = 0;
        }
    @endphp

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    DASHBOARD MONITORING ANGGARAN<br>
                    <small>{{ $perusahaan->nama_perusahaan }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <a href="{{ route('dashboard') }}" class="btn btn-danger d-none d-lg-block m-l-15"><i
                            class="fas fa-refresh mr-2"></i>Reset
                    </a>
                    <button type="button" data-toggle="modal" data-target=".modal-filter"
                        class="btn btn-info d-none d-lg-block m-l-15"><i class="fas fa-filter mr-2"></i>Filter Data
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-summary-penyaluran">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold mb-4">ANGGARAN {{ $tahun }}</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <span>
                                            <i class="ti-wallet text-info" style="font-size: 55px"></i>
                                        </span>
                                        <br>
                                        <small class="text-muted">Total</small>
                                    </div>
                                    <div class="ml-auto">
                                        <h3 class="counter">
                                            <b class="font-weight-bold"><sup><i
                                                        class="{{ $anggaran > $budget ? 'fas fa-arrow-up text-success' : 'fas fa-arrow-down text-danger' }}"></i></sup>
                                                {{ 'Rp' . number_format($anggaran, 0, ',', '.') }}
                                            </b>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a href="{{ route('indexPembayaran', ['tahun' => $tahun]) }}" class="text-dark">
                    <div class="card card-summary-penyaluran">
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold mb-4">REALISASI</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <span class="pie"
                                                data-peity='{ "fill": ["#1de9b6", "#f2f2f2"]}'>{{ round(($realisasi / $anggaran) * 100, 2) }},{{ round(($sisa / $anggaran) * 100, 2) }}</span>
                                            <br>
                                            <small class="text-muted">Status
                                                : {{ round(($realisasi / $anggaran) * 100, 3) . '%' }}</small>
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
                </a>
            </div>
            <div class="col-md-4">
                <div class="card card-summary-penyaluran">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold mb-4">SISA ANGGARAN</h4>
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
                                            @if ($sisa < 0)
                                                <b class="font-weight-bold"
                                                    style="color: red">{{ 'Rp' . number_format($sisa, 0, ',', '.') }}</b>
                                            @else
                                                <b
                                                    class="font-weight-bold">{{ 'Rp' . number_format($sisa, 0, ',', '.') }}</b>
                                            @endif
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-summary-chart">
                    <div class="card-body">
                        <div id="chartPilar" style="height: 400px; width: 100%;"></div>
                        {{-- <table class="table table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th>Pilar</th>
                                    <th>Total Anggaran</th>
                                    <th>Total Realisasi</th>
                                    <th>Selisih</th>
                                    <th>Realisasi (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportPilar as $row)
                                    <tr>
                                        <td>{{ $row['pilar'] }}</td>
                                        <td>Rp{{ number_format($row['anggaran'], 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($row['realisasi'], 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($row['selisih'], 0, ',', '.') }}</td>
                                        <td>{{ $row['persentase'] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-summary-chart">
                    <div class="card-body">
                        <div id="chartPrioritas" style="height: 400px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-summary-chart">
            <div class="card-body">
                <div id="chartBulan" style="height: 400px;"></div>
            </div>
        </div>

        <div class="card card-summary-chart">
            <div class="card-body">
                <div id="chart-anggaran-realisasi" style="height: 400px;"></div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-filter" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <form method="GET" action="{{ route('dashboard') }}" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-bold" id="filterModalLabel">Filter Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label>Tahun Anggaran</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">-- Pilih Tahun --</option>
                            @foreach ($dataAnggaran as $da)
                                <option value="{{ $da->tahun }}"
                                    {{ request('tahun') == $da->tahun ? 'selected' : '' }}>
                                    {{ $da->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-danger">Reset</a>
                    <button type="submit" class="btn btn-info">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        Highcharts.setOptions({
            lang: {
                thousandsSep: '.',
                decimalPoint: ','
            }
        });

        Highcharts.chart('chartPilar', {
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
            subtitle: {
                text: 'Tahun RKAP ' + "{{ $tahun }}"
            },
            tooltip: {
                pointFormat: '<b>{point.name}</b>: Rp{point.y:,.0f} ({point.percentage:.1f}%)',
                enabled: false,
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<b>' + this.point.name + ' (' +
                                Highcharts.numberFormat(this.percentage, 1, '.', ',') + '%)</b><br/>' +
                                'Rp' + Highcharts.numberFormat(this.y, 0, '.', ',');
                            // 'Rp' + Highcharts.numberFormat(this.y / 1000000000, 2, '.', ',') + ' M'
                        },
                        distance: 20
                    },
                    showInLegend: true,
                    point: {
                        events: {
                            click: function() {
                                if (this.url) {
                                    window.location.href = this.url;
                                }
                            }
                        }
                    }
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
        Highcharts.setOptions({
            lang: {
                thousandsSep: '.',
                decimalPoint: ','
            }
        });

        Highcharts.chart('chartPrioritas', {
            colors: ['#1de9b6', '#1dc4e9', '#A389D4', '#899FD4', '#f44236', '#f4c22b'],
            chart: {
                type: 'pie'
            },
            credits: {
                enabled: false,
            },
            title: {
                text: 'Realisasi Berdasarkan Prioritas'
            },
            subtitle: {
                text: 'Tahun RKAP ' + "{{ $tahun }}"
            },
            tooltip: {
                pointFormat: '<b>{point.name}</b>: Rp{point.y:,.0f} ({point.percentage:.1f}%)',
                enabled: false,
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<b>' + this.point.name + ' (' +
                                Highcharts.numberFormat(this.percentage, 1, '.', ',') + '%)</b><br/>' +
                                'Rp' + Highcharts.numberFormat(this.y, 0, '.', ',');
                            // 'Rp' + Highcharts.numberFormat(this.y / 1000000000, 2, '.', ',') + ' M'
                        },
                        distance: 20
                    },
                    showInLegend: true,
                    point: {
                        events: {
                            click: function() {
                                if (this.url) {
                                    window.location.href = this.url;
                                }
                            }
                        }
                    }
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
        Highcharts.setOptions({
            lang: {
                thousandsSep: '.',
                decimalPoint: ','
            }
        });

        Highcharts.chart('chartBulan', {
            chart: {
                type: 'column'
            },
            credits: {
                enabled: false,
            },
            title: {
                text: 'Realisasi Per Bulan - {{ $tahun }}'
            },
            xAxis: {
                type: 'category',
                title: {
                    text: ''
                }
            },
            yAxis: {
                title: {
                    text: ''
                },
                labels: {
                    formatter: function() {
                        return 'Rp' + Highcharts.numberFormat(this.value / 1000000000, 0, '.', ',') + ' M';
                    }
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Rp{point.y:,.0f}',
                enabled: false,
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return 'Rp' + Highcharts.numberFormat(this.y, 0, '.', ',');
                        }
                    }
                }
            },
            series: [{
                name: 'Realisasi',
                colorByPoint: true,
                data: {!! json_encode($realisasiPerBulan) !!}
            }]
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Format angka Indonesia
            Highcharts.setOptions({
                lang: {
                    thousandsSep: '.',
                    decimalPoint: ','
                }
            });

            const categories = {!! json_encode($categories) !!};
            const anggaranData = {!! json_encode($anggaranData, JSON_NUMERIC_CHECK) !!};
            const realisasiData = {!! json_encode($realisasiData, JSON_NUMERIC_CHECK) !!};

            Highcharts.chart('chart-anggaran-realisasi', {
                chart: {
                    type: 'column'
                },
                credits: {
                    enabled: false,
                },
                title: {
                    text: 'Realisasi Anak Perusahaan'
                },
                subtitle: {
                    text: 'Tahun RKAP ' + "{{ $tahun }}"
                },
                xAxis: {
                    categories: categories,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    },
                    labels: {
                        formatter: function() {
                            // HANYA sumbu-Y yang ditampilkan dalam miliar
                            const valM = this.value / 1000000000;
                            return 'Rp' + Highcharts.numberFormat(valM, 0) + ' M';
                        }
                    }
                },
                tooltip: {
                    shared: true,
                    useHTML: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                // DATA LABEL TETAP RUPIAH PENUH
                                return 'Rp ' + Highcharts.numberFormat(this.y, 0);
                            },
                            style: {
                                fontWeight: 'bold'
                            }
                        }
                    }
                },
                series: [{
                        name: 'Anggaran',
                        data: anggaranData
                    },
                    {
                        name: 'Realisasi',
                        data: realisasiData
                    }
                ]
            });
        });
    </script>
@stop
