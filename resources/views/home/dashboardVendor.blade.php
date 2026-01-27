@extends('layout.master_vendor')
@section('title', 'NR SHARE | Dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold">DASHBOARD</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ "Selamat Datang, ".$comp }}</h4>
                        <h6 class="card-subtitle mb-5"><i class="fa fa-exclamation-triangle text-danger mr-1"></i>Segera lengkapi profile perusahaan anda untuk menjadi rekanan kami</h6>
                        <h5 class="m-t-30">Kelengkapan Dokumen<span class="pull-right">85%</span></h5>
                        <div class="progress">
                            <div class="progress-bar bg-info progress-bar-striped" style="width: 85%; height:15px;" role="progressbar"> <span class="sr-only">60% Complete</span> </div>
                        </div>
                        <h5 class="m-t-30">Verifikasi<span class="pull-right">45%</span></h5>
                        <div class="progress">
                            <div class="progress-bar bg-success progress-bar-striped" style="width: 45%; height:15px;" role="progressbar"> <span class="sr-only">60% Complete</span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

@stop