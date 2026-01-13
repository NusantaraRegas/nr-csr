@extends('layout.master')
@section('title', 'NR SHARE | Export Payment')
@section('content')
    <div class="container-fluid">
        <style>
            .model-huruf-family {
                font-family: "Trebuchet MS", Verdana, sans-serif;
            }
        </style>

        <form method="post" action="{{ action('APIController@storePaymentRequest') }}">
            {{ csrf_field() }}
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="font-weight-bold model-huruf-family">EXPORT PAYMENT</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('data-pembayaran') }}">To-Do List</a>
                            </li>
                            <li class="breadcrumb-item active">Export Payment</li>
                        </ol>
                        <button type="submit" class="btn btn-info d-lg-block m-l-15">
                            Export to Popay
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white model-huruf-family">Update Attribute</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Provinsi <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="provinsi" id="provinsi"
                                            style="width: 100%">
                                        <option>{{ $dataPembayaran->provinsi }}</option>
                                        @foreach($dataProvinsi as $provinsi)
                                            <option>{{ ucwords($provinsi->provinsi) }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('provinsi'))
                                        <small class="text-danger">Provinsi harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kota/Kabupaten <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="kabupaten" id="kabupaten"
                                            style="width: 100%">
                                        <option>{{ $dataPembayaran->kabupaten }}</option>
                                        @foreach($dataKabupaten as $kabupaten)
                                            <option>{{ ucwords($kabupaten->city_name) }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('kabupaten'))
                                        <small class="text-danger">Kota/Kabupaten harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Program Kerja <span class="text-danger">*{{ " #".$proker->id_proker }}</span></label>
                                <input type="hidden" class="form-control text-center" name="prokerID"
                                       value="{{ $proker->id_proker }}" readonly>
                                <input type="text" class="form-control" value="{{ $proker->proker }}" readonly>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Pilar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pilar" value="{{ $proker->pilar }}"
                                           readonly>
                                    @if($errors->has('pilar'))
                                        <small class="text-danger">Pilar harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Goals <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tpb" value="{{ $proker->gols }}"
                                           readonly>
                                    @if($errors->has('tpb'))
                                        <small class="text-danger">Goals harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group mb-0 col-md-6">
                                    <label>Prioritas</label>
                                    <input type="text" class="form-control" name="prioritas"
                                           value="{{ $proker->prioritas }}" readonly>
                                </div>
                                <div class="form-group mb-0 col-md-6">
                                    <label>Anggaran Tersedia</label>
                                    <input type="text" class="form-control"
                                           value="{{ "Rp".number_format($terpakai,2,',','.') }}" readonly>
                                    <input type="hidden" class="form-control" name="sisaAnggaran"
                                           value="{{ $terpakai }}"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white model-huruf-family">Payment Information</h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" class="form-control" name="ID" id="ID"
                                   value="{{ $dataPembayaran->id_pembayaran }}">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Invoice Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-uppercase" name="noInvoice">
                                    @if($errors->has('noInvoice'))
                                        <small class="text-danger">No invoice harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Invoice Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="tanggal-mulai"
                                               class="form-control" onchange="ubahTanggal()"
                                               name="invoiceDate" value="{{ old('invoiceDate') }}">
                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i
                                                                        class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    @if($errors->has('invoiceDate'))
                                        <small class="text-danger">Invoice date harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Invoice Due Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="tanggal-selesai"
                                               class="form-control"
                                               name="invoiceDueDate" value="{{ old('invoiceDueDate') }}">
                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i
                                                                        class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    @if($errors->has('invoiceDueDate'))
                                        <small class="text-danger">Invoice due date harus diisi</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>YKPP <span class="text-danger">*</span></label>
                                    <select class="form-control" name="ykpp">
                                        <option>No</option>
                                        <option>Yes</option>
                                    </select>
                                    @if($errors->has('ykpp'))
                                        <small class="text-danger">Kolom ini harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Budget Year <span class="text-danger">*</span></label>
                                    <select class="form-control" name="budget" id="budget"
                                            style="width: 100%">
                                        <option></option>
                                        @foreach($dataBudget as $budget)
                                            <option value="{{ $budget['budget_year'] }}">{{ $budget['budget_name'] }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('budget'))
                                        <small class="text-danger">Budget Year harus diisi</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Billing Amount</label>
                                    <input type="text" class="form-control" name="billingAmount"
                                           value="{{ "Rp".number_format($dataPembayaran->jumlah_pembayaran,2,',','.') }}"
                                           readonly>
                                    <input type="hidden" class="form-control" name="totalAmount"
                                           value="{{ $dataPembayaran->jumlah_pembayaran }}"
                                           readonly>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <label>Description Detail <span class="text-danger">*</span></label>
                                <textarea rows="3" class="form-control text-uppercase" name="deskripsi">{{ $dataPembayaran->kabupaten }} - {{ $dataPembayaran->asal_surat }} : BERDASARKAN {{ $dataPembayaran->perihal }} PILAR {{ $dataPembayaran->pilar }} DALAM RANGKA {{ $dataPembayaran->deskripsi }}</textarea>
                                @if($errors->has('deskripsi'))
                                    <small class="text-danger">Description detail harus diisi</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    <script>
        function ubahTanggal() {
            document.getElementById("tanggal-selesai").value = '';
        }
    </script>

    <script>
        $(document).ready(function () {
            $("#budget").select2({
                placeholder: "Select Budget Year"
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
        @if (count($errors) > 0)
        toastr.warning("Data yang anda isi belum lengkap", "Warning", {closeButton: true});
        @endif
    </script>
@stop