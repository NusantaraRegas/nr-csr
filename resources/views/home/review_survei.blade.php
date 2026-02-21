@extends('layout.master')
@section('title', 'NR SHARE | Tasklist')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="model-huruf-family font-weight-bold">TASKLIST</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb model-huruf-family">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Tasklist</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family">My Tasks</h4>
                        <h6 class="card-subtitle mb-5 model-huruf-family">Review Survei Proposal</h6>
                        @if($jumlahData > 0)
                        <div class="table-responsive">
                            <table class="example5 table m-b-0 table-striped table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center" width="50px">No</th>
                                    <th width="200px">Disposisi</th>
                                    <th width="300px">Penerima Bantuan</th>
                                    <th width="200px">Wilayah</th>
                                    <th width="300px">Hasil Survei</th>
                                    <th width="100px">Jenis</th>
                                    <th width="150px">Disurvei Oleh</th>
                                    <th class="text-center" width="50px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataSurvei as $data)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td nowrap>
                                            <span class="font-weight-bold">
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                   title="Form Survei"
                                                   target="_blank"
                                                   href="{{ route('form-survei', $data->id_kelayakan) }}">{{ strtoupper($data->no_agenda) }}</a>
                                            </span><br>
                                            <span class="text-muted">{{ $data->pengirim }}</span><br>
                                            <span class="text-muted">{{ \App\Http\Controllers\tanggal_indo(date('Y-m-d', strtotime($data->tgl_terima))) }}</span><br>
                                            @if($data->sifat == 'Biasa')
                                                <span class="badge badge-success">Biasa</span>
                                            @elseif($data->sifat == 'Segera')
                                                <span class="badge badge-warning" style="color: black">Segera</span>
                                            @elseif($data->sifat == 'Amat Segera')
                                                <span class="badge badge-danger">Amat Segera</span>
                                            @endif
                                        </td>
                                        <td>
                                            <b class="font-weight-bold text-uppercase">{{ $data->asal_surat }}</b><br>
                                            <span class="text-muted">{{ $data->deskripsi }}</span>
                                        </td>
                                        <td>
                                            <b class="font-weight-bold text-uppercase">{{ $data->provinsi }}</b><br>
                                            <span class="text-muted">{{ $data->kabupaten }}</span>
                                        </td>
                                        <td>
                                            @if($data->usulan == 'Tidak Memenuhi Kriteria')
                                                <span class="font-weight-bold"><i
                                                            class="fa fa-times-circle text-danger mr-1"></i>{{ $data->usulan }}</span>
                                            @else
                                                <span class="font-weight-bold"><i
                                                            class="fa fa-check-circle text-success mr-1"></i>{{ $data->usulan }}</span>
                                            @endif
                                            <br>
                                            {{ $data->hasil_survei }}
                                            <h4 class="model-huruf-family mt-0 text-danger font-weight-bold">{{ "Rp. ".number_format($data->nilai_bantuan,0,',','.') }}</h4>
                                        </td>
                                        <td>{{ $data->jenis }}</td>
                                        <td nowrap>
                                            <?php
                                            $survei1 = \App\Models\User::where('username', $data->survei1)->first();
                                            $survei2 = \App\Models\User::where('username', $data->survei2)->first();
                                            ?>
                                            <b class="font-weight-bold">{{ $survei1->nama }}</b>
                                            <br>
                                            <b class="font-weight-bold">{{ $survei2->nama }}</b>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary review" data-id="{{ encrypt($data->id_survei) }}" data-target=".modal-review" data-toggle="modal">Review</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <div class="alert alert-success mb-0">
                                <h4 class="text-success model-huruf-family"><i class="fa fa-check-circle"></i> Completed</h4> To-do list is complete
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('TasklistSurveiController@review') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-review" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family">REVIEW SURVEI</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="surveiID" id="surveiID">
                        <div class="form-group mb-0">
                            <label>Hasil Survei <span class="text-danger">*</span></label>
                            <textarea rows="3" class="form-control" name="hasilSurvei"></textarea>
                            @if($errors->has('hasilSurvei'))
                                <small class="text-danger">Nama anggota harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $(document).on('click', '.review', function (e) {
            document.getElementById("surveiID").value = $(this).attr('data-id');
        });
    </script>

    <script>
        $('.delete').click(function () {
            var data_id = $(this).attr('kelayakan-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus proposal ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function () {
                    submitDelete("delete-kelayakan/" + data_id + "");
                });
        });
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop