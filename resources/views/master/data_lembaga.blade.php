@extends('layout.master')
@section('title', 'PGN SHARE | Lembaga & Yayasan')

@section('content')
    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    LEMBAGA & YAYASAN
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Master Data</li>
                        <li class="breadcrumb-item active">Lembaga & Yayasan</li>
                    </ol>
                    <button type="button" data-toggle="modal" data-target=".modal-input"
                        class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle mr-2"></i>Tambah
                        Lembaga
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
                                        <th class="text-center" width="50px">ID</th>
                                        <th width="400px">Nama Lembaga</th>
                                        <th width="200px">Penanggung Jawab</th>
                                        <th width="200px">Informasi Bank</th>
                                        <th class="text-right" width="100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataLembaga as $data)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0 font-bold">{{ '#' . $data->id_lembaga }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-1 font-bold">{{ strtoupper($data->nama_lembaga) }}</h6>
                                                <p class="mb-0 text-muted">{{ $data->alamat }}</p>
                                            </td>
                                            <td>
                                                <h6 class="mb-1 font-bold">{{ $data->nama_pic }}</h6>
                                                <p class="mb-0 text-muted">
                                                    <i class="icon-star mr-2"></i>{{ $data->jabatan }}
                                                </p>
                                                <p class="mb-0 text-muted">
                                                    <i class="icon-phone mr-2"></i>{{ $data->no_telp }}
                                                </p>
                                            </td>
                                            <td nowrap>
                                                @if (!empty($data->nama_bank))
                                                    <h6 class="mb-1 font-bold">{{ $data->nama_bank }}</h6>
                                                    <p class="mb-0 text-muted">
                                                        <i class="icon-credit-card mr-2"></i>{{ $data->no_rekening }}
                                                    </p>
                                                    <p class="mb-0 text-muted">
                                                        <i class="icon-user mr-2"></i>{{ $data->atas_nama }}
                                                    </p>
                                                @else
                                                    <p class="mb-1 text-danger">Informasi Bank belum ditambahkan</p>
                                                @endif
                                                <a href="#" class="text-info updateBank"
                                                    data-id="{{ encrypt($data->id_lembaga) }}"
                                                    data-namabank="{{ $data->nama_bank }}"
                                                    data-norek="{{ $data->no_rekening }}"
                                                    data-atasnama="{{ $data->atas_nama }}" data-target=".modal-updateBank"
                                                    data-toggle="modal">
                                                    <i class="fa fa-pencil-square text-info mr-2"></i>Update Informasi
                                                    Bank</a>

                                            </td>
                                            <td class="text-right" nowrap>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="edit tooltip-trigger" title="Edit"
                                                            data-id="{{ encrypt($data->id_lembaga) }}"
                                                            data-nama="{{ $data->nama_lembaga }}"
                                                            data-alamat="{{ $data->alamat }}"
                                                            data-pic="{{ $data->nama_pic }}"
                                                            data-jabatan="{{ $data->jabatan }}"
                                                            data-notelp="{{ $data->no_telp }}" data-target=".modal-edit"
                                                            data-toggle="modal">
                                                            <i class="far fa-edit text-info font-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#" class="delete" data-toggle="tooltip"
                                                            title="Hapus" data-id="{{ encrypt($data->id_lembaga) }}">
                                                            <i class="far fa-trash-alt text-danger font-16"></i>
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

    <form method="post" action="{{ action('LembagaController@store') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-input" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Tambah Lembaga</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Lembaga <span class="text-danger">*</span></label>
                            <input type="text" name="namaLembaga" class="form-control" value="{{ old('namaLembaga') }}"
                                maxlength="100" min="3" required>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama PIC <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pic" value="{{ old('pic') }}"
                                    maxlength="100" min="3" required>
                                @error('pic')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>No HP <span class="text-danger">*</span></label>
                                <input type="tel" name="noTelp" onkeypress="return hanyaAngka(event)"
                                    class="form-control" pattern="[0-9]{10,15}"
                                    title="Isi nomor HP dengan angka 10–15 digit" value="{{ old('noTelp') }}">
                                @error('noTelp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="jabatan" value="{{ old('jabatan') }}"
                                maxlength="100" min="3" required>
                            @error('jabatan')
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

    <form method="post" action="{{ action('LembagaController@update') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Edit Lembaga</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="lembagaID" id="lembagaID"
                            value="{{ old('lembagaID') }}">
                        <div class="form-group">
                            <label>Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="namaLembaga" id="namaLembaga" class="form-control"
                                value="{{ old('namaLembaga') }}" maxlength="100" min="3" required>
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
                                <label>Nama PIC <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pic" id="pic"
                                    value="{{ old('pic') }}" maxlength="100" min="3" required>
                                @error('pic')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>No HP <span class="text-danger">*</span></label>
                                <input type="tel" name="noTelp" id="noTelp"
                                    onkeypress="return hanyaAngka(event)" class="form-control" pattern="[0-9]{10,15}"
                                    title="Isi nomor HP dengan angka 10–15 digit" value="{{ old('noTelp') }}">
                                @error('noTelp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group">
                            <label>Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan"
                                value="{{ old('jabatan') }}" maxlength="100" min="3" required>
                            @error('jabatan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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

    <form method="post" action="{{ action('LembagaController@updateBank') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-updateBank" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Update Informasi Bank</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="lembagaID" id="lembagaBank"
                            value="{{ old('lembagaID') }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama Bank</label>
                                <select class="form-control pilihBank" name="namaBank" id="namaBank">
                                    <option>{{ old('namaBank') }}</option>
                                    <option disabled value="">-- Pilih Bank --</option>
                                    @foreach ($dataBank as $bank)
                                        <option value="{{ $bank->nama_bank }}">{{ $bank->nama_bank }}</option>
                                    @endforeach
                                </select>
                                @error('namaBank')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>No Rekening</label>
                                <input type="text" name="noRekening" id="noRekening"
                                    onkeypress="return hanyaAngka(event)" class="form-control"
                                    value="{{ old('noRekening') }}">
                                @error('noRekening')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Atas Nama</label>
                            <input type="text" name="atasNama" id="atasNama" class="form-control"
                                value="{{ old('atasNama') }}">
                            @error('atasNama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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
            $('.tooltip-trigger').tooltip();
        });
    </script>

    <script>
        $('.modal-updateBank').on('shown.bs.modal', function() {
            $(this).find('.pilihBank').select2({
                dropdownParent: $('.modal-updateBank'),
                width: '100%',
                placeholder: "-- Pilih Bank --",
                allowClear: true
            });
        });
    </script>

    <script>
        $(document).on('click', '.edit', function(e) {
            $('#lembagaID').val($(this).data('id'));
            $('#namaLembaga').val($(this).data('nama'));
            $('#alamat').val($(this).data('alamat'));
            $('#pic').val($(this).data('pic'));
            $('#jabatan').val($(this).data('jabatan'));
            $('#noTelp').val($(this).data('notelp'));
        });
    </script>

    <script>
        $(document).on('click', '.updateBank', function(e) {
            $('#lembagaBank').val($(this).data('id'));
            $('#namaBank').val($(this).data('namabank'));
            $('#noRekening').val($(this).data('norek'));
            $('#atasNama').val($(this).data('atasnama'));
        });
    </script>

    <script>
        $('#namaBank').on('change', function() {
            var kodeBank = $('#namaBank option:selected').attr('kodeBank');
            $('#kodeBank').val(kodeBank);
        });

        $('#kota').on('change', function() {
            var kodeKota = $('#kota option:selected').attr('kodeKota');
            $('#kodeKota').val(kodeKota);
        });
    </script>

    <script>
        $('.delete').click(function() {
            var data_id = $(this).data('id');

            if (!data_id) return;

            swal({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin ingin menghapus lembaga ini? Tindakan ini tidak bisa dibatalkan.",
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
                    window.location = "deleteLembaga/" + data_id;
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
