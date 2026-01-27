@extends('layout.master')
@section('title', 'SHARE | SPK')
<?php
$tanggalmenit = date("Y-m-d H:i:s");
$tgl = date("Y-m-d");

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

//$tglSurat = date('Y-m-d', strtotime($data->tgl_surat));
?>
@section('content')

    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-uppercase">Surat Perintah Kerja</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">SPK</li>
                    </ol>
                    @if($data->header1 == '' or $data->header2 == '' or $data->header3 == '')
                        <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal"
                                data-target=".modal-table">Create Tabel Rincian
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <form method="post" action="{{ action('SPKController@editSPK') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white">EDIT SPK</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Nomor Surat Perintah Kerja</label>
                                        <input type="hidden" class="form-control text-uppercase bg-white"
                                               name="noAgenda"
                                               value="{{ $data->no_agenda }}" readonly>
                                        <input type="text" class="form-control text-uppercase" name="noSPK"
                                               value="{{ $data->no_spk }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('tglSPK') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Tanggal SPK</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker-autoclose text-uppercase"
                                                   name="tglSPK" value="{{ date('d-M-Y', strtotime($data->tgl_spk)) }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('judulKegiatan') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Judul Kegiatan <span
                                                    class="text-danger">*</span></label>
                                        <textarea rows="3" maxlength="200" class="form-control text-capitalize"
                                                  name="judulKegiatan">{{ $data->kegiatan }}</textarea>
                                    </div>
                                    <div class="form-group {{ $errors->has('nama') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Nama Penyedia Barang/Jasa <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white text-capitalize" name="nama"
                                               value="{{ $data->nama }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('jabatan') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Jabatan Penyedia Barang/Jasa <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white text-capitalize" name="jabatan"
                                               value="{{ $data->jabatan }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('perusahaan') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Perusahaan Penyedia Barang/Jasa <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white text-capitalize"
                                               name="perusahaan"
                                               value="{{ $data->perusahaan }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('alamat') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Alamat <span
                                                    class="text-danger">*</span></label>
                                        <textarea rows="3" maxlength="500" class="form-control bg-white text-capitalize"
                                                  name="alamat">{{ $data->alamat }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group  {{ $errors->has('noPenawaran') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Nomor Surat Penawaran <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white text-uppercase"
                                               name="noPenawaran"
                                               value="{{ $data->no_penawaran }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('tglPenawaran') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Tanggal Surat Penawaran</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker-autoclose text-uppercase"
                                                   name="tglPenawaran"
                                                   value="{{ date('d-M-Y', strtotime($data->tgl_penawaran)) }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('noBAST') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Nomor BA Klarifikasi dan Negosiasi <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white text-uppercase" name="noBAST"
                                               value="{{ $data->no_berita_acara }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('tglBAST') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Tanggal BA Klarifikasi dan Negosiasi <span
                                                    class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker-autoclose text-uppercase"
                                                   name="tglBAST"
                                                   value="{{ date('d-M-Y', strtotime($data->tgl_berita_acara)) }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('nilaiPengadaan') ? ' has-danger' : ''}}">
                                        <label>Nilai Pengadaan <span class="text-danger">*</span></label>
                                        <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                               id="nilaiRupiah" value="{{ number_format($data->nominal,2,',','.') }}">
                                        <input type="hidden" class="form-control" value="{{ $data->nominal }}"
                                               name="nilaiPengadaan" id="nilaiPengadaan">
                                    </div>
                                    <div class="form-group {{ $errors->has('termin') ? ' has-danger' : ''}}">
                                        <label>Termin Pembayaran <span class="text-danger">*</span></label>
                                        <select onchange="bukaTermin()" id="selectTermin"
                                                class="form-control bukaTermin"
                                                name="termin">
                                            <option value="{{ $data->termin }}">{{ $data->termin }}</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                    <div class="form-group {{ $errors->has('termin1') ? ' has-danger' : ''}}">
                                        <label>Nominal <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control termin1"
                                               value="{{ number_format($data->rupiah1,2,',','.') }}"
                                               name="termin1" id="termin1" placeholder="Tahap 1"
                                               style="margin-bottom: 5px;">
                                        <input type="hidden" class="form-control"
                                               name="rupiah1" id="rupiah1" value="{{ $data->rupiah1 }}">
                                        <input type="text"
                                               class="form-control termin2"
                                               value="{{ number_format($data->rupiah2,2,',','.') }}"
                                               name="termin2" id="termin2" placeholder="Tahap 2"
                                               style="margin-bottom: 5px;">
                                        <input type="hidden" class="form-control"
                                               name="rupiah2" id="rupiah2" value="{{ $data->rupiah2 }}">
                                        <input type="text"
                                               class="form-control termin3"
                                               value="{{ number_format($data->rupiah3,2,',','.') }}"
                                               name="termin3" id="termin3" placeholder="Tahap 3"
                                               style="margin-bottom: 5px;">
                                        <input type="hidden" class="form-control" value="{{ $data->rupiah3 }}"
                                               name="rupiah3" id="rupiah3">
                                        <input type="text"
                                               class="form-control termin4"
                                               value="{{ number_format($data->rupiah4,2,',','.') }}"
                                               name="termin4" id="termin4" placeholder="Tahap 4">
                                        <input type="hidden" class="form-control" value="{{ $data->rupiah4 }}"
                                               name="rupiah4" id="rupiah4">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('pengadilan') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Pengadilan Negeri <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white text-capitalize"
                                               name="pengadilan"
                                               value="{{ $data->nama_pengadilan }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('tglBatasWaktu') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Tanggal Batas Waktu <span
                                                    class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker-autoclose text-uppercase"
                                                   name="tglBatasWaktu"
                                                   value="{{ date('d-M-Y', strtotime($data->due_date)) }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('namaBank') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Nama Bank <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="namaBank"
                                               value="{{ $data->nama_bank }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('noRekening') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">No Rekening <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                               name="noRekening"
                                               value="{{ $data->no_rekening }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('atasNama') ? 'has-danger' : '' }}">
                                        <label class="form-control-label">Atas Nama <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control text-uppercase" name="atasNama"
                                               value="{{ $data->atas_nama }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('cabang') ? 'has-danger' : '' }}">
                                        <label class="form-control-label">Cabang <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control text-uppercase" name="cabang"
                                               value="{{ $data->cabang }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('namaPejabat') ? 'has-danger' : '' }} {{ $errors->has('jabatanPejabat') ? 'has-danger' : '' }} {{ $errors->has('noPelimpahan') ? 'has-danger' : '' }} {{ $errors->has('tglPelimpahan') ? 'has-danger' : '' }}">
                                        <label class="form-control-label">Pejabat Yang Menyetujui <span
                                                    class="text-danger">*</span></label>
                                        <select onchange="bukaJabatan()" id="namaPejabat"
                                                class="form-control bukaJabatan"
                                                name="namaPejabat">
                                            <option>{{ $data->nama_pejabat }}</option>
                                            <option>Anak Agung Raka Haryana</option>
                                            <option>Erick Taufan</option>
                                            <option>Tubagus Nurcholis</option>
                                        </select>
                                        <input type="text" class="form-control m-t-5 text-capitalize bg-white"
                                               placeholder="Jabatan" style="color: black"
                                               name="jabatanPejabat" id="jabatanPejabat"
                                               value="{{ $data->jabatan_pejabat }}" readonly>
                                    </div>

                                    <table></table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <button type="submit" class="btn btn-success waves-effect text-left"><i
                                            class="fa fa-check"></i> Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white text-uppercase">Tabel Rincian
                            <button class="btn btn-sm btn-rounded btn-secondary pull-right" data-toggle="modal"
                                    data-target=".modal-tambah">Add Column
                            </button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th width="10px" style="text-align:center;">NO</th>
                                    <th width="300px">{{ strtoupper($data->header1) }}</th>
                                    <th width="150px">{{ strtoupper($data->header2) }}</th>
                                    <th width="150px">{{ strtoupper($data->header3) }}</th>
                                    <th width="100px">ACTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataDetailSPK as $dataDetail)
                                    <tr>
                                        <th class="text-center">{{ $loop->iteration }}</th>
                                        <th>{{ $dataDetail->column1 }}</th>
                                        <th>{{ $dataDetail->column2 }}</th>
                                        <th>{{ $dataDetail->column3 }}</th>
                                        <th>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('ubah-spk', encrypt($data->no_agenda)) }}">
                                                <i class="fa fa-pencil" style="font-size: 18px"></i>
                                            </a>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Delete" href="#!" class="deleteBAST"
                                               no-agenda="{{ encrypt($data->no_agenda) }}"><i
                                                        class="fa fa-trash text-danger"
                                                        style="font-size: 18px"></i>
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
    </div>

    <form method="post" action="{{ action('SPKController@insertHeader') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-table" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">HEADER TABLE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control form-control-line" name="noAgenda"
                               value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group {{ $errors->has('header1') ? ' has-danger' : ''}}">
                            <input maxlength="50" type="text" class="form-control form-control-line" name="header1"
                                   placeholder="Header 1"/>
                        </div>
                        <div class="form-group {{ $errors->has('header2') ? ' has-danger' : ''}}">
                            <input maxlength="50" type="text" class="form-control form-control-line" name="header2"
                                   placeholder="Header 2"/>
                        </div>
                        <div class="form-group m-b-0 {{ $errors->has('header2') ? ' has-danger' : ''}}">
                            <input maxlength="50" type="text" class="form-control form-control-line" name="header3"
                                   placeholder="Header 3"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    <form method="post" action="{{ action('SPKController@insertDetailSPK') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-tambah" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">ADD COLUMN</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control form-control-line" name="noAgenda"
                               value="{{ encrypt($data->no_agenda) }}">
                        <div class="form-group {{ $errors->has('header1') ? ' has-danger' : ''}}">
                            <label class="form-control-label">{{ $data->header1 }}</label>
                            <input maxlength="200" type="text" class="form-control form-control-line" name="header1"
                                   placeholder=""/>
                        </div>
                        <div class="form-group {{ $errors->has('header2') ? ' has-danger' : ''}}">
                            <label class="form-control-label">{{ $data->header2 }}</label>
                            <input maxlength="200" type="text" class="form-control form-control-line" name="header2"
                                   placeholder=""/>
                        </div>
                        <div class="form-group m-b-0 {{ $errors->has('header2') ? ' has-danger' : ''}}">
                            <label class="form-control-label">{{ $data->header3 }}</label>
                            <input maxlength="200" type="text" class="form-control form-control-line" name="header3"
                                   placeholder=""/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i
                                        class="fa fa-check"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            $("#namaBank").select2({
                placeholder: "Pilih Nama Bank"
            });
        });
    </script>

    <script>
        function bukaJabatan() {
            var x = document.getElementById("namaPejabat").value;
            if (x == 'Erick Taufan') {
                document.getElementById("jabatanPejabat").value = 'PH Division Head Corporate Social Responsibility';
            }
            if (x == 'Tubagus Nurcholis') {
                document.getElementById("jabatanPejabat").value = 'PH Division Head Corporate Social Responsibility';
            }
            if (x == 'Anak Agung Raka Haryana') {
                document.getElementById("jabatanPejabat").value = 'Division Head Corporate Social Responsibility';
            }
        }
    </script>

    <script>
        var nilai = '';

        function bukaTermin() {
            var x = document.getElementById("selectTermin").value;
            if (x == 1) {
                $(".termin1").show();
                $(".termin2").hide();
                $(".termin3").hide();
                $(".termin4").hide();
            }
            if (x == 2) {
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").hide();
                $(".termin4").hide();
            }
            if (x == 3) {
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").show();
                $(".termin4").hide();
            }
            if (x == 4) {
                $(".termin1").show();
                $(".termin2").show();
                $(".termin3").show();
                $(".termin4").show();
            }
        }
    </script>

    <script>
        var nilaiRupiah = document.getElementById('nilaiRupiah');
        nilaiRupiah.addEventListener('keyup', function (e) {
            nilaiRupiah.value = formatRupiah(this.value);
            nilaiPengadaan.value = convertToAngka(this.value);
        });

        var termin1 = document.getElementById('termin1');
        termin1.addEventListener('keyup', function (e) {
            termin1.value = formatRupiah(this.value);
            rupiah1.value = convertToAngka(this.value);
        });

        var termin2 = document.getElementById('termin2');
        termin2.addEventListener('keyup', function (e) {
            termin2.value = formatRupiah(this.value);
            rupiah2.value = convertToAngka(this.value);
        });

        var termin3 = document.getElementById('termin3');
        termin3.addEventListener('keyup', function (e) {
            termin3.value = formatRupiah(this.value);
            rupiah3.value = convertToAngka(this.value);
        });

        var termin4 = document.getElementById('termin4');
        termin4.addEventListener('keyup', function (e) {
            termin4.value = formatRupiah(this.value);
            rupiah4.value = convertToAngka(this.value);
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
        toastr.error('Data belum lengkap', 'Peringatan', {closeButton: true});
        @endif
    </script>
@stop