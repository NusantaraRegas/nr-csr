@extends('layout.master_vendor')
@section('title', 'PGN SHARE | Project List')

@section('content')
    <div class="pcoded-inner-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">
                                <b>Project List in Budget {{ $tahun }}</b>
                            </h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Project List</a></li>
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
                                <h5 class="font-weight-bold">Project List</h5>
                                <div class="card-header-right">
                                    <a href="#!" class="btn text-muted font-weight-bold mr-0"
                                       data-toggle="modal" data-target="#modalInput">
                                        <i class="feather icon-plus mr-1"></i>Create New
                                    </a>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table class="example1 table table-striped table-hover table-bordered"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th width="10px" style="text-align:center;">ID</th>
                                            <th width="300px" style="text-align:center;">Nama Proyek</th>
                                            <th width="400px" style="text-align:center;">Ringkasan Pekerjaan</th>
                                            <th width="150px" style="text-align:center;">Perkiraan Biaya (Rp)</th>
                                            <th width="100px" style="text-align:center;">Status</th>
                                            <th width="50px" style="text-align:center;">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($dataPekerjaan as $data)
                                            <tr>
                                                <td style="text-align:center;">{{ $data->pekerjaan_id }}</td>
                                                <td>
                                                    <b class="text-dark">{{ $data->nama_pekerjaan }}</b>
                                                    <br>
                                                    <span>{{ $data->proker }}</span>
                                                </td>
                                                <td>
                                                    <span class="mb-1">{{ $data->ringkasan }}</span>
                                                    <a target="_blank" class="font-weight-bold"
                                                       href="/attachment/{{ $data->kak }}">
                                                        <br>
                                                       <i class="feather icon-download mr-1"></i>Download KAK
                                                    </a>
                                                </td>
                                                <td class="text-right">
                                                    <span class="font-weight-bold">{{ number_format($data->nilai_perkiraan,0,',','.') }}</span>
                                                </td>
                                                <td nowrap>
                                                    @if($data->status == 'Open')
                                                        <span class="badge badge-secondary f-12">Open</span>
                                                    @elseif($data->status == 'Procurement')
                                                        <span class="badge badge-warning f-12">Procurement</span>
                                                    @elseif($data->status == 'In Progress')
                                                        <span class="badge badge-primary f-12">In Progress</span>
                                                    @elseif($data->status == 'Pending')
                                                        <span class="badge badge-danger f-12">Pending</span>
                                                    @else
                                                        <span class="badge badge-danger f-12">Non Active</span>
                                                    @endif
                                                </td>
                                                <td nowrap style="text-align: center; vertical-align: top">
                                                    <div class="btn-group"
                                                         style="margin-top: -10px; margin-right: 0px; margin-right: -12px">
                                                        <button class="btn btn-link" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                            <i class="feather icon-settings"></i>
                                                        </button>
                                                        <ul class="list-unstyled dropdown-menu dropdown-menu-right">
                                                            <li class="dropdown-item">
                                                                <a href="{{ route('detailPekerjaan', encrypt($data->pekerjaan_id)) }}">
                                                                    <span><i class="feather icon-info"></i>Detail Project</span>
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <a href="{{ route('editPekerjaan', encrypt($data->pekerjaan_id)) }}">
                                                                    <span><i class="feather icon-edit"></i>Edit</span>
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <a href="javascript:void(0)" class="delete"
                                                                   data-id="{{ encrypt($data->pekerjaan_id) }}"
                                                                   data-nama="{{ $data->nama_pekerjaan }}">
                                                                    <span><i class="feather icon-trash-2"></i>Delete</span>
                                                                </a>
                                                            </li>
                                                        </ul>
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
        </div>
    </div>

    <form method="post" action="{{ action('PekerjaanController@store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div id="modalInput" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLiveLabel">Create Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Proyek <span class="text-danger">*</span></label>
                            <input type="text" autofocus class="form-control" name="namaPekerjaan"
                                   value="{{ old('namaPekerjaan') }}">
                            @if($errors->has('namaPekerjaan'))
                                <small class="text-danger">Nama proyek harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Ringkasan Pekerjaan <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="3" name="ringkasan"></textarea>
                            @if($errors->has('ringkasan'))
                                <small class="text-danger">Ringkasan pekerjaan harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Program Kerja <span class="text-danger">*</span></label>
                            <select class="form-control" name="proker">
                                <option></option>
                                @foreach($dataProker as $proker)
                                    <option value="{{ $proker->id_proker }}">{{ $proker->proker }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('proker'))
                                <small class="text-danger">Program Kerja harus diisi</small>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Perkiraan Biaya (Rp) <span class="text-danger">*</span></label>
                                <input type="text" onkeypress="return hanyaAngka(event)"
                                       class="form-control"
                                       name="nilaiPerkiraan" id="nilaiPerkiraan"
                                       value="{{ old('nilaiPerkiraan') }}">
                                @if($errors->has('nilaiPerkiraan'))
                                    <small class="text-danger">Perkiraan biaya harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Lampiran KAK <span class="text-danger">*</span></label>
                                <br>
                                <input type="hidden" name="namaDokumen" value="KAK">
                                <input type="file" name="lampiran" value="{{ old('lampiran') }}"
                                       accept="application/pdf">
                                @if($errors->has('lampiran'))
                                    <br>
                                    <small class="text-danger">Lampiran KAK harus diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success font-weight-bold text-dark">Save Data</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        var nilaiPerkiraan = document.getElementById('nilaiPerkiraan');
        nilaiPerkiraan.addEventListener('keyup', function (e) {
            nilaiPerkiraan.value = formatRupiah(this.value);
        });
    </script>

    <script>
        $('.delete').click(function () {
            var data_id = $(this).attr('data-id');
            var data_nama = $(this).attr('data-nama');
            swal({
                title: "Are You Sure?",
                text: "Anda akan menghapus Proyek " + data_nama + "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/Pekerjaan/deletePekerjaan/" + data_id + "";
                    }
                });

        });
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop
