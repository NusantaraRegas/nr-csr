@extends('layout.master')
@section('title', 'SHARE | Laporan CSR 517/518')
@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>
    <div class="container-fluid model-huruf-family">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">LAPORAN CSR 517/518</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item active">CSR 517/518</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="m-b-0 text-white text-uppercase">FILTER DATA</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ action('APIController@listPaymentRequestPeriode') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Start Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker-autoclose text-uppercase"
                                                name="tanggal1" value="{{ old('tanggal1') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('tanggal1'))
                                            <small class="text-danger">Start date harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>End Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker-autoclose text-uppercase"
                                                name="tanggal2" value="{{ old('tanggal2') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('tanggal2'))
                                            <small class="text-danger">End Date harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status">
                                            <option>{{ old('status') }}</option>
                                            @foreach ($dataStatus as $status)
                                                <option>{{ $status['status'] }}</option>
                                            @endforeach
                                            <option>ALL PROGRESS</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <small class="text-danger">Status harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-search mr-2"></i>Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-5">PAYMENT REQUEST CSR 517/518</h5>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="50px">Action</th>
                                        <th width="150px">Paid Date</th>
                                        <th width="100px">PR ID</th>
                                        <th width="100px">Status</th>
                                        <th width="600px">Payment Information</th>
                                        <th width="200px">Billing Amount</th>
                                        <th width="200px">Deduction</th>
                                        <th width="200px">Total Amount</th>
                                        <th width="200px">Receiver Information</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataPayment as $data)
                                        <tr>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"><i
                                                            class="fa fa-gear font-18 text-info"></i></a>
                                                    <div class="dropdown-menu" style="font-size: 13px">
                                                        <a class="dropdown-item"
                                                            href="{{ route('logApproval', $data['id']) }}"><i
                                                                class="fa fa-info-circle font-16 text-info mr-2"></i>Log
                                                            Approval</a>
                                                        @if (session('user')->role == '1')
                                                            <a class="dropdown-item edit" href="javascript:void (0)"
                                                                data-id="{{ $data['id'] }}" data-target=".modal-edit"
                                                                data-toggle="modal"><i
                                                                    class="fa fa-pencil text-primary font-16 mr-2"></i>Update</a>
                                                            @if ($data['status'] == 'DRAFT' or $data['status'] == 'REJECTED')
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item delete" id="{{ $data['id'] }}"
                                                                    href="javascript:void(0)"><i
                                                                        class="fa fa-trash text-danger font-16 mr-2"></i>Delete</a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td nowrap>
                                                {{ date('d M Y', strtotime($data['action_date'])) }}
                                            </td>
                                            <td>
                                                {{ $data['id'] }}
                                            </td>
                                            <td>
                                                @if ($data['status'] == 'DRAFT')
                                                    <span
                                                        class="badge badge-warning badge-pill">{{ $data['status'] }}</span>
                                                @elseif($data['status'] == 'IN PROGRESS')
                                                    <span
                                                        class="badge badge-primary badge-pill">{{ $data['status'] }}</span>
                                                @elseif($data['status'] == 'PAID')
                                                    <span
                                                        class="badge badge-success badge-pill">{{ $data['status'] }}</span>
                                                @elseif($data['status'] == 'RELEASED')
                                                    <span
                                                        class="badge badge-success badge-pill">{{ $data['status'] }}</span>
                                                @elseif($data['status'] == 'REJECTED')
                                                    <span
                                                        class="badge badge-danger badge-pill">{{ $data['status'] }}</span>
                                                @elseif($data['status'] == 'READY TO RELEASE')
                                                    <span class="badge badge-info badge-pill">{{ $data['status'] }}</span>
                                                @else
                                                    <span class="badge badge-info badge-pill">{{ $data['status'] }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <b class="text-danger">{{ $data['invoice_num'] }}</b>
                                                <br>
                                                <small
                                                    class="text-muted">{{ date('d M Y', strtotime($data['invoice_date'])) }}</small>
                                                <br>
                                                {{ $data['description_detail'] }}
                                                @if ($data['attribute1'] != '')
                                                    <br>
                                                    <span class="font-bold">{{ $data['attribute2'] }}</span>
                                                    <br>
                                                    {{ $data['attribute3'] }}
                                                    <br>
                                                    <small>{{ $data['attribute4'] }}</small>
                                                @endif
                                            </td>
                                            <td nowrap>Rp. {{ number_format($data['invoice_amount'], 0, ',', '.') }}</td>
                                            <td nowrap>Rp. {{ number_format($data['invoice_refund'], 0, ',', '.') }}</td>
                                            <td nowrap>Rp. {{ number_format($data['invoice_amount_paid'], 0, ',', '.') }}
                                            </td>
                                            <td>{{ $data['supplier_name'] }}</td>
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

    <form method="post" action="{{ action('APIController@updatePaymentRequest') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">UPDATE ATTRIBUTE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>PR Number</label>
                            <input type="text" class="form-control" name="paymentID" id="paymentID" readonly>
                            @if ($errors->has('paymentID'))
                                <small class="text-danger">PR number harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Jenis Proposal</label>
                            <select class="form-control" name="jenis" id="jenis">
                                <option></option>
                                <option>Bulanan</option>
                                <option>Santunan</option>
                                <option>Idul Adha</option>
                                <option>Natal</option>
                                <option>Aspirasi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Sektor Bantuan</label>
                            <select class="form-control" name="sektorBantuan" id="sektorBantuan">
                                <option></option>
                                @foreach ($dataSektor as $sektor)
                                    <option>{{ $sektor->sektor_bantuan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Provinsi</label>
                            <select class="form-control" name="provinsi" id="provinsi">
                                <option></option>
                                @foreach ($dataProvinsi as $provinsi)
                                    <option>{{ ucwords($provinsi->provinsi) }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('provinsi'))
                                <small class="text-danger">Provinsi harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Kabupaten</label>
                            <select class="form-control" name="kabupaten" id="kabupaten">
                                <option></option>
                            </select>
                            @if ($errors->has('nama'))
                                <small class="text-danger">Nama anggota harus diisi</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-check mr-2"></i>Submit
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
        $(document).on('click', '.edit', function(e) {
            document.getElementById("paymentID").value = $(this).attr('data-id');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                var provinsi_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupaten/" + provinsi_id + "",
                    success: function(response) {
                        $('#kabupaten').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        $('.delete').click(function() {
            var id = $(this).attr('id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus Payment Request ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function() {
                    window.location = "/exportPopay/deletePaymentRequest/" + id + "";
                });
        });
    </script>
@stop
