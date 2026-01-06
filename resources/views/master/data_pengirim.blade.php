@extends('layout.master')
@section('title', 'PGN SHARE | Data Stakeholder')

@section('content')
    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    DATA STAKEHOLDER
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Master Data</li>
                        <li class="breadcrumb-item active">Stakeholder</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                        class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle mr-2"></i>Tambah
                        Stakeholder
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_pengirim" class="table table-striped">
                                <thead class="thead-light font-bold">
                                    <tr>
                                        <th width="800px">Nama Stakeholder</th>
                                        <th class="text-center" width="100px">Status</th>
                                        <th class="text-right" width="100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataPengirim as $data)
                                        <tr>
                                            <td>{{ $data->pengirim }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-pill font-12 {{ $data->status == 'Active' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $data->status }}
                                                </span>
                                            </td>
                                            <td class="text-right" nowrap>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="editPengirim tooltip-trigger"
                                                            title="Edit" data-id="{{ encrypt($data->id_pengirim) }}"
                                                            data-nama="{{ $data->pengirim }}"
                                                            data-status="{{ $data->status }}" data-target=".modal-edit"
                                                            data-toggle="modal">
                                                            <i class="fa fa-pencil-square text-info font-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#!" class="delete" data-toggle="tooltip"
                                                            title="Hapus" data-id="{{ encrypt($data->id_pengirim) }}"
                                                            data-nama="{{ $data->pengirim }}">
                                                            <i class="fa fa-trash text-danger font-18"></i>
                                                        </a>
                                                    </li>
                                                </ul>
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

    <form method="post" action="{{ action('PengirimController@store') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-bold" id="myLargeModalLabel">Tambah Stakeholder</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Stakeholder <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" name="nama" placeholder="" />
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('PengirimController@update') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-bold" id="myLargeModalLabel">Edit Stakeholder</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idpengirim" name="idpengirim">
                        <div class="form-group">
                            <label>Stakeholder <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" id="nama" name="nama" />
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" id="status">
                                    <option>{{ old('status') }}</option>
                                    <option>Active</option>
                                    <option>Non Active</option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            const table = $('#table_pengirim').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                pageLength: 10,

                initComplete: function() {
                    const savedPage = localStorage.getItem('datatablePage');
                    if (savedPage !== null) {
                        this.api().page(parseInt(savedPage)).draw('page');
                    }
                }
            });

            table.on('page.dt', function() {
                const currentPage = table.page.info().page;
                localStorage.setItem('datatablePage', currentPage);
            });
        });
    </script>

    <script>
        $('.delete').click(function() {
            var data_id = $(this).data('id');
            var data_nama = $(this).data('nama');

            if (!data_id) return;

            swal({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin ingin menghapus " + data_nama +
                    "? Tindakan ini tidak bisa dibatalkan.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-secondary",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                setTimeout(() => {
                    window.location = "delete-pengirim/" + data_id;
                }, 1000);
            });
        });

        $(document).on('click', '.editPengirim', function(e) {
            document.getElementById("idpengirim").value = $(this).attr('pengirim-id');
            document.getElementById("nama").value = $(this).attr('pengirim-nama');

            $('#idpengirim').val($(this).data('id'));
            $('#nama').val($(this).data('nama'));
            $('#status').val($(this).data('status'));
        });
    </script>

    <script>
        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi tidak lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
