@extends('layout.master')
@section('title', 'PGN SHARE | Operasional')

@section('content')
    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">INPUT OPERASIONAL</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Operasional</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('storeOperasional') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Nomor Surat <span class="text-danger">*</span></label>
                                    <input type="text" name="noSurat" class="form-control" value="{{ old('noSurat') }}"
                                        required>
                                    @error('noSurat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Tanggal Surat <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="tglSurat" class="form-control tgl-surat"
                                            value="{{ old('tglSurat') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-calendar text-info"></i></span>
                                        </div>
                                    </div>
                                    @error('tglSurat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Sifat <span class="text-danger">*</span></label>
                                    <select name="sifat" class="form-control" required>
                                        <option value="" disabled selected>-- Sifat Surat --</option>
                                        <option value="Biasa" {{ old('sifat') == 'Biasa' ? 'selected' : '' }}>Biasa
                                        </option>
                                        <option value="Segera" {{ old('sifat') == 'Segera' ? 'selected' : '' }}>Segera
                                        </option>
                                        <option value="Amat Segera" {{ old('sifat') == 'Amat Segera' ? 'selected' : '' }}>
                                            Amat Segera</option>
                                    </select>
                                    @error('sifat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Yayasan/Lembaga <span class="text-danger">*</span></label>
                                <select class="pilihLembaga form-control" name="dari" id="dari" required>
                                    <option value="" disabled selected>-- Pilih Lembaga --</option>
                                    @foreach ($dataLembaga as $lembaga)
                                        <option value="{{ $lembaga->id_lembaga }}" alamat="{{ $lembaga->alamat }}">
                                            {{ $lembaga->nama_lembaga }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dari')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" id="alamat" class="form-control bg-white" rows="3" readonly required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Jumlah Pembayaran <span class="text-danger">*</span></label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                        autocomplete="off" name="besarPermohonan" id="besarPermohonan"
                                        placeholder="Contoh: Rp. 1.000.000" value="{{ old('besarPermohonan') }}">
                                    <input type="hidden" name="besarPermohonanAsli" id="besarPermohonanAsli">
                                    @error('besarPermohonanAsli')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Provinsi <small class="text-muted">(Lokasi Program Bantuan)</small> <span
                                            class="text-danger">*</span></label>
                                    <select class="pilihProvinsi form-control" name="provinsi" id="provinsi" required>
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
                                    <select id="kabupaten" name="kabupaten" class="form-control pilihKabupaten" required>
                                        <option disabled selected>-- Pilih Kabupaten/Kota --</option>
                                    </select>
                                    @error('kabupaten')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Kecamatan <span class="text-danger">*</span></label>
                                    <select id="kecamatan" name="kecamatan" class="form-control pilihKecamatan" required>
                                        <option disabled selected>-- Pilih Kecamatan --</option>
                                    </select>
                                    @error('kecamatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kelurahan <span class="text-danger">*</span></label>
                                    <select id="kelurahan" name="kelurahan" class="form-control pilihKelurahan" required>
                                        <option disabled selected>-- Pilih Kelurahan --</option>
                                    </select>
                                    @error('kelurahan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi <span class="text-danger">*</span></label>
                                <textarea rows="3" class="form-control js-maxlength" maxlength="500"
                                    placeholder="Deskripsi maksimal 500 karakter" name="deskripsiBantuan">{{ old('deskripsiBantuan') }}</textarea>
                                @error('deskripsi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Simpan</a>
                            <button type="submit" class="btn btn-info">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script
        src="{{ asset('template/assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
    </script>

    <script src="{{ asset('template/assets/node_modules/bootstrap-maxlength/js/bootstrap-maxlength.min.js') }}"></script>

    <script>
        $('.js-maxlength').maxlength({
            alwaysShow: true, // selalu tampil
            separator: ' / ', // format "0 / 255"
            preText: '',
            postText: '',
            warningClass: 'badge badge-success',
            limitReachedClass: 'badge badge-danger',
            appendToParent: true, // ditempel ke parent (.form-group)
            placement: 'bottom' // lalu kita posisikan dengan CSS di atas
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".pilihLembaga").select2({
                width: '100%',
                placeholder: "-- Pilih Lembaga --",
                allowClear: true
            });

            $(".pilihProvinsi").select2({
                width: '100%',
                // placeholder: "-- Pilih Provinsi --",
                allowClear: true
            });

            $(".pilihKabupaten").select2({
                width: '100%',
                placeholder: "-- Pilih Kabupaten/Kota --",
                allowClear: true
            });

            $(".pilihKecamatan").select2({
                width: '100%',
                placeholder: "-- Pilih Kecamatan --",
                allowClear: true
            });

            $(".pilihKelurahan").select2({
                width: '100%',
                placeholder: "-- Pilih Kelurahan --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.tgl-surat').bootstrapMaterialDatePicker({
            weekStart: 0,
            maxDate: new Date(),
            format: 'DD-MMM-YYYY',
            time: false
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dari').on('change', function() {
                const selected = $(this).find(':selected');
                $('#alamat').val(selected.attr('alamat') || '');
            });
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
                            '<option disabled selected>-- Pilih Kabupaten/Kota --</option>');
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

        function initRupiahFormatter() {
            const inputRupiah = document.getElementById('besarPermohonan');
            const hiddenInput = document.getElementById('besarPermohonanAsli');
            if (!inputRupiah || !hiddenInput) return;

            inputRupiah.addEventListener('input', function() {
                // Format tampilan
                const cursorPos = this.selectionStart;
                const originalLength = this.value.length;

                this.value = formatRupiah(this.value, 'Rp. ');

                const updatedLength = this.value.length;
                this.setSelectionRange(
                    cursorPos + (updatedLength - originalLength),
                    cursorPos + (updatedLength - originalLength)
                );

                // Set nilai bersih ke input hidden
                const cleanValue = this.value.replace(/[^0-9]/g, '');
                hiddenInput.value = cleanValue;
            });
        }

        // Jalankan saat dokumen siap
        document.addEventListener('DOMContentLoaded', initRupiahFormatter);
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
