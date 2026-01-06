@extends('layout.master_vendor')
@section('title', 'PGN SHARE | SPPH')

@section('content')
    <div class="pcoded-inner-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">
                                <b>SPPH {{ $tahun }}</b>
                            </h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Procurement Documents</a></li>
                            <li class="breadcrumb-item"><a href="#!">SPPH</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-body">
            <div class="page-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="font-weight-bold">SPPH List</h5>
                                <div class="card-header-right">

                                </div>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table class="example1 table table-striped table-hover table-bordered"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th width="10px" style="text-align:center;">No</th>
                                            <th width="100px" style="text-align:center;">Nomor</th>
                                            <th width="200px" style="text-align:center;">Vendor</th>
                                            <th width="300px" style="text-align:center;">Nama Proyek</th>
                                            <th width="400px" style="text-align:center;">Ringkasan Pekerjaan</th>
                                            <th width="100px" style="text-align:center;">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($dataSPPH as $data)
                                            <tr>
                                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                                <td nowrap>
                                                    <h6 class="mb-1 font-weight-bold">
                                                        <a target="_blank"
                                                           href="/attachment/{{ $data->file_spph }}">{{ strtoupper($data->nomor) }}</a>
                                                    </h6>
                                                    <h6 class="mb-1">{{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($data->tanggal))) }}</h6>
                                                </td>
                                                <td>
                                                    <b class="text-dark">{{ $data->nama_perusahaan }}</b>
                                                </td>
                                                <td>
                                                    <b class="text-dark">{{ $data->nama_pekerjaan }}</b>
                                                </td>
                                                <td>
                                                    <span class="mb-1">{{ $data->ringkasan }}</span>
                                                    <a target="_blank" class="font-weight-bold"
                                                       href="/attachment/{{ $data->kak }}">
                                                        <br>
                                                        <i class="feather icon-download mr-1"></i>Download KAK
                                                    </a>
                                                </td>
                                                <td nowrap>
                                                    @if($data->status == 'DRAFT')
                                                        <span class="badge badge-secondary">DRAFT</span>
                                                    @elseif($data->status == 'Submitted')
                                                        <span class="badge badge-warning f-12 text-dark">Waiting for response</span>
                                                    @elseif($data->status == 'Accepted')
                                                        <span class="badge badge-success f-12">Responded</span>
                                                    @elseif($data->status == 'Declined')
                                                        <span class="badge badge-danger f-12">Declined</span>
                                                    @endif
                                                    @if($data->catatan != "")
                                                        <br>
                                                        <span class="text-muted">{{ $data->catatan }}</span>
                                                    @endif
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
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop
