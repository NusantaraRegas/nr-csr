@extends('layout.master_subsidiary')
@section('title', 'NR SHARE | Anggaran')
@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="model-huruf-family font-weight-bold">ANGGARAN
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Budget Control</li>
                        <li class="breadcrumb-item active">Anggaran</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                        class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle mr-2"></i>Create New
                    </button>
                    @if (session('user')->role != 'Subsidiary')
                        <button type="button" class="btn btn-secondary active ml-1 d-lg-block" data-toggle="collapse"
                            data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter"><i
                                class="fa fa-filter"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="collapse" id="collapseFilter">
            <div class="row">
                <div class="col-12">
                    <form method="post" action="{{ action('AnggaranController@cariPerusahaan') }}">
                        {{ csrf_field() }}
                        <div class="card">
                            <div class="card-body p-b-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-8">
                                                <select class="form-control" name="perusahaan" id="company"
                                                    style="width: 100%">
                                                    <option>{{ $comp }}</option>
                                                    @foreach ($dataPerusahaan as $perusahaan)
                                                        <option>{{ $perusahaan->nama_perusahaan }}</option>
                                                    @endforeach
                                                    <option>Semua Perusahaan</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <select class="form-control" name="tahun" id="year"
                                                    style="width: 100%">
                                                    <option>{{ $tahun }}</option>
                                                    <option>2018</option>
                                                    <option>2019</option>
                                                    <option>2020</option>
                                                    <option>2021</option>
                                                    <option>2022</option>
                                                    <option>2023</option>
                                                    <option>Semua Tahun</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <button class="btn btn-success"><i class="fa fa-search mr-2"></i>Search
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family mb-5">DAFTAR ANGGARAN</h4>
                        @if ($jumlahData > 0)
                            <div class="table-responsive">
                                <table class="example5 table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center font-weight-bold" width="10px">No</th>
                                            <th width="500px" class=" font-weight-bold">Perusahaan</th>
                                            <th class="text-center font-weight-bold" width="100px">Tahun</th>
                                            <th class="text-center font-weight-bold" width="200px">Nominal</th>
                                            <th class="text-center font-weight-bold" width="50px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataAnggaran as $data)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $data->perusahaan }}</td>
                                                <td class="text-center">{{ $data->tahun }}</td>
                                                <td class="text-right">{{ number_format($data->nominal, 0, ',', '.') }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"><i
                                                                class="fa fa-gear font-18 text-info"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            style="font-size: 13px">
                                                            <a class="dropdown-item" target="_blank"
                                                                href="{{ route('indexProkerPerusahaan', ['year' => $data->tahun, 'company' => encrypt($data->perusahaan)]) }}"><i
                                                                    class="fa fa-info-circle mr-2"></i>Detail Alokasi</a>
                                                            <a class="dropdown-item anggaran-edit"
                                                                data-id="{{ encrypt($data->id_anggaran) }}"
                                                                data-nominal="{{ number_format($data->nominal, 0, ',', '.') }}"
                                                                data-tahun="{{ $data->tahun }}"
                                                                data-perusahaan="{{ $data->perusahaan }}"
                                                                data-target=".modal-edit" data-toggle="modal"
                                                                href="#!"><i class="fa fa-pencil mr-2"></i>Edit</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item delete"
                                                                data-id="{{ encrypt($data->id_anggaran) }}"
                                                                href="javascript:void(0)"><i
                                                                    class="fa fa-trash mr-2"></i>Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                <h4 class="model-huruf-family"><i class="fa fa-warning"></i> Warning</h4> Belum ada anggaran
                                yang dibuat oleh {{ $comp }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <form method="post" action="{{ action('AnggaranController@insertAnggaran') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title model-huruf-family font-weight-bold"><b>CREATE ANGGARAN</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="perusahaan" value="{{ $comp }}"
                            readonly>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label>Nominal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nominal" name="nominal"
                                    value="{{ old('nominal') }}" />
                                @if ($errors->has('nominal'))
                                    <small class="text-danger">Nominal harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <select class="form-control" name="tahun">
                                    <option></option>
                                    <option>2022</option>
                                    <option>2023</option>
                                </select>
                                @if ($errors->has('tahun'))
                                    <small class="text-danger">Tahun anggaran harus diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check-circle mr-2"></i>Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('AnggaranController@editAnggaran') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title model-huruf-family font-weight-bold"><b>EDIT ANGGARAN</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idanggaran" id="idanggaran">
                        <input type="hidden" class="form-control" name="perusahaan" id="perusahaan" readonly>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label>Nominal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nominal2" name="nominal"
                                    value="{{ old('nominalRupiah') }}" />
                                @if ($errors->has('nominal'))
                                    <small class="text-danger">Nominal harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <select class="form-control" name="tahun" id="tahun">
                                    <option></option>
                                    <option>2022</option>
                                    <option>2023</option>
                                    <option>2024</option>
                                </select>
                                @if ($errors->has('tahun'))
                                    <small class="text-danger">Tahun anggaran harus diisi</small>
                                @endif
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
@endsection

@section('footer')
    <script>
        $(document).on('click', '.anggaran-edit', function(e) {
            document.getElementById("idanggaran").value = $(this).attr('data-id');
            document.getElementById("nominal2").value = $(this).attr('data-nominal');
            document.getElementById("tahun").value = $(this).attr('data-tahun');
            document.getElementById("perusahaan").value = $(this).attr('data-perusahaan');
        });
    </script>

    <script>
        $('.delete').click(function() {
            var anggaran_id = $(this).attr('data-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus anggaran ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "/anggaran/delete/" + anggaran_id + "";
                });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#company").select2({
                placeholder: "Pilih Perusahaan"
            });

            $("#year").select2({
                placeholder: "Pilih Tahun"
            });
        });
    </script>

    <script>
        var nominal = document.getElementById('nominal');
        nominal.addEventListener('keyup', function(e) {
            nominal.value = formatRupiah(this.value);
        });

        var nominal2 = document.getElementById('nominal2');
        nominal2.addEventListener('keyup', function(e) {
            nominal2.value = formatRupiah(this.value);
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
