@extends('layout.master')
@section('title', 'PGN SHARE | Relokasi Anggaran')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="model-huruf-family font-weight-bold">RELOKASI ANGGARAN TAHUN {{ $tahun }}
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Budget Control</li>
                        <li class="breadcrumb-item active">Relokasi Anggaran</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white model-huruf-family">Form Relokasi Anggaran</h4>
                    </div>
                    <form method="post" action="{{ action('RelokasiController@store') }}">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-body">
                                <div class="form-group">
                                    <label>Sumber Anggaran <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white text-dark" name="prokerAsal"
                                            id="prokerAsal" readonly>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-secondary" data-target=".modal-prokerAsal"
                                                data-toggle="modal"><i class="fa fa-search"></i></button>
                                        </div>
                                        <input type="hidden" class="form-control" name="prokerIDAsal" id="prokerIDAsal">
                                        @if ($errors->has('prokerAsal'))
                                            <small class="text-danger">Program kerja asal harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="font-16">Anggaran Tersedia <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-lg bg-white text-dark custom-select"
                                            name="nominalAsal" id="nominalAsal" readonly>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="font-16">Jumlah Relokasi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" name="nominalRelokasi"
                                            id="nominalRelokasi">
                                        @if ($errors->has('nominalRelokasi'))
                                            <small class="text-danger">Jumlah relokasi harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tujuan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white text-dark" name="prokerTujuan"
                                            id="prokerTujuan" readonly>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-secondary"
                                                data-target=".modal-prokerTujuan" data-toggle="modal"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                        <select style="display: none" class="form-control bg-white text-dark custom-select"
                                            name="nominalTujuan" id="nominalTujuan" readonly>
                                            <option></option>
                                        </select>
                                        <input type="hidden" class="form-control" name="prokerIDTujuan"
                                            id="prokerIDTujuan">
                                        @if ($errors->has('prokerTujuan'))
                                            <small class="text-danger">Program kerja tujuan harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('indexRelokasi') }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        Cancel
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check-circle mr-2"></i>Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-prokerAsal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
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
                                    <th width="10px" style="text-align:center;">ID</th>
                                    <th class="text-center" width="400px">Program Kerja</th>
                                    <th class="text-center" width="300px">SDGs</th>
                                    <th class="text-center" width="50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataProker as $proker)
                                    <tr>
                                        <td style="text-align:center;">{{ $proker->id_proker }}</td>
                                        <td>
                                            <span class="font-weight-bold">{{ $proker->proker }}</span>
                                            @if ($proker->prioritas != '')
                                                <br>
                                                <span class="text-muted">{{ $proker->prioritas }}</span>
                                            @else
                                                <br>
                                                <span class="text-muted">Sosial & Ekonomi</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="font-weight-bold">{{ $proker->pilar }}</span>
                                            <br>
                                            <span class="text-muted">{{ $proker->gols }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#!" class="pilihAsal btn btn-sm btn-success"
                                                prokerID="{{ $proker->id_proker }}" proker="{{ $proker->proker }}"
                                                prioritas="{{ $proker->prioritas }}">Pilih
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

    <div class="modal fade modal-prokerTujuan" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
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
                                    <th width="10px" style="text-align:center;">ID</th>
                                    <th class="text-center" width="400px">Program Kerja</th>
                                    <th class="text-center" width="300px">SDGs</th>
                                    <th class="text-center" width="50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataProker as $proker)
                                    <tr>
                                        <td style="text-align:center;">{{ $proker->id_proker }}</td>
                                        <td>
                                            <span class="font-weight-bold">{{ $proker->proker }}</span>
                                            @if ($proker->prioritas != '')
                                                <br>
                                                <span class="text-muted">{{ $proker->prioritas }}</span>
                                            @else
                                                <br>
                                                <span class="text-muted">Sosial & Ekonomi</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="font-weight-bold">{{ $proker->pilar }}</span>
                                            <br>
                                            <span class="text-muted">{{ $proker->gols }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#!" class="pilihTujuan btn btn-sm btn-success"
                                                prokerID="{{ $proker->id_proker }}" proker="{{ $proker->proker }}"
                                                prioritas="{{ $proker->prioritas }}">Pilih
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
@endsection

@section('footer')
    <script>
        $(document).on('click', '.pilihAsal', function(e) {
            var proker_id = $(this).attr('prokerID');

            $.ajax({
                type: 'GET',
                url: "sisaAnggaran/" + proker_id + "",
                success: function(response) {
                    $('#nominalAsal').html(response);
                }
            });

            document.getElementById("prokerIDAsal").value = $(this).attr('prokerID');
            document.getElementById("prokerAsal").value = $(this).attr('proker');
            $('.modal-prokerAsal').modal('hide');
        });
    </script>

    <script>
        $(document).on('click', '.pilihTujuan', function(e) {
            var proker_id = $(this).attr('prokerID');

            $.ajax({
                type: 'GET',
                url: "sisaAnggaran/" + proker_id + "",
                success: function(response) {
                    $('#nominalTujuan').html(response);
                }
            });

            document.getElementById("prokerIDTujuan").value = $(this).attr('prokerID');
            document.getElementById("prokerTujuan").value = $(this).attr('proker');
            $('.modal-prokerTujuan').modal('hide');
        });
    </script>


    <script>
        var nominal = document.getElementById('nominalRelokasi');
        nominal.addEventListener('keyup', function(e) {
            nominal.value = formatRupiah(this.value);
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
        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
