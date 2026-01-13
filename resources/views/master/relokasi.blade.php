@extends('layout.master')
@section('title', 'NR SHARE | Relokasi Anggaran')

@section('content')
    <style>
        .empty-icon {
            display: inline-block;
            font-size: 60px;
            color: #888;
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

    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    RELOKASI ANGGARAN PROGRAM KERJA<br>
                    <small>{{ $perusahaan->nama_perusahaan }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Anggaran</li>
                        <li class="breadcrumb-item active">Relokasi</li>
                    </ol>
                    <a href="{{ route('createRelokasi') }}" type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                            class="fas fa-plus-circle mr-2"></i>Tambah Relokasi
                    </a>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('indexRelokasi') }}">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="form-row align-items-end">
                        <div class="form-group col-md-8">
                            <label>Nama Perusahaan</label>
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
                        <div class="form-group col-md-2">
                            <label>Tahun Anggaran</label>
                            <select name="tahun" class="form-control">
                                @php
                                    $selectedTahun = request('tahun', date('Y'));
                                    $tahunSudahAda = false;
                                @endphp
                                <option value="">-- Pilih Tahun --</option>
                                @foreach ($dataAnggaran as $da)
                                    @if ($da->tahun == $selectedTahun)
                                        @php $tahunSudahAda = true; @endphp
                                    @endif
                                    <option value="{{ $da->tahun }}"
                                        {{ $selectedTahun == $da->tahun ? 'selected' : '' }}>
                                        {{ $da->tahun }}
                                    </option>
                                @endforeach

                                @if (!$tahunSudahAda)
                                    <option value="{{ $selectedTahun }}" selected>{{ $selectedTahun }}</option>
                                @endif
                            </select>
                            @error('tahun')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-search mr-1"></i> Search
                            </button>
                            <a href="{{ route('indexRelokasi') }}" class="btn btn-outline-danger">
                                Reset
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if ($anggaran > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($dataRelokasi->count() > 0)
                                <div class="table-responsive">
                                    <table id="table_relokasi" class="table table-striped">
                                        <thead class="thead-light font-bold">
                                            <tr>
                                                <th class="text-center" width="10px">No</th>
                                                <th class="text-center" width="100px">Tanggal</th>
                                                <th width="500px">Sumber Anggaran</th>
                                                <th width="500px">Tujuan</th>
                                                <th class="text-right" width="100px">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataRelokasi as $data)
                                                <?php
                                                $prokerAsal = \App\Models\Proker::where('id_proker', $data->proker_asal)->first();
                                                $prokerTujuan = \App\Models\Proker::where('id_proker', $data->proker_tujuan)->first();
                                                ?>
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center" nowrap>
                                                        <h6 class="mb-1 font-bold">
                                                            {{ date('d-m-Y', strtotime($data->request_date)) }}
                                                        </h6>
                                                        <p class="mb-0 text-muted">
                                                            {{ date('H:i:s', strtotime($data->request_date)) }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <h6 class="mb-1 font-bold">
                                                            {{ $prokerAsal->proker }}
                                                        </h6>
                                                        <p class="mb-0 text-muted">
                                                            {{ number_format($data->nominal_asal, 0, ',', '.') . ' - ' }}
                                                            <span
                                                                class="text-danger">{{ number_format($data->nominal_relokasi, 0, ',', '.') }}</span>{{ ' = ' . number_format($data->nominal_asal - $data->nominal_relokasi, 0, ',', '.') }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <h6 class="mb-1 font-bold">
                                                            {{ $prokerTujuan->proker }}
                                                        </h6>
                                                        <p class="mb-0 text-muted">
                                                            {{ number_format($data->nominal_tujuan, 0, ',', '.') . ' + ' }}<span
                                                                class="text-danger">{{ number_format($data->nominal_relokasi, 0, ',', '.') }}</span>{{ ' = ' . number_format($data->nominal_tujuan + $data->nominal_relokasi, 0, ',', '.') }}
                                                        </p>
                                                    </td>
                                                    <td class="text-right" nowrap>
                                                        <ul class="list-inline mb-0">
                                                            <li class="list-inline-item">
                                                                <a href="#!" class="delete" data-toggle="tooltip"
                                                                    title="Hapus"
                                                                    data-id="{{ encrypt($data->id_relokasi) }}">
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
                                    <span class="empty-icon">
                                        <i class="bi bi-database-fill-slash"></i>
                                    </span>
                                    <h5 class="mt-3">Data relokasi program kerja tidak ditemukan</h5>
                                    <p class="text-muted mb-0">Klik tombol "Search" di kanan atas untuk
                                        mulai pencarian.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning mb-0">
                        <h4 class="model-huruf-family"><i class="fa fa-warning"></i> Warning</h4> Belum ada anggaran
                        yang
                        dibuat oleh {{ $perusahaan->nama_perusahaan }} di tahun {{ $tahun }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $('.tooltip-trigger').tooltip();
        });
    </script>

    <script>
        $(document).ready(function() {
            const table = $('#table_relokasi').DataTable({
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
        $('.delete').click(function() {
            var data_id = $(this).data('id');

            if (!data_id) return;

            swal({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin ingin menghapus data relokasi ini? Tindakan ini tidak bisa dibatalkan.",
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
                    window.location = "deleteRelokasi/" + data_id;
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
