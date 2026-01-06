@extends('layout.master_subsidiary')
@section('title', 'PGN SHARE | Realisasi Non Proposal')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">REALISASI ANGGARAN CSR
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Realisasi</li>
                        <li class="breadcrumb-item active">Non Proposal</li>
                    </ol>
                </div>
            </div>
        </div>

        <form method="post" action="{{ action('RealisasiSubsidiaryController@storeNonProposal') }}"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white model-huruf-family">Realisasi Anggaran</h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" class="form-control" name="jenis" value="Non Proposal">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Tanggal Realisasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control max-date" name="tglRealisasi"
                                            value="{{ old('tglRealisasi') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('tglRealisasi'))
                                        <small class="text-danger">Tanggal realisasi harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Dokumentasi Kegiatan <span class="text-danger">*</span></label>
                                    <br>
                                    <input type="file" name="lampiran" accept="image/*">
                                    @if ($errors->has('lampiran'))
                                        <br>
                                        <small class="text-danger">Dokumentasi kegiatan harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Program Kerja <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-white text-dark" name="proker"
                                        id="proker" readonly value="{{ old('proker') }}">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" data-target=".modal-proker"
                                            data-toggle="modal"><i class="fa fa-search mr-2"></i>Search
                                        </button>
                                    </div>
                                    <input type="hidden" class="form-control" name="prokerID" id="prokerID"
                                        value="{{ old('prokerID') }}">
                                </div>
                                @if ($errors->has('proker'))
                                    <small class="text-danger">Program kerja harus diisi</small>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Pilar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control bg-white text-dark" name="pilar"
                                        id="pilar" readonly value="{{ old('pilar') }}">
                                    @if ($errors->has('pilar'))
                                        <small class="text-danger">Pilar harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Goals <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control bg-white text-dark" name="gols"
                                        id="gols" readonly value="{{ old('gols') }}">
                                    @if ($errors->has('gols'))
                                        <small class="text-danger">Goals harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Prioritas</label>
                                    <input type="text" class="form-control bg-white text-dark" name="prioritas"
                                        id="prioritas" readonly value="{{ old('prioritas') }}">
                                </div>
                                <div class="form-group col-md-6">

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Bantuan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-capitalize" name="deskripsi"
                                    value="{{ old('deskripsi') }}">
                                @if ($errors->has('deskripsi'))
                                    <small class="text-danger">Deskripsi bantuan harus diisi</small>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Anggaran Tersedia <span class="text-danger">*(Automatic by system)</span></label>
                                    <select class="form-control bg-white text-dark custom-select" name="anggaranTersedia"
                                        id="anggaranTersedia" readonly>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Nominal Bantuan <span class="text-danger">*</span></label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                        name="nilaiBantuan" id="nilaiBantuan" value="{{ old('nilaiBantuan') }}">
                                    @if ($errors->has('nilaiBantuan'))
                                        <small class="text-danger">Nominal bantuan harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Provinsi <small class="text-muted">(Lokasi Program Bantuan)</small> <span
                                            class="text-danger">*</span></label>
                                    <select class="pilihProvinsi form-control" name="provinsi" id="provinsi">
                                        <option value="" disabled {{ old('provinsi') ? '' : 'selected' }}>-- Pilih
                                            Provinsi --</option>
                                        @foreach ($dataProvinsi as $provinsi)
                                            <option value="{{ ucwords($provinsi->provinsi) }}"
                                                {{ old('provinsi') == ucwords($provinsi->provinsi) ? 'selected' : '' }}>
                                                {{ ucwords($provinsi->provinsi) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('provinsi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kabupaten/Kota <span class="text-danger">*</span></label>
                                    <select id="kabupaten" name="kabupaten" class="form-control pilihKabupaten">
                                        <option disabled selected>-- Pilih Kabupaten --</option>
                                    </select>
                                    @error('kabupaten')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Kecamatan <span class="text-danger">*</span></label>
                                    <select id="kecamatan" name="kecamatan" class="form-control pilihKecamatan">
                                        <option disabled selected>-- Pilih Kecamatan --</option>
                                    </select>
                                    @error('kecamatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kelurahan <span class="text-danger">*</span></label>
                                    <select id="kelurahan" name="kelurahan" class="form-control pilihKelurahan">
                                        <option disabled selected>-- Pilih Kelurahan --</option>
                                    </select>
                                    @error('kelurahan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('indexRealisasiSubsidiary') }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        Cancel
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check-circle mr-2"></i>Submit Realisasi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white model-huruf-family">Penerima Bantuan</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Lembaga/Yayasan <span class="text-danger">*</span></label>
                                <select class="select2 form-control" name="namaYayasan" id="dari"
                                    style="width: 100%">
                                    <option>{{ old('namaYayasan') }}</option>
                                    @foreach ($dataLembaga as $lembaga)
                                        <option alamat="{{ $lembaga->alamat }}" pic="{{ $lembaga->nama_pic }}"
                                            noTelp="{{ $lembaga->no_telp }}" jabatan="{{ $lembaga->jabatan }}">
                                            {{ $lembaga->nama_lembaga }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('namaYayasan'))
                                    <small class="text-danger">Nama lembaga/yayasan dari harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Alamat<span class="text-danger">*</span></label>
                                <textarea rows="3" maxlength="200" class="form-control bg-white" placeholder="" name="alamat"
                                    id="alamat" readonly>{{ old('alamat') }}</textarea>
                                @if ($errors->has('alamat'))
                                    <small class="text-danger">Alamat pengaju proposal harus
                                        diisi</small>
                                    <br>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Nama Penanggung Jawab <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" name="pic" id="pengajuProposal"
                                    readonly value="{{ old('pic') }}" placeholder="">
                                @if ($errors->has('pic'))
                                    <small class="text-danger">Nama penanggung jawab harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Bertindak Sebagai <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" name="jabatan" id="bertindakSebagai"
                                    readonly value="{{ old('jabatan') }}" placeholder="">
                                @if ($errors->has('jabatan'))
                                    <small class="text-danger">Bertindak sebagai harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>No Telepon <span class="text-danger">*</span></label>
                                <input type="text" onkeypress="return hanyaAngka(event)" class="form-control bg-white"
                                    readonly id="noTelp" value="{{ old('noTelp') }}" placeholder="" name="noTelp">
                                @if ($errors->has('noTelp'))
                                    <small class="text-danger">No telepon harus diisi</small>
                                @endif
                            </div>
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
                    <h4 class="modal-title font-weight-bold model-huruf-family">DAFTAR PROGRAM KERJA</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="example5 table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="10px" style="text-align:center;" nowrap>Proker ID</th>
                                    <th class="text-center" width="400px">Program Kerja</th>
                                    <th class="text-center" width="100px">Tahun</th>
                                    <th class="text-center" width="300px">SDGs</th>
                                    <th class="text-center" width="50px">Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataProker as $proker)
                                    <tr>
                                        <td style="text-align:center;">{{ '#' . $proker->id_proker }}</td>
                                        <td>
                                            <span class="font-weight-bold">{{ $proker->proker }}</span>
                                            @if ($proker->prioritas != '')
                                                <br>
                                                <span class="text-muted">{{ $proker->prioritas }}</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center;">{{ $proker->tahun }}</td>
                                        <td>
                                            <span class="font-weight-bold">{{ $proker->pilar }}</span>
                                            <br>
                                            <span class="text-muted">{{ $proker->gols }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="pilih btn btn-sm btn-success"
                                                data-id="{{ $proker->id_proker }}" data-proker="{{ $proker->proker }}"
                                                data-pilar="{{ $proker->pilar }}" data-gols="{{ $proker->gols }}"
                                                data-prioritas="{{ $proker->prioritas }}"><i
                                                    class="fa fa-check font-14"></i>
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
        $(document).ready(function() {
            $(".pilihProvinsi").select2({
                width: '100%',
                // placeholder: "-- Pilih Provinsi --",
                allowClear: true
            });

            $(".pilihKabupaten").select2({
                width: '100%',
                // placeholder: "-- Pilih Kabupaten/Kota --",
                allowClear: true
            });

            $(".pilihKecamatan").select2({
                width: '100%',
                // placeholder: "-- Pilih Kecamatan --",
                allowClear: true
            });

            $(".pilihKelurahan").select2({
                width: '100%',
                // placeholder: "-- Pilih Kelurahan --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('#dari').on('change', function() {
            var alamat = $('#dari option:selected').attr('alamat');
            var pic = $('#dari option:selected').attr('pic');
            var jabatan = $('#dari option:selected').attr('jabatan');
            var noTelp = $('#dari option:selected').attr('noTelp');
            $('#alamat').val(alamat);
            $('#pengajuProposal').val(pic);
            $('#bertindakSebagai').val(jabatan);
            $('#noTelp').val(noTelp);
        });
    </script>

    <script>
        $(document).on('click', '.pilih', function(e) {
            var proker_id = $(this).attr('data-id');

            $.ajax({
                type: 'GET',
                url: "sisaAnggaran/" + proker_id + "",
                success: function(response) {
                    $('#anggaranTersedia').html(response);
                }
            });

            document.getElementById("prokerID").value = $(this).attr('data-id');
            document.getElementById("proker").value = $(this).attr('data-proker');
            document.getElementById("pilar").value = $(this).attr('data-pilar');
            document.getElementById("gols").value = $(this).attr('data-gols');
            document.getElementById("prioritas").value = $(this).attr('data-prioritas');
            $('.modal-proker').modal('hide');
        });
    </script>

    <script>
        $(document).ready(function() {
            const provOld = "{{ old('provinsi', $data->provinsi ?? '') }}";
            const kabOld = "{{ old('kabupaten', $data->kabupaten ?? '') }}";
            const kecOld = "{{ old('kecamatan', $data->kecamatan ?? '') }}";
            const kelOld = "{{ old('kelurahan', $data->kelurahan ?? '') }}";

            // Provinsi -> Kabupaten
            $('#provinsi').change(function() {
                const provinsi = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: `/proposal/data-kabupaten/${encodeURIComponent(provinsi)}`,
                    success: function(response) {
                        $('#kabupaten').empty().append(
                            '<option disabled selected>-- Pilih Kabupaten --</option>');
                        $('#kecamatan').empty().append(
                            '<option disabled selected>-- Pilih Kecamatan --</option>');
                        $('#kelurahan').empty().append(
                            '<option disabled selected>-- Pilih Kelurahan --</option>');

                        $.each(response, function(i, kab) {
                            const selected = kab.value === kabOld ? 'selected' : '';
                            $('#kabupaten').append(
                                `<option value="${kab.value}" ${selected}>${kab.label}</option>`
                            );
                        });

                        $('#kabupaten').prop('disabled', false);

                        if (kabOld) {
                            $('#kabupaten').val(kabOld).trigger('change');
                        }
                    },
                    error: function() {
                        toastr.error("Gagal memuat kabupaten", "Failed", {
                            closeButton: true
                        });
                    }
                });
            });

            // Kabupaten -> Kecamatan
            $('#kabupaten').change(function() {
                const provinsi = $('#provinsi').val();
                const kabupaten = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: `/proposal/data-kecamatan/${provinsi}/${kabupaten}`,
                    success: function(response) {
                        $('#kecamatan').empty().append(
                            '<option disabled selected>-- Pilih Kecamatan --</option>');
                        $('#kelurahan').empty().append(
                            '<option disabled selected>-- Pilih Kelurahan --</option>');

                        $.each(response, function(i, kec) {
                            const selected = kec.value === kecOld ? 'selected' : '';
                            $('#kecamatan').append(
                                `<option value="${kec.value}" ${selected}>${kec.label}</option>`
                            );
                        });

                        $('#kecamatan').prop('disabled', false);

                        if (kecOld) {
                            $('#kecamatan').val(kecOld).trigger('change');
                        }
                    },
                    error: function() {
                        toastr.error("Gagal memuat kecamatan", "Failed", {
                            closeButton: true
                        });
                    }
                });
            });

            // Kecamatan -> Kelurahan
            $('#kecamatan').change(function() {
                const provinsi = $('#provinsi').val();
                const kabupaten = $('#kabupaten').val();
                const kecamatan = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: `/proposal/data-kelurahan/${provinsi}/${kabupaten}/${kecamatan}`,
                    success: function(response) {
                        $('#kelurahan').empty().append(
                            '<option disabled selected>-- Pilih Kelurahan --</option>');

                        $.each(response, function(i, kel) {
                            const selected = kel.value === kelOld ? 'selected' : '';
                            $('#kelurahan').append(
                                `<option value="${kel.value}" ${selected}>${kel.label}</option>`
                            );
                        });

                        $('#kelurahan').prop('disabled', false);
                    },
                    error: function() {
                        toastr.error("Gagal memuat kelurahan", "Failed", {
                            closeButton: true
                        });
                    }
                });
            });

            // Auto-trigger on load if old value exists (Edit mode)
            if (provOld) {
                $('#provinsi').val(provOld).trigger('change');
            }
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

    <script>
        function ubahTanggal() {
            document.getElementById("date-end").value = '';
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
