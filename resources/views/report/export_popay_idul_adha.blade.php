@extends('layout.master')
@section('title', 'SHARE | Export Pembayaran')
@section('content')
    <div class="container">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="font-weight-bold text-uppercase">Export Pembayaran<br><small class="text-muted">{{ $dataPembayaran->no_agenda }}</small></h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('detail-kelayakan', encrypt($dataPembayaran->no_agenda)) }}">Detail Proposal</a></li>
                        <li class="breadcrumb-item active">Export Pembayaran</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form method="post" action="{{ action('APIController@storePaymentRequestIdulAdha') }}">
                    <div class="card">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="card-title mb-5">PAYMENT INFORMATION</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="hidden" class="form-control" name="ID" id="ID" value="{{ $dataPembayaran->id_pembayaran }}">
                                            <input type="hidden" class="form-control" name="userID"
                                                   value="1211">
                                            <input type="hidden" class="form-control" name="username"
                                                   value="dinar.valupi">
                                            <input type="hidden" class="form-control" name="orgID"
                                                   value="100">
                                            <input type="hidden" class="form-control" name="divID"
                                                   value="A035">
                                            <div class="form-group">
                                                <label>Invoice Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-uppercase" name="noInvoice">
                                                @if($errors->has('noInvoice'))
                                                    <small class="text-danger">No invoice harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Invoice Date <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker-autoclose"
                                                           name="invoiceDate">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                    class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                                @if($errors->has('invoiceDate'))
                                                    <small class="text-danger">Invoice date harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Invoice Due Date <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker-autoclose"
                                                           name="invoiceDueDate">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                    class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                                @if($errors->has('invoiceDueDate'))
                                                    <small class="text-danger">Invoice due date harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Billing Amount</label>
                                                <input type="text" class="form-control" name="billingAmount"
                                                       value="Rp. {{ number_format($dataPembayaran->jumlah_pembayaran,2,',','.') }}"
                                                       readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
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
                                            <div class="form-group">
                                                <label>Description Detail <span class="text-danger">*</span></label>
                                                <textarea rows="3" class="form-control text-uppercase" name="deskripsi">{{ $dataPembayaran->kabupaten }} - {{ $dataPembayaran->asal_surat }} - SEKTOR {{ $dataPembayaran->sektor_bantuan }} DALAM RANGKA {{ $dataPembayaran->bantuan_untuk }}</textarea>
                                                @if($errors->has('deskripsi'))
                                                    <small class="text-danger">Description detail harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h5 class="card-title mb-5 mt-5">RECEIVER INFORMATION</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Receiver Name <span class="text-danger">*</span></label>
                                                <select class="form-control" name="receiverName" id="receiverName"
                                                        style="width: 100%">
                                                    <option></option>
                                                    @foreach($dataSupplier as $sup)
                                                        <option number="{{ $sup['number'] }}" type="{{ $sup['type'] }}"
                                                                npwp="{{ $sup['npwp'] }}"
                                                                email="{{ $sup['email'] }}">{{ $sup['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('receiverName'))
                                                    <small class="text-danger">Receiver name harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Receiver Type <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="receiverType"
                                                               id="receiverType" placeholder="Automated by system"
                                                               readonly>
                                                        @if($errors->has('receiverType'))
                                                            <small class="text-danger">Receiver type harus diisi</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Receiver Number <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="receiverNumber"
                                                               id="receiverNumber" placeholder="Automated by system"
                                                               readonly>
                                                        @if($errors->has('receiverNumber'))
                                                            <small class="text-danger">Receiver number harus
                                                                diisi</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Receiver Email <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="receiverEmail"
                                                       id="receiverEmail">
                                                @if($errors->has('receiverEmail'))
                                                    <small class="text-danger">Receiver email harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Receiver Tax ID</label>
                                                <input type="text" class="form-control" name="receiverTax"
                                                       id="receiverTax" placeholder="Automated by system" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Site Name <span class="text-danger">*</span></label>
                                                <select class="form-control" name="siteName" id="siteName" disabled
                                                        style="width: 100%">
                                                    <option></option>
                                                </select>
                                                @if($errors->has('siteName'))
                                                    <small class="text-danger">Site name harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Receiver Address <span class="text-danger">*</span></label>
                                                <textarea rows="3" class="form-control" name="receiverAddress"
                                                          id="receiverAddress" placeholder="Automated by system"
                                                          readonly></textarea>
                                                @if($errors->has('receiverAddress'))
                                                    <small class="text-danger">Receiver address harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h5 class="card-title mb-5 mt-5">BANK INFORMATION</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Account Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="accountNumber" value="{{ $dataPembayaran->no_rekening }}" placeholder="Maksimal 35 Karakter">
                                                @if($errors->has('accountNumber'))
                                                    <small class="text-danger">Account number harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Account Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="accountName" value="{{ $dataPembayaran->atas_nama }}" placeholder="Maksimal 35 Karakter">
                                                @if($errors->has('accountName'))
                                                    <small class="text-danger">Account name harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Bank Name <span class="text-danger">*</span></label>
                                                <select class="select2 form-control" name="bankName"
                                                        style="width: 100%">
                                                    <option value="{{ $dataPembayaran->kode_bank }}">{{ $dataPembayaran->nama_bank }}</option>
                                                    @foreach($dataBank as $bank)
                                                        <option value="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('bankName'))
                                                    <small class="text-danger">Bank name harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Bank City <span class="text-danger">*</span></label>
                                                <select class="select2 form-control" name="bankCity"
                                                        style="width: 100%">
                                                    <option value="{{ $dataPembayaran->kode_kota }}">{{ $dataPembayaran->kota_bank }}</option>
                                                    @foreach($dataCity as $city)
                                                        <option value="{{ $city['city_code'] }}">{{ $city['city_name'] }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('bankCity'))
                                                    <small class="text-danger">Bank city harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Bank Branch <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="bankBranch" placeholder="Maksimal 35 Karakter" value="{{ $dataPembayaran->cabang_bank }}">
                                                @if($errors->has('bankBranch'))
                                                    <small class="text-danger">Bank branch harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="emailBank">
                                                @if($errors->has('emailBank'))
                                                    <small class="text-danger">Email harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Receiver Type <span class="text-danger">*</span></label>
                                                <select class="form-control" name="receiverBank" id="receiverBank"
                                                        style="width: 100%">
                                                    <option></option>
                                                    @foreach($dataReceiver as $receiver)
                                                        <option value="{{ $receiver['id'] }}">{{ $receiver['detail'] }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('receiverBank'))
                                                    <small class="text-danger">Receiver type harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Citizen <span class="text-danger">*</span></label>
                                                <select class="form-control" name="citizen" id="citizen"
                                                        style="width: 100%">
                                                    <option></option>
                                                    @foreach($dataNationality as $nationality)
                                                        <option value="{{ $nationality['id'] }}">{{ $nationality['detail'] }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('citizen'))
                                                    <small class="text-danger">Citizen harus diisi</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Total Amount <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="totalAmount" id="totalAmount" value="{{ number_format($dataPembayaran->jumlah_pembayaran,0,',','.') }}">
                                                @if($errors->has('totalAmount'))
                                                    <small class="text-danger">Total amount harus diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <a href="{{ route('detail-kelayakan', encrypt($dataPembayaran->no_agenda)) }}">
                                    <button type="button" class="btn btn-secondary waves-effect text-left">
                                        <i class="fa fa-times-circle mr-2"></i>Cancel
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-success waves-effect text-left"><i
                                            class="fa fa-send mr-2"></i>Export
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
        $(document).ready(function () {
            $("#receiverName").select2({
                placeholder: "Select Receiver"
            });

            $("#budget").select2({
                placeholder: "Select Budget Year"
            });

            $("#coaAccount").select2({
                placeholder: "Select COA Account"
            });

            $("#coaElemenBiaya").select2({
                placeholder: "Select COA Elemen Biaya"
            });

            $("#bankName").select2({
                placeholder: "Select Bank Name"
            });

            $("#bankCity").select2({
                placeholder: "Select Bank City"
            });
        });
    </script>

    <script>
        $('#receiverName').on('change', function () {
            var number = $('#receiverName option:selected').attr('number');
            var type = $('#receiverName option:selected').attr('type');
            var npwp = $('#receiverName option:selected').attr('npwp');
            var email = $('#receiverName option:selected').attr('email');
            $('#receiverNumber').val(number);
            $('#receiverType').val(type);
            $('#receiverTax').val(npwp);
            $('#receiverEmail').val(email);

            $.ajax({
                type: 'GET',
                url: "/exportPopay/siteReceiver/" + number + "",
                success: function (response) {
                    $('#siteName').html(response);
                    $("#siteName").prop("disabled", false);
                }
            });

            // $("#siteName").select2({
            //     placeholder: "Select Receiver"
            // });
        });
    </script>

    <script>
        $('#siteName').on('change', function () {
            var address = $('#siteName option:selected').attr('address');
            $('#receiverAddress').val(address);
        });
    </script>

    <script>
        var totalRupiah = document.getElementById('totalAmount');
        totalRupiah.addEventListener('keyup', function (e) {
            totalRupiah.value = formatRupiah(this.value);
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
        toastr.error('Data yang anda isi belum lengkap', 'Failed', {closeButton: true});
        @endif
    </script>
@stop