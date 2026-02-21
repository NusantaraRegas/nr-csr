@extends('layout.master_subsidiary')
@section('title', 'NR SHARE | Anggaran')
@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold">ANGGARAN
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
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family mb-5">DAFTAR ANGGARAN</h4>
                        @if ($dataAnggaran->count() > 0)
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
                                                <td>{{ $data->nama_perusahaan }}</td>
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
                                                                data-nominal="{{ 'Rp. ' . number_format($data->nominal, 0, ',', '.') }}"
                                                                data-nominalAsli="{{ $data->nominal }}"
                                                                data-tahun="{{ $data->tahun }}"
                                                                data-perusahaan="{{ $data->perusahaan }}"
                                                                data-target=".modal-edit" data-toggle="modal"
                                                                href="#!"><i class="fa fa-pencil mr-2"></i>Edit</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item delete"
                                                                data-id="{{ encrypt($data->id_anggaran) }}"
                                                                data-tahun="{{ $data->tahun }}"
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

    <form method="post" action="{{ route('storeAnggaran') }}">
        @csrf
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title model-huruf-family font-weight-bold"><b>CREATE ANGGARAN</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="perusahaan" value="{{ $comp }}" readonly>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label>Nominal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" name="nominal" id="nominal"
                                    value="{{ old('nominal') }}" required>
                                <input type="hidden" name="nominalAsli" id="nominalAsli"
                                    value="{{ old('nominalAsli') }}">
                                @error('nominalAsli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <select class="form-control" name="tahun" autocomplete="off">
                                    <option value="">-- Pilih
                                        Tahun --</option>
                                    @for ($thn = 2022; $thn <= date('Y') + 1; $thn++)
                                        <option value="{{ $thn }}">
                                            {{ $thn }}
                                        </option>
                                    @endfor
                                </select>
                                @error('tahun')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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

    <form method="post" action="{{ route('updateAnggaran') }}">
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
                                <input type="text" class="form-control" autocomplete="off" name="nominal"
                                    id="nominal_edit" value="{{ old('nominal') }}" required>
                                <input type="hidden" name="nominalAsli" id="nominalAsli_edit"
                                    value="{{ old('nominalAsli') }}">
                                @error('nominalAsli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <select class="form-control" name="tahun" id="tahun" autocomplete="off">
                                    <option value="">-- Pilih
                                        Tahun --</option>
                                    @for ($thn = 2022; $thn <= date('Y') + 1; $thn++)
                                        <option value="{{ $thn }}">
                                            {{ $thn }}
                                        </option>
                                    @endfor
                                </select>
                                @error('tahun')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
            document.getElementById("nominal_edit").value = $(this).attr('data-nominal');
            document.getElementById("nominalAsli_edit").value = $(this).attr('data-nominalAsli');
            document.getElementById("tahun").value = $(this).attr('data-tahun');
        });
    </script>

    <script>
        $('.delete').click(function() {
            var data_id = $(this).data('id');
            var data_tahun = $(this).data('tahun');

            if (!data_id) return;

            swal({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin ingin menghapus anggaran " + data_tahun +
                    "? Tindakan ini tidak bisa dibatalkan.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-secondary",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                setTimeout(() => {
                    submitDelete("/anggaran/deleteAnggaran/" + data_id);
                }, 1000);
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
        var inputRupiah = document.getElementById('nominal');
        var inputHidden = document.getElementById('nominalAsli');

        inputRupiah.addEventListener('input', function() {
            // Simpan posisi kursor
            var cursorPos = this.selectionStart;
            var originalLength = this.value.length;

            // Format tampilan input
            this.value = formatRupiah(this.value, 'Rp. ');

            // Kembalikan posisi kursor
            var updatedLength = this.value.length;
            this.setSelectionRange(cursorPos + (updatedLength - originalLength), cursorPos + (updatedLength -
                originalLength));

            // Set nilai ke hidden input dalam bentuk angka (tanpa Rp dan titik)
            inputHidden.value = convertToAngka(this.value);
        });

        var inputRupiah2 = document.getElementById('nominal_edit');
        var inputHidden2 = document.getElementById('nominalAsli_edit');

        inputRupiah2.addEventListener('input', function() {
            // Simpan posisi kursor
            var cursorPos = this.selectionStart;
            var originalLength = this.value.length;

            // Format tampilan input
            this.value = formatRupiah(this.value, 'Rp. ');

            // Kembalikan posisi kursor
            var updatedLength = this.value.length;
            this.setSelectionRange(cursorPos + (updatedLength - originalLength), cursorPos + (updatedLength -
                originalLength));

            // Set nilai ke hidden input dalam bentuk angka (tanpa Rp dan titik)
            inputHidden2.value = convertToAngka(this.value);
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString();
            var split = number_string.split(',');
            var sisa = split[0].length % 3;
            var rupiah = split[0].substr(0, sisa);
            var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix ? prefix + rupiah : rupiah;
        }

        function convertToAngka(rupiah) {
            return rupiah.replace(/[^0-9]/g, '');
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
