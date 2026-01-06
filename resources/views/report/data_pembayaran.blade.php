@extends('layout.master')
@section('title', 'PGN SHARE | Rekap Realisasi')
@section('content')
    <style>
        .empty-icon {
            font-size: 60px;
            color: #888;
            display: inline-block;
            /* Penting untuk animasi */
            animation: bounce 1.5s infinite alternate;
        }

        @keyframes bounce {
            from {
                transform: translateY(5px);
                opacity: 0.8;
            }

            to {
                transform: translateY(-5px);
                opacity: 1;
            }
        }
    </style>

    <style>
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            /* agar setara input */
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    REKAP REALISASI<br>
                    <small>Tahun {{ $tahun }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item">Realisasi Penyaluran TJSL</li>
                        <li class="breadcrumb-item active">Rekap Realisasi</li>
                    </ol>
                    <a href="{{ route('indexPembayaran') }}" class="btn btn-danger d-none d-lg-block m-l-15"><i
                            class="fas fa-refresh mr-2"></i>Reset
                    </a>
                    <button type="button" data-toggle="modal" data-target=".modal-filter"
                        class="btn btn-info d-none d-lg-block m-l-15"><i class="fas fa-filter mr-2"></i>Filter Data
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mb-2">
                                <h4 class="card-title font-weight-bold">Total Realisasi</h4>
                                <h4 class="card-subtitle font-weight-bold" style="color: red">
                                    {{ 'Rp' . number_format($totalRealisasi, 0, ',', '.') }}
                                </h4>
                            </div>
                            <div class="ml-auto">
                                <a href="{{ route('exportPembayaran', request()->query()) }}" class="font-bold text-muted">
                                    <img src="{{ asset('template/assets/images/icon/excel.png') }}" class="mr-1"
                                        width="18px" alt="icon-excel"> Export
                                    Excel
                                </a>
                            </div>
                        </div>
                        @if ($dataPembayaran->count() > 0)
                            <div class="table-responsive">
                                <table id="table_pembayaran" class="table table-striped">
                                    <thead class="thead-light font-bold">
                                        <tr>
                                            <th width="50px" class="text-center">No</th>
                                            <th width="400px">Detail Informasi</th>
                                            <th width="300px">Penerima Manfaat</th>
                                            <th width="200px">Wilayah</th>
                                            <th class="text-right" width="100px" nowrap>Jumlah (Rp)</th>
                                            <th class="text-right" width="100px" nowrap>Fee (Rp)</th>
                                            <th class="text-right" width="100px" nowrap>Subtotal (Rp)</th>
                                            <th width="100px">Status</th>
                                            @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                <th class="text-right" width="100px">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataPembayaran as $data)
                                            <tr>
                                                <td style="text-align:center;">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    <h6 class="mb-1 font-bold">
                                                        <a class="text-info"
                                                            href="{{ route('detailKelayakan', Crypt::encrypt($data->id_kelayakan)) }}">
                                                            {{ $data->no_agenda }}
                                                        </a>
                                                    </h6>
                                                    <p class="text-muted text-justify">
                                                        {{ $data->deskripsi_pembayaran }}
                                                    </p>
                                                    <h6 class="mb-1 font-bold">
                                                        {{ $data->pilar }}
                                                    </h6>
                                                    <p class="mb-0 text-muted">
                                                        {{ $data->kode_tpb . '. ' . $data->gols }}
                                                    </p>
                                                    <small>
                                                        📌 {{ $data->prioritas }}
                                                    </small>
                                                    @if ($data->metode == 'YKPP')
                                                        <br>
                                                        <small>
                                                            ⭐ YKPP
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <h6 class="mb-1 font-bold">{{ strtoupper($data->nama_lembaga) }}</h6>
                                                    <p class="mb-0 text-muted">{{ $data->deskripsi }}</p>
                                                </td>
                                                <td>
                                                    <h6 class="mb-1 font-bold">{{ $data->provinsi }}</h6>
                                                    <p class="mb-0 text-muted">{{ $data->kabupaten }}</p>
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($data->jumlah_pembayaran, 0, ',', '.') }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($data->fee, 0, ',', '.') }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($data->subtotal, 0, ',', '.') }}
                                                </td>
                                                <td nowrap>
                                                    @if ($data->status == 'Open')
                                                        <span class="badge badge-dark font-bold font-12">OPEN</span>
                                                    @elseif($data->status == 'Exported')
                                                        <span class="badge badge-success font-bold font-12">EXPORT
                                                            POPAY</span>
                                                        @if ($data->status == 'Exported')
                                                            <br>
                                                            <small>Popay ID: {{ $data->pr_id }}</small>
                                                        @endif
                                                    @endif
                                                </td>
                                                @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                    <td class="text-right" nowrap>
                                                        <ul class="list-inline mb-0">
                                                            <li class="list-inline-item">
                                                                <a href="#" class="editPembayaran"
                                                                    data-id="{{ Crypt::encrypt($data->id_pembayaran) }}"
                                                                    data-deskripsi="{{ $data->deskripsi_pembayaran }}"
                                                                    data-termin="{{ $data->termin }}"
                                                                    data-jumlah_rupiah="{{ 'Rp. ' . number_format($data->jumlah_pembayaran, 0, ',', '.') }}"
                                                                    data-jumlah="{{ $data->jumlah_pembayaran }}"
                                                                    data-fee_rupiah="{{ 'Rp. ' . number_format($data->fee, 0, ',', '.') }}"
                                                                    data-fee="{{ $data->fee }}" data-toggle="modal"
                                                                    data-target=".modal-pembayaranEdit"
                                                                    data-toggle="tooltip" title="Edit">
                                                                    <i class="far fa-edit text-info font-18"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#" class="delete" data-toggle="tooltip"
                                                                    title="Hapus"
                                                                    data-id="{{ encrypt($data->id_pembayaran) }}">
                                                                    <i class="far fa-trash-alt text-danger font-18"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-database-fill-slash empty-icon"></i>
                                <h5 class="mt-3">Data pembayaran tidak ditemukan</h5>
                                <p class="text-muted mb-0">Klik tombol "Filter Data" di kanan atas untuk
                                    mulai pencarian.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-filter" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="GET" action="{{ route('indexPembayaran') }}" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-bold" id="filterModalLabel">Filter Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Tahun Anggaran</label>
                                    <input type="number" name="tahun" class="form-control"
                                        value="{{ request('tahun', date('Y')) }}" min="2000" max="2100">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Semua Status --</option>
                                        @foreach (['Open', 'Exported'] as $status)
                                            <option value="{{ $status }}"
                                                {{ request('status') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jenis Proposal</label>
                                <select name="jenis" class="form-control">
                                    <option value="">-- Semua Jenis --</option>
                                    @foreach (['Bulanan', 'Santunan', 'Idul Adha', 'Natal', 'Aspirasi'] as $jenis)
                                        <option value="{{ $jenis }}"
                                            {{ request('jenis') == $jenis ? 'selected' : '' }}>
                                            {{ $jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Pilar</label>
                                <select name="pilar" id="pilar" class="form-control">
                                    <option value="">-- Semua Pilar --</option>
                                    @foreach ($dataPilar as $pilar)
                                        <option value="{{ $pilar->nama }}"
                                            {{ request('pilar') == $pilar->nama ? 'selected' : '' }}>
                                            {{ $pilar->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>TPB</label>
                                <select name="tpb" id="tpb" class="form-control">
                                    <option value="">-- Semua TPB --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Prioritas</label>
                                <select class="form-control" name="prioritas">
                                    <option value="">-- Semua Prioritas --</option>
                                    <option value="Pendidikan"
                                        {{ request('prioritas') == 'Pendidikan' ? 'selected' : '' }}>
                                        Pendidikan
                                    </option>
                                    <option value="Lingkungan"
                                        {{ request('prioritas') == 'Lingkungan' ? 'selected' : '' }}>
                                        Lingkungan
                                    </option>
                                    <option value="UMK" {{ request('prioritas') == 'UMK' ? 'selected' : '' }}>
                                        UMK
                                    </option>
                                    <option value="Sosial/Ekonomi"
                                        {{ request('prioritas') == 'Sosial/Ekonomi' ? 'selected' : '' }}>
                                        Sosial/Ekonomi
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Provinsi</label>
                                <select name="provinsi" id="provinsi" class="form-control pilihProvinsi">
                                    <option value="">-- Semua Provinsi --</option>
                                    @foreach ($dataProvinsi as $prov)
                                        <option value="{{ $prov->provinsi }}"
                                            {{ request('provinsi') == $prov->provinsi ? 'selected' : '' }}>
                                            {{ ucwords($prov->provinsi) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kabupaten/Kota</label>
                                <select id="kabupaten" name="kabupaten" class="form-control pilihKabupaten">
                                    <option value="">-- Semua Kabupaten --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <select id="kecamatan" name="kecamatan" class="form-control pilihKecamatan">
                                    <option value="">-- Semua Kecamatan --</option>
                                    @if (old('kecamatan', $data->kecamatan ?? false))
                                        <option value="{{ old('kecamatan', $data->kecamatan) }}" selected>
                                            {{ old('kecamatan', $data->kecamatan) }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kelurahan/Desa</label>
                                <select id="kelurahan" name="kelurahan" class="form-control pilihKelurahan">
                                    <option value="">-- Semua Kelurahan --</option>
                                    @if (old('kelurahan', $data->kelurahan ?? false))
                                        <option value="{{ old('kelurahan', $data->kelurahan) }}" selected>
                                            {{ old('kelurahan', $data->kelurahan) }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('indexPembayaran') }}" class="btn btn-outline-danger">Reset</a>
                    <button type="submit" class="btn btn-info">Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    <form method="post" action="{{ route('updatePembayaran') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-pembayaranEdit" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">
                            Edit Pembayaran
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="pembayaranID" id="pembayaranID">
                        <div class="form-group">
                            <label>Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" maxlength="500" required></textarea>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Termin Ke <span class="text-danger">*</span></label>
                            <select class="form-control" name="termin" id="termin" required>
                                <option value="" disabled selected>-- Pilih Termin --</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            @error('termin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Jumlah Pembayaran <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" name="jumlahPembayaran"
                                    id="jumlahPembayaran_edit" value="{{ old('jumlahPembayaran') }}" required>
                                <input type="hidden" name="jumlahPembayaranAsli" id="jumlahPembayaranAsli_edit"
                                    value="{{ old('jumlahPembayaranAsli') }}">
                                @error('jumlahPembayaranAsli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Fee <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" name="fee"
                                    id="fee_edit" value="{{ old('fee') }}" required>
                                <input type="hidden" name="feeAsli" id="feeAsli_edit" value="{{ old('feeAsli') }}">
                                @error('fee')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            const table = $('#table_pembayaran').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                pageLength: 10,

                initComplete: function() {
                    const savedPage = localStorage.getItem('datatablePage');
                    if (savedPage !== null) {
                        this.api().page(parseInt(savedPage)).draw('page');
                    }
                }
            });

            table.on('page.dt', function() {
                const currentPage = table.page.info().page;
                localStorage.setItem('datatablePage', currentPage);
            });
        });
    </script>

    <script>
        $(document).on('click', '.editPembayaran', function(e) {
            document.getElementById("pembayaranID").value = $(this).attr('data-id');
            document.getElementById("deskripsi").value = $(this).attr('data-deskripsi');
            document.getElementById("termin").value = $(this).attr('data-termin');
            document.getElementById("jumlahPembayaran_edit").value = $(this).attr('data-jumlah_rupiah');
            document.getElementById("jumlahPembayaranAsli_edit").value = $(this).attr('data-jumlah');
            document.getElementById("fee_edit").value = $(this).attr('data-fee_rupiah');
            document.getElementById("feeAsli_edit").value = $(this).attr('data-fee');
        });
    </script>

    <script>
        var inputRupiah8 = document.getElementById('jumlahPembayaran_edit');
        var inputHidden8 = document.getElementById('jumlahPembayaranAsli_edit');

        inputRupiah8.addEventListener('input', function() {
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
            inputHidden8.value = convertToAngka(this.value);
        });

        var inputRupiah9 = document.getElementById('fee_edit');
        var inputHidden9 = document.getElementById('feeAsli_edit');

        inputRupiah9.addEventListener('input', function() {
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
            inputHidden9.value = convertToAngka(this.value);
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
        $(document).ready(function() {
            const pilarOld = "{{ request('pilar') }}";
            const tpbOld = "{{ request('tpb') }}";

            $('#pilar').change(function() {
                const pilar_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/dataTPB/" + encodeURIComponent(pilar_id),
                    success: function(response) {
                        $('#tpb').empty().append(
                            '<option value="">-- Semua TPB --</option>'
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

            // Jalankan sekali untuk load data TPB dari nilai lama saat edit
            if (pilarOld) {
                $('#pilar').val(pilarOld).trigger('change');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            const provOld = "{{ request('provinsi') }}";
            const kabOld = "{{ request('kabupaten') }}";
            const kecOld = "{{ request('kecamatan') }}";
            const kelOld = "{{ request('kelurahan') }}";

            function loadKabupaten(provinsi, callback) {
                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupaten/" + encodeURIComponent(provinsi),
                    success: function(response) {
                        $('#kabupaten').empty().append(
                            '<option value="">-- Semua Kabupaten --</option>');
                        $.each(response, function(i, kab) {
                            const selected = kab.value === kabOld ? 'selected' : '';
                            $('#kabupaten').append('<option value="' + kab.value + '" ' +
                                selected + '>' + kab.label + '</option>');
                        });
                        $('#kabupaten').prop('disabled', false);
                        if (callback) callback();
                    },
                    error: function() {
                        toastr.error("Gagal memuat kabupaten", "Failed", {
                            closeButton: true
                        });
                    }
                });
            }

            function loadKecamatan(provinsi, kabupaten, callback) {
                $.ajax({
                    type: 'GET',
                    url: `/proposal/data-kecamatan/${provinsi}/${kabupaten}`,
                    success: function(response) {
                        $('#kecamatan').empty().append(
                            '<option value="">-- Semua Kecamatan --</option>');
                        $.each(response, function(i, kec) {
                            const selected = kec.value === kecOld ? 'selected' : '';
                            $('#kecamatan').append(
                                `<option value="${kec.value}" ${selected}>${kec.label}</option>`
                            );
                        });
                        $('#kecamatan').prop('disabled', false);
                        if (callback) callback();
                    },
                    error: function() {
                        toastr.error("Gagal memuat kecamatan", "Failed", {
                            closeButton: true
                        });
                    }
                });
            }

            function loadKelurahan(provinsi, kabupaten, kecamatan) {
                $.ajax({
                    type: 'GET',
                    url: `/proposal/data-kelurahan/${provinsi}/${kabupaten}/${kecamatan}`,
                    success: function(response) {
                        $('#kelurahan').empty().append(
                            '<option value="">-- Semua Kelurahan --</option>');
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
            }

            // Auto-trigger saat halaman edit dimuat
            if (provOld) {
                $('#provinsi').val(provOld);
                loadKabupaten(provOld, function() {
                    if (kabOld) {
                        $('#kabupaten').val(kabOld);
                        loadKecamatan(provOld, kabOld, function() {
                            if (kecOld) {
                                $('#kecamatan').val(kecOld);
                                loadKelurahan(provOld, kabOld, kecOld);
                            }
                        });
                    }
                });
            }

            // Event saat user ubah dropdown secara manual
            $('#provinsi').change(function() {
                const prov = $(this).val();
                loadKabupaten(prov);
                $('#kecamatan').empty().append('<option value="">-- Semua Kecamatan --</option>');
                $('#kelurahan').empty().append('<option value="">-- Semua Kelurahan --</option>');
            });

            $('#kabupaten').change(function() {
                const prov = $('#provinsi').val();
                const kab = $(this).val();
                loadKecamatan(prov, kab);
                $('#kelurahan').empty().append('<option value="">-- Semua Kelurahan --</option>');
            });

            $('#kecamatan').change(function() {
                const prov = $('#provinsi').val();
                const kab = $('#kabupaten').val();
                const kec = $(this).val();
                loadKelurahan(prov, kab, kec);
            });
        });
    </script>

    <script>
        $('.modal-filter').on('shown.bs.modal', function() {
            $(this).find('.pilihProvinsi').select2({
                dropdownParent: $('.modal-filter'),
                width: '100%',
                placeholder: "-- Semua Provinsi --",
                allowClear: true
            });

            $(this).find('.pilihKabupaten').select2({
                dropdownParent: $('.modal-filter'),
                width: '100%',
                placeholder: "-- Semua Kabupaten/Kota --",
                allowClear: true
            });

            $(this).find('.pilihKecamatan').select2({
                dropdownParent: $('.modal-filter'),
                width: '100%',
                placeholder: "-- Semua Kecamatan --",
                allowClear: true
            });

            $(this).find('.pilihKelurahan').select2({
                dropdownParent: $('.modal-filter'),
                width: '100%',
                placeholder: "-- Semua Kelurahan --",
                allowClear: true
            });

            $(this).find('.pilihPengirim').select2({
                dropdownParent: $('.modal-filter'),
                width: '100%',
                placeholder: "-- Semua Pengirim --",
                allowClear: true
            });

            $(this).find('.pilihMaker').select2({
                dropdownParent: $('.modal-filter'),
                width: '100%',
                placeholder: "-- Semua Maker --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.delete').click(function() {
            var data_id = $(this).data('id');

            if (!data_id) return;

            swal({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin ingin menghapus data kelayakan proposal ini? Tindakan ini tidak bisa dibatalkan.",
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
                    window.location = "deleteKelayakan/" + data_id;
                }, 1000);
            });
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
