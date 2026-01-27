@extends('layout.master')
@section('title', 'NR SHARE | Survei Proposal')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">SURVEI KELAYAKAN PROPOSAL</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Survei Kelayakan Proposal</li>
                    </ol>
                </div>
            </div>
        </div>

        <form method="post" action="{{ action('SurveiController@insertSurvei') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h5 class="m-b-0 text-white font-weight-bold model-huruf-family">Survei Proposal</h5>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="noAgenda" class="form-control" value="{{ $data->no_agenda }}"
                                readonly>
                            <div class="form-group">
                                <label>Hasil Survei <span class="text-danger">*</span></label>
                                @if ($data->jenis == 'Santunan')
                                    <textarea rows="3" class="form-control" autofocus name="hasilSurvei1">Yayasan/Lembaga sangat membutuhkan bantuan dana dari perusahaan</textarea>
                                @else
                                    <textarea rows="3" class="form-control" autofocus name="hasilSurvei1"></textarea>
                                @endif
                                @if ($errors->has('hasilSurvei1'))
                                    <small class="text-danger">Hasil survei 1 untuk harus diisi</small>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Untuk Dibantu Berupa <span class="text-danger">*</span></label>
                                    <select class="form-control" name="bantuan">
                                        @if ($data->jenis == 'Santunan')
                                            <option>Dana</option>
                                        @else
                                            <option></option>
                                            <option>Dana</option>
                                            <option>Barang</option>
                                        @endif
                                    </select>
                                    @if ($errors->has('bantuan'))
                                        <small class="text-danger">Bantuan berupa harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Usulan/Rekomendasi <span class="text-danger">*</span></label>
                                    <select class="form-control" name="usulan">
                                        @if ($data->jenis == 'Santunan')
                                            <option>Disarankan</option>
                                        @else
                                            <option>Disarankan</option>
                                            <option>Dipertimbangkan</option>
                                            <option>Tidak Memenuhi Kriteria</option>
                                        @endif
                                    </select>
                                    @if ($errors->has('usulan'))
                                        <small class="text-danger">Usulan/rekomendasi harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nilai Bantuan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nilaiBantuan" id="nilaiBantuan"
                                        value="{{ number_format($data->nilai_bantuan, 0, ',', '.') }}">
                                    @if ($errors->has('nilaiBantuan'))
                                        <small class="text-danger">Nilai bantuan harus diisi</small>
                                    @endif
                                </div>
                                @if ($data->jenis == 'Santunan')
                                    <div class="form-group col-md-3">
                                        <label>Termin Pembayaran <span class="text-danger">*</span></label>
                                        <input class="form-control bg-white" type="text" name="termin" value="1"
                                            readonly>
                                        @if ($errors->has('termin'))
                                            <small class="text-danger">Termin pembayaran harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Persentase <span class="text-danger">*</span></label>
                                        <input class="form-control bg-white" type="text" name="termin1" value="100"
                                            readonly>
                                    </div>
                                @else
                                    <div class="form-group col-md-3">
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
                                    <div id="persentase" class="form-group col-md-3 persentase">
                                        <label>Persentase <span class="text-danger">*</span></label>
                                        <input maxlength="3" value="100" onkeypress="return hanyaAngka(event)"
                                            type="text" class="form-control termin1" name="termin1" id="termin1"
                                            placeholder="Termin 1" style="margin-bottom: 5px;">
                                        <input maxlength="2" onkeypress="return hanyaAngka(event)" type="text"
                                            class="form-control termin2" name="termin2" id="termin2"
                                            placeholder="Termin 2" style="margin-bottom: 5px; display: none">
                                        <input maxlength="2" onkeypress="return hanyaAngka(event)" type="text"
                                            class="form-control termin3" name="termin3" id="termin3"
                                            placeholder="Termin 3" style="margin-bottom: 5px; display: none">
                                        <input maxlength="2" style="display: none" onkeypress="return hanyaAngka(event)"
                                            type="text" class="form-control termin4" name="termin4" id="termin4"
                                            placeholder="Termin 4">
                                        <input maxlength="2" style="display: none" onkeypress="return hanyaAngka(event)"
                                            type="text" class="form-control termin5" name="termin5" id="termin5"
                                            placeholder="Termin 5">
                                    </div>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Pelaksana Survei 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control bg-white" name="survei1"
                                        value="{{ session('user')->nama }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Pelaksana Survei 2 <span class="text-danger">*</span></label>
                                    <select class="select2 form-control custom-select" name="survei2"
                                        style="width: 100%; height:36px; margin-top: 5px">
                                        <option value=""></option>
                                        @foreach ($dataUser as $user)
                                            <option value="{{ $user->username }}">{{ $user->nama }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('survei2'))
                                        <small class="text-danger">Pelaksana survei 2 harus diisi</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <a href="{{ route('todolist') }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        Cancel
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-success waves-effect text-left">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h5 class="m-b-0 text-white model-huruf-family">Program Kerja</h5>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-sm btn-primary" data-target=".modal-proker"
                                data-toggle="modal"><i class="fa fa-search mr-2"></i>Search
                            </button>
                            <hr>
                            <div class="form-group">
                                <label>Program Kerja <span class="text-danger">*</span></label>
                                <input type="hidden" class="form-control" name="prokerID" id="prokerID">
                                <textarea rows="3" class="form-control text-dark bg-white" placeholder="Otomatis by system" name="proker"
                                    id="proker" readonly></textarea>
                                @if ($errors->has('proker'))
                                    <small class="text-danger">Program Kerja harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Pilar <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" name="pilar" id="pilar"
                                    placeholder="Otomatis by system" readonly>
                                @if ($errors->has('pilar'))
                                    <small class="text-danger">Pilar SDGs harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Goals <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" name="tpb" id="tpb"
                                    placeholder="Otomatis by system" readonly>
                                @if ($errors->has('tpb'))
                                    <small class="text-danger">Gols SDGs harus diisi</small>
                                @endif
                            </div>
                            {{--                            <div class="form-group"> --}}
                            {{--                                <label>Prioritas <span class="text-danger">*</span></label> --}}
                            {{--                                <select class="form-control" name="prioritas"> --}}
                            {{--                                    <option></option> --}}
                            {{--                                    <option>Pendidikan</option> --}}
                            {{--                                    <option>Lingkungan</option> --}}
                            {{--                                    <option>UMK</option> --}}
                            {{--                                    <option>Sosial/Ekonomi</option> --}}
                            {{--                                </select> --}}
                            {{--                                @if ($errors->has('prioritas')) --}}
                            {{--                                    <small class="text-danger">Prioritas harus diisi</small> --}}
                            {{--                                @endif --}}
                            {{--                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade modal-proker" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold model-huruf-family">DAFTAR PROGRAM KERJA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="example5 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="10px" style="text-align:center;" nowrap>Proker ID</th>
                                    <th class="text-center" width="400px">Program Kerja</th>
                                    <th class="text-center" width="300px">SDGs</th>
                                    <th class="text-center" width="50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataProker as $proker)
                                    <tr>
                                        <td style="text-align:center;">{{ '#' . $proker->id_proker }}</td>
                                        <td>{{ $proker->proker }}</td>
                                        <td>
                                            <span class="font-weight-bold">{{ $proker->pilar }}</span>
                                            <br>
                                            <span class="text-muted">{{ $proker->gols }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#!" class="pilih btn btn-sm btn-success"
                                                prokerID="{{ $proker->id_proker }}" proker="{{ $proker->proker }}"
                                                pilar="{{ $proker->pilar }}" gols="{{ $proker->gols }}"><i
                                                    class="fa fa-check"></i>
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
                document.getElementById("termin5").value = '';
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

    <script>
        $(document).on('click', '.pilih', function(e) {
            document.getElementById("prokerID").value = $(this).attr('prokerID');
            document.getElementById("proker").value = $(this).attr('proker');
            document.getElementById("pilar").value = $(this).attr('pilar');
            document.getElementById("tpb").value = $(this).attr('gols');
            $('.modal-proker').modal('hide');
        });
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
@stop
