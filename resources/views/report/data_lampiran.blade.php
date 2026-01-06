@extends('master')
@section('title', 'SHARE | Data Lampiran')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase">Lampiran</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Lampiran</li>
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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white">Data Lampiran</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th width="10px" style="text-align:center;">No</th>
                                    <th width="200px">Jenis File</th>
                                    <th width="200px">Upload By</th>
                                    <th width="150px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataLampiran as $data)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->upload_by }}<br>
                                            <small>{{ date('d-m-Y H:i:s', strtotime($data->upload_date)) }}</small>
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="/attachment/{{ $data->lampiran }}"
                                               target="_blank"><i class="fa fa-download"></i> Download</a>
                                            <button class="btn btn-danger btn-sm delete"
                                                    lampiran-id="{{ encrypt($data->id_lampiran) }}"
                                                    lampiran-nama="{{ $data->nama }}"
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Upload File</h4>
                        <hr>
                        <form method="post" action="{{ action('LampiranController@uploadFile') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="noAgenda" value="{{ encrypt($noAgenda) }}">
                            <div class="form-group {{ $errors->has('nama') ? ' has-danger' : ''}}">
                                <label>Jenis File <span class="text-danger">*</span></label>
                                <select class="form-control" name="nama">
                                    <option></option>
                                    <option>Surat Pengantar dan Proposal</option>
                                    <option>Lampiran Evaluasi</option>
                                    <option>KTP Ketua</option>
                                    <option>KTP Bendahara</option>
                                    <option>Buku Rekening Lembaga/Bendahara</option>
                                    <option>Dokumentasi</option>
                                    <option>BAST</option>
                                    <option>SPK</option>
                                    <option>BAST</option>
                                    <option>PKS</option>
                                    <option>MOM</option>
                                    <option>BA Nego</option>
                                    <option>Memo/Nota Dinas</option>
                                    <option>Disposisi</option>
                                    <option>Proposal Revisi</option>
                                    <option>Lainnya</option>
                                </select>
                                @if($errors->has('nama'))
                                    <small class="text-danger">Jenis file harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('lampiran') ? ' ' : ''}}">
                                <label>File Proposal <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="lampiran">
                                @if($errors->has('lampiran'))
                                    <small class="text-danger">File proposal harus diisi</small>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Submit</button>
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
        $('.delete').click(function () {
            var lampiran_id = $(this).attr('lampiran-id');
            var lampiran_nama = $(this).attr('lampiran-nama');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus lampiran " + lampiran_nama + " ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function () {
                    window.location = "/proposal/delete-file/" + lampiran_id + "";
                });
        });
    </script>
@stop