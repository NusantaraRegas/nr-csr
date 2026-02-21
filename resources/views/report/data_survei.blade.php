@extends('layout.master')
@section('title', 'SHARE | Kelayakan Proposal')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase">Survei Proposal</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Survei Proposal</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Survei</h4>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="10px" style="text-align:center;">No</th>
                                        <th width="200px">No Agenda</th>
                                        <th width="200px">Proposal Dari</th>
                                        <th width="200px">Bantuan Untuk</th>
                                        <th width="100px">Nilai Bantuan</th>
                                        <th width="150px">Surveyor</th>
                                        <th width="100px">Status</th>
                                        <th width="200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataSurvei as $data)
                                        <tr>
                                            <td style="text-align:center;">{{ $loop->iteration }}</td>
                                            <td><a data-toggle="tooltip" data-placement="bottom" title="Form Survei"
                                                    target="_blank"
                                                    href="{{ route('form-survei', $data->id_kelayakan) }}">{{ $data->no_agenda }}</a>
                                                <br>
                                                <a href="{{ route('data-lampiran', encrypt($data->no_agenda)) }}"
                                                    class="badge badge-info">Lampiran</a>
                                            </td>
                                            <td>{{ $data->asal_surat }}</td>
                                            <td>{{ $data->bantuan_untuk }}</td>
                                            <td>{{ number_format($data->nilai_bantuan, 0, ',', '.') }}</td>
                                            <td>
                                                <ol class="pull-left">
                                                    <li>{{ $data->survei1 }}</li>
                                                    <li>{{ $data->survei2 }}</li>
                                                </ol>
                                            </td>
                                            <td>
                                                @if ($data->status == 'Draft')
                                                    <span class="badge badge-info">DRAFT</span>
                                                @elseif($data->status == 'Forward')
                                                    <span class="badge badge-primary text-white">Forward</span>
                                                @elseif($data->status == 'Approved 1')
                                                    <span class="badge badge-success text-white">Disetujui Surveyor 2</span>
                                                    <br>
                                                    <small>{{ date('d-m-Y', strtotime($data->approve_date)) }}
                                                        {{ date('H:i:s', strtotime($data->approve_date)) }}</small>
                                                @elseif($data->status == 'Approved 2')
                                                    <span class="badge badge-success text-white">Disetujui Dept. Head
                                                        Operasional</span>
                                                    <br>
                                                    <small>{{ date('d-m-Y', strtotime($data->approve_kadep)) }}
                                                        {{ date('H:i:s', strtotime($data->approve_kadep)) }}</small>
                                                @elseif($data->status == 'Approved 3')
                                                    <span class="badge badge-success text-white">Disetujui Division
                                                        Head</span>
                                                    <br>
                                                    <small>{{ date('d-m-Y', strtotime($data->approve_kadiv)) }}
                                                        {{ date('H:i:s', strtotime($data->approve_kadiv)) }}</small>
                                                @elseif($data->status == 'Revisi')
                                                    <span class="badge badge-warning">Untuk Direvisi Surveyor 2</span>
                                                    <br>
                                                    <small>{{ date('d-m-Y', strtotime($data->revisi_date)) }}
                                                        {{ date('H:i:s', strtotime($data->revisi_date)) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if (session('user')->role != 1)
                                                    @if ($data->create_by == session('user')->username)
                                                        @if ($data->status == 'Draft' or $data->status == 'Forward')
                                                            <a
                                                                href="{{ route('edit-survei', encrypt($data->no_agenda)) }}">
                                                                <button class="btn btn-warning btn-sm"><i
                                                                        class="fa fa-pencil"></i> Edit
                                                                </button>
                                                            </a>
                                                        @endif
                                                        @if ($data->status == 'Draft')
                                                            <button class="btn btn-danger btn-sm delete"
                                                                survei-id="{{ encrypt($data->no_agenda) }}"><i
                                                                    class="fa fa-trash"></i> Delete
                                                            </button>
                                                            <button class="btn btn-success forward btn-sm"
                                                                survei-id="{{ encrypt($data->no_agenda) }}"><i
                                                                    class="fa fa-mail-forward"></i>
                                                                Forward
                                                            </button>
                                                        @endif
                                                    @endif
                                                    @if ($data->survei2 == session('user')->username)
                                                        @if ($data->status == 'Draft' or $data->status == 'Forward')
                                                            <a
                                                                href="{{ route('edit-evaluasi', encrypt($data->no_agenda)) }}">
                                                                <button class="btn btn-warning btn-sm"><i
                                                                        class="fa fa-pencil"></i> Edit
                                                                </button>
                                                            </a>
                                                        @endif
                                                    @endif
                                                @elseif(session('user')->role == 1)
                                                    <a href="{{ route('edit-survei', encrypt($data->no_agenda)) }}">
                                                        <button class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>
                                                            Edit
                                                        </button>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm delete"
                                                        survei-id="{{ encrypt($data->no_agenda) }}"><i
                                                            class="fa fa-trash"></i> Delete
                                                    </button>
                                                    @if ($data->status == 'Draft')
                                                        <button class="btn btn-success forward btn-sm"
                                                            survei-id="{{ encrypt($data->no_agenda) }}"><i
                                                                class="fa fa-mail-forward"></i>
                                                            Forward
                                                        </button>
                                                    @endif
                                                @endif
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
        <!-- ============================================================== -->
        <!-- End PAge Content -->
    </div>
@endsection

@section('footer')
    <script>
        $('.delete').click(function() {
            var survei_id = $(this).attr('survei-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus survei proposal ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function() {
                    submitDelete("delete-survei/" + survei_id + "");
                });
        });

        $('.forward').click(function() {
            var survei_id = $(this).attr('survei-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan meneruskan survei proposal ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "forward-survei/" + survei_id + "";
                });
        });
    </script>
@stop
