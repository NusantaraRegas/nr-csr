@extends('layout.master')
@section('title', 'SHARE | Tasklist')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold text-uppercase">Tasklist</h4>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="card-body inbox-panel">
                                <ul class="list-group list-group-full">
                                    <li class="list-group-item active">
                                        <a href="{{ route('tasklist') }}" class="text-dark">
                                            <i class="fa fa-envelope mr-2"></i>Evaluasi
                                        </a>
                                        @if ($jumlahEvaluator2 > 0)
                                            <span
                                                class="badge badge-pill badge-success float-right">{{ $jumlahEvaluator2 }}</span>
                                        @endif
                                        @if ($jumlahKadep > 0)
                                            <span
                                                class="badge badge-pill badge-success float-right">{{ $jumlahKadep }}</span>
                                        @endif
                                        @if ($jumlahKadiv > 0)
                                            <span
                                                class="badge badge-pill badge-success float-right">{{ $jumlahKadiv }}</span>
                                        @endif
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('tasklistSurvei') }}" class="text-dark">
                                            <i class="fa fa-envelope-o mr-2"></i>Survei
                                        </a>
                                        @if ($jumlahSurvei2 > 0)
                                            <span
                                                class="badge badge-pill badge-success float-right">{{ $jumlahSurvei2 }}</span>
                                        @endif
                                        @if ($jumlahKadepSurvei > 0)
                                            <span
                                                class="badge badge-pill badge-success float-right">{{ $jumlahKadepSurvei }}</span>
                                        @endif
                                        @if ($jumlahKadivSurvei > 0)
                                            <span
                                                class="badge badge-pill badge-success float-right">{{ $jumlahKadivSurvei }}</span>
                                        @endif
                                    </li>
                                </ul>
                                <div class="btn-group-vertical btn-block mt-3" role="group"
                                    aria-label="Vertical button group">
                                    @if (session('user')->role == '3')
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target=".modal-kadep"><i class="fa fa-mail-reply mr-2"></i>Reply
                                        </button>
                                    @elseif(session('user')->role == '2')
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target=".modal-kadiv"><i class="fa fa-mail-reply mr-2"></i>Reply
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target=".modal-evaluator"><i class="fa fa-mail-reply mr-2"></i>Reply
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 bg-light border-left">
                            <div class="card-body">
                                <h4 class="card-title">Data Evaluasi

                                </h4>
                            </div>
                            <div class="card-body p-t-0">
                                <div class="card b-all shadow-none">
                                    @if ($jumlahTask > 0)
                                        @if ($jumlahEvaluator2 > 0)
                                            <div class="inbox-center table-responsive">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        @foreach ($dataEvaluator2 as $e2)
                                                            <?php
                                                            $agenda = \App\Models\Kelayakan::where('no_agenda', $e2->no_agenda)->first();
                                                            ?>
                                                            <tr>
                                                                <td width="10px">
                                                                    <input type="checkbox" class="check"
                                                                        data-checkbox="icheckbox_flat-red"
                                                                        data-idEvaluasi="{{ $e2->id_evaluasi }}">
                                                                </td>
                                                                <td width="200px" style="color: red">
                                                                    {{ date('d M Y', strtotime($e2->create_date)) }}</td>
                                                                <td width="200px">{{ $agenda->sektor_bantuan }}</td>
                                                                <td width="150px">{{ $agenda->asal_surat }}</td>
                                                                <td width="300px">{{ $agenda->bantuan_untuk }}</td>
                                                                <td width="150px" style="color: red">
                                                                    Rp
                                                                    {{ number_format($agenda->nilai_bantuan, 0, ',', '.') }}
                                                                </td>
                                                                <td width="300px"><i>{{ $e2->catatan1 }}</i></td>
                                                                <td width="10px">
                                                                    <a href="{{ route('form-evaluasi', $e2->id_kelayakan) }}"
                                                                        target="_blank" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Lihat Form Evaluasi"><i
                                                                            class="fa fa-eye text-info font-18"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                        @if ($jumlahKadep > 0)
                                            <div class="inbox-center table-responsive">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        @foreach ($dataKadep as $k)
                                                            <?php
                                                            $agendaKadep = \App\Models\Kelayakan::where('no_agenda', $k->no_agenda)->first();
                                                            ?>
                                                            <tr>
                                                                <td width="10px">
                                                                    <input type="checkbox" class="check"
                                                                        data-checkbox="icheckbox_flat-red"
                                                                        data-idEvaluasi="{{ $k->id_evaluasi }}">
                                                                </td>
                                                                <td width="200px" style="color: red">
                                                                    {{ date('d M Y', strtotime($k->create_date)) }}</td>
                                                                <td width="200px">{{ $agendaKadep->sektor_bantuan }}</td>
                                                                <td width="150px">{{ $agendaKadep->asal_surat }}</td>
                                                                <td width="300px">{{ $agendaKadep->bantuan_untuk }}</td>
                                                                <td width="150px" style="color: red">
                                                                    Rp
                                                                    {{ number_format($agendaKadep->nilai_bantuan, 0, ',', '.') }}
                                                                </td>
                                                                <td width="300px"><i>{{ $k->catatan2 }}</i></td>
                                                                <td width="10px">
                                                                    <a href="{{ route('form-evaluasi', $k->id_kelayakan) }}"
                                                                        target="_blank" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Lihat Form Evaluasi"><i
                                                                            class="fa fa-eye text-info font-18"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                        @if ($jumlahKadiv > 0)
                                            <div class="inbox-center table-responsive">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        @foreach ($dataKadiv as $kadiv)
                                                            <?php
                                                            $agendaKadiv = \App\Models\Kelayakan::where('no_agenda', $kadiv->no_agenda)->first();
                                                            ?>
                                                            <tr>
                                                                <td width="10px">
                                                                    <input type="checkbox" class="check"
                                                                        data-checkbox="icheckbox_flat-red"
                                                                        data-idEvaluasi="{{ $kadiv->id_evaluasi }}">
                                                                </td>
                                                                <td width="200px" style="color: red">
                                                                    {{ date('d M Y', strtotime($kadiv->create_date)) }}
                                                                </td>
                                                                <td width="200px">{{ $agendaKadiv->sektor_bantuan }}</td>
                                                                <td width="150px">{{ $agendaKadiv->asal_surat }}</td>
                                                                <td width="300px">{{ $agendaKadiv->bantuan_untuk }}</td>
                                                                <td width="150px" style="color: red">
                                                                    Rp
                                                                    {{ number_format($agendaKadiv->nilai_bantuan, 0, ',', '.') }}
                                                                </td>
                                                                <td width="300px"><i>{{ $kadiv->catatan2 }}</i></td>
                                                                <td width="10px">
                                                                    <a href="{{ route('form-evaluasi', $kadiv->id_kelayakan) }}"
                                                                        target="_blank" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Lihat Form Evaluasi"><i
                                                                            class="fa fa-eye text-info font-18"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-info">
                                            <h4 class="text-info"><i class="fa fa-info-circle mr-2"></i>Information</h4>
                                            Saat ini anda tidak
                                            memiliki tasklist evaluasi
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-evaluator" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">CATATAN</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="form-group">
                    <textarea rows="3" maxlength="100" class="form-control" name="catatan" id="catatan"
                        placeholder="Maksimal 100 karakter"></textarea>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" id="btnSubmit" class="btn btn-success btnSubmit waves-effect text-left"><i
                                class="fa fa-check mr-2"></i>Submit
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade modal-kadep" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">KOMENTAR</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="form-group" style="margin-bottom: -10px;">
                    <textarea rows="3" maxlength="100" class="form-control" name="komentar" id="komentarKadep"
                        placeholder="Maksimal 100 karakter"></textarea>
                    <input type="hidden" class="form-control" name="keterangan" id="keterangan">
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <ul class="icheck-list">
                            <li>
                                <input onclick="approveKadep()" type="radio" value="Approved 2" class="approveKadep"
                                    name="status" id="approve" data-radio="iradio_flat-red">
                                <label class="label label-success" for="approve">Approve</label>
                            </li>
                            <li>
                                <input onclick="revisiKadep()" type="radio" value="Revisi" class="revisiKadep"
                                    name="status" id="revisi" data-radio="iradio_flat-red">
                                <label class="label label-danger" for="revisi">Revisi</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" id="btnApprove" class="btn btn-success btnSubmit waves-effect text-left">
                            <i class="fa fa-check mr-2"></i>Submit
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade modal-kadiv" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">KOMENTAR</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="form-group" style="margin-bottom: -10px;">
                    <textarea rows="3" maxlength="100" class="form-control" name="komentar" id="komentarKadiv"
                        placeholder="Maksimal 100 karakter"></textarea>
                    <input type="hidden" class="form-control" name="keterangan" id="keteranganKadiv">
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <ul class="icheck-list">
                            <li>
                                <input onclick="approve()" type="radio" value="Survei" class="approveKadiv"
                                    name="status" id="approveKadiv" data-radio="iradio_flat-red">
                                <label class="label label-success" for="approveKadiv">Approve</label>
                            </li>
                            <li>
                                <input onclick="reject()" type="radio" value="Reject" class="reject" name="status"
                                    id="reject" data-radio="iradio_flat-red">
                                <label class="label label-danger" for="reject">Reject</label>
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
                            class="btn btn-success btnSubmit waves-effect text-left">
                            <i class="fa fa-check mr-2"></i>Submit
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('footer')
    <script>
        $('#btnSubmit').click(function() {
            var catatan = $('#catatan').val().length;
            var isiCatatan = $('#catatan').val();

            if (catatan == 0) {
                toastr.warning('Catatan harus diisi', 'Warning', {
                    closeButton: true,
                    progressBar: true
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
                        window.location = "/tasklist/approveEvaluator/" + id + "/" + isiCatatan + "";
                    }
                });
        });
    </script>

    <script>
        $('#btnApprove').click(function() {
            var komentar = $('#komentarKadep').val().length;
            var isiKomentar = $('#komentarKadep').val();

            var status = $('#keterangan').val().length;
            var isiStatus = $('#keterangan').val();

            if (komentar == 0) {
                toastr.warning('Komentar harus diisi', 'Warning', {
                    closeButton: true,
                    progressBar: true
                });
                return false;
            }

            if (status == 0) {
                toastr.warning('Status komentar harus diisi', 'Warning', {
                    closeButton: true,
                    progressBar: true
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
                    closeButton: true,
                    progressBar: true
                });
                return false;
            }

            if (status == 0) {
                toastr.warning('Status komentar harus diisi', 'Warning', {
                    closeButton: true,
                    progressBar: true
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
