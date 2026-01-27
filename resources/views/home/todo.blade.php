@extends('layout.master')
@section('title', 'SHARE | Tasklist')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="model-huruf-family font-weight-bold">TASKLIST</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Tasklist</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title model-huruf-family">My Tasks</h4>
                        <h6 class="card-subtitle mb-5 model-huruf-family">Create Survei Proposal</h6>
                        @if($jumlahData > 0)
                            <div class="table-responsive">
                                <table class="example5 table m-b-0 table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center" width="50px">No</th>
                                        <th width="200px">Disposisi</th>
                                        <th width="300px">Penerima Bantuan</th>
                                        <th width="200px">Wilayah</th>
                                        <th width="300px">Hasil Evaluasi</th>
                                        <th width="100px">Jenis</th>
                                        <th width="200px" nowrap>Dievaluasi Oleh</th>
                                        <th class="text-center" width="100px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataEvaluasi as $data)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td nowrap>
                                                <span class="font-weight-bold">
                                                    <a data-toggle="tooltip" data-placement="bottom"
                                                       title="Form Evaluasi"
                                                       target="_blank"
                                                       href="{{ route('form-evaluasi', $data->id_kelayakan) }}">{{ strtoupper($data->no_agenda) }}
                                                    </a>
                                                </span>
                                                <br>
                                                <span class="text-muted">{{ $data->pengirim }}</span><br>
                                                <span class="text-muted">{{ \App\Http\Controllers\tanggal_indo(date('Y-m-d', strtotime($data->tgl_terima))) }}</span><br>
                                                @if($data->sifat == 'Biasa')
                                                    <span class="badge badge-success">Biasa</span>
                                                @elseif($data->sifat == 'Segera')
                                                    <span class="badge badge-warning" style="color: black">Segera</span>
                                                @elseif($data->sifat == 'Amat Segera')
                                                    <span class="badge badge-danger">Amat Segera</span>
                                                @endif
                                            </td>
                                            <td>
                                                <b class="font-weight-bold text-uppercase">{{ $data->asal_surat }}</b><br>
                                                <span class="text-muted">{{ $data->deskripsi }}</span>
                                            </td>
                                            <td>
                                                <b class="font-weight-bold text-uppercase">{{ $data->provinsi }}</b><br>
                                                <span class="text-muted">{{ $data->kabupaten }}</span>
                                            </td>
                                            <td>
                                                @if($data->syarat == 'Survei')
                                                    <span class="font-weight-bold"><i
                                                                class="fa fa-check-circle text-success mr-1"></i>
                                                    Survei/Konfirmasi</span>
                                                @else
                                                    <span class="font-weight-bold"><i
                                                                class="fa fa-times-circle text-danger mr-1"></i>Tidak Memenuhi
                                                        Syarat</span>
                                                @endif
                                                <br>
                                                {{ $data->catatan1 }}
                                                <h4 class="model-huruf-family mt-0 text-danger font-weight-bold">{{ "Rp. ".number_format($data->nilai_bantuan,0,',','.') }}</h4>
                                            </td>
                                            <td>{{ $data->jenis }}</td>
                                            <td nowrap>
                                                <?php
                                                $evaluator1 = \App\Models\User::where('username', $data->evaluator1)->first();
                                                $evaluator2 = \App\Models\User::where('username', $data->evaluator2)->first();
                                                ?>
                                                <b class="font-weight-bold">{{ $evaluator1->nama }}</b>
                                                <br>
                                                <b class="font-weight-bold">{{ $evaluator2->nama }}</b>
                                            </td>
                                            <td class="text-center">
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                   title="Create Survei Proposal" href="{{ route('input-survei', encrypt($data->no_agenda)) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-success mb-0">
                                <h3 class="text-success model-huruf-family"><i class="fa fa-check-circle"></i> Completed
                                </h3> To-do list is complete
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

@stop