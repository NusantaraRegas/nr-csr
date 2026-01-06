@extends('layout.master')
@section('title', 'PGN SHARE | List Penyaluran TJSL-YKPP')

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

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold">
                    REKAP PENYALURAN YKPP
                    <br>
                    <small class="text-muted">TAHUN {{ $tahun }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item active">Rekap Penyaluran YKPP</li>
                    </ol>
                    <a href="{{ route('listPaymentYKPPSubmited') }}" class="btn btn-danger d-none d-lg-block m-l-15"><i
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
                @forelse ($penyaluran as $group)
                    {{-- ===== Header kartu penyaluran ===== --}}
                    <div class="ribbon-wrapper card mb-4">
                        <div class="ribbon ribbon-primary">
                            PENYALURAN KE {{ $group['penyaluran_ke'] }}
                        </div>

                        <div class="card-body">
                            <div class="d-flex">
                                {{-- Info surat --}}
                                <div>
                                    @if ($group['no_surat'])
                                        <h5 class="card-title font-weight-bold">
                                            <a href="#" data-toggle="tooltip" title="Preview PDF"
                                                data-src="/attachment/{{ $group['file_surat'] }}"
                                                class="previewPdf text-info mr-2">
                                                {{ $group['no_surat'] }}
                                            </a>
                                        </h5>
                                        <h6 class="card-subtitle mb-3">
                                            {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($group['tgl_surat']))) }}
                                        </h6>
                                    @else
                                        <h5 class="card-title font-weight-bold" style="color: red">
                                            Surat perintah belum
                                            diunggah
                                        </h5>
                                        <h6 class="card-subtitle mb-3">
                                            <a href="javascript:void(0)" class="uploadSurat text-muted"
                                                data-id="{{ encrypt($group['penyaluran_ke']) }}"
                                                data-tahun="{{ encrypt($group['tahun_ykpp']) }}" data-toggle="modal"
                                                data-target=".modal-surat">
                                                <i class="fas fa-upload text-info mr-2"></i>Upload Surat
                                            </a>
                                        </h6>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="ml-auto">
                                    @if ($group['no_surat'])
                                        <button type="button" class="btn btn-light editSurat"
                                            data-id="{{ encrypt($group['penyaluran_ke']) }}"
                                            data-tahun="{{ encrypt($group['tahun_ykpp']) }}"
                                            data-nomor="{{ $group['no_surat'] }}"
                                            data-tanggal="{{ date('d-m-Y', strtotime($group['tgl_surat'])) }}"
                                            data-toggle="modal" data-target=".modal-suratEdit">
                                            <i class="far fa-edit text-info mr-2"></i>Update Surat
                                        </button>
                                    @endif
                                    <a href="{{ route('printPenyaluran', [encrypt($group['penyaluran_ke']), encrypt($group['tahun_ykpp'])]) }}"
                                        target="_blank" class="btn btn-light">
                                        🖨️ Print Preview
                                    </a>
                                </div>
                            </div>

                            {{-- ===== Tabel detail proposal ===== --}}
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-light font-bold">
                                        <tr>
                                            <th class="text-center" width="50">No</th>
                                            <th width="200">Disposisi</th>
                                            <th width="300">Penerima Manfaat</th>
                                            <th width="200">Wilayah</th>
                                            <th width="300">Informasi Bank</th>
                                            <th class="text-right" width="100">Jumlah (Rp)</th>
                                            @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                <th class="text-right" width="50px">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($group['rows'] as $row)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>

                                                <td>
                                                    <h6 class="mb-1 font-bold text-uppercase">
                                                        {{ $row->no_agenda }}
                                                    </h6>
                                                    <p class="mb-0 text-muted">
                                                        {{ \Carbon\Carbon::parse($row->tgl_terima)->format('d M Y') }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <h6 class="mb-1 font-bold text-uppercase">
                                                        {{ $row->nama_lembaga }}
                                                    </h6>
                                                    <p class="mb-0 text-muted">{{ $row->deskripsi }}</p>
                                                </td>

                                                <td>
                                                    <h6 class="mb-1 font-bold">{{ $row->provinsi }}</h6>
                                                    <p class="mb-0 text-muted">{{ $row->kabupaten }}</p>
                                                </td>

                                                <td nowrap>
                                                    <h6 class="mb-1 font-bold">{{ $row->nama_bank }}</h6>
                                                    <p class="mb-0 text-muted">
                                                        <i
                                                            class="icon-credit-card text-info mr-2"></i>{{ $row->no_rekening }}
                                                    </p>
                                                    <p class="mb-0 text-muted">
                                                        <i class="icon-user text-info mr-2"></i>{{ $row->atas_nama }}
                                                    </p>
                                                </td>

                                                <td class="text-right">
                                                    {{ number_format($row->jumlah_pembayaran, 0, ',', '.') }}
                                                </td>

                                                @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                    <td class="text-right" nowrap>
                                                        <ul class="list-inline mb-0">
                                                            <li class="list-inline-item">
                                                                <a class="unsubmittedYKPP tooltip-trigger" title="Unsubmit"
                                                                    data-id="{{ encrypt($row->id_pembayaran) }}"
                                                                    href="javascript:void(0)">
                                                                    <i class="fas fa-undo-alt text-info font-18"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr class="border-top">
                                            <td colspan="5" class="text-right font-bold">Total</td>
                                            <td class="text-right font-bold">
                                                {{ number_format($group['rows']->sum('jumlah_pembayaran'), 0, ',', '.') }}
                                            </td>
                                            @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                <td></td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center py-4">
                                <i class="bi bi-database-fill-slash empty-icon"></i>
                                <h5 class="mt-3">Data penyaluran YKPP tidak ditemukan</h5>
                                <p class="text-muted mb-0">Klik tombol "Filter Data" di kanan atas untuk
                                    mulai pencarian.
                                </p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="modal fade modal-filter" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="GET" action="{{ route('listPaymentYKPPSubmited') }}" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-bold" id="filterModalLabel">Filter Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control"
                                value="{{ request('tahun', date('Y')) }}" min="2000" max="2100">
                        </div>
                        <div class="form-group col-md-9">
                            <label>Penyaluran Ke <span class="text-danger">*</span></label>
                            <select class="form-control pilihTahapan" name="penyaluran">
                                <option value="">-- Semua Tahapan --</option>
                                @for ($thn = 1; $thn <= 25; $thn++)
                                    <option value="{{ $thn }}"
                                        {{ request('penyaluran') == $thn ? 'selected' : '' }}>
                                        {{ $thn }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('listPaymentYKPPSubmited') }}" class="btn btn-outline-danger">Reset</a>
                    <button type="submit" class="btn btn-info">Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    <form method="post" enctype="multipart/form-data" action="{{ action('KelayakanController@uploadSuratYKPP') }}">
        @csrf
        <div class="modal fade modal-surat" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold"><i class="fas fa-upload mr-2"></i>Upload Surat</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="penyaluran" id="penyaluran">
                        <input type="hidden" name="tahun" id="tahun">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tanggal <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control mdate" name="tanggal"
                                        value="{{ old('tanggal') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar text-info"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('tanggal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nomor Surat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-uppercase" name="noSurat"
                                    value="{{ old('noSurat') }}">
                                @error('noSurat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Surat Perintah <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="lampiran" accept="application/pdf"
                                required>
                            <small class="text-muted">Format yang didukung: PDF (maks. 10MB)</small>
                            @error('lampiran')
                                <br>
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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

    <form method="POST" enctype="multipart/form-data" action="{{ action('KelayakanController@updateSuratYKPP') }}">
        @csrf
        <input type="hidden" name="penyaluran" id="penyaluran_edit">
        <input type="hidden" name="tahun" id="tahun_edit">

        <div class="modal fade modal-suratEdit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit Surat
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tanggal <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control mdate" name="tanggal" id="tanggal">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar text-info"></i></span>
                                    </div>
                                </div>
                                @error('tanggal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nomor Surat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-uppercase" name="noSurat" id="noSurat">
                                @error('noSurat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Surat Perintah</label>
                            <input type="file" name="lampiran" class="form-control" accept="application/pdf">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah file.</small>
                            @error('lampiran')
                                <br>
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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


    <!-- Modal Preview PDF -->
    <div class="modal fade" id="previewPdfModal" tabindex="-1" role="dialog" aria-labelledby="previewPdfModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-bold">Preview Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0" style="height: 80vh;">
                    <iframe id="pdfPreviewFrame" src="" width="100%" height="100%" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script
        src="{{ asset('template/assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
    </script>

    <script>
        $('.mdate').bootstrapMaterialDatePicker({
            maxDate: new Date(),
            format: 'DD-MM-YYYY',
            time: false
        });
    </script>

    <script>
        $(document).on('click', '.previewPdf', function(e) {
            e.preventDefault();
            const fileSrc = $(this).data('src');
            $('#pdfPreviewFrame').attr('src', fileSrc);
            $('#previewPdfModal').modal('show');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.tooltip-trigger').tooltip();
        });
    </script>

    <script>
        $(document).ready(function() {
            const table = $('.table_submit').DataTable({
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
        $(document).on('click', '.uploadSurat', function(e) {
            document.getElementById("penyaluran").value = $(this).attr('data-id');
            document.getElementById("tahun").value = $(this).attr('data-tahun');
        });
    </script>

    <script>
        $(document).on('click', '.editSurat', function(e) {
            document.getElementById("penyaluran_edit").value = $(this).attr('data-id');
            document.getElementById("tahun_edit").value = $(this).attr('data-tahun');
            document.getElementById("noSurat").value = $(this).attr('data-nomor');
            document.getElementById("tanggal").value = $(this).attr('data-tanggal');
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
        $('.modal-filter').on('shown.bs.modal', function() {
            $(this).find('.pilihTahapan').select2({
                dropdownParent: $('.modal-filter'),
                width: '100%',
                //placeholder: "-- Semua Tahapan --",
                allowClear: true
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
