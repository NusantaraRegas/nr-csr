<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error 500 - Internal Server Error</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/logoicon.png') }}">
    <link href="{{ asset('template/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/dist/css/pages/error-pages.css') }}" rel="stylesheet">
</head>
<body class="skin-default-dark fixed-layout">
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1>500</h1>
                <h3 class="text-uppercase">Internal Server Error!</h3>
                <p class="text-muted m-t-30 m-b-30">Sorry, something went wrong on our end. Please wait a few minutes.</p>
                <a href="{{ route('dashboard') }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to Home</a>
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/node_modules/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.js') }}"></script>
</body>
</html>