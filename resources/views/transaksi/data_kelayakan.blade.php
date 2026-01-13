@extends('layout.master')
@section('title', 'NR SHARE | Laporan Kelayakan Proposal')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">KELAYAKAN PROPOSAL</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Kelayakan Proposal</li>
                    </ol>
                    <div class="btn-group">
                        <a href="#!" class="btn btn-info d-lg-block ml-3" data-target=".modalFilterTanggal"
                            data-toggle="modal"><i class="fa fa-filter mr-2"></i>Filter</a>
                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split active"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#!" data-target=".modalFilterMonthly"
                                data-toggle="modal">Monthly</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterAnnual"
                                data-toggle="modal">Annual Report</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterTanggal"
                                data-toggle="modal">Custom Range</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('dataKelayakan') }}">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title font-weight-bold">DATA REKAP KELAYAKAN
                                    PROPOSAL</h5>
                                <h6 class="card-subtitle mb-5 text-danger">{{ $keterangan }}</h6>
                            </div>
                            <div class="ml-auto">

                            </div>
                        </div>
                        @if ($jumlahData > 0)
                            {{--                            <a href="#!" class="btn btn-sm btn-secondary"><i class="fa fa-file-text-o mr-2"></i>Export Excel</a> --}}
                            {{--                            <a href="#!" class="btn btn-sm btn-secondary"><i class="fa fa-print mr-2"></i>Print</a> --}}
                            {{--                            <hr> --}}
                            <div class="table-responsive">
                                <table class="example5 table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="50px">No</th>
                                            <th class="text-center" width="200px">Disposisi</th>
                                            <th class="text-center" width="400px">Penerima Bantuan</th>
                                            <th class="text-center" width="200px">SDGs</th>
                                            <th class="text-center" width="200px">Wilayah</th>
                                            <th class="text-center" width="150px">Evaluasi</th>
                                            <th class="text-center" width="150px">Survei</th>
                                            <th class="text-center" width="100px">Jenis</th>
                                            <th class="text-center" width="100px">Status</th>
                                            <th class="text-center" width="50px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataKelayakan as $data)
                                            <?php
                                            $countEvaluasi = \App\Models\Evaluasi::where('no_agenda', $data->no_agenda)->count();
                                            $countSurvei = \App\Models\Survei::where('no_agenda', $data->no_agenda)->count();
                                            $user = \App\Models\User::where('username', $data->create_by)->first();
                                            ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                                <td nowrap>
                                                    <span
                                                        class="font-weight-bold">{{ strtoupper($data->no_agenda) }}</span><br>
                                                    <span class="text-muted">{{ $data->pengirim }}</span><br>
                                                    <span
                                                        class="text-muted">{{ \App\Http\Controllers\tanggal_indo(date('Y-m-d', strtotime($data->tgl_terima))) }}</span>
                                                    <br>
                                                    @if ($data->sifat == 'Biasa')
                                                        <span class="badge badge-success">Biasa</span>
                                                    @elseif($data->sifat == 'Segera')
                                                        <span class="badge badge-warning" style="color: black">Segera</span>
                                                    @elseif($data->sifat == 'Amat Segera')
                                                        <span class="badge badge-danger">Amat Segera</span>
                                                    @endif
                                                    @if ($data->ykpp == 'Yes')
                                                        <br>
                                                        <small>
                                                            <i class="fa fa-check-circle text-success mr-1"></i>YKPP
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <b
                                                        class="font-weight-bold text-uppercase">{{ $data->asal_surat }}</b><br>
                                                    <span class="text-muted">{{ $data->deskripsi }}</span>
                                                </td>
                                                <td>
                                                    <b class="font-weight-bold">{{ $data->pilar }}</b><br>
                                                    <span class="text-muted">{{ $data->tpb }}</span>
                                                </td>
                                                <td>
                                                    <b class="font-weight-bold">{{ $data->provinsi }}</b><br>
                                                    <span class="text-muted">{{ $data->kabupaten }}</span>
                                                </td>
                                                <td nowrap>
                                                    @if ($countEvaluasi > 0)
                                                        <?php
                                                        $evaluasi = \App\Models\Evaluasi::where('no_agenda', $data->no_agenda)->first();
                                                        $evaluator1 = \App\Models\User::where('username', $evaluasi->evaluator1)->first();
                                                        $evaluator2 = \App\Models\User::where('username', $evaluasi->evaluator2)->first();
                                                        ?>
                                                        <span
                                                            class="label label-megna font-12">{{ $evaluator1->nama }}</span>
                                                        <br>
                                                        <span
                                                            class="label label-megna font-12">{{ $evaluator2->nama }}</span>
                                                    @endif
                                                </td>
                                                <td nowrap>
                                                    @if ($countSurvei > 0)
                                                        <?php
                                                        $survei = \App\Models\Survei::where('no_agenda', $data->no_agenda)->first();
                                                        $survei1 = \App\Models\User::where('username', $survei->survei1)->first();
                                                        $survei2 = \App\Models\User::where('username', $survei->survei2)->first();
                                                        ?>
                                                        <span class="label label-megna font-12">{{ $survei1->nama }}</span>
                                                        <br>
                                                        <span class="label label-megna font-12">{{ $survei2->nama }}</span>
                                                    @endif
                                                </td>
                                                <td nowrap>{{ $data->jenis }}</td>
                                                <td nowrap>
                                                    @if ($data->status == 'Draft')
                                                        <span class="badge badge-warning" style="color: black">DRAFT</span>
                                                    @elseif($data->status == 'Evaluasi')
                                                        <span class="badge badge-success">EVALUASI PROPOSAL</span>
                                                    @elseif($data->status == 'Survei')
                                                        <span class="badge badge-info">SURVEI PROPOSAL</span>
                                                    @elseif($data->status == 'Approved')
                                                        <span class="badge badge-primary">APPROVED</span>
                                                    @elseif($data->status == 'Rejected')
                                                        <span class="badge badge-danger">REJECTED</span>
                                                    @endif
                                                    <br>
                                                    {{ $user->nama }}
                                                    <br>
                                                    <span
                                                        class="text-muted">{{ date('d-m-Y H:i:s', strtotime($data->create_date)) }}</span>
                                                </td>
                                                <td class="text-center" nowrap>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"><i
                                                                class="fa fa-gear font-18 text-info"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            style="font-size: 13px">
                                                            <a class="dropdown-item"
                                                                href="{{ route('detail-kelayakan', encrypt($data->no_agenda)) }}"><i
                                                                    class="icon-info mr-2"></i>View Detail</a>
                                                            @if ($data->create_by == session('user')->username)
                                                                @if ($data->ykpp == '')
                                                                    @if ($data->status == 'Approved')
                                                                        <a class="dropdown-item checklistYKPP"
                                                                            kelayakan-id="{{ encrypt($data->id_kelayakan) }}"
                                                                            data-target=".modalYKPP" data-toggle="modal"
                                                                            href="javascript:void(0)">
                                                                            <i class="icon-check mr-2"></i>Checklist YKPP
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                            @if (in_array(session('user')->role, ['Admin']))
                                                                @if (session('user')->role == 'Admin')
                                                                    @if (in_array($data->status, ['Draft', 'Evaluasi']))
                                                                        @if ($countEvaluasi == 0)
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('input-evaluasi', encrypt($data->no_agenda)) }}"><i
                                                                                    class="icon-plus mr-2"></i>Create
                                                                                Evaluasi</a>
                                                                        @endif
                                                                    @endif
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('ubahProposal', encrypt($data->id_kelayakan)) }}"><i
                                                                            class="icon-note mr-2"></i>Edit</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item delete"
                                                                        kelayakan-id="{{ encrypt($data->no_agenda) }}"
                                                                        href="javascript:void(0)"><i
                                                                            class="icon-trash mr-2"></i>Delete</a>
                                                                @endif
                                                            @else
                                                                @if ($data->create_by == session('user')->username)
                                                                    @if ($data->status == 'Draft' or $data->status == 'Reject')
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('ubahProposal', encrypt($data->no_agenda)) }}"><i
                                                                                class="icon-note mr-2"></i>Edit</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item delete"
                                                                            kelayakan-id="{{ encrypt($data->no_agenda) }}"
                                                                            href="javascript:void(0)"><i
                                                                                class="icon-trash mr-2"></i>Delete</a>
                                                                    @endif
                                                                @endif
                                                            @endif
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
                                <h3 class="text-info"><i class="fa fa-info-circle"></i> Information
                                </h3> Tidak ada data yang ditampilkan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('KelayakanController@checklistYKPP') }}">
        {{ csrf_field() }}
        <div class="modal fade modalYKPP" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">
                            CHECKLIST YKPP
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="kelayakanID" id="kelayakanID">
                        <div class="form-group mb-0">
                            <label>Budget Year <span class="text-danger">*</span></label>
                            <select class="form-control mb-2" name="tahun">
                                <option></option>
                                @for ($thn = 2023; $thn <= date('Y'); $thn++)
                                    <option>{{ $thn }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('tahun'))
                                <small class="text-danger mt-0">Tahun anggaran harus
                                    diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect text-left"><i
                                class="fa fa-check-circle mr-2"></i>Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('KelayakanController@cariPeriode') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterTanggal" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold"><i class="fa fa-filter mr-2"></i>Custom
                            Range</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Start <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="date-start" class="form-control" onchange="ubahTanggal()"
                                        name="tanggal1" value="{{ old('tanggal1') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                @if ($errors->has('tanggal1'))
                                    <small class="text-danger">Periode awal harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>End <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="date-end" class="form-control" name="tanggal2"
                                        value="{{ old('tanggal2') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                @if ($errors->has('tanggal1'))
                                    <small class="text-danger">Periode awal harus diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input openWilayah" onchange="openWilayah()"
                                id="checkBookWilayah" name="checkBookWilayah" style="cursor: pointer">
                            <label class="custom-control-label" for="checkBookWilayah"
                                style="cursor: pointer">Wilayah</label>
                        </div>
                        <div class="wilayah" style="display: none">
                            <div class="form-group">
                                <label>Provinsi <span class="text-danger">*</span></label>
                                <select class="form-control mb-2" name="provinsi" id="provinsi">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach ($dataProvinsi as $provinsi)
                                        <option value="{{ ucwords($provinsi->provinsi) }}">
                                            {{ ucwords($provinsi->provinsi) }}</option>
                                    @endforeach
                                </select>
                                <select class="form-control" name="kabupaten" id="kabupaten">
                                </select>
                                @if ($errors->has('provinsi'))
                                    <small class="text-danger mt-0">Wilayah harus
                                        diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input openPilar" onchange="openPilar()"
                                id="checkBookPilar" name="checkBookPilar" style="cursor: pointer">
                            <label class="custom-control-label" for="checkBookPilar" style="cursor: pointer">SDGs</label>
                        </div>
                        <div class="pilar" style="display: none">
                            <div class="form-group">
                                <label>Pilar <span class="text-danger">*</span></label>
                                <select class="form-control mb-2" name="pilar" id="pilar">
                                    <option value="" disabled selected>Pilih Pilar</option>
                                    @foreach ($dataPilar as $pilar)
                                        <option value="{{ $pilar->nama }}">{{ $pilar->nama }}</option>
                                    @endforeach
                                </select>
                                <select class="form-control" name="gols" id="gols">
                                </select>
                                @if ($errors->has('pilar'))
                                    <small class="text-danger mt-0">SDGs harus diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input openJenis" onchange="openJenis()"
                                id="checkBookJenis" name="checkBookJenis" style="cursor: pointer">
                            <label class="custom-control-label" for="checkBookJenis"
                                style="cursor: pointer">Jenis</label>
                        </div>
                        <div class="jenis" style="display: none">
                            <div class="form-group">
                                <label>Jenis Proposal <span class="text-danger">*</span></label>
                                <select class="form-control" name="jenis">
                                    <option value="" disabled selected>Pilih Jenis Proposal</option>
                                    <option value="Bulanan">Bulanan</option>
                                    <option value="Santunan">Santunan</option>
                                    <option value="Idul Adha">Idul Adha</option>
                                    <option value="Natal">Natal</option>
                                    <option value="Aspirasi">Aspirasi</option>
                                </select>
                                @if ($errors->has('jenis'))
                                    <small class="text-danger mt-0">Jenis proposal harus diisi</small>
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

    <form method="post" action="{{ action('KelayakanController@cariBulan') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterMonthly" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold"><i class="fa fa-filter mr-2"></i>Monthly
                            Report</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label>Bulan <span class="text-danger">*</span></label>
                                <select class="form-control mb-2" name="bulan">
                                    <option value="" disabled selected>Pilih Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                @if ($errors->has('bulan'))
                                    <small class="text-danger mt-0">Bulan penerimaan harus
                                        diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <select class="form-control mb-2" name="tahun">
                                    <option value="" disabled selected>Pilih Tahun</option>
                                    @for ($thn = 2023; $thn <= date('Y'); $thn++)
                                        <option value="{{ $thn }}">{{ $thn }}</option>
                                    @endfor
                                </select>
                                @if ($errors->has('tahun'))
                                    <small class="text-danger mt-0">Tahun penerimaan harus
                                        diisi</small>
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

    <form method="post" action="{{ action('KelayakanController@cariTahun') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterAnnual" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold"><i class="fa fa-filter mr-2"></i>Monthly
                            Report</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tahun <span class="text-danger">*</span></label>
                            <select class="form-control mb-2" name="tahun">
                                <option value="" disabled selected>Pilih Tahun</option>
                                @for ($thn = 2023; $thn <= date('Y'); $thn++)
                                    <option value="{{ $thn }}">{{ $thn }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('tahun'))
                                <small class="text-danger mt-0">Tahun penerimaan harus
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
        function openWilayah() {
            if ($('.openWilayah').is(":checked")) {
                $(".wilayah").show();
            } else {
                $(".wilayah").hide();
            }
        }

        function openPilar() {
            if ($('.openPilar').is(":checked")) {
                $(".pilar").show();
            } else {
                $(".pilar").hide();
            }
        }

        function openJenis() {
            if ($('.openJenis').is(":checked")) {
                $(".jenis").show();
            } else {
                $(".jenis").hide();
            }
        }
    </script>

    <script>
        function ubahTanggal() {
            document.getElementById("date-end").value = '';
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                var provinsi_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupatenPencarian/" + provinsi_id + "",
                    success: function(response) {
                        $('#kabupaten').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#pilar').change(function() {
                var pilar_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/anggaran/dataGols/" + pilar_id + "",
                    success: function(response) {
                        $('#gols').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        $(document).ready(function() {
            $("#sektor").select2({
                placeholder: "Pilih Sektor Bantuan"
            });

            $("#tahun").select2({
                placeholder: "Pilih Tahun"
            });

            $("#jenisProposal").select2({
                placeholder: "Pilih Jenis Proposal"
            });
        });
    </script>

    <script>
        $(document).on('click', '.checklistYKPP', function(e) {
            document.getElementById("kelayakanID").value = $(this).attr('kelayakan-id');
        });
    </script>

    {{--    <script> --}}
    {{--        $('.checklistYKPP').click(function () { --}}
    {{--            var data_id = $(this).attr('kelayakan-id'); --}}
    {{--            swal({ --}}
    {{--                    title: "Yakin?", --}}
    {{--                    text: "Anda akan menambahkan proposal ini ke daftar YKPP", --}}
    {{--                    type: "warning", --}}
    {{--                    showCancelButton: true, --}}
    {{--                    confirmButtonClass: "btn-info", --}}
    {{--                    cancelButtonClass: "btn-secondary", --}}
    {{--                    confirmButtonText: "Yes", --}}
    {{--                    closeOnConfirm: false --}}
    {{--                }, --}}
    {{--                function () { --}}
    {{--                    window.location = "/report/checklistYKPP/" + data_id + ""; --}}
    {{--                }); --}}
    {{--        }); --}}
    {{--    </script> --}}

    <script>
        $('.unchecklistYKPP').click(function() {
            var data_id = $(this).attr('kelayakan-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus proposal ini dari daftar YKPP",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "unchecklistYKPP/" + data_id + "";
                });
        });
    </script>

    <script>
        $('.delete').click(function() {
            var data_id = $(this).attr('kelayakan-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus proposal ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "delete-kelayakan/" + data_id + "";
                });
        });
    </script>

    <script>
        @if (Session::has('gagalMenemukan'))
            toastr.error('{{ Session::get('gagalMenemukan') }}', 'Failed', {
                closeButton: true
            });
        @endif

        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
