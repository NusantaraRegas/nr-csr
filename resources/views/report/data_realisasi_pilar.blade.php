@extends('layout.master')
@section('title', 'PGN SHARE | Realisasi Pilar')
@section('content')
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            /* agar setara input */
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

    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    REALISASI PILAR<br>
                    <small>Tahun {{ $tahun }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item">Realisasi Penyaluran TJSL</li>
                        <li class="breadcrumb-item active">Realisasi Pilar</li>
                    </ol>
                    <a href="{{ route('indexRealisasiPilar') }}" class="btn btn-danger d-none d-lg-block m-l-15"><i
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
                                <a href="{{ route('exportRealisasiPilar', request()->query()) }}"
                                    class="font-bold text-muted">
                                    <img src="{{ asset('template/assets/images/icon/excel.png') }}" class="mr-1"
                                        width="18px" alt="icon-excel"> Export
                                    Excel
                                </a>
                            </div>
                        </div>
                        @if ($dataPilar->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-light font-bold">
                                        <tr>
                                            <th width="50px" class="text-center">No</th>
                                            <th width="400px">Pilar</th>
                                            <th class="text-right" width="100px" nowrap>Anggaran (Rp)</th>
                                            <th class="text-right" width="100px" nowrap>Realisasi (Rp)</th>
                                            <th class="text-right" width="100px" nowrap>Selisih (Rp)</th>
                                            <th class="text-right" width="100px" nowrap>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataPilar as $data)
                                            <tr>
                                                <td style="text-align:center;">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 font-bold">
                                                        {{ $data['pilar'] }}
                                                    </h6>
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($data['anggaran'], 0, ',', '.') }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($data['realisasi'], 0, ',', '.') }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($data['selisih'], 0, ',', '.') }}
                                                </td>
                                                <td class="text-right">
                                                    <h6 class="mb-0 font-bold">
                                                        {{ $data['persentase'] . '%' }}
                                                    </h6>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-database-fill-slash empty-icon"></i>
                                <h5 class="mt-3">Data realisasi pilar tidak ditemukan</h5>
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
        <div class="modal-dialog modal-sm" role="document">
            <form method="GET" action="{{ route('indexRealisasiPilar') }}" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-bold" id="filterModalLabel">Filter Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-0">
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
                                <option value="{{ $da->tahun }}" {{ $selectedTahun == $da->tahun ? 'selected' : '' }}>
                                    {{ $da->tahun }}
                                </option>
                            @endforeach

                            @if (!$tahunSudahAda)
                                <option value="{{ $selectedTahun }}" selected>{{ $selectedTahun }}</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('indexRealisasiPilar') }}" class="btn btn-outline-danger">Reset</a>
                    <button type="submit" class="btn btn-info">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
