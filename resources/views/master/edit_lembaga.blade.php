@extends('layout.master')
@section('title', 'SHARE | Lembaga')

@section('content')

    <div class="container">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor font-bold text-uppercase">LEMBAGA</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">Lembaga</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form method="post" action="{{ action('LembagaController@update') }}">
                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="card-title mb-5">LEMBAGA ATAU YAYASAN</h5>
                                    <input type="hidden" autofocus class="form-control" name="lembagaID" value="{{ encrypt($data->id_lembaga) }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lembaga <span class="text-danger">*</span></label>
                                                <input type="text" autofocus class="form-control" name="namaLembaga" value="{{ $data->nama_lembaga }}">
                                                @if($errors->has('namaLembaga'))
                                                    <small class="text-danger">Nama lembaga harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alamat <span class="text-danger">*</span></label>
                                                <textarea class="form-control" rows="3" name="alamat">{{ $data->alamat }}</textarea>
                                                @if($errors->has('alamat'))
                                                    <small class="text-danger">Alamat harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h5 class="card-title mb-5 mt-5">PENANGGUNG JAWAB</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="pic"
                                                       value="{{ $data->nama_pic }}">
                                                @if($errors->has('pic'))
                                                    <small class="text-danger">Nama lembaga atau yayasan harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>No Telepon <span class="text-danger">*</span></label>
                                                <input type="text" onkeypress="return hanyaAngka(event)"
                                                       class="form-control"
                                                       name="noTelp" value="{{ $data->no_telp }}">
                                                @if($errors->has('noTelp'))
                                                    <small class="text-danger">No telepon harus
                                                        diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bertindak Sebagai <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="bertindakSebagai"
                                                       value="{{ $data->jabatan }}">
                                                @if($errors->has('bertindakSebagai'))
                                                    <small class="text-danger">Bertindak sebagai harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h5 class="card-title mb-5 mt-5">INFORMASI BANK</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No Rekening</label>
                                                <input type="text" maxlength="35" onkeypress="return hanyaAngka(event)"
                                                       class="form-control"
                                                       placeholder="Maksimal 35 Karakter" name="noRekening"
                                                       value="{{ $data->no_rekening }}">
                                                @if($errors->has('noRekening'))
                                                    <small class="text-danger">No rekening bank harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Atas Nama</label>
                                                <input type="text" maxlength="150" class="form-control"
                                                       placeholder="Maksimal 35 Karakter" name="atasNama" value="{{ $data->atas_nama }}">
                                                @if($errors->has('atasNama'))
                                                    <small class="text-danger">Atas nama bank harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('namaBank') ? ' ' : ''}}">
                                                <label>Nama Bank</label>
                                                <select class="form-control" name="namaBank" id="namaBank" style="width: 100%">
                                                    <option kodeBank="{{ $data->kode_bank }}">{{ $data->nama_bank }}</option>
                                                    @foreach($dataBank as $bank)
                                                        <option kodeBank="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" readonly class="form-control" name="kodeBank" id="kodeBank">
                                                @if($errors->has('namaBank'))
                                                    <small class="text-danger">Nama bank harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Kota Bank <span class="text-danger">*</span></label>
                                                <select class="form-control" name="kota" id="kota"
                                                        style="width: 100%">
                                                    <option kodeKota="{{ $data->kode_kota }}">{{ $data->kota_bank }}</option>
                                                    @foreach($dataCity as $city)
                                                        <option kodeKota="{{ $city['city_code'] }}">{{ $city['city_name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" readonly class="form-control" name="kodeKota" id="kodeKota">
                                                @if($errors->has('kota'))
                                                    <small class="text-danger">Bank city harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Cabang</label>
                                                <input maxlength="35" type="text"
                                                       class="form-control"
                                                       placeholder="Maksimal 35 Karakter" name="cabang" value="{{ $data->cabang }}">
                                                @if($errors->has('cabang'))
                                                    <small class="text-danger">Cabang bank harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <a href="{{ route('dashboard') }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        Batal
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-success waves-effect text-left"><i
                                            class="fa fa-save mr-2"></i>Ubah
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            $("#namaBank").select2({
                placeholder: "Pilih Bank"
            });

            $("#kota").select2({
                placeholder: "Pilih Kota"
            });
        });

        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true, progressBar: true});
        @endif
    </script>

    <script>
        $('#namaBank').on('change', function () {
            var kodeBank = $('#namaBank option:selected').attr('kodeBank');
            $('#kodeBank').val(kodeBank);
        });

        $('#kota').on('change', function () {
            var kodeKota = $('#kota option:selected').attr('kodeKota');
            $('#kodeKota').val(kodeKota);
        });
    </script>
@stop