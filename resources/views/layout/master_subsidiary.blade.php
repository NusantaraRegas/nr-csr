<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/assets/images/logoicon.png') }}">
    <link href="{{ asset('template/assets/node_modules/icheck/skins/all.css') }}" rel="stylesheet">
    <link
        href="{{ asset('template/assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
        rel="stylesheet">
    <link href="{{ asset('template/assets/node_modules/wizard/steps.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/node_modules/css-chart/css-chart.css') }}" rel="stylesheet">

    <!-- Page plugins css -->
    <link href="{{ asset('template_ap/dist/css/pages/form-icheck.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('template/assets/node_modules/footable/css/footable.core.css') }}" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="{{ asset('template/assets/node_modules/jquery-asColorPicker-master/css/asColorPicker.css') }}"
        rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="{{ asset('template/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="{{ asset('template/assets/node_modules/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/node_modules/bootstrap-daterangepicker/daterangepicker.css') }}"
        rel="stylesheet">
    <!-- alerts CSS -->
    <link href="{{ asset('template/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet"
        type="text/css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('template/assets/node_modules/toast-master/toastr.min.css') }}">
    <!-- Select 2 css -->
    <link href="{{ asset('template/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/assets/node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- wysihtml5 CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}" />
    <!-- page css -->
    <link href="{{ asset('template_ap/dist/css/pages/ribbon-page.css') }}" rel="stylesheet">
    <link href="{{ asset('template_ap/dist/css/pages/contact-app-page.css') }}" rel="stylesheet">
    <link href="{{ asset('template_ap/dist/css/pages/footable-page.css') }}" rel="stylesheet">
    <link href="{{ asset('template_ap/dist/css/pages/easy-pie-chart.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('template_ap/dist/css/style.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="skin-blue fixed-layout model-huruf-family">

    <div class="preloader">
        <div class="loader">
            <div><img src="{{ asset('template/assets/images/logoicon.png') }}" width="48" height="48"
                    alt="Logo NR"></div>
            <p class="loader__label">Loading page</p>
        </div>
    </div>

    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('dashboardSubsidiary') }}">
                        <b>
                            <img src="{{ asset('template/assets/images/logo-pertamina.png') }}" width="60px"
                                alt="homepage" class="light-logo">
                        </b>
                        <span>
                            <img src="{{ asset('template/assets/images/text-pertamina.png') }}" width="100px"
                                alt="homepage" style="margin-top: -10px" class="light-logo">
                        </span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark"
                                href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a
                                class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
                                href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic"
                                href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="hidden-md-down">
                                    <b class="text-white">Selamat Datang, {{ session('user')->nama }}</b>&nbsp;
                                </span>
                                <img src="{{ asset('template/assets/images/icon/man.png') }}" alt="user">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <a href="{{ route('logout') }}" class="dropdown-item"><i
                                        class="fa fa-power-off mr-2" style="color:red"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="user-pro">
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <img src="{{ asset('template/assets/images/icon/man.png') }}" width="24px"
                                    alt="user">
                                <span class="hide-menu">{{ session('user')->nama }}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{ route('logout') }}"><i class="fa fa-power-off ml-3 mr-2"
                                            style="color:red"></i>Logout</a></li>
                            </ul>
                        </li>
                        <li class="nav-small-cap">--- MAIN MENU</li>
                        <li class="{{ Request::is('subsidiary/dashboard*') ? 'active' : '' }}"> <a
                                class="waves-effect waves-dark" href="{{ route('dashboardSubsidiary') }}"
                                aria-expanded="false"><img
                                    src="{{ asset('template/assets/images/icon/pie-chart.png') }}" width="24px">
                                <span class="hide-menu">&nbsp;&nbsp;Dashboard</span></a></li>
                        <li class="{{ Request::is('subsidiary/realisasi/editProposal*') ? 'active' : '' }}"> <a
                                class="waves-effect waves-dark" href="{{ route('createNonProposalSubsidiary') }}"
                                aria-expanded="false"><img
                                    src="{{ asset('template/assets/images/icon/agreement.png') }}" width="24px">
                                <span class="hide-menu">&nbsp;&nbsp;Realisasi</span></a></li>
                        {{--                    <li class="{{ Request::is('subsidiary/realisasi/editProposal*') ? 'active' : '' }}"><a class="has-arrow waves-effect waves-dark {{ Request::is('subsidiary/realisasi/editProposal*') ? 'active' : '' }}" href="javascript:void(0)" --}}
                        {{--                           aria-expanded="false"><img --}}
                        {{--                                    src="{{ asset('template/assets/images/icon/agreement.png') }}" width="24px"><span --}}
                        {{--                                    class="hide-menu">&nbsp;&nbsp;&nbsp;Realisasi</span></a> --}}
                        {{--                        <ul aria-expanded="false" class="collapse {{ Request::is('subsidiary/realisasi/editProposal*') ? 'in' : '' }}"> --}}
                        {{--                            <li class="{{ Request::is('subsidiary/realisasi/editProposal*') ? 'active' : '' }}"><a class="m-l-10 {{ Request::is('subsidiary/realisasi/editProposal*') ? 'active' : '' }}" href="{{ route('createProposalSubsidiary') }}">Proposal</a></li> --}}
                        {{--                            <li><a class="m-l-10" href="{{ route('createNonProposalSubsidiary') }}">Non Proposal</a></li> --}}
                        {{--                        </ul> --}}
                        {{--                    </li> --}}
                        <li class="{{ Request::is('subsidiary/anggaran/indexProkerYear*') ? 'active' : '' }}">
                            <a class="has-arrow waves-effect waves-dark {{ Request::is('subsidiary/anggaran/indexProkerYear*') ? 'active' : '' }}"
                                href="javascript:void(0)" aria-expanded="false"><img
                                    src="{{ asset('template/assets/images/icon/money-bag.png') }}"
                                    width="24px"><span class="hide-menu">&nbsp;&nbsp;&nbsp;Budget Control</span></a>
                            <ul aria-expanded="false"
                                class="collapse {{ Request::is('subsidiary/anggaran/indexProkerYear*') ? 'in' : '' }}">
                                <li><a class="m-l-10" href="{{ route('indexBudgetSubsidiary') }}">Anggaran</a></li>
                                <li class="{{ Request::is('subsidiary/anggaran/indexProkerYear*') ? 'active' : '' }}">
                                    <a class="m-l-10 {{ Request::is('subsidiary/anggaran/indexProkerYear*') ? 'active' : '' }}"
                                        href="{{ route('indexProkerSubsidiary') }}">Alokasi Program Kerja</a>
                                </li>
                                <li><a class="m-l-10" href="{{ route('indexRelokasiSubsidiary') }}">Relokasi</a></li>
                            </ul>
                        </li>
                        <li class="nav-small-cap">--- HISTORY &amp; REPORT</li>
                        <li
                            class="{{ Request::is('subsidiary/report/indexRealisasiSubsidiary*') ? 'active' : '' }} {{ Request::is('subsidiary/report/indexRealisasiProker*') ? 'active' : '' }} {{ Request::is('subsidiary/report/viewDetailRealisasiSubsidiary*') ? 'active' : '' }}">
                            <a class="has-arrow waves-effect waves-dark {{ Request::is('subsidiary/report/indexRealisasiSubsidiary*') ? 'active' : '' }} {{ Request::is('subsidiary/report/indexRealisasiProker*') ? 'active' : '' }} {{ Request::is('subsidiary/report/viewDetailRealisasiSubsidiary*') ? 'active' : '' }}"
                                href="javascript:void(0)" aria-expanded="false"><img
                                    src="{{ asset('template/assets/images/icon/statistics.png') }}" width="24px">
                                <span class="hide-menu">&nbsp;&nbsp;Report</span>
                            </a>
                            <ul aria-expanded="false"
                                class="collapse {{ Request::is('subsidiary/report/indexRealisasiSubsidiary*') ? 'in' : '' }} {{ Request::is('subsidiary/report/indexRealisasiProker*') ? 'in' : '' }} {{ Request::is('subsidiary/report/viewDetailRealisasiSubsidiary*') ? 'in' : '' }}">
                                <li
                                    class="{{ Request::is('subsidiary/report/indexRealisasiSubsidiary*') ? 'active' : '' }}">
                                    <a class="m-l-10 {{ Request::is('subsidiary/report/indexRealisasiSubsidiary*') ? 'active' : '' }} {{ Request::is('subsidiary/report/viewDetailRealisasiSubsidiary*') ? 'active' : '' }}"
                                        href="{{ route('indexRealisasiSubsidiary') }}">Detail Realisasi</a>
                                </li>
                                <li
                                    class="{{ Request::is('subsidiary/report/indexRealisasiProker*') ? 'active' : '' }}">
                                    <a class="m-l-10 {{ Request::is('subsidiary/report/indexRealisasiProker*') ? 'active' : '' }}"
                                        href="{{ route('indexRealisasiProkerSubsidiary') }}">Realisasi Program
                                        Kerja</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-small-cap">--- SETTINGS</li>
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false"><img
                                    src="{{ asset('template/assets/images/icon/settings.png') }}"
                                    width="24px"><span class="hide-menu">&nbsp;&nbsp;&nbsp;Settings</span></a>
                            <ul aria-expanded="false" class="collapse">
                                {{--                            <li><a class="m-l-10" href="javascript:void(0)">Users</a></li> --}}
                                <li><a class="m-l-10" href="{{ route('indexLembagaSubsidiary') }}">Penerima
                                        Bantuan</a>
                                    {{--                            <li><a class="m-l-10" href="{{ route('indexStakeholderSubsidiary') }}">Stakeholder Internal</a></li> --}}
                            </ul>
                        </li>
                        <li class="nav-small-cap">--- SUPPORT</li>
                        <li> <a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><img
                                    src="{{ asset('template/assets/images/icon/archive.png') }}" width="24px">
                                <span class="hide-menu">&nbsp;&nbsp;Manual Book</span></a></li>
                        <li> <a class="waves-effect waves-dark" target="_blank"
                                href="https://api.whatsapp.com/send?phone=6281908885453&text=Mohon%20bantuannya%20terkait%20aplikasi%20PGN SHARE%20"
                                aria-expanded="false"><img
                                    src="{{ asset('template/assets/images/icon/help-desk.png') }}" width="24px">
                                <span class="hide-menu">&nbsp;&nbsp;Help</span></a></li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-wrapper">
            @yield('content')
        </div>

        <footer class="footer">
            Copyright © 2018 PT Perusahaan Gas Negara Tbk All Rights Reserved
        </footer>

    </div>

    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('template/assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('template/assets/node_modules/popper/popper.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('template_ap/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('template_ap/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('template_ap/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('template_ap/dist/js/custom.min.js') }}"></script>
    <!--stickey kit -->
    <script src="{{ asset('template/assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- This is data table -->
    <script src="{{ asset('template/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- Sweet-Alert  -->
    <script src="{{ asset('template/assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('template/assets/node_modules/toast-master/toastr.min.js') }}"></script>
    <!-- Plugin JavaScript -->
    <script src="{{ asset('template/assets/node_modules/moment/moment.js') }}"></script>
    <script
        src="{{ asset('template/assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
    </script>
    <script src="{{ asset('template/assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript">
    </script>

    <!-- Clock Plugin JavaScript -->
    <script src="{{ asset('template/assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="{{ asset('template/assets/node_modules/jquery-asColorPicker-master/libs/jquery-asColor.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/jquery-asColorPicker-master/libs/jquery-asGradient.js') }}">
    </script>
    <script src="{{ asset('template/assets/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js') }}">
    </script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{ asset('template/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="{{ asset('template/assets/node_modules/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- icheck -->
    <script src="{{ asset('template/assets/node_modules/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/icheck/icheck.init.js') }}"></script>

    <!--Morris JavaScript -->
    <script src="{{ asset('template/assets/node_modules/raphael/raphael-min.js') }}"></script>

    <!--Custom JavaScript -->
    <script src="{{ asset('template/assets/node_modules/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/wizard/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/wizard/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/wizard/steps.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}"></script>

    <!-- EASY PIE CHART JS -->
    <script src="{{ asset('template/assets/node_modules/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}">
    </script>
    <script src="{{ asset('template/assets/node_modules/jquery.easy-pie-chart/easy-pie-chart.init.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('template/assets/node_modules/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/peity/jquery.peity.init.js') }}"></script>

    <!-- Footable -->
    <script src="{{ asset('template/assets/node_modules/footable/js/footable.all.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}"
        type="text/javascript"></script>
    <!--FooTable init-->
    <script src="{{ asset('template_ap/dist/js/pages/footable-init.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.textarea_editor').wysihtml5();
        });
    </script>

    <script>
        jQuery(document).ready(function() {
            // For select 2
            $(".select2").select2();
            $('.selectpicker').selectpicker();
        });
    </script>

    <script>
        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))

                return false;
            return true;
        }
    </script>

    <script>
        // Date Picker
        jQuery('.mydatepicker, #datepicker').datepicker();
        jQuery('.datepicker-autoclose').datepicker({
            autoclose: true,
            format: 'dd-M-yyyy',
            todayHighlight: true,
            orientation: 'bottom auto'
        });

        jQuery('.datepicker-autoclose2').datepicker({
            autoclose: true,
            format: 'dd-M-yyyy',
            todayHighlight: true,
            orientation: 'bottom auto'
        });

        // Clock pickers
        $('.clockpicker').clockpicker({
            donetext: 'Done',
            'default': 'now',
        }).find('input').change(function() {
            console.log(this.value);
        });

        var dateMin = "01/Jan/2022";

        // Material Date picker
        $('.mdate').bootstrapMaterialDatePicker({
            format: 'DD-MM-YYYY',
            minDate: new Date(),
            time: false
        });
        $('#timepicker').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            time: true,
            date: false
        });
        $('#date-format').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY - HH:mm'
        });

        $('.min-date').bootstrapMaterialDatePicker({
            format: 'DD-MMM-YYYY',
            minDate: new Date(),
            time: false
        });
        $('.max-date').bootstrapMaterialDatePicker({
            format: 'DD-MMM-YYYY',
            minDate: dateMin,
            maxDate: new Date(),
            time: false
        });
    </script>

    <script>
        $(function() {
            $(".example1").DataTable();

            $('.example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": false,
                "autoWidth": false
            });

            $('.example3').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": false,
                "autoWidth": false
            });

            $('.example4').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });

            $('.example5').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false
            });
        });
    </script>

    <script>
        @if (Session::has('gagal'))
            toastr.error("{{ Session::get('gagal') }}", "Failed", {
                closeButton: true
            });
        @endif

        @if (Session::has('berhasil'))
            toastr.success("{{ Session::get('berhasil') }}", "Success", {
                closeButton: true
            });
        @endif

        @if (Session::has('peringatan'))
            swal("Warning", "{{ Session::get('peringatan') }}", "warning");
        @endif

        @if (Session::has('SuksesLogin'))
            swal("Login Berhasil", "{{ Session::get('SuksesLogin') }}", "success");
        @endif

        @if (Session::has('sukses'))
            swal("Success", "{{ Session::get('sukses') }}", "success");
        @endif
    </script>

    @yield('footer')
</body>

</html>
