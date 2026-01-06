<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Datta Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords"
        content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, datta able, datta able bootstrap admin template">
    <meta name="author" content="CSR" />

    <link rel="icon" href="{{ asset('template_vendor/assets/images/logoicon.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('template_vendor/assets/fonts/fontawesome/css/fontawesome-all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template_vendor/assets/plugins/animation/css/animate.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template_vendor/assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('template_vendor/assets/plugins/toastr/toastr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template_vendor/assets/plugins/data-tables/css/datatables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template_vendor/assets/plugins/bootstrap-sweetalert/sweetalert.css') }}">

    <link rel="stylesheet"
        href="{{ asset('template_vendor/assets/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">

    <link rel="stylesheet"
        href="{{ asset('template_vendor/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_vendor/assets/fonts/material/css/materialdesignicons.min.css') }}">

</head>

<body class="layout-6"
    style="background: linear-gradient(to right, rgb(164, 69, 178) 0%, rgb(212, 24, 114) 52%, rgb(255, 0, 102) 100%);">

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>


    <nav class="pcoded-navbar menu-light brand-lightblue icon-colored menupos-static">
        <div class="navbar-wrapper">
            <div class="navbar-brand header-logo">
                <a href="{{ route('dashboardVendor') }}" class="b-brand">
                    <div class="b-bg">
                        <img src="{{ asset('template_vendor/assets/images/logoicon.png') }}" width="30px">
                    </div>
                    <span class="b-title font-weight-bold">PGN SHARE</span>
                </a>
                <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            </div>
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar">
                    <li class="nav-item pcoded-menu-caption">
                        <label>Navigation</label>
                    </li>
                    <li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
                        <a href="{{ route('dashboardVendor') }}" class="nav-link">
                            <span class="pcoded-micon">
                                <i class="feather icon-home"></i>
                            </span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('Vendor/detailVendor*') ? 'active' : '' }}">
                        <a href="{{ route('detailVendor', encrypt(session('user')->vendor_id)) }}" class="nav-link">
                            <span class="pcoded-micon">
                                <i class="fas fa-building"></i>
                            </span>
                            <span class="pcoded-mtext">Profile Perusahaan</span>
                        </a>
                    </li>
                    <li class="nav-item pcoded-menu-caption">
                        <label>History & Report</label>
                    </li>
                    <li
                        class="nav-item {{ Request::is('SPPH/dataSPPHVendor') ? 'active' : '' }} {{ Request::is('SPPH/detailSPPH*') ? 'active' : '' }}">
                        <a href="#!" class="nav-link">
                            <span class="pcoded-micon">
                                <i class="feather icon-file-text"></i>
                            </span>
                            <span class="pcoded-mtext">History SPPH</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">
                            <span class="pcoded-micon">
                                <i class="feather icon-power"></i>
                            </span>
                            <span class="pcoded-mtext">Log Out</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <header class="navbar pcoded-header navbar-expand-lg navbar-light">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
            <a href="{{ route('dashboardVendor') }}" class="b-brand">
                <div class="b-bg">
                    <img src="{{ asset('template_vendor/assets/images/logoicon.png') }}" width="30px">
                </div>
                <span class="b-title">PGN SHARE</span>
            </a>
        </div>
        <a class="mobile-menu" id="mobile-header" href="#!">
            <i class="feather icon-more-horizontal"></i>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item navbar-collapse">
                    <a href="#!" class="full-screen text-white" onclick="javascript:toggleFullScreen()">
                        Selamat Datang, <b>{{ session('user')->perusahaan }}</b>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="dropdown drp-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon feather icon-settings"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                <img src="{{ asset('template_vendor/assets/images/user/avatar-2.jpg') }}"
                                    class="img-radius" alt="User-Profile-Image">
                                <span>{{ session('user')->perusahaan }}</span>
                            </div>
                            <ul class="pro-body">
                                <li>
                                    <a href="#!" class="dropdown-item">
                                        <i class="feather icon-settings"></i> Account Setting
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" class="dropdown-item">
                                        <i class="feather icon-log-out"></i> Log Out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </header>


    <section class="header-user-list">
        <div class="h-list-header">
            <div class="input-group">
                <input type="text" id="search-friends" class="form-control" placeholder="Search . . .">
            </div>
        </div>
        <div class="h-list-body">
            <a href="#!" class="h-close-text"><i class="feather icon-chevrons-right"></i></a>
            <div class="main-friend-cont scroll-div">
                <div class="main-friend-list">
                    @yield('log')
                </div>
            </div>
        </div>
    </section>


    <section class="header-chat">
        <div class="h-list-body">
            <div class="main-chat-cont scroll-div">

            </div>
        </div>
    </section>


    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('template_vendor/assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('template_vendor/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template_vendor/assets/js/pcoded.min.js') }}"></script>

    <!-- data tables Js -->
    <script src="{{ asset('template_vendor/assets/plugins/data-tables/js/datatables.min.js') }}"></script>
    <script src="{{ asset('template_vendor/assets/js/pages/tbl-datatable-custom.js') }}"></script>

    <script src="{{ asset('template_vendor/assets/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('template_vendor/assets/plugins/toastr/toastr.min.js') }}"></script>

    <!-- material datetimepicker Js -->
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script
        src="{{ asset('template_vendor/assets/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
    </script>

    <!-- form-picker-custom Js -->
    <script src="{{ asset('template_vendor/assets/js/pages/form-picker-custom.js') }}"></script>

    <script src="{{ asset('template_vendor/assets/plugins/inputmask/js/inputmask.min.js') }}"></script>
    <script src="{{ asset('template_vendor/assets/plugins/inputmask/js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('template_vendor/assets/plugins/inputmask/js/autoNumeric.js') }}"></script>

    <script src="{{ asset('template_vendor/assets/js/pages/form-masking-custom.js') }}"></script>

    <script>
        @if (Session::has('gagal'))
            swal("Failed", "{{ Session::get('gagal') }}", "error");
        @endif

        @if (Session::has('sukses'))
            swal("Success", "{{ Session::get('sukses') }}", "success");
        @endif

        @if (Session::has('perhatian'))
            swal("Warning", "{{ Session::get('perhatian') }}", "warning");
        @endif

        @if (Session::has('berhasil'))
            toastr.success("{{ Session::get('berhasil') }}", "Success");
        @endif

        @if (Session::has('failed'))
            toastr.error("{{ Session::get('failed') }}", "Failed");
        @endif
    </script>

    <script>
        $('.example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false
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

    @yield('footer')
    @yield('js')
</body>

</html>
