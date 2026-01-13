@extends('layout.master')
@section('title', 'NR SHARE | Edit Evaluasi')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container model-huruf-family">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold">EVALUASI PROPOSAL</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Evaluasi</li>
                    </ol>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <form id="myForm" method="post" action="{{ action('EvaluasiController@editEvaluasi') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">EDIT EVALUASI</h4>
                            <h6 class="card-subtitle mb-5">{{ $data->no_agenda }}</h6>
                            <input class="form-control" type="hidden" name="noAgenda" value="{{ $data->no_agenda }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Rencana Anggaran <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select class="form-control" name="rencanaAnggaran">
                                                <option>{{ $data->rencana_anggaran }}</option>
                                                <option>ADA</option>
                                                <option>TIDAK ADA</option>
                                            </select>
                                        </div>
                                        @if($errors->has('rencanaAnggaran'))
                                            <small class="text-danger">Rencana anggaran harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Dokumentasi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select class="form-control" name="dokumen">
                                                <option>{{ $data->dokumen }}</option>
                                                <option>ADA</option>
                                                <option>TIDAK ADA</option>
                                            </select>
                                        </div>
                                        @if($errors->has('dokumen'))
                                            <small class="text-danger">Dokumentasi harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Denah Lokasi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select class="form-control" name="denah">
                                                <option>{{ $data->denah }}</option>
                                                <option>ADA</option>
                                                <option>TIDAK ADA</option>
                                            </select>
                                        </div>
                                        @if($errors->has('denah'))
                                            <small class="text-danger">Denah lokasi harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Perkiraan Bantuan <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" onkeypress="return hanyaAngka(event)"
                                               class="form-control perkiraanRupiah"
                                               id="perkiraanRupiah"
                                               value="{{ number_format($dataKelayakan->nilai_bantuan,0,',','.') }}">
                                        <input type="hidden" onkeypress="return hanyaAngka(event)" class="form-control"
                                               name="perkiraanDana" id="perkiraanDana"
                                               value="{{ $dataKelayakan->nilai_bantuan }}">
                                        @if($errors->has('perkiraanDana'))
                                            <small class="text-danger">Perkiraan dana harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Kepentingan Perusahaan <span
                                                    class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <ul class="icheck-list">
                                                <?php
                                                $data1 = \App\Models\DetailKriteria::where('no_agenda', $data->no_agenda)->where('kriteria', 'Wilayah Operasi NR (Ring I / II / III)')->count();
                                                $data2 = \App\Models\DetailKriteria::where('no_agenda', $data->no_agenda)->where('kriteria', 'Kelancaran Operasional/asset NR')->count();
                                                $data3 = \App\Models\DetailKriteria::where('no_agenda', $data->no_agenda)->where('kriteria', 'Menjaga hubungan baik shareholders/stakeholders')->count();
                                                $data4 = \App\Models\DetailKriteria::where('no_agenda', $data->no_agenda)->where('kriteria', 'Brand images/citra perusahaan')->count();
                                                $data5 = \App\Models\DetailKriteria::where('no_agenda', $data->no_agenda)->where('kriteria', 'Pengembangan wilayah usaha')->count();
                                                ?>
                                                @if($data1 > 0)
                                                    <li>
                                                        <input type="checkbox" name="wilayahOperasi"
                                                               value="Wilayah Operasi NR (Ring I / II / III)"
                                                               class="check" checked
                                                               id="square-checkbox-1"
                                                               data-checkbox="icheckbox_square-red">
                                                        <label for="square-checkbox-1">Wilayah Operasi NR (Ring
                                                            I/II/III)</label>
                                                    </li>
                                                @else
                                                    <li>
                                                        <input type="checkbox" name="wilayahOperasi"
                                                               value="Wilayah Operasi NR (Ring I / II / III)"
                                                               class="check"
                                                               id="square-checkbox-1"
                                                               data-checkbox="icheckbox_square-red">
                                                        <label for="square-checkbox-1">Wilayah Operasi NR (Ring
                                                            I/II/III)</label>
                                                    </li>
                                                @endif
                                                @if($data2 > 0)
                                                    <li>
                                                        <input type="checkbox" name="kelancaranOperasional"
                                                               value="Kelancaran Operasional/asset NR" class="check"
                                                               id="square-checkbox-2" checked
                                                               data-checkbox="icheckbox_square-red">
                                                        <label for="square-checkbox-2">Kelancaran Operasional/Asset
                                                            NR</label>
                                                    </li>
                                                @else
                                                    <li>
                                                        <input type="checkbox" name="kelancaranOperasional"
                                                               value="Kelancaran Operasional/asset NR" class="check"
                                                               id="square-checkbox-2"
                                                               data-checkbox="icheckbox_square-red">
                                                        <label for="square-checkbox-2">Kelancaran Operasional/Asset
                                                            NR</label>
                                                    </li>
                                                @endif
                                                @if($data3 > 0)
                                                    <li>
                                                        <input type="checkbox" name="hubunganBaik"
                                                               value="Menjaga hubungan baik shareholders/stakeholders"
                                                               class="check" id="square-checkbox-3" checked
                                                               data-checkbox="icheckbox_square-red">
                                                        <label for="square-checkbox-3">Menjaga Hubungan Baik
                                                            Stakeholders</label>
                                                    </li>
                                                @else
                                                    <li>
                                                        <input type="checkbox" name="hubunganBaik"
                                                               value="Menjaga hubungan baik shareholders/stakeholders"
                                                               class="check" id="square-checkbox-3"
                                                               data-checkbox="icheckbox_square-red">
                                                        <label for="square-checkbox-3">Menjaga Hubungan Baik
                                                            Stakeholders</label>
                                                    </li>
                                                @endif
                                                <li>
                                                    <input type="checkbox" name="brandImage"
                                                           value="Brand images/citra perusahaan" class="check"
                                                           id="square-checkbox-4" data-checkbox="icheckbox_square-red">
                                                    <label for="square-checkbox-4">Brand Images/Citra Perusahaan</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" name="pengembanganWilayah"
                                                           value="Pengembangan wilayah usaha" class="check"
                                                           id="square-checkbox-5" data-checkbox="icheckbox_square-red">
                                                    <label for="square-checkbox-5">Pengembangan Wilayah Usaha</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Memenuhi Syarat Untuk <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select class="form-control" name="syarat">
                                                @if($data->syarat == 'Survei')
                                                    <option value="{{ $data->syarat }}">Survei/Konfirmasi</option>
                                                @elseif($data->syarat == 'Tidak Memenuhi Syarat')
                                                    <option value="{{ $data->syarat }}">Tidak Memenuhi Syarat</option>
                                                @else
                                                    <option value=""></option>
                                                @endif
                                                <option value="Survei">Survei/Konfirmasi</option>
                                                <option value="Tidak Memenuhi Syarat">Tidak Memenuhi Syarat</option>
                                            </select>
                                        </div>
                                        @if($errors->has('syarat'))
                                            <small class="text-danger">Syarat harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Evaluator 1</label>
                                        <select class="form-control" name="evaluator1" readonly>
                                            <option value="{{ $evaluator1->username }}">{{ $evaluator1->nama }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Evaluator 2 <span class="text-danger">*</span></label>
                                        <select class="select2 form-control custom-select" name="evaluator2"
                                                style="width: 100%; height:36px; margin-top: 5px">
                                            <option value="{{ $evaluator2->username }}">{{ $evaluator2->nama }}</option>
                                            @foreach($dataUser as $user)
                                                <option value="{{ $user->username }}">{{ $user->nama }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('evaluator2'))
                                            <small class="text-danger">Evaluator 2 harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Catatan <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" maxlength="200" name="catatan"
                                                  placeholder="Catatan Evaluator 1">{{ $data->catatan1 }}</textarea>
                                        @if($errors->has('catatan'))
                                            <small class="text-danger">Catatan harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <a href="{{ route('detail-kelayakan', encrypt($data->no_agenda)) }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        <i class="fa fa-times-circle mr-2"></i>Cancel
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-success waves-effect text-left"><i
                                            class="fa fa-save mr-2"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
    </div>
@endsection

@section('footer')
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
        var perkiraanRupiah = document.getElementById('perkiraanRupiah');
        perkiraanRupiah.addEventListener('keyup', function (e) {
            perkiraanRupiah.value = formatRupiah(this.value);
            perkiraanDana.value = convertToAngka(this.value);
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
@stop