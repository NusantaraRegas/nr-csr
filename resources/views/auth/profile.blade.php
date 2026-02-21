@extends('layout.master')
@section('title', 'SHARE | Account Setting')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>
    <div class="container model-huruf-family">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">ACCOUNT SETTING</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Account Setting</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="m-t-30">
                            @if($data->foto == "")
                                <img src="{{ asset('assets/images/user.png') }}"
                                     class="img-circle" width="180"/>
                            @else
                                <img src="{{ asset('avatar/'.$data->foto.'.jpg') }}"
                                     class="img-circle" width="150"/>
                            @endif
                            <h4 class="card-title m-t-10">{{ $data->nama }}</h4>
                            <h6 class="card-subtitle">{{ $data->jabatan }}</h6>
                            <div class="row text-center justify-content-md-center">
                                @if($data->foto != "")
                                    <br>
                                    <button type="button" class="btn btn-danger delete-foto"
                                            user-id="{{ encrypt($data->id_user) }}">Delete Avatar
                                    </button>
                                @else
                                    <br>
                                    <button type="button" class="btn btn-rounded btn-info" data-toggle="modal"
                                            data-target=".modal-input"> Change Avatar
                                    </button>
                                @endif
                            </div>
                            <hr>
                            <h5 class="card-title">Progress Activity</h5>
                        </center>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="m-t-30"><span class="font-12">Ongoing</span><span class="pull-right font-12">{{ $ongoing }}%</span>
                                </h5>
                                <div class="progress ">
                                    <div class="progress-bar bg-info wow animated progress-animated"
                                         style="width: {{ $ongoing }}%; height:6px;" role="progressbar"><span class="sr-only">{{ $ongoing }}% Complete</span>
                                    </div>
                                </div>
                                <h5 class="m-t-30"><span class="font-12">Completed</span><span
                                            class="pull-right font-12">{{ $completed }}%</span></h5>
                                <div class="progress">
                                    <div class="progress-bar bg-success wow animated progress-animated"
                                         style="width: {{ $completed }}%; height:6px;" role="progressbar"><span class="sr-only">{{ $completed }}% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#profile"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span>
                                <span class="hidden-xs-down">Profile</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#evaluasi" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-list"></i></span> <span
                                        class="hidden-xs-down">Activity Ongoing</span></a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile" role="tabpanel">
                            <div class="p-20">
                                <form class="form-horizontal form-material" method="post"
                                      action="{{ action('UserController@editProfile') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="idlogin" value="{{ encrypt($data->id_user) }}">
                                    <div class="form-group">
                                        <label class="col-md-12" style="margin-bottom: 5px">Username :</label>
                                        <div class="col-md-12">
                                            <input type="text" value="{{ $data->username }}"
                                                   class="form-control form-control-line bg-white" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" style="margin-bottom: 5px">Email :</label>
                                        <div class="col-md-12">
                                            <input type="text" value="{{ $data->email }}"
                                                   class="form-control form-control-line bg-white" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" style="margin-bottom: 5px">Nama :</label>
                                        <div class="col-md-12">
                                            <input type="text" name="nama" value="{{ $data->nama }}"
                                                   class="form-control form-control-line">
                                            @if($errors->has('nama'))
                                                <small class="text-danger">Nama wajib diisi</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" style="margin-bottom: 5px">Jabatan :</label>
                                        <div class="col-md-12">
                                            <input type="text" name="jabatan" value="{{ $data->jabatan }}"
                                                   class="form-control form-control-line">
                                            @if($errors->has('jabatan'))
                                                <small class="text-danger">Jabatan wajib diisi</small>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group pull-right">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success">Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="evaluasi" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th width="50px" class="text-center">No</th>
                                        <th width="150px">No Agenda</th>
                                        <th width="300px">Sektor Bantuan</th>
                                        <th width="300px">Wilayah</th>
                                        <th width="100px">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataEvaluasi as $evaluasi)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <b class="text-danger">{{ $evaluasi->no_agenda }}</b><br>
                                                <small class="text-muted">{{ \App\Http\Controllers\tanggal_indo(date('Y-m-d', strtotime($evaluasi->tgl_terima))) }}</small><br>
                                                <b class="text-uppercase">{{ $evaluasi->asal_surat }}</b><br>
                                                <span class="text-info">{{ $evaluasi->bantuan_untuk }}</span>
                                            </td>
                                            <td>{{ $evaluasi->sektor_bantuan }}</td>
                                            <td>
                                                <b>{{ $evaluasi->provinsi }}</b><br>
                                                <small class="text-muted">{{ $evaluasi->kabupaten }}</small>
                                            </td>
                                            <td nowrap>
                                                @if($evaluasi->status == 'Draft')
                                                    <span class="badge badge-warning badge-pill"
                                                          style="color: black">DRAFT</span>
                                                @elseif($evaluasi->status == 'Evaluasi')
                                                    <span class="badge badge-success badge-pill">EVALUASI</span>
                                                @elseif($evaluasi->status == 'Survei')
                                                    <span class="badge badge-info badge-pill">SURVEI</span>
                                                @elseif($evaluasi->status == 'Approved')
                                                    <span class="badge badge-primary badge-pill">APPROVED</span>
                                                @elseif($evaluasi->status == 'Rejected')
                                                    <span class="badge badge-danger badge-pill">REJECTED</span>
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
        </div>
        <!-- Column -->
    </div>

    <form method="post" action="{{ action('UserController@uploadFoto') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">CHANGE AVATAR</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <input type="hidden" name="idlogin" value="{{ encrypt($data->id_user) }}">
                            <input type="file" class="form-control" name="avatar" accept="image/jpg">
                            @if($errors->has('avatar'))
                                <br>
                                <small class="text-danger">File masih kosong</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left">Submit
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $('.delete-foto').click(function () {
            var user_id = $(this).attr('user-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus foto profile?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function () {
                    submitDelete("/profile/delete-foto/" + user_id + "");
                });
        });

        @if ($errors->has('passwordLama') or $errors->has('password'))
        toastr.error('Data perubahan password belum lengkap', 'Gagal', {closeButton: true});
        @endif
    </script>
@stop