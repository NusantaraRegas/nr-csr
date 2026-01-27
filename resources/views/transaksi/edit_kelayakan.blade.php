@extends('layout.master')
@section('title', 'SHARE | Kelayakan Proposal')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase">Kelayakan Proposal</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Kelayakan Proposal</li>
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
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        Data yang anda isi belum lengkap
                    </div>
                @endif
                <form method="post" action="{{ action('KelayakanController@editKelayakan') }}">
                    {{ csrf_field() }}
                    <input value="{{ encrypt($data->id_kelayakan) }}" name="idkelayakan" type="hidden">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white">Standar Kelayakan Proposal</h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">Edit Proposal</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="card-title">Data Proposal</h4>
                                    <h6 class="card-subtitle">Sesuai dengan input proposal di e-sms</h6>
                                    <hr>
                                    <div class="form-group {{ $errors->has('noAgenda') ? ' has-danger' : ''}}">
                                        <label>No Agenda <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-white" name="noAgenda"
                                               value="{{ $data->no_agenda }}">
                                        @if($errors->has('noAgenda'))
                                            <small class="text-danger">No agenda harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('pengirim') ? ' ' : ''}}">
                                        <label>Pengirim <span class="text-danger">*</span></label>
                                        <select class="select2 form-control custom-select" name="pengirim"
                                                style="width: 100%; height:36px; margin-top: 5px">
                                            <option value="{{ $data->pengirim }}">{{ $data->pengirim }}</option>
                                            @foreach($dataPengirim as $pengirim)
                                                <option value="{{ $pengirim->pengirim }}">{{ $pengirim->pengirim }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('pengirim'))
                                            <small class="text-danger">Pengirim proposal harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('tglPenerimaan') ? ' has-danger' : ''}}">
                                        <label>Tanggal Penerimaan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control datepicker-autoclose text-uppercase"
                                               name="tglPenerimaan"
                                               value="{{ date('d-M-Y', strtotime($data->tgl_terima)) }}">
                                        @if($errors->has('tglPenerimaan'))
                                            <small class="text-danger">Tanggal penerimaan harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('sifat') ? ' has-danger' : ''}}">
                                        <label>Sifat Proposal <span class="text-danger">*</span></label>
                                        <select name="sifat" class="form-control">
                                            <option value="{{ $data->sifat }}">{{ $data->sifat }}</option>
                                            <option value="Biasa">Biasa</option>
                                            <option value="Segera">Segera</option>
                                            <option value="Amat Segera">Amat Segera</option>
                                        </select>
                                        @if($errors->has('sifat'))
                                            <small class="text-danger">Sifat proposal harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('dari') ? ' has-danger' : ''}}">
                                        <label>Surat/Proposal Dari <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="dari"
                                               value="{{ $data->asal_surat }}">
                                        @if($errors->has('dari'))
                                            <small class="text-danger">Proposal dari harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('noSurat') ? ' has-danger' : ''}}">
                                        <label>Nomor Surat/Proposal <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="noSurat"
                                               value="{{ $data->no_surat }}">
                                        @if($errors->has('noSurat'))
                                            <small class="text-danger">Nomor proposal harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('tglSurat') ? ' has-danger' : ''}}">
                                        <label>Tanggal Surat/Proposal <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control datepicker-autoclose text-uppercase" name="tglSurat"
                                               value="{{ date('d-M-Y', strtotime($data->tgl_surat)) }}">
                                        @if($errors->has('tglSurat'))
                                            <small class="text-danger">Tanggal proposal harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('perihal') ? ' has-danger' : ''}}">
                                        <label>Perihal Surat/Proposal <span class="text-danger">*</span></label>
                                        <textarea rows="3" class="form-control"
                                                  name="perihal">{{ $data->perihal }}</textarea>
                                        @if($errors->has('perihal'))
                                            <small class="text-danger">Perihal proposal harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('alamat') ? ' has-danger' : ''}}">
                                        <label>Alamat Surat/Proposal <span class="text-danger">*</span></label>
                                        <textarea rows="3" class="form-control"
                                                  name="alamat">{{ $data->alamat }}</textarea>
                                        @if($errors->has('alamat'))
                                            <small class="text-danger">Alamat proposal harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('provinsi') ? ' has-danger' : ''}}">
                                        <label>Provinsi <span class="text-danger">*</span></label>
                                        <select class="select2 form-control custom-select" name="provinsi" id="provinsi"
                                                style="width: 100%; height:36px;">
                                            <option value="{{ $data->provinsi }}">{{ $data->provinsi }}</option>
                                            @foreach($dataProvinsi as $provinsi)
                                                <option value="{{ ucwords($provinsi->provinsi) }}">{{ ucwords($provinsi->provinsi) }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('provinsi'))
                                            <small class="text-danger">Provinsi harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('kabupaten') ? ' has-danger' : ''}}">
                                        <label>Kabupaten/Kota <span class="text-danger">*</span></label>
                                        <select class="select2 form-control custom-select" name="kabupaten" id="kabupaten"
                                                style="width: 100%; height:36px; margin-top: 5px">
                                            <option value="{{ $data->kabupaten }}">{{ $data->kabupaten }}</option>
                                        </select>
                                        @if($errors->has('kabupaten'))
                                            <small class="text-danger">Kabupaten harus diisi</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="card-title">Contact Person</h4>
                                    <h6 class="card-subtitle">Contact person pengaju proposal</h6>
                                    <hr>
                                    <div class="form-group {{ $errors->has('pengajuProposal') ? ' ' : ''}}">
                                        <label>Nama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="pengajuProposal"
                                               value="{{ $data->pengaju_proposal }}">
                                        @if($errors->has('pengajuProposal'))
                                            <small class="text-danger">Nama harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('email') ? ' ' : ''}}">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="email"
                                               value="{{ $data->email_pengaju }}">
                                        @if($errors->has('email'))
                                            <small class="text-danger">Email harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('noTelp') ? ' ' : ''}}">
                                        <label>No Telepon <span class="text-danger">*</span></label>
                                        <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                               name="noTelp" value="{{ $data->contact_person }}">
                                        @if($errors->has('noTelp'))
                                            <small class="text-danger">No Telepon harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('bertindakSebagai') ? ' ' : ''}}">
                                        <label>Bertindak Sebagai <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="bertindakSebagai"
                                               value="{{ $data->sebagai }}">
                                        @if($errors->has('bertindakSebagai'))
                                            <small class="text-danger">Bertindak sebagai harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('besarPermohonan') ? ' has-danger' : ''}}">
                                        <label>Besar Permohonan <span class="text-danger">*</span></label>
                                        <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                               id="besarRupiah" name="besarRupiah" value="{{ number_format($data->nilai_pengajuan,0,',','.') }}">
                                        <input type="hidden" onkeypress="return hanyaAngka(event)" class="form-control"
                                               name="besarPermohonan" id="besarPermohonan" value="{{ $data->nilai_pengajuan }}">
                                        @if($errors->has('besarPermohonan'))
                                            <small class="text-danger">Besar permohonan harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('digunakanUntuk') ? ' has-danger' : ''}}">
                                        <label>Digunakan Untuk <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="digunakanUntuk"
                                               value="{{ $data->bantuan_untuk }}">
                                        @if($errors->has('digunakanUntuk'))
                                            <small class="text-danger">Digunakan untuk harus diisi</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Sektor Bantuan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <ul class="icheck-list">
                                                <li>
                                                    <input type="radio" class="check" id="flat-radio-1"
                                                           name="ruangLingkup" data-radio="iradio_flat-red"
                                                           value="Korban Bencana Alam"
                                                           @if($data->sektor_bantuan == 'Korban Bencana Alam') checked @endif>
                                                    <label for="flat-radio-1">Korban Bencana Alam</label>
                                                </li>
                                                <li>
                                                    <input type="radio" class="check" id="flat-radio-2"
                                                           name="ruangLingkup" data-radio="iradio_flat-red"
                                                           value="Pendidikan dan/atau Pelatihan"
                                                           @if($data->sektor_bantuan == 'Pendidikan dan/atau Pelatihan') checked @endif>
                                                    <label for="flat-radio-2">Pendidikan dan/atau Pelatihan</label>
                                                </li>
                                                <li>
                                                    <input type="radio" class="check" id="flat-radio-3"
                                                           name="ruangLingkup" data-radio="iradio_flat-red"
                                                           value="Peningkatan Kesehatan"
                                                           @if($data->sektor_bantuan == 'Peningkatan Kesehatan') checked @endif>
                                                    <label for="flat-radio-3">Peningkatan Kesehatan</label>
                                                </li>
                                                <li>
                                                    <input type="radio" class="check" id="flat-radio-4"
                                                           name="ruangLingkup" data-radio="iradio_flat-red"
                                                           value="Pengembangan Prasarana dan/atau Sarana Umum"
                                                           @if($data->sektor_bantuan == 'Pengembangan Prasarana dan/atau Sarana Umum') checked @endif>
                                                    <label for="flat-radio-4">Pengembangan Sarana Umum</label>
                                                </li>
                                                <li>
                                                    <input type="radio" class="check" id="flat-radio-5"
                                                           name="ruangLingkup" data-radio="iradio_flat-red"
                                                           value="Pelestarian Alam"
                                                           @if($data->sektor_bantuan == 'Pelestarian Alam') checked @endif>
                                                    <label for="flat-radio-5">Pelestarian Alam</label>
                                                </li>
                                                <li>
                                                    <input type="radio" class="check" id="flat-radio-6"
                                                           name="ruangLingkup" data-radio="iradio_flat-red"
                                                           value="Pengentasan Kemiskinan"
                                                           @if($data->sektor_bantuan == 'Pengentasan Kemiskinan') checked @endif>
                                                    <label for="flat-radio-6">Pengentasan Kemiskinan</label>
                                                </li>
                                                <li>
                                                    <input type="radio" class="check" id="flat-radio-7"
                                                           name="ruangLingkup" data-radio="iradio_flat-red"
                                                           value="Sarana Ibadah"
                                                           @if($data->sektor_bantuan == 'Sarana Ibadah') checked @endif>
                                                    <label for="flat-radio-7">Sarana Ibadah</label>
                                                </li>
                                            </ul>
                                            @if($errors->has('ruangLingkup'))
                                                <small class="text-danger">Ruang lingkup bantuan harus diisi</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @if($data->nama_anggota != '')
                                        <h4 class="card-title">Proposal Aspirasi</h4>
                                        <h6 class="card-subtitle">Kolom ini hanya diisi untuk pengajuan proposal
                                            dari DPR/DPRD</h6>
                                        <div class="form-group">
                                            <label>Nama Anggota :</label>
                                            <input type="text" class="form-control" name="namaAnggota"
                                                   value="{{ $data->nama_anggota }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Fraksi :</label>
                                            <input type="text" class="form-control" name="fraksi"
                                                   value="{{ $data->fraksi }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Komisi :</label>
                                            <select class="form-control" name="komisi">
                                                <option value="{{ $data->komisi }}">{{ $data->komisi }}</option>
                                                <option value="VI">VI</option>
                                                <option value="VII">VII</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Jabatan :</label>
                                            <input type="text" class="form-control" name="jabatan"
                                                   value="{{ $data->jabatan }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Contact TA/PIC :</label>
                                            <input type="text" class="form-control" name="pic"
                                                   value="{{ $data->pic }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <a href="{{ route('data-kelayakan') }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        Cancel
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-success waves-effect text-left"><i
                                            class="fa fa-check"></i> Save Changes
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
            $('#provinsi').change(function () {
                var provinsi_id = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupaten/" + provinsi_id + "",
                    //data:'prov_id='+provinsi_id,
                    success: function (response) {
                        $('#kabupaten').html(response);
                    }
                });
            })
        })
    </script>
    <script>
        var besarRupiah = document.getElementById('besarRupiah');
        besarRupiah.addEventListener('keyup', function(e)
        {
            besarRupiah.value = formatRupiah(this.value);
            besarPermohonan.value = convertToAngka(this.value);
        });

        /* Fungsi */
        function formatRupiah(angka, prefix)
        {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split	= number_string.split(','),
                sisa 	= split[0].length % 3,
                rupiah 	= split[0].substr(0, sisa),
                ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        /* Fungsi */
        function convertToAngka(rupiah)
        {
            return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
        }

    </script>
@stop