@extends('layout.master')
@section('title', 'NR SHARE | Mapping Program Kerja')
@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>
    <div class="container-fluid model-huruf-family">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">MAPPING PROGRAM KERJA TAHUN {{ $tahun }}</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">To-Do List</li>
                        <li class="breadcrumb-item active">Mapping Program Kerja</li>
                    </ol>
                    <button class="btn btn-info d-lg-block ml-3" data-target=".modalFilterAnnual"
                            data-toggle="modal"><i class="fa fa-filter mr-2"></i>Budget Year</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family">REALISASI CSR 517</h4>
                        <h6 class="card-subtitle mb-5 model-huruf-family">Source: popay.pgn.co.id</h6>
                        <div class="table-responsive">
                            <table class="example5 table table-striped table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th style="text-align: center" width="150px">Tanggal</th>
                                    <th style="text-align: center" width="100px" nowrap>PR ID</th>
                                    <th style="text-align: center" width="100px">Status</th>
                                    <th style="text-align: center" width="600px">Deskripsi</th>
                                    <th style="text-align: center" width="200px">Jumlah</th>
                                    <th style="text-align: center" width="200px">Pengurangan</th>
                                    <th style="text-align: center" width="200px">Total</th>
                                    <th style="text-align: center" width="50px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataPayment as $data)
                                    <tr>
                                        <td class="text-center" nowrap>
                                            {{ date('d-m-Y', strtotime($data['created_at'])) }}<br>
                                            <span class="text-muted">{{ date('H:i:s', strtotime($data['created_at'])) }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{ $data['id'] }}
                                        </td>
                                        <td class="text-center">
                                            @if($data['status'] == 'DRAFT')
                                                <span class="badge text-dark"
                                                      style="background-color: #FFA900">{{ $data['status'] }}</span>
                                            @elseif($data['status'] == 'IN PROGRESS')
                                                <span class="badge text-white"
                                                      style="background-color: #1dc4e9">{{ $data['status'] }}</span>
                                            @elseif($data['status'] == 'PAID')
                                                <span class="badge text-white"
                                                      style="background-color: #1de9b6">{{ $data['status'] }}</span>
                                            @elseif($data['status'] == 'RELEASED')
                                                <span class="badge text-white"
                                                      style="background-color: #B23CFD">{{ $data['status'] }}</span>
                                            @elseif($data['status'] == 'REJECTED')
                                                <span class="badge text-white"
                                                      style="background-color: #f44236">{{ $data['status'] }}</span>
                                            @elseif($data['status'] == 'READY TO RELEASE')
                                                <span class="badge text-white"
                                                      style="background-color: #00B74A">{{ $data['status'] }}</span>
                                            @else
                                                <span class="badge badge-info">{{ $data['status'] }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <b class="font-weight-bold"
                                               style="color: #f44236">{{ $data['invoice_num'] }}</b>
                                            <br>
                                            {{ $data['description_detail'] }}
                                        </td>
                                        <td class="text-right" nowrap>{{ number_format($data['invoice_amount'],0,',','.') }}</td>
                                        <td class="text-right" nowrap>
                                            @if($data['invoice_refund'] > 0)
                                                {{ number_format($data['invoice_refund'],0,',','.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-right" nowrap>{{ number_format($data['invoice_amount_paid'],0,',','.') }}</td>
                                        <td class="text-center">
                                            @if($tahun > 2022)
                                            <button type="button" class="btn btn-sm btn-success editPopayV4"
                                                    data-id="{{ $data['id'] }}"
                                                    data-provinsi="{{ $data['attribute3'] }}"
                                                    data-kabupaten="{{ $data['attribute4'] }}"
                                                    data-target=".modal-editPopayV4" data-toggle="modal">Mapping</button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-success edit"
                                                        data-id="{{ $data['id'] }}"
                                                        data-provinsi="{{ $data['attribute3'] }}"
                                                        data-kabupaten="{{ $data['attribute4'] }}"
                                                        data-target=".modal-edit" data-toggle="modal">Mapping</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('APIController@updatePaymentRequest') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family">UPDATE ATTRIBUTE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="paymentID" id="paymentID" readonly>
                        <input type="hidden" class="form-control" name="prokerID" id="prokerID" readonly>
                        <button type="button" class="btn btn-sm btn-secondary active" data-target=".modal-proker"
                                data-toggle="modal"><i
                                    class="fa fa-search mr-2"></i>Cari Program Kerja
                        </button>
                        <hr>
                        <div class="form-group mt-4">
                            <label>Program Kerja</label>
                            <textarea rows="2" class="form-control bg-white text-dark" name="proker" id="proker"
                                      readonly>Otomatis By System</textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Ketegori</label>
                                <select class="form-control" onchange="bukaWilayah()" id="kategori" name="kategori">
                                    <option value="Proposal">Realisasi Proposal</option>
                                    <option value="Operasional">Operasional</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 prioritas">
                                <label>Prioritas</label>
                                <input type="text" class="form-control bg-white text-dark" id="prioritas" name="prioritas"
                                       placeholder="Otomatis By System" readonly>
                            </div>
                        </div>
                        <div class="wilayah">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Pilar</label>
                                    <input type="text" class="form-control bg-white text-dark" name="pilar" id="pilar"
                                           placeholder="Otomatis By System" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Gols</label>
                                    <input type="text" class="form-control bg-white text-dark" name="gols" id="gols"
                                           placeholder="Otomatis By System" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Provinsi</label>
                                    <select class="form-control" name="provinsi" id="provinsi">
                                        <option></option>
                                        @foreach($dataProvinsi as $provinsi)
                                            <option>{{ ucwords($provinsi->provinsi) }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('provinsi'))
                                        <small class="text-danger">Provinsi harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kota/Kabupaten</label>
                                    <select class="form-control" name="kabupaten" id="kabupaten">
                                        <option></option>
                                        @foreach($dataKabupaten as $kabupaten)
                                            <option>{{ ucwords($kabupaten->city_name) }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('kabupaten'))
                                        <small class="text-danger">Kota/Kabupaten harus diisi</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check-circle mr-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('APIController@updatePaymentRequestPopayV4') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-editPopayV4" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family">UPDATE ATTRIBUTE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="paymentID" id="paymentIDPopayV4" readonly>
                        <input type="hidden" class="form-control" name="prokerID" id="prokerIDPopayV4" readonly>
                        <button type="button" class="btn btn-sm btn-secondary active" data-target=".modal-prokerPopayV4"
                                data-toggle="modal"><i
                                    class="fa fa-search mr-2"></i>Cari Program Kerja
                        </button>
                        <hr>
                        <div class="form-group mt-4">
                            <label>Program Kerja</label>
                            <textarea rows="2" class="form-control bg-white text-dark" name="proker" id="prokerPopayV4"
                                      readonly>Otomatis By System</textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Ketegori</label>
                                <select class="form-control" onchange="bukaWilayahPopayV4()" id="kategoriPopayV4" name="kategori">
                                    <option value="Proposal">Realisasi Proposal</option>
                                    <option value="Operasional">Operasional</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 prioritasPopayV4">
                                <label>Prioritas</label>
                                <input type="text" class="form-control bg-white text-dark" id="prioritasPopayV4" name="prioritas"
                                       placeholder="Otomatis By System" readonly>
                            </div>
                        </div>
                        <div class="wilayahPopayV4">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Pilar</label>
                                    <input type="text" class="form-control bg-white text-dark" name="pilar" id="pilarPopayV4"
                                           placeholder="Otomatis By System" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Gols</label>
                                    <input type="text" class="form-control bg-white text-dark" name="gols" id="golsPopayV4"
                                           placeholder="Otomatis By System" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Provinsi</label>
                                    <select class="form-control" name="provinsi" id="provinsiPopayV4">
                                        <option></option>
                                        @foreach($dataProvinsi as $provinsi)
                                            <option>{{ ucwords($provinsi->provinsi) }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('provinsi'))
                                        <small class="text-danger">Provinsi harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kota/Kabupaten</label>
                                    <select class="form-control" name="kabupaten" id="kabupatenPopayV4">
                                        <option></option>
                                        @foreach($dataKabupaten as $kabupaten)
                                            <option>{{ ucwords($kabupaten->city_name) }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('kabupaten'))
                                        <small class="text-danger">Kota/Kabupaten harus diisi</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check-circle mr-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade modal-proker" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title model-huruf-family font-weight-bold">DAFTAR PROGRAM KERJA</h4>
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
                            @foreach($dataProker as $proker)
                                <tr>
                                    <td style="text-align:center;">{{ "#".$proker->id_proker }}</td>
                                    <td>
                                        <span class="font-weight-bold">{{ $proker->proker }}</span>
                                        @if($proker->prioritas != "")
                                            <br>
                                            <span class="text-muted">{{ $proker->prioritas }}</span>
                                        @else
                                            <br>
                                            <span class="text-muted">Sosial/Ekonomi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="font-weight-bold">{{ $proker->pilar }}</span>
                                        <br>
                                        <span class="text-muted">{{ $proker->gols }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="#!" class="pilih btn btn-sm btn-success"
                                           prokerID="{{ $proker->id_proker }}" proker="{{ $proker->proker }}"
                                           prioritas="{{ $proker->prioritas }}"
                                           pilar="{{ $proker->pilar }}" gols="{{ $proker->gols }}">Pilih
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
        </div>
    </div>

    <div class="modal fade modal-prokerPopayV4" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title model-huruf-family font-weight-bold">DAFTAR PROGRAM KERJA</h4>
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
                            @foreach($dataProker as $proker)
                                <tr>
                                    <td style="text-align:center;">{{ "#".$proker->id_proker }}</td>
                                    <td>
                                        <span class="font-weight-bold">{{ $proker->proker }}</span>
                                        @if($proker->prioritas != "")
                                            <br>
                                            <span class="text-muted">{{ $proker->prioritas }}</span>
                                        @else
                                            <br>
                                            <span class="text-muted">Sosial/Ekonomi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="font-weight-bold">{{ $proker->pilar }}</span>
                                        <br>
                                        <span class="text-muted">{{ $proker->gols }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="#!" class="pilihPopayV4 btn btn-sm btn-success"
                                           prokerID="{{ $proker->id_proker }}" proker="{{ $proker->proker }}"
                                           prioritas="{{ $proker->prioritas }}"
                                           pilar="{{ $proker->pilar }}" gols="{{ $proker->gols }}">Pilih
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
        </div>
    </div>

    <form method="post" action="{{ action('PembayaranController@postTaskMappingAnnual') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterAnnual" tabindex="-1" role="dialog" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i class="fa fa-filter mr-2"></i>Budget Year</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label>Tahun <span
                                        class="text-danger">*</span></label>
                            <select class="form-control mb-2" name="tahun">
                                <option value="" disabled selected>Pilih Tahun</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                            </select>
                            @if($errors->has('tahun'))
                                <small class="text-danger mt-0">Tahun anggaran harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-search mr-2"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $(document).on('click', '.edit', function (e) {
            document.getElementById("paymentID").value = $(this).attr('data-id');
            document.getElementById("provinsi").value = $(this).attr('data-provinsi');
            document.getElementById("kabupaten").value = $(this).attr('data-kabupaten');
        });
    </script>

    <script>
        $(document).on('click', '.editPopayV4', function (e) {
            document.getElementById("paymentIDPopayV4").value = $(this).attr('data-id');
            document.getElementById("provinsiPopayV4").value = $(this).attr('data-provinsi');
            document.getElementById("kabupatenPopayV4").value = $(this).attr('data-kabupaten');
        });
    </script>

    <script>
        $(document).on('click', '.pilih', function (e) {
            document.getElementById("prokerID").value = $(this).attr('prokerID');
            document.getElementById("proker").value = $(this).attr('proker');
            document.getElementById("prioritas").value = $(this).attr('prioritas');
            document.getElementById("pilar").value = $(this).attr('pilar');
            document.getElementById("gols").value = $(this).attr('gols');
            $('.modal-proker').modal('hide');
        });
    </script>

    <script>
        $(document).on('click', '.pilihPopayV4', function (e) {
            document.getElementById("prokerIDPopayV4").value = $(this).attr('prokerID');
            document.getElementById("prokerPopayV4").value = $(this).attr('proker');
            document.getElementById("prioritasPopayV4").value = $(this).attr('prioritas');
            document.getElementById("pilarPopayV4").value = $(this).attr('pilar');
            document.getElementById("golsPopayV4").value = $(this).attr('gols');
            $('.modal-prokerPopayV4').modal('hide');
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#provinsi').change(function () {
                var provinsi_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupaten/" + provinsi_id + "",
                    success: function (response) {
                        $('#kabupaten').html(response);
                    }
                });
            })
        })

        $(document).ready(function () {
            $('#provinsiPopayV4').change(function () {
                var provinsi_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupaten/" + provinsi_id + "",
                    success: function (response) {
                        $('#kabupatenPopayV4').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        function bukaWilayah() {
            var x = document.getElementById("kategori").value;
            if (x == "Proposal") {
                $(".wilayah").show();
                $(".prioritas").show();
            }

            if (x == "Operasional") {
                $(".wilayah").hide();
                $(".prioritas").hide();
            }
        }
    </script>

    <script>
        function bukaWilayahPopayV4() {
            var x = document.getElementById("kategoriPopayV4").value;
            if (x == "Proposal") {
                $(".wilayahPopayV4").show();
                $(".prioritasPopayV4").show();
            }

            if (x == "Operasional") {
                $(".wilayahPopayV4").hide();
                $(".prioritasPopayV4").hide();
            }
        }
    </script>

    <script>
        $('.delete').click(function () {
            var id = $(this).attr('id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus Payment Request ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function () {
                    submitDelete("/exportPopay/deletePaymentRequest/" + id + "");
                });
        });
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.error('Parameter yang anda isi belum lengkap', 'Failed', {closeButton: true});
        @endif
    </script>
@stop