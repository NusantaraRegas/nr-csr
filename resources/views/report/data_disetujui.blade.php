@extends('master')
@section('title', 'SHARE | Kelayakan Proposal')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase">Proposal Telah Disetujui</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Proposal Telah Disetujui</li>
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
                        <h4 class="card-title">Data Proposal</h4>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th width="10px" style="text-align:center;">No</th>
                                    <th width="200px">No Agenda</th>
                                    <th width="100px">Pengirim</th>
                                    <th width="200px">Proposal Dari</th>
                                    <th width="200px">Bantuan Untuk</th>
                                    <th width="100px">Nilai Bantuan</th>
                                    <th width="150px">Sektor Bantuan</th>
                                    <th width="150px">Surveyor</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataSurvei as $data)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td><a data-toggle="tooltip" data-placement="bottom" title="Form Evaluasi"
                                               target="_blank"
                                               href="{{ route('form-survei', encrypt($data->no_agenda)) }}">{{ $data->no_agenda }}</a>
                                        </td>
                                        <td>{{ $data->pengirim }}</td>
                                        <td>{{ $data->asal_surat }}</td>
                                        <td>{{ $data->bantuan_untuk }}</td>
                                        <td>{{ number_format($data->nilai_bantuan,0,',','.') }}</td>
                                        <td>{{ $data->sektor_bantuan }}</td>
                                        <td>
                                            <ol class="pull-left">
                                                <li>{{ $data->survei1 }}</li>
                                                <li>{{ $data->survei2 }}</li>
                                            </ol>
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
    <script>
        $('.delete').click(function () {
            var survei_id = $(this).attr('survei-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus survei proposal ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function () {
                    window.location = "delete-survei/" + survei_id + "";
                });
        });

        $('.forward').click(function () {
            var survei_id = $(this).attr('survei-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan meneruskan survei proposal ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function () {
                    window.location = "forward-survei/" + survei_id + "";
                });
        });
    </script>
@stop