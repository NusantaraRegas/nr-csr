@extends('layout.master_subsidiary')
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
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-target=".modalBudgetYear"
                        data-toggle="modal"><i class="fa fa-filter mr-2"></i>Budget Year
                    </button>
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
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div id="container2" style="width: 100%; height: 300px;"></div>
                            </div>
                            <table class="table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th width="300px" style="padding: 5px 5px 5px 10px" class="font-weight-bold">
                                            Pilar
                                        </th>
                                        <th width="150px" style="text-align: center; padding: 5px 10px 5px 5px"
                                            class="font-weight-bold">Plan
                                        </th>
                                        <th width="150px" style="text-align: center; padding: 5px 10px 5px 5px"
                                            class="font-weight-bold">
                                            Realisasi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="300px" style="padding: 5px 5px 5px 10px">
                                            Sosial
                                        </td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalPlanPilarSosial, 0, ',', '.') }}</td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalActualPilarSosial, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td width="300px" style="padding: 5px 5px 5px 10px">
                                            Ekonomi
                                        </td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalPlanPilarEkonomi, 0, ',', '.') }}</td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalActualPilarEkonomi, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td width="300px" style="padding: 5px 5px 5px 10px">
                                            Lingkungan
                                        </td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalPlanPilarLingkungan, 0, ',', '.') }}</td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalActualPilarLingkungan, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div id="container1" style="width: 100%; height: 300px;"></div>
                            </div>
                            <table class="table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th width="300px" style="padding: 5px 5px 5px 10px" class="font-weight-bold">
                                            Prioritas
                                        </th>
                                        <th width="150px" style="text-align: center; padding: 5px 10px 5px 5px"
                                            class="font-weight-bold">Plan
                                        </th>
                                        <th width="150px" style="text-align: center; padding: 5px 10px 5px 5px"
                                            class="font-weight-bold">
                                            Realisasi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="300px" style="padding: 5px 5px 5px 10px">
                                            Pendidikan
                                        </td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalPlanPrioritasPendidikan, 0, ',', '.') }}</td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalActualPrioritasPendidikan, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td width="300px" style="padding: 5px 5px 5px 10px">
                                            Lingkungan
                                        </td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalPlanPrioritasLingkungan, 0, ',', '.') }}</td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalActualPrioritasLingkungan, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td width="300px" style="padding: 5px 5px 5px 10px">
                                            UMK
                                        </td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalPlanPrioritasUMK, 0, ',', '.') }}</td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalActualPrioritasUMK, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td width="300px" style="padding: 5px 5px 5px 10px">
                                            Sosial/Ekonomi
                                        </td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalPlanPrioritasSosialEkonomi, 0, ',', '.') }}</td>
                                        <td width="150px" style="text-align: right; padding: 5px 10px 5px 5px">
                                            {{ number_format($totalActualPrioritasSosialEkonomi, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
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
                                                        <a style="color: blue"
                                                            href="{{ route('indexRealisasiSubsidiaryRegion', ['provinsi' => $provinsi->provinsi, 'kabupaten' => encrypt('Semua Kabupaten/Kota'), 'year' => encrypt($tahun)]) }}">{{ $provinsi->provinsi }}</a>
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

    <form method="GET" action="{{ route('dashboardSubsidiary') }}" class="modal-content">
        <div class="modal fade modalBudgetYear" tabindex="-1" role="dialog" aria-hidden="true"
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
                                <small class="text-danger">Tahun anggaran belum dipilih</small>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="{{ route('dashboardSubsidiary') }}" class="btn btn-outline-danger">Reset</a>
                        <button type="submit" class="btn btn-info">Terapkan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script src="{{ asset('template/assets/node_modules/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/peity/jquery.peity.init.js') }}"></script>

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

    <script>
        Highcharts.chart('container1', {
            credits: {
                enabled: false,
            },
            colors: ['#1dc4e9', '#1de9b6'],
            chart: {
                type: 'column'
            },
            title: {
                style: {
                    color: '#000',
                    font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                },
                text: 'Statistik Prioritas',
            },
            subtitle: {
                style: {
                    color: '#666666',
                    font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                },
                text: 'Source: popay.pgn.co.id'
            },
            xAxis: {
                categories: [
                    'Pendidikan',
                    'Lingkungan',
                    'UMK',
                    'Sosial/Ekonomi',
                ],
                crosshair: true
            },
            yAxis: {
                //max: 100,
                title: {
                    text: ''
                }
            },
            tooltip: {
                // headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                // pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                //     '<td style="padding:0"><b>{point.y:.f}%</b></td></tr>',
                // footerFormat: '</table>',
                // shared: true,
                // useHTML: true,
                enabled: false
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.f}%'
                    }
                },
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Plan',
                data: [{{ $planPrioritasPendidikan }}, {{ $planPrioritasLingkungan }},
                    {{ $planPrioritasUMK }}, {{ $planPrioritasSosialEkonomi }}
                ]

            }, {
                name: 'Realisasi',
                data: [{{ $actualPrioritasPendidikan }}, {{ $actualPrioritasLingkungan }},
                    {{ $actualPrioritasUMK }}, {{ $actualPrioritasSosialEkonomi }}
                ]

            }]
        });
    </script>

    <script>
        Highcharts.chart('container2', {
            credits: {
                enabled: false,
            },
            colors: ['#1dc4e9', '#1de9b6'],
            chart: {
                type: 'column'
            },
            title: {
                style: {
                    color: '#000',
                    font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                },
                text: 'Statistik Pilar SDGs',
            },
            subtitle: {
                style: {
                    color: '#666666',
                    font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                },
                text: 'Tahun {{ $tahun }}'
            },
            xAxis: {
                categories: [
                    'Sosial',
                    'Ekonomi',
                    'Lingkungan',
                ],
                crosshair: true
            },
            yAxis: {
                //max: 100,
                title: {
                    text: ''
                }
            },
            tooltip: {
                // headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                // pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                //     '<td style="padding:0"><b>{point.y:.f}%</b></td></tr>',
                // footerFormat: '</table>',
                // shared: true,
                // useHTML: true,
                enabled: false,
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.f}%'
                    }
                },
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Plan',
                data: [{{ $planPilarSosial }}, {{ $planPilarEkonomi }}, {{ $planPilarLingkungan }}]

            }, {
                name: 'Realisasi',
                data: [{{ $actualPilarSosial }}, {{ $actualPilarEkonomi }}, {{ $actualPilarLingkungan }}]

            }]
        });
    </script>

    <script>
        @if (count($errors) > 0)
            toastr.error('Parameter pencarian data belum lengkap', 'Failed', {
                closeButton: true
            });
        @endif
    </script>
@stop
