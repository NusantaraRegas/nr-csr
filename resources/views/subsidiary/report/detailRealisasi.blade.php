@extends('layout.master_subsidiary')
@section('title', 'PGN SHARE | Detail Info Realisasi')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">DETAIL INFO REALISASI
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb model-huruf-family">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Detail Info Realisasi</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card model-huruf-family">
                    <div class="card-body p-b-0">
                        <h5 class="card-title font-weight-bold model-huruf-family">DETAIL REALISASI</h5>
                        <h6 class="card-subtitle mb-5 model-huruf-family">{{ $data->proker }}</h6>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home2" role="tab">REALISASI</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#yayasan" role="tab">PENERIMA MANFAAT</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="home2" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped m-b-0" width="10%">
                                    <tbody>
                                    <tr>
                                        <th class="pt-2 pb-2">
                                            Tanggal Realisasi
                                        </th>
                                        <td class="pt-2 pb-2">{{ date('d-m-Y', strtotime($data->tgl_realisasi)) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 pb-2" width="200px">
                                            Program Kerja
                                        </th>
                                        <td class="pt-2 pb-2">{{ $data->proker }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 pb-2" width="200px">
                                            Pilar
                                        </th>
                                        <td class="pt-2 pb-2">{{ $data->pilar }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 pb-2" width="250px">
                                            Gols
                                        </th>
                                        <td class="pt-2 pb-2">{{ $data->gols }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 pb-2" width="250px">
                                            Prioritas
                                        </th>
                                        <td class="pt-2 pb-2">
                                            @if($data->prioritas != "")
                                                {{ $data->prioritas }}
                                            @else
                                                Sosial/Ekonomi
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 pb-2" width="200px">
                                            Deskripsi Kegiatan
                                        </th>
                                        <td class="pt-2 pb-2">{{ $data->deskripsi }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 pb-2" width="200px">
                                            Wilayah
                                        </th>
                                        <td class="pt-2 pb-2">{{ $data->kabupaten.", " }}{{ $data->provinsi }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 pb-2" width="200px">
                                            Nominal Bantuan
                                        </th>
                                        <td class="pt-2 pb-2">
                                            {{ "Rp".number_format($data->nilai_bantuan,0,',','.') }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="yayasan" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped m-b-0" width="10%">
                                    <tbody>
                                    <tr>
                                        <th class="pt-2 pb-2" width="200px">
                                            Yayasan/Lembaga
                                        </th>
                                        <td class="pt-2 pb-2">{{ $data->nama_yayasan }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 pb-2" width="200px">
                                            Alamat
                                        </th>
                                        <td class="pt-2 pb-2">{{ $data->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 pb-2" width="200px">
                                            Penanggung Jawab
                                        </th>
                                        <td class="pt-2 pb-2">{{ $data->pic }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 pb-2" width="200px">
                                            Bertindak Sebagai
                                        </th>
                                        <td class="pt-2 pb-2">{{ $data->jabatan }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 pb-2" width="200px">
                                            No Telepon
                                        </th>
                                        <td class="pt-2 pb-2">{{ $data->no_telp }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-b-0">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title font-weight-bold mb-5 model-huruf-family">DOKUMENTASI</h5>
                            </div>
                            <div class="ml-auto">
                                <button type="button" data-toggle="modal" data-target=".modal-lampiran"
                                        class="btn btn-sm btn-success"><i class="fa fa-plus-circle mr-2"></i>Add
                                    File
                                </button>
                            </div>
                        </div>
                    </div>
                    @if($jumlahLampiran > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tbody>
                                @foreach($dataLampiran as $dl)
                                    <tr>
                                        <td class="pt-2 pb-2">{{ "Dokumentasi ".$loop->iteration }}</td>
                                        <td class="pt-2 pb-2">
                                            <a href="/attachment/{{ $dl->lampiran }}" data-toggle="tooltip"
                                               data-placement="bottom" title="Download"
                                               target="_blank"><i
                                                        class="fa fa-download text-info"
                                                        style="font-size: 18px"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-danger mr-3 ml-3">
                            File dokumentasi tidak ditemukan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

@stop