@extends('master')
@section('title', 'SHARE | Data Pembayaran Proposal')
@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor text-uppercase">Data Pembayaran Proposal</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Data Pembayaran Popay</li>
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
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Pembayaran
                        </h4>
                        <div class="table-responsive">
                            @verbatim
                                <table id="myTable" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th width="10px" style="text-align:center;">No</th>
                                        <th width="200px">No Invoice</th>
                                        <th width="200px">Deskripsi</th>
                                        <th width="200px">Jumlah</th>
                                        <th width="50px">Termin</th>
                                        <th width="50px">ID PR</th>
                                        <th width="100px">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(d, index) in dataPayment" :key="d.id">
                                        <td style="text-align:center;">{{ index + 1 }}</td>
                                        <td>{{ d.noInvoice }}</td>
                                        <td>{{ d.deskripsi }}</td>
                                        <td>{{ d.jumlah }}</td>
                                        <td>{{ d.termin }}</td>
                                        <td>{{ d.id }}</td>
                                        <td>{{ d.status }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            @endverbatim
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
    </div>
@endsection

@section('footer')
    <script>
        new Vue({
            el: "#vueapp",
            data: {
                dataPayment: [],
            },
            mounted() {
                this.getPayment();
            },
            methods: {
                getPayment() {
                    axios.get(`${window.BASEURL}/api/ExportCSR/PaymentRequest/export-popay`)
                        .then(response => {
                            this.dataPayment = response.data.result;
                        })
                        .catch(response => {
                            console.log(response);
                        })
                },
            }
        })
    </script>
@stop