@extends('layout.master')
@section('title', 'SHARE | tasklist Dokumen Legal')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase">Tasklist Dokumen Legal</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Tasklist Dokumen Legal</li>
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
                        <h4 class="card-title">BAST</h4>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th width="10px" style="text-align:center;">No</th>
                                    <th width="150px">No Agenda</th>
                                    <th width="100px">Sektor Bantuan</th>
                                    <th width="200px">Proposal Dari</th>
                                    <th width="250px">Bantuan Untuk</th>
                                    <th width="100px">Status</th>
                                    <th width="100px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataTaskBAST as $data)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td>{{ $data->no_agenda }}</td>
                                        <td>{{ $data->sektor_bantuan }}</td>
                                        <td>{{ $data->proposal_dari }}</td>
                                        <td>{{ $data->bantuan_untuk }}</td>
                                        <td>
                                            @if($data->status == 'Submited')
                                                <span class="badge badge-warning"
                                                      style="color: black">Menunggu verifikasi Legal</span>
                                            @elseif($data->status == 'Approved')
                                                <span class="badge badge-success">Approved</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('ubah-bast-dana', encrypt($data->no_agenda)) }}"><i class="icon-pencil"></i>&nbsp;&nbsp;Edit</a>
                                                    <a class="dropdown-item approve" data-no="{{ encrypt($data->no_agenda) }}" href="javascript:void(0)"><i class="icon-check"></i>&nbsp;&nbsp;Verifikasi</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" target="_blank" href="{{ route('form-BASTDana', $data->id_kelayakan) }}"><i class="icon-doc"></i>&nbsp;&nbsp;Form BAST</a>
                                                </div>
                                            </div>
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

@endsection

@section('footer')
    <script>
        function approveKadep() {
            var nilai = 'Untuk ditindaklanjuti sesuai peraturan yang berlaku';
            if ($('.approveKadep').is(":checked")) {
                document.getElementById("komentarKadep").value = nilai;
            }
        }

        function revisiKadep() {
            var nilai = 'Untuk dapat direvisi';
            if ($('.revisiKadep').is(":checked")) {
                document.getElementById("komentarKadep").value = nilai;
            }
        }

        function bukalampiran() {
            var nilai = 'Mohon maaf proposal tidak dapat dibantu';
            if ($('.bukalampiran').is(":checked")) {
                document.getElementById("komentarKadiv").value = nilai;
            }
        }

        function bukalampiran2() {
            var nilai = 'Untuk dapat diproses sesuai prosedur';
            if ($('.bukalampiran2').is(":checked")) {
                document.getElementById("komentarKadiv").value = nilai;
            }
        }
    </script>

    <script>
        $('.approve').click(function () {
            var no_agenda = $(this).attr('data-no');
            swal({
                    title: "Yakin?",
                    text: "Anda akan verifikasi BAST ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-info',
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function () {
                    window.location = "/tasklistLegal/approveBAST/" + no_agenda + "";
                });
        });

        @if (count($errors) > 0)
        swal("Peringatan", "Komentar yang diisi belum lengkap", "warning");
        @endif
    </script>
@stop