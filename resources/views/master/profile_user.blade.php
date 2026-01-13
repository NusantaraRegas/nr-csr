@extends('layout.master')
@section('title', 'NR SHARE | Profile User')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />

    <style>
        .profile-img-container {
            position: relative;
            display: inline-block;
            width: 140px;
            height: 140px;
        }

        .profile-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .edit-photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 50%;
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
            color: #fff;
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
                    <a href="{{ url()->previous() ?? route('home') }}" class="text-c-blue">
                        <i class="fa fa-arrow-circle-left text-info mr-1"></i>
                    </a>
                    PROFILE USER
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Master Data</li>
                        <li class="breadcrumb-item">Manajemen User</li>
                        <li class="breadcrumb-item active">Profile User</li>
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
                                    src="{{ $data->foto_profile ? asset('storage/' . $data->foto_profile) : asset('template/assets/images/user.png') }}"
                                    alt="Profile Picture" class="img-thumbnail">

                                <!-- Overlay Button -->
                                <div class="edit-photo-overlay" data-toggle="modal" data-target=".modal-ubahFoto">
                                    <i class="feather icon-camera"></i>
                                </div>
                            </div>

                            <h5 class="font-bold">{{ $data->nama }}</h5>
                            <p class="text-muted">{{ $data->jabatan }}</p>

                            <div class="m-t-30">
                                <a href="javascript:void(0)" data-toggle="modal" data-target=".modal-update"
                                    class="btn btn-outline-info btn-rounded mb-3">
                                    Update Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white bg-info">
                        <h4 class="m-b-0 text-white">Profile User {{ '#' . $data->id_user }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i class="icon-user text-primary mr-2"></i>
                                    Nama</label>
                                <div>{{ $data->nama }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i class="icon-star text-primary mr-2"></i>
                                    Jabatan</label>
                                <div>{{ $data->jabatan }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i class="icon-key text-primary mr-2"></i>
                                    Username</label>
                                <div>{{ $data->username }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i
                                        class="icon-envelope text-primary mr-2"></i>
                                    Email</label>
                                <div>{{ $data->email }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i
                                        class="icon-briefcase text-primary mr-2"></i>
                                    Entitas</label>
                                <div>{{ $data->namaPerusahaan->nama_perusahaan ?? '-' }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i
                                        class="icon-settings text-primary mr-2"></i>
                                    role</label>
                                <div>{{ $data->role }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header text-white bg-info">
                        <h4 class="m-b-0 text-white">Reset Password</h4>
                    </div>
                    <form method="post" action="{{ route('editPassword') }}" autocomplete="off">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="userID" value="{{ Crypt::encrypt($data->id_user) }}">

                            <div class="form-group">
                                <label>Password Baru <span class="text-danger">*</span></label>
                                <input type="password"
                                    class="form-control no-autofill @error('newPassword') is-invalid @enderror"
                                    name="newPassword" autocomplete="new-password" readonly
                                    onfocus="this.removeAttribute('readonly')">
                                @error('newPassword')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="newPassword_confirmation"
                                    autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly')">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-info">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-ubahFoto" tabindex="-1" role="dialog" aria-labelledby="ubahFotoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="uploadFotoForm" action="{{ route('updateFotoProfile') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold">Foto Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="userID" value="{{ Crypt::encrypt($data->id_user) }}">
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

    <form method="post" action="{{ action('UserController@update') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-update" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">UPDATE PROFILE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="userID" value="{{ Crypt::encrypt($data->id_user) }}">
                        <div class="form-row" style="display: none">
                            <div class="form-group col-md-6">
                                <label>Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username"
                                    value="{{ $data->username }}">
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ $data->email }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" value="{{ $data->nama }}">
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jabatan" value="{{ $data->jabatan }}">
                                @error('jabatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group" style="display: none">
                            <label>Entitas <span class="text-danger">*</span></label>
                            <select name="perusahaan" class="form-control pilihEntitas">
                                <option value="{{ $data->id_perusahaan }}">
                                    {{ $data->namaPerusahaan->nama_perusahaan ?? '-' }}</option>
                                @foreach ($dataPerusahaan as $perusahaan)
                                    <option value="{{ $perusahaan->id_perusahaan }}">{{ $perusahaan->nama_perusahaan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('perusahaan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row" style="display: none">
                            <div class="form-group col-md-6">
                                <label>Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control">
                                    <option>{{ $data->role }}</option>
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
                                    <option>Subsidiary</option>

                                </select>
                                @error('role')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" id="status">
                                    <option>{{ $data->status }}</option>
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
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 1,
                        crop(event) {
                            const canvas = cropper.getCroppedCanvas();
                            if (canvas) {
                                document.getElementById('croppedImageInput').value = canvas.toDataURL(
                                    'image/png');
                            }
                        }
                    });
                };
                reader.readAsDataURL(files[0]);
            }
        });

        logoForm.addEventListener('submit', function(e) {
            e.preventDefault(); // prevent default submit

            if (cropper) {
                cropper.getCroppedCanvas({
                    width: 300,
                    height: 300,
                }).toBlob((blob) => {
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
            $(this).find('.pilihEntitas').select2({
                dropdownParent: $('.modal-update'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Entitas --",
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
        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi tidak lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
