@extends('layout.master_vendor')
@section('title', 'PGN SHARE | Input Pekerjaan')

@section('content')
    <div class="pcoded-inner-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">
                                <b>Input Pekerjaan</b>
                            </h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Pekerjaan</a></li>
                            <li class="breadcrumb-item"><a href="#!">Input Pekerjaan</a></li>
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
                                <h5 class="font-weight-bold">Input Pekerjaan</h5>
                            </div>
                            <div class="card-block">
                                <div class="form-group">
                                    <label>Nama Pekerjaan <span class="text-danger">*</span></label>
                                    <input type="text" autofocus class="form-control" name="namaPekerjaan"
                                           value="{{ old('namaPekerjaan') }}">
                                    @if($errors->has('namaPekerjaan'))
                                        <small class="text-danger">Nama pekerjaan harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Tahun Anggaran <span class="text-danger">*</span></label>
                                        <select class="form-control" name="tahun" id="tahun" style="width: 100%">
                                            <option>{{ old('tahun') }}</option>
                                            @for ($thn = 2023; $thn <= date("Y") ; $thn++)
                                                <option>{{ $thn }}</option>
                                            @endfor
                                        </select>
                                        @if($errors->has('tahun'))
                                            <small class="text-danger">Nama anggaran harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Program Kerja <span class="text-danger">*</span></label>
                                        <select class="form-control" name="proker" id="proker" style="width: 100%">
                                            <option></option>
                                        </select>
                                        @if($errors->has('proker'))
                                            <small class="text-danger">Program Kerja harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer float-right">
                                <a href="{{ route('indexPekerjaan') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-success"><i class="feather icon-save"></i>Save</button>
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
        $(document).on('click', '.editPekerjaan', function (e) {
            document.getElementById("pekerjaanID").value = $(this).attr('data-id');
            document.getElementById("tahun2").value = $(this).attr('data-tahun');

            var id = $(this).attr('data-tahun');

            $.ajax({
                type: 'GET',
                url: "/anggaran/getProker/" + id + "",
                success: function (response) {
                    $('#proker2').html(response);
                }
            });

            document.getElementById("proker2").value = $(this).attr('data-prokerID');
        });
    </script>

    <script>
        $('.delete').click(function () {
            var data_id = $(this).attr('data-id');
            var data_nama = $(this).attr('data-nama');
            swal({
                title: "Are You Sure?",
                text: "Akan menghapus " + data_nama + " dalam daftar Vendor",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/master/deleteVendor/" + data_id + "";
                    }
                });

        });
    </script>

    <script>
        $(document).ready(function () {
            $('#tahun').change(function () {
                var id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/anggaran/getProker/" + id + "",
                    success: function (response) {
                        $('#proker').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop
