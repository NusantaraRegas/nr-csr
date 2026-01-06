<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Manajemen Tanggung Jawab Sosial dan Lingkungan">
    <meta name="author" content="Sigit Sutrisno">

    <title>@yield('title')</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/assets/images/logoicon.png') }}">
    <link href="{{ asset('template/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/node_modules/toast-master/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/dist/css/custom.css') }}" rel="stylesheet">

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .login-left {
            background-image: url('{{ asset('template/assets/images/background/csr-bg.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .login-right {
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        .btn-login {
            background-color: #009cf3;
            color: white;
        }

        .form-control {
            border-radius: 8px;
        }

        .custom-checkbox label {
            cursor: pointer;
        }

        .field-icon {
            z-index: 2;
            color: #aaa;
        }
    </style>
</head>

<body>
    <div class="row no-gutters" style="height: 100vh;">
        <div class="col-md-7 login-left d-none d-md-block"></div>

        <div class="col-md-5 login-right">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('template/assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('template/assets/node_modules/toast-master/toastr.min.js') }}"></script>

    <script>
        @if (Session::has('session'))
            toastr.warning("{{ Session::get('session') }}", "Warning");
        @endif

        @if (Session::has('credential'))
            toastr.error("{{ Session::get('credential') }}", "Credential Account");
        @endif

        @if (Session::has('gagal'))
            toastr.error("{{ Session::get('gagal') }}", "Gagal");
        @endif

        @if (Session::has('sukses'))
            swal("Berhasil", "{{ Session::get('sukses') }}", "success");
        @endif
    </script>

    @yield('footer')

</body>

</html>
