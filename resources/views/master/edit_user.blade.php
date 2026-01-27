@extends('layout.master')
@section('title', 'SHARE | Edit User')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container model-huruf-family">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family"><b>USER AKSES</b></h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">User Akses</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-t-10 mb-5">EDIT USER</h5>
                        <form method="post" enctype="multipart/form-data" action="{{ action('UserController@editUser') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="iduser" id="iduser"
                                   value="{{ encrypt($data->id_user) }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('username') ? ' has-danger' : ''}}">
                                        <label>Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="username" id="username" value="{{ $data->username }}">
                                        @if($errors->has('username'))
                                            <small class="text-danger">Username wajib diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('email') ? ' has-danger' : ''}}">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ $data->email }}">
                                        @if($errors->has('email'))
                                            <small class="text-danger">Email wajib diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('nama') ? ' has-danger' : ''}}">
                                        <label>Nama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama" id="nama" value="{{ $data->nama }}">
                                        @if($errors->has('nama'))
                                            <small class="text-danger">Nama wajib diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('jabatan') ? ' has-danger' : ''}}">
                                        <label>Jabatan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{ $data->jabatan }}">
                                        @if($errors->has('jabatan'))
                                            <small class="text-danger">Jabatan wajib diisi</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('area') ? ' has-danger' : ''}}">
                                        <label>Area Kerja <span class="text-danger">*</span></label>
                                        <select name="area" id="area" class="form-control">
                                            <option value="{{ $data->area_kerja }}">{{ $data->area_kerja }}</option>
                                            @foreach($dataArea as $area)
                                                <option value="{{ $area->area_kerja }}">{{ $area->area_kerja }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('area'))
                                            <small class="text-danger">Area kerja wajib diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('role') ? ' has-danger' : ''}}">
                                        <label>Role <span class="text-danger">*</span></label>
                                        <select name="role" id="role" class="form-control">
                                            <option value="{{ $data->role }}">{{ $data->role_name }}</option>
                                            @foreach($dataRole as $role)
                                                <option value="{{ $role->role }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('role'))
                                            <small class="text-danger">Role user wajib diisi</small>
                                        @endif
                                    </div>
{{--                                    <div class="form-group">--}}
{{--                                        <label>Avatar</label>--}}
{{--                                        <input type="file" class="form-control" name="avatar" accept="image/jpg">--}}
{{--                                    </div>--}}
                                    <div class="form-group {{ $errors->has('status') ? ' has-danger' : ''}}">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option>{{ $data->status }}</option>
                                            <option>Active</option>
                                            <option>Non Active</option>
                                        </select>
                                        @if($errors->has('status'))
                                            <small class="text-danger">Status user wajib diisi</small>
                                        @endif
                                    </div>
                                    <div class="pull-right">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-success waves-effect text-left">Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        @if (count($errors) > 0)
        toastr.error('Data yang diisi tidak lengkap', 'Gagal Menyimpan', {closeButton: true});
        @endif
    </script>
@stop