@extends('layout.master')
@section('title', 'SHARE | Sub Proposal Idul Adha')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase font-weight-bold">SUB PROPOSAL IDUL ADHA</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item">Proposal</li>
                        <li class="breadcrumb-item active">Sub Proposal Idul Adha</li>
                    </ol>
                    <a href="{{ route('inputSubProposal', encrypt($noAgenda)) }}"
                       class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle mr-2"></i> Input
                        Proposal</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if($total > $nilaiApproved)
                    <div class="alert alert-secondary">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h3 class="text-danger"><i class="fa fa-exclamation-triangle"></i> Warning</h3>
                        <span class="text-dark">Mohon periksa
                        kembali data yang sudah diinput, nominal sub proposal melebihi nilai permohonan bantuan.</span>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-uppercase font-bold">{{ $dataKelayakan->asal_surat }}</h3>
                                <h5 class="font-light m-t-0">Bantuan Hewan Qurban</h5></div>
                            <div class="col-6 align-self-center display-6 text-right">
                                <h2 class="text-success font-bold">
                                    Rp. {{ number_format($nilaiApproved,0,',','.') }}</h2></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">DAFTAR SUB PROPOSAL
                            <a href="{{ route('exportSubProposal', encrypt($noAgenda)) }}" class="btn btn-rounded btn-outline-success btn-sm float-right">
                                <i class="fa fa-file-text mr-2"></i>Download
                            </a>
                        </h4>
                        <h6 class="card-subtitle text-danger mb-5">{{ $noAgenda }}</h6>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                <tr>
                                    <th class="text-center p-b-20" rowspan="3" width="30px">No</th>
                                    <th class="text-center p-b-20" rowspan="3" width="150px">Sub Agenda</th>
                                    <th class="text-center p-b-20" rowspan="3" width="200px">Penerima</th>
                                    <th class="text-center p-b-20" rowspan="3" width="200px">Wilayah</th>
                                    <th class="text-center" colspan="2" width="200px">Hewan Qurban</th>
                                    <th class="text-center p-b-20" rowspan="3" width="150px">Total</th>
                                    <th class="text-center p-b-20" rowspan="3" width="150px">Fee</th>
                                    <th class="text-center p-b-20" rowspan="3" width="150px">PPN</th>
                                    <th class="text-center p-b-20" rowspan="3" width="150px">Sub Total</th>
                                    <th class="text-center p-b-20" rowspan="3" width="50px">Actions</th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="text-center" width="100px">Kambing</th>
                                    <th rowspan="2" class="text-center" width="100px">Sapi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataSubProposal as $data)
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td class="m-l-10">
                                            {{ $data->no_sub_agenda }}
                                        </td>
                                        <td class="m-l-10">
                                            <span class="font-bold text-info">{{ $data->nama_lembaga }}</span><br>
                                            <small class="text-muted">{{ $data->nama_ketua }}</small>
                                        </td>
                                        <td class="m-l-10">
                                            <span class="font-bold text-info">{{ $data->provinsi }}</span><br>
                                            <small class="text-muted">{{ $data->kabupaten }}</small>
                                        </td>
                                        <td class="text-center">
                                            {{ $data->kambing }}
                                        </td>
                                        <td class="text-center">
                                            {{ $data->sapi }}
                                        </td>
                                        <td class="text-right p-r-10">
                                            {{ number_format($data->total,0,',','.') }}
                                        </td>
                                        <td class="text-right p-r-10">
                                            {{ number_format($data->fee,0,',','.') }}
                                        </td>
                                        <td class="text-right p-r-10">
                                            {{ number_format($data->ppn,0,',','.') }}
                                        </td>
                                        <td class="text-right p-r-10">
                                            {{ number_format($data->subtotal,0,',','.') }}
                                        </td>
                                        <td nowrap class="text-center">
                                            <a data-toggle="tooltip" data-placement="bottom"
                                               title="Edit" href="{{ route('ubahSubProposal', encrypt($data->id_sub_proposal)) }}">
                                                <i class="fa fa-pencil" style="font-size: 18px"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="delete text-danger"
                                               data-toggle="tooltip" data-placement="bottom" title="Delete"
                                               data-id="{{ encrypt($data->id_sub_proposal) }}"><i class="fa fa-trash"
                                                                                                  style="font-size: 18px"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <thead>
                                <tr>
                                    <th colspan="10" width="150px" class="font-bold text-right p-r-10">
                                        Rp. {{ number_format($total,0,',','.') }}
                                    </th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
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
        $(document).on('click', '.edit', function (e) {
            x
            document.getElementById("lembagaID").value = $(this).attr('data-id');
            document.getElementById("namaLembaga").value = $(this).attr('data-nama');
            document.getElementById("alamat").value = $(this).attr('data-alamat');
            document.getElementById("ketua").value = $(this).attr('data-ketua');
            document.getElementById("noTelp").value = $(this).attr('data-telp');
        });
    </script>

    <script>
        $('.delete').click(function () {
            var data_id = $(this).attr('data-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus data ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function () {
                    submitDelete("/proposal/deleteSubProposal/" + data_id + "");
                });
        });

        @if (count($errors) > 0)
        toastr.warning('Data yang diisi tidak lengkap', 'Warning', {closeButton: true});
        @endif

    </script>
@stop