
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Error Code 403</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/assets/images/logoicon.png') }}">

    <!-- Google font -->
    <link href="{{ asset('template_error/css/font.css') }}" rel="stylesheet">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('template_error/css/style.css') }}" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="notfound">
    <div class="notfound">
        <div class="notfound-404">
            <div></div>
            <h1>403</h1>
        </div>
        <h2>Access Forbidden</h2>
        <p>You don;t have permission to access this page</p>
        <a href="{{ route('dashboard') }}">home page</a>
    </div>
</div>

</body>

</html>
