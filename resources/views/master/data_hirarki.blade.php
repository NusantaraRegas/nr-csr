@extends('layout.master')
@section('title', 'PGN SHARE | Hirarki Persetujuan')

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

        .empty-icon {
            font-size: 60px;
            color: #888;
            animation: bounce 1.5s infinite alternate;
        }

        @keyframes bounce {
            from {
                transform: translateY(5px);
                opacity: 0.8;
            }

            to {
                transform: translateY(-5px);
                opacity: 1;
            }
        }
    </style>

    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">HIRARKI PERSETUJUAN</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">Hirarki Persetujuan</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                        class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle mr-2"></i>Tambah Hirarki
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($dataHirarki->count() > 0)
                            <ul class="list-group">
                                @foreach ($dataHirarki as $data)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $data->foto_profile ? asset('storage/' . $data->foto_profile) : asset('template/assets/images/user.png') }}"
                                                alt="{{ $data->nama }}" class="rounded-circle mr-1" data-toggle="tooltip"
                                                title="{{ $data->jabatan }}"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            <div class="ml-3">
                                                <h6 class="mb-0 font-weight-bold">{{ $data->nama }}</h6>
                                                <p class="mb-0 text-muted">
                                                    @if ($data->status == 'Active')
                                                        <i class="fas fa-circle mr-1 f-12 text-success"></i>
                                                    @else
                                                        <i class="fas fa-circle mr-1 f-12 text-danger"></i>
                                                    @endif
                                                    {{ $data->nama_level }}
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button"
                                                class="btn btn-sm btn-light mr-1 tooltip-trigger editHirarki" title="Edit"
                                                data-id="{{ encrypt($data->id) }}" data-nama="{{ $data->id_user }}"
                                                data-level="{{ $data->id_level }}" data-status="{{ $data->status }}"
                                                data-toggle="modal" data-target=".modal-edit">
                                                <i class="fa fa-pencil-square text-info font-18"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-light deleteHirarki"
                                                data-toggle="tooltip" title="Hapus" data-id="{{ encrypt($data->id) }}"
                                                data-nama="{{ $data->nama }}">
                                                <i class="fa fa-trash text-danger font-18"></i>
                                            </button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-4">
                                <i class="fa fa-users-slash text-muted" style="font-size: 40px;"></i>
                                <h5 class="mt-3">Belum ada data hirarki</h5>
                                <p class="text-muted mb-0">Silakan klik "Tambah Hirarki" untuk mulai menambahkan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('storeHirarki') }}">
        @csrf
        <div class="modal fade modal-input" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold">Tambah Hirarki</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        {{-- LEVEL --}}
                        <div class="form-group">
                            <label>Level <span class="text-danger">*</span></label>
                            <select class="form-control" name="level" required>
                                <option value="" disabled {{ old('level') ? '' : 'selected' }}>-- Pilih Level --
                                </option>
                                @foreach ($dataLevel as $level)
                                    <option value="{{ $level->id }}"
                                        {{ old('level') == $level->id ? 'selected' : '' }}>
                                        {{ $level->level }}. {{ $level->nama_level }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- NAMA APPROVER --}}
                        <div class="form-group">
                            <label>Nama Approver <span class="text-danger">*</span></label>
                            <select class="form-control pilihNama" name="nama" required>
                                <option value="" disabled {{ old('nama') ? '' : 'selected' }}>-- Pilih Approver --
                                </option>
                                @foreach ($dataApprover as $approver)
                                    <option value="{{ $approver->id_user }}"
                                        {{ old('nama') == $approver->id_user ? 'selected' : '' }}>
                                        {{ $approver->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <form method="POST" action="{{ route('updateHirarki') }}">
        @csrf
        <div class="modal fade modal-edit" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold">Edit Hirarki</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="hirarkiID" id="hirarkiID">
                        <div class="form-group">
                            <label>Level <span class="text-danger">*</span></label>
                            <select class="form-control" name="level" id="level" required>
                                <option value="" disabled {{ old('level') ? '' : 'selected' }}>-- Pilih Level --
                                </option>
                                @foreach ($dataLevel as $level)
                                    <option value="{{ $level->id }}"
                                        {{ old('level') == $level->id ? 'selected' : '' }}>
                                        {{ $level->level }}. {{ $level->nama_level }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Approver <span class="text-danger">*</span></label>
                            <select class="form-control pilihNama" name="nama" id="nama" required>
                                <option value="" disabled {{ old('nama') ? '' : 'selected' }}>-- Pilih Approver --
                                </option>
                                @foreach ($dataApprover as $approver)
                                    <option value="{{ $approver->id_user }}"
                                        {{ old('nama') == $approver->id_user ? 'selected' : '' }}>
                                        {{ $approver->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" id="status">
                                <option value="" disabled {{ old('status') ? '' : 'selected' }}>-- Pilih Status --
                                </option>
                                <option {{ old('status') == 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option {{ old('status') == 'Non Active' ? 'selected' : '' }}>
                                    Non Active
                                </option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $('.tooltip-trigger').tooltip();
        });
    </script>

    <script>
        $(document).on('click', '.editHirarki', function(e) {
            $('#hirarkiID').val($(this).data('id'));
            $('#level').val($(this).data('level')).trigger('change');
            $('#nama').val($(this).data('nama')).trigger('change');
            $('#status').val($(this).data('status')).trigger('change');
        });
    </script>

    <script>
        $('.modal-input').on('shown.bs.modal', function() {
            $(this).find('.pilihNama').select2({
                dropdownParent: $('.modal-input'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Approver --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.modal-edit').on('shown.bs.modal', function() {
            $(this).find('.pilihNama').select2({
                dropdownParent: $('.modal-edit'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Approver --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.deleteHirarki').click(function() {
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
                    window.location = "deleteHirarki/" + data_id;
                }, 1000);
            });
        });
    </script>

    <script>
        @if (count($errors) > 0)
            toastr.warning('Data yang diisi tidak lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
