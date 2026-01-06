@extends('layout.master')
@section('title', 'SHARE | Update Kelayakan')

@section('content')
    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor font-weight-bold text-uppercase">Update Kelayakan</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Proposal</li>
                        <li class="breadcrumb-item active">Update Kelayakan</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form method="post" action="{{ action('KelayakanController@editKelayakan') }}">
                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="card-title mb-5">SURAT ATAU PROPOSAL</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No Agenda ESMS <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-uppercase" name="noAgenda"
                                                    value="{{ $data->no_agenda }}">
                                                <input type="hidden" class="form-control" name="idKelayakan"
                                                    value="{{ encrypt($data->id_kelayakan) }}">
                                                <input type="hidden" class="form-control" name="lastNoAgenda"
                                                    value="{{ $data->no_agenda }}">
                                                @if ($errors->has('noAgenda'))
                                                    <small class="text-danger">No agenda harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Proposal <span class="text-danger">*</span></label>
                                                <select class="select2 form-control" name="jenis"
                                                    style="width: 100%; height:36px; margin-top: 5px">
                                                    <option>{{ $data->jenis }}</option>
                                                    <option>Bulanan</option>
                                                    <option>Santunan</option>
                                                    <option>Idul Adha</option>
                                                    <option>Natal</option>
                                                    <option>Aspirasi</option>
                                                </select>
                                                @if ($errors->has('pengirim'))
                                                    <small class="text-danger">Pengirim surat/proposal harus
                                                        diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Pengirim <span class="text-danger">*</span></label>
                                                <select class="select2 form-control" name="pengirim"
                                                    style="width: 100%; height:36px; margin-top: 5px">
                                                    <option value="{{ $data->pengirim }}">{{ $data->pengirim }}</option>
                                                    @foreach ($dataPengirim as $pengirim)
                                                        <option value="{{ $pengirim->pengirim }}">{{ $pengirim->pengirim }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('pengirim'))
                                                    <small class="text-danger">Pengirim surat/proposal harus
                                                        diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Penerimaan <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker-autoclose"
                                                        name="tglPenerimaan"
                                                        value="{{ date('d-M-Y', strtotime($data->tgl_terima)) }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('tglPenerimaan'))
                                                    <small class="text-danger">Tanggal penerimaan surat/proposal harus
                                                        diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Sifat <span class="text-danger">*</span></label>
                                                <select name="sifat" class="form-control">
                                                    <option value="{{ $data->sifat }}">{{ $data->sifat }}</option>
                                                    <option value="Biasa">Biasa</option>
                                                    <option value="Segera">Segera</option>
                                                    <option value="Amat Segera">Amat Segera</option>
                                                </select>
                                                @if ($errors->has('sifat'))
                                                    <small class="text-danger">Sifat surat/proposal harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Dari <span class="text-danger">*</span></label>
                                                <select class="form-control" name="dari" id="dari"
                                                    style="width: 100%">
                                                    <option>{{ $data->asal_surat }}</option>
                                                    @foreach ($dataLembaga as $lembaga)
                                                        <option alamat="{{ $lembaga->alamat }}"
                                                            pic="{{ $lembaga->nama_pic }}"
                                                            noTelp="{{ $lembaga->no_telp }}"
                                                            jabatan="{{ $lembaga->jabatan }}"
                                                            noRekening="{{ $lembaga->no_rekening }}"
                                                            atasNama="{{ $lembaga->atas_nama }}"
                                                            namaBank="{{ $lembaga->nama_bank }}"
                                                            kodeBank="{{ $lembaga->kode_bank }}"
                                                            kotaBank="{{ $lembaga->kota_bank }}"
                                                            kodeKota="{{ $lembaga->kode_kota }}"
                                                            cabang="{{ $lembaga->cabang }}">{{ $lembaga->nama_lembaga }}
                                                        </option>
                                                    @endforeach
                                                    <option></option>
                                                </select>
                                                @if ($errors->has('dari'))
                                                    <small class="text-danger">Proposal/Surat dari harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Nomor <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="noSurat"
                                                    value="{{ $data->no_surat }}">
                                                @if ($errors->has('noSurat'))
                                                    <small class="text-danger">Nomor surat/proposal harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker-autoclose"
                                                        name="tglSurat"
                                                        value="{{ date('d-M-Y', strtotime($data->tgl_surat)) }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('tglSurat'))
                                                    <small class="text-danger">Tanggal surat/proposal harus
                                                        diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Perihal <span class="text-danger">*</span> </label>
                                                <input maxlength="200" type="text" class="form-control"
                                                    name="digunakanUntuk" value="{{ $data->bantuan_untuk }}">
                                                @if ($errors->has('digunakanUntuk'))
                                                    <small class="text-danger">Perihal harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Besar Permohonan <span class="text-danger">*</span></label>
                                                <input type="text" onkeypress="return hanyaAngka(event)"
                                                    class="form-control" name="besarRupiah"
                                                    value="{{ number_format($data->nilai_pengajuan, 0, ',', '.') }}"
                                                    id="besarRupiah">
                                                <input type="hidden" onkeypress="return hanyaAngka(event)"
                                                    class="form-control" name="besarPermohonan" id="besarPermohonan"
                                                    value="{{ $data->nilai_pengajuan }}">
                                                @if ($errors->has('besarRupiah'))
                                                    <small class="text-danger">Besar permohonan harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Kategori Bantuan <span class="text-danger">*</span></label>
                                                <select class="form-control" name="perihal">
                                                    <option>{{ $data->perihal }}</option>
                                                    <option>Permohonan Bantuan Dana</option>
                                                    <option>Permohonan Bantuan Barang</option>
                                                </select>
                                                @if ($errors->has('perihal'))
                                                    <small class="text-danger">Kategori bantuan harus
                                                        diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi Bantuan <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="deskripsiBantuan"
                                                    value="{{ $data->deskripsi }}">
                                                @if ($errors->has('deskripsiBantuan'))
                                                    <small class="text-danger">Deskripsi bantuan harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Sektor Bantuan <span class="text-danger">*</span></label>
                                                <select class="form-control" name="ruangLingkup" id="ruangLingkup"
                                                    style="width: 100%">
                                                    <option>{{ $data->sektor_bantuan }}</option>
                                                    @foreach ($dataSektor as $sektor)
                                                        <option>{{ $sektor->sektor_bantuan }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('ruangLingkup'))
                                                    <small class="text-danger">Sektor bantuan harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Provinsi Kegiatan Program Bantuan <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="provinsi" id="provinsi"
                                                    style="width: 100%; height:36px;">
                                                    <option value="{{ $data->provinsi }}">{{ $data->provinsi }}</option>
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
                                            <div class="form-group">
                                                <label>Kabupaten/Kota Kegiatan Program Bantuan <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="kabupaten" id="kabupaten" disabled
                                                    style="width: 100%; height:36px; margin-top: 5px">
                                                    <option value="{{ $data->kabupaten }}">{{ $data->kabupaten }}
                                                    </option>
                                                </select>
                                                @if ($errors->has('kabupaten'))
                                                    <small class="text-danger">Kabupaten/Kota kegiatan program bantua
                                                        harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat Pengaju Proposal <span class="text-danger">*</span></label>
                                                <textarea rows="3" maxlength="200" class="form-control" placeholder="Otomatis By System" name="alamat"
                                                    id="alamat" readonly>{{ $data->alamat }}</textarea>
                                                @if ($errors->has('alamat'))
                                                    <small class="text-danger">Alamat pengaju proposal harus
                                                        diisi</small>
                                                    <br>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h5 class="card-title mb-5 mt-5">PENANGGUNG JAWAB</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="pengajuProposal"
                                                    id="pengajuProposal" readonly value="{{ $data->pengaju_proposal }}"
                                                    placeholder="Otomatis By System">
                                                @if ($errors->has('pengajuProposal'))
                                                    <small class="text-danger">Nama penanggung jawab harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Email <span class="text-danger">*</span> <small
                                                        style="color: red">(Email Evaluator 1) </small></label>
                                                <input type="text" class="form-control" name="email"
                                                    value="{{ $data->email_pengaju }}">
                                                @if ($errors->has('email'))
                                                    <small class="text-danger">Email penanggung jawab harus
                                                        diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No Telepon <span class="text-danger">*</span></label>
                                                <input type="text" onkeypress="return hanyaAngka(event)"
                                                    class="form-control" readonly id="noTelp"
                                                    placeholder="Otomatis By System" name="noTelp"
                                                    value="{{ $data->contact_person }}">
                                                @if ($errors->has('noTelp'))
                                                    <small class="text-danger">No telepon penanggung jawab harus
                                                        diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Bertindak Sebagai <span class="text-danger">*</span> <small
                                                        style="color: red">Jabatan dalam proposal</small></label>
                                                <input type="text" class="form-control" name="bertindakSebagai"
                                                    id="bertindakSebagai" readonly value="{{ $data->sebagai }}"
                                                    placeholder="Otomatis By System">
                                                @if ($errors->has('bertindakSebagai'))
                                                    <small class="text-danger">Bertindak sebagai harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h5 class="card-title mb-5 mt-5">INFORMASI BANK</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No Rekening</label>
                                                <input type="text" maxlength="35"
                                                    onkeypress="return hanyaAngka(event)" class="form-control"
                                                    placeholder="Otomatis By System" readonly
                                                    placeholder="Maksimal 35 Karakter" name="noRekening" id="noRekening"
                                                    value="{{ $data->no_rekening }}">
                                                @if ($errors->has('noRekening'))
                                                    <small class="text-danger">No rekening bank harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Atas Nama</label>
                                                <input type="text" maxlength="150" class="form-control" readonly
                                                    placeholder="Otomatis By System" name="atasNama" id="atasNama"
                                                    value="{{ $data->atas_nama }}">
                                                @if ($errors->has('atasNama'))
                                                    <small class="text-danger">Atas nama bank harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('namaBank') ? ' ' : '' }}">
                                                <label>Nama Bank</label>
                                                <input type="text" class="form-control" name="namaBank"
                                                    id="namaBank" readonly placeholder="Otomatis By System"
                                                    value="{{ $data->nama_bank }}">
                                                <input type="hidden" readonly class="form-control" name="kodeBank"
                                                    id="kodeBank" value="{{ $data->kode_bank }}">
                                                @if ($errors->has('namaBank'))
                                                    <small class="text-danger">Nama bank harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Kota Bank</label>
                                                <input type="text" class="form-control" name="kota" id="kota"
                                                    readonly placeholder="Otomatis By System"
                                                    value="{{ $data->kota_bank }}">
                                                <input type="hidden" readonly class="form-control" name="kodeKota"
                                                    id="kodeKota" value="{{ $data->kode_kota }}">
                                                @if ($errors->has('kota'))
                                                    <small class="text-danger">Bank city harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Cabang</label>
                                                <input maxlength="35" type="text" class="form-control" readonly
                                                    placeholder="Otomatis By System" name="cabang" id="cabang"
                                                    value="{{ $data->cabang_bank }}">
                                                @if ($errors->has('cabang'))
                                                    <small class="text-danger">Cabang bank harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <a href="{{ route('cari-kelayakan') }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        Cancel
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-success waves-effect text-left">Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $("#provinsi").select2({
                placeholder: "Pilih Provinsi"
            });

            $("#ruangLingkup").select2({
                placeholder: "Pilih Sektor Bantuan"
            });

            $("#dari").select2({
                placeholder: "Pilih Lembaga atau Yayasan"
            });
        });
    </script>

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
        @if (count($errors) > 0)
            toastr.warning('Data yang anda isi belum lengkap', 'Warning', {
                closeButton: true,
                progressBar: true
            });
        @endif

        var besarRupiah = document.getElementById('besarRupiah');
        besarRupiah.addEventListener('keyup', function(e) {
            besarRupiah.value = formatRupiah(this.value);
            besarPermohonan.value = convertToAngka(this.value);
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
@stop
