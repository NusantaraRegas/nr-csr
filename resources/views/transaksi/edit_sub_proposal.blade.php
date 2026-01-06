@extends('layout.master')
@section('title', 'SHARE | Sub Proposal Idul Adha')

@section('content')

    <div class="container">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-uppercase font-bold">SUB PROPOSAL IDUL ADHA</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item"><a href="{{ route('detail-kelayakan', encrypt($noAgenda)) }}">Proposal</a></li></li>
                        <li class="breadcrumb-item active">Sub Proposal Idul Adha</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form method="post" action="{{ action('SubProposalController@update') }}">
                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white">FORM SUB PROPOSAL</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No Agenda <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="noAgenda" value="{{ $noAgenda }}" readonly>
                                        <input type="hidden" class="form-control" name="proposalID" value="{{ encrypt($data->id_sub_proposal) }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Ketua <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="namaKetua" value="{{ $data->nama_ketua }}">
                                        @if($errors->has('namaKetua'))
                                            <small class="text-danger">Nama ketua harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Lembaga <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="namaLembaga" value="{{ $data->nama_lembaga }}">
                                        @if($errors->has('namaLembaga'))
                                            <small class="text-danger">Nama lembaga harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Kambing <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="number" class="form-control" value="{{ $data->kambing }}" name="kambing">
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" name="hargaKambing">
                                                    <option>{{ $data->harga_kambing }}</option>
                                                    <option>3.500.000</option>
                                                    <option>4.000.000</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if($errors->has('kambing'))
                                            <small class="text-danger">Jumlah kambing harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Sapi <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="number" class="form-control" value="{{ $data->sapi }}" name="sapi">
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" name="hargaSapi">
                                                    <option>{{ $data->harga_sapi }}</option>
                                                    <option>25.000.000</option>
                                                    <option>27.500.000</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if($errors->has('sapi'))
                                            <small class="text-danger">Jumlah sapi harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Alamat <span
                                                    class="text-danger">*</span></label>
                                        <textarea rows="3" maxlength="200" class="form-control"
                                                  placeholder=""
                                                  name="alamat">{{ $data->alamat }}</textarea>
                                    </div>
                                    <div class="form-group {{ $errors->has('provinsi') ? 'has-danger' : ''}}">
                                        <label>Provinsi <span
                                                    class="text-danger">*</span></label>
                                        <select class="select2 form-control" name="provinsi" id="provinsi"
                                                style="width: 100%; height:36px;">
                                            <option value="{{ $data->provinsi }}">{{ $data->provinsi }}</option>
                                            @foreach($dataProvinsi as $provinsi)
                                                <option value="{{ ucwords($provinsi->provinsi) }}">{{ ucwords($provinsi->provinsi) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group {{ $errors->has('kabupaten') ? 'has-danger' : ''}}">
                                        <label>Kabupaten/Kota <span
                                                    class="text-danger">*</span></label>
                                        <select class="form-control" name="kabupaten"
                                                id="kabupaten"
                                                style="width: 100%; height:36px; margin-top: 5px">
                                            <option value="{{ $data->kabupaten }}">{{ $data->kabupaten }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <a href="{{ route('dataSubProposal', encrypt($noAgenda)) }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        Batal
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
            $('#provinsi').change(function () {
                var provinsi_id = $(this).val();

                $("#kabupaten").select2({
                    placeholder: "Pilih Kabupaten/Kota"
                });

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupaten/" + provinsi_id + "",
                    success: function (response) {
                        $('#kabupaten').html(response);
                        $("#kabupaten").prop("disabled", false);
                    }
                });
            })
        })
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true, progressBar: true});
        @endif
    </script>

@stop