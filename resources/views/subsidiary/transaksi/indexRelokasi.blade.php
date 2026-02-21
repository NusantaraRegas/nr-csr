@extends('layout.master_subsidiary')
@section('title', 'NR SHARE | Relokasi Anggaran')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="model-huruf-family font-weight-bold">RELOKASI ANGGARAN TAHUN {{ $tahun }}
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Budget Control</li>
                        <li class="breadcrumb-item active">Relokasi Anggaran</li>
                    </ol>
                    <a href="{{ route('createRelokasiSubsidiary') }}" class="btn btn-info d-lg-block m-l-15">
                        <i class="fa fa-plus-circle mr-2"></i>Create New
                    </a>
                    <button type="button"
                            class="btn btn-secondary active ml-1 d-lg-block" data-toggle="collapse"
                            data-target="#collapseFilter"
                            aria-expanded="false"
                            aria-controls="collapseFilter"><i class="fa fa-filter"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="collapse" id="collapseFilter">
            <div class="row">
                <div class="col-12">
                    <form method="post" action="{{ action('ProkerController@cariPerusahaan') }}">
                        {{ csrf_field() }}
                        <div class="card">
                            <div class="card-body p-b-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-8">
                                                <select class="form-control" name="perusahaan" id="company"
                                                        style="width: 100%">
                                                    <option>{{ $comp }}</option>
                                                    @foreach($dataPerusahaan as $perusahaan)
                                                        <option>{{ $perusahaan->nama_perusahaan }}</option>
                                                    @endforeach
                                                    <option>Semua Perusahaan</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <select class="form-control" name="tahun" id="year" style="width: 100%">
                                                    <option>{{ $tahun }}</option>
                                                    <option>2021</option>
                                                    <option>2022</option>
                                                    <option>2023</option>
                                                    <option>Semua Tahun</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <button class="btn btn-success"><i class="fa fa-search mr-2"></i>Search
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($anggaran > 0)

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <h4 class="card-title mb-5 model-huruf-family">DAFTAR RELOKASI</h4>
                                </div>
                                <div class="ml-auto">
                                    @if($jumlahRelokasi > 0)
                                        <a href="#!" class="btn active btn-sm btn-secondary"><i
                                                    class="fa fa-file-text-o mr-2"></i>Export Excel</a>
                                        <a href="{{ route('printProker', $tahun) }}" target="_blank"
                                           class="btn active btn-sm btn-secondary"><i class="fa fa-print mr-2"></i>Print</a>
                                    @endif
                                </div>
                            </div>
                            @if($jumlahRelokasi > 0)
                                <div class="table-responsive">
                                    <table class="example5 table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center" width="10px">No</th>
                                            <th class="text-center" width="100px">Tanggal</th>
                                            <th width="500px">Sumber Anggaran</th>
                                            <th width="500px">Tujuan</th>
                                            <th width="50px" class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($dataRelokasi as $data)
                                            <?php
                                            $prokerAsal = \App\Models\Proker::where('id_proker', $data->proker_asal)->first();
                                            $prokerTujuan = \App\Models\Proker::where('id_proker', $data->proker_tujuan)->first();
                                            ?>
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center" nowrap>
                                                    {{ date('d-m-Y', strtotime($data->request_date)) }}<br>
                                                    <span class="text-muted">{{ date('H:i:s', strtotime($data->request_date)) }}</span>
                                                </td>
                                                <td>
                                                    <span class="font-weight-bold">{{ $prokerAsal->proker }}</span><br>
                                                    {{ number_format($data->nominal_asal,0,',','.')." - " }}<span class="text-danger">{{ number_format($data->nominal_relokasi,0,',','.') }}</span>{{ " = ".number_format($data->nominal_asal - $data->nominal_relokasi,0,',','.') }}
                                                </td>
                                                <td>
                                                    <span class="font-weight-bold">{{ $prokerTujuan->proker }}</span><br>
                                                    {{ number_format($data->nominal_tujuan,0,',','.')." + " }}<span class="text-danger">{{ number_format($data->nominal_relokasi,0,',','.') }}</span>{{ " = ".number_format($data->nominal_tujuan + $data->nominal_relokasi,0,',','.') }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)"
                                                           data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false"><i
                                                                    class="fa fa-gear font-18 text-info"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item edit-proker" href="#!"
                                                               data-id="{{ encrypt($data->id_relokasi) }}"
                                                               data-alokasi="{{ number_format($data->nominal_asal,0,',','.') }}"
                                                               data-tahun="{{ $data->tahun }}"
                                                               data-target=".modal-edit" data-toggle="modal"><i
                                                                        class="fa fa-pencil mr-2"></i>Edit</a>
                                                            <a class="dropdown-item delete"
                                                               data-id="{{ encrypt($data->id_relokasi) }}"
                                                               href="javascript:void(0)"><i
                                                                        class="fa fa-trash mr-2"></i>Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info mb-0">
                                    <h4 class="model-huruf-family"><i class="fa fa-info-circle"></i> Information</h4>
                                    Tidak ada relokasi anggaran di tahun {{ $tahun }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning mb-0">
                        <h4 class="model-huruf-family"><i class="fa fa-warning"></i> Warning</h4> Belum ada anggaran
                        yang
                        dibuat oleh {{ $comp }} di tahun {{ $tahun }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('footer')
    <script>
        $('.delete').click(function () {
            var proker_id = $(this).attr('data-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus data ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function () {
                    submitDelete("deleteRelokasi/" + proker_id + "");
                });
        });
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop