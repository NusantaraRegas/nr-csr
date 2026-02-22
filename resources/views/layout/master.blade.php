<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Aplikasi Manajemen Tanggung Jawab Sosial dan Lingkungan">
    <meta name="author" content="Sigit Sutrisno">

    <title>@yield('title')</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/logoicon.png') }}">
    <link href="{{ asset('assets/node_modules/icheck/skins/all.css') }}" rel="stylesheet">
    <link
        href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/node_modules/jquery-steps/demo/css/jquery.steps.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('assets/node_modules/css-chart/css-chart.css') }}" rel="stylesheet"> --}}

    <!-- Page plugins css -->
    <link href="{{ asset('template/dist/css/pages/form-icheck.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/node_modules/footable/css/footable.core.css') }}" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="{{ asset('assets/node_modules/jquery-asColorPicker/dist/css/asColorPicker.css') }}"
        rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="{{ asset('assets/node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="{{ asset('assets/node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/node_modules/daterangepicker/daterangepicker.css') }}"
        rel="stylesheet">
    <!-- alerts CSS -->
{{-- <link href="{{ asset('assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css"> --}}
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/node_modules/toastr/build/toastr.css') }}">
    <!-- Select 2 css -->
    <link href="{{ asset('assets/node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- wysihtml5 CSS -->
{{-- <link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}" /> --}}
    <!-- page css -->
    <link href="{{ asset('template/dist/css/pages/ribbon-page.css') }}" rel="stylesheet">
    <link href="{{ asset('template/dist/css/pages/contact-app-page.css') }}" rel="stylesheet">
    <link href="{{ asset('template/dist/css/pages/footable-page.css') }}" rel="stylesheet">
    {{--    <link href="{{ asset('template/css/pages/easy-pie-chart.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('template/dist/css/pages/easy-pie-chart.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('template/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/dist/css/custom.css') }}" rel="stylesheet">
    {{--    <link href="{{ asset('template/dist/css/chart-style.css') }}" rel="stylesheet"> --}}

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .dropdown-menu.mailbox::-webkit-scrollbar {
            width: 6px;
        }

        .dropdown-menu.mailbox::-webkit-scrollbar-thumb {
            background-color: #c1c1c1;
            border-radius: 3px;
        }

        .dropdown-menu.mailbox {
            scroll-behavior: smooth;
        }
    </style>

</head>

<body class="horizontal-nav skin-blue fixed-layout model-huruf-family">

    <div class="preloader">
        <div class="loader">
            <div><img src="{{ asset('assets/images/logoicon.png') }}" width="48" height="48"
                    alt="Logo NR"></div>
            <p class="loader__label">Loading page</p>
        </div>
    </div>

    <div id="main-wrapper">

        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">

                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('dashboard') }}">
                        <!-- Logo icon -->
                        <b>
                            <!-- Light Logo icon -->
                            <img src="{{ asset('assets/images/logo-pertamina-nusantara-regas.png') }}"
                                width="180px" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                    </a>
                </div>

                <div class="navbar-collapse">

                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark ml-5"
                                href="javascript:void(0)"><i class="ti-menu"></i></a>
                        </li>
                        <li class="nav-item"><a class="nav-link sidebartoggler d-none waves-effect waves-dark"
                                href="javascript:void(0)"><i class="icon-menu"></i></a></li>

                        <li class="nav-item">
                            <form class="app-search d-none d-md-block d-lg-block">
                                <span class="text-white"></span>
                            </form>
                        </li>
                    </ul>

                    <ul class="navbar-nav my-lg-0">
                        @php
                            $dataTask = App\Models\DetailApproval::with('maker')
                                ->where('status', 'In Progress')
                                ->where('id_user', session('user')->id_user)
                                ->orderBy('task_date', 'desc')
                                ->limit(10)
                                ->get();
                        @endphp

                        @if ($dataTask->count() > 0)

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#"
                                    id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-bell"></i>
                                    <div class="notify">
                                        <span class="heartbit"></span>
                                        <span class="point"></span>
                                    </div>
                                </a>

                                @php
                                    $isScrollable = count($dataTask) > 10;
                                @endphp

                                <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown"
                                    aria-labelledby="2"
                                    style="width: 350px; {{ $isScrollable ? 'max-height: 400px; overflow-y: auto; scroll-behavior: smooth;' : '' }}">
                                    <ul>
                                        <li>
                                            <div class="drop-title">Notifikasi Persetujuan</div>
                                        </li>
                                        <li>
                                            <div class="message-center">
                                                @foreach ($dataTask as $task)
                                                    <a href="{{ route('detailKelayakan', Crypt::encrypt($task->id_kelayakan)) }}"
                                                        class="d-flex align-items-start p-2 border-bottom">
                                                        <div class="user-img">
                                                            <img src="{{ $task->maker->foto_profile ? asset('storage/' . $task->maker->foto_profile) : asset('template/assets/images/user.png') }}"
                                                                alt="user" class="img-circle"
                                                                style="width: 45px; height: 45px;">
                                                            <span class="profile-status online pull-right"></span>
                                                        </div>
                                                        <div class="ml-2 w-100">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center">
                                                                <h6 class="mb-0 font-bold text-dark">
                                                                    {{ $task->maker->nama }}</h6>
                                                                <small
                                                                    class="text-muted">{{ \Carbon\Carbon::parse($task->task_date)->diffForHumans() }}</small>
                                                            </div>
                                                            <p class="text-muted mb-1">
                                                                {{ $task->phase . ' Proposal' }}
                                                            </p>
                                                            <div class="text-danger small">
                                                                {{ $task->pesan ?? 'Tidak ada catatan' }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </li>
                                        <li>
                                            <a class="nav-link text-center link" href="javascript:void(0);">
                                                <strong>Tutup</strong>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        @endif

                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="hidden-md-down"><b class="text-white">Selamat Datang,
                                        {{ session('user')->nama }}</b>&nbsp; </span>
                                <img src="{{ session('user')->foto_profile ? asset('storage/' . session('user')->foto_profile) : asset('template/assets/images/user.png') }}"
                                    alt="user">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <a href="{{ route('profile', encrypt(session('user')->id_user)) }}"
                                    class="dropdown-item font-weight-bold">
                                    <i class="fas fa-user mr-1 f-16"></i>
                                    Profile User
                                </a>
                                <a href="{{ route('logout') }}" class="dropdown-item font-weight-bold">
                                    <i class="fas fa-sign-out-alt mr-1 f-16" style="color: red"></i>
                                    Logout
                                </a>
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
                                <img src="{{ session('user')->foto_profile ? asset('storage/' . session('user')->foto_profile) : asset('template/assets/images/user.png') }}"
                                    alt="user">
                                <span class="hide-menu">{{ session('user')->nama }}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{ route('profile', encrypt(session('user')->id_user)) }}"><i
                                            class="ti-settings"></i> Account Setting</a></li>
                                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                        <li class="nav-small-cap">--- MAIN MENU</li>
                        <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                            <a class="waves-effect waves-dark" href="{{ route('dashboard') }}"
                                aria-expanded="false">
                                <i class="bi bi-speedometer" style="font-size: 24px"></i>
                                <span class="hide-menu">&nbsp;Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{ route('createProposal') }}"
                                aria-expanded="false">
                                <i class="bi bi-journal-bookmark-fill" style="font-size: 24px"></i>
                                <span class="hide-menu">&nbsp;Kelayakan Proposal</span>
                            </a>
                        </li>
                        @if (session('user')->role == 'Payment' or session('user')->role == 'Admin')
                            <li>
                                <a class="waves-effect waves-dark" href="{{ route('createOperasional') }}"
                                    aria-expanded="false">
                                    <i class="bi bi-journal-plus" style="font-size: 24px"></i>
                                    <span class="hide-menu">&nbsp;Operasional</span>
                                </a>
                            </li>
                        @endif
                        @if (session('user')->role == 'Payment' or session('user')->role == 'Admin')
                            <li
                                class="{{ Request::is(['master/inputProker', 'anggaran/indexBudget*', 'anggaran/dataProker*', 'anggaran/indexRelokasi*', 'anggaran/createRelokasi']) ? 'active' : '' }}">
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i class="bi bi-cash-coin" style="font-size: 24px"></i>
                                    <span class="hide-menu">&nbsp;Anggaran</span></a>
                                <ul aria-expanded="false"
                                    class="collapse {{ Request::is(['master/inputProker', 'anggaran/indexBudget*', 'anggaran/dataProker*', 'anggaran/indexRelokasi*', 'anggaran/createRelokasi']) ? 'in' : '' }}">
                                    <li>
                                        <a href="{{ route('indexBudget') }}"
                                            class="{{ Request::is(['anggaran/indexBudget*']) ? 'active' : '' }}">
                                            Anggaran
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('data-proker') }}"
                                            class="{{ Request::is(['master/inputProker', 'anggaran/dataProker*']) ? 'active' : '' }}">
                                            Program Kerja
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('indexRelokasi') }}"
                                            class="{{ Request::is(['anggaran/indexRelokasi*', 'anggaran/createRelokasi']) ? 'active' : '' }}">
                                            Relokasi
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="nav-small-cap">--- REPORT</li>
                        <li
                            class="{{ Request::is(['report/detailKelayakan*', 'report/dataKelayakan*', 'report/editKelayakan*', 'exportPopay/viewPaymentRequest*', 'report/LaporanKelayakan', 'report/dataPeriode*', '/report/listPaymentRequest', '/report/listPaymentRequestProposal', 'report/listPaymentYKPP*', 'report/indexPembayaran*', 'report/indexRealisasiProker*', 'report/indexRealisasiPilar*', 'report/indexRealisasiPrioritas*', 'report/detailRealisasiSubsidiary']) ? 'active' : '' }}">
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="bi bi-clipboard-data-fill" style="font-size: 24px"></i>
                                <span class="hide-menu">&nbsp;Laporan</span>
                            </a>
                            <ul aria-expanded="false"
                                class="collapse {{ Request::is(['report/detailKelayakan*', 'report/dataKelayakan*', 'report/editKelayakan*', 'report/dataBulan*', 'report/dataToday']) ? 'in' : '' }}">
                                <li>
                                    <a href="{{ route('dataKelayakan') }}"
                                        class="{{ Request::is(['report/detailKelayakan*', 'report/dataKelayakan*', 'report/editKelayakan*']) ? 'active' : '' }}">Rekap
                                        Kelayakan
                                        Proposal</a>
                                </li>
                                <li class="{{ Request::is(['report/listPaymentYKPP*']) ? 'active' : '' }}">
                                    <a class="has-arrow waves-effect waves-dark {{ Request::is(['report/listPaymentYKPP*']) ? 'active' : '' }}"
                                        href="javascript:void(0)" aria-expanded="false">
                                        <span class="hide-menu">Penyaluran TJSL-YKPP</span>
                                    </a>
                                    <ul aria-expanded="false"
                                        class="collapse {{ Request::is(['report/listPaymentYKPP*']) ? 'in' : '' }}">
                                        <li>
                                            <a class="{{ Request::is(['report/listPaymentYKPP']) ? 'active' : '' }}"
                                                href="{{ route('listPaymentYKPP') }}">All</a>
                                        </li>
                                        <li>
                                            <a class="{{ Request::is(['report/listPaymentYKPPSubmited']) ? 'active' : '' }}"
                                                href="{{ route('listPaymentYKPPSubmited') }}">Submited</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is(['report/indexPembayaran*']) ? 'active' : '' }}">
                                    <a class="has-arrow waves-effect waves-dark {{ Request::is(['report/indexPembayaran*', 'report/indexRealisasiProker*']) ? 'active' : '' }}"
                                        href="javascript:void(0)" aria-expanded="false">
                                        <span class="hide-menu">Realisasi Penyaluran TJSL</span>
                                    </a>
                                    <ul aria-expanded="false"
                                        class="collapse {{ Request::is(['report/indexPembayaran*', 'report/indexRealisasiProker*', 'report/indexRealisasiPilar*', 'report/indexRealisasiPrioritas*']) ? 'in' : '' }}">
                                        <li>
                                            <a class="{{ Request::is(['report/indexPembayaran*']) ? 'active' : '' }}"
                                                href="{{ route('indexPembayaran') }}">Rekap Realisasi</a>
                                        </li>
                                        <li>
                                            <a class="{{ Request::is(['report/indexRealisasiProker*']) ? 'active' : '' }}"
                                                href="{{ route('indexRealisasiProker') }}">
                                                Realisasi Program Kerja
                                            </a>
                                        </li>
                                        <li>
                                            <a class="{{ Request::is(['report/indexRealisasiPilar*']) ? 'active' : '' }}"
                                                href="{{ route('indexRealisasiPilar') }}">
                                                Realisasi Pilar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="{{ Request::is(['report/indexRealisasiPrioritas*']) ? 'active' : '' }}"
                                                href="{{ route('indexRealisasiPrioritas') }}">
                                                Realisasi Prioritas
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                {{-- <li
                                    class="{{ Request::is('report/listRealisasiAllAnnual*') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestProvinsi*') ? 'active' : '' }} {{ Request::is('report/listRealisasiAllMonthly*') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestPeriode') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestProker*') ? 'active' : '' }} {{ Request::is('report/logApproval*') ? 'active' : '' }}">
                                    <a class="has-arrow waves-effect waves-dark {{ Request::is('report/listRealisasiAllAnnual*') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestProvinsi*') ? 'active' : '' }} {{ Request::is('report/listRealisasiAllMonthly*') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestProposalPeriodePAID') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestProker*') ? 'active' : '' }} {{ Request::is('report/logApproval*') ? 'active' : '' }}"
                                        href="javascript:void(0)" aria-expanded="false">
                                        <span class="hide-menu">List Payment Request</span>
                                    </a>
                                    <ul aria-expanded="false"
                                        class="collapse {{ Request::is('report/listRealisasiAllAnnual*') ? 'in' : '' }} {{ Request::is('report/listPaymentRequestProvinsi*') ? 'in' : '' }} {{ Request::is('report/listRealisasiAllMonthly*') ? 'in' : '' }} {{ Request::is('report/listPaymentRequestPeriode') ? 'in' : '' }} {{ Request::is('report/listPaymentRequestProker*') ? 'in' : '' }} {{ Request::is('report/logApproval*') ? 'in' : '' }}">
                                        <li
                                            class="{{ Request::is('report/listRealisasiAllAnnual*') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestProvinsi*') ? 'active' : '' }} {{ Request::is('report/listRealisasiAllMonthly*') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestPeriode') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestProker*') ? 'active' : '' }} {{ Request::is('report/logApproval*') ? 'active' : '' }}">
                                            <a href="{{ route('listPaymentRequest') }}"
                                                class="{{ Request::is('report/listRealisasiAllAnnual/*') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestProvinsi*') ? 'active' : '' }} {{ Request::is('report/listRealisasiAllMonthly*') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestPeriode') ? 'active' : '' }} {{ Request::is('report/listPaymentRequestProker*') ? 'active' : '' }} {{ Request::is('report/logApproval*') ? 'active' : '' }}">All
                                            </a>
                                        </li>
                                        <li><a href="{{ route('listPaymentRequestProgress') }}">Progress</a></li>
                                        <li><a href="{{ route('listPaymentRequestPAID') }}">Paid</a></li>
                                    </ul>
                                </li> --}}
                                <li class="{{ Request::is(['report/detailRealisasiSubsidiary*']) ? 'active' : '' }}">
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <span class="hide-menu">Anak Perusahaan</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="{{ route('detailRealisasiSubsidiary') }}">Rekap Realisasi</a>
                                        </li>
                                        <li><a href="javascript:void(0)">Realisasi Program Kerja</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-small-cap">--- SETTING</li>
                        <li
                            class="{{ Request::is(['proposal/indexLembaga', 'proposal/createLembaga*']) ? 'active' : '' }}">
                            <a class="waves-effect waves-dark" href="{{ route('dataLembaga') }}"
                                aria-expanded="false">
                                <i class="bi bi-building-fill" style="font-size: 24px"></i>
                                <span class="hide-menu">&nbsp;Lembaga</span>
                            </a>
                        </li>
                        @if (session('user')->role == 'Admin')
                            <li
                                class="{{ Request::is(['master/indexPerusahaan', 'master/profilePerusahaan*', 'master/indexUser', 'master/profileUser*', 'master/dataAnggota', 'master/profileAnggota*', 'master/data-pengirim', 'master/indexHirarki']) ? 'active' : '' }}">
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="bi bi-database-fill-gear"
                                        style="font-size: 24px"></i><span class="hide-menu">&nbsp;&nbsp;Master
                                        Data</span></a>
                                <ul aria-expanded="false"
                                    class="collapse {{ Request::is(['master/indexPerusahaan', 'master/profilePerusahaan*', 'master/indexUser*', 'master/profileUser*', 'master/dataAnggota', 'master/profileAnggota*', 'master/data-pengirim', 'master/indexHirarki']) ? 'in' : '' }}">
                                    <li>
                                        <a href="{{ route('indexPerusahaan') }}"
                                            class="{{ Request::is(['master/indexPerusahaan', 'master/profilePerusahaan*']) ? 'active' : '' }}">Entitas</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('indexUser') }}"
                                            class="{{ Request::is(['master/indexUser*', 'master/profileUser*']) ? 'active' : '' }}">Manajemen
                                            User</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('data-pengirim') }}"
                                            class="{{ Request::is(['master/data-pengirim']) ? 'active' : '' }}">Stakeholder</a>
                                    </li>
                                    {{-- <li>
                                        <a href="{{ route('dataAnggota') }}"
                                            class="{{ Request::is(['master/dataAnggota', 'master/profileAnggota*']) ? 'active' : '' }}">Komisi
                                            VI & VII</a>
                                    </li> --}}
                                    <li>
                                        <a href="{{ route('indexHirarki') }}"
                                            class="{{ Request::is(['master/indexHirarki']) ? 'active' : '' }}">Hirarki
                                            Persetujuan</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </nav>
                <nav class="sidebar-nav mt-2">
                    <marquee direction="left" scrollamount="10">Selamat Datang di Aplikasi SHARE | <b
                            style="color: darkred">CSR BAROKAH</b> <b style="color: darkblue">#JanganLupaBahagia</b>
                    </marquee>
                </nav>
            </div>
        </aside>

        <div class="page-wrapper">
            @yield('content')
        </div>

        <footer class="footer">
            Copyright © 2018 - 2025 PT Nusantara Regas All Rights Reserved
        </footer>

    </div>

    <!-- All Jquery -->
    <script src="{{ asset('assets/node_modules/jquery/dist/jquery.js') }}"></script>

    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('template/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>

    <!--Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!--Wave Effects -->
    <script src="{{ asset('template/dist/js/waves.js') }}"></script>

    <!--Menu sidebar -->
    <script src="{{ asset('template/dist/js/sidebarmenu.js') }}"></script>

    <!--Custom JavaScript -->
    <script src="{{ asset('template/dist/js/custom.min.js') }}"></script>

    <!--stickey kit -->
    <script src="{{ asset('assets/node_modules/sticky-kit/dist/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- This is data table -->
    <script src="{{ asset('assets/node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <!-- Sweet-Alert  -->
    <script src="{{ asset('assets/node_modules/sweetalert/dist/sweetalert.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('assets/node_modules/toastr/toastr.js') }}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{ asset('assets/node_modules/moment/moment.js') }}"></script>

    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript">
    </script>

    <!-- Clock Plugin JavaScript -->
    <script src="{{ asset('assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="{{ asset('assets/node_modules/jquery-asColor/dist/jquery-asColor.js') }}"></script>
    <script src="{{ asset('assets/node_modules/jquery-asGradient/dist/jquery-asGradient.js') }}">
    </script>
    <script
        src="{{ asset('assets/node_modules/jquery-asColorPicker/dist/jquery-asColorPicker.min.js') }}">
    </script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{ asset('assets/node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="{{ asset('assets/node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/daterangepicker/daterangepicker.js') }}"></script>
    <!-- icheck -->
    <script src="{{ asset('assets/node_modules/icheck/icheck.min.js') }}"></script>
{{-- <script src="{{ asset('assets/node_modules/icheck/icheck.init.js') }}"></script> --}}

    <!--Morris JavaScript -->
    <script src="{{ asset('assets/node_modules/raphael/raphael.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/node_modules/morrisjs/morris.js') }}"></script> --}}
    {{-- <script src="{{ asset('template/dist/js/pages/morris-data.js') }}"></script> --}}

    <!--Custom JavaScript -->
    <script src="{{ asset('assets/node_modules/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/jquery-validation/dist/jquery.validate.min.js') }}"></script>
{{-- <script src="{{ asset('assets/node_modules/wizard/steps.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}"></script> --}}

    <!-- EASY PIE CHART JS -->
    <script src="{{ asset('assets/node_modules/easy-pie-chart/dist/jquery.easypiechart.min.js') }}">
    </script>
{{-- <script src="{{ asset('assets/node_modules/jquery.easy-pie-chart/easy-pie-chart.init.js') }}"></script> --}}

    <!-- Chart JS -->
    <script src="{{ asset('assets/node_modules/peity/jquery.peity.min.js') }}"></script>
{{-- <script src="{{ asset('assets/node_modules/peity/jquery.peity.init.js') }}"></script> --}}

    <!-- Footable -->
    <script src="{{ asset('assets/node_modules/footable/dist/footable.all.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/dist/js/bootstrap-select.min.js') }}"
        type="text/javascript"></script>
    <!--FooTable init-->
    <script src="{{ asset('template/dist/js/pages/footable-init.js') }}"></script>

    {{-- <script src="{{ asset('template/validasi/master.js') }}"></script> --}}

    <script>
        $(document).ready(function() {
            // Check if wysihtml5 plugin is loaded
            if ($.fn.wysihtml5) {
                $('.textarea_editor').wysihtml5();
            }
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
        // Bootstrap Date Picker
        // $('#date-end').bootstrapMaterialDatePicker({
        //     weekStart: 0,
        //     maxDate: new Date(),
        //     format: 'DD-MMM-YYYY',
        //     time: false
        // });

        // $('#date-start').bootstrapMaterialDatePicker({
        //     weekStart: 0,
        //     maxDate: new Date(),
        //     format: 'DD-MMM-YYYY',
        //     time: false
        // }).on('change', function(e, date) {
        //     $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
        // });

        // $('#tanggal-selesai').bootstrapMaterialDatePicker({
        //     weekStart: 0,
        //     // maxDate: new Date(),
        //     format: 'DD-MMM-YYYY',
        //     time: false
        // });

        // $('#tanggal-mulai').bootstrapMaterialDatePicker({
        //     weekStart: 0,
        //     maxDate: new Date(),
        //     format: 'DD-MMM-YYYY',
        //     time: false
        // }).on('change', function(e, date) {
        //     $('#tanggal-selesai').bootstrapMaterialDatePicker('setMinDate', date);
        // });

        // // Date Picker
        // jQuery('.mydatepicker, #datepicker').datepicker();
        // jQuery('.datepicker-autoclose').datepicker({
        //     autoclose: true,
        //     format: 'dd-M-yyyy',
        //     todayHighlight: true,
        //     orientation: 'bottom auto'
        // });

        // jQuery('.datepicker-autoclose2').datepicker({
        //     autoclose: true,
        //     format: 'dd-M-yyyy',
        //     todayHighlight: true,
        //     orientation: 'bottom auto'
        // });

        // // Clock pickers
        // $('.clockpicker').clockpicker({
        //     donetext: 'Done',
        //     'default': 'now',
        // }).find('input').change(function() {
        //     console.log(this.value);
        // });

        // MAterial Date picker
        // $('.mdate').bootstrapMaterialDatePicker({format: 'DD-MM-YYYY', minDate: new Date(), time: false});
        // $('.mdate').bootstrapMaterialDatePicker({
        //     format: 'DD-MM-YYYY',
        //     time: false
        // });
        // $('#timepicker').bootstrapMaterialDatePicker({
        //     format: 'HH:mm',
        //     time: true,
        //     date: false
        // });
        // $('#date-format').bootstrapMaterialDatePicker({
        //     format: 'dddd DD MMMM YYYY - HH:mm'
        // });

        // $('.min-date').bootstrapMaterialDatePicker({
        //     format: 'DD-MM-YYYY HH:mm',
        //     minDate: new Date()
        // });
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
        @if (Session::has('gagalDetail'))
            toastr.error("{{ Session::get('gagalDetail') }}", "Gagal", {
                closeButton: true
            });
        @endif

        @if (Session::has('suksesDetail'))
            toastr.success("{{ Session::get('suksesDetail') }}", "Berhasil", {
                closeButton: true
            });
        @endif

        @if (Session::has('failed'))
            swal("Gagal", "{{ Session::get('failed') }}", "error");
        @endif

        @if (Session::has('berhasil'))
            toastr.success("{{ Session::get('berhasil') }}", "Berhasil", {
                closeButton: true
            });
        @endif

        @if (Session::has('peringatan'))
            swal("Peringatan", "{{ Session::get('peringatan') }}", "warning");
        @endif

        @if (Session::has('SuksesLogin'))
            swal("Login Berhasil", "{{ Session::get('SuksesLogin') }}", "success");
        @endif

        @if (Session::has('sukses'))
            swal("Berhasil", "{{ Session::get('sukses') }}", "success");
        @endif

        @if (Session::has('gagal'))
            swal("Gagal", "{{ Session::get('gagal') }}", "error");
        @endif

        @if (Session::has('gagalHapus'))
            swal("Gagal Hapus", "{{ Session::get('gagalHapus') }}", "error");
        @endif
    </script>

    <script>
        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            return charCode >= 48 && charCode <= 57;
        }
    </script>

    <script>
        function submitDelete(url) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = url;

            var token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = '{{ csrf_token() }}';
            form.appendChild(token);

            var method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            form.appendChild(method);

            document.body.appendChild(form);
            form.submit();
        }
    </script>

    @yield('footer')

</body>

</html>
