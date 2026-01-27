@extends('layout.master_vendor')
@section('title', 'NR SHARE | Edit Project')

@section('content')
    <div class="pcoded-inner-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">
                                <b>Edit Project</b>
                            </h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Project List</a></li>
                            <li class="breadcrumb-item"><a href="#!">Edit Project</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-body">
            <div class="page-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="font-weight-bold">Edit Project</h5>
                            </div>
                            <form method="post" action="{{ action('PekerjaanController@update') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="pekerjaanID" value="{{ encrypt($data->pekerjaan_id) }}">
                                <input type="hidden" name="namaDokumen" value="KAK">
                                <div class="card-block">
                                    <div class="form-group row">
                                        <label for="namaPekerjaan" class="col-sm-3 col-form-label">Nama
                                            Proyek <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" autofocus class="form-control" name="namaPekerjaan"
                                                   id="namaPekerjaan"
                                                   value="{{ $data->nama_pekerjaan }}">
                                            @if($errors->has('namaPekerjaan'))
                                                <small class="text-danger">Nama proyek harus diisi</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="proker" class="col-sm-3 col-form-label">Ringkasan Pekerjaan <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="3"
                                                      name="ringkasan">{{ $data->ringkasan }}</textarea>
                                            @if($errors->has('ringkasan'))
                                                <small class="text-danger">Ringkasan pekerjaan harus diisi</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="proker" class="col-sm-3 col-form-label">Program Kerja <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="proker" id="proker">
                                                <option value="{{ $data->proker_id }}">{{ $data->proker }}</option>
                                                @foreach($dataProker as $proker)
                                                    <option value="{{ $proker->id_proker }}">{{ $proker->proker }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('proker'))
                                                <small class="text-danger">Program Kerja harus diisi</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="proker" class="col-sm-3 col-form-label">Perkiraan Biaya (Rp) <span class="text-danger">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" onkeypress="return hanyaAngka(event)"
                                                   class="form-control"
                                                   name="nilaiPerkiraan" id="nilaiPerkiraan"
                                                   value="{{ number_format($data->nilai_perkiraan,0,',','.') }}">
                                            @if($errors->has('nilaiPerkiraan'))
                                                <small class="text-danger">Nilai perkiraan harus diisi</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="proker" class="col-sm-3 col-form-label">Lampiran KAK</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="lampiran" value="{{ old('lampiran') }}"
                                                   accept="application/pdf">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a href="{{ route('indexPekerjaan') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-success font-weight-bold text-dark">Save
                                        Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var nilaiPerkiraan = document.getElementById('nilaiPerkiraan');
        nilaiPerkiraan.addEventListener('keyup', function (e) {
            nilaiPerkiraan.value = formatRupiah(this.value);
        });
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop
