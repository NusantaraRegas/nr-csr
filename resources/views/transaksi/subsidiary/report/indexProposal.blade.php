@extends('layout.master_subsidiary')
@section('title', 'PGN SHARE | Detail Realisasi')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">DETAIL REALISASI ANGGARAN CSR TAHUN {{ $tahun }}
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb model-huruf-family">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Detail Realisasi</li>
                    </ol>
                    <div class="btn-group">
                        <a href="#!" class="btn btn-info d-lg-block ml-3" data-target=".modalFilterAnnual"
                           data-toggle="modal"><i class="fa fa-filter mr-2"></i>Budget Year</a>
                        <button type="button"
                                class="btn btn-info dropdown-toggle dropdown-toggle-split active"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#!" data-target=".modalFilterMonthly"
                               data-toggle="modal">Monthly Report</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterTanggal"
                               data-toggle="modal">Custom Range</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterRegion"
                               data-toggle="modal">By Region</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterSDGs"
                            data-toggle="modal">By SDGs</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterPriority"
                            data-toggle="modal">By Priority</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('indexRealisasiSubsidiary') }}">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card model-huruf-family">
                    <div class="card-body">
                        @if($jumlahData > 0)
                            <div class="d-flex">
                                <div>
                                    <h4 class="card-title model-huruf-family mb-1">TOTAL REALISASI</h4>
                                    <h3 class="card-subtitle mb-5 text-dark font-weight-bold">{{ "Rp".number_format($total,0,',','.') }}
                                        <span class="model-huruf-family ml-2">({{ $persen."%" }})</span></h3>
                                </div>
                                <div class="ml-auto">
                                    @if($status == 'All Data')
                                        <a href="{{ route('exportRealisasiProposalSubsidiary', ['year' => $tahun, 'company' => $comp]) }}"
                                           class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-file-text-o mr-2"></i>Export
                                            Excel</a>
                                        <a href="{{ route('printRealisasiProposalSubsidiary', ['year' => $tahun, 'company' => $comp]) }}"
                                           target="_blank" class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-print mr-2"></i>Print</a>
                                    @elseif($status == 'Monthly')
                                        <a href="{{ route('exportRealisasiMonthlySubsidiary', ['bulan1' => $bulan1, 'bulan2' => $bulan2, 'year' => $tahun]) }}"
                                           class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-file-text-o mr-2"></i>Export
                                            Excel</a>
                                        <a href="{{ route('printRealisasiMonthlySubsidiary', ['bulan1' => $bulan1, 'bulan2' => $bulan2, 'year' => encrypt($tahun)]) }}"
                                           target="_blank" class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-print mr-2"></i>Print</a>
                                    @elseif($status == 'Periode')
                                        <a href="{{ route('exportRealisasiPeriodeSubsidiary', ['tanggal1' => $tanggal1, 'tanggal2' => $tanggal2, 'year' => encrypt($tahun)]) }}"
                                           class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-file-text-o mr-2"></i>Export
                                            Excel</a>
                                        <a href="{{ route('printRealisasiPeriodeSubsidiary', ['tanggal1' => $tanggal1, 'tanggal2' => $tanggal2, 'year' => encrypt($tahun)]) }}"
                                           target="_blank" class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-print mr-2"></i>Print</a>
                                    @elseif($status == 'Region')
                                        <a href="{{ route('exportRealisasiRegionSubsidiary', ['provinsi' => $provinsi, 'kabupaten' => encrypt($kabupaten), 'year' => $tahun]) }}"
                                           class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-file-text-o mr-2"></i>Export
                                            Excel</a>
                                        <a href="{{ route('printRealisasiRegionSubsidiary', ['provinsi' => $provinsi, 'kabupaten' => encrypt($kabupaten), 'year' => encrypt($tahun)]) }}"
                                           target="_blank" class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-print mr-2"></i>Print</a>
                                    @elseif($status == 'SDGs')
                                        <a href="{{ route('exportRealisasiSDGsSubsidiary', ['pilar' => $pilar, 'gols' => $gols, 'year' => $tahun]) }}"
                                           class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-file-text-o mr-2"></i>Export
                                            Excel</a>
                                        <a href="{{ route('printRealisasiSDGsSubsidiary', ['pilar' => $pilar, 'gols' => $gols, 'year' => encrypt($tahun)]) }}"
                                           target="_blank" class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-print mr-2"></i>Print</a>
                                    @elseif($status == 'Priority')
                                        <a href="{{ route('exportRealisasiPrioritySubsidiary', ['prioritas' => $prioritas, 'year' => $tahun]) }}"
                                           class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-file-text-o mr-2"></i>Export
                                            Excel</a>
                                        <a href="{{ route('printRealisasiPrioritySubsidiary', ['prioritas' => $prioritas, 'year' => encrypt($tahun)]) }}"
                                           target="_blank" class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-print mr-2"></i>Print</a>
                                    @elseif($status == 'Proker')
                                        <a href="{{ route('exportRealisasiProkerSubsidiary', $prokerID) }}"
                                           class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-file-text-o mr-2"></i>Export
                                            Excel</a>
                                        <a href="{{ route('printRealisasiProkerSubsidiary', encrypt($prokerID)) }}"
                                           target="_blank" class="btn btn-sm active btn-secondary"><i
                                                    class="fa fa-print mr-2"></i>Print</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if($jumlahData > 0)
                            <div class="table-responsive">
                                <table class="example5 table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center font-weight-bold" width="50px">No</th>
                                        <th class="text-center font-weight-bold" width="100px">Tanggal</th>
                                        <th class="text-center font-weight-bold" width="300px" nowrap>Program Kerja</th>
                                        <th class="text-center font-weight-bold" width="300px">Penerima Bantuan</th>
                                        <th class="text-center font-weight-bold" width="200px">Wilayah</th>
                                        <th class="text-center font-weight-bold" width="100px" nowrap>Jumlah (Rp)</th>
                                        <th class="text-center font-weight-bold" width="50px">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataRealisasi as $data)
                                        <tr>
                                            <td style="text-align:center;">{{ $loop->iteration }}</td>
                                            <td class="text-center"
                                                nowrap>{{ date('d-m-Y', strtotime($data->tgl_realisasi)) }}</td>
                                            <td>
                                                <span class="font-weight-bold">{{ $data->proker }}</span><br>
                                                <span>{{ $data->pilar }}</span><br>
                                                <span class="text-muted">{{ $data->gols }}</span><br>
                                                @if($data->prioritas != "")
                                                    <span class="text-danger">{{ $data->prioritas }}</span>
                                                @else
                                                    <span class="text-danger">Sosial/Ekonomi</span>
                                                @endif
                                            </td>
                                            <td>
                                                <b class="font-weight-bold text-uppercase">{{ $data->nama_yayasan }}</b><br>
                                                <span class="text-muted">{{ $data->deskripsi }}</span>
                                            </td>
                                            <td>
                                                <b class="font-weight-bold">{{ $data->provinsi }}</b><br>
                                                <span class="text-muted">{{ $data->kabupaten }}</span>
                                            </td>
                                            <td class="text-right" nowrap>
                                                {{ number_format($data->nilai_bantuan,0,',','.') }}
                                            </td>
                                            <td class="text-center" nowrap>
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)"
                                                       data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false"><i
                                                                class="fa fa-gear font-18 text-info"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         style="font-size: 13px">
                                                        <a class="dropdown-item"
                                                           href="{{ route('viewDetailRealisasiSubsidiary', encrypt($data->id_realisasi)) }}"><i
                                                                    class="fa fa-info-circle mr-2"></i>Detail
                                                            Info</a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('editNonProposalSubsidiary', encrypt($data->id_realisasi)) }}"><i
                                                                    class="fa fa-pencil mr-2"></i>Edit</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item delete"
                                                           data-id="{{ encrypt($data->id_realisasi) }}"
                                                           href="javascript:void(0)"><i class="fa fa-trash mr-2"></i>Delete</a>
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
                                Data realisasi tidak ditemukan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('ReportSubsidiaryController@postRealisasiSubsidiaryAnnual') }}">
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
                        <div class="form-group mb-0">
                            <label>Tahun <span
                                        class="text-danger">*</span></label>
                            <select class="form-control" name="tahun">
                                <option value="" disabled selected>Pilih Tahun</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                            </select>
                            @if($errors->has('tahun'))
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

    <form method="post" action="{{ action('ReportSubsidiaryController@postRealisasiSubsidiaryMonthly') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterMonthly" tabindex="-1" role="dialog" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i class="fa fa-filter mr-2"></i>Monthly
                            Report</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <label>Start <span
                                            class="text-danger">*</span></label>
                                <select class="form-control" name="bulan1">
                                    <option value=""></option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                @if($errors->has('bulan2'))
                                    <small class="text-danger mt-0">Bulan awal harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6 mb-0">
                                <label>End <span
                                            class="text-danger">*</span></label>
                                <select class="form-control" name="bulan2">
                                    <option value=""></option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                @if($errors->has('bulan2'))
                                    <small class="text-danger mt-0">Bulan akhir harus diisi</small>
                                @endif
                            </div>
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

    <form method="post" action="{{ action('ReportSubsidiaryController@postRealisasiSubsidiaryPeriode') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterTanggal" tabindex="-1" role="dialog" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i class="fa fa-filter mr-2"></i>Custom
                            Range</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row mb-0">
                            <div class="form-group col-md-6">
                                <label>Start <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="date-start"
                                           class="form-control" onchange="ubahTanggal()"
                                           name="tanggal1" value="{{ old('tanggal1') }}">
                                    <div class="input-group-append">
                                                            <span class="input-group-text"><i
                                                                        class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                @if($errors->has('tanggal1'))
                                    <small class="text-danger">Periode awal harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>End <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="date-end"
                                           class="form-control"
                                           name="tanggal2" value="{{ old('tanggal2') }}">
                                    <div class="input-group-append">
                                                            <span class="input-group-text"><i
                                                                        class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                @if($errors->has('tanggal1'))
                                    <small class="text-danger">Periode awal harus diisi</small>
                                @endif
                            </div>
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

    <form method="post" action="{{ action('ReportSubsidiaryController@postRealisasiSubsidiaryRegion') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterRegion" tabindex="-1" role="dialog" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i class="fa fa-filter mr-2"></i>By
                            Region</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                        <div class="form-group">
                            <label>Provinsi <span class="text-danger">*</span></label>
                            <select class="form-control" name="provinsi" id="provinsi">
                                <option value=""></option>
                                @foreach($dataProvinsi as $provinsi)
                                    <option value="{{ ucwords($provinsi->provinsi) }}">{{ ucwords($provinsi->provinsi) }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('provinsi'))
                                <small class="text-danger mt-0">Provinsi harus
                                    diisi</small>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <label>Kabupaten <span class="text-danger">*</span></label>
                            <select class="form-control" name="kabupaten"
                                    id="kabupaten">
                            </select>
                            @if($errors->has('kabupaten'))
                                <small class="text-danger mt-0">Kabupaten harus
                                    diisi</small>
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

    <form method="post" action="{{ action('ReportSubsidiaryController@postRealisasiSubsidiarySDGs') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterSDGs" tabindex="-1" role="dialog" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i class="fa fa-filter mr-2"></i>By
                            SDGs</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                        <div class="form-group">
                            <label>Pilar <span class="text-danger">*</span></label>
                            <select class="form-control" name="pilar" id="pilar">
                                <option value=""></option>
                                @foreach($dataPilar as $pilar)
                                    <option value="{{ $pilar->nama }}">{{ $pilar->nama }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('pilar'))
                                <small class="text-danger mt-0">Pilar harus
                                    diisi</small>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <label>Goals <span class="text-danger">*</span></label>
                            <select class="form-control" name="gols"
                                    id="gols">
                            </select>
                            @if($errors->has('gols'))
                                <small class="text-danger mt-0">Goals harus
                                    diisi</small>
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

    <form method="post" action="{{ action('ReportSubsidiaryController@postRealisasiSubsidiaryPriority') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterPriority" tabindex="-1" role="dialog" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i class="fa fa-filter mr-2"></i>By
                            Priority</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                        <div class="form-group mb-0">
                            <label>Prioritas <span class="text-danger">*</span></label>
                            <select class="form-control" name="prioritas" id="prioritas">
                                <option>{{ old('prioritas') }}</option>
                                <option>Pendidikan</option>
                                <option>Lingkungan</option>
                                <option>UMK</option>
                            </select>
                            @if($errors->has('prioritas'))
                                <small class="text-danger mt-0">Prioritas harus
                                    diisi</small>
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
        function ubahTanggal() {
            document.getElementById("date-end").value = '';
        }
    </script>

    <script>
        // Bootstrap Date Picker
        var dateMin = "01-Jan-2022";

        $('#date-end').bootstrapMaterialDatePicker({
            weekStart: 0,
            maxDate: new Date(),
            format: 'DD-MMM-YYYY',
            time: false
        });

        $('#date-start').bootstrapMaterialDatePicker({
            weekStart: 0,
            maxDate: new Date(),
            minDate: dateMin,
            format: 'DD-MMM-YYYY',
            time: false
        }).on('change', function (e, date) {
            $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#provinsi').change(function () {
                var provinsi_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupatenPencarian/" + provinsi_id + "",
                    success: function (response) {
                        $('#kabupaten').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        $(document).ready(function () {
            $('#pilar').change(function () {
                var pilar_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/anggaran/dataGolsPencarian/" + pilar_id + "",
                    success: function (response) {
                        $('#gols').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        $('.delete').click(function () {
            var data_id = $(this).attr('data-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus data realisasi ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function () {
                    window.location = "/subsidiary/realisasi/deleteRealisasi/" + data_id + "";
                });
        });
    </script>

    <script>
        @if(Session::has('gagalMenemukan'))
        toastr.error('{{Session::get('gagalMenemukan')}}', 'Failed', {closeButton: true});
        @endif

        @if (count($errors) > 0)
        toastr.error('Parameter pencarian data belum lengkap', 'Failed', {closeButton: true});
        @endif
    </script>
@stop