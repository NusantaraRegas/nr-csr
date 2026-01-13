@extends('layout.master')
@section('title', 'NR SHARE | Rekap Kelayakan Proposal')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="model-huruf-family font-bold">REKAP KELAYAKAN PROPOSAL</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb model-huruf-family">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item active">Rekap Kelayakan Proposal</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card model-huruf-family">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="model-huruf-family">
                                <h4 class="card-title model-huruf-family">Data Proposal Bantuan</h4>
                            </div>
                            <div class="ml-auto">
                                <div class="btn-group">
                                    <a href="#!" class="btn btn-success" data-target=".modalFilterTanggal"
                                        data-toggle="modal"><i class="fa fa-filter mr-2"></i>Filter</a>
                                    <button type="button"
                                        class="btn btn-success dropdown-toggle dropdown-toggle-split active"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#!">Created Today</a>
                                        <a class="dropdown-item" href="#!">Monthly</a>
                                        <a class="dropdown-item" href="#!">Annual</a>
                                        <a class="dropdown-item" href="#!" data-target=".modalFilterTanggal"
                                            data-toggle="modal">Custom Range</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('cari-kelayakan') }}">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#!" class="btn btn-sm btn-secondary"><i class="fa fa-file-text-o mr-2"></i>Export
                            Excel</a>
                        <a href="#!" target="_blank" class="btn btn-sm btn-secondary"><i
                                class="fa fa-print mr-2"></i>Print</a>
                        <hr>
                        <div class="table-responsive">
                            <table class="example5 table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="50px">No</th>
                                        <th class="text-center" width="200px">Disposisi</th>
                                        <th class="text-center" width="400px">Penerima Bantuan</th>
                                        <th class="text-center" width="150px">Jenis Proposal</th>
                                        <th class="text-center" width="250px">Wilayah</th>
                                        <th class="text-center" width="150px">Evaluasi</th>
                                        <th class="text-center" width="150px">Survei</th>
                                        <th class="text-center" width="100px">Created Date</th>
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
                                                <span class="font-weight-bold">{{ strtoupper($data->no_agenda) }}</span><br>
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
                                            </td>
                                            <td>
                                                <b class="font-weight-bold">{{ $data->asal_surat }}</b><br>
                                                <span class="text-muted">{{ $data->deskripsi }}</span>
                                            </td>
                                            <td class="text-center">{{ $data->jenis }}</td>
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
                                                    <span class="label label-megna">{{ $evaluator1->nama }}</span>
                                                    <br>
                                                    <span class="label label-megna">{{ $evaluator2->nama }}</span>
                                                @endif
                                            </td>
                                            <td nowrap>
                                                @if ($countSurvei > 0)
                                                    <?php
                                                    $survei = \App\Models\Survei::where('no_agenda', $data->no_agenda)->first();
                                                    $survei1 = \App\Models\User::where('username', $survei->survei1)->first();
                                                    $survei2 = \App\Models\User::where('username', $survei->survei2)->first();
                                                    ?>
                                                    <span class="label label-megna">{{ $survei1->nama }}</span>
                                                    <br>
                                                    <span class="label label-megna">{{ $survei2->nama }}</span>
                                                @endif
                                            </td>
                                            <td nowrap>
                                                <b class="font-weight-bold">{{ $user->nama }}</b><br>
                                                <span
                                                    class="text-muted">{{ date('d-m-Y H:i:s', strtotime($data->create_date)) }}</span>
                                            </td>
                                            <td class="text-center" nowrap>
                                                @if ($data->status == 'Draft')
                                                    <span class="badge badge-warning" style="color: black">DRAFT</span>
                                                @elseif($data->status == 'Evaluasi')
                                                    <span class="badge badge-success">EVALUASI</span>
                                                @elseif($data->status == 'Survei')
                                                    <span class="badge badge-info">SURVEI</span>
                                                @elseif($data->status == 'Approved')
                                                    <span class="badge badge-primary">APPROVED</span>
                                                @elseif($data->status == 'Rejected')
                                                    <span class="badge badge-danger">REJECTED</span>
                                                @endif
                                            </td>
                                            <td class="text-center" nowrap>
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"><i
                                                            class="fa fa-gear font-18 text-info"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        style="font-size: 13px">
                                                        <a class="dropdown-item"
                                                            href="{{ route('detail-kelayakan', encrypt($data->no_agenda)) }}">Detail
                                                            Info</a>
                                                        @if (session('user')->role == 1)
                                                            <a class="dropdown-item"
                                                                href="{{ route('ubahProposal', encrypt($data->id_kelayakan)) }}">Edit
                                                                Kelayakan</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item delete"
                                                                kelayakan-id="{{ encrypt($data->no_agenda) }}"
                                                                href="javascript:void(0)">Delete</a>
                                                        @else
                                                            @if ($data->create_by == session('user')->username)
                                                                @if ($data->status == 'Draft' or $data->status == 'Reject')
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('ubahProposal', encrypt($data->no_agenda)) }}">Edit
                                                                        Proposal</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item delete"
                                                                        kelayakan-id="{{ encrypt($data->no_agenda) }}"
                                                                        href="javascript:void(0)">Delete</a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('KelayakanController@cariPeriode') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterTanggal" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family">Filter Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Start <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="date-start" class="form-control" name="tanggal1"
                                        value="{{ old('tanggal1') }}">
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
                                    <input type="text" id="date-end" class="form-control" name="tanggal1"
                                        value="{{ old('tanggal1') }}">
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
                                id="checkBookWilayah" style="cursor: pointer">
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
                                    <option>All Kabupaten/Kota</option>
                                </select>
                                @if ($errors->has('provinsi'))
                                    <small class="text-danger">Provinsi harus
                                        diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect text-left">Search</button>
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
    </script>

    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                var provinsi_id = $(this).val();

                // $("#kabupaten").select2({
                //     placeholder: "Pilih Kabupaten"
                // });

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupaten/" + provinsi_id + "",
                    success: function(response) {
                        $('#kabupaten').html(response);
                        //$("#kabupaten").prop("disabled", false);
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
            swal("Warning", "{{ Session::get('gagalMenemukan') }}", "warning");
        @endif
    </script>
@stop
