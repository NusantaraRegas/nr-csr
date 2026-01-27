@extends('layout.master')
@section('title', 'NR SHARE | Rekap Penyaluran TJSL-YKPP')

@section('content')
    <style>
        .card-summary-penyaluran {
            border: none;
            background: #f8f9fa;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .card-summary-penyaluran .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #343a40;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .card-summary-penyaluran .total-nilai {
            font-size: 1.2rem;
            font-weight: 800;
            color: #007bff;
            /* atau #198754 untuk hijau */
        }
    </style>

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

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    REKAP PENYALURAN TJSL-YKPP
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item active">Rekap Penyaluran TJSL-YKPP</li>
                    </ol>
                    <a href="{{ route('listPaymentYKPP') }}" class="btn btn-danger d-none d-lg-block m-l-15"><i
                            class="fas fa-refresh mr-2"></i>Reset
                    </a>

                    @if (request('status') == 'Verified')
                        <button type="button" class="btn btn-success d-none d-lg-block m-l-15" data-toggle="modal"
                            data-target=".modal-submit"><i class="fas fa-forward mr-2"></i>Submit Penyaluran
                        </button>
                    @else
                        <button type="button" data-toggle="modal" data-target=".modal-filter"
                            class="btn btn-info d-none d-lg-block m-l-15"><i class="fas fa-filter mr-2"></i>Filter Data
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-summary-penyaluran">
                    <div class="card-body text-center">
                        <h4 class="card-title">
                            TOTAL PENYALURAN TJSL
                        </h4>
                        <h2 class="total-nilai">
                            {{ 'Rp' . number_format($totalPenyaluran, 0, ',', '.') }}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-summary-penyaluran">
                    <div class="card-body text-center">
                        <h4 class="card-title">
                            TOTAL FEE (5%)
                        </h4>
                        <h2 class="total-nilai">
                            {{ 'Rp' . number_format($totalFee, 0, ',', '.') }}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-summary-penyaluran">
                    <div class="card-body text-center">
                        <h4 class="card-title">
                            TOTAL PEMBAYARAN YKPP
                        </h4>
                        <h2 class="total-nilai">
                            {{ 'Rp' . number_format($totalPembayaran, 0, ',', '.') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mb-2">
                                <h4 class="card-title font-weight-bold">Data Penyaluran YKPP</h4>
                            </div>
                            <div class="ml-auto">
                                @if ($dataKelayakan->count() > 0)
                                    <a href="{{ route('exportPenyaluran', request()->query()) }}"
                                        class="text-muted font-bold">
                                        <img src="{{ asset('template/assets/images/icon/excel.png') }}" class="mr-1"
                                            width="18px" alt="icon-excel"> Export
                                        Excel
                                    </a>
                                @endif
                            </div>
                        </div>
                        @if ($dataKelayakan->count() > 0)
                            <div class="table-responsive">
                                <table id="table_penyaluran" class="table table-striped">
                                    <thead class="thead-light font-bold">
                                        <tr>
                                            @if (request('status') == 'Verified')
                                                <th class="text-center" width="50px">Pilih</th>
                                            @else
                                                <th class="text-center" width="50px">No</th>
                                            @endif
                                            <th width="200px">Disposisi</th>
                                            <th width="300px">Penerima Manfaat</th>
                                            <th width="200px">Wilayah</th>
                                            <th class="text-right" width="100px" nowrap>Jumlah (Rp)</th>
                                            <th class="text-right" width="100px" nowrap>Fee (5%)</th>
                                            <th class="text-right" width="100px" nowrap>Subtotal (Rp)</th>
                                            <th width="100px">Status</th>
                                            @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                <th class="text-right" width="100px">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataKelayakan as $data)
                                            <tr>
                                                @if (request('status') == 'Verified')
                                                    <td style="text-align:center;">
                                                        <input type="checkbox" class="check"
                                                            data-checkbox="icheckbox_flat-red" name="id_pembayaran[]"
                                                            data-idKelayakan="{{ $data->id_pembayaran }}">
                                                    </td>
                                                @else
                                                    <td style="text-align:center;">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                @endif

                                                <td nowrap>
                                                    <h6 class="mb-1 font-bold">
                                                        <a class="text-info"
                                                            href="{{ route('detailKelayakan', Crypt::encrypt($data->id_kelayakan)) }}">
                                                            {{ $data->no_agenda }}
                                                        </a>
                                                    </h6>
                                                    <p class="text-muted text-justify">
                                                        {{ date('d-M-Y', strtotime($data->tgl_terima)) }}
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
                                                    <h6 class="mt-1 font-bold">
                                                        {{ 'Termin Ke ' . $data->termin }}
                                                    </h6>
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
                                                    @if ($data->status_ykpp == 'Open')
                                                        <span
                                                            class="badge badge-warning font-bold font-12 text-dark">OPEN</span>
                                                    @elseif($data->status_ykpp == 'Verified')
                                                        <span class="badge badge-info font-bold font-12">VERIFIED</span>
                                                    @elseif($data->status_ykpp == 'Submited')
                                                        <span class="badge badge-success font-bold font-12">SUBMITTED</span>
                                                    @endif
                                                </td>
                                                @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                    <td class="text-right" nowrap>
                                                        <ul class="list-inline mb-0">
                                                            <li class="list-inline-item">
                                                                <a href="{{ route('detailKelayakan', Crypt::encrypt($data->id_kelayakan)) }}"
                                                                    class="tooltip-trigger" title="Detail Kelayakan">
                                                                    <i class="fas fa-eye font-16"></i>
                                                                </a>
                                                            </li>
                                                            @if ($data->status_ykpp == 'Submited')
                                                                <li class="list-inline-item">
                                                                    <a class="unsubmittedYKPP tooltip-trigger"
                                                                        title="Unsubmit"
                                                                        data-id="{{ encrypt($data->id_pembayaran) }}"
                                                                        href="javascript:void(0)">
                                                                        <i class="fas fa-undo-alt text-info font-18"></i>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            <li class="list-inline-item">
                                                                <a class="unchecklistYKPP" class="tooltip-trigger"
                                                                    data-id="{{ encrypt($data->id_pembayaran) }}"
                                                                    href="javascript:void(0)" title="Unchecklist">
                                                                    <i class="fas fa-times text-danger font-18"></i>
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
                                <h5 class="mt-3">Data penyaluran YKPP tidak ditemukan</h5>
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
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form method="GET" action="{{ route('listPaymentYKPP') }}" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-bold" id="filterModalLabel">Filter Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control"
                                value="{{ request('tahun', date('Y')) }}" min="2000" max="2100">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">-- Semua Status --</option>
                                @foreach (['Open', 'Verified', 'Submited'] as $status)
                                    <option value="{{ $status }}"
                                        {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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
                            <option value="Pendidikan" {{ request('prioritas') == 'Pendidikan' ? 'selected' : '' }}>
                                Pendidikan
                            </option>
                            <option value="Lingkungan" {{ request('prioritas') == 'Lingkungan' ? 'selected' : '' }}>
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

                <div class="modal-footer">
                    <a href="{{ route('listPaymentYKPP') }}" class="btn btn-outline-danger">Reset</a>
                    <button type="submit" class="btn btn-info">Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade modal-submit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">Submit Penyaluran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Penyaluran Ke <span class="text-danger">*</span></label>
                            <select class="form-control pilihTahap" id="penyaluran">
                                <option value="">-- Pilih Tahapan --</option>
                                @for ($thn = 1; $thn <= 150; $thn++)
                                    <option>{{ $thn }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tahun <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-white" name="tahun" id="tahunPenyaluran"
                                value="{{ $tahun }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" id="btnApprove" class="btn btn-info">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $('.tooltip-trigger').tooltip();
        });
    </script>

    <script>
        $('.modal-submit').on('shown.bs.modal', function() {
            $(this).find('.pilihTahap').select2({
                dropdownParent: $('.modal-submit'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Tahap --",
                allowClear: true
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            const table = $('#table_penyaluran').DataTable({
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
        $(document).on('click', '.editStatus', function(e) {
            document.getElementById("kelayakanID").value = $(this).attr('kelayakan-id');
        });
    </script>

    <script>
        $('.unchecklistYKPP').click(function() {
            var data_id = $(this).data('id');

            if (!data_id) return;

            swal({
                title: "Konfirmasi Unchecklist",
                text: "Apakah Anda yakin ingin unchecklist data penyaluran ini dari daftar YKPP? Tindakan ini tidak bisa dibatalkan.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-secondary",
                confirmButtonText: "Ya, Lanjutkan",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                setTimeout(() => {
                    window.location = "unchecklistYKPP/" + data_id;
                }, 1000);
            });
        });
    </script>

    <script>
        $('.unsubmittedYKPP').click(function() {
            var data_id = $(this).data('id');

            if (!data_id) return;

            swal({
                title: "Konfirmasi Unsubmit",
                text: "Apakah Anda yakin ingin unsubmit data penyaluran ini dari daftar YKPP? Tindakan ini tidak bisa dibatalkan.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-secondary",
                confirmButtonText: "Ya, Lanjutkan",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                setTimeout(() => {
                    window.location = "unsubmittedYKPP/" + data_id;
                }, 1000);
            });
        });
    </script>

    <script>
        $('#btnApprove').click(function() {
            const penyaluran = $('#penyaluran').val();
            const tahun = $('#tahunPenyaluran').val();

            if (!penyaluran || !tahun) {
                toastr.warning('Urutan dan tahun penyaluran harus diisi', 'Warning', {
                    closeButton: true
                });
                return;
            }

            const ids = $('.check:checked').map(function() {
                return $(this).data('idkelayakan');
            }).get();

            if (ids.length === 0) {
                swal("Information", "Anda belum memilih data manapun", "info");
                return;
            }

            swal({
                title: "Konfirmasi Submit",
                text: "Pastikan data yang anda pilih sudah benar",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Submit",
                cancelButtonText: "Batal",
                confirmButtonClass: "btn-info",
                cancelButtonClass: "btn-secondary",
                closeOnConfirm: false,
                showLoaderOnConfirm: true // ✅ Ini yang penting
            }, function() {
                const ids = $('.check:checked').map(function() {
                    return $(this).data('idkelayakan');
                }).get();

                if (ids.length === 0) {
                    swal("Information", "Anda belum memilih data manapun", "info");
                    return;
                }

                $.ajax({
                    url: '/report/submitYKPP',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_pembayaran: ids,
                        penyaluran: $('#penyaluran').val(),
                        tahun: $('#tahunPenyaluran').val()
                    },
                    success: function(res) {
                        swal("Berhasil", "Data berhasil disubmit", "success");
                        setTimeout(() => window.location.reload(), 1500);
                    },
                    error: function() {
                        swal("Gagal", "Terjadi kesalahan saat submit", "error");
                    }
                });
            });
        });
    </script>

    <script>
        @if (Session::has('gagalMenemukan'))
            toastr.error('{{ Session::get('gagalMenemukan') }}', 'Failed', {
                closeButton: true
            });
        @endif

        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
