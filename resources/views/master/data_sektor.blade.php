@extends('layout.master')
@section('title', 'SHARE | Sektor Bantuan')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase">Sektor Bantuan</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Sektor Bantuan</li>
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
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        Data yang anda isi belum lengkap
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">DATA SEKTOR BANTUAN
                            <button class="btn btn-sm btn-info pull-right" data-toggle="modal"
                                    data-target=".modal-input"><i class="fa fa-plus"></i> Add Sektor
                            </button>
                        </h4>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                <tr>
                                    <th width="5px" style="text-align:center;">No</th>
                                    <th width="200px">Kode Sektor</th>
                                    <th width="600px">Sektor Bantuan</th>
                                    <th width="50px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataSektor as $data)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td>{{ $data->kode_sektor }}</td>
                                        <td>{{ $data->sektor_bantuan }}</td>
                                        <td>
                                            <a href="#!" class="edit-sektor"
                                               data-id="{{ encrypt($data->id_sektor) }}"
                                               data-kode="{{ $data->kode_sektor }}"
                                               data-nama="{{ $data->sektor_bantuan }}"
                                               data-target=".modal-edit" data-toggle="modal">
                                                <i class="fa fa-pencil" style="font-size: 18px"></i>
                                            </a>
                                            <a href="#!" class="delete text-danger" data-id="{{ encrypt($data->id_sektor) }}">
                                                <i class="fa fa-trash" style="font-size: 18px"></i>
                                            </a>
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

    <form method="post" action="{{ action('SektorController@insertSektor') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">INPUT SEKTOR</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode Sektor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kode"/>
                            @if($errors->has('kode'))
                                <small class="text-danger">Kode sektor wajib diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Sektor Bantuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-capitalize" name="sektor"/>
                            @if($errors->has('sektor'))
                                <small class="text-danger">Sektor bantuan wajib diisi</small>
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

    <form method="post" action="{{ action('SektorController@editSektor') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">EDIT SEKTOR</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="idsektor" id="idsektor">
                            <label>Kode Sektor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kode" id="kode"/>
                            @if($errors->has('kode'))
                                <small class="text-danger">Kode sektor wajib diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Sektor Bantuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-capitalize" name="sektor" id="sektor"/>
                            @if($errors->has('sektor'))
                                <small class="text-danger">Sektor bantuan wajib diisi</small>
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
        $(document).on('click', '.edit-sektor', function (e) {
            document.getElementById("idsektor").value = $(this).attr('data-id');
            document.getElementById("kode").value = $(this).attr('data-kode');
            document.getElementById("sektor").value = $(this).attr('data-nama');
        });
    </script>

    <script>
        $('.delete').click(function () {
            var sektor_id = $(this).attr('data-id');
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
                    submitDelete("delete-sektor/" + sektor_id + "");
                });
        });
    </script>
@stop