@extends('layout.master')
@section('title', 'PGN SHARE | Manajemen User')

@section('content')
    <style>
        img.rounded-circle {
            border: 2px solid #f0f0f0;
            transition: transform 0.2s ease;
        }

        img.rounded-circle:hover {
            transform: scale(1.05);
        }

        .table-striped tbody tr td {
            vertical-align: middle;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
    </style>

    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">MANAJEMEN USER</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">Manajemen User</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                        class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle mr-2"></i>Tambah User
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_user" class="table table-striped">
                                <thead class="thead-light font-bold">
                                    <tr>
                                        <th class="text-center" width="400px">Nama</th>
                                        <th class="text-center" width="300px">Entitas</th>
                                        <th class="text-center" width="100px">Role</th>
                                        <th class="text-center" width="100px">Status</th>
                                        <th class="text-right" width="100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataUser as $data)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('profileUser', Crypt::encrypt($data->id_user)) }}"
                                                        data-toggle="tooltip" title="Profile User">
                                                        <img src="{{ $data->foto_profile ? asset('storage/' . $data->foto_profile) : asset('template/assets/images/user.png') }}"
                                                            alt="{{ $data->nama }}" class="rounded-circle mr-3"
                                                            style="width: 60px;">
                                                    </a>
                                                    <div>
                                                        <h6 class="mb-1 font-weight-bold">{{ $data->nama }}</h6>
                                                        <p class="mb-0 text-muted">{{ $data->jabatan }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <h6 class="mb-1 font-weight-bold">
                                                    {{ $data->namaPerusahaan->nama_perusahaan ?? '-' }}</h6>
                                                <p class="mb-0 text-muted">{{ $data->namaPerusahaan->kode ?? '-' }}</p>
                                            </td>
                                            <td class="align-middle">{{ $data->role }}</td>
                                            <td class="align-middle">
                                                <span
                                                    class="badge badge-pill font-12 {{ $data->status == 'Active' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $data->status }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-right" nowrap>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('profileUser', Crypt::encrypt($data->id_user)) }}"
                                                            data-toggle="tooltip" title="Profile User">
                                                            <i class="fas fa-eye" style="font-size: 19px"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#" class="edit tooltip-trigger" title="Edit"
                                                            data-id="{{ encrypt($data->id_user) }}"
                                                            data-username="{{ $data->username }}"
                                                            data-email="{{ $data->email }}"
                                                            data-nama="{{ $data->nama }}"
                                                            data-jabatan="{{ $data->jabatan }}"
                                                            data-perusahaan="{{ $data->id_perusahaan }}"
                                                            data-role="{{ $data->role }}"
                                                            data-status="{{ $data->status }}"
                                                            data-sk="{{ $data->no_sk }}"
                                                            data-tglsk="{{ $data->tgl_sk ? date('d-M-Y', strtotime($data->tgl_sk)) : '' }}"
                                                            data-target=".modal-edit" data-toggle="modal">
                                                            <i class="far fa-edit text-info font-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#!" class="delete" data-toggle="tooltip"
                                                            title="Hapus" data-id="{{ encrypt($data->id_user) }}"
                                                            data-nama="{{ $data->nama }}">
                                                            <i class="fas fa-trash-alt text-danger font-18"></i>
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

    <form method="post" action="{{ action('UserController@store') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">Tambah User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username"
                                    value="{{ old('username') }}">
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" value="{{ old('nama') }}">
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jabatan" value="{{ old('jabatan') }}">
                                @error('jabatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Entitas <span class="text-danger">*</span></label>
                            <select name="perusahaan" class="form-control pilihEntitas">
                                <option>{{ old('perusahaan') }}</option>
                                @foreach ($dataPerusahaan as $perusahaan)
                                    <option value="{{ $perusahaan->id_perusahaan }}">{{ $perusahaan->nama_perusahaan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('perusahaan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control">
                                    <option>{{ old('role') }}</option>
                                    <option>Super Admin</option>
                                    <option>Admin</option>
                                    <option>Inputer</option>
                                    <option>Finance</option>
                                    <option>Budget</option>
                                    <option>Payment</option>
                                    <option>Legal</option>
                                    <option>Supervisor 1</option>
                                    <option>Supervisor 2</option>
                                    <option>Manager</option>
                                    <option>Corporate Secretary</option>
                                    <option>Direktur</option>
                                    <option>Subsidiary</option>
                                </select>
                                @error('role')
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
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('UserController@update') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="userID" id="userID">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username"
                                    value="{{ old('username') }}" id="username">
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    id="email">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" value="{{ old('nama') }}"
                                    id="nama">
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jabatan" value="{{ old('jabatan') }}"
                                    id="jabatan">
                                @error('jabatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Perusahaan <span class="text-danger">*</span></label>
                            <select name="perusahaan" class="form-control pilihEntitas" id="perusahaan">
                                <option>{{ old('perusahaan') }}</option>
                                @foreach ($dataPerusahaan as $perusahaan)
                                    <option value="{{ $perusahaan->id_perusahaan }}">{{ $perusahaan->nama_perusahaan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('perusahaan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control" id="role">
                                    <option>{{ old('role') }}</option>
                                    <option>Super Admin</option>
                                    <option>Admin</option>
                                    <option>Inputer</option>
                                    <option>Finance</option>
                                    <option>Budget</option>
                                    <option>Payment</option>
                                    <option>Legal</option>
                                    <option>Supervisor 1</option>
                                    <option>Supervisor 2</option>
                                    <option>Manager</option>
                                    <option>Corporate Secretary</option>
                                    <option>Direktur</option>
                                    <option>Manager</option>
                                    <option>Subsidiary</option>
                                </select>
                                @error('role')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
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
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nomor SK</label>
                                <input type="text" name="noSK" id="noSK" class="form-control text-uppercase"
                                    value="{{ old('noSK') }}">
                                @error('noSK')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal SK</label>
                                <div class="input-group">
                                    <input type="text" name="tglSK" id="tglSK" class="form-control mdate"
                                        value="{{ old('tglSurat') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar text-info"></i></span>
                                    </div>
                                </div>
                                @error('tglSurat')
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
        // Use bootstrap-datepicker instead of bootstrap-material-datetimepicker
        $(document).ready(function() {
            $('.mdate').datepicker({
                format: 'dd-M-yyyy',
                autoclose: true,
                todayHighlight: true,
                orientation: 'bottom auto'
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            const table = $('#table_user').DataTable({
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
        $('.modal-input').on('shown.bs.modal', function() {
            $(this).find('.pilihEntitas').select2({
                dropdownParent: $('.modal-input'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Entitas --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.modal-edit').on('shown.bs.modal', function() {
            $(this).find('.pilihEntitas').select2({
                dropdownParent: $('.modal-edit'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Entitas --",
                allowClear: true
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script>
        $(document).on('click', '.edit', function(e) {
            document.getElementById("userID").value = $(this).attr('data-id');
            document.getElementById("username").value = $(this).attr('data-username');
            document.getElementById("email").value = $(this).attr('data-email');
            document.getElementById("nama").value = $(this).attr('data-nama');
            document.getElementById("jabatan").value = $(this).attr('data-jabatan');
            document.getElementById("perusahaan").value = $(this).attr('data-perusahaan');
            document.getElementById("role").value = $(this).attr('data-role');
            document.getElementById("status").value = $(this).attr('data-status');
            document.getElementById("noSK").value = $(this).attr('data-sk');
            document.getElementById("tglSK").value = $(this).attr('data-tglsk');
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
                    window.location = "deleteUser/" + data_id;
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
