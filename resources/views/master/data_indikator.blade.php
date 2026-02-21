@extends('layout.master')
@section('title', 'SHARE | Indikator')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor font-weight-bold">Indikator</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">Indikator</li>
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
                        <h4 class="card-title mb-5">DAFTAR INDIKATOR
                            <button class="btn btn-sm btn-rounded btn-info float-right" data-toggle="modal"
                                    data-target=".modal-input">
                                <i class="fa fa-plus mr-2"></i>Tambah Data
                            </button>
                        </h4>
                        <div class="table-responsive">
                            <table class="example5 table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th width="10px" style="text-align:center;">No</th>
                                    <th class="text-center" width="200px">TPB</th>
                                    <th class="text-center" width="100px">Kode Indikator</th>
                                    <th width="400px">Keterangan</th>
                                    <th width="200px">Pilar</th>
                                    <th class="text-center" width="50px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataIndikator as $data)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->tpb }}</td>
                                        <td class="text-center">{{ $data->kode_indikator }}</td>
                                        <td>{{ $data->keterangan }}</td>
                                        <td>{{ $data->pilar }}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="edit"
                                               data-id="{{ encrypt($data->id_sub_pilar) }}"
                                               data-tpb="{{ $data->tpb }}"
                                               data-kode="{{ $data->kode_indikator }}"
                                               data-keterangan="{{ $data->keterangan }}"
                                               data-pilar="{{ $data->pilar }}"
                                               data-target=".modal-edit" data-toggle="modal">
                                                <i class="fa fa-pencil" style="font-size: 18px"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="delete text-danger"
                                               data-id="{{ encrypt($data->id_sub_pilar) }}"><i class="fa fa-trash"
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

    <form method="post" action="{{ action('SubPilarController@store') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">INPUT INDIKATOR</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>TPB <span class="text-danger">*</span></label>
                                    <select class="form-control" name="tpb" id="tpb">
                                        <option pilar=""></option>
                                        @foreach($dataTPB as $tpb)
                                            <option pilar="{{ $tpb->pilar }}">{{ $tpb->nama }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('tpb'))
                                        <small class="text-danger">TPB harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Pilar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control bg-white" name="pilar" id="pilar"
                                           value="{{ old('pilar') }}" readonly>
                                    @if($errors->has('pilar'))
                                        <small class="text-danger">Pilar harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="kode" value="{{ old('kode') }}">
                                    @if($errors->has('kode'))
                                        <small class="text-danger">Kode indikator harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Keterangan <span class="text-danger">*</span></label>
                                    <textarea rows="3" class="form-control"
                                              name="keterangan">{{ old('keterangan') }}</textarea>
                                    @if($errors->has('keterangan'))
                                        <small class="text-danger">Keterangan harus diisi</small>
                                    @endif
                                </div>
                            </div>
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

    <form method="post" action="{{ action('SubPilarController@update') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">EDIT INDIKATOR</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="pilarID" id="pilarID">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>TPB <span class="text-danger">*</span></label>
                                    <select class="form-control" name="tpb" id="tpb2">
                                        <option pilar=""></option>
                                        @foreach($dataTPB as $tpb)
                                            <option pilar="{{ $tpb->pilar }}">{{ $tpb->nama }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('tpb'))
                                        <small class="text-danger">TPB harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Pilar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control bg-white" name="pilar" id="pilar2"
                                           value="{{ old('pilar') }}" readonly>
                                    @if($errors->has('pilar'))
                                        <small class="text-danger">Pilar harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="kode" id="kode" value="{{ old('kode') }}">
                                    @if($errors->has('kode'))
                                        <small class="text-danger">Kode indikator harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Keterangan <span class="text-danger">*</span></label>
                                    <textarea rows="3" class="form-control"
                                              name="keterangan" id="keterangan">{{ old('keterangan') }}</textarea>
                                    @if($errors->has('keterangan'))
                                        <small class="text-danger">Keterangan harus diisi</small>
                                    @endif
                                </div>
                            </div>
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
            document.getElementById("tpb2").value = $(this).attr('data-tpb');
            document.getElementById("pilar2").value = $(this).attr('data-pilar');
            document.getElementById("kode").value = $(this).attr('data-kode');
            document.getElementById("keterangan").value = $(this).attr('data-keterangan');
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
                    submitDelete("deleteIndikator/" + data_id + "");
                });
        });
    </script>

    <script>
        $('#tpb').on('change', function () {
            var pilar = $('#tpb option:selected').attr('pilar');
            $('#pilar').val(pilar);
        });

        $('#tpb2').on('change', function () {
            var pilar = $('#tpb2 option:selected').attr('pilar');
            $('#pilar2').val(pilar);
        });
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi tidak lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop