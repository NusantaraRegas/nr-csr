@extends('layout.master')
@section('title', 'SHARE | Tasklist')

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
                    <ol class="breadcrumb">
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
                        <div class="d-flex">
                            <div>
                                <h4 class="card-title model-huruf-family">My Tasks</h4>
                                <h6 class="card-subtitle mb-5 model-huruf-family">Approval Evaluasi Proposal</h6>
                            </div>
                            <div class="ml-auto">
                                @if ($jumlahData > 0)
                                    @if (session('user')->role == 'Supervisor 1')
                                        <button class="btn btn-primary" data-toggle="modal" data-target=".modal-kadep"><i
                                                class="fa fa-reply mr-2"></i>Reply
                                            Selected
                                        </button>
                                    @else
                                        <button class="btn btn-primary" data-toggle="modal" data-target=".modal-kadiv"><i
                                                class="fa fa-reply mr-2"></i>Reply
                                            Selected
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @if ($jumlahData > 0)
                            <div class="table-responsive">
                                <table class="example5 table m-b-0 table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="50px">Pilih</th>
                                            <th width="200px">Disposisi</th>
                                            <th width="300px">Penerima Bantuan</th>
                                            <th width="200px">Wilayah</th>
                                            <th width="300px">Hasil Evaluasi</th>
                                            <th width="100px">Jenis</th>
                                            <th width="200px" nowrap>Dievaluasi Oleh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataEvaluasi as $data)
                                            <tr>
                                                <td style="text-align:center;" nowrap>
                                                    <input type="checkbox" class="check" data-checkbox="icheckbox_flat-red"
                                                        data-idEvaluasi="{{ $data->id_evaluasi }}">
                                                </td>
                                                <td nowrap>
                                                    <span class="font-weight-bold">
                                                        <a data-toggle="tooltip" data-placement="bottom"
                                                            title="Form Evaluasi" target="_blank"
                                                            href="{{ route('form-evaluasi', $data->id_kelayakan) }}">{{ strtoupper($data->no_agenda) }}
                                                        </a>
                                                    </span>
                                                    <br>
                                                    <span class="text-muted">{{ $data->pengirim }}</span><br>
                                                    <span
                                                        class="text-muted">{{ \App\Http\Controllers\tanggal_indo(date('Y-m-d', strtotime($data->tgl_terima))) }}</span><br>
                                                    @if ($data->sifat == 'Biasa')
                                                        <span class="badge badge-success">Biasa</span>
                                                    @elseif($data->sifat == 'Segera')
                                                        <span class="badge badge-warning" style="color: black">Segera</span>
                                                    @elseif($data->sifat == 'Amat Segera')
                                                        <span class="badge badge-danger">Amat Segera</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <b
                                                        class="font-weight-bold text-uppercase">{{ $data->asal_surat }}</b><br>
                                                    <span class="text-muted">{{ $data->deskripsi }}</span>
                                                </td>
                                                <td>
                                                    <b class="font-weight-bold text-uppercase">{{ $data->provinsi }}</b><br>
                                                    <span class="text-muted">{{ $data->kabupaten }}</span>
                                                </td>
                                                <td>
                                                    @if ($data->syarat == 'Survei')
                                                        <span class="font-weight-bold"><i
                                                                class="fa fa-check-circle text-success mr-1"></i>
                                                            Survei/Konfirmasi</span>
                                                    @else
                                                        <span class="font-weight-bold"><i
                                                                class="fa fa-times-circle text-danger mr-1"></i>Tidak
                                                            Memenuhi
                                                            Syarat</span>
                                                    @endif
                                                    <br>
                                                    {{ $data->catatan1 }}
                                                    <h4 class="model-huruf-family mt-0 text-danger font-weight-bold">
                                                        {{ 'Rp. ' . number_format($data->nilai_bantuan, 0, ',', '.') }}
                                                    </h4>
                                                </td>
                                                <td>{{ $data->jenis }}</td>
                                                <td nowrap>
                                                    <?php
                                                    $evaluator1 = \App\Models\User::where('username', $data->evaluator1)->first();
                                                    $evaluator2 = \App\Models\User::where('username', $data->evaluator2)->first();
                                                    ?>
                                                    <b class="font-weight-bold">{{ $evaluator1->nama }}</b>
                                                    <br>
                                                    <b class="font-weight-bold">{{ $evaluator2->nama }}</b>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-success mb-0">
                                <h3 class="text-success model-huruf-family"><i class="fa fa-check-circle"></i> Completed
                                </h3> To-do list is complete
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-kadep" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title model-huruf-family font-weight-bold">REVIEW EVALUASI PROPOSAL</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="keterangan" id="keterangan">
                    <div class="form-group mb-0">
                        <label>Komentar <span class="text-danger">*</span></label>
                        <textarea rows="3" maxlength="100" class="form-control" name="komentar" id="komentarKadep"
                            placeholder="Maksimal 100 karakter"></textarea>
                        @if ($errors->has('komentar'))
                            <small class="text-danger">Komentar harus diisi</small>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <ul class="icheck-list">
                                <li>
                                    <input onclick="approveKadep()" type="radio" value="Approved 2" class="approveKadep"
                                        name="status" id="approve" style="cursor:pointer;"
                                        data-radio="iradio_flat-red">
                                    <label class="label label-success" for="approve"
                                        style="cursor: pointer">Approve</label>
                                </li>
                                <li>
                                    <input onclick="revisiKadep()" type="radio" value="Revisi" class="revisiKadep"
                                        name="status" id="revisi" style="cursor:pointer;"
                                        data-radio="iradio_flat-red">
                                    <label class="label label-danger" for="revisi"
                                        style="cursor: pointer">Revisi</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" id="btnApprove" class="btn btn-success btnSubmit waves-effect text-left">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-kadiv" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title model-huruf-family font-weight-bold">REVIEW EVALUASI PROPOSAL</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="keterangan" id="keteranganKadiv">
                    <div class="form-group mb-0">
                        <label>Komentar <span class="text-danger">*</span></label>
                        <textarea rows="3" maxlength="100" class="form-control" name="komentar" id="komentarKadiv"
                            placeholder="Maksimal 100 karakter"></textarea>
                        @if ($errors->has('komentar'))
                            <small class="text-danger">Komentar harus diisi</small>
                        @endif
                    </div>
                    <div class="input-group">
                        <ul class="icheck-list">
                            <li>
                                <input onclick="approve()" type="radio" value="Survei" class="approveKadiv"
                                    name="status" id="approveKadiv"style="cursor: pointer" data-radio="iradio_flat-red">
                                <label class="label label-success" for="approveKadiv"
                                    style="cursor: pointer">Approve</label>
                            </li>
                            <li>
                                <input onclick="reject()" type="radio" value="Reject" class="reject" name="status"
                                    id="reject" style="cursor: pointer" data-radio="iradio_flat-red">
                                <label class="label label-danger" for="reject" style="cursor: pointer">Reject</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" id="btnApproveKadiv"
                            class="btn btn-success btnSubmit waves-effect text-left">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $('#btnApprove').click(function() {
            var komentar = $('#komentarKadep').val().length;
            var isiKomentar = $('#komentarKadep').val();

            var status = $('#keterangan').val().length;
            var isiStatus = $('#keterangan').val();

            if (komentar == 0) {
                toastr.warning('Komentar harus diisi', 'Warning', {
                    closeButton: true
                });
                return false;
            }

            if (status == 0) {
                toastr.warning('Status komentar harus diisi', 'Warning', {
                    closeButton: true
                });
                return false;
            }

            swal({
                    title: "Warning",
                    text: "Pastikan data yang anda pilih sudah benar",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function() {
                    var id = [];
                    $(':checkbox:checked').each(function(i) {
                        id[i] = $(this).attr('data-idEvaluasi');
                    });
                    if (id.length === 0) {
                        swal("Information", "Anda belum memilih data manapun", "info");
                    } else {
                        window.location = "/tasklist/approveKadep/" + id + "/" + isiKomentar + "/" + isiStatus +
                            "";
                    }
                });
        });
    </script>

    <script>
        $('#btnApproveKadiv').click(function() {
            var komentar = $('#komentarKadiv').val().length;
            var isiKomentar = $('#komentarKadiv').val();

            var status = $('#keteranganKadiv').val().length;
            var isiStatus = $('#keteranganKadiv').val();

            if (komentar == 0) {
                toastr.warning('Komentar harus diisi', 'Warning', {
                    closeButton: true
                });
                return false;
            }

            if (status == 0) {
                toastr.warning('Status komentar harus diisi', 'Warning', {
                    closeButton: true
                });
                return false;
            }

            swal({
                    title: "Warning",
                    text: "Pastikan data yang anda pilih sudah benar",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function() {
                    var id = [];
                    $(':checkbox:checked').each(function(i) {
                        id[i] = $(this).attr('data-idEvaluasi');
                    });
                    if (id.length === 0) {
                        swal("Information", "Anda belum memilih data manapun", "info");
                    } else {
                        window.location = "/tasklist/approveKadiv/" + id + "/" + isiKomentar + "/" + isiStatus +
                            "";
                    }
                });
        });
    </script>

    <script>
        function approveKadep() {
            var nilai = 'Untuk ditindaklanjuti sesuai peraturan yang berlaku';
            var ket = 'Approved 2';
            if ($('.approveKadep').is(":checked")) {
                document.getElementById("komentarKadep").value = nilai;
                document.getElementById("keterangan").value = ket;
            }
        }

        function revisiKadep() {
            var nilai = 'Untuk dapat direvisi';
            var ket = 'Revisi';
            if ($('.revisiKadep').is(":checked")) {
                document.getElementById("komentarKadep").value = nilai;
                document.getElementById("keterangan").value = ket;
            }
        }

        function approve() {
            var nilai = 'Untuk dapat diproses sesuai prosedur';
            var ket = 'Survei';
            if ($('.approveKadiv').is(":checked")) {
                document.getElementById("komentarKadiv").value = nilai;
                document.getElementById("keteranganKadiv").value = ket;
            }
        }

        function reject() {
            var nilai = 'Mohon maaf proposal tidak dapat dibantu';
            var ket = 'Reject';
            if ($('.reject').is(":checked")) {
                document.getElementById("komentarKadiv").value = nilai;
                document.getElementById("keteranganKadiv").value = ket;
            }
        }
    </script>
@stop
