@extends('layout.master')
@section('title', 'SHARE | BAST')
<?php
use App\Models\User;
date_default_timezone_set("Asia/Bangkok");
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

$tglSurat = date('Y-m-d', strtotime($data->tgl_surat));
?>
@section('content')

    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-uppercase">Berita Acara Serah Terima</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">BAST</li>
                    </ol>
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
                <form method="post" action="{{ action('BASTController@insertBASTDana') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white">FORM BAST</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Nomor Pihak Pertama</label>
                                        <input type="hidden" class="form-control text-uppercase bg-white"
                                               name="noAgenda"
                                               value="{{ $data->no_agenda }}" readonly>
                                        <input type="text" class="form-control text-uppercase" name="noBAST">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Nomor Pihak Kedua</label>
                                        <input type="text" class="form-control text-uppercase" name="noPihakKedua">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Tanggal BAST</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker-autoclose text-uppercase"
                                                   name="tglBAST">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Pilar</label>
                                        <input class="form-control bg-white" name="pilar"
                                               value="{{ $data->pilar }}" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('bantuanUntuk') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Bantuan Untuk <span
                                                    class="text-danger">*</span></label>
                                        <textarea rows="3" maxlength="200" class="form-control text-capitalize"
                                                  name="bantuanUntuk">{{ $data->bantuan_untuk }}</textarea>
                                    </div>
                                    <div class="form-group {{ $errors->has('proposalDari') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Surat/Proposal Dari <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white text-capitalize" name="proposalDari"
                                               value="{{ $data->asal_surat }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('alamat') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Alamat <span
                                                    class="text-danger">*</span></label>
                                        <textarea rows="3" maxlength="500" class="form-control bg-white text-capitalize"
                                                  name="alamat">{{ $data->alamat }}</textarea>
                                    </div>
                                    <div class="form-group {{ $errors->has('provinsi') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Provinsi <span
                                                    class="text-danger">*</span></label>
                                        <select class="form-control" name="provinsi" id="provinsi">
                                            <option>{{ $data->provinsi }}</option>
                                            @foreach($dataProvinsi as $provinsi)
                                                <option>{{ $provinsi->provinsi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group {{ $errors->has('kabupaten') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Kota/Kabupaten <span
                                                    class="text-danger">*</span></label>
                                        <select class="form-control" name="kabupaten"
                                                id="kabupaten">
                                            <option>{{ $data->kabupaten }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group  {{ $errors->has('penanggungJawab') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Penanggung Jawab <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white text-capitalize" name="penanggungJawab"
                                               value="{{ $data->pengaju_proposal }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('bertindakSebagai') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Bertindak Sebagai <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white text-capitalize" name="bertindakSebagai"
                                               value="{{ $data->sebagai }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('noSurat') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">No Surat/Proposal <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white text-uppercase" name="noSurat"
                                               value="{{ $data->no_surat }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('tglSurat') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Tanggal Surat/Proposal <span
                                                    class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker-autoclose text-uppercase"
                                                   name="tglSurat"
                                                   value="{{ date('d-M-Y', strtotime($data->tgl_surat)) }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('perihal') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Perihal <span
                                                    class="text-danger">*</span></label>
                                        <textarea rows="3" maxlength="100" class="form-control bg-white text-capitalize"
                                                  name="perihal">{{ $data->perihal }}</textarea>
                                    </div>
                                    <div class="form-group {{ $errors->has('pihakKedua') ? 'has-danger' : ''}}">
                                        <label class="form-control-label">Penanggung Jawab Pihak Kedua Berdasarkan <span
                                                    class="text-danger">*</span></label>
                                        <textarea rows="3" maxlength="500" class="form-control bg-white text-capitalize"
                                                  name="pihakKedua">{{ old('pihakKedua') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @if($data->bantuan_berupa == 'Dana')
                                        <div class="form-group {{ $errors->has('nilaiBantuan') ? 'has-danger' : ''}}">
                                            <label class="form-control-label">Nilai Bantuan</label>
                                            <input type="text" class="form-control bg-white" name="nilaiBantuan"
                                                   value="{{ number_format($data->nilai_approved,2,',','.') }}"
                                                   readonly>
                                        </div>
                                        <div class="form-group {{ $errors->has('termin') ? 'has-danger' : ''}}">
                                            <label class="form-control-label">Termin Pembayaran</label>
                                            <input type="text" class="form-control bg-white" name="termin"
                                                   value="{{ $data->termin }}" readonly>
                                        </div>
                                        <div class="form-group {{ $errors->has('namaBank') ? 'has-danger' : ''}}">
                                            <label class="form-control-label">Nama Bank <span
                                                        class="text-danger">*</span></label>
                                            <select class="form-control" name="namaBank" id="namaBank">
                                                <option>{{ $data->nama_bank }}</option>
                                                @foreach($dataBank as $bank)
                                                    <option kodeBank="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group {{ $errors->has('noRekening') ? 'has-danger' : ''}}">
                                            <label class="form-control-label">No Rekening <span
                                                        class="text-danger">*</span></label>
                                            <input type="text" class="form-control" onkeypress="return hanyaAngka(event)" name="noRekening"
                                                   value="{{ $data->no_rekening }}">
                                        </div>
                                        <div class="form-group {{ $errors->has('atasNama') ? 'has-danger' : '' }}">
                                            <label class="form-control-label">Atas Nama <span
                                                        class="text-danger">*</span></label>
                                            <input type="text" class="form-control text-uppercase" name="atasNama"
                                                   value="{{ $data->atas_nama }}">
                                        </div>
                                    @elseif($data->bantuan_berupa == 'Barang')
                                        <div class="form-group">
                                            <label class="form-control-label">Nama Barang</label>
                                            <input type="text" class="form-control text-capitalize" name="namaBarang">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Jumlah Barang</label>
                                            <input type="text" class="form-control" name="jumlahBarang"
                                                   onkeypress="return hanyaAngka(event)">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Satuan Barang</label>
                                            <input type="text" class="form-control text-capitalize" name="satuanBarang">
                                        </div>
                                    @endif
                                    <div class="form-group {{ $errors->has('namaPejabat') ? 'has-danger' : '' }} {{ $errors->has('jabatanPejabat') ? 'has-danger' : '' }} {{ $errors->has('noPelimpahan') ? 'has-danger' : '' }} {{ $errors->has('tglPelimpahan') ? 'has-danger' : '' }}">
                                        <label class="form-control-label">Pejabat Yang Menyetujui <span
                                                    class="text-danger">*</span></label>
                                        <select onchange="bukaTermin()" id="namaPejabat" class="form-control bukaTermin"
                                                name="namaPejabat">
                                            <option>Anak Agung Raka Haryana</option>
                                            <option>Sigit Tri Hartanto Sukamto</option>
                                            <option>Tubagus Nurcholis</option>
                                        </select>
                                        <input type="text" class="form-control m-t-5 text-capitalize bg-white"
                                               placeholder="Jabatan" style="color: black"
                                               name="jabatanPejabat" id="jabatanPejabat"
                                               value="Division Head Corporate Social Responsibility" readonly>
                                        <input type="text" class="form-control m-t-5 noPelimpahan" name="noPelimpahan"
                                               id="noPelimpahan" value="-" placeholder="Nomor Pelimpahan Tugas"
                                               style="display: none">
                                        <div class="input-group m-t-5 tglPelimpahan" style="display: none">
                                            <input type="text" class="form-control datepicker-autoclose"
                                                   name="tglPelimpahan" id="tglPelimpahan" value="{{ $tanggal }}"
                                                   placeholder="Tanggal Pelimpahan Tugas">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <button type="submit" class="btn btn-success waves-effect text-left"><i
                                            class="fa fa-check"></i> Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            $("#namaBank").select2({
                placeholder: "Pilih Nama Bank"
            });

            $("#provinsi").select2({
                placeholder: "Pilih Provinsi"
            });

            $("#kabupaten").select2({
                placeholder: "Pilih Kota/Kabupaten"
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#provinsi').change(function () {
                var provinsi_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupaten/" + provinsi_id + "",
                    success: function (response) {
                        $('#kabupaten').html(response);
                    }
                });
            })
        })
    </script>

    <script>
        function bukaTermin() {
            var x = document.getElementById("namaPejabat").value;
            if (x == 'Erick Taufan') {
                document.getElementById("jabatanPejabat").value = 'PH Division Head Corporate Social Responsibility';
                document.getElementById("noPelimpahan").value = '';
                $(".noPelimpahan").show();
                $(".tglPelimpahan").show();
            }
            if (x == 'Tubagus Nurcholis') {
                document.getElementById("jabatanPejabat").value = 'PH Division Head Corporate Social Responsibility';
                document.getElementById("noPelimpahan").value = '';
                $(".noPelimpahan").show();
                $(".tglPelimpahan").show();
            }
            if (x == 'Anak Agung Raka Haryana') {
                document.getElementById("jabatanPejabat").value = 'Division Head Corporate Social Responsibility';
                document.getElementById("noPelimpahan").value = '-';
                $(".noPelimpahan").hide();
                $(".tglPelimpahan").hide();
            }
        }
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.error('Data yang diisi belum lengkap', 'Peringatan', {closeButton: true});
        @endif
    </script>
@stop