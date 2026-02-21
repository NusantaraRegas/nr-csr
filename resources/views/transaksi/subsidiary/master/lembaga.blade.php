@extends('layout.master_subsidiary')
@section('title', 'NR SHARE | Penerima Bantuan')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="model-huruf-family font-weight-bold">PENERIMA BANTUAN
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">Penerima Bantuan</li>
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
                        <h4 class="card-title model-huruf-family mb-5">DAFTAR PENERIMA BANTUAN</h4>
                        <div class="table-responsive">
                            <table class="example5 table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th width="10px" class="text-center font-weight-bold">No</th>
                                    <th width="200px" class="text-center font-weight-bold">Nama Lembaga/Yayasan</th>
                                    <th width="400px" class="text-center font-weight-bold">Alamat</th>
                                    <th width="200px" class="text-center font-weight-bold">Penanggung Jawab</th>
                                    <th width="50px" class="text-center font-weight-bold">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataLembaga as $data)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama_lembaga }}</td>
                                        <td>{{ $data->alamat }}</td>
                                        <td>
                                            <span class="font-bold">{{ $data->nama_pic }}</span><br>
                                            <span class="text-muted">{{ $data->jabatan }}</span><br>
                                            {{ $data->no_telp }}
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="editLembaga font-18"
                                               lembaga-id="{{ encrypt($data->id_lembaga) }}"
                                               lembaga-nama="{{ $data->nama_lembaga }}"
                                               lembaga-alamat="{{ $data->alamat }}"
                                               lembaga-pic="{{ $data->nama_pic }}"
                                               lembaga-jabatan="{{ $data->jabatan }}"
                                               lembaga-noTelp="{{ $data->no_telp }}"
                                               data-target=".modal-edit" data-toggle="modal"><i
                                                        class="fa fa-pencil" data-toggle="tooltip" data-placement="bottom" title="Edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="delete text-danger"
                                               data-toggle="tooltip" data-placement="bottom" title="Delete"
                                               data-id="{{ encrypt($data->id_lembaga) }}"><i class="fa fa-trash"
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
    </div>

    <form method="post" action="{{ action('LembagaSubsidiaryController@store') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title model-huruf-family font-weight-bold">INPUT PENERIMA BANTUAN</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Lembaga/Yayasan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="namaLembaga" value="{{ old('namaLembaga') }}">
                            @if($errors->has('namaLembaga'))
                                <small class="text-danger">Nama lembaga/yayasan harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="3" name="alamat"></textarea>
                            @if($errors->has('alamat'))
                                <small class="text-danger">Alamat harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Penanggung Jawab <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pic" value="{{ old('pic') }}">
                            @if($errors->has('pic'))
                                <small class="text-danger">Nama penanggung jawab harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="jabatan" value="{{ old('jabatan') }}">
                            @if($errors->has('jabatan'))
                                <small class="text-danger">Jabatan harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>No Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" onkeypress="return hanyaAngka(event)" name="noTelp" value="{{ old('noTelp') }}">
                            @if($errors->has('noTelp'))
                                <small class="text-danger">No telepon harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Batal
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

    <form method="post" action="{{ action('LembagaSubsidiaryController@update') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title model-huruf-family font-weight-bold">EDIT PENERIMA BANTUAN</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="lembagaID" id="lembagaID" value="{{ old('lembagaID') }}">
                        <div class="form-group">
                            <label>Nama Lembaga/Yayasan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="namaLembaga" id="namaLembaga" value="{{ old('namaLembaga') }}">
                            @if($errors->has('namaLembaga'))
                                <small class="text-danger">Nama lembaga/yayasan harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="3" name="alamat" id="alamat">{{ old('alamat') }}</textarea>
                            @if($errors->has('alamat'))
                                <small class="text-danger">Alamat harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Penanggung Jawab <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pic" id="pic" value="{{ old('pic') }}">
                            @if($errors->has('pic'))
                                <small class="text-danger">Nama penanggung jawab harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{ old('jabatan') }}">
                            @if($errors->has('jabatan'))
                                <small class="text-danger">Jabatan harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>No Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" onkeypress="return hanyaAngka(event)" name="noTelp" id="noTelp" value="{{ old('noTelp') }}">
                            @if($errors->has('noTelp'))
                                <small class="text-danger">No telepon harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Batal
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
                    submitDelete("deleteLembaga/" + data_id + "");
                });
        });
    </script>

    <script>
        $(document).on('click', '.editLembaga', function (e) {
            document.getElementById("lembagaID").value = $(this).attr('lembaga-id');
            document.getElementById("namaLembaga").value = $(this).attr('lembaga-nama');
            document.getElementById("alamat").value = $(this).attr('lembaga-alamat');
            document.getElementById("pic").value = $(this).attr('lembaga-pic');
            document.getElementById("jabatan").value = $(this).attr('lembaga-jabatan');
            document.getElementById("noTelp").value = $(this).attr('lembaga-noTelp');
        });
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop