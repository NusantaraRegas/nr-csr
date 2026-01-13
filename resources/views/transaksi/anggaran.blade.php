@extends('layout.master')
@section('title', 'NR SHARE | Anggaran')
@section('content')
    <style>
        .card-summary-penyaluran {
            border: none;
            background: #f8f9fa;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-summary-penyaluran:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            /* agar setara input */
        }
    </style>

    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    ANGGARAN<br>
                    <small>{{ $perusahaan->nama_perusahaan }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Anggaran</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                        class="btn btn-info d-none d-lg-block m-l-15"><i class="fas fa-plus-circle mr-2"></i>Tambah Anggaran
                    </button>
                </div>
            </div>
        </div>

        @if (session('user')->id_perusahaan == 1)
            <form method="GET" action="{{ route('indexBudget') }}">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-9">
                                <label>Cari Berdasarkan Perusahaan</label>
                                <select name="perusahaan" class="form-control pilihPerusahaan">
                                    <option value="">-- Semua Perusahaan --</option>
                                    @foreach ($dataPerusahaan as $p)
                                        <option value="{{ $p->id_perusahaan }}"
                                            {{ request('perusahaan') == $p->id_perusahaan || (!request()->has('perusahaan') && isset($perusahaan) && $perusahaan->id_perusahaan == $p->id_perusahaan) ? 'selected' : '' }}>
                                            {{ $p->nama_perusahaan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-search mr-1"></i> Search
                                </button>
                                <a href="{{ route('indexBudget') }}" class="btn btn-outline-danger">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif

        <div class="row">
            @if ($dataAnggaran->count() > 0)
                @foreach ($dataAnggaran as $data)
                    @php
                        $lastYear = $data->tahun - 1;

                        $jumlahAnggaran = \App\Models\Anggaran::where('id_perusahaan', $data->id_perusahaan)
                            ->where('tahun', $lastYear)
                            ->count();
                        $anggaran = \App\Models\Anggaran::where('id_perusahaan', $data->id_perusahaan)
                            ->where('tahun', $lastYear)
                            ->first();

                        if ($jumlahAnggaran > 0) {
                            $budget = $anggaran->nominal;
                        } else {
                            $budget = 0;
                        }

                        $perusahaan = \App\Models\Perusahaan::where('id_perusahaan', $data->id_perusahaan)->first();
                    @endphp
                    <div class="col-lg-4 col-md-6">
                        <div class="card card-summary-penyaluran">
                            <div class="card-header bg-primary">
                                <h4 class="m-b-0 text-white">{{ $perusahaan->nama_perusahaan }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="card-title font-weight-bold">{{ $data->tahun }}</h4>
                                    </div>
                                    <div class="ml-auto mb-4">
                                        <button type="button" class="btn btn-secondary btn-xs font-bold dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item edit" data-id="{{ encrypt($data->id_anggaran) }}"
                                                data-nominal="{{ 'Rp. ' . number_format($data->nominal, 0, ',', '.') }}"
                                                data-nominal_asli="{{ $data->nominal }}" data-tahun="{{ $data->tahun }}"
                                                data-target=".modal-edit" data-toggle="modal" href="javascript:void(0)">
                                                <i class="far fa-edit text-info mr-2"></i>Edit
                                            </a>
                                            <a class="dropdown-item delete" data-id="{{ encrypt($data->id_anggaran) }}"
                                                data-tahun="{{ $data->tahun }}" href="javascript:void(0)">
                                                <i class="far fa-trash-alt text-danger mr-2"></i>Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right"><span class="text-muted">Total Anggaran</span>
                                    <h2 class="font-light font-weight-bold"><sup><i
                                                class="{{ $data->nominal > $budget ? 'fas fa-arrow-up text-success' : 'fas fa-arrow-down text-danger' }}"></i></sup>
                                        {{ number_format($data->nominal, 0, ',', '.') }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center py-4">
                                <i class="bi bi-database-fill-slash" style="font-size: 40px;"></i>
                                <h5 class="mt-3">Data anggaran tidak ditemukan</h5>
                                <p class="text-muted mb-0">Silakan klik "Tambah Anggaran" untuk mulai menambahkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <form method="post" action="{{ route('storeAnggaran') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Tambah Anggaran</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            Simpan
                        </button>
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
                        <h4 class="modal-title font-weight-bold">Edit Anggaran</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="anggaranID" id="anggaranID">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $('.tooltip-trigger').tooltip();
        });
    </script>

    <script>
        $(document).ready(function() {
            const table = $('#table_anggaran').DataTable({
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
        $(document).ready(function() {
            $(".pilihPerusahaan").select2({
                width: '100%',
                placeholder: "-- Pilih Perusahaan --",
                allowClear: false
            });
        });
    </script>

    <script>
        $(document).on('click', '.edit', function(e) {
            document.getElementById("anggaranID").value = $(this).attr('data-id');
            document.getElementById("nominal_edit").value = $(this).attr('data-nominal');
            document.getElementById("nominalAsli_edit").value = $(this).attr('data-nominal_asli');
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
                    window.location = "deleteAnggaran/" + data_id;
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
