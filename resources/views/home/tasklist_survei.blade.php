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
                        <div class="d-flex">
                            <div>
                                <h4 class="card-title model-huruf-family">My Tasks</h4>
                                <h6 class="card-subtitle mb-5 model-huruf-family">Approval Survei Proposal</h6>
                            </div>
                            <div class="ml-auto">
                                @if ($jumlahData > 0)
                                    @if (session('user')->role == 'Supervisor 1')
                                        <button class="btn btn-primary approveAllKadep"><i
                                                class="fa fa-check-circle mr-2"></i>Approve Selected
                                        </button>
                                    @else
                                        <button class="btn btn-primary approveAllKadiv"><i
                                                class="fa fa-check-circle mr-2"></i>Approve Selected
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
                                            <th width="300px">Hasil Survei</th>
                                            <th width="100px">Jenis</th>
                                            <th width="150px">Disurvei Oleh</th>
                                            <th class="text-center" width="50px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataSurvei as $data)
                                            <tr>
                                                <td style="text-align:center;" nowrap>
                                                    <input type="checkbox" class="check" data-checkbox="icheckbox_flat-red"
                                                        data-idSurvei="{{ $data->id_survei }}">
                                                </td>
                                                <td nowrap>
                                                    <span class="font-weight-bold">
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Form Survei"
                                                            target="_blank"
                                                            href="{{ route('form-survei', $data->id_kelayakan) }}">{{ strtoupper($data->no_agenda) }}</a>
                                                    </span><br>
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
                                                    @if ($data->usulan == 'Tidak Memenuhi Kriteria')
                                                        <span class="font-weight-bold"><i
                                                                class="fa fa-times-circle text-danger mr-1"></i>{{ $data->usulan }}</span>
                                                    @else
                                                        <span class="font-weight-bold"><i
                                                                class="fa fa-check-circle text-success mr-1"></i>{{ $data->usulan }}</span>
                                                    @endif
                                                    <br>
                                                    {{ $data->hasil_survei }}
                                                    <h4 class="model-huruf-family mt-0 text-danger font-weight-bold">
                                                        {{ 'Rp. ' . number_format($data->nilai_bantuan, 0, ',', '.') }}
                                                    </h4>
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
                                                    <button data-toggle="modal" data-target=".modal-kadep"
                                                        class="btn btn-sm btn-success approve-survei"
                                                        no-agenda="{{ encrypt($data->no_agenda) }}"
                                                        status="{{ $data->status }}"
                                                        bantuan="{{ '' . number_format($data->nilai_bantuan, 0, ',', '.') }}"
                                                        termin="{{ $data->termin }}" termin1="{{ $data->persen1 }}"
                                                        termin2="{{ $data->persen2 }}" termin3="{{ $data->persen3 }}"
                                                        termin4="{{ $data->persen4 }}" tombol="Revisi">Approve
                                                    </button>
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

    <form method="post" action="{{ action('TasklistSurveiController@approveKadep') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-kadep" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family">PERSETUJUAN SURVEI PROPOSAL</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="noAgenda" id="noAgenda">
                        <div class="form-group">
                            <label>Komentar <span class="text-danger">*</span></label>
                            <textarea rows="3" maxlength="100" class="form-control" name="komentar" id="komentarKadep"
                                placeholder="Maksimal 100 karakter"></textarea>
                            <input type="hidden" class="form-control" name="keterangan" id="keterangan">
                            @if ($errors->has('komentar'))
                                <small class="text-danger">Komentar harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Nilai Bantuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nilaiBantuan" id="nilaiBantuan">
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
                            </select>
                            @if ($errors->has('termin'))
                                <small class="text-danger">Termin pembayaran harus diisi</small>
                            @endif
                        </div>
                        <div id="persentase" class="form-group persentase">
                            <label>Persentase Termin <span class="text-danger">*</span></label>
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
                        </div>
                        <div class="input-group">
                            <ul class="icheck-list">
                                <li>
                                    <input onclick="approveKadep()" type="radio" value="Approved" class="approveKadep"
                                        name="status" id="approve" data-radio="iradio_flat-red">
                                    <label class="label label-success" for="approve"
                                        style="cursor: pointer">Approve</label>
                                </li>
                                <li>
                                    <input onclick="revisiKadep()" type="radio" value="Revisi" class="revisiKadep"
                                        name="status" id="revisi" data-radio="iradio_flat-red">
                                    <label class="label label-danger" for="revisi" style="cursor: pointer"
                                        id="tombol"></label>
                                </li>
                            </ul>
                        </div>
                        @if ($errors->has('status'))
                            <small class="text-danger">Pilihan harus diisi</small>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left">Submit
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
        $('.approveAllKadep').click(function() {
            swal({
                    title: "Warning",
                    text: "Anda yakin akan menyetujui permohonan ini tanpa merubah nilai bantuan dan termin pembayaran?",
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
                        window.location = "/tasklist/approve-all-kadep-survei/" + id + "";
                    }
                });
        });
    </script>

    <script>
        $('.approveAllKadiv').click(function() {
            swal({
                    title: "Warning",
                    text: "Anda yakin akan menyetujui permohonan ini tanpa merubah nilai bantuan dan termin pembayaran?",
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
                        window.location = "/tasklist/approveAllKadivSurvei/" + id + "";
                    }
                });
        });
    </script>

    <script>
        $(document).on('click', '.approve-survei', function(e) {
            document.getElementById("noAgenda").value = $(this).attr('no-agenda');
            document.getElementById("keterangan").value = $(this).attr('status');
            document.getElementById("nilaiBantuan").value = $(this).attr('bantuan');
            document.getElementById("selectTermin").value = $(this).attr('termin');
            document.getElementById("termin1").value = $(this).attr('termin1');
            document.getElementById("termin2").value = $(this).attr('termin2');
            document.getElementById("termin3").value = $(this).attr('termin3');
            document.getElementById("termin4").value = $(this).attr('termin4');
            document.getElementById("tombol").innerHTML = $(this).attr('tombol');
        });
    </script>

    <script>
        function approveKadep() {
            var x = document.getElementById("nilaiBantuan").value;
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
        var nilaiBantuan = document.getElementById('nilaiBantuan');
        nilaiBantuan.addEventListener('keyup', function(e) {
            nilaiBantuan.value = formatRupiah(this.value);
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
        var nilai = '';

        function bukaTermin() {
            var x = document.getElementById("selectTermin").value;
            if (x == 1) {
                document.getElementById("termin1").value = 100;
                document.getElementById("termin2").value = '';
                document.getElementById("termin3").value = '';
                document.getElementById("termin4").value = '';
                $(".termin1").show();
                $(".termin2").hide();
                $(".termin3").hide();
                $(".termin4").hide();
            }
            if (x == 2) {
                document.getElementById("termin1").value = 50;
                document.getElementById("termin2").value = 50;
                document.getElementById("termin3").value = '';
                document.getElementById("termin4").value = '';
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").hide();
                $(".termin4").hide();
            }
            if (x == 3) {
                document.getElementById("termin1").value = 50;
                document.getElementById("termin2").value = 30;
                document.getElementById("termin3").value = 20;
                document.getElementById("termin4").value = '';
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").show();
                $(".termin4").hide();
            }
            if (x == 4) {
                document.getElementById("termin1").value = 25;
                document.getElementById("termin2").value = 25;
                document.getElementById("termin3").value = 25;
                document.getElementById("termin4").value = 25;
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").show();
                $(".termin4").show();
            }
        }
    </script>

    <script>
        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
