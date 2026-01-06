@extends('layout.master')
@section('title', 'PGN SHARE | Komisi VI & VII')

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
                <h4 class="font-bold">KOMISI VI & VII</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">Komisi VI & VII</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                        class="btn btn-info d-none d-lg-block m-l-15"><i class="fas fa-plus-circle mr-2"></i>Tambah Anggota
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="example5 table table-striped">
                                <thead class="thead-light font-bold">
                                    <tr>
                                        <th class="text-center" width="300px">Nama Anggota</th>
                                        <th class="text-center" width="200px">Fraksi</th>
                                        <th class="text-center" width="50px">Komisi</th>
                                        <th class="text-center" width="200px">Tenaga Ahli</th>
                                        <th class="text-center" width="100px">Status</th>
                                        <th class="text-right" width="100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataAnggota as $data)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('profileAnggota', Crypt::encrypt($data->id_anggota)) }}"
                                                        data-toggle="tooltip" title="Profile Anggota">
                                                        <img src="{{ $data->foto_profile ? asset('storage/' . $data->foto_profile) : asset('template/assets/images/user.png') }}"
                                                            alt="{{ $data->nama_anggota }}" class="rounded-circle mr-3"
                                                            style="width: 60px;">
                                                    </a>
                                                    <div>
                                                        <h6 class="mb-1 font-weight-bold">{{ $data->nama_anggota }}</h6>
                                                        <p class="mb-0 text-muted">{{ $data->jabatan }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">{{ $data->fraksi }}</td>
                                            <td class="align-middle">{{ $data->komisi }}</td>
                                            <td class="align-middle" nowrap>
                                                <h6 class="mb-1"><i class="icon-user mr-2"></i>{{ $data->staf_ahli }}</h6>
                                                <p class="mb-0 text-muted"><i
                                                        class="icon-phone mr-2"></i>{{ $data->no_telp }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <span
                                                    class="badge badge-pill font-12 {{ $data->status == 'Active' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $data->status }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-right" nowrap>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('profileAnggota', Crypt::encrypt($data->id_anggota)) }}"
                                                            data-toggle="tooltip" title="Profile Anggota">
                                                            <i class="fa fa-eye" style="font-size: 19px"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#" class="editAnggota tooltip-trigger" title="Edit"
                                                            data-id="{{ Crypt::encrypt($data->id_anggota) }}"
                                                            data-nama="{{ $data->nama_anggota }}"
                                                            data-fraksi="{{ $data->fraksi }}"
                                                            data-komisi="{{ $data->komisi }}"
                                                            data-jabatan="{{ $data->jabatan }}"
                                                            data-tenagaahli="{{ $data->staf_ahli }}"
                                                            data-telp="{{ $data->no_telp }}"
                                                            data-status="{{ $data->status }}" data-target=".modal-edit"
                                                            data-toggle="modal">
                                                            <i class="fa fa-pencil-square text-info font-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#!" class="delete" data-toggle="tooltip"
                                                            title="Hapus" data-id="{{ encrypt($data->id_anggota) }}"
                                                            data-nama="{{ $data->nama_anggota }}">
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

    <form method="POST" action="{{ action('AnggotaController@store') }}">
        @csrf
        <div class="modal fade modal-input" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Tambah Anggota</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama Anggota <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}"
                                    required>
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <select class="form-control" name="jabatan" required>
                                    <option value="" disabled {{ old('jabatan') ? '' : 'selected' }}>-- Pilih
                                        Jabatan --</option>
                                    <option value="Ketua" {{ old('jabatan') == 'Ketua' ? 'selected' : '' }}>Ketua
                                    </option>
                                    <option value="Wakil Ketua" {{ old('jabatan') == 'Wakil Ketua' ? 'selected' : '' }}>
                                        Wakil Ketua</option>
                                    <option value="Anggota" {{ old('jabatan') == 'Anggota' ? 'selected' : '' }}>Anggota
                                    </option>
                                </select>
                                @error('jabatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Fraksi <span class="text-danger">*</span></label>
                                <select name="fraksi" class="form-control pilihPartai" required>
                                    <option value="" disabled {{ old('fraksi') ? '' : 'selected' }}>-- Pilih Fraksi
                                        --</option>
                                    @foreach (['Kebangkitan Bangsa (PKB)', 'Gerakan Indonesia Raya (Gerindra)', 'PDI Perjuangan (PDIP)', 'Golongan Karya (Golkar)', 'Nasional Demokrasi (Nasdem)', 'Gerakan Perubahan Indonesia (Garuda)', 'Beringin Karya (Berkarya)', 'Keadilan Sejahtera (PKS)', 'Persatuan Indonesia (Perindo)', 'Persatuan Pembangunan (PPP)', 'Solidaritas Indonesia (PSI)', 'Amanat Nasional (PAN)', 'Hati Nurani Rakyat (Hanura)', 'Demokrat'] as $fraksi)
                                        <option value="{{ $fraksi }}"
                                            {{ old('fraksi') == $fraksi ? 'selected' : '' }}>
                                            {{ $fraksi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fraksi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Komisi <span class="text-danger">*</span></label>
                                <select name="komisi" class="form-control" required>
                                    <option value="" disabled {{ old('komisi') ? '' : 'selected' }}>-- Pilih Komisi
                                        --</option>
                                    @foreach (['VI', 'VII'] as $komisi)
                                        <option value="{{ $komisi }}"
                                            {{ old('komisi') == $komisi ? 'selected' : '' }}>
                                            {{ $komisi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('komisi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tenaga Ahli <span class="text-danger">*</span></label>
                                <input type="text" name="tenagaAhli" class="form-control"
                                    value="{{ old('tenagaAhli') }}" required>
                                @error('tenagaAhli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>No HP <span class="text-danger">*</span></label>
                                <input type="tel" name="noTelp" class="form-control" value="{{ old('noTelp') }}"
                                    pattern="[0-9]{10,15}" maxlength="15" title="Isi nomor HP dengan angka 10–15 digit"
                                    required onkeypress="return hanyaAngka(event)">
                                @error('noTelp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
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

    <form method="POST" action="{{ action('AnggotaController@update') }}">
        @csrf
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Edit Anggota</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="anggotaID" id="anggotaID" value="{{ old('anggotaID') }}">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama Anggota <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" id="nama"
                                    value="{{ old('nama') }}">
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <select class="form-control" name="jabatan" id="jabatan" required>
                                    <option value="" disabled {{ old('jabatan') ? '' : 'selected' }}>-- Pilih
                                        Jabatan --</option>
                                    <option value="Ketua" {{ old('jabatan') == 'Ketua' ? 'selected' : '' }}>Ketua
                                    </option>
                                    <option value="Wakil Ketua" {{ old('jabatan') == 'Wakil Ketua' ? 'selected' : '' }}>
                                        Wakil Ketua</option>
                                    <option value="Anggota" {{ old('jabatan') == 'Anggota' ? 'selected' : '' }}>Anggota
                                    </option>
                                </select>
                                @error('jabatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Fraksi <span class="text-danger">*</span></label>
                                <select class="form-control pilihPartai" name="fraksi" id="fraksi" required>
                                    <option value="" disabled {{ old('fraksi') ? '' : 'selected' }}>-- Pilih Fraksi
                                        --</option>
                                    @foreach (['Kebangkitan Bangsa (PKB)', 'Gerakan Indonesia Raya (Gerindra)', 'PDI Perjuangan (PDIP)', 'Golongan Karya (Golkar)', 'Nasional Demokrasi (Nasdem)', 'Gerakan Perubahan Indonesia (Garuda)', 'Beringin Karya (Berkarya)', 'Keadilan Sejahtera (PKS)', 'Persatuan Indonesia (Perindo)', 'Persatuan Pembangunan (PPP)', 'Solidaritas Indonesia (PSI)', 'Amanat Nasional (PAN)', 'Hati Nurani Rakyat (Hanura)', 'Demokrat'] as $fraksi)
                                        <option value="{{ $fraksi }}"
                                            {{ old('fraksi') == $fraksi ? 'selected' : '' }}>{{ $fraksi }}</option>
                                    @endforeach
                                </select>
                                @error('fraksi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Komisi <span class="text-danger">*</span></label>
                                <select class="form-control" name="komisi" id="komisi" required>
                                    <option value="" disabled {{ old('komisi') ? '' : 'selected' }}>-- Pilih Komisi
                                        --</option>
                                    <option value="VI" {{ old('komisi') == 'VI' ? 'selected' : '' }}>VI</option>
                                    <option value="VII" {{ old('komisi') == 'VII' ? 'selected' : '' }}>VII</option>
                                </select>
                                @error('komisi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tenaga Ahli <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="tenagaAhli" id="tenagaAhli"
                                    value="{{ old('tenagaAhli') }}">
                                @error('tenagaAhli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>No Telepon <span class="text-danger">*</span></label>
                                <input type="tel" name="noTelp" id="noTelp" class="form-control"
                                    value="{{ old('noTelp') }}" pattern="[0-9]{10,15}" maxlength="15"
                                    title="Isi nomor HP dengan angka 10–15 digit" required
                                    onkeypress="return hanyaAngka(event)">
                                @error('noTelp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>-- Pilih Status
                                        --</option>
                                    @foreach (['Active', 'Non Active'] as $status)
                                        <option value="{{ $status }}"
                                            {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
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
        $(document).on('click', '.editAnggota', function(e) {
            $('#anggotaID').val($(this).data('id'));
            $('#nama').val($(this).data('nama'));
            $('#fraksi').val($(this).data('fraksi')).trigger('change');
            $('#komisi').val($(this).data('komisi')).trigger('change');
            $('#jabatan').val($(this).data('jabatan')).trigger('change');
            $('#tenagaAhli').val($(this).data('tenagaahli'));
            $('#noTelp').val($(this).data('telp'));
            $('#status').val($(this).data('status')).trigger('change');
        });
    </script>

    <script>
        $('.modal-input').on('shown.bs.modal', function() {
            $(this).find('.pilihPartai').select2({
                dropdownParent: $('.modal-input'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Fraksi --",
                allowClear: true
            });
        });
    </script>

    <script>
        $('.modal-edit').on('shown.bs.modal', function() {
            $(this).find('.pilihPartai').select2({
                dropdownParent: $('.modal-edit'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Fraksi --",
                allowClear: true
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
                    window.location = "deleteAnggota/" + data_id;
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
