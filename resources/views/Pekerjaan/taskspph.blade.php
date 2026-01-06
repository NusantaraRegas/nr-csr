@extends('layout.master_vendor')
@section('title', 'PGN SHARE | My Tasks')

@section('content')
    <div class="pcoded-inner-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10"><b>My Tasks</b></h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="#!">My Tasks</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-body">
            <div class="page-wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="font-weight-bold">SPPH</h5>
                            </div>
                            <div class="card-block p-3">
                                @if($jumlahSPPH > 0)
                                    @foreach($dataSPPH as $spph)
                                        <?php
                                        $namaPekerjaan = \App\Models\Pekerjaan::where('pekerjaan_id', $spph->pekerjaan_id)->first();
                                        $namaVendor = \App\Models\Vendor::where('vendor_id', $spph->id_vendor)->first();
                                        ?>
                                        <a href="#!"
                                           data-toggle="modal"
                                           data-target=".modal-Respon"
                                           data-id="{{ encrypt($spph->spph_id) }}"
                                           class="label theme-bg text-white font-weight-bold f-12 respon">Response</a>
                                        <br>
                                        <br>
                                        <table width="100%" class="mb-3">
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Nomor
                                                </th>
                                                <td>
                                                    <a target="_blank" class="font-weight-bold"
                                                       href="/attachment/{{ $spph->file }}">{{ strtoupper($spph->nomor) }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Tanggal
                                                </th>
                                                <td>
                                                    {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($spph->tanggal))) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Nama Proyek
                                                </th>
                                                <td>
                                                    <span class="font-weight-bold">{{ $namaPekerjaan->nama_pekerjaan }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    KAK
                                                </th>
                                                <td>
                                                    <a target="_blank" class="font-weight-bold"
                                                       href="/attachment/{{ $namaPekerjaan->kak }}"><i class="feather icon-download mr-1"></i>Download</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Status
                                                </th>
                                                <td>
                                                    @if($spph->status == 'DRAFT')
                                                        <span class="badge badge-secondary">DRAFT</span>
                                                    @elseif($spph->status == 'Submitted')
                                                        <span class="badge badge-warning f-12 text-dark">Waiting for response</span>
                                                    @elseif($spph->status == 'Accepted')
                                                        <span class="badge badge-success f-12">Responded</span>
                                                    @elseif($spph->status == 'Declined')
                                                        <span class="badge badge-danger f-12">Declined</span>
                                                    @endif
                                                    @if($spph->catatan != "")
                                                        <br>
                                                        <span class="text-muted">{{ $spph->catatan }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                @else
                                    <div class="alert alert-danger mb-0" role="alert">
                                        <b>Saat ini Anda tidak memiliki Permintaan Penawaran Harga</b>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="font-weight-bold">BAKN</h5>
                            </div>
                            <div class="card-block p-3">
                                @if($jumlahBAKN > 0)
                                    @foreach($dataBAKN as $bakn)
                                        <?php
                                        $namaVendorBAKN = \App\Models\Vendor::where('vendor_id', $bakn->id_vendor)->first();
                                        $proyek = \App\Models\Pekerjaan::where('pekerjaan_id', $bakn->pekerjaan_id)->first();
                                        ?>
                                        <a href="#!" data-toggle="modal"
                                           data-target=".modal-ResponBAKN"
                                           data-id="{{ encrypt($bakn->bakn_id) }}"
                                           class="label theme-bg text-white font-weight-bold f-12 responBAKN">Response</a>
                                        <br>
                                        <br>
                                        <table width="100%" class="mb-3">
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Nomor
                                                </th>
                                                <td>
                                                    <a target="_blank" class="font-weight-bold"
                                                       href="/attachment/{{ $bakn->file }}">{{ strtoupper($bakn->nomor) }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Tanggal
                                                </th>
                                                <td>
                                                    {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($bakn->tanggal))) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Nama Proyek
                                                </th>
                                                <td>
                                                    <span class="font-weight-bold">{{ $proyek->nama_pekerjaan }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Kesepakatan Biaya
                                                </th>
                                                <td>
                                                    <span class="font-weight-bold f-16 text-dark">{{ "Rp".number_format($bakn->nilai_kesepakatan,0,',','.') }}</span>
                                                    @if($bakn->nilai_kesepakatan > $proyek->nilai_perkiraan)
                                                        <i class="font-weight-bold feather icon-arrow-up text-c-red f-16 m-r-10"></i>
                                                    @else
                                                        <i class="font-weight-bold feather icon-arrow-down text-c-green f-16 m-r-10"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Status
                                                </th>
                                                <td>
                                                    @if($bakn->status == 'DRAFT')
                                                        <span class="badge badge-secondary">DRAFT</span>
                                                    @elseif($bakn->status == 'Submitted')
                                                        <span class="badge badge-warning f-12 text-dark">Waiting for response</span>
                                                    @elseif($bakn->status == 'Accepted')
                                                        <span class="badge badge-success f-12">Responded</span>
                                                    @elseif($bakn->status == 'Declined')
                                                        <span class="badge badge-danger f-12">Declined</span>
                                                    @endif
                                                    @if($bakn->catatan != "")
                                                        <br>
                                                        <span class="text-muted">{{ $bakn->catatan }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                @else
                                    <div class="alert alert-danger mb-0" role="alert">
                                        <b>Saat ini Anda tidak memiliki Berita Acara Klarifikasi dan Negosiasi</b>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="font-weight-bold">SPK</h5>
                            </div>
                            <div class="card-block p-3">
                                @if($jumlahSPK > 0)
                                    @foreach($dataSPK as $spk)
                                        <?php
                                        $namaVendorSPK = \App\Models\Vendor::where('vendor_id', $spk->id_vendor)->first();
                                        $proyekSPK = \App\Models\Pekerjaan::where('pekerjaan_id', $spk->pekerjaan_id)->first();
                                        ?>
                                        <a href="#!" data-toggle="modal"
                                           data-target=".modal-ResponSPK"
                                           data-id="{{ encrypt($spk->spk_id) }}"
                                           class="label theme-bg text-white font-weight-bold f-12 responSPK">Response</a>
                                        <br>
                                        <br>
                                        <table width="100%" class="mb-3">
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Nomor
                                                </th>
                                                <td>
                                                    <a target="_blank" class="font-weight-bold"
                                                       href="/attachment/{{ $spk->file }}">{{ strtoupper($spk->nomor) }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Tanggal
                                                </th>
                                                <td>
                                                    {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($spk->tanggal))) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Nama Proyek
                                                </th>
                                                <td>
                                                    <span class="font-weight-bold">{{ $proyekSPK->nama_pekerjaan }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Kesepakatan Biaya
                                                </th>
                                                <td>
                                                    <span class="font-weight-bold f-16 text-dark">{{ "Rp".number_format($spk->nilai_kesepakatan,0,',','.') }}</span>
                                                    @if($spk->nilai_kesepakatan > $proyekSPK->nilai_perkiraan)
                                                        <i class="font-weight-bold feather icon-arrow-up text-c-red f-16 m-r-10"></i>
                                                    @else
                                                        <i class="font-weight-bold feather icon-arrow-down text-c-green f-16 m-r-10"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Durasi
                                                </th>
                                                <td>
                                                    <b>{{ $spk->durasi." Hari" }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Tanggal Penyelesaian
                                                </th>
                                                <td>
                                                    {{ \App\Helper\formatTanggal::tanggal_indo(date('Y-m-d', strtotime($spk->due_date))) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px; vertical-align: top; padding: 5px 5px 5px 5px">
                                                    Status
                                                </th>
                                                <td>
                                                    @if($spk->status == 'DRAFT')
                                                        <span class="badge badge-secondary">DRAFT</span>
                                                    @elseif($spk->status == 'Submitted')
                                                        <span class="badge badge-warning f-12 text-dark">Waiting for response</span>
                                                    @elseif($spk->status == 'Accepted')
                                                        <span class="badge badge-success f-12">Accepted</span>
                                                    @elseif($spk->status == 'Declined')
                                                        <span class="badge badge-danger f-12">Declined</span>
                                                    @endif
                                                    @if($spk->catatan != "")
                                                        <br>
                                                        <span class="text-muted">{{ $spk->catatan }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                @else
                                    <div class="alert alert-danger mb-0" role="alert">
                                        <b>Saat ini Anda tidak memiliki Tasks Surat Perintah Kerja</b>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ action('TasklistVendorController@response') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade modal-Respon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLiveLabel">Task Response</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control bg-light" type="hidden" name="spphID" id="spphID" readonly>
                        <div class="form-group">
                            <label>Response <span class="text-danger">*</span></label>
                            <select class="form-control" onchange="bukaTermin()" name="response" id="response">
                                <option value="Accepted">Submit Penawaran</option>
                                <option value="Declined">Decline</option>
                            </select>
                            @if($errors->has('response'))
                                <small class="text-danger">Response harus diisi</small>
                            @endif
                        </div>
                        <div id="keteranganNomor">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nomor <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nomor">
                                    @if($errors->has('nomor'))
                                        <small class="text-danger">Nomor dokumen harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tanggal <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                        class="feather icon-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="date-start" name="tanggal"
                                               value="{{ old('tanggal') }}">
                                    </div>
                                    @if($errors->has('tanggal'))
                                        <small class="text-danger">Tanggal harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Penawaran Biaya (Rp) <span class="text-danger">*</span></label>
                                    <input type="text" onkeypress="return hanyaAngka(event)"
                                           class="form-control"
                                           name="nilaiPenawaran" id="nilaiPenawaran"
                                           value="{{ old('nilaiPerkiraan') }}">
                                    @if($errors->has('nilaiPerkiraan'))
                                        <small class="text-danger">Perkiraan biaya harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Lampiran SPH <span class="text-danger">*</span></label>
                                    <br>
                                    <input type="hidden" name="namaDokumen" value="SPH">
                                    <input type="file" name="lampiran" value="{{ old('lampiran') }}"
                                           accept="application/pdf">
                                    @if($errors->has('lampiran'))
                                        <br>
                                        <small class="text-danger">Lampiran SPH harus diisi</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Komentar</label>
                            <textarea class="form-control" rows="3" name="komentar" maxlength="200"
                                      placeholder="Maksimal 200 karakter"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success font-weight-bold text-dark">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('TasklistVendorController@responseBAKN') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-ResponBAKN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLiveLabel">Task Response</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control bg-light" type="hidden" name="baknID" id="baknID" readonly>
                        <div class="form-group">
                            <label>Response <span class="text-danger">*</span></label>
                            <br>
                            <div class="form-group d-inline">
                                <div class="radio d-inline">
                                    <input type="radio" name="responseBAKN" id="radio-in-1" value="Accepted">
                                    <label for="radio-in-1" class="cr">Accept</label>
                                </div>
                            </div>
                            <div class="form-group d-inline">
                                <div class="radio d-inline">
                                    <input type="radio" name="responseBAKN" id="radio-in-2" value="Declined">
                                    <label for="radio-in-2" class="cr">Decline</label>
                                </div>
                            </div>
                            @if($errors->has('responseBAKN'))
                                <br>
                                <small class="text-danger">Response harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Komentar</label>
                            <textarea class="form-control" rows="3" name="komentar" maxlength="200"
                                      placeholder="Maksimal 200 karakter"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success font-weight-bold text-dark">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" action="{{ action('TasklistVendorController@responseSPK') }}">
        {{ csrf_field() }}
        <div class="modal fade modal-ResponSPK" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLiveLabel">Task Response</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control bg-light" type="hidden" name="spkID" id="spkID" readonly>
                        <div class="form-group">
                            <label>Response <span class="text-danger">*</span></label>
                            <br>
                            <div class="form-group d-inline">
                                <div class="radio d-inline">
                                    <input type="radio" name="responseSPK" id="radio-in-3" value="Accepted">
                                    <label for="radio-in-3" class="cr">Accept</label>
                                </div>
                            </div>
                            <div class="form-group d-inline">
                                <div class="radio d-inline">
                                    <input type="radio" name="responseSPK" id="radio-in-4" value="Declined">
                                    <label for="radio-in-4" class="cr">Decline</label>
                                </div>
                            </div>
                            @if($errors->has('responseSPK'))
                                <br>
                                <small class="text-danger">Response harus diisi</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Komentar</label>
                            <textarea class="form-control" rows="3" name="komentar" maxlength="200"
                                      placeholder="Maksimal 200 karakter"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success font-weight-bold text-dark">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        $(document).on('click', '.respon', function (e) {
            document.getElementById("spphID").value = $(this).attr('data-id');
        });
    </script>

    <script>
        $(document).on('click', '.responBAKN', function (e) {
            document.getElementById("baknID").value = $(this).attr('data-id');
        });
    </script>

    <script>
        $(document).on('click', '.responSPK', function (e) {
            document.getElementById("spkID").value = $(this).attr('data-id');
        });
    </script>

    <script>
        var nilaiPenawaran = document.getElementById('nilaiPenawaran');
        nilaiPenawaran.addEventListener('keyup', function (e) {
            nilaiPenawaran.value = formatRupiah(this.value);
        });
    </script>

    <script>
        function bukaTermin() {
            var x = document.getElementById("response").value;
            if (x == 'Accepted') {
                $("#keteranganNomor").show();
            } else if (x == 'Declined') {
                $("#keteranganNomor").hide();
            } else {
                $("#keteranganNomor").hide();
            }
        }
    </script>

    <script>
        @if (count($errors) > 0)
        toastr.warning('Data yang anda isi belum lengkap', 'Warning', {closeButton: true});
        @endif
    </script>
@stop
