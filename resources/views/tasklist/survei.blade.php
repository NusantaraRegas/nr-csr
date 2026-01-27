@extends('layout.master')
@section('title', 'SHARE | Tasklist')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
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
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="card-body inbox-panel">
                                <ul class="list-group list-group-full">
                                    <li class="list-group-item">
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
                                    <li class="list-group-item active">
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
                                    @if (session('user')->role == '5' or session('user')->role == '1')
                                        <button type="button" id="btnSetuju" class="btn btn-danger"><i
                                                class="fa fa-mail-reply mr-2"></i>Reply
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 bg-light border-left">
                            <div class="card-body">
                                <h4 class="card-title">Data Survei

                                </h4>
                            </div>
                            <div class="card-body p-t-0">
                                <div class="card b-all shadow-none">
                                    @if ($jumlahTaskSurvei > 0)
                                        @if ($jumlahSurvei2 > 0)
                                            <div class="inbox-center table-responsive">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        @foreach ($dataSurvei2 as $e2)
                                                            <?php
                                                            $agenda = \App\Models\Kelayakan::where('no_agenda', $e2->no_agenda)->first();
                                                            ?>
                                                            <tr>
                                                                <td width="10px">
                                                                    <input type="checkbox" class="check"
                                                                        data-checkbox="icheckbox_flat-red"
                                                                        data-idSurvei="{{ $e2->id_survei }}">
                                                                </td>
                                                                <td width="200px" style="color: red">
                                                                    {{ date('d M Y', strtotime($e2->create_date)) }}</td>
                                                                <td width="200px">{{ $agenda->asal_surat }}</td>
                                                                <td width="300px">{{ $agenda->bantuan_untuk }}</td>
                                                                <td width="200px">
                                                                    @if ($e2->usulan == 'Disarankan')
                                                                        <span
                                                                            class="badge badge-success badge-pill">{{ $e2->usulan }}</span>
                                                                    @elseif($e2->usulan == 'Dipertimbangkan')
                                                                        <span
                                                                            class="badge badge-warning badge-pill">{{ $e2->usulan }}</span>
                                                                    @else
                                                                        <span
                                                                            class="badge badge-danger badge-pill">{{ $e2->usulan }}</span>
                                                                    @endif
                                                                </td>
                                                                <td width="150px">
                                                                    <b style="color: red">Rp
                                                                        {{ number_format($e2->nilai_bantuan, 0, ',', '.') }}</b>
                                                                    <br>
                                                                    {{ $e2->termin }} Termin
                                                                </td>
                                                                <td width="300px"><i>{{ $e2->hasil_survei }}</i></td>
                                                                <td width="10px">
                                                                    <a href="{{ route('form-survei', $e2->id_kelayakan) }}"
                                                                        target="_blank" data-toggle="tooltip"
                                                                        data-placement="bottom" title="Lihat Form Survei"><i
                                                                            class="fa fa-eye text-info font-18"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                        @if ($jumlahKadepSurvei > 0)
                                            <div class="inbox-center table-responsive">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        @foreach ($dataKadepSurvei as $k)
                                                            <?php
                                                            $agendaKadep = \App\Models\Kelayakan::where('no_agenda', $k->no_agenda)->first();
                                                            ?>
                                                            <tr>
                                                                <td width="300px">{{ $agendaKadep->asal_surat }}</td>
                                                                <td width="300px">{{ $agendaKadep->bantuan_untuk }}</td>
                                                                <td width="200px">
                                                                    @if ($k->usulan == 'Disarankan')
                                                                        <span
                                                                            class="badge badge-success badge-pill">{{ $k->usulan }}</span>
                                                                    @elseif($k->usulan == 'Dipertimbangkan')
                                                                        <span
                                                                            class="badge badge-warning badge-pill">{{ $k->usulan }}</span>
                                                                    @else
                                                                        <span
                                                                            class="badge badge-danger badge-pill">{{ $k->usulan }}</span>
                                                                    @endif
                                                                </td>
                                                                <td width="150px">
                                                                    <b style="color: red">Rp
                                                                        {{ number_format($k->nilai_bantuan, 0, ',', '.') }}</b>
                                                                    <br>
                                                                    {{ $k->termin }} Termin
                                                                </td>
                                                                <td width="200px">
                                                                    <a href="{{ route('form-survei', $k->id_kelayakan) }}"
                                                                        class="btn btn-info btn-xs" target="_blank">View
                                                                    </a>
                                                                    <a href="#!" data-toggle="modal"
                                                                        data-target=".modal-kadep"
                                                                        class="btn btn-success btn-xs approve-survei"
                                                                        no-agenda="{{ encrypt($k->no_agenda) }}"
                                                                        status="{{ $k->status }}"
                                                                        bantuan="{{ $k->nilai_bantuan }}"
                                                                        bantuanRupiah="{{ '' . number_format($k->nilai_bantuan, 0, ',', '.') }}"
                                                                        termin="{{ $k->termin }}"
                                                                        termin1="{{ $k->persen1 }}"
                                                                        termin2="{{ $k->persen2 }}"
                                                                        termin3="{{ $k->persen3 }}"
                                                                        termin4="{{ $k->persen4 }}"
                                                                        termin5="{{ $k->persen5 }}"
                                                                        tombol="Revisi">Approve
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                        @if ($jumlahKadivSurvei > 0)
                                            <div class="inbox-center table-responsive">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        @foreach ($dataKadivSurvei as $kadiv)
                                                            <?php
                                                            $agendaKadiv = \App\Models\Kelayakan::where('no_agenda', $kadiv->no_agenda)->first();
                                                            ?>
                                                            <tr>
                                                                <td width="300px">{{ $agendaKadiv->asal_surat }}</td>
                                                                <td width="300px">{{ $agendaKadiv->bantuan_untuk }}</td>
                                                                <td width="200px">
                                                                    @if ($kadiv->usulan == 'Disarankan')
                                                                        <span
                                                                            class="badge badge-success badge-pill">{{ $kadiv->usulan }}</span>
                                                                    @elseif($kadiv->usulan == 'Dipertimbangkan')
                                                                        <span
                                                                            class="badge badge-warning badge-pill">{{ $kadiv->usulan }}</span>
                                                                    @else
                                                                        <span
                                                                            class="badge badge-danger badge-pill">{{ $kadiv->usulan }}</span>
                                                                    @endif
                                                                </td>
                                                                <td width="150px">
                                                                    <b style="color: red">Rp
                                                                        {{ number_format($kadiv->nilai_bantuan, 0, ',', '.') }}</b>
                                                                    <br>
                                                                    {{ $kadiv->termin }} Termin
                                                                </td>
                                                                <td width="200px">
                                                                    <a href="{{ route('form-survei', $kadiv->id_kelayakan) }}"
                                                                        class="btn btn-info btn-xs" target="_blank">View
                                                                    </a>
                                                                    <a href="#!" data-toggle="modal"
                                                                        data-target=".modal-kadep"
                                                                        class="btn btn-success btn-xs approve-survei"
                                                                        no-agenda="{{ encrypt($kadiv->no_agenda) }}"
                                                                        status="{{ $kadiv->status }}"
                                                                        bantuan="{{ $kadiv->nilai_bantuan }}"
                                                                        bantuanRupiah="{{ '' . number_format($kadiv->nilai_approved, 0, ',', '.') }}"
                                                                        termin="{{ $kadiv->termin }}"
                                                                        termin1="{{ $kadiv->persen1 }}"
                                                                        termin2="{{ $kadiv->persen2 }}"
                                                                        termin3="{{ $kadiv->persen3 }}"
                                                                        termin4="{{ $kadiv->persen4 }}"
                                                                        termin5="{{ $kadiv->persen5 }}"
                                                                        tombol="Reject">Approve
                                                                    </a>
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
                                            memiliki tasklist survei
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

    <form method="post" action="{{ action('TasklistSurveiController@approveKadep') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-kadep" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">PERSETUJUAN</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda" id="noAgenda">
                        <div class="form-group">
                            <textarea rows="3" maxlength="100" class="form-control" name="komentar" id="komentarKadep"
                                placeholder="Maksimal 100 karakter"></textarea>
                            <input type="hidden" class="form-control" name="keterangan" id="keterangan">
                        </div>
                        <div class="form-group">
                            <label>Nilai Bantuan <span class="text-danger">*</span></label>
                            <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                id="nilaiRupiah">
                            <input type="hidden" class="form-control" name="nilaiBantuan" id="nilaiBantuan">
                            @if ($errors->has('nilaiBantuan'))
                                <small class="text-danger">Nilai bantuan harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Termin Pembayaran <span class="text-danger">*</span></label>
                            <select onchange="bukaTermin()" id="selectTermin" class="form-control bukaTermin"
                                name="termin">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @if ($errors->has('termin'))
                                <small class="text-danger">Termin pembayaran harus diisi</small>
                            @endif
                        </div>
                        <div id="persentase" class="form-group persentase">
                            <label>Persentase Termin
                                <small>(isi dengan nilai persen)</small>
                                <span class="text-danger">*</span></label>
                            <input maxlength="3" onkeypress="return hanyaAngka(event)" type="text"
                                class="form-control termin1" name="termin1" id="termin1" placeholder="Termin 1"
                                style="margin-bottom: 5px;">
                            <input maxlength="2" onkeypress="return hanyaAngka(event)" type="text"
                                class="form-control termin2" name="termin2" id="termin2" placeholder="Termin 2"
                                style="margin-bottom: 5px;">
                            <input maxlength="2" onkeypress="return hanyaAngka(event)" type="text"
                                class="form-control termin3" name="termin3" id="termin3" placeholder="Termin 3"
                                style="margin-bottom: 5px;">
                            <input maxlength="2" onkeypress="return hanyaAngka(event)" type="text"
                                class="form-control termin4" name="termin4" id="termin4" placeholder="Termin 4">
                            <input maxlength="2" onkeypress="return hanyaAngka(event)" type="text"
                                class="form-control termin5" name="termin5" id="termin5" placeholder="Termin 5">
                        </div>
                        <div class="input-group">
                            <ul class="icheck-list">
                                <li>
                                    <input onclick="approveKadep()" type="radio" value="Approved" class="approveKadep"
                                        name="status" id="approve" data-radio="iradio_flat-red">
                                    <label class="label label-success" for="approve">Approve</label>
                                </li>
                                <li>
                                    <input onclick="revisiKadep()" type="radio" value="Revisi" class="revisiKadep"
                                        name="status" id="revisi" data-radio="iradio_flat-red">
                                    <label class="label label-danger" for="revisi" id="tombol"></label>
                                </li>
                            </ul>
                        </div>
                        @if ($errors->has('status'))
                            <small class="text-danger">Status komentar harus diisi</small>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check mr-2"></i>Submit
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
        $(document).ready(function() {
            $('#btnSetuju').click(function() {
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
                            id[i] = $(this).attr('data-idSurvei');
                        });

                        if (id.length === 0) {
                            swal("Information", "Anda belum memilih data manapun", "info");
                        } else {
                            window.location = "/tasklist/approveSurvei/" + id + "";
                        }
                    });
            });
        });
    </script>

    <script>
        function approveKadep() {
            var x = document.getElementById("nilaiRupiah").value;
            var termin = document.getElementById("selectTermin").value;
            var stat = document.getElementById("keterangan").value;
            if ($('.approveKadep').is(":checked")) {
                if (stat == 'Approved 1') {
                    document.getElementById("komentarKadep").value =
                        'Dilengkapi kelengkapan dokumen administrasi sesuai peraturan yang berlaku dengan usulan nilai bantuan Rp. ' +
                        x;
                }
                if (stat == 'Approved 2') {
                    document.getElementById("komentarKadep").value = 'Dapat dibantu senilai Rp. ' + x + ' dengan ' +
                        termin + ' termin pembayaran';
                }

            }
        }

        function revisiKadep() {
            var stat = document.getElementById("keterangan").value;
            if ($('.revisiKadep').is(":checked")) {
                if (stat == 'Approved 1') {
                    document.getElementById("komentarKadep").value = 'Untuk dapat direvisi';
                }
                if (stat == 'Approved 2') {
                    document.getElementById("komentarKadep").value = 'Proposal tidak dapat dibantu';
                }

            }
        }
    </script>

    <script>
        var nilaiRupiah = document.getElementById('nilaiRupiah');
        nilaiRupiah.addEventListener('keyup', function(e) {
            nilaiRupiah.value = formatRupiah(this.value);
            nilaiBantuan.value = convertToAngka(this.value);
        });

        /* Fungsi */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        /* Fungsi */
        function convertToAngka(rupiah) {
            return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
        }
    </script>

    <script>
        $('.approve').click(function() {
            var no_agenda = $(this).attr('no-agenda');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menyetujui evaluasi proposal ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "approve-surveyor/" + no_agenda + "";
                });
        });

        @if (count($errors) > 0)
            toastr.warning("Persetujuan yang anda isi belum lengkap", "Warning");
        @endif
    </script>
    <script>
        $(document).on('click', '.approve-survei', function(e) {
            document.getElementById("noAgenda").value = $(this).attr('no-agenda');
            document.getElementById("keterangan").value = $(this).attr('status');
            document.getElementById("nilaiBantuan").value = $(this).attr('bantuan');
            document.getElementById("nilaiRupiah").value = $(this).attr('bantuanRupiah');
            document.getElementById("selectTermin").value = $(this).attr('termin');
            document.getElementById("termin1").value = $(this).attr('termin1');
            document.getElementById("termin2").value = $(this).attr('termin2');
            document.getElementById("termin3").value = $(this).attr('termin3');
            document.getElementById("termin4").value = $(this).attr('termin4');
            document.getElementById("termin5").value = $(this).attr('termin5');
            document.getElementById("tombol").innerHTML = $(this).attr('tombol');
        });
    </script>
    <script>
        var nilai = '';

        function bukaTermin() {
            var x = document.getElementById("selectTermin").value;
            if (x == 1) {
                document.getElementById("termin1").value = 100;
                document.getElementById("termin2").value = '';
                document.getElementById("termin3").value = '';
                document.getElementById("termin4").value = '';
                document.getElementById("termin5").value = '';
                $(".termin1").show();
                $(".termin2").hide();
                $(".termin3").hide();
                $(".termin4").hide();
                $(".termin5").hide();
            }
            if (x == 2) {
                document.getElementById("termin1").value = 50;
                document.getElementById("termin2").value = 50;
                document.getElementById("termin3").value = '';
                document.getElementById("termin4").value = '';
                document.getElementById("termin5").value = '';
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").hide();
                $(".termin4").hide();
                $(".termin5").hide();
            }
            if (x == 3) {
                document.getElementById("termin1").value = 50;
                document.getElementById("termin2").value = 30;
                document.getElementById("termin3").value = 20;
                document.getElementById("termin4").value = '';
                document.getElementById("termin4").value = '';
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").show();
                $(".termin4").hide();
                $(".termin5").hide();
            }
            if (x == 4) {
                document.getElementById("termin1").value = 25;
                document.getElementById("termin2").value = 25;
                document.getElementById("termin3").value = 25;
                document.getElementById("termin4").value = 25;
                document.getElementById("termin5").value = '';
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").show();
                $(".termin4").show();
                $(".termin5").hide();
            }
            if (x == 5) {
                document.getElementById("termin1").value = 20;
                document.getElementById("termin2").value = 20;
                document.getElementById("termin3").value = 20;
                document.getElementById("termin4").value = 20;
                document.getElementById("termin5").value = 20;
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").show();
                $(".termin4").show();
                $(".termin5").show();
            }
        }
    </script>
@stop
