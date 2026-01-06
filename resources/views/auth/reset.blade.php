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
    <title>PGN SHARE | Reset Password</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/assets/images/logoicon.png') }}">

    <!-- page css -->
    <link href="{{ asset('template/dist/css/pages/login-register-lock.css') }}" rel="stylesheet">
    <!--alerts CSS -->
    <link href="{{ asset('template/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('template/assets/node_modules/toast-master/toastr.min.css') }}">

    <!-- Custom CSS -->
    <link href="{{ asset('template/dist/css/style.min.css') }}" rel="stylesheet">

    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }
    </style>

</head>

<body class="horizontal-nav skin-blue card-no-border">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="loader">
        <div><img src="{{ asset('template/assets/images/logoicon.png') }}" width="48" height="48" alt="Lucid"></div>
        <p class="loader__label">Loading page</p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">
    <div class="login-register" style="background-image:url({{ asset('template/assets/images/background/bg.jpg') }});">
        <div class="login-box card">
            <div class="card-body">
                <center>
                    <img class="m-t-20" src="{{ asset('template/assets/images/logo-pertamina-gas-negara.png') }}"
                         width="200px" alt="Logo PGN">
                    <h5 class="m-t-20 model-huruf-family"><b>RESET PASSWORD</b></h5>
                </center>
                <br>
                <form class="form-horizontal form-material" method="post"
                      action="{{ action('LoginController@updatePassword') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="userID" value="{{ encrypt($data->id_user) }}">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" placeholder="New Password"
                                   value="{{ old('password') }}" autofocus>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-xs-12">
                            <button class="btn btn-block btn-lg btn-info" type="submit">RESET</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0 m-t-25">
                        <div class="col-sm-12 text-center">
                            <h3 class="card-title model-huruf-family">PGN SHARE</h3>
                            <h6 class="card-subtitle model-huruf-family">© 2018 - 2021 PT Perusahaan Gas Negara Tbk<br>
                                All Rights Reserved</h6>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('template/assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('template/assets/node_modules/popper/popper.min.js') }}"></script>
<script src="{{ asset('template/assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Sweet-Alert  -->
<script src="{{ asset('template/assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('template/assets/node_modules/sweetalert/jquery.sweet-alert.custom.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('template/assets/node_modules/toast-master/toastr.min.js') }}"></script>

<!--Custom JavaScript -->
<script src="{{ asset('template/dist/js/custom.min.js') }}"></script>

<script type="text/javascript">
    $(function () {
        $(".preloader").fadeOut();
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>

<script>
    @if(Session::has('session'))
    toastr.info("Session anda sudah habis", "Informasi", {closeButton: true});
    @endif

    @if (Session::has('credential'))
    toastr.error("{{Session::get('credential')}}", "Credential Account");
    @endif

    @if(Session::has('gagalLogin'))
    toastr.error("{{ Session::get('gagalLogin') }}", "Perhatian", {closeButton: true});
    @endif

    @if(Session::has('gagal'))
    swal("Failed", "{{Session::get('gagal')}}", "error");
    @endif

    @if(Session::has('sukses'))
    swal("Success", "{{Session::get('sukses')}}", "success");
    @endif
</script>

<script>
    @if (count($errors) > 0)
    toastr.warning('Password baru harus diisi', 'Warning', {closeButton: true});
    @endif
</script>

</body>

</html>