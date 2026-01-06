@extends('layout.master')
@section('title', 'PGN SHARE | Realisasi Program Kerja')
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
    </style>

    @php
        $lastYear = $tahun - 1;

        $jumlahAnggaran = \App\Models\Anggaran::where('tahun', $lastYear)->count();
        $budgetLastYear = \App\Models\Anggaran::where('tahun', $lastYear)->first();

        if ($jumlahAnggaran > 0) {
            $budget = $budgetLastYear;
        } else {
            $budget = 0;
        }
    @endphp

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    REKAP REALISASI PROGRAM KERJA<br>
                    <small>Tahun {{ $tahun }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item">Realisasi Penyaluran TJSL</li>
                        <li class="breadcrumb-item active">Realisasi Program Kerja</li>
                    </ol>
                    <a href="{{ route('indexRealisasiProker') }}" class="btn btn-danger d-none d-lg-block m-l-15"><i
                            class="fas fa-refresh mr-2"></i>Reset
                    </a>
                    <button type="button" data-toggle="modal" data-target=".modal-filter"
                        class="btn btn-info d-none d-lg-block m-l-15"><i class="fas fa-filter mr-2"></i>Filter Data
                    </button>
                </div>
            </div>
        </div>

        @if ($dataProker->count() > 0)
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-summary-penyaluran">
                        <div class="card-body">
                            <h4 class="card-title model-huruf-family mb-4">ANGGARAN</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <span>
                                                <i class="ti-wallet text-info" style="font-size: 55px"></i>
                                            </span>
                                            <br>
                                            <small class="text-muted">Total</small>
                                        </div>
                                        <div class="ml-auto">
                                            <h3 class="counter">
                                                <b class="font-weight-bold"><sup><i
                                                            class="{{ $anggaran > $budget ? 'fas fa-arrow-up text-success' : 'fas fa-arrow-down text-danger' }}"></i></sup>
                                                    {{ 'Rp' . number_format($anggaran, 0, ',', '.') }}
                                                </b>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-summary-penyaluran">
                        <div class="card-body">
                            <h4 class="card-title model-huruf-family mb-4">REALISASI PROGRAM KERJA</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <span class="pie"
                                                data-peity='{ "fill": ["#1de9b6", "#f2f2f2"]}'>{{ round(($realisasi / $anggaran) * 100, 2) }},{{ round(($sisa / $anggaran) * 100, 2) }}</span>
                                            <br>
                                            <small class="text-muted">Status
                                                : {{ round(($realisasi / $anggaran) * 100, 3) . '%' }}</small>
                                        </div>
                                        <div class="ml-auto">
                                            <h3 class="counter">
                                                <b
                                                    class="font-weight-bold">{{ 'Rp' . number_format($realisasi, 0, ',', '.') }}</b>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-summary-penyaluran">
                        <div class="card-body">
                            <h4 class="card-title model-huruf-family mb-4">SISA ANGGARAN</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <span class="pie"
                                                data-peity='{ "fill": ["#f44236", "#f2f2f2"]}'>{{ round(($sisa / $anggaran) * 100, 2) }},{{ round(($realisasi / $anggaran) * 100, 2) }}</span>
                                            <br>
                                            <small class="text-muted">Status
                                                : {{ round(($sisa / $anggaran) * 100, 2) . '%' }}</small>
                                        </div>
                                        <div class="ml-auto">
                                            <h3 class="counter">
                                                @if ($sisa < 0)
                                                    <b class="font-weight-bold"
                                                        style="color: red">{{ 'Rp' . number_format($sisa, 0, ',', '.') }}</b>
                                                @else
                                                    <b
                                                        class="font-weight-bold">{{ 'Rp' . number_format($sisa, 0, ',', '.') }}</b>
                                                @endif
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mb-2">
                                <h4 class="card-title font-weight-bold">Data Realisasi</h4>
                            </div>
                            <div class="ml-auto">
                                <a href="{{ route('exportRealisasiProker', request()->query()) }}"
                                    class="font-bold text-muted">
                                    <img src="{{ asset('template/assets/images/icon/excel.png') }}" class="mr-1"
                                        width="18px" alt="icon-excel"> Export
                                    Excel
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table_realisasi" class="table table-striped">
                                <thead class="thead-light font-bold">
                                    <tr>
                                        <th width="50px" class="text-center" nowrap>Proker ID</th>
                                        <th width="300px">Program Kerja</th>
                                        <th width="300px">Pilar & TPB</th>
                                        <th width="150px" class="text-right" nowrap>Anggaran (Rp)</th>
                                        <th width="150px" class="text-right" nowrap>Realisasi (Rp)</th>
                                        <th width="150px" class="text-right" nowrap>Sisa (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataProker as $data)
                                        @php
                                            $realisasi = $realisasiProker[$data->id_proker] ?? 0;
                                            $sisaAnggaran = $data->anggaran - $realisasi;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ '#' . $data->id_proker }}</td>
                                            <td>
                                                <h6 class="mb-1 font-bold">
                                                    @if ($realisasi > 0)
                                                        <a class="text-info" data-toggle="tooltip" title="Rekap Realisasi"
                                                            href="{{ route('indexPembayaran', ['tahun' => $tahun, 'proker' => $data->id_proker]) }}">
                                                            {{ $data->proker }}
                                                        </a>
                                                    @else
                                                        {{ $data->proker }}
                                                    @endif
                                                </h6>
                                                <p class="mb-0 text-muted">{{ $data->prioritas ?: 'Sosial/Ekonomi' }}</p>
                                            </td>
                                            <td>
                                                <h6 class="mb-1 font-bold">{{ $data->pilar }}</h6>
                                                <p class="mb-0 text-muted">{{ $data->kode_tpb . '. ' . $data->gols }}</p>
                                            </td>
                                            <td class="text-right">{{ number_format($data->anggaran, 0, ',', '.') }}</td>
                                            <td class="text-right">{{ number_format($realisasi, 0, ',', '.') }}</td>
                                            <td class="text-right">
                                                <span style="color: {{ $sisaAnggaran < 0 ? 'red' : 'inherit' }}">
                                                    {{ number_format($sisaAnggaran, 0, ',', '.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-filter" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form method="GET" action="{{ route('indexRealisasiProker') }}" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-bold" id="filterModalLabel">Filter Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Tahun Anggaran</label>
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="{{ request('tahun', date('Y')) }}">{{ request('tahun', date('Y')) }}
                                </option>
                                @foreach ($dataAnggaran as $da)
                                    <option value="{{ $da->tahun }}"
                                        {{ request('tahun') == $da->tahun ? 'selected' : '' }}>
                                        {{ $da->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
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
                    </div>
                    <div class="form-group">
                        <label>TPB</label>
                        <select name="tpb" id="tpb" class="form-control">
                            <option value="">-- Semua TPB --</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('indexRealisasiProker') }}" class="btn btn-outline-danger">Reset</a>
                    <button type="submit" class="btn btn-info">Terapkan</button>
                </div>
            </form>
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
        $(document).ready(function() {
            const table = $('#table_realisasi').DataTable({
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
        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
