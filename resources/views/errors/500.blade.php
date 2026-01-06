
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Error Code 500</title>
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
            <div style="background: #FF1744"></div>
            <h1>500</h1>
        </div>
        <h2>Internal Server Error!</h2>
        <p>Sorry, something went wrong on our end. We are currently trying to fix the problem. Please wait few minutes.</p>
        <a href="#!" onClick="document.location.reload(true)">home page</a>
    </div>
</div>

<script>
    function reloadpage()
    {
        location.reload()
    }
</script>

</body>

</html>
