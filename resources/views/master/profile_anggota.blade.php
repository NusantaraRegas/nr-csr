@extends('layout.master')
@section('title', 'PGN SHARE | Profile Anggota')

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
                    <a href="{{ route('dataAnggota') }}" class="text-c-blue">
                        <i class="fa fa-arrow-circle-left text-info mr-1"></i>
                    </a>
                    PROFILE ANGGOTA
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Master Data</li>
                        <li class="breadcrumb-item">Komisi VI & VII</li>
                        <li class="breadcrumb-item active">Profile Anggota</li>
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

                            <h5 class="font-bold">{{ $data->nama_anggota }}</h5>
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
                        <h4 class="m-b-0 text-white">Profile Anggota {{ '#' . $data->id_anggota }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i class="icon-user text-primary mr-2"></i>
                                    Nama</label>
                                <div>{{ $data->nama_anggota }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i class="icon-star text-primary mr-2"></i>
                                    Jabatan</label>
                                <div>{{ $data->jabatan }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i class="icon-flag text-primary mr-2"></i>
                                    Fraksi</label>
                                <div>{{ $data->fraksi }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i class="icon-layers text-primary mr-2"></i>
                                    Komisi</label>
                                <div>{{ $data->komisi }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i class="icon-user text-primary mr-2"></i>
                                    Tenaga Ahli</label>
                                <div>{{ $data->staf_ahli }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block font-bold p-0 text-dark"><i class="icon-phone text-primary mr-2"></i>
                                    No HP</label>
                                <div>{{ $data->no_telp }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-ubahFoto" tabindex="-1" role="dialog" aria-labelledby="ubahFotoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="uploadFotoForm" action="{{ route('updateFotoAnggota') }}" method="POST"
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
                        <input type="hidden" name="anggotaID" value="{{ Crypt::encrypt($data->id_anggota) }}">
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

    <form method="post" action="{{ action('AnggotaController@update') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-update" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="myLargeModalLabel">UPDATE PROFILE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="anggotaID" value="{{ Crypt::encrypt($data->id_anggota) }}">
                        <input type="hidden" name="status" value="{{ $data->status }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama Anggota <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control"
                                    value="{{ $data->nama_anggota }}" required>
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <select class="form-control" name="jabatan" required>
                                    <option value="{{ $data->jabatan }}">{{ $data->jabatan }}</option>
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
                                    <option value="{{ $data->fraksi }}">{{ $data->fraksi }}</option>
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
                                    <option value="{{ $data->komisi }}">{{ $data->komisi }}</option>
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
                                    value="{{ $data->staf_ahli }}" required>
                                @error('tenagaAhli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>No HP <span class="text-danger">*</span></label>
                                <input type="tel" name="noTelp" class="form-control" value="{{ $data->no_telp }}"
                                    pattern="[0-9]{10,15}" maxlength="15" title="Isi nomor HP dengan angka 10–15 digit"
                                    required onkeypress="return hanyaAngka(event)">
                                @error('noTelp')
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
            $(this).find('.pilihPartai').select2({
                dropdownParent: $('.modal-update'), // penting untuk modal
                width: '100%',
                placeholder: "-- Pilih Fraksi --",
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
