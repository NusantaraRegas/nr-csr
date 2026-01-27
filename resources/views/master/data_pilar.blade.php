@extends('layout.master')
@section('title', 'SHARE | Pilar')

@section('content')
    <div class="container">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor font-weight-bold">Pilar</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">Pilar</li>
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
                        <h4 class="card-title mb-5">DAFTAR PILAR
                            <button class="btn btn-sm btn-rounded btn-info float-right" data-toggle="modal"
                                    data-target=".modal-input">
                                <i class="fa fa-plus mr-2"></i>Tambah Data
                            </button>
                        </h4>
                        <div class="table-responsive">
                            <table class="example5 table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center" width="100px">ID</th>
                                    <th width="600px">Nama Pilar</th>
                                    <th class="text-center" width="50px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataPilar as $data)
                                    <tr>
                                        <td class="text-center">{{ $data->kode }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="edit"
                                               data-id="{{ encrypt($data->id_pilar) }}"
                                               data-kode="{{ $data->kode }}"
                                               data-nama="{{ $data->nama }}"
                                               data-target=".modal-edit" data-toggle="modal">
                                                <i class="fa fa-pencil" style="font-size: 18px"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="delete text-danger"
                                               data-id="{{ encrypt($data->id_pilar) }}"><i class="fa fa-trash"
                                                                                           style="font-size: 18px"></i></a>
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

    <form method="post" action="{{ action('PilarController@store') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">INPUT PILAR</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kode" value="{{ old('kode') }}">
                            @if($errors->has('nama'))
                                <small class="text-danger">ID pilar harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" value="{{ old('nama') }}">
                            @if($errors->has('nama'))
                                <small class="text-danger">Nama pilar harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-save mr-2"></i>Submit
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('PilarController@update') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">EDIT PILAR</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="pilarID" id="pilarID">
                            <label>ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kode" id="kode">
                            @if($errors->has('nama'))
                                <small class="text-danger">ID pilar harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" id="nama">
                            @if($errors->has('nama'))
                                <small class="text-danger">Nama pilar harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-save mr-2"></i>Save Changes
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
        $(document).on('click', '.edit', function (e) {
            document.getElementById("pilarID").value = $(this).attr('data-id');
            document.getElementById("kode").value = $(this).attr('data-kode');
            document.getElementById("nama").value = $(this).attr('data-nama');
        });
    </script>

    <script>
        $('.delete').click(function () {
            var data_id = $(this).attr('data-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus data ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function () {
                    window.location = "deletePilar/" + data_id + "";
                });
        });
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi tidak lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop