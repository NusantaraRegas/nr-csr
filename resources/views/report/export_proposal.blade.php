@extends('layout.master')
@section('title', 'SHARE | Export Proposal')
<?php
$tanggalMenit = date("d-M-Y H:i:s");
$tanggal = date("d-M-Y");
?>
@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase">Export Proposal</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Export Proposal</li>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white">Cari Periode Proposal</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-md-4">
                                <form method="post" action="{{ action('LaporanController@cariPeriode') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label>Tanggal Awal <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text"
                                                   class="text-uppercase form-control datepicker-autoclose2" name="tanggal1">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                        @if($errors->has('tanggal1'))
                                            <small class="text-danger">Tanggal awal harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Akhir <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text"
                                                   class="text-uppercase form-control datepicker-autoclose2" name="tanggal2">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                        @if($errors->has('tanggal2'))
                                            <small class="text-danger">Tanggal akhir harus diisi</small>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary">Export Data</button>
                                </form>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
    </div>
@endsection

@section('footer')

@stop