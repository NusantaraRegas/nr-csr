@extends('layout.master')
@section('title', 'NR SHARE | User Management')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold">USER MANAGEMENT</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">User Management</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                            class="btn btn-info d-lg-block m-l-15">Create New
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h4 class="card-title mb-3">LIST USER</h4>
                            </div>
                            <div class="ml-auto">

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataServer" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center" width="10px">ID</th>
                                    <th class="text-center" width="100px">USERNAME</th>
                                    <th class="text-center" width="200px">NAMA</th>
                                    <th class="text-center" width="300px">PERUSAHAAN</th>
                                    <th class="text-center" width="100px">ROLE</th>
                                    <th class="text-center" width="100px">STATUS</th>
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
    <script>
        $(function () {
            $("#dataServer").dataTable({
                processing: true,
                search: {
                    return: true
                },
                serverSide: true,
                ajax: 'indexUser/json',
                columns: [
                    {data: 'id_user', name: 'id_user'},
                    {data: 'username', name: 'username'},
                    {data: 'nama', name: 'nama'},
                    {data: 'perusahaan', name: 'perusahaan'},
                    {data: 'role', name: 'role'},
                    {data: 'status', name: 'status'}
                ]
            });
        });
    </script>
@stop