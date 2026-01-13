@extends('layout.master')
@section('title', 'NR SHARE | Program Kerja')

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
    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    ALOKASI ANGGARAN PROGRAM KERJA<br>
                    <small>{{ $perusahaan->nama_perusahaan }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Anggaran</li>
                        <li class="breadcrumb-item active">Program Kerja</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                        class="btn btn-info d-none d-lg-block m-l-15"><i class="fas fa-plus-circle mr-2"></i>Tambah Proker
                    </button>
                </div>
            </div>
        </div>

        @if ($dataProker->count() > 0)
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-summary-penyaluran">
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold mb-4">ANGGARAN {{ $tahun }}</h4>
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
                            <h4 class="card-title font-weight-bold mb-4">ALOKASI
                                @if ($dataProker->count() > 0)
                                    <button type="button"
                                        class="btn btn-xs btn-outline-success btn-rounded font-bold float-right"
                                        data-toggle="collapse" data-target="#collapsePrioritas" aria-expanded="false"
                                        aria-controls="collapsePrioritas">
                                        Prioritas
                                    </button>
                                    <button type="button"
                                        class="btn btn-xs btn-outline-success btn-rounded font-bold float-right mr-1"
                                        data-toggle="collapse" data-target="#collapsePilar" aria-expanded="false"
                                        aria-controls="collapsePilar">
                                        Pilar
                                    </button>
                                @endif
                            </h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <span class="pie"
                                                data-peity='{ "fill": ["#1de9b6", "#f2f2f2"]}'>{{ round(($totalAlokasi / $anggaran) * 100, 2) }},{{ round(($sisa / $anggaran) * 100, 2) }}</span>
                                            <br>
                                            <small class="text-muted">Status
                                                : {{ round(($totalAlokasi / $anggaran) * 100, 3) . '%' }}</small>
                                        </div>
                                        <div class="ml-auto">
                                            <h3 class="counter">
                                                <b
                                                    class="font-weight-bold">{{ 'Rp' . number_format($totalAlokasi, 0, ',', '.') }}</b>
                                            </h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="collapse" id="collapsePilar">
                                    <div class="col-12">
                                        <table class="table-striped mt-3" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3" style="padding: 5px" class="font-weight-bold">
                                                        PILAR
                                                    </td>
                                                </tr>
                                                @foreach ($alokasiPilar as $ap)
                                                    <tr>
                                                        <td width="300px" style="padding: 5px">{{ $ap->pilar }}</td>
                                                        <td class="text-right" width="100px" style="padding: 5px">
                                                            {{ round(($ap->total / $anggaran) * 100, 2) . '%' }}</td>
                                                        <td width="150px" style="text-align: right; padding: 5px">
                                                            {{ number_format($ap->total, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="collapse" id="collapsePrioritas">
                                    <div class="col-12">
                                        <table class="table-striped mt-3" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3" style="padding: 5px" class="font-weight-bold">
                                                        PRIORITAS
                                                    </td>
                                                </tr>
                                                @foreach ($alokasiPrioritas as $app)
                                                    <tr>
                                                        <td width="300px" style="padding: 5px">
                                                            {{ $app->prioritas }}
                                                        </td>
                                                        <td class="text-right" width="100px" style="padding: 5px">
                                                            {{ round(($app->total / $anggaran) * 100, 2) . '%' }}</td>
                                                        <td width="150px" style="text-align: right; padding: 5px">
                                                            {{ number_format($app->total, 0, ',', '.') }}</td>
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
                <div class="col-md-4">
                    <div class="card card-summary-penyaluran">
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold mb-4">SISA ANGGARAN</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <span class="pie"
                                                data-peity='{ "fill": ["#f44236", "#f2f2f2"]}'>{{ round(($sisa / $anggaran) * 100, 2) }},{{ round(($totalAlokasi / $anggaran) * 100, 2) }}</span>
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

        @if (session('user')->id_perusahaan == 1)
            <form method="GET" action="{{ route('data-proker') }}">
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
                                <a href="{{ route('data-proker') }}" class="btn btn-outline-danger">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mb-2">
                                <h4 class="card-title font-weight-bold">Data Alokasi</h4>
                            </div>
                            <div class="ml-auto">
                                @if ($dataProker->count() > 0)
                                    <a href="{{ route('exportProker', request()->query()) }}"
                                        class="font-bold text-muted">
                                        <img src="{{ asset('template/assets/images/icon/excel.png') }}" class="mr-1"
                                            width="18px" alt="icon-excel"> Export
                                        Excel
                                    </a>
                                @endif
                            </div>
                        </div>
                        @if ($dataProker->count() > 0)
                            <div class="table-responsive">
                                <table id="table_proker" class="table table-striped">
                                    <thead class="thead-light font-bold">
                                        <tr>
                                            <th width="50px" class="text-center" nowrap>Proker ID</th>
                                            <th width="300px">Program Kerja</th>
                                            <th width="300px">Pilar & TPB</th>
                                            <th width="150px" class="text-right" nowrap>Anggaran (Rp)</th>
                                            <th class="text-right" width="100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataProker as $data)
                                            <tr>
                                                <td class="text-center">{{ '#' . $data->id_proker }}</td>
                                                <td>
                                                    <h6 class="mb-1 font-bold">
                                                        {{ strtoupper($data->proker) }}
                                                    </h6>
                                                    <p class="mb-0 text-muted">{{ $data->prioritas ?: 'Sosial/Ekonomi' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <h6 class="mb-1 font-bold">{{ $data->pilar }}</h6>
                                                    <p class="mb-0 text-muted">{{ $data->kode_tpb . '. ' . $data->gols }}
                                                    </p>
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($data->anggaran, 0, ',', '.') }}
                                                </td>
                                                <td class="text-right" nowrap>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="#!" class="edit tooltip-trigger" title="Edit"
                                                                data-id="{{ encrypt($data->id_proker) }}"
                                                                data-proker="{{ $data->proker }}"
                                                                data-pilar="{{ $data->pilar }}"
                                                                data-gols="{{ $data->gols }}"
                                                                data-nominal="{{ 'Rp. ' . number_format($data->anggaran, 0, ',', '.') }}"
                                                                data-nominal_asli="{{ $data->anggaran }}"
                                                                data-tahun="{{ $data->tahun }}"
                                                                data-prioritas="{{ $data->prioritas }}"
                                                                data-toggle="modal" data-target=".modal-edit">
                                                                <i class="far fa-edit text-info font-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="#!" class="delete" data-toggle="tooltip"
                                                                title="Hapus" data-id="{{ encrypt($data->id_proker) }}">
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
                                <h5 class="mt-3">Data program kerja tidak ditemukan</h5>
                                <p class="text-muted mb-0">Klik tombol "Search" di kanan atas untuk
                                    mulai pencarian.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <form method="post" action="{{ action('ProkerController@store') }}">
            {{ csrf_field() }}
            <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true"
                style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">Tambah Proker</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Program Kerja <span class="text-danger">*</span></label>
                                <textarea rows="3" class="form-control text-uppercase" maxlength="300" name="proker" required>{{ old('proker') }}</textarea>
                                @error('proker')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Pilar <span class="text-danger">*</span></label>
                                    <select name="pilar" id="pilar" class="form-control" required>
                                        <option value="">-- Pilih Pilar --</option>
                                        @foreach ($dataPilar as $pilar)
                                            <option value="{{ $pilar->nama }}"
                                                {{ old('pilar') == $pilar->nama ? 'selected' : '' }}>
                                                {{ $pilar->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pilar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8">
                                    <label>TPB <span class="text-danger">*</span></label>
                                    <select name="tpb" id="tpb" class="form-control" required>
                                        <option value="">-- Pilih TPB --</option>
                                    </select>
                                    @error('tpb')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Tahun Anggaran <span class="text-danger">*</span></label>
                                    <select name="tahun" class="form-control" required>
                                        <option value="{{ request('tahun', date('Y')) }}">
                                            {{ request('tahun', date('Y')) }}
                                        </option>
                                        @foreach ($dataAnggaran as $da)
                                            <option value="{{ $da->tahun }}"
                                                {{ old('tahun') == $da->tahun ? 'selected' : '' }}>
                                                {{ $da->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tahun')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8">
                                    <label>Anggaran <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" autocomplete="off" name="nominal"
                                        id="nominal" value="{{ old('nominal') }}" required>
                                    <input type="hidden" name="nominalAsli" id="nominalAsli"
                                        value="{{ old('nominalAsli') }}">
                                    @error('nominalAsli')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Prioritas</label>
                                    <select class="form-control" name="prioritas" required>
                                        <option value="">-- Semua Prioritas --</option>
                                        <option value="Pendidikan"
                                            {{ old('prioritas') == 'Pendidikan' ? 'selected' : '' }}>
                                            Pendidikan
                                        </option>
                                        <option value="Lingkungan"
                                            {{ old('prioritas') == 'Lingkungan' ? 'selected' : '' }}>
                                            Lingkungan
                                        </option>
                                        <option value="UMK" {{ old('prioritas') == 'UMK' ? 'selected' : '' }}>
                                            UMK
                                        </option>
                                        <option value="Sosial/Ekonomi"
                                            {{ old('prioritas') == 'Sosial/Ekonomi' ? 'selected' : '' }}>
                                            Sosial/Ekonomi
                                        </option>
                                    </select>
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

        <form method="post" action="{{ action('ProkerController@update') }}">
            {{ csrf_field() }}
            <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold"><b>Edit Proker</b></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="prokerID" id="prokerID">
                            <div class="form-group">
                                <label>Program Kerja <span class="text-danger">*</span></label>
                                <textarea rows="3" class="form-control text-uppercase" maxlength="300" name="proker" id="proker"
                                    required>{{ old('proker') }}</textarea>
                                @error('proker')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Pilar <span class="text-danger">*</span></label>
                                    <select name="pilar" id="pilar_edit" class="form-control" required>
                                        <option value="">-- Pilih Pilar --</option>
                                        @foreach ($dataPilar as $pilar)
                                            <option value="{{ $pilar->nama }}"
                                                {{ old('pilar') == $pilar->nama ? 'selected' : '' }}>
                                                {{ $pilar->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pilar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8">
                                    <label>TPB <span class="text-danger">*</span></label>
                                    <select name="tpb" id="tpb_edit" class="form-control" required>
                                        <option value="">-- Pilih TPB --</option>
                                    </select>
                                    @error('tpb')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Tahun Anggaran <span class="text-danger">*</span></label>
                                    <select name="tahun" id="tahun" class="form-control" required>
                                        <option value="{{ request('tahun', date('Y')) }}">
                                            {{ request('tahun', date('Y')) }}
                                        </option>
                                        @foreach ($dataAnggaran as $da)
                                            <option value="{{ $da->tahun }}"
                                                {{ old('tahun') == $da->tahun ? 'selected' : '' }}>
                                                {{ $da->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tahun')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8">
                                    <label>Anggaran <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" autocomplete="off" name="nominal"
                                        id="nominal_edit" value="{{ old('nominal') }}" required>
                                    <input type="hidden" name="nominalAsli" id="nominalAsli_edit"
                                        value="{{ old('nominalAsli') }}">
                                    @error('nominalAsli')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Prioritas</label>
                                    <select class="form-control" name="prioritas" id="prioritas" required>
                                        <option value="">-- Semua Prioritas --</option>
                                        <option value="Pendidikan"
                                            {{ old('prioritas') == 'Pendidikan' ? 'selected' : '' }}>
                                            Pendidikan
                                        </option>
                                        <option value="Lingkungan"
                                            {{ old('prioritas') == 'Lingkungan' ? 'selected' : '' }}>
                                            Lingkungan
                                        </option>
                                        <option value="UMK" {{ old('prioritas') == 'UMK' ? 'selected' : '' }}>
                                            UMK
                                        </option>
                                        <option value="Sosial/Ekonomi"
                                            {{ old('prioritas') == 'Sosial/Ekonomi' ? 'selected' : '' }}>
                                            Sosial/Ekonomi
                                        </option>
                                    </select>
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
                const table = $('#table_proker').DataTable({
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
                const pilarOld = "{{ old('pilar') }}";
                const tpbOld = "{{ old('tpb') }}";

                $('#pilar').change(function() {
                    const pilar_id = $(this).val();

                    $.ajax({
                        type: 'GET',
                        url: "/proposal/dataTPB/" + encodeURIComponent(pilar_id),
                        success: function(response) {
                            $('#tpb').empty().append(
                                '<option value="">-- Pilih TPB --</option>'
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
            $(document).ready(function() {
                // Fungsi untuk memuat TPB berdasarkan Pilar
                function loadTPB(pilarNama, selectedTPB = '') {
                    if (!pilarNama) {
                        $('#tpb_edit').empty().append('<option value="">-- Pilih TPB --</option>');
                        return;
                    }

                    $.ajax({
                        type: 'GET',
                        url: "/proposal/dataTPB/" + encodeURIComponent(pilarNama),
                        success: function(response) {
                            $('#tpb_edit').empty().append('<option value="">-- Pilih TPB --</option>');

                            $.each(response, function(i, tp) {
                                const isSelected = tp.value === selectedTPB ? 'selected' : '';
                                $('#tpb_edit').append(
                                    `<option value="${tp.value}" ${isSelected}>${tp.label}</option>`
                                );
                            });

                            $('#tpb_edit').prop('disabled', false);
                        },
                        error: function() {
                            toastr.error("Gagal memuat TPB", "Failed", {
                                closeButton: true
                            });
                        }
                    });
                }

                // Event: Klik tombol edit
                $(document).on('click', '.edit', function() {
                    const data = $(this).data();

                    $('#prokerID').val(data.id);
                    $('#proker').val(data.proker);
                    $('#pilar_edit').val(data.pilar);
                    $('#nominal_edit').val(data.nominal);
                    $('#nominalAsli_edit').val(data.nominal_asli);
                    $('#tahun').val(data.tahun);
                    $('#prioritas').val(data.prioritas);

                    // Load TPB setelah ganti pilar
                    loadTPB(data.pilar, data.gols);
                });

                // Event: Ganti pilar manual (misal oleh user)
                $('#pilar_edit').change(function() {
                    const selectedPilar = $(this).val();
                    loadTPB(selectedPilar); // tanpa selectedTPB (user memilih manual)
                });

                // Jika ingin load old value saat halaman reload (misal karena error validasi)
                const pilarOld = "{{ old('pilar') }}";
                const tpbOld = "{{ old('tpb') }}";
                if (pilarOld) {
                    $('#pilar_edit').val(pilarOld);
                    loadTPB(pilarOld, tpbOld);
                }
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
                    text: "Apakah Anda yakin ingin menghapus program kerja ini? Tindakan ini tidak bisa dibatalkan.",
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
                        window.location = "deleteProker/" + data_id;
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
