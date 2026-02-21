@extends('layout.master')
@section('title', 'SHARE | Export Sub Proposal')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold">EXPORT DETAIL ACCOUNT <small>Sub Proposal</small></h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item">Realisasi Proposal</li>
                        <li class="breadcrumb-item active">Export Detail Account</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if($total > $nilaiApproved)
                    <div class="alert alert-secondary">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h3 class="text-danger"><i class="fa fa-exclamation-triangle"></i> Warning</h3>
                        <span class="text-dark">Mohon periksa
                        kembali data yang sudah diinput, nominal sub proposal melebihi nilai permohonan bantuan.</span>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-uppercase font-bold">{{ $dataKelayakan->asal_surat }}</h3>
                                <h5 class="font-light m-t-0">Bantuan Hewan Qurban</h5></div>
                            <div class="col-6 align-self-center display-6 text-right">
                                <h2 class="text-success font-bold">
                                    Rp. {{ number_format($nilaiApproved,0,',','.') }}</h2></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">DAFTAR SUB PROPOSAL
                            <button type="button" class="btn btn-rounded btn-info btn-sm float-right exportDetail"
                                    data-target=".modal-export" data-toggle="modal">
                                <i class="fa fa-send mr-2"></i>Export Detail Account
                            </button>
                        </h4>
                        <h6 class="card-subtitle text-danger mb-5">{{ $noAgenda }}</h6>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                <tr>
                                    <th class="text-center p-b-20" rowspan="3" width="20px">No</th>
                                    <th class="text-center p-b-20" rowspan="3" width="150px">Sub Agenda</th>
                                    <th class="text-center p-b-20" rowspan="3" width="200px">Penerima</th>
                                    <th class="text-center p-b-20" rowspan="3" width="200px">Wilayah</th>
                                    <th class="text-center" colspan="2" width="200px">Hewan Qurban</th>
                                    <th class="text-center p-b-20" rowspan="2" width="150px">Total</th>
                                    <th class="text-center p-b-20" rowspan="2" width="150px">Fee</th>
                                    <th class="text-center p-b-20" rowspan="2" width="150px">PPN</th>
                                    <th class="text-center p-b-20" rowspan="2" width="150px">Sub Total</th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="text-center" width="100px">Kambing</th>
                                    <th rowspan="2" class="text-center" width="100px">Sapi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataSubProposal as $data)
                                    <tr>
                                        <td class="m-l-10" style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td class="m-l-10">
                                            {{ $data->no_sub_agenda }}
                                        </td>
                                        <td class="m-l-10">
                                            <span class="font-bold text-info">{{ $data->nama_lembaga }}</span><br>
                                            <small class="text-muted">{{ $data->nama_ketua }}</small>
                                        </td>
                                        <td class="m-l-10">
                                            <span class="font-bold text-info">{{ $data->provinsi }}</span><br>
                                            <small class="text-muted">{{ $data->kabupaten }}</small>
                                        </td>
                                        <td class="text-center">
                                            {{ $data->kambing }}
                                        </td>
                                        <td class="text-center">
                                            {{ $data->sapi }}
                                        </td>
                                        <td class="text-right p-r-10">
                                            {{ number_format($data->total,0,',','.') }}
                                        </td>
                                        <td class="text-right p-r-10">
                                            {{ number_format($data->fee,0,',','.') }}
                                        </td>
                                        <td class="text-right p-r-10">
                                            {{ number_format($data->ppn,0,',','.') }}
                                        </td>
                                        <td class="text-right p-r-10">
                                            {{ number_format($data->subtotal,0,',','.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <thead>
                                <tr>
                                    <th colspan="10" width="150px" class="font-bold text-right p-r-10">
                                        {{ number_format($total,0,',','.') }}
                                    </th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('APIController@storeDetailAccountIdulAdha') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-export" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">EXPORT DETAIL ACCOUNT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PR Number</label>
                                    <input type="text" class="form-control" name="prID" id="prID"
                                           value="{{ $PRNumber }}" readonly>
                                    @if($errors->has('prID'))
                                        <small class="text-danger">PR Number harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>COA Account <span class="text-danger">*</span></label>
                                    <select class="form-control" name="coaAccount" id="coaAccount"
                                            style="width: 100%">
                                        <option value=""></option>
                                        <option value="90400">90400 - BIAYA DISTRIBUSI</option>
                                        <option value="90500">90500 - BIAYA TRANSMISI</option>
                                        <option value="90600">90600 - BEBAN ADMINISTRASI DAN UMUM</option>
                                    </select>
                                    @if($errors->has('coaAccount'))
                                        <small class="text-danger">COA Account harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>COA Elemen Biaya <span class="text-danger">*</span></label>
                                    <select class="form-control" name="coaElemenBiaya" id="coaElemenBiaya"
                                            style="width: 100%">
                                        <option value=""></option>
                                        <option value="517">517 - TANGGUNG JAWAB SOSIAL DAN LINGKUNGAN</option>
                                        <option value="518">518 - PROGRAM BINA LINGKUNGAN</option>
                                    </select>
                                    @if($errors->has('budget'))
                                        <small class="text-danger">Budget Year harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PPN <span class="text-danger">*</span></label>
                                    <select class="form-control" name="ppn" id="ppn"
                                            style="width: 100%">
                                        <option value="" disabled selected>Select PPN</option>
                                        <option value="include">Ada PPN</option>
                                        <option value="exclude">Tidak Ada PPN</option>
                                    </select>
                                    @if($errors->has('ppn'))
                                        <small class="text-danger">PPN harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>PPN Code <span class="text-danger">*</span></label>
                                    <select class="form-control" name="ppnCode" id="ppnCode">
                                        <option value="" taxRate="" disabled selected>Select PPN Code</option>
                                    </select>
                                    <input type="hidden" class="form-control" name="taxRate" id="taxRate">
                                    @if($errors->has('ppnCode'))
                                        <small class="text-danger">PPN Code harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>PPN Put <span class="text-danger">*</span></label>
                                    <select class="form-control" name="ppnPut" id="ppnPut"
                                            style="width: 100%">
                                        <option value="" disabled selected>Select PPN Put</option>
                                    </select>
                                    @if($errors->has('ppnPut'))
                                        <small class="text-danger">PPN Put harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Tax Code <span class="text-danger">*</span></label>
                                    <select class="form-control" name="taxCode" id="taxCode"
                                            style="width: 100%">
                                        <option value="" disabled selected>Select Tax Code</option>
                                    </select>
                                    @if($errors->has('taxCode'))
                                        <small class="text-danger">Tax Code harus diisi</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left">Submit
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            $('#ppn').change(function () {
                var id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/exportPopay/dataTaxCode/" + id + "",
                    success: function (response) {
                        $('#ppnCode').html(response);
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: "/exportPopay/dataTaxPut/" + id + "",
                    success: function (response) {
                        $('#ppnPut').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        $(document).ready(function () {
            $('#ppnPut').change(function () {
                var id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/exportPopay/dataTaxGroup/" + id + "",
                    success: function (response) {
                        $('#taxCode').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        $('#ppnCode').on('change', function () {
            var rate = $('#ppnCode option:selected').attr('taxRate');
            $('#taxRate').val(rate);
        });
    </script>

    <script>
        $(document).on('click', '.edit', function (e) {
            x
            document.getElementById("lembagaID").value = $(this).attr('data-id');
            document.getElementById("namaLembaga").value = $(this).attr('data-nama');
            document.getElementById("alamat").value = $(this).attr('data-alamat');
            document.getElementById("ketua").value = $(this).attr('data-ketua');
            document.getElementById("noTelp").value = $(this).attr('data-telp');
        });
    </script>

    <script>
        $('.delete').click(function () {
            var data_id = $(this).attr('data-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus data ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function () {
                    submitDelete("/proposal/deleteSubProposal/" + data_id + "");
                });
        });

        @if (count($errors) > 0)
        toastr.warning('Data yang diisi tidak lengkap', 'Warning', {closeButton: true});
        @endif

    </script>
@stop