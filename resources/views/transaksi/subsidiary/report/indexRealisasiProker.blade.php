@extends('layout.master_subsidiary')
@section('title', 'NR SHARE | Realisasi Program Kerja')
@section('content')
    <?php
    $sisa = $anggaran - $realisasi;
    ?>

    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>
    <div class="container-fluid model-huruf-family">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">REALISASI PROGRAM KERJA TAHUN {{ $tahun }}
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Realisasi Program Kerja</li>
                    </ol>
                    <button class="btn btn-info d-lg-block ml-3" data-target=".modalFilterAnnual"
                            data-toggle="modal"><i class="fa fa-filter mr-2"></i>Budget Year
                    </button>
                </div>
            </div>
        </div>

        @if($anggaran > 0)
            <div class="card-group">
                <!-- Column -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family mb-4">ANGGARAN</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>

                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-muted">&nbsp;</span>
                                        <h3 class="counter">
                                            <b class="font-weight-bold">{{ "Rp".number_format($anggaran,0,',','.') }}</b>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family mb-4">REALISASI PROGRAM KERJA</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <div>
                                        <span class="pie"
                                              data-peity='{ "fill": ["#1de9b6", "#f2f2f2"]}'>{{ round($realisasi / $anggaran * 100, 2) }},{{ round($sisa / $anggaran * 100, 2) }}</span>
                                            <br>
                                            <small class="text-muted">Status
                                                : {{ round($realisasi / $anggaran * 100, 3)."%" }}</small>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <h3 class="counter">
                                            <b class="font-weight-bold">{{ "Rp".number_format($realisasi,0,',','.') }}</b>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family mb-4">SISA ANGGARAN</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <div>
                                        <span class="pie"
                                              data-peity='{ "fill": ["#f44236", "#f2f2f2"]}'>{{ round($sisa / $anggaran * 100, 2) }},{{ round($realisasi / $anggaran * 100, 2) }}</span>
                                            <br>
                                            <small class="text-muted">Status
                                                : {{ round($sisa / $anggaran * 100, 2)."%" }}</small>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <h3 class="counter">
                                            @if($sisa < 0)
                                                <b class="font-weight-bold"
                                                   style="color: red">{{ "Rp".number_format($sisa,0,',','.') }}</b>
                                            @else
                                                <b class="font-weight-bold">{{ "Rp".number_format($sisa,0,',','.') }}</b>
                                            @endif
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <h4 class="card-title mb-5 model-huruf-family">REALISASI PROGRAM KERJA</h4>
                                </div>
                                @if($jumlahData > 0)
                                    <div class="ml-auto">
                                        <a href="{{ route('exportRealisasiProkerAnnualSubsidiary', $tahun) }}"
                                           class="btn active btn-sm btn-secondary"><i
                                                    class="fa fa-file-text-o mr-2"></i>Export Excel</a>
                                        <a href="{{ route('printRealisasiProkerAnnualSubsidiary', encrypt($tahun)) }}"
                                           target="_blank"
                                           class="btn active btn-sm btn-secondary"><i class="fa fa-print mr-2"></i>Print</a>
                                    </div>
                                @endif
                            </div>
                            @if($jumlahData > 0)
                            <div class="table-responsive">
                                <table class="example5 table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th width="100px" class="text-center font-weight-bold" nowrap>Proker ID</th>
                                        <th width="300px" class="text-center font-weight-bold">Program Kerja</th>
                                        <th width="300px" class="text-center font-weight-bold">SDGs</th>
                                        <th width="150px" class="text-center font-weight-bold">Anggaran (Rp)</th>
                                        <th width="150px" class="text-center font-weight-bold">Realisasi (Rp)</th>
                                        <th width="150px" class="text-center font-weight-bold">Sisa (Rp)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataProker as $data)
                                        <?php
                                        $totalRealisasi = DB::table('tbl_realisasi_ap')
                                            ->select(DB::raw('SUM(nilai_bantuan) as total'))
                                            ->where('perusahaan', $comp)
                                            ->where('tahun', $tahun)
                                            ->where('id_proker', $data->id_proker)
                                            ->first();

                                        $sisa = $data->anggaran - $totalRealisasi->total;
                                        ?>
                                        <tr>
                                            <td class="text-center">{{ "#".$data->id_proker }}</td>
                                            <td>
                                                <a target="_blank"
                                                   href="{{ route('indexRealisasiSubsidiaryProker', encrypt($data->id_proker)) }}"
                                                   class="font-weight-bold" style="color: blue">{{ $data->proker }}</a>
                                                @if($data->prioritas != "")
                                                    <br>
                                                    <span class="text-muted">{{ $data->prioritas }}</span>
                                                @else
                                                    <br>
                                                    <span class="text-danger">Non Prioritas</span>
                                                @endif
                                            </td>
                                            <td nowrap>
                                                <span class="font-weight-bold">{{ $data->pilar }}</span>
                                                <br>
                                                <span class="text-muted">{{ $data->gols }}</span>
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($data->anggaran,0,',','.') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($totalRealisasi->total,0,',','.') }}
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
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <div class="alert alert-info mb-0">
                                    <h4 class="model-huruf-family"><i class="fa fa-info-circle"></i> Information</h4>
                                    Alokasi program kerja tahun {{ $tahun }} belum dibuat
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info mb-0">
                <h4 class="model-huruf-family"><i class="fa fa-info-circle"></i> Information</h4>
                Anggaran tahun {{ $tahun }} belum dibuat
            </div>
        @endif
    </div>

    <form method="post" action="{{ action('ReportSubsidiaryController@postRealisasiProkerAnnualSubsidiary') }}">
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
                        <input type="hidden" name="perusahaan" value="{{ $comp }}">
                        <div class="form-group mb-0">
                            <label>Tahun <span
                                        class="text-danger">*</span></label>
                            <select class="form-control mb-2" name="tahun">
                                <option value="">{{ old('tahun') }}</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
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
@endsection

@section('footer')
    <script>
        @if (count($errors) > 0)
        toastr.error('Parameter pencarian data belum lengkap', 'Failed', {closeButton: true});
        @endif
    </script>
@stop