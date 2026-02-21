@extends('layout.master')
@section('title', 'SHARE | Log Exception')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor font-weight-bold">Log Exception</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Log Exception</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">LOG EXCEPTION</h4>
                    <div class="table-responsive">
                        <table class="example5 table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center" width="100px">No</th>
                                <th width="500px">Error Message</th>
                                <th width="300px">Remark</th>
                                <th width="100px">Status</th>
                                <th class="text-center" width="50px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dataException as $data)
                                <tr>
                                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                                    <td>{{ $data->exception }}</td>
                                    <td>{{ $data->remark }}</td>
                                    <td>
                                        @if($data->status == 'Open')
                                            <span class="badge badge-danger">Open</span>
                                        @elseif($data->status == 'Resolved')
                                            <span class="badge badge-info">Resolved</span>
                                        @elseif($data->status == 'Closed')
                                            <span class="badge badge-success">Closed</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="edit"
                                           data-id="{{ encrypt($data->error_id) }}"
                                           data-target=".modal-edit" data-toggle="modal">
                                            <i class="fa fa-pencil" style="font-size: 18px"></i>
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
                    submitDelete("deletePilar/" + data_id + "");
                });
        });
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi tidak lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop