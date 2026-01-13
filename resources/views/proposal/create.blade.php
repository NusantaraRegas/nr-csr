@extends('layout.master')
@section('title', 'PGN SHARE | Kelayakan Proposal')

@section('content')
    <link href="{{ asset('template/assets/node_modules/wizard/steps.css') }}" rel="stylesheet">

    <style>
        label.text-danger {
            font-size: 0.9rem;
        }

        .is-invalid {
            border-color: initial !important;
            box-shadow: none !important;
        }

        input.is-invalid,
        select.is-invalid,
        textarea.is-invalid {
            border-color: #ced4da !important;
            /* warna default Bootstrap */
            box-shadow: none !important;
        }

        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            /* agar setara input */
        }
    </style>

    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold">KELAYAKAN PROPOSAL</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Kelayakan Proposal</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white">Form Kelayakan Proposal</h4>
                    </div>
                    <div class="card-body wizard-content">
                        <form id="formKelayakan" method="POST" action="{{ route('storeProposal') }}"
                            enctype="multipart/form-data" class="wizard-circle">
                            @csrf

                            <!-- Step 1 -->
                            <h6>Surat/Proposal</h6>
                            <section>
                                @include('proposal.step.surat_proposal')
                            </section>

                            <!-- Step 2 -->
                            <h6>Penerima Manfaat</h6>
                            <section>
                                @include('proposal.step.penerima_bantuan')
                            </section>

                            <!-- Step 3 -->
                            <h6>Lampiran Pendukung</h6>
                            <section>
                                @include('proposal.step.lampiran_submit')
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('template/assets/node_modules/wizard/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/wizard/jquery.validate.min.js') }}"></script>

    <script>
        function initDatepicker() {
            setTimeout(() => {
                const $tglSurat = $('.tgl-surat');
                const $tglTerima = $('.tgl-terima');

                // Use bootstrap-datepicker instead of bootstrap-material-datetimepicker
                $tglSurat.datepicker({
                    format: 'dd-M-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    endDate: new Date(),
                    orientation: 'bottom auto'
                });

                $tglTerima.datepicker({
                    format: 'dd-M-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    endDate: new Date(),
                    orientation: 'bottom auto'
                }).on('changeDate', function(e) {
                    if (e.date) {
                        $tglSurat.datepicker('setEndDate', e.date);
                    }
                });
            }, 200);
        }
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
        $(document).ready(function() {
            const form = $("#formKelayakan");

            // Init jQuery Validate
            form.validate({
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2')); // untuk select2
                    } else if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent()); // untuk input dengan icon kalender
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                errorClass: 'text-danger mt-1',

                // ✅ Custom error messages
                messages: {
                    noAgenda: {
                        required: "No Agenda harus diisi"
                    },
                    tglPenerimaan: {
                        required: "Tanggal penerimaan harus diisi"
                    },
                    pengirim: {
                        required: "Pengirim harus dipilih"
                    },
                    noSurat: {
                        required: "Nomor surat harus diisi"
                    },
                    tglSurat: {
                        required: "Tanggal surat harus diisi"
                    },
                    sifat: {
                        required: "Sifat surat harus dipilih"
                    },
                    jenis: {
                        required: "Jenis proposal harus dipilih"
                    },
                    digunakanUntuk: {
                        required: "Perihal harus diisi"
                    },
                    dari: {
                        required: "Yayasan/Lembaga harus dipilih"
                    },
                    alamat: {
                        required: "Alamat harus diisi"
                    },
                    besarPermohonanAsli: {
                        required: "Nominal permohonan harus diisi"
                    },
                    perihal: {
                        required: "Kategori bantuan harus dipilih"
                    },
                    provinsi: {
                        required: "Provinsi harus dipilih"
                    },
                    kabupaten: {
                        required: "Kabupaten/Kota harus dipilih"
                    },
                    kecamatan: {
                        required: "Kecamatan harus dipilih"
                    },
                    kelurahan: {
                        required: "Kelurahan harus dipilih"
                    },
                    deskripsiBantuan: {
                        required: "Deskripsi bantuan harus diisi"
                    },
                    disposisi: {
                        required: "Disposisi wajib diunggah"
                    },
                    lampiran: {
                        required: "Proposal/Surat wajib diunggah"
                    }
                }
            });

            // Wizard init + validation + datepicker
            form.steps({
                headerTag: 'h6',
                bodyTag: 'section',
                transitionEffect: 'fade',
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    finish: "Simpan",
                    next: "Lanjut",
                    previous: "Sebelumnya"
                },
                onInit: function() {
                    initDatepicker();
                    initRupiahFormatter();
                },
                onStepChanged: function(event, currentIndex, priorIndex) {
                    if (currentIndex === 0) {
                        initDatepicker();
                        initRupiahFormatter();
                    }
                },
                onStepChanging: function(event, currentIndex, newIndex) {
                    if (currentIndex > newIndex) return true;
                    form.validate().settings.ignore = ":disabled,:hidden";
                    return form.valid();
                },
                onFinishing: function(event, currentIndex) {
                    form.validate().settings.ignore = ":disabled,:hidden";
                    return form.valid();
                },
                onFinished: function(event, currentIndex) {
                    form.submit();
                }
            });
        });
    </script>

    <script>
        function terms_changed(checkbox) {
            document.getElementById("submit_button").disabled = !checkbox.checked;
        }
    </script>

    <script>
        $(document).ready(function() {
            $(".pilihPengirim").select2({
                width: '100%',
                placeholder: "-- Pilih Pengirim --",
                allowClear: true
            });

            $(".pilihLembaga").select2({
                width: '100%',
                placeholder: "-- Pilih Lembaga --",
                allowClear: true
            });

            $(".pilihProvinsi").select2({
                width: '100%',
                placeholder: "-- Pilih Provinsi --",
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
        $(document).ready(function() {
            $('#dari').on('change', function() {
                const selected = $(this).find(':selected');
                $('#alamat').val(selected.attr('alamat') || '');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            const pilarOld = "{{ old('pilar') }}";
            const tpbOld = "{{ old('tpb') }}";

            $('#pilar').change(function() {
                const pilar_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/dataTPB/" + pilar_id,
                    success: function(response) {
                        $('#tpb').empty().append(
                            '<option disabled selected>-- Pilih TPB --</option>'
                        );

                        $.each(response, function(i, tp) {
                            const selected = tp.value === tpbOld ? 'selected' : '';
                            $('#tpb').append('<option value="' + tp.value +
                                '" ' + selected + '>' + tp.label + '</option>');
                        });

                        $('#tpb').prop('disabled', false);
                    },
                    error: function() {
                        toastr.error("Gagal memuat TPB", "Failed", {
                            closeButton: true
                        });
                    }
                });
            });

            // Trigger saat halaman pertama kali dibuka jika ada nilai lama
            if (pilarOld) {
                $('#pilar').val(pilarOld).trigger('change');
            }
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
        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
