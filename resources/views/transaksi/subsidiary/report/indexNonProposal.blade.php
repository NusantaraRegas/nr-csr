@extends('layout.master_subsidiary')
@section('title', 'PGN SHARE | Laporan Realisasi Non Proposal')

@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

    <?php
    function tanggal_indo($tanggal)
    {
        $bulan = array(1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }
    ?>

    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold model-huruf-family">HISTORY REALISASI NON PROPOSAL
                    <br>
                    <small class="text-danger">{{ $comp }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb model-huruf-family">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">History</li>
                        <li class="breadcrumb-item active">Realisasi Non Proposal</li>
                    </ol>
                    <a href="{{ route('createNonProposalSubsidiary') }}" class="btn btn-info d-lg-block m-l-15"><i
                                class="fa fa-plus-circle mr-2"></i>Create New
                    </a>
                    <div class="btn-group">
                        <a href="#!" class="btn btn-secondary d-lg-block ml-1" data-target=".modalFilterTanggal"
                           data-toggle="modal"><i class="fa fa-filter mr-2"></i>Filter</a>
                        <button type="button"
                                class="btn btn-secondary dropdown-toggle dropdown-toggle-split active"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#!" data-target=".modalFilterMonthly"
                               data-toggle="modal">Monthly</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterAnnual"
                               data-toggle="modal">Annual</a>
                            <a class="dropdown-item" href="#!" data-target=".modalFilterTanggal"
                               data-toggle="modal">Custom Range</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('dataKelayakan') }}">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card model-huruf-family">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h4 class="card-title model-huruf-family mb-1">TOTAL REALISASI</h4>
                                <h3 class="card-subtitle mb-5 text-dark font-weight-bold">{{ "Rp".number_format($total,0,',','.') }}
                                    <span class="model-huruf-family ml-2">({{ $persen."%" }})</span></h3>
                            </div>
                            <div class="ml-auto">
                                @if($jumlahData > 0)
                                    <a href="{{ route('exportRealisasiProposalSubsidiary', ['year' => $tahun, 'company' => $comp]) }}" class="btn btn-sm active btn-secondary"><i
                                                class="fa fa-file-text-o mr-2"></i>Export
                                        Excel</a>
                                    <a href="{{ route('printRealisasiProposalSubsidiary', ['year' => $tahun, 'company' => $comp]) }}" target="_blank" class="btn btn-sm active btn-secondary"><i
                                                class="fa fa-print mr-2"></i>Print</a>
                                @endif
                            </div>
                        </div>
                        @if($jumlahData > 0)
                            <div class="table-responsive">
                                <table class="example5 table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center font-weight-bold" width="50px">No</th>
                                        <th class="text-center font-weight-bold" width="100px">Tanggal</th>
                                        <th class="text-center font-weight-bold" width="200px" nowrap>Program Kerja</th>
                                        <th class="text-center font-weight-bold" width="300px">Penerima Bantuan</th>
                                        <th class="text-center font-weight-bold" width="200px">Wilayah</th>
                                        <th class="text-center font-weight-bold" width="150px">Bantuan</th>
                                        <th class="text-center font-weight-bold" width="100px">Status</th>
                                        <th class="text-center font-weight-bold" width="50px">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataRealisasi as $data)
                                        <tr>
                                            <td style="text-align:center;">{{ $loop->iteration }}</td>
                                            <td class="text-center" nowrap>{{ date('d-m-Y', strtotime($data->tgl_realisasi)) }}</td>
                                            <td>{{ $data->proker }}</td>
                                            <td>
                                                <b class="font-weight-bold text-uppercase">{{ $data->nama_yayasan }}</b><br>
                                                <span class="text-muted">{{ $data->deskripsi }}</span>
                                            </td>
                                            <td>
                                                <b class="font-weight-bold">{{ $data->provinsi }}</b><br>
                                                <span class="text-muted">{{ $data->kabupaten }}</span>
                                            </td>
                                            <td class="text-right" nowrap>
                                                {{ number_format($data->nilai_bantuan,0,',','.') }}
                                            </td>
                                            <td class="text-center" nowrap>
                                                @if($data->status == 'In Progress')
                                                    <span class="badge badge-warning"
                                                          style="color: black">In Progress</span>
                                                @elseif($data->status == 'Paid')
                                                    <span class="badge badge-success">Paid</span>
                                                @endif
                                            </td>
                                            <td class="text-center" nowrap>
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)"
                                                       data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false"><i
                                                                class="fa fa-gear font-18 text-info"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         style="font-size: 13px">
                                                        <a class="dropdown-item"
                                                           href="javascript:void(0)"><i
                                                                    class="fa fa-info-circle mr-2"></i>Detail
                                                            Info</a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('editNonProposalSubsidiary', encrypt($data->id_realisasi)) }}"><i class="fa fa-pencil mr-2"></i>Edit</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item delete"
                                                           data-id="{{ encrypt($data->id_realisasi) }}"
                                                           href="javascript:void(0)"><i class="fa fa-trash mr-2"></i>Delete</a>
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
                                <h3 class="text-info model-huruf-family"><i class="fa fa-info-circle"></i> Information
                                </h3> Realisasi proposal tidak ditemukan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('RealisasiSubsidiaryController@postRealisasiProposalAnnual') }}">
        {{ csrf_field() }}
        <div class="modal fade modalFilterAnnual" tabindex="-1" role="dialog" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold model-huruf-family"><i class="fa fa-filter mr-2"></i>Annual
                            Report</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tahun <span
                                            class="text-danger">*</span></label>
                                <select class="form-control" name="tahun">
                                    <option value="" disabled selected>Pilih Tahun</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                </select>
                                @if($errors->has('tahun'))
                                    <small class="text-danger">Tahun harus diisi</small>
                                @endif
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input openWilayah" onchange="openWilayah()"
                                   id="checkBookWilayah" name="checkBookWilayah" style="cursor: pointer">
                            <label class="custom-control-label" for="checkBookWilayah"
                                   style="cursor: pointer">Wilayah</label>
                        </div>
                        <div class="wilayah" style="display: none">
                            <div class="form-group mb-3">
                                <label>Provinsi <span
                                            class="text-danger">*</span></label>
                                <select class="form-control mb-2" name="provinsi"
                                        id="provinsi">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach($dataProvinsi as $provinsi)
                                        <option value="{{ ucwords($provinsi->provinsi) }}">{{ ucwords($provinsi->provinsi) }}</option>
                                    @endforeach
                                </select>
                                <select class="form-control" name="kabupaten"
                                        id="kabupaten">
                                </select>
                                @if($errors->has('provinsi'))
                                    <small class="text-danger mt-0">Wilayah harus
                                        diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect text-left"><i
                                    class="fa fa-search mr-2"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        function openWilayah() {
            if ($('.openWilayah').is(":checked")) {
                $(".wilayah").show();
            } else {
                $(".wilayah").hide();
            }
        }
    </script>

    <script>
        $(document).ready(function () {
            $('#provinsi').change(function () {
                var provinsi_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupatenPencarian/" + provinsi_id + "",
                    success: function (response) {
                        $('#kabupaten').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        $('.delete').click(function () {
            var data_id = $(this).attr('data-id');
            swal({
                    title: "Yakin?",
                    text: "Anda akan menghapus data realisasi ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-secondary",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function () {
                    window.location = "deleteRealisasi/" + data_id + "";
                });
        });
    </script>

    <script>
        @if(Session::has('gagalMenemukan'))
        toastr.error('{{Session::get('gagalMenemukan')}}', 'Failed', {closeButton: true});
        @endif

        @if (count($errors) > 0)
        toastr.error('Lengkapi parameter pencarian data anda', 'Failed', {closeButton: true});
        @endif
    </script>
@stop