@extends('layout.master')
@section('title', 'PGN SHARE | List Penyaluran TJSL-YKPP')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold">
                    REKAPITULASI PENYALURAN TJSL
                    <br>
                    <small class="text-muted">Tahun Anggaran {{ $tahun }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">List Penyaluran TJSL-YKPP</li>
                    </ol>
                    <button type="button" class="btn btn-light btn-rounded d-none d-lg-block m-l-15"
                        data-target=".modal-tahun" data-toggle="modal" data-bs-toggle="tooltip" data-placement="top"
                        title="Tahun Anggaran">
                        <i class="icon-wallet text-primary mr-2"></i>{{ $tahun }}
                    </button>
                    @if ($jumlahData > 0)
                        @if (in_array(session('user')->role, ['Admin', 'Payment']))
                            <button type="button" class="btn btn-light btn-rounded d-none d-lg-block m-l-15"
                                data-toggle="modal" data-target=".modal-submit"><i
                                    class="fas fa-paper-plane mr-2 text-success"></i>Submit
                                Selected
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        @if ($jumlahData > 0)
            <div class="card-group">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-5">TOTAL PENYALURAN TJSL</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div class="ml-auto">
                                        <h3 class="counter">
                                            <b class="font-weight-bold">
                                                {{ 'Rp' . number_format($totalPenyaluran, 0, ',', '.') }}
                                            </b>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-5">TOTAL FEE ({{ $fee }})</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div class="ml-auto">
                                        <h3 class="counter">
                                            <b class="font-weight-bold">
                                                {{ 'Rp' . number_format($totalFee, 0, ',', '.') }}
                                            </b>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-5">TOTAL PEMBAYARAN YKPP</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div class="ml-auto">
                                        <h3 class="counter">
                                            <b class="font-weight-bold">
                                                {{ 'Rp' . number_format($totalPembayaran, 0, ',', '.') }}
                                            </b>
                                        </h3>
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
                        @if ($jumlahData > 0)
                            <div class="d-flex">
                                <div>
                                    <h4 class="card-title mb-3">DATA PENYALURAN TJSL</h4>
                                </div>
                                <div class="ml-auto">
                                    @if ($ket == 'All Data')
                                        <a target="_blank" href="{{ route('printPaymentYKPP') }}" class="text-muted"
                                            style="margin-right: 10px">
                                            <i class="fa fa-print text-danger mr-1" style="font-size: 16px"></i>Print
                                        </a>
                                    @elseif($ket == 'Open')
                                        <a target="_blank" href="{{ route('printPaymentYKPPOpen') }}" class="text-muted"
                                            style="margin-right: 10px">
                                            <i class="fa fa-print text-danger mr-1" style="font-size: 16px"></i>Print
                                        </a>
                                    @elseif($ket == 'Verified')
                                        <a target="_blank" href="{{ route('printPaymentYKPPVerified') }}" class="text-muted"
                                            style="margin-right: 10px">
                                            <i class="fa fa-print text-danger mr-1" style="font-size: 16px"></i>Print
                                        </a>
                                    @elseif($ket == 'Submited')
                                        <a target="_blank" href="{{ route('printPaymentYKPPSubmited') }}" class="text-muted"
                                            style="margin-right: 10px">
                                            <i class="fa fa-print text-danger mr-1" style="font-size: 16px"></i>Print
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="example5 table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                <th class="text-center" width="50px">Pilih</th>
                                            @endif
                                            <th class="text-center" width="200px">No Agenda</th>
                                            <th class="text-center" width="300px">Penerima Manfaat</th>
                                            <th class="text-center" width="200px">Wilayah</th>
                                            <th class="text-center" width="300px">Informasi Bank</th>
                                            <th class="text-center" width="100px">Jumlah</th>
                                            <th class="text-center" width="100px">Fee ({{ $fee }})</th>
                                            <th class="text-center" width="100px">Subtotal</th>
                                            <th class="text-center" width="100px">Status</th>
                                            @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                <th class="text-center" width="50px">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataKelayakan as $data)
                                            <tr>
                                                @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                    <td style="text-align:center;">
                                                        <input type="checkbox" class="check"
                                                            data-checkbox="icheckbox_flat-red"
                                                            data-idKelayakan="{{ $data->id_kelayakan }}">
                                                    </td>
                                                @endif
                                                <td nowrap>
                                                    {{ strtoupper($data->no_agenda) }}
                                                </td>
                                                <td>
                                                    <b
                                                        class="font-weight-bold text-uppercase">{{ $data->asal_surat }}</b><br>
                                                    <span class="text-muted">{{ $data->deskripsi }}</span>
                                                </td>
                                                <td>
                                                    <b class="font-weight-bold">{{ $data->provinsi }}</b><br>
                                                    <span class="text-muted">{{ $data->kabupaten }}</span>
                                                </td>
                                                <td>
                                                    <b class="font-weight-bold">{{ $data->nama_bank }}</b><br>
                                                    <span class="text-dark">{{ $data->no_rekening }}</span><br>
                                                    <span class="text-muted">{{ $data->atas_nama }}</span>
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($data->nominal_approved, 0, ',', '.') }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($data->nominal_fee, 0, ',', '.') }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($data->total_ykpp, 0, ',', '.') }}
                                                </td>
                                                <td nowrap>
                                                    @if ($data->status_ykpp == 'Open')
                                                        <span class="badge badge-warning" style="color: black">OPEN</span>
                                                    @elseif($data->status_ykpp == 'Verified')
                                                        <span class="badge badge-info">VERIFIED</span>
                                                    @elseif($data->status_ykpp == 'Submited')
                                                        <span class="badge badge-success">SUBMITED</span>
                                                    @endif
                                                </td>
                                                @if (in_array(session('user')->role, ['Admin', 'Payment']))
                                                    <td class="text-center" nowrap>
                                                        <div class="btn-group">
                                                            <a href="javascript:void(0)" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"><i
                                                                    class="fa fa-gear font-18 text-info"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right"
                                                                style="font-size: 13px">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('detail-kelayakan', encrypt($data->no_agenda)) }}"><i
                                                                        class="icon-info mr-2"></i>View Detail</a>
                                                                @if (in_array($data->status_ykpp, ['Verified', 'Submited']))
                                                                    <a class="dropdown-item editStatus"
                                                                        data-target=".modal-status" data-toggle="modal"
                                                                        kelayakan-id="{{ encrypt($data->id_kelayakan) }}"
                                                                        href="javascript:void(0)"><i
                                                                            class="icon-note mr-2"></i>Update
                                                                        Status</a>
                                                                @endif
                                                                <a style="color: red"
                                                                    class="dropdown-item unchecklistYKPP"
                                                                    kelayakan-id="{{ encrypt($data->id_kelayakan) }}"
                                                                    href="javascript:void(0)"><i
                                                                        class="icon-close mr-2"></i>Unchecklist
                                                                    YKPP</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                <b>Tidak ada data yang ditampilkan</b>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('KelayakanController@updateStatusYKPP') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-status" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold"><i class="fa fa-edit mr-2"></i>Update
                            Status</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="kelayakanID" id="kelayakanID">
                        <div class="form-group mb-0">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control mb-2" name="status">
                                <option></option>
                                <option>Open</option>
                                <option>Verified</option>
                            </select>
                            @if ($errors->has('status'))
                                <small class="text-danger mt-0">Status harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect text-left">
                            <i class="fa fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
                                <option>-- Pilih Tahap --</option>
                                @for ($thn = 1; $thn <= 150; $thn++)
                                    <option>{{ $thn }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tahun <span class="text-danger">*</span></label>
                            <select class="form-control" id="tahunPenyaluran">
                                <option></option>
                                @for ($thn = 2023; $thn <= date('Y'); $thn++)
                                    <option>{{ $thn }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" id="btnApprove" class="btn btn-success btnSubmit waves-effect text-left">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('ReportController@postPaymentYKPPVerifiedYear') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-tahun" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">FILTER DATA</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="keterangan" value="{{ $ket }}">
                        <div class="form-group mb-0">
                            <label>Budget Year <span class="text-danger">*</span></label>
                            <select class="form-control mb-2" name="tahun">
                                <option></option>
                                @for ($thn = 2023; $thn <= date('Y'); $thn++)
                                    <option>{{ $thn }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('tahun'))
                                <small class="text-danger mt-0">Tahun anggaran harus
                                    diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect text-left"><i
                                class="fa fa-search mr-2"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $(document).on('click', '.editStatus', function(e) {
            document.getElementById("kelayakanID").value = $(this).attr('kelayakan-id');
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".pilihTahap").select2({
                width: '100%',
                placeholder: "-- Pilih Tahap --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('#btnApprove').click(function() {
            var penyaluran = $('#penyaluran').val().length;
            var tahun = $('#tahunPenyaluran').val().length;
            var isiPenyaluran = $('#penyaluran').val();
            var isiTahun = $('#tahunPenyaluran').val();

            if (penyaluran == 0 || tahun == 0) {
                toastr.warning('Urutan dan tahun penyaluran harus diisi', 'Warning', {
                    closeButton: true
                });
                return false;
            }

            swal({
                    title: "Warning",
                    text: "Pastikan data yang anda pilih sudah benar",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function() {
                    var id = [];
                    $(':checkbox:checked').each(function(i) {
                        id[i] = $(this).attr('data-idKelayakan');
                    });
                    if (id.length === 0) {
                        swal("Information", "Anda belum memilih data manapun", "info");
                    } else {
                        window.location = "/report/submitYKPP/" + id + "/" + isiPenyaluran + "/" + isiTahun +
                            "";
                    }
                });
        });
    </script>

    <script>
        $('.unchecklistYKPP').click(function() {
            var data_id = $(this).attr('kelayakan-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus proposal ini dari daftar YKPP",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "/report/unchecklistYKPP/" + data_id + "";
                });
        });
    </script>

    <script>
        $('.submitAll').click(function() {
            swal({
                    title: "Anda Yakin?",
                    text: "Akan submit daftar penyaluran TJSL ini ke YKPP",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function() {
                    var id = [];
                    $(':checkbox:checked').each(function(i) {
                        id[i] = $(this).attr('data-idKelayakan');
                    });
                    if (id.length === 0) {
                        swal("Information", "Anda belum memilih data manapun", "info");
                    } else {
                        window.location = "/report/submitYKPP/" + id + "";
                    }
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
