@extends('layout.master')
@section('title', 'NR SHARE | Evaluasi Proposal')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">EVALUASI PROPOSAL</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Evaluasi Proposal</li>
                    </ol>
                </div>
            </div>
        </div>
        <form id="myForm" method="post" action="{{ action('EvaluasiController@insertEvaluasi') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white">Form Evaluasi</h4>
                        </div>
                        <div class="card-body">
                            <input class="form-control" type="hidden" name="noAgenda" value="{{ $data->no_agenda }}">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Rencana Anggaran <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="rencanaAnggaran">
                                            <option>{{ old('rencanaAnggaran') }}</option>
                                            <option>ADA</option>
                                            <option>TIDAK ADA</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('rencanaAnggaran'))
                                        <small class="text-danger">Rencana anggaran harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Dokumentasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="dokumen">
                                            <option>{{ old('dokumen') }}</option>
                                            <option>ADA</option>
                                            <option>TIDAK ADA</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('dokumen'))
                                        <small class="text-danger">Dokumentasi harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Denah Lokasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="denah">
                                            <option>{{ old('denah') }}</option>
                                            <option>ADA</option>
                                            <option>TIDAK ADA</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('denah'))
                                        <small class="text-danger">Denah lokasi harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Kepentingan Perusahaan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <ul class="icheck-list">
                                            <li>
                                                <input type="checkbox" name="wilayahOperasi"
                                                    value="Wilayah Operasi NR (Ring I / II / III)" class="check"
                                                    id="square-checkbox-1" data-checkbox="icheckbox_square-red">
                                                <label for="square-checkbox-1">Wilayah Operasi NR (Ring
                                                    I/II/III)</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="kelancaranOperasional"
                                                    value="Kelancaran Operasional/asset NR" class="check"
                                                    id="square-checkbox-2" data-checkbox="icheckbox_square-red">
                                                <label for="square-checkbox-2">Kelancaran Operasional/Asset
                                                    NR</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="hubunganBaik"
                                                    value="Menjaga hubungan baik shareholders/stakeholders" class="check"
                                                    id="square-checkbox-3" data-checkbox="icheckbox_square-red">
                                                <label for="square-checkbox-3">Menjaga Hubungan Baik
                                                    Stakeholders</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>&nbsp;</label>
                                    <div class="input-group">
                                        <ul class="icheck-list">
                                            <li>
                                                <input type="checkbox" name="brandImage"
                                                    value="Brand images/citra perusahaan" class="check"
                                                    id="square-checkbox-4" data-checkbox="icheckbox_square-red">
                                                <label for="square-checkbox-4">Brand Images/Citra Perusahaan</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="pengembanganWilayah"
                                                    value="Pengembangan wilayah usaha" class="check" id="square-checkbox-5"
                                                    data-checkbox="icheckbox_square-red">
                                                <label for="square-checkbox-5">Pengembangan Wilayah Usaha</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Perkiraan Bantuan <span class="text-danger">*</span></label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                        name="perkiraanDana" value="{{ old('perkiraanDana') }}" id="perkiraanDana">
                                    @if ($errors->has('perkiraanDana'))
                                        <small class="text-danger">Perkiraan dana harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Memenuhi Syarat Untuk <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="syarat">
                                            <option value="">{{ old('syarat') }}</option>
                                            <option value="Survei">Survei/Konfirmasi</option>
                                            <option value="Tidak Memenuhi Syarat">Tidak Memenuhi Syarat</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('syarat'))
                                        <small class="text-danger">Syarat harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Catatan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" maxlength="200" name="catatan"
                                        placeholder="Catatan Evaluator 1" value="Berada dalam wilayah operasi NR">
                                </div>
                                @if ($errors->has('catatan'))
                                    <small class="text-danger">Catatan harus diisi</small>
                                @endif
                            </div>
                            <div class="form-check mr-sm-2 mb-3">
                                <input type="checkbox" class="form-check-input" id="checkboxAgreement" name="smap"
                                    value="check" onclick="terms_changed(this)">
                                <label class="form-check-label" for="checkboxAgreement">Dokumen legalitas (berupa Akta
                                    pendirian lembaga atau dokumen legalitas lainnya yang disahkan oleh pejabat yang
                                    berwenang)</label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <a href="{{ route('dataKelayakan') }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        Cancel
                                    </button>
                                </a>
                                <button type="submit" disabled class="btn btn-success waves-effect text-left"
                                    id="submit_button"><i class="fa fa-save mr-2"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white">Evaluator</h4>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-sm btn-primary" data-target=".modal-evaluator"
                                data-toggle="modal"><i class="fa fa-search mr-2"></i>Cari
                            </button>
                            <hr class="mb-5">
                            <div class="form-group">
                                <label>Evaluator ke 1 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" name="evaluator1"
                                    value="{{ session('user')->nama }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Evaluator ke 2 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" name="namaEvaluator"
                                    id="namaEvaluator" readonly>
                                <input type="hidden" class="form-control" name="evaluator2" id="evaluator2">
                                @if ($errors->has('evaluator2'))
                                    <small class="text-danger">Evaluator ke 2 harus diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade modal-evaluator" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">EVALUATOR</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="example5 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="10px" style="text-align:center;">No</th>
                                    <th class="text-center" width="200px">Nama</th>
                                    <th class="text-center" width="400px">Jabatan</th>
                                    <th class="text-center" width="50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataUser as $user)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->jabatan }}</td>
                                        <td class="text-center">
                                            <a href="#!" class="pilih btn btn-sm btn-success"
                                                username="{{ $user->username }}" nama="{{ $user->nama }}">Pilih
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                            Close
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
        // $(document).ready(function () {
        //     $("#evaluator2").select2({
        //         placeholder: "Pilih Evaluator ke 2"
        //     });
        // });
    </script>

    <script>
        $(document).on('click', '.pilih', function(e) {
            document.getElementById("namaEvaluator").value = $(this).attr('nama');
            document.getElementById("evaluator2").value = $(this).attr('username');
            $('.modal-evaluator').modal('hide');
        });
    </script>


    <script>
        function bukalampiran() {
            var nilai = 0;
            if ($('.bukalampiran').is(":checked")) {
                document.getElementById("perkiraanRupiah").value = nilai;
                document.getElementById("perkiraanDana").value = nilai;
            }
        }
    </script>

    <script>
        var perkiraanDana = document.getElementById('perkiraanDana');
        perkiraanDana.addEventListener('keyup', function(e) {
            perkiraanDana.value = formatRupiah(this.value);
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
        function terms_changed(checkboxAgreement) {
            if (checkboxAgreement.checked) {
                document.getElementById("submit_button").disabled = false;
            } else {
                document.getElementById("submit_button").disabled = true;
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
