@extends('layout.master')
@section('title', 'NR SHARE | Profile Entitas')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />

    <style>
        .profile-img-container {
            position: relative;
            display: inline-block;
            padding: 8px;
            margin-top: 20px;
            background: #f9f9f9;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            max-width: 220px;
        }

        .profile-img-container img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
            display: block;
            border-radius: 8px;
        }

        .edit-photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.3s ease;
            cursor: pointer;
        }

        .profile-img-container:hover .edit-photo-overlay {
            opacity: 1;
        }

        .edit-photo-overlay i {
            color: white;
            font-size: 1.5rem;
        }

        .card-body.p-1 {
            padding-top: 2rem !important;
        }
    </style>

    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-bold">
                    <a href="{{ route('indexPerusahaan') }}" class="text-c-blue">
                        <i class="fa fa-arrow-circle-left text-info mr-1"></i>
                    </a>
                    PROFILE ENTITAS
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Master Data</li>
                        <li class="breadcrumb-item">Entitas</li>
                        <li class="breadcrumb-item active">Profile Entitas</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-1">
                        <div class="text-center project-main">
                            <div class="profile-img-container mx-auto mb-3">
                                <img id="fotoProfilCard"
                                    src="{{ $data->foto_profile ? asset('storage/' . $data->foto_profile) : asset('template/assets/images/logo-pertamina-gas-negara.png') }}"
                                    alt="Logo Perusahaan">

                                <div class="edit-photo-overlay" data-toggle="modal" data-target=".modal-ubahFoto">
                                    <i class="feather icon-camera"></i>
                                </div>
                            </div>

                            <h5 class="font-bold">{{ $data->nama_perusahaan }}</h5>
                            <p class="text-muted">{{ $data->kode }}</p>

                            <div class="m-t-30">
                                <a href="javascript:void(0)" data-toggle="modal" data-target=".modal-update"
                                    class="btn btn-outline-info btn-rounded mb-3">
                                    Update Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted mb-3">USER ACTIVE</h5>
                        <div class="d-flex m-t-30 m-b-20 justify-content-between align-items-center">
                            <span class="display-5 text-info"><i class="icon-people"></i></span>
                            <a href="javscript:void(0)" class="link display-5 ms-auto tooltip-trigger" title="Daftar User"
                                data-toggle="modal" data-target=".modal-user">{{ $dataUser->count() }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white bg-info">
                        <h4 class="m-b-0 text-white">Detail Perusahaan {{ '#' . $data->id_perusahaan }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i
                                        class="icon-briefcase text-primary mr-2"></i>
                                    Nama
                                    Perusahaan</label>
                                <div>{{ $data->nama_perusahaan . ' - ' . $data->kode }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block p-0 font-bold text-dark"><i
                                        class="icon-layers text-primary mr-2"></i>Kategori</label>
                                <div>
                                    @if ($data->kategori == 'Holding')
                                        <span class="badge badge-pill font-12 badge-success">Holding</span>
                                    @else
                                        <span class="badge badge-pill font-12 badge-warning text-dark">Subholding</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i
                                        class="icon-location-pin text-primary mr-2"></i>Alamat</label>
                                <div>{{ $data->alamat }}</div>
                            </div>
                            @if (!empty($data->picUser->nama))
                                <div class="col-md-6 mb-2">
                                    <label class="d-block p-0 font-bold text-dark"><i
                                            class="icon-user text-primary mr-2"></i>PIC</label>
                                    <div>{{ $data->picUser->nama ?? '-' }}</div>
                                </div>
                            @endif
                            @if (!empty($data->no_telp))
                                <div class="col-md-6 mb-2">
                                    <label class="d-block p-0 font-bold text-dark"><i
                                            class="icon-phone text-primary mr-2"></i>No
                                        HP</label>
                                    <div>{{ $data->no_telp }}</div>
                                </div>
                            @endif
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
                        <input type="hidden" name="perusahaanID" value="{{ Crypt::encrypt($data->id_perusahaan) }}">
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
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form method="post" action="{{ action('PerusahaanController@updateProfile') }}">
        @csrf
        <div class="modal fade modal-update" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-bold">UPDATE PROFILE</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="perusahaanID" value="{{ Crypt::encrypt($data->id_perusahaan) }}">
                        <div class="form-group">
                            <label>Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control"
                                value="{{ $data->nama_perusahaan }}" maxlength="100" minlength="10" required>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" rows="3" class="form-control" required>{{ $data->alamat }}</textarea>
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama PIC</label>
                                <select name="pic" class="form-control pilihPIC">
                                    <option disabled selected>-- Pilih PIC --</option>
                                    @foreach ($dataPIC as $pic)
                                        <option value="{{ $pic->id_user }}"
                                            {{ $data->pic == $pic->id_user ? 'selected' : '' }}>
                                            {{ $pic->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pic')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>No HP</label>
                                <input type="tel" name="noTelp" onkeypress="return hanyaAngka(event)"
                                    class="form-control" pattern="[0-9]{10,15}"
                                    title="Isi nomor HP dengan angka 10–15 digit" value="{{ $data->no_telp }}">
                                @error('noTelp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Inisial <span class="text-danger">*</span></label>
                                <input type="text" name="inisial" class="form-control" value="{{ $data->kode }}"
                                    maxlength="10" min="2" required>
                                @error('inisial')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-control" required>
                                    <option disabled selected>-- Pilih Kategori --</option>
                                    @foreach (['Holding', 'Subholding', 'Vendor'] as $kategori)
                                        <option value="{{ $kategori }}"
                                            {{ $data->kategori == $kategori ? 'selected' : '' }}>{{ $kategori }}
                                        </option>
                                    @endforeach
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
            </div>
        </div>
    </form>

    <div class="modal fade modal-user" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-bold"><i class="icon-people mr-2"></i>DAFTAR USER</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <ul class="list-unstyled">
                        @foreach ($dataUser as $user)
                            <li class="mb-3 pb-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('profileUser', Crypt::encrypt($user->id_user)) }}"
                                        data-toggle="tooltip" title="Profile User">
                                        <img src="{{ $user->foto_profile ? asset('storage/' . $user->foto_profile) : asset('template/assets/images/user.png') }}"
                                            alt="{{ $user->nama }}" class="rounded-circle mr-3"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    </a>
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $user->nama }}</h6>
                                        <p class="mb-0 text-muted">{{ $user->jabatan }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
        let cropper;
        const image = document.getElementById('previewCrop');
        const input = document.getElementById('inputFoto');
        const logoForm = document.getElementById('uploadFotoForm');

        input.addEventListener('change', (e) => {
            const files = e.target.files;
            if (files && files.length > 0) {
                const reader = new FileReader();
                reader.onload = () => {
                    image.src = reader.result;
                    image.style.display = 'block';

                    if (cropper) cropper.destroy();
                    cropper = new Cropper(image, {
                        aspectRatio: NaN,
                        viewMode: 1,
                        autoCropArea: 0.8,
                        responsive: true,
                        movable: true,
                        zoomable: true,
                        scalable: true,
                        rotatable: false
                    });
                };
                reader.readAsDataURL(files[0]);
            }
        });

        logoForm.addEventListener('submit', function(e) {
            e.preventDefault(); // prevent default submit

            if (cropper) {
                cropper.getCroppedCanvas().toBlob((blob) => {
                    const formData = new FormData(logoForm);
                    formData.set('foto_profile', blob); // ganti file input dengan hasil crop

                    fetch(logoForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status) {
                                // Update gambar jika perlu
                                document.getElementById('fotoProfilCard').src = data.foto_profile +
                                    '?' + new Date().getTime();

                                // Tampilkan toastr sukses
                                toastr.success(data.message, 'Sukses', {
                                    closeButton: true
                                });

                                // Tutup modal
                                $('.modal-ubahFoto').modal('hide');

                                // Reset cropper dan input file
                                if (cropper) {
                                    cropper.destroy();
                                    cropper = null;
                                }
                                image.src = '';
                                image.style.display = 'none';
                                input.value = ''; // agar input file bisa dipilih ulang
                            } else {
                                toastr.error(data.message, 'Gagal', {
                                    closeButton: true
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Upload gagal:', error);
                            toastr.error('Terjadi kesalahan saat mengunggah foto', 'Gagal', {
                                closeButton: true
                            });
                        });
                });
            }
        });
    </script>

    <script>
        $('.modal-update').on('shown.bs.modal', function() {
            $(this).find('.pilihPIC').select2({
                dropdownParent: $('.modal-update'),
                width: '100%',
                placeholder: "-- Pilih PIC --",
                allowClear: true
            });
        });
    </script>

    <script>
        // Saat modal ditampilkan, baru jalankan select2
        $('.modal-input').on('shown.bs.modal', function() {
            $(this).find('.pilihPIC').select2({
                dropdownParent: $('.modal-input'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih PIC --",
                allowClear: true
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.tooltip-trigger').tooltip();
        });
    </script>

    <script>
        $(document).on('click', '.ubahLogo', function(e) {
            $('#logoID').val($(this).data('id'));
        });
    </script>

    <script>
        $(document).on('click', '.user-edit', function(e) {
            $('#perusahaanID').val($(this).data('id'));
            $('#nama').val($(this).data('nama'));
            $('#alamat').val($(this).data('alamat'));
            $('#inisial').val($(this).data('kode'));
            $('#kategori').val($(this).data('kategori'));
        });
    </script>

    <script>
        $(document).on('click', '.user-edit', function(e) {
            $('#perusahaanID').val($(this).data('id'));
            $('#nama').val($(this).data('nama'));
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
        @if ($errors->any() && session('_old_input') && !session('_old_input.perusahaanID'))
            $('.modal-input').modal('show');
        @endif
    </script>

    <script>
        @if ($errors->any() && session('_old_input') && session('_old_input.perusahaanID'))
            $('.modal-edit').modal('show');
        @endif
    </script>

    <script>
        $('.delete').click(function() {
            var data_id = $(this).data('id');
            var data_nama = $(this).data('nama');

            if (!data_id) return;

            swal({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin ingin menghapus " + data_nama + "?",
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
