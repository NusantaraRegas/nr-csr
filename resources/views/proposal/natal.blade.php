@extends('layout.master')
@section('title', 'SHARE | Proposal Natal')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold">PROPOSAL NATAL</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Proposal</li>
                        <li class="breadcrumb-item active">Proposal Natal</li>
                    </ol>
                </div>
            </div>
        </div>

        <form method="post" action="{{ action('KelayakanController@insertSantunan') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white model-huruf-family">Kelayakan Proposal</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>No Agenda <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-uppercase" name="noAgenda"
                                        value="{{ old('noAgenda') }}">
                                    <input type="hidden" class="form-control" name="jenis" value="Natal">
                                    @if ($errors->has('noAgenda'))
                                        <small class="text-danger">No agenda harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tanggal Penerimaan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker-autoclose" name="tglPenerimaan"
                                            value="{{ old('tglPenerimaan') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('tglPenerimaan'))
                                        <small class="text-danger">Tanggal penerimaan harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Pengirim <span class="text-danger">*</span></label>
                                    <select class="select2 form-control" name="pengirim" style="width: 100%;">
                                        <option>{{ old('pengirim') }}</option>
                                        @foreach ($dataPengirim as $pengirim)
                                            <option>{{ $pengirim->pengirim }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('pengirim'))
                                        <small class="text-danger">Pengirim harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Lembar Disposisi <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="disposisi">
                                    @if ($errors->has('disposisi'))
                                        <small class="text-danger">Lembar disposisi harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nomor Surat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-uppercase" name="noSurat"
                                        value="{{ old('noSurat') }}">
                                    @if ($errors->has('noSurat'))
                                        <small class="text-danger">Nomor Surat harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tanggal Surat <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker-autoclose" name="tglSurat"
                                            value="{{ old('tglSurat') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('tglSurat'))
                                        <small class="text-danger">Tanggal surat/proposal harus
                                            diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Sifat <span class="text-danger">*</span></label>
                                    <select name="sifat" class="select2 form-control" style="width: 100%">
                                        <option value="Amat Segera">Amat Segera</option>
                                        <option value="Biasa">Biasa</option>
                                        <option value="Segera">Segera</option>
                                    </select>
                                    @if ($errors->has('sifat'))
                                        <small class="text-danger">Sifat surat/proposal harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Surat Pengantar dan Proposal <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="lampiran">
                                    @if ($errors->has('lampiran'))
                                        <small class="text-danger">Surat pengantar dan proposal harus
                                            diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Perihal <span class="text-danger">*</span> </label>
                                <input type="text" maxlength="200" class="form-control" name="digunakanUntuk"
                                    value="{{ old('digunakanUntuk') }}">
                                @if ($errors->has('digunakanUntuk'))
                                    <small class="text-danger">Perihal harus diisi</small>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Besar Permohonan <span class="text-danger">*</span></label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                        name="besarPermohonan" id="besarPermohonan" value="0">
                                    @if ($errors->has('besarPermohonan'))
                                        <small class="text-danger">Besar permohonan harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <select class="select2 form-control" name="perihal" style="width: 100%">
                                        <option>Permohonan Bantuan Dana</option>
                                        <option>Permohonan Bantuan Barang</option>
                                    </select>
                                    @if ($errors->has('perihal'))
                                        <small class="text-danger">Kategori harus
                                            diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Provinsi Kegiatan Program Bantuan <span class="text-danger">*</span></label>
                                    <select class="select2 form-control" name="provinsi" id="provinsi"
                                        style="width: 100%; height:36px;">
                                        <option></option>
                                        @foreach ($dataProvinsi as $provinsi)
                                            <option value="{{ ucwords($provinsi->provinsi) }}">
                                                {{ ucwords($provinsi->provinsi) }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('provinsi'))
                                        <small class="text-danger">Provinsi kegiatan program bantuan harus
                                            diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kabupaten/Kota Kegiatan Program Bantuan <span
                                            class="text-danger">*</span></label>
                                    <select class="select2 form-control bg-white" name="kabupaten" id="kabupaten"
                                        style="width: 100%; height:36px; margin-top: 5px">
                                        <option value=""></option>
                                    </select>
                                    @if ($errors->has('kabupaten'))
                                        <small class="text-danger">Kabupaten/Kota kegiatan program bantua
                                            harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Bantuan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="deskripsiBantuan"
                                    value="Natal dan Tahun Baru Tahun 2023">
                                @if ($errors->has('deskripsiBantuan'))
                                    <small class="text-danger">Deskripsi bantuan harus diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white model-huruf-family">Evaluasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Rencana Anggaran <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="rencanaAnggaran">
                                            <option>ADA</option>
                                            <option>ADA</option>
                                            <option>TIDAK ADA</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('rencanaAnggaran'))
                                        <small class="text-danger">Rencana anggaran harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Dokumentasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="dokumen">
                                            <option>TIDAK ADA</option>
                                            <option>ADA</option>
                                            <option>TIDAK ADA</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('dokumen'))
                                        <small class="text-danger">Dokumentasi harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Denah Lokasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="denah">
                                            <option>TIDAK ADA</option>
                                            <option>ADA</option>
                                            <option>TIDAK ADA</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('denah'))
                                        <small class="text-danger">Denah lokasi harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Kepentingan Perusahaan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <ul class="icheck-list">
                                            <li>
                                                <input type="checkbox" name="wilayahOperasi"
                                                    value="Wilayah Operasi PGN (Ring I / II / III)" class="check"
                                                    id="square-checkbox-1" data-checkbox="icheckbox_square-red">
                                                <label for="square-checkbox-1">Wilayah Operasi PGN (Ring
                                                    I/II/III)</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="kelancaranOperasional"
                                                    value="Kelancaran Operasional/asset PGN" class="check"
                                                    id="square-checkbox-2" data-checkbox="icheckbox_square-red">
                                                <label for="square-checkbox-2">Kelancaran Operasional/Asset
                                                    PGN</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="hubunganBaik" checked
                                                    value="Menjaga hubungan baik shareholders/stakeholders" class="check"
                                                    id="square-checkbox-3" data-checkbox="icheckbox_square-red">
                                                <label for="square-checkbox-3">Menjaga Hubungan Baik
                                                    Stakeholders</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>&nbsp;</label>
                                    <div class="input-group">
                                        <ul class="icheck-list">
                                            <li>
                                                <input type="checkbox" name="brandImage" checked
                                                    value="Brand images/citra perusahaan" class="check"
                                                    id="square-checkbox-4" data-checkbox="icheckbox_square-red">
                                                <label for="square-checkbox-4">Brand Images/Citra Perusahaan</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="pengembanganWilayah"
                                                    value="Pengembangan wilayah usaha" class="check"
                                                    id="square-checkbox-5" data-checkbox="icheckbox_square-red">
                                                <label for="square-checkbox-5">Pengembangan Wilayah Usaha</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Perkiraan Bantuan <span class="text-danger">*</span></label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                        name="perkiraanDana" id="perkiraanDana" value="{{ old('perkiraanDana') }}">
                                    @if ($errors->has('perkiraanDana'))
                                        <small class="text-danger">Perkiraan dana harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Memenuhi Syarat Untuk <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="syarat">
                                            <option value="Survei">Survei/Konfirmasi</option>
                                            <option value="Tidak Memenuhi Syarat">Tidak Memenuhi Syarat</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('syarat'))
                                        <small class="text-danger">Syarat harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Evaluator ke 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control bg-white" name="evaluator1"
                                        value="{{ session('user')->nama }}" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Evaluator ke 2 <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="evaluator2" style="width: 100%">
                                        <option value=""></option>
                                        @foreach ($dataUser as $user)
                                            <option value="{{ $user->username }}">{{ $user->nama }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('evaluator2'))
                                        <small class="text-danger">Evaluator ke 2 harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Catatan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" maxlength="200" name="catatan"
                                        placeholder="Catatan Evaluator 1"
                                        value="Sebagai bentuk kepedulian perusahaan terhadap masyarakat yang membutuhkan">
                                </div>
                                @if ($errors->has('catatan'))
                                    <small class="text-danger">Catatan harus diisi</small>
                                @endif
                            </div>
                            <div class="form-check mr-sm-2 mb-3">
                                <input type="checkbox" class="form-check-input" id="checkboxAgreement" value="check"
                                    onclick="terms_changed(this)">
                                <label class="form-check-label" for="checkboxAgreement">Dokumen legalitas (berupa Akta
                                    pendirian lembaga atau dokumen legalitas lainnya yang disahkan oleh pejabat yang
                                    berwenang)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white model-huruf-family">Yayasan/Lembaga Penerima Bantuan</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Yayasan/Lembaga <span class="text-danger">*</span></label>
                                <select class="select2 form-control" name="dari" id="dari" style="width: 100%">
                                    <option></option>
                                    @foreach ($dataLembaga as $lembaga)
                                        <option alamat="{{ $lembaga->alamat }}" pic="{{ $lembaga->nama_pic }}"
                                            noTelp="{{ $lembaga->no_telp }}" jabatan="{{ $lembaga->jabatan }}"
                                            noRekening="{{ $lembaga->no_rekening }}"
                                            atasNama="{{ $lembaga->atas_nama }}" namaBank="{{ $lembaga->nama_bank }}"
                                            kodeBank="{{ $lembaga->kode_bank }}" kotaBank="{{ $lembaga->kota_bank }}"
                                            kodeKota="{{ $lembaga->kode_kota }}" cabang="{{ $lembaga->cabang }}">
                                            {{ $lembaga->nama_lembaga }}</option>
                                    @endforeach
                                    <option></option>
                                </select>
                                @if ($errors->has('dari'))
                                    <small class="text-danger">Proposal/Surat dari harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Alamat Pengaju Proposal <span class="text-danger">*</span></label>
                                <textarea rows="3" maxlength="200" class="form-control bg-white" placeholder="Otomatis by system"
                                    name="alamat" id="alamat" readonly></textarea>
                                @if ($errors->has('alamat'))
                                    <small class="text-danger">Alamat pengaju proposal harus
                                        diisi</small>
                                    <br>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Nama Penanggung Jawab <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white" name="pengajuProposal"
                                    id="pengajuProposal" readonly placeholder="Otomatis by system">
                                @if ($errors->has('pengajuProposal'))
                                    <small class="text-danger">Nama penanggung jawab harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Bertindak Sebagai <span class="text-danger">*</span> <small
                                        style="color: red">Jabatan dalam proposal</small></label>
                                <input type="text" class="form-control bg-white" name="bertindakSebagai"
                                    id="bertindakSebagai" readonly placeholder="Otomatis by system">
                                @if ($errors->has('bertindakSebagai'))
                                    <small class="text-danger">Bertindak sebagai harus diisi</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>No Telepon <span class="text-danger">*</span></label>
                                <input type="text" onkeypress="return hanyaAngka(event)" class="form-control bg-white"
                                    readonly id="noTelp" placeholder="Otomatis by system" name="noTelp">
                                @if ($errors->has('noTelp'))
                                    <small class="text-danger">No telepon penanggung jawab harus
                                        diisi</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span> <small style="color: red">(Email Evaluator
                                        1) </small></label>
                                <input type="text" class="form-control" name="email"
                                    value="{{ session('user')->email }}">
                                @if ($errors->has('email'))
                                    <small class="text-danger">Email penanggung jawab harus
                                        diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white model-huruf-family">Informasi Bank</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>No Rekening</label>
                                    <input type="text" maxlength="35" onkeypress="return hanyaAngka(event)"
                                        class="form-control bg-white" placeholder="Otomatis by system" readonly
                                        name="noRekening" id="noRekening">
                                    @if ($errors->has('noRekening'))
                                        <small class="text-danger">No rekening bank harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Atas Nama</label>
                                    <input type="text" maxlength="150" class="form-control bg-white" readonly
                                        placeholder="Otomatis by system" name="atasNama" id="atasNama">
                                    @if ($errors->has('atasNama'))
                                        <small class="text-danger">Atas nama bank harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nama Bank</label>
                                <input type="text" class="form-control bg-white" name="namaBank" id="namaBank"
                                    readonly placeholder="Otomatis by system">
                                <input type="hidden" readonly class="form-control" name="kodeBank" id="kodeBank">
                                @if ($errors->has('namaBank'))
                                    <small class="text-danger">Nama bank harus diisi</small>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Kota Bank</label>
                                    <input type="text" class="form-control bg-white" name="kota" id="kota"
                                        readonly placeholder="Otomatis by system">
                                    <input type="hidden" readonly class="form-control" name="kodeKota" id="kodeKota">
                                    @if ($errors->has('kota'))
                                        <small class="text-danger">Bank city harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Cabang</label>
                                    <input maxlength="35" type="text" class="form-control bg-white" readonly
                                        placeholder="Otomatis by system" name="cabang" id="cabang"
                                        value="{{ old('cabang') }}">
                                    @if ($errors->has('cabang'))
                                        <small class="text-danger">Cabang bank harus diisi</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="{{ route('dashboard') }}" class="btn btn-light font-weight-bold">Cancel</a>
                        <button type="submit" disabled class="btn btn-info font-weight-bold" id="submit_button">Save as
                            draft</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    <script>
        $('#dari').on('change', function() {
            var alamat = $('#dari option:selected').attr('alamat');
            var pic = $('#dari option:selected').attr('pic');
            var jabatan = $('#dari option:selected').attr('jabatan');
            var noTelp = $('#dari option:selected').attr('noTelp');
            var noRekening = $('#dari option:selected').attr('noRekening');
            var atasNama = $('#dari option:selected').attr('atasNama');
            var namaBank = $('#dari option:selected').attr('namaBank');
            var kodeBank = $('#dari option:selected').attr('kodeBank');
            var kotaBank = $('#dari option:selected').attr('kotaBank');
            var kodeKota = $('#dari option:selected').attr('kodeKota');
            var cabang = $('#dari option:selected').attr('cabang');
            $('#alamat').val(alamat);
            $('#pengajuProposal').val(pic);
            $('#bertindakSebagai').val(jabatan);
            $('#noTelp').val(noTelp);
            $('#noRekening').val(noRekening);
            $('#atasNama').val(atasNama);
            $('#namaBank').val(namaBank);
            $('#kodeBank').val(kodeBank);
            $('#kota').val(kotaBank);
            $('#kodeKota').val(kodeKota);
            $('#cabang').val(cabang);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                var provinsi_id = $(this).val();

                $("#kabupaten").select2({
                    placeholder: "Pilih Kabupaten"
                });

                $.ajax({
                    type: 'GET',
                    url: "/proposal/data-kabupaten/" + provinsi_id + "",
                    success: function(response) {
                        $('#kabupaten').html(response);
                        $("#kabupaten").prop("disabled", false);
                    }
                });
            })
        })
    </script>

    <script>
        var besarPermohonan = document.getElementById('besarPermohonan');
        besarPermohonan.addEventListener('keyup', function(e) {
            besarPermohonan.value = formatRupiah(this.value);
        });

        var perkiraanDana = document.getElementById('perkiraanDana');
        perkiraanDana.addEventListener('keyup', function(e) {
            perkiraanDana.value = formatRupiah(this.value);
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
        function terms_changed(checkboxAgreement) {
            if (checkboxAgreement.checked) {
                document.getElementById("submit_button").disabled = false;
            } else {
                document.getElementById("submit_button").disabled = true;
            }
        }
    </script>

    <script>
        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true
            });
        @endif
    </script>
@stop
