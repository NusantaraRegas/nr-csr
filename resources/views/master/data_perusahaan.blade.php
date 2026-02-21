@extends('layout.master')
@section('title', 'NR SHARE | Data Entitas')

@section('content')
    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    DATA ENTITAS
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Master Data</li>
                        <li class="breadcrumb-item active">Entitas</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                        class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle mr-2"></i>Tambah
                        Entitas
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_entitas" class="table table-striped">
                                <thead class="thead-light font-bold">
                                    <tr>
                                        <th width="300px">Nama Perusahaan</th>
                                        <th width="400px">Alamat</th>
                                        <th width="100px">Kategori</th>
                                        <th class="text-right" width="100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataPerusahaan as $data)
                                        <tr>
                                            <td>
                                                <h6 class="mb-1 font-bold">{{ $data->nama_perusahaan }}</h6>
                                                <p class="mb-0 text-muted">{{ $data->kode }}</p>
                                            </td>
                                            <td>
                                                <h6 class="mb-1 font-bold">{{ $data->alamat }}</h6>
                                                @if (!empty($data->picUser->nama))
                                                    <p class="mb-0 text-muted"><i
                                                            class="icon-user mr-2"></i>{{ $data->picUser->nama ?? '-' }}</p>
                                                @endif
                                                @if (!empty($data->no_telp))
                                                    <p class="mb-0 text-muted"><i
                                                            class="icon-phone mr-2"></i>{{ $data->no_telp }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->kategori == 'Holding')
                                                    <span class="badge badge-pill font-12 badge-success">Holding</span>
                                                @else
                                                    <span
                                                        class="badge badge-pill font-12 badge-warning text-dark">Subholding</span>
                                                @endif
                                            </td>
                                            <td class="text-right" nowrap>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('profilePerusahaan', Crypt::encrypt($data->id_perusahaan)) }}"
                                                            data-toggle="tooltip" title="Profile Perusahaan">
                                                            <i class="fa fa-eye" style="font-size: 19px"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#" class="user-edit tooltip-trigger" title="Edit"
                                                            data-id="{{ encrypt($data->id_perusahaan) }}"
                                                            data-nama="{{ $data->nama_perusahaan }}"
                                                            data-alamat="{{ $data->alamat }}"
                                                            data-kode="{{ $data->kode }}"
                                                            data-kategori="{{ $data->kategori }}" data-target=".modal-edit"
                                                            data-toggle="modal">
                                                            <i class="fa fa-pencil-square text-info font-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#!" class="delete" data-toggle="tooltip"
                                                            title="Hapus" data-id="{{ encrypt($data->id_perusahaan) }}"
                                                            data-nama="{{ $data->nama_perusahaan }}">
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

    <div class="modal fade modal-ubahFoto" tabindex="-1" role="dialog" aria-labelledby="ubahFotoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="uploadFotoForm" action="{{ action('PerusahaanController@updateLogo') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold">Logo Perusahaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="perusahaanID" id="logoID">
                        <div class="form-group">
                            <label>Upload Foto <span class="text-danger">*</span></label>
                            <input type="file" name="foto_profile" id="inputFoto" class="form-control mb-3"
                                accept="image/*" required>
                            @error('foto_profile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div style="max-height: 300px; overflow:hidden;">
                            <img id="previewCrop" style="max-width: 100%; display: none;" />
                        </div>
                        <input type="hidden" name="cropped_image" id="croppedImageInput">
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
            </form>
        </div>
    </div>

    <div class="modal fade modal-input" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <form method="post" action="{{ action('PerusahaanController@store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-bold">Tambah Entitas</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}"
                                maxlength="100" min="10" required>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" rows="3" class="form-control" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Inisial <span class="text-danger">*</span></label>
                                <input type="text" name="inisial" class="form-control" value="{{ old('inisial') }}"
                                    maxlength="10" min="2" required>
                                @error('inisial')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-control" required>
                                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>-- Pilih
                                        Kategori --</option>
                                    <option value="Holding" {{ old('kategori') == 'Holding' ? 'selected' : '' }}>Holding
                                    </option>
                                    <option value="Subholding" {{ old('kategori') == 'Subholding' ? 'selected' : '' }}>
                                        Subholding</option>
                                </select>
                                @error('kategori')
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
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade modal-edit" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <form method="post" action="{{ action('PerusahaanController@update') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-bold">Edit Entitas</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="perusahaanID" id="perusahaanID">

                        <div class="form-group">
                            <label>Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                placeholder="Nama perusahaan" value="{{ old('nama') }}" required>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" rows="3" class="form-control" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Inisial <span class="text-danger">*</span></label>
                                <input type="text" name="inisial" id="inisial" class="form-control"
                                    placeholder="Contoh: NR" value="{{ old('inisial') }}" required>
                                @error('inisial')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" name="kategori" id="kategori" required>
                                    <option disabled value="">-- Pilih Kategori --</option>
                                    <option value="Holding" {{ old('kategori') == 'Holding' ? 'selected' : '' }}>Holding
                                    </option>
                                    <option value="Subholding" {{ old('kategori') == 'Subholding' ? 'selected' : '' }}>
                                        Subholding</option>
                                </select>
                                @error('kategori')
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
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            const table = $('#table_entitas').DataTable({
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
        $(document).ready(function() {
            $('.tooltip-trigger').tooltip();
        });
    </script>

    <script>
        $(document).on('click', '.user-edit', function(e) {
            $('#perusahaanID').val($(this).attr('data-id'));
            $('#nama').val($(this).data('nama'));
            $('#alamat').val($(this).data('alamat'));
            $('#inisial').val($(this).data('kode'));
            $('#kategori').val($(this).data('kategori'));
        });
    </script>

    @if ($errors->any() && !old('perusahaanID'))
        <script>
            $('.modal-input').modal('show');
        </script>
    @endif

    @if ($errors->any() && old('perusahaanID'))
        <script>
            $('.modal-edit').modal('show');
        </script>
    @endif

    <script>
        $(document).on('click', '.delete', function() {
            var data_id = $(this).attr('data-id');
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
                    submitDelete("deletePerusahaan/" + data_id);
                }, 1000);
            });
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
