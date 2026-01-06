@extends('layout.master')
@section('title', 'SHARE | Edit Informasi Bank')

@section('content')

    <div class="container">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor font-bold text-uppercase">EDIT INFORMASI BANK</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Informasi Bank</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form method="post" action="{{ action('KelayakanController@editBank') }}">
                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-5">INFORMASI BANK</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No Rekening <span class="text-danger">*</span></label>
                                        <input type="hidden" class="form-control" name="nomor"
                                               value="{{ encrypt($data->no_agenda) }}">
                                        <input type="text" maxlength="35" onkeypress="return hanyaAngka(event)"
                                               class="form-control"
                                               placeholder="Maksimal 35 Karakter" name="noRekening"
                                               value="{{ $data->no_rekening }}">
                                        @if($errors->has('noRekening'))
                                            <small class="text-danger">No rekening harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Atas Nama <span class="text-danger">*</span></label>
                                        <input type="text" maxlength="150" class="form-control"
                                               placeholder="Maksimal 35 Karakter" name="atasNama" value="{{ $data->atas_nama }}">
                                        @if($errors->has('atasNama'))
                                            <small class="text-danger">Atas nama harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('namaBank') ? ' ' : ''}}">
                                        <label>Nama Bank <span class="text-danger">*</span></label>
                                        <select class="form-control" name="namaBank" id="namaBank" style="width: 100%">
                                            <option kodeBank="{{ $data->kode_bank }}">{{ $data->nama_bank }}</option>
                                            @foreach($dataBank as $bank)
                                                <option kodeBank="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" readonly class="form-control mt-2" value="{{ $data->kode_bank }}" name="kodeBank" id="kodeBank">
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
                                        <input type="text" value="{{ $data->kode_kota }}" readonly class="form-control mt-2" name="kodeKota" id="kodeKota">
                                        @if($errors->has('kota'))
                                            <small class="text-danger">Kota bank harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Cabang <span class="text-danger">*</span></label>
                                        <input maxlength="35" type="text"
                                               class="form-control"
                                               placeholder="Maksimal 35 Karakter" name="cabang" value="{{ $data->cabang_bank }}">
                                        @if($errors->has('cabang'))
                                            <small class="text-danger">Cabang bank harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <a href="{{ route('detail-kelayakan', encrypt($data->no_agenda)) }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        <i class="fa fa-times-circle mr-2"></i>Batal
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-success waves-effect text-left"><i
                                            class="fa fa-save mr-2"></i>Simpan Perubahan
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
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
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