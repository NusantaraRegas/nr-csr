@extends('layout.master')
@section('title', 'SHARE | Maker Popay')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase">Maker Popay</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">Maker Popay</li>
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
                    <div class="card-body">
                        <h4 class="card-title mb-5">Data Maker Popay</h4>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="50px">No</th>
                                    <th width="300px">Username</th>
                                    <th width="300px">Email</th>
                                    <th width="100px">Role</th>
                                    <th width="100px">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataMaker as $data)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td>{{ $data['username'] }}</td>
                                        <td>{{ $data['email'] }}</td>
                                        <td>{{ $data['role'] }}</td>
                                        <td>
                                            @if($data['status'] == 'Active')
                                                <span class="badge badge-success">{{ $data['status'] }}</span>
                                            @elseif($data['status'] == 'Non Active')
                                                <span class="badge badge-danger">{{ $data['status'] }}</span>
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
        <!-- ============================================================== -->
        <!-- End PAge Content -->
    </div>

@endsection

@section('footer')

@stop