@extends('layout.master_subsidiary')
@section('title', 'NR SHARE | Alokasi Program Kerja')

@section('content')
    <?php
    $sisa = $anggaran - $totalAlokasi;
    ?>

    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="model-huruf-family font-weight-bold">ALOKASI PROGRAM KERJA TAHUN {{ $tahun }}
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Budget Control</li>
                        <li class="breadcrumb-item active">Alokasi Program Kerja</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                            class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle mr-2"></i>Create New
                    </button>
                    <button type="button"
                            class="btn btn-secondary active ml-1 d-lg-block" data-target=".modalBudgetYear"
                            data-toggle="modal"><i class="fa fa-filter"></i>
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
                    <?php
                    $alokasiPilar = DB::table('tbl_proker')
                        ->select(DB::raw('pilar, sum(anggaran) as total'))
                        ->where('tahun', $tahun)
                        ->where('perusahaan', $comp)
                        ->groupBy('pilar')
                        ->get();

                    $alokasiPrioritas = DB::table('tbl_proker')
                        ->select(DB::raw('prioritas, sum(anggaran) as total'))
                        ->where('tahun', $tahun)
                        ->where('perusahaan', $comp)
                        ->groupBy('prioritas')
                        ->get();
                    ?>
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family mb-4">ALOKASI PROGRAM KERJA
                            @if($jumlahData > 0)
                                <button type="button" class="btn btn-xs btn-outline-info btn-rounded float-right"
                                        data-toggle="collapse"
                                        data-target="#collapsePrioritas"
                                        aria-expanded="false"
                                        aria-controls="collapsePrioritas">
                                    View Prioritas
                                </button>
                                <button type="button" class="btn btn-xs btn-outline-info btn-rounded float-right mr-1"
                                        data-toggle="collapse"
                                        data-target="#collapsePilar"
                                        aria-expanded="false"
                                        aria-controls="collapsePilar">
                                    View Pilar
                                </button>
                            @endif
                        </h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <div>
                                        <span class="pie"
                                              data-peity='{ "fill": ["#1de9b6", "#f2f2f2"]}'>{{ round($totalAlokasi / $anggaran * 100, 2) }},{{ round($sisa / $anggaran * 100, 2) }}</span>
                                            <br>
                                            <small class="text-muted">Status
                                                : {{ round($totalAlokasi / $anggaran * 100, 3)."%" }}</small>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <h3 class="counter">
                                            <b class="font-weight-bold">{{ "Rp".number_format($totalAlokasi,0,',','.') }}</b>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            @if($jumlahData > 0)
                                <div class="collapse" id="collapsePilar">
                                    <div class="col-12">
                                        <table class="table-striped mt-3" width="100%">
                                            <tbody>
                                            <tr>
                                                <td colspan="3" style="padding: 5px" class="font-weight-bold">
                                                    PILAR
                                                </td>
                                            </tr>
                                            @foreach($alokasiPilar as $ap)
                                                <tr>
                                                    <td width="300px" style="padding: 5px">{{ $ap->pilar }}</td>
                                                    <td class="text-right" width="100px"
                                                        style="padding: 5px">{{ round($ap->total / $anggaran * 100, 2)."%" }}</td>
                                                    <td width="150px"
                                                        style="text-align: right; padding: 5px">{{ number_format($ap->total,0,',','.') }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="collapse" id="collapsePrioritas">
                                    <div class="col-12">
                                        <table class="table-striped mt-3" width="100%">
                                            <tbody>
                                            <tr>
                                                <td colspan="3" style="padding: 5px" class="font-weight-bold">
                                                    PRIORITAS
                                                </td>
                                            </tr>
                                            @foreach($alokasiPrioritas as $app)
                                                <tr>
                                                    <td width="300px" style="padding: 5px">
                                                        @if($app->prioritas == "")
                                                            Sosial/Ekonomi
                                                        @else
                                                            {{ $app->prioritas }}
                                                        @endif
                                                    </td>
                                                    <td class="text-right" width="100px"
                                                        style="padding: 5px">{{ round($app->total / $anggaran * 100, 2)."%" }}</td>
                                                    <td width="150px"
                                                        style="text-align: right; padding: 5px">{{ number_format($app->total,0,',','.') }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family mb-4">BELUM TERALOKASI</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <div>
                                        <span class="pie"
                                              data-peity='{ "fill": ["#f44236", "#f2f2f2"]}'>{{ round($sisa / $anggaran * 100, 2) }},{{ round($totalAlokasi / $anggaran * 100, 2) }}</span>
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
                                    <h4 class="card-title mb-5 model-huruf-family">DAFTAR PROGRAM KERJA</h4>
                                </div>
                                @if($jumlahData > 0)
                                    <div class="ml-auto">
                                        <a href="{{ route('exportProkerSubsidiary', ["year" => $tahun, "company" => $comp]) }}"
                                           class="btn active btn-sm btn-secondary"><i
                                                    class="fa fa-file-text-o mr-2"></i>Export Excel</a>
                                        <a href="{{ route('printProkerSubsidiary', ["year" => $tahun, "company" => $comp]) }}"
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
                                            <th width="50px" class="text-center font-weight-bold" nowrap>Proker ID</th>
                                            <th width="300px" class="font-weight-bold">Program Kerja</th>
                                            <th width="300px" class="text-center font-weight-bold">SDGs</th>
                                            <th width="150px" class="text-center font-weight-bold">Anggaran (Rp)</th>
                                            <th width="300px" class="text-center font-weight-bold">Keterangan</th>
                                            <th width="50px" class="text-center font-weight-bold">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($dataProker as $data)
                                            <tr>
                                                <td class="text-center">{{ "#".$data->id_proker }}</td>
                                                <td>
                                                    <span class="font-weight-bold">{{ $data->proker }}</span>
                                                    @if($data->prioritas != "")
                                                        <br>
                                                        <span class="text-muted">{{ $data->prioritas }}</span>
                                                    @else
                                                        <br>
                                                        <span class="text-muted">Sosial/Ekonomi</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="font-weight-bold">{{ $data->pilar }}</span><br>
                                                    <span class="text-muted">{{ $data->gols }}</span>
                                                </td>
                                                <td class="text-right">{{ number_format($data->anggaran,0,',','.') }}</td>
                                                <td>
                                                    <?php
                                                    $relokasi = \App\Models\LogRelokasi::where('id_proker', $data->id_proker)->orderBy('status_date', 'ASC')->get();
                                                    $jumlahRelokasi = \App\Models\LogRelokasi::where('id_proker', $data->id_proker)->count();
                                                    ?>
                                                    @if($jumlahRelokasi > 0)
                                                        <ol class="pl-3">
                                                            @foreach($relokasi as $r)
                                                                <li>{{ $r->keterangan }}<br><small
                                                                            class="text-danger">{{ date('d-m-Y H:i:s', strtotime($r->status_date)) }}</small>
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)"
                                                           data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false"><i
                                                                    class="fa fa-gear font-18 text-info"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item edit-proker" href="#!"
                                                               data-id="{{ encrypt($data->id_proker) }}"
                                                               data-perusahaan="{{ $data->perusahaan }}"
                                                               data-proker="{{ $data->proker }}"
                                                               data-pilar="{{ $data->pilar }}"
                                                               data-gols="{{ $data->gols }}"
                                                               data-alokasi="{{ number_format($data->anggaran,0,',','.') }}"
                                                               data-tahun="{{ $data->tahun }}"
                                                               data-prioritas="{{ $data->prioritas }}"
                                                               data-target=".modal-edit" data-toggle="modal"><i
                                                                        class="fa fa-pencil mr-2"></i>Edit</a>
                                                            <a class="dropdown-item delete"
                                                               data-id="{{ encrypt($data->id_proker) }}"
                                                               href="javascript:void(0)"><i
                                                                        class="fa fa-trash mr-2"></i>Delete</a>
                                                            <div class="dropdown-divider"></div>
                                                        </div>
                                                    </div>
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

    <form method="post" action="{{ action('AnggaranSubsidiaryController@storeProker') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title model-huruf-family font-weight-bold"><b>CREATE PROGRAM KERJA</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="perusahaan" value="{{ $comp }}" readonly>
                        <div class="form-group">
                            <label>Program Kerja <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="proker" value="{{ old('proker') }}">
                            @if($errors->has('proker'))
                                <small class="text-danger">Program kerja harus diisi</small>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Pilar <span class="text-danger">*</span></label>
                                <select class="form-control" name="pilar" id="pilar2">
                                    <option value="{{ old('pilar') }}">{{ old('pilar') }}</option>
                                    @foreach($dataPilar as $pilar)
                                        <option value="{{ $pilar->nama }}">{{ $pilar->nama }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('pilar'))
                                    <small class="text-danger">Pilar harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Goals <span class="text-danger">*</span></label>
                                <select class="form-control" name="gols" id="gols2">
                                    <option value="{{ old('gols') }}">{{ old('gols') }}</option>
                                </select>
                                @if($errors->has('gols'))
                                    <small class="text-danger">Gols harus diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Anggaran <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alokasi" id="alokasi2"
                                       value="{{ old('alokasi') }}">
                                @if($errors->has('alokasi'))
                                    <small class="text-danger">Anggaran harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <select class="form-control" name="tahun">
                                    <option>{{ $tahun }}</option>
                                    <option>2022</option>
                                    <option>2023</option>
                                </select>
                                @if($errors->has('tahun'))
                                    <small class="text-danger">Tahun anggaran harus diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Prioritas</label>
                                <select class="form-control" name="prioritas">
                                    <option>{{ old('prioritas') }}</option>
                                    <option>Pendidikan</option>
                                    <option>Lingkungan</option>
                                    <option>UMK</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check-circle mr-2"></i>Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('AnggaranSubsidiaryController@updateProker') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title model-huruf-family font-weight-bold"><b>EDIT PROGRAM KERJA</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="prokerID" id="prokerID" value="{{ old('prokerID') }}">
                        <input type="hidden" class="form-control" name="perusahaan" id="perusahaan"
                               value="{{ old('perusahaan') }}" readonly>
                        <div class="form-group">
                            <label>Program Kerja <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="proker" id="proker"
                                   value="{{ old('proker') }}">
                            @if($errors->has('proker'))
                                <small class="text-danger">Program kerja harus diisi</small>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Pilar <span class="text-danger">*</span></label>
                                <select class="form-control" name="pilar" id="pilar">
                                    <option value="{{ old('pilar') }}">{{ old('pilar') }}</option>
                                    @foreach($dataPilar as $pilar)
                                        <option value="{{ $pilar->nama }}">{{ $pilar->nama }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('pilar'))
                                    <small class="text-danger">Pilar harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Goals <span class="text-danger">*</span></label>
                                <select class="form-control" name="gols" id="gols">
                                    <option value="{{ old('gols') }}">{{ old('gols') }}</option>
                                    @foreach($dataGols as $gols)
                                        <option value="{{ $gols->nama }}">{{ $gols->nama }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('gols'))
                                    <small class="text-danger">Gols harus diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Anggaran <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alokasi" id="alokasi"
                                       value="{{ old('alokasi') }}">
                                @if($errors->has('alokasi'))
                                    <small class="text-danger">Anggaran harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <select class="form-control" name="tahun" id="tahun">
                                    <option>{{ old('tahun') }}</option>
                                    <option>2022</option>
                                    <option>2023</option>
                                </select>
                                @if($errors->has('tahun'))
                                    <small class="text-danger">Tahun Anggaran harus diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Prioritas</label>
                                <select class="form-control" name="prioritas" id="prioritas">
                                    <option>{{ old('prioritas') }}</option>
                                    <option>Pendidikan</option>
                                    <option>Lingkungan</option>
                                    <option>UMK</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check-circle mr-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('AnggaranSubsidiaryController@postProkerYear') }}">
        {{ csrf_field() }}
        <div class="modal fade modalBudgetYear" tabindex="-1" role="dialog" aria-hidden="true"
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
                            <select class="form-control" name="tahun">
                                <option value="" disabled selected>Pilih Tahun</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                            </select>
                            @if($errors->has('tahun'))
                                <small class="text-danger">Tahun anggaran belum dipilih</small>
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
    <script src="{{ asset('template/assets/node_modules/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/peity/jquery.peity.init.js') }}"></script>

    <script>
        $(document).on('click', '.edit-proker', function (e) {
            document.getElementById("prokerID").value = $(this).attr('data-id');
            document.getElementById("perusahaan").value = $(this).attr('data-perusahaan');
            document.getElementById("proker").value = $(this).attr('data-proker');
            document.getElementById("pilar").value = $(this).attr('data-pilar');
            document.getElementById("gols").value = $(this).attr('data-gols');
            document.getElementById("alokasi").value = $(this).attr('data-alokasi');
            document.getElementById("tahun").value = $(this).attr('data-tahun');
            document.getElementById("prioritas").value = $(this).attr('data-prioritas');
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#pilar2').change(function () {
                var pilar_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/anggaran/dataGols/" + pilar_id + "",
                    success: function (response) {
                        $('#gols2').html(response);
                    }
                });
            })
        })

        $(document).ready(function () {
            $('#pilar').change(function () {
                var pilar_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/anggaran/dataGols/" + pilar_id + "",
                    success: function (response) {
                        $('#gols').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        $('.delete').click(function () {
            var proker_id = $(this).attr('data-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus data ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function () {
                    window.location = "/anggaran/deleteProker/" + proker_id + "";
                });
        });
    </script>

    <script>
        var alokasi2 = document.getElementById('alokasi2');
        alokasi2.addEventListener('keyup', function (e) {
            alokasi2.value = formatRupiah(this.value);
        });

        var alokasi = document.getElementById('alokasi');
        alokasi.addEventListener('keyup', function (e) {
            alokasi.value = formatRupiah(this.value);
        });

        /* Fungsi */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
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

        /* Fungsi */
        function convertToAngka(rupiah) {
            return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
        }
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop