@extends('layout.master')
@section('title', 'SHARE | Export Realisasi Proposal')
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
                <h4 class="text-themecolor text-uppercase">Export Realisasi Proposal</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Export Realisasi Proposal</li>
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
                                <form method="post" action="{{ action('LaporanController@cariPeriodeRealisasi') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label>Element Biaya <span class="text-danger">*</span></label>
                                        <select class="form-control" name="eb">
                                            <option></option>
                                            <option>517</option>
                                            <option>518</option>
                                        </select>
                                        @if($errors->has('eb'))
                                            <small class="text-danger">Element biaya harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Tahun <span class="text-danger">*</span></label>
                                        <select class="form-control" name="tahun">
                                            <option></option>
                                            <option>2018</option>
                                            <option>2019</option>
                                            <option>2020</option>
                                            <option>2021</option>
                                            <option>2022</option>
                                            <option>2023</option>
                                        </select>
                                        @if($errors->has('tahun'))
                                            <small class="text-danger">Tahun harus diisi</small>
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