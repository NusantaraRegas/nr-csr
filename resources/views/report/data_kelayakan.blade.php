@extends('layout.master')
@section('title', 'NR SHARE | Rekap Kelayakan Proposal')

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
                <h4 class="font-bold">
                    REKAP KELAYAKAN PROPOSAL
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item active">Rekap Kelayakan Proposal</li>
                    </ol>
                    <a href="{{ route('dataKelayakan') }}" class="btn btn-danger d-none d-lg-block m-l-15"><i
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
                                <h4 class="card-title font-weight-bold">Data Kelayakan Proposal</h4>
                            </div>
                            <div class="ml-auto">
                                <a href="{{ route('exportKelayakan', request()->query()) }}" class="m-l-15">
                                    <img src="{{ asset('template/assets/images/icon/excel.png') }}" class="mr-1"
                                        width="18px" alt="icon-excel"> Export
                                    Excel
                                </a>
                            </div>
                        </div>
                        @if ($dataKelayakan->count() > 0)
                            <div class="table-responsive">
                                <table id="table_kelayakan" class="table table-striped">
                                    <thead class="thead-light font-bold">
                                        <tr>
                                            <th class="text-center" width="50px">ID</th>
                                            <th width="200px">Disposisi</th>
                                            <th width="400px">Penerima Manfaat</th>
                                            <th width="200px">Wilayah</th>
                                            <th width="100px">Jenis</th>
                                            <th width="100px">Status</th>
                                            <th class="text-right" width="100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataKelayakan as $data)
                                            <tr>
                                                <td style="text-align:center;">{{ '#' . $data->id_kelayakan }}</td>
                                                <td nowrap>
                                                    <h6 class="mb-1 font-bold">
                                                        <a class="text-info"
                                                            href="{{ route('detailKelayakan', Crypt::encrypt($data->id_kelayakan)) }}">
                                                            {{ $data->no_agenda }}
                                                        </a>
                                                    </h6>
                                                    @if (!empty($data->pengirim))
                                                        <p class="mb-0 text-muted">{{ $data->pengirim }}</p>
                                                    @endif
                                                    <p class="mb-1 text-muted">
                                                        {{ date('d-M-Y', strtotime($data->tgl_terima)) }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <h6 class="mb-1 font-bold">{{ strtoupper($data->nama_lembaga) }}</h6>
                                                    <p class="mb-1 text-muted">{{ $data->deskripsi }}</p>
                                                    @if (!empty($data->nilai_bantuan))
                                                        <h6 class="mb-0 font-weight-bold" style="color: red">
                                                            {{ 'Rp. ' . number_format($data->nilai_bantuan, 0, ',', '.') }}
                                                        </h6>
                                                    @endif
                                                </td>
                                                <td>
                                                    <h6 class="mb-1 font-bold">{{ $data->provinsi }}</h6>
                                                    <p class="mb-0 text-muted">{{ $data->kabupaten }}</p>
                                                </td>
                                                <td nowrap>{{ $data->jenis }}</td>
                                                <td nowrap>
                                                    @if ($data->status == 'Draft')
                                                        <span
                                                            class="badge badge-warning font-bold font-12 text-dark">DRAFT</span>
                                                    @elseif($data->status == 'Evaluasi')
                                                        <span class="badge badge-success font-bold font-12">EVALUASI
                                                            PROPOSAL</span>
                                                    @elseif($data->status == 'Survei')
                                                        <span class="badge badge-info font-bold font-12">SURVEI
                                                            PROPOSAL</span>
                                                    @elseif($data->status == 'Approved')
                                                        <span
                                                            class="badge badge-primary font-bold font-12 text-white">APPROVED</span>
                                                    @elseif($data->status == 'Rejected')
                                                        <span class="badge badge-danger font-bold font-12">REJECTED</span>
                                                    @endif
                                                </td>
                                                <td class="text-right" nowrap>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('detailKelayakan', Crypt::encrypt($data->id_kelayakan)) }}"
                                                                data-toggle="tooltip" title="Detail Kelayakan">
                                                                <i class="fas fa-eye font-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('editKelayakan', Crypt::encrypt($data->id_kelayakan)) }}"
                                                                data-toggle="tooltip" title="Edit">
                                                                <i class="far fa-edit text-info font-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="#!" class="delete" data-toggle="tooltip"
                                                                title="Hapus"
                                                                data-id="{{ encrypt($data->id_kelayakan) }}">
                                                                <i class="far fa-trash-alt text-danger font-18"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-database-fill-slash empty-icon"></i>
                                <h5 class="mt-3">Data kelayakan proposal tidak ditemukan</h5>
                                <p class="text-muted mb-0">Silakan klik menu "Kelayakan Proposal" untuk mulai menambahkan.
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
            <form method="GET" action="{{ route('dataKelayakan') }}" class="modal-content">
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
                                @foreach (['Draft', 'Evaluasi', 'Survei', 'Approved', 'Rejected'] as $status)
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
                                <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <select name="provinsi" class="form-control pilihProvinsi">
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
                        <label>Pengirim</label>
                        <select name="pengirim" class="form-control pilihPengirim">
                            <option value="">-- Semua Pengirim --</option>
                            @foreach ($dataPengirim as $peng)
                                <option value="{{ $peng->pengirim }}"
                                    {{ request('lembaga') == $peng->pengirim ? 'selected' : '' }}>
                                    {{ $peng->pengirim }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Maker</label>
                        <select name="maker" class="form-control pilihMaker">
                            <option value="">-- Semua Maker --</option>
                            @foreach ($dataMaker as $mak)
                                <option value="{{ $mak->id_user }}"
                                    {{ request('lembaga') == $mak->id_user ? 'selected' : '' }}>
                                    {{ $mak->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('dataKelayakan') }}" class="btn btn-outline-danger">Reset</a>
                    <button type="submit" class="btn btn-info">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            const table = $('#table_kelayakan').DataTable({
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
        $('.modal-filter').on('shown.bs.modal', function() {
            $(this).find('.pilihProvinsi').select2({
                dropdownParent: $('.modal-filter'),
                width: '100%',
                placeholder: "-- Semua Provinsi --",
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
                    submitDelete("deleteKelayakan/" + data_id);
                }, 1000);
            });
        });
    </script>
@stop
