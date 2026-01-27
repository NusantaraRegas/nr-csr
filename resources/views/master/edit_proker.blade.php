@extends('layout.master')
@section('title', 'SHARE | Program Kerja')

@section('content')

    <div class="container">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor font-weight-bold">INPUT PROGRAM KERJA</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">Input Program Kerja</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form method="post" action="{{ action('ProkerController@store') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-info">
                                    <h4 class="m-b-0 text-white">Program Kerja</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Program Kerja <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" name="proker">{{ old('proker') }}</textarea>
                                        @if($errors->has('proker'))
                                            <small class="text-danger">Program kerja harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Prioritas</label>
                                        <select class="form-control" name="prioritas">
                                            <option>{{ old('prioritas') }}</option>
                                            <option>Pendidikan</option>
                                            <option>Lingkungan</option>
                                            <option>UMK</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Elemen BIaya <span class="text-danger">*</span></label>
                                        <select class="form-control" name="eb">
                                            <option>{{ old('eb') }}</option>
                                            <option>517</option>
                                            <option>518</option>
                                        </select>
                                        @if($errors->has('eb'))
                                            <small class="text-danger">Elemen biaya harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Tahun <span class="text-danger">*</span></label>
                                        <select class="form-control" name="tahun">
                                            <option>{{ old('tahun') }}</option>
                                            <option>2022</option>
                                            <option>2023</option>
                                            <option>2024</option>
                                        </select>
                                        @if($errors->has('tahun'))
                                            <small class="text-danger">Tahun anggaran harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Alokasi Anggaran <span class="text-danger">*</span></label>
                                        <input type="text" onkeypress="return hanyaAngka(event)"
                                               class="form-control"
                                               name="anggaran" id="anggaran" value="{{ old('anggaran') }}">
                                        @if($errors->has('anggaran'))
                                            <small class="text-danger">Alokasi anggaran harus
                                                diisi</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a href="{{ route('data-proker') }}" class="btn btn-secondary waves-effect">
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-success waves-effect">Simpan</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-info">
                                    <h4 class="m-b-0 text-white">Indikator SDGs</h4>
                                </div>
                                <div class="card-body">
                                    <button type="button" class="btn btn-sm btn-primary" data-target=".modal-proker" data-toggle="modal"><i
                                                class="fa fa-search mr-2"></i>Cari
                                    </button>
                                    <hr>
                                    <input type="hidden" class="form-control" name="indikatorID" id="indikatorID" readonly>
                                    <div class="form-group">
                                        <label>Pilar <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white" name="pilar" id="pilar"
                                               placeholder="Otomatis By System" readonly>
                                        @if($errors->has('pilar'))
                                            <small class="text-danger">Pilar harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>TPB <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white" name="tpb" id="tpb" placeholder="Otomatis By System"
                                               readonly>
                                        @if($errors->has('tpb'))
                                            <small class="text-danger">TPB harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Indikator <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white" name="kodeIndikator" placeholder="Otomatis By System"
                                               id="kodeIndikator" readonly>
                                        <textarea rows="3" class="form-control bg-white mt-2" name="indikator" placeholder="Otomatis By System"
                                                  id="indikator" readonly></textarea>
                                        @if($errors->has('indikator'))
                                            <small class="text-danger">Indikator harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-proker" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">INDIKATOR SDGs</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="example5 table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="10px" style="text-align:center;">No</th>
                                <th class="text-center" width="200px">Pilar</th>
                                <th class="text-center" width="200px">TPB</th>
                                <th class="text-center" width="400px">Indikator</th>
                                <th class="text-center" width="50px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dataIndikator as $data)
                                <tr>
                                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $data->pilar }}</td>
                                    <td>{{ $data->tpb }}</td>
                                    <td>
                                        <span class="font-weight-bold text-danger">{{ $data->kode_indikator }}</span><br>
                                        {{ $data->keterangan }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#!" class="pilih btn btn-sm btn-success"
                                           indikatorID="{{ $data->id_sub_pilar }}"
                                           pilar="{{ $data->pilar }}" tpb="{{ $data->tpb }}"
                                           kode="{{ $data->kode_indikator }}"
                                           indikator="{{ $data->keterangan }}">Pilih
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('footer')
    <script>
        $(document).on('click', '.pilih', function (e) {
            document.getElementById("indikatorID").value = $(this).attr('indikatorID');
            document.getElementById("pilar").value = $(this).attr('pilar');
            document.getElementById("tpb").value = $(this).attr('tpb');
            document.getElementById("kodeIndikator").value = $(this).attr('kode');
            document.getElementById("indikator").value = $(this).attr('indikator');
            $('.modal-proker').modal('hide');
        });
    </script>

    <script>
        var anggaran = document.getElementById('anggaran');
        anggaran.addEventListener('keyup', function (e) {
            anggaran.value = formatRupiah(this.value);
        });

        /* Fungsi */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        /* Fungsi */
        function convertToAngka(rupiah) {
            return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
        }
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop