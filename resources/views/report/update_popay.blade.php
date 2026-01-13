<?php
function kekata($x)
{
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x < 12) {
        $temp = " " . $angka[$x];
    } else if ($x < 20) {
        $temp = kekata($x - 10) . " belas";
    } else if ($x < 100) {
        $temp = kekata($x / 10) . " puluh" . kekata($x % 10);
    } else if ($x < 200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x < 1000) {
        $temp = kekata($x / 100) . " ratus" . kekata($x % 100);
    } else if ($x < 2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x < 1000000) {
        $temp = kekata($x / 1000) . " ribu" . kekata($x % 1000);
    } else if ($x < 1000000000) {
        $temp = kekata($x / 1000000) . " juta" . kekata($x % 1000000);
    } else if ($x < 1000000000000) {
        $temp = kekata($x / 1000000000) . " milyar" . kekata(fmod($x, 1000000000));
    } else if ($x < 1000000000000000) {
        $temp = kekata($x / 1000000000000) . " trilyun" . kekata(fmod($x, 1000000000000));
    }
    return $temp;
}

function hurufTanggal($x, $style = 4)
{
    if ($x < 0) {
        $hasil1 = "minus " . trim(kekata($x));
    } else {
        $hasil1 = trim(kekata($x));
    }
    return ucwords($hasil1);
}


function terbilang($x, $style = 4)
{
    if ($x < 0) {
        $hasil = "minus " . trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }
    return $hasil;
}

?>

@extends('layout.master')
@section('title', 'NR SHARE | Update Payment Request')
@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-uppercase font-bold">UPDATE PAYMENT REQUEST<br><small class="text-danger">{{ $dataPembayaran->no_agenda }}</small></h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Payment Request</li>
                        <li class="breadcrumb-item active">Next Update</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">HEADER
                            <button type="button" data-toggle="modal" data-target=".modalDetailAccount"
                                    class="btn btn-sm btn-info pull-right">Edit Header
                            </button>
                        </h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped m-b-0" width="10%">
                            <tbody>
                            <tr>
                                <th colspan="2" class="pt-2 pb-2" width="250px" style="background-color: lightgoldenrodyellow">
                                    GENERAL INFORMATION
                                </th>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="250px">
                                    PR Number
                                </th>
                                <td class="pt-2 pb-2 text-uppercase">{{ $data['id'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2">
                                    Rev ID
                                </th>
                                <td class="pt-2 pb-2 text-uppercase">{{ $data['rev_id'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Maker
                                </th>
                                <td class="pt-2 pb-2">{{ $data['user_name'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Organization
                                </th>
                                <td class="pt-2 pb-2">{{ $data['org_name'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Division
                                </th>
                                <td class="pt-2 pb-2">{{ $data['div_name'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Payment Category
                                </th>
                                <td class="pt-2 pb-2">{{ $data['category'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Payment Type
                                </th>
                                <td class="pt-2 pb-2">{{ $data['payment_type'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Budget Year
                                </th>
                                <td class="pt-2 pb-2">
                                    {{ $data['bugdet_year'] }}
                                </td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Description (Bank)
                                </th>
                                <td class="pt-2 pb-2">{{ $data['description_bank'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Description
                                </th>
                                <td class="pt-2 pb-2">{{ $data['description_detail'] }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="pt-2 pb-2" width="250px" style="background-color: lightgoldenrodyellow">
                                    PAYMENT INVOICE
                                </th>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="250px">
                                    Invoice Number
                                </th>
                                <td class="pt-2 pb-2 text-uppercase">{{ $data['invoice_num'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2">
                                    Invoice Date
                                </th>
                                <td class="pt-2 pb-2">{{ date('d F Y', strtotime($data['invoice_date'])) }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Due Date
                                </th>
                                <td class="pt-2 pb-2">{{ date('d F Y', strtotime($data['invoice_due_date'])) }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Billing Amount
                                </th>
                                <td class="pt-2 pb-2">
                                    Rp. {{ number_format($data['invoice_amount'],0,',','.') }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Deduction
                                </th>
                                <td class="pt-2 pb-2">
                                    Rp. {{ number_format($data['invoice_refund'],0,',','.') }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Total Amount
                                </th>
                                <td class="pt-2 pb-2">
                                    Rp. {{ number_format($data['invoice_amount_paid'],0,',','.') }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    In Word
                                </th>
                                <td class="pt-2 pb-2 text-capitalize">{{ terbilang($data['invoice_amount_paid']) }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="pt-2 pb-2" width="250px" style="background-color: lightgoldenrodyellow">
                                    RECEIVER INFORMATION
                                </th>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="250px">
                                    Receiver Type
                                </th>
                                <td class="pt-2 pb-2">{{ $data['supplier_type'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2">
                                    Receiver Name
                                </th>
                                <td class="pt-2 pb-2">{{ $data['supplier_name'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Receiver Number
                                </th>
                                <td class="pt-2 pb-2">{{ $data['supplier_number'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Receiver Site Name
                                </th>
                                <td class="pt-2 pb-2">
                                    {{ $data['supplier_site_name'] }}
                                </td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Receiver Address
                                </th>
                                <td class="pt-2 pb-2">
                                    {{ $data['supplier_site_address'] }}
                                </td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Receiver Email
                                </th>
                                <td class="pt-2 pb-2">{{ $data['supplier_email'] }}</td>
                            </tr>
                            <tr>
                                <th class="pt-2 pb-2" width="200px">
                                    Number Tax ID
                                </th>
                                <td class="pt-2 pb-2">{{ $data['supplier_npwp'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">DETAIL ACCOUNT
                            <a href="{{ route('subProposal', encrypt($data['id'])) }}" class="btn btn-sm btn-info pull-right">Add Detail Account
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover">
                                <thead style="background-color: #FFCCBC;">
                                <tr>
                                    <th width="150px">TYPE</th>
                                    <th width="200px">COA ORGANISASI</th>
                                    <th width="200px">COA AKUN</th>
                                    <th width="200px">COA PUSAT BIAYA</th>
                                    <th width="200px">COA SEGMEN BISNIS</th>
                                    <th width="200px">COA ELEMEN BIAYA</th>
                                    <th width="100px">COA INTERCOMPANY</th>
                                    <th width="100px">COA WILAYAH</th>
                                    <th width="100px">DEBIT</th>
                                    <th width="100px">KREDIT</th>
                                    <th width="100px">DESCRIPTION</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">RECEIVER BANK INFORMATION
                            <button type="button" data-toggle="modal" data-target=".modalDetailAccount"
                                    class="btn btn-sm btn-info pull-right">Add Payment Receiver
                            </button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover">
                                <thead style="background-color: #FFCCBC;">
                                <tr>
                                    <th width="150px">ACCOUNT NO</th>
                                    <th width="200px">ACCOUNT NAME</th>
                                    <th width="200px">BANK NAME</th>
                                    <th width="200px">BANK CITY</th>
                                    <th width="200px">BANK BRANCH</th>
                                    <th width="200px">EMAIL</th>
                                    <th width="100px">CURRENCY</th>
                                    <th width="150px">AMOUNT</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataReceiver as $r)
                                        <tr>
                                            <td>{{ $r['ben_bank_account'] }}</td>
                                            <td>{{ $r['ben_name'] }}</td>
                                            <td>{{ $r['ben_bank_name'] }}</td>
                                            <td>{{ $r['ben_bank_address2'] }}</td>
                                            <td>{{ $r['ben_bank_address1'] }}</td>
                                            <td>{{ $r['ben_email'] }}</td>
                                            <td>{{ $r['receive_curr'] }}</td>
                                            <td>{{ number_format($r['receive_amount'],0,',','.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">DOCUMENT ATTACHMENT
                            <button type="button" data-toggle="modal" data-target=".modal-lampiran"
                                    class="btn btn-sm btn-info pull-right">Add Document
                            </button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover">
                                <thead style="background-color: #FFCCBC;">
                                <tr>
                                    <th>DOC TYPE</th>
                                    <th>DOC NAME</th>
                                    <th>DESCRIPTION</th>
                                    <th>APPLICATION</th>
                                    <th>URL</th>
                                </tr>
                                </thead>
                                <tbody>

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

@stop