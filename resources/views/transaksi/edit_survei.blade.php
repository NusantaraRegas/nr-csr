@extends('layout.master')
@section('title', 'PGN SHARE | Survei Proposal')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="model-huruf-family font-weight-bold">SURVEI PROPOSAL</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Survei Proposal</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form method="post" action="{{ action('SurveiController@editSurvei') }}">
                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white">Form Survei Proposal</h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">Edit Survei</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" name="status" value="{{ $data->status }}">
                                    <h4 class="card-title">Data Proposal</h4>
                                    <h6 class="card-subtitle">Sesuai dengan input proposal di e-sms</h6>
                                    <hr>
                                    <div
                                        class="form-group form-material {{ $errors->has('noAgenda') ? ' has-danger' : '' }}">
                                        <label>No Agenda :</label>
                                        <input type="text" name="noAgenda" class="form-control"
                                            value="{{ $data->no_agenda }}" readonly>
                                    </div>
                                    <div
                                        class="form-group form-material {{ $errors->has('pengirim') ? ' has-danger' : '' }}">
                                        <label>Pengirim :</label>
                                        <input type="text" class="form-control" name="pengirim"
                                            value="{{ $data->pengirim }}" readonly>
                                    </div>
                                    <div
                                        class="form-group form-material {{ $errors->has('tglPenerimaan') ? ' has-danger' : '' }}">
                                        <label>Tanggal Penerimaan :</label>
                                        <input type="text" class="form-control" name="tglPenerimaan"
                                            value="{{ date('d-m-Y', strtotime($data->tgl_terima)) }}" readonly>
                                    </div>
                                    <div class="form-group form-material {{ $errors->has('sifat') ? ' has-danger' : '' }}">
                                        <label>Sifat Proposal :</label>
                                        <input type="text" class="form-control" name="pengirim"
                                            value="{{ $data->sifat }}" readonly>
                                    </div>
                                    <div class="form-group form-material {{ $errors->has('dari') ? ' has-danger' : '' }}">
                                        <label>Surat/Proposal Dari :</label>
                                        <input type="text" class="form-control" name="dari"
                                            value="{{ $data->asal_surat }}" readonly>
                                        @if ($errors->has('dari'))
                                            <small class="text-danger">Proposal dari harus diisi</small>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group form-material {{ $errors->has('noSurat') ? ' has-danger' : '' }}">
                                        <label>Nomor Surat/Proposal :</label>
                                        <input type="text" class="form-control" name="noSurat"
                                            value="{{ $data->no_surat }}" readonly>
                                        @if ($errors->has('noSurat'))
                                            <small class="text-danger">Nomor proposal harus diisi</small>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group form-material {{ $errors->has('tglSurat') ? ' has-danger' : '' }}">
                                        <label>Tanggal Surat/Proposal :</label>
                                        <input type="text" class="form-control" name="tglSurat"
                                            value="{{ date('d-m-Y', strtotime($data->tgl_surat)) }}" readonly>
                                        @if ($errors->has('tglSurat'))
                                            <small class="text-danger">Tanggal proposal harus diisi</small>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group form-material {{ $errors->has('perihal') ? ' has-danger' : '' }}">
                                        <label>Perihal Surat/Proposal :</label>
                                        <textarea rows="3" class="form-control" name="perihal" readonly>{{ $data->perihal }}</textarea>
                                        @if ($errors->has('perihal'))
                                            <small class="text-danger">Perihal proposal harus diisi</small>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group form-material {{ $errors->has('alamat') ? ' has-danger' : '' }}">
                                        <label>Alamat Surat/Proposal :</label>
                                        <textarea rows="3" class="form-control" readonly name="alamat">{{ $data->alamat }}</textarea>
                                        @if ($errors->has('alamat'))
                                            <small class="text-danger">Alamat proposal harus diisi</small>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group form-material {{ $errors->has('provinsi') ? ' has-danger' : '' }}">
                                        <label>Provinsi :</label>
                                        <input type="text" class="form-control" name="pengirim"
                                            value="{{ $data->provinsi }}" readonly>
                                        @if ($errors->has('provinsi'))
                                            <small class="text-danger">Provinsi harus diisi</small>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group form-material {{ $errors->has('kabupaten') ? ' has-danger' : '' }}">
                                        <label>Kabupaten/Kota :</label>
                                        <input type="text" class="form-control" name="pengirim"
                                            value="{{ $data->kabupaten }}" readonly>
                                        @if ($errors->has('kabupaten'))
                                            <small class="text-danger">Kabupaten proposal harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="card-title">Contact Person</h4>
                                    <h6 class="card-subtitle">Contact person pengaju proposal</h6>
                                    <hr>
                                    <div class="form-group form-material {{ $errors->has('pengajuProposal') ? ' ' : '' }}">
                                        <label>Nama :</label>
                                        <input type="text" class="form-control" name="pengajuProposal"
                                            value="{{ $data->pengaju_proposal }}" readonly>
                                        @if ($errors->has('pengajuProposal'))
                                            <small class="text-danger">Nama harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group form-material {{ $errors->has('email') ? ' ' : '' }}">
                                        <label>Email :</label>
                                        <input type="text" class="form-control" name="email"
                                            value="{{ $data->email_pengaju }}" readonly>
                                        @if ($errors->has('email'))
                                            <small class="text-danger">Email harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group form-material {{ $errors->has('noTelp') ? ' ' : '' }}">
                                        <label>No Telepon :</label>
                                        <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                            name="noTelp" value="{{ $data->contact_person }}" readonly>
                                        @if ($errors->has('noTelp'))
                                            <small class="text-danger">No Telepon harus diisi</small>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group form-material {{ $errors->has('bertindakSebagai') ? ' ' : '' }}">
                                        <label>Bertindak Sebagai :</label>
                                        <input type="text" class="form-control" name="bertindakSebagai"
                                            value="{{ $data->sebagai }}" readonly>
                                        @if ($errors->has('bertindakSebagai'))
                                            <small class="text-danger">Bertindak sebagai harus diisi</small>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group form-material {{ $errors->has('besarPermohonan') ? ' has-danger' : '' }}">
                                        <label>Besar Permohonan :</label>
                                        <input type="text" class="form-control" name="besarPermohonan"
                                            value="{{ '' . number_format($data->nilai_pengajuan, 0, ',', '.') }}"
                                            readonly>
                                        @if ($errors->has('besarPermohonan'))
                                            <small class="text-danger">Besar permohonan harus diisi</small>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group form-material {{ $errors->has('digunakanUntuk') ? ' has-danger' : '' }}">
                                        <label>Digunakan Untuk :</label>
                                        <input type="text" class="form-control" name="digunakanUntuk"
                                            value="{{ $data->bantuan_untuk }}" readonly>
                                        @if ($errors->has('digunakanUntuk'))
                                            <small class="text-danger">Digunakan untuk harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group form-material">
                                        <label>Ruang Lingkup Bantuan :</label>
                                        <input type="text" class="form-control" name="digunakanUntuk"
                                            value="{{ $data->sektor_bantuan }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="card-title">Survei Proposal</h4>
                                    <h6 class="card-subtitle">Input hasil survei proposal</h6>
                                    <hr>
                                    @if ($dataEvaluasi->syarat == 'Konfirmasi')
                                        <div class="form-group {{ $errors->has('konfirmasi') ? ' has-danger' : '' }}">
                                            <label>Hasil Konfirmasi <span class="text-danger">*</span></label>
                                            <textarea rows="4" class="form-control" name="konfirmasi">{{ $data->hasil_konfirmasi }}</textarea>
                                            @if ($errors->has('konfirmasi'))
                                                <small class="text-danger">Hasil konfirmasi untuk harus diisi</small>
                                            @endif
                                        </div>
                                    @elseif($dataEvaluasi->syarat == 'Survei')
                                        <div class="form-group {{ $errors->has('survei') ? ' has-danger' : '' }}">
                                            <label>Hasil Survei <span class="text-danger">*</span></label>
                                            <textarea rows="4" class="form-control" name="survei">{{ $data->hasil_survei }}</textarea>
                                            @if ($errors->has('survei'))
                                                <small class="text-danger">Hasil survei untuk harus diisi</small>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>Usulan/Rekomendasi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <ul class="icheck-list">
                                                <li>
                                                    <input {{ $data->usulan == 'Disarankan' ? 'checked' : '' }}
                                                        type="radio" value="Disarankan" class="check" id="disarankan"
                                                        name="usulan" data-radio="iradio_flat-red">
                                                    <label for="disarankan">Disarankan</label>
                                                </li>
                                                <li>
                                                    <input {{ $data->usulan == 'Dipertimbangkan' ? 'checked' : '' }}
                                                        type="radio" value="Dipertimbangkan" class="check"
                                                        id="dipertimbangkan" name="usulan" data-radio="iradio_flat-red">
                                                    <label for="dipertimbangkan">Dipertimbangkan</label>
                                                </li>
                                                <li>
                                                    <input
                                                        {{ $data->usulan == 'Tidak Memenuhi Kriteria' ? 'checked' : '' }}
                                                        type="radio" value="Tidak Memenuhi Kriteria" class="check"
                                                        id="tidak" name="usulan" data-radio="iradio_flat-red">
                                                    <label for="tidak">Tidak Memenuhi Kriteria</label>
                                                </li>
                                            </ul>
                                        </div>
                                        @if ($errors->has('usulan'))
                                            <small class="text-danger">Usulan/rekomendasi harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Untuk Dibantu Berupa <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <ul class="icheck-list">
                                                <li>
                                                    <input {{ $data->bantuan_berupa == 'Barang' ? 'checked' : '' }}
                                                        type="radio" value="Barang" class="check" id="barang"
                                                        name="bantuan" data-radio="iradio_flat-red">
                                                    <label for="barang">Barang</label>
                                                </li>
                                                <li>
                                                    <input {{ $data->bantuan_berupa == 'Dana' ? 'checked' : '' }}
                                                        type="radio" value="Dana" class="check" id="dana"
                                                        name="bantuan" data-radio="iradio_flat-red">
                                                    <label for="dana">Dana</label>
                                                </li>
                                            </ul>
                                        </div>
                                        @if ($errors->has('bantuan'))
                                            <small class="text-danger">Bantuan berupa harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('nilaiBantuan') ? ' has-danger' : '' }}">
                                        <label>Nilai Bantuan <span class="text-danger">*</span></label>
                                        <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                            id="nilaiRupiah"
                                            value="{{ '' . number_format($data->nilai_bantuan, 0, ',', '.') }}">
                                        <input type="hidden" class="form-control" name="nilaiBantuan" id="nilaiBantuan"
                                            value="{{ $data->nilai_bantuan }}">
                                        @if ($errors->has('nilaiBantuan'))
                                            <small class="text-danger">Nilai bantuan harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Termin Pembayaran <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <ul class="icheck-list">
                                                <li>
                                                    <input onclick="bukaTermin1()"
                                                        @if ($data->termin == 1) checked @endif
                                                        class="bukaTermin1" type="radio" value="1" id="1"
                                                        name="termin" data-radio="iradio_flat-red">
                                                    <label for="1">1 &nbsp;Termin</label>
                                                </li>
                                                <li>
                                                    <input onclick="bukaTermin2()"
                                                        @if ($data->termin == 2) checked @endif
                                                        class="bukaTermin2" type="radio" value="2" id="2"
                                                        name="termin" data-radio="iradio_flat-red">
                                                    <label for="2">2 Termin</label>
                                                </li>
                                                <li>
                                                    <input onclick="bukaTermin3()"
                                                        @if ($data->termin == 3) checked @endif
                                                        class="bukaTermin3" type="radio" value="3" id="3"
                                                        name="termin" data-radio="iradio_flat-red">
                                                    <label id="perkiraan" for="3">3 Termin</label>
                                                </li>
                                                <li>
                                                    <input onclick="bukaTermin4()"
                                                        @if ($data->termin == 4) checked @endif
                                                        class="bukaTermin4" onclick="bukalampiran()" type="radio"
                                                        value="4" id="4" name="termin"
                                                        data-radio="iradio_flat-red">
                                                    <label id="perkiraan" for="4">4 Termin</label>
                                                </li>
                                            </ul>
                                        </div>
                                        @if ($errors->has('termin'))
                                            <small class="text-danger">Termin pembayaran harus diisi</small>
                                        @endif
                                    </div>
                                    <div id="persentase"
                                        class="form-group persentase {{ $errors->has('nilaiBantuan') ? ' has-danger' : '' }}">
                                        <label>Persentase Termin
                                            <small>(isi dengan nilai persen)</small>
                                            <span class="text-danger">*</span></label>
                                        <input maxlength="3" value="{{ $data->persen1 }}"
                                            onkeypress="return hanyaAngka(event)" type="text"
                                            class="form-control termin1" name="termin1" id="termin1"
                                            placeholder="Termin 1" style="margin-bottom: 5px;">
                                        <input maxlength="2" value="{{ $data->persen2 }}"
                                            onkeypress="return hanyaAngka(event)" type="text"
                                            class="form-control termin2" name="termin2" id="termin2"
                                            placeholder="Termin 2" style="margin-bottom: 5px;">
                                        <input maxlength="2" value="{{ $data->persen3 }}"
                                            onkeypress="return hanyaAngka(event)" type="text"
                                            class="form-control termin3" name="termin3" id="termin3"
                                            placeholder="Termin 3" style="margin-bottom: 5px;">
                                        <input maxlength="2" value="{{ $data->persen4 }}"
                                            onkeypress="return hanyaAngka(event)" type="text"
                                            class="form-control termin4" name="termin4" id="termin4"
                                            placeholder="Termin 4">
                                    </div>
                                    <div class="form-group {{ $errors->has('survei1') ? ' has-danger' : '' }}">
                                        <label>Surveyor 1 <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white" name="survei1"
                                            value="{{ session('user')->nama }}" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('survei2') ? ' has-danger' : '' }}">
                                        <label>Surveyor 2 <span class="text-danger">*</span></label>
                                        <select class="select2 form-control custom-select" name="survei2"
                                            style="width: 100%; height:36px; margin-top: 5px">
                                            <?php
                                            $survei2 = DB::table('tbl_user')->select('tbl_user.*')->where('username', $data->survei2)->first();
                                            ?>
                                            <option value="{{ $survei2->username }}">{{ $survei2->nama }}</option>
                                            @foreach ($dataUser as $user)
                                                <option value="{{ $user->username }}">{{ $user->nama }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('survei2'))
                                            <small class="text-danger">Surveyor 2 harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <a href="{{ route('dataKelayakan') }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        Cancel
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check"></i> Save Changes
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
        var nilai = '';

        function bukaTermin1() {
            if ($('.bukaTermin1').is(":checked")) {
                document.getElementById("termin1").value = 100;
                document.getElementById("termin2").value = nilai;
                document.getElementById("termin3").value = nilai;
                document.getElementById("termin4").value = nilai;
            }
        }

        function bukaTermin2() {
            if ($('.bukaTermin2').is(":checked")) {
                document.getElementById("termin1").value = 50;
                document.getElementById("termin2").value = 50;
                document.getElementById("termin3").value = nilai;
                document.getElementById("termin4").value = nilai;
            }
        }

        function bukaTermin3() {
            if ($('.bukaTermin3').is(":checked")) {
                document.getElementById("termin1").value = 50;
                document.getElementById("termin2").value = 30;
                document.getElementById("termin3").value = 20;
                document.getElementById("termin4").value = nilai;
            }
        }

        function bukaTermin4() {
            if ($('.bukaTermin4').is(":checked")) {
                document.getElementById("termin1").value = 25;
                document.getElementById("termin2").value = 25;
                document.getElementById("termin3").value = 25;
                document.getElementById("termin4").value = 25;
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
@stop
