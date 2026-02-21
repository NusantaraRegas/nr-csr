@extends('layout.master')
@section('title', 'SHARE | Role User')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase">Role User</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Role User</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                            class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New
                    </button>
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
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        Data yang anda isi belum lengkap
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Role User</h4>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5px" style="text-align:center;">No</th>
                                    <th width="100px">Role</th>
                                    <th width="800px">Role Name</th>
                                    <th width="200px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataRole as $data)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td>{{ $data->role }}</td>
                                        <td>{{ $data->role_name }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm role-edit text-white"
                                                    role-id="{{ encrypt($data->id_role) }}"
                                                    role-role="{{ $data->role }}"
                                                    role-nama="{{ $data->role_name }}"
                                                    data-target=".modal-edit" data-toggle="modal"><i
                                                        class="fa fa-pencil"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete"
                                                    role-id="{{ encrypt($data->id_role) }}"
                                                    role-nama="{{ $data->role_name }}"
                                            ><i class="fa fa-trash-o"></i> Delete
                                            </button>
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

    <form method="post" action="{{ action('RoleController@insertRole') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">INPUT ROLE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group {{ $errors->has('role') ? ' has-danger' : ''}}">
                            <label>Role <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-line" id="role" name="role"
                                   placeholder=""/>
                            @if($errors->has('role'))
                                <small class="text-danger">Role wajib diisi</small>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('nama') ? ' has-danger' : ''}}">
                            <label>Nama Role <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-line" id="nama" name="nama"
                                   placeholder=""/>
                            @if($errors->has('nama'))
                                <small class="text-danger">Role name wajib diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('RoleController@editRole') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">EDIT ROLE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group {{ $errors->has('role_edit') ? ' has-danger' : ''}}">
                            <label>Role <span class="text-danger">*</span></label>
                            <input type="hidden" id="idrole" name="idrole">
                            <input type="text" class="form-control form-control-line" id="role_edit" name="role_edit"
                                   placeholder=""/>
                            @if($errors->has('role_edit'))
                                <small class="text-danger">Role wajib diisi</small>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('nama_edit') ? ' has-danger' : ''}}">
                            <label>Nama Role <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-line" id="nama_edit" name="nama_edit"
                                   placeholder=""/>
                            @if($errors->has('nama_edit'))
                                <small class="text-danger">Role name wajib diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check"></i> Save Changes
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
        $('.delete').click(function () {
            var role_id = $(this).attr('role-id');
            var role_nama = $(this).attr('role-nama');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus role ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function () {
                    submitDelete("delete-role/" + role_id + "/" + role_nama + "");
                });
        });
    </script>
@stop