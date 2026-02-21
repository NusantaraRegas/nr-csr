@extends('layout.master')
@section('title', 'SHARE | Realisasi Proposal')
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
                <h4 class="font-bold">REALISASI PROPOSAL</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item active">Realisasi Proposal</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title">REALISASI PROPOSAL</h5>
                                <h6 class="card-subtitle mb-5">Source: popay.pgn.co.id</h6>
                            </div>
                            <div class="ml-auto">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success"><i
                                            class="fa fa-filter mr-2"></i>Filter</button>
                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" data-target=".modal-cariBulan" data-toggle="modal"
                                            href="#!">Monthly</a>
                                        <a class="dropdown-item" data-target=".modal-cari" data-toggle="modal"
                                            href="#!">Custom Range</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                            href="{{ route('listPaymentRequestProposal') }}">Refresh</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="50px">Action</th>
                                        <th width="150px">Date</th>
                                        <th width="100px">PR ID</th>
                                        <th width="100px">Status</th>
                                        <th width="400px">Payment Information</th>
                                        <th width="200px">Type</th>
                                        <th width="200px">Sector</th>
                                        <th width="200px">Region</th>
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
                                                        <a class="dropdown-item" href="#!"><i
                                                                class="fa fa-info-circle text-info font-18 text-info mr-2"></i>View
                                                            Detail</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('logApproval', $data['id']) }}"><i
                                                                class="fa fa-list font-16 text-success mr-2"></i>View Log
                                                            Approval</a>
                                                        @if (session('user')->role == '1' or session('user')->role == '6')
                                                            <a class="dropdown-item"
                                                                href="{{ route('viewPaymentRequest', $data['id']) }}"><i
                                                                    class="fa fa-pencil text-primary font-18 mr-2"></i>Next
                                                                Update</a>
                                                            @if ($data['status'] == 'DRAFT' or $data['status'] == 'REJECTED')
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item delete" id="{{ $data['id'] }}"
                                                                    href="javascript:void(0)"><i
                                                                        class="fa fa-trash text-danger font-18 mr-2"></i>Delete</a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td nowrap>
                                                {{ date('d M Y', strtotime($data['invoice_date'])) }}
                                            </td>
                                            <td>{{ $data['id'] }}</td>
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
                                            </td>
                                            <td>{{ $data['attribute1'] }}</td>
                                            <td>{{ $data['attribute2'] }}</td>
                                            <td>{{ $data['attribute3'] }}<br><small
                                                    class="text-muted">{{ $data['attribute4'] }}</small></td>
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
@endsection

@section('footer')
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
                    submitDelete("/exportPopay/deletePaymentRequest/" + id + "");
                });
        });
    </script>
@stop
