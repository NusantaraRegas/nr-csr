@extends('layout.master')
@section('title', 'NR SHARE | Dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold">
                    <a href="{{ route('dashboard') }}" class="text-dark"><i
                            class="icon-arrow-left-circle mr-2"></i></a>DASHBOARD
                    <br>
                    <small>Anak Perusahaan</small>
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
                        <i class="icon-wallet mr-2"></i>{{ $tahun }}
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if ($jumlahAnggaranAP > 0)
                        <div class="card-body">
                            <div id="containerSubsidiary"></div>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="alert alert-danger mb-0">
                                <h4 class="model-huruf-family"><i class="fa fa-warning"></i> Warning</h4>
                                Tidak ada realisasi anggaran anak perusahaan di tahun {{ $tahun }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="containerMonthly"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('DashboardController@postOverallYear') }}">
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
@endsection

@section('footer')
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        var tahun = "<?php echo $tahun; ?>";

        $(function() {
            Highcharts.chart('containerSubsidiary', {
                chart: {
                    type: 'column'
                },
                credits: {
                    enabled: false,
                },
                title: {
                    text: 'Realisasi TJSL Anak Perusahaan',
                },
                subtitle: {
                    text: 'RKAP ' + tahun + ''
                },
                xAxis: {
                    categories: {!! json_encode($subsidiary) !!},
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                legend: {
                    reversed: true
                },
                tooltip: {
                    formatter: function() {
                        return '<span>' + this.series.name +
                            '</span><br/>' + '<b>Rp' + Highcharts.numberFormat(this.point.y, 0, '.',
                                ',') + '</b>'
                    },
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                if (this.percentage === 0) {
                                    return null; // Tidak menampilkan nilai 0
                                }
                                return Highcharts.numberFormat(this.percentage, 2) +
                                    '%'; // Menampilkan nilai dengan format persen
                            }
                        },
                        stacking: 'percent',
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function() {
                                    // Redirect ke URL
                                    var subsidiary = this
                                        .category; // Mendapatkan nama kategori (subsidiary)
                                    var year = "<?php echo $tahun; ?>"; // Tahun dari PHP

                                    // Contoh URL: /dashboard/dashboardSubsidiaryAnnual/{year}/{subsidiary}
                                    var url = '/dashboard/dashboardSubsidiaryAnnual/' + year + '/' +
                                        subsidiary;

                                    // Redirect ke URL
                                    window.location.href = url;
                                }
                            }
                        }
                    },
                },
                series: [{
                    name: 'Sisa',
                    data: {!! json_encode($sisaSubsidiary) !!},
                    color: '#f44236'

                }, {
                    name: 'Realisasi',
                    data: {!! json_encode($realisasiSubsidiary) !!},
                    color: '#1de9b6'

                }]
            });
        });
    </script>
@stop
