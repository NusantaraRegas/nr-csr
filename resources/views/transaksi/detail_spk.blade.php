@extends('layout.master')
@section('title', 'NR SHARE | Detail SPK')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase">Detail SPK</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Detail SPK</li>
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
                        <h4 class="m-b-0 text-white text-uppercase">Rincian</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="10px" style="text-align:center;">No</th>
                                        <th width="100px">No Agenda</th>
                                        <th width="150px">Tanggal</th>
                                        <th width="100px">Pengirim</th>
                                        <th width="300px">Dari</th>
                                        <th width="300px">Bantuan Untuk</th>
                                        <th width="100px">Status</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataKelayakan as $data)
                                        <tr>
                                            <td style="text-align:center;">{{ $loop->iteration }}</td>
                                            <td>{{ $data->no_agenda }}</td>
                                            <td class="text-uppercase">{{ date('d-M-Y', strtotime($data->tgl_terima)) }}
                                            </td>
                                            <td>{{ $data->pengirim }}</td>
                                            <td>{{ $data->asal_surat }}</td>
                                            <td>{{ $data->bantuan_untuk }}</td>
                                            <td>
                                                @if ($data->status == 'Draft')
                                                    <span class="btn btn-warning btn-xs" style="color: black">DRAFT
                                                        PROPOSAL</span>
                                                @elseif($data->status == 'Evaluasi')
                                                    <span class="btn btn-success btn-xs">Proposal Sedang Dievaluasi</span>
                                                @elseif($data->status == 'Survei')
                                                    <span class="btn btn-info btn-xs"> Proposal Sedang Disurvei</span>
                                                @elseif($data->status == 'Approved')
                                                    <span class="btn btn-primary btn-xs" style="color: black">Proposal Sudah
                                                        Disetujui</span>
                                                @elseif($data->status == 'Rejected')
                                                    <span class="btn btn-danger btn-xs">PROPOSAL DITOLAK</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (session('user')->role != 1)
                                                    @if ($data->create_by == session('user')->username)
                                                        <a href="{{ route('edit-kelayakan', encrypt($data->no_agenda)) }}"
                                                            data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                            <i class="fa fa-pencil" style="font-size: 18px"></i>
                                                        </a>
                                                        @if ($data->status == 'Draft')
                                                            <a href="#!" data-toggle="tooltip" data-placement="bottom"
                                                                title="Delete" class="delete text-danger"
                                                                kelayakan-id="{{ encrypt($data->no_agenda) }}"><i
                                                                    class="fa fa-trash" style="font-size: 18px"></i></a>
                                                        @endif
                                                    @endif
                                                @elseif(session('user')->role == 1)
                                                    <a href="{{ route('edit-kelayakan', encrypt($data->no_agenda)) }}"
                                                        data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                        <i class="fa fa-pencil" style="font-size: 18px"></i>
                                                    </a>
                                                    <a href="#!" data-toggle="tooltip" data-placement="bottom"
                                                        title="Delete" class="delete text-danger"
                                                        kelayakan-id="{{ encrypt($data->no_agenda) }}"><i
                                                            class="fa fa-trash" style="font-size: 18px"></i></a>
                                                @endif
                                                <a data-toggle="tooltip" data-placement="bottom" title="View"
                                                    href="{{ route('detail-kelayakan', encrypt($data->no_agenda)) }}">
                                                    <i class="fa fa-eye text-info" style="font-size: 18px"></i>
                                                </a>
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
        <!-- ============================================================== -->
        <!-- End PAge Content -->
    </div>
@endsection

@section('footer')

@stop
