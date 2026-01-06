@extends('layout.master_subsidiary')
@section('title', 'PGN SHARE | Stakeholder')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">STAKEHOLDER INTERNAL
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Settings</li>
                        <li class="breadcrumb-item active">Stakeholder Internal</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                            class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle mr-2"></i>Create New
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family mb-5">DAFTAR STAKEHOLDER</h4>
                        <div class="table-responsive">
                            <table class="example5 table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center font-weight-bold" width="5px">No</th>
                                    <th width="900px" class=" font-weight-bold">Nama Stakeholder</th>
                                    <th class="text-center font-weight-bold" width="100px">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataPengirim as $data)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $data->pengirim }}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="editPengirim font-18"
                                               pengirim-id="{{ encrypt($data->id_pengirim) }}"
                                               pengirim-nama="{{ $data->pengirim }}"
                                               pengirim-status="{{ $data->status }}"
                                               data-target=".modal-edit" data-toggle="modal"><i
                                                        class="fa fa-pencil" data-toggle="tooltip" data-placement="bottom" title="Edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="delete font-18 text-danger"
                                               pengirim-id="{{ encrypt($data->id_pengirim) }}"
                                               pengirim-nama="{{ $data->pengirim }}"
                                            ><i class="fa fa-trash" data-toggle="tooltip" data-placement="bottom" title="Delete"></i>
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
    </div>

    <form method="post" action="{{ action('StakeholderSubsidiaryController@store') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title model-huruf-family font-weight-bold" id="myLargeModalLabel">INPUT STAKEHOLDER</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Stakeholder <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama">
                            @if($errors->has('nama'))
                                <small class="text-danger">Nama stakeholder harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check-circle mr-2"></i>Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('StakeholderSubsidiaryController@update') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title model-huruf-family font-weight-bold" id="myLargeModalLabel">EDIT STAKEHOLDER</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Stakeholder <span class="text-danger">*</span></label>
                            <input type="hidden" id="idpengirim" name="idpengirim">
                            <input type="text" class="form-control" id="nama" name="nama"/>
                            @if($errors->has('nama'))
                                <small class="text-danger">Nama stakeholder harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check-circle mr-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $('.delete').click(function () {
            var pengirim_id = $(this).attr('pengirim-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus stakeholder ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function(){
                    window.location = "deleteStakeholder/" + pengirim_id + "";
                });
        });

        $(document).on('click', '.editPengirim', function (e) {
            document.getElementById("idpengirim").value = $(this).attr('pengirim-id');
            document.getElementById("nama").value = $(this).attr('pengirim-nama');
        });

        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop