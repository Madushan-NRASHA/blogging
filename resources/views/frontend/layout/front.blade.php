<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Blog Post</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="templatemo">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,900,800,700,500,200,100,600" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('asset/frontend/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/frontend/css/misc.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/frontend/css/blue-scheme.css') }}">

    <!-- JavaScripts -->
    <script src="{{ asset('asset/frontend/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('asset/frontend/js/jquery-migrate-1.2.1.min.js') }}"></script>

    <link rel="shortcut icon" href="{{ asset('/asset/frontend/images/includes/kr.png') }}" type="image/x-icon" />
</head>
<body>

@yield('header',view('frontend.components.header'))
@yield('content')
@yield('footer',view('frontend.components.footer'))

<!-- Scripts -->
<script src="{{ asset('asset/frontend/js/min/plugins.min.js') }}"></script>
<script src="{{ asset('asset/frontend/js/min/medigo-custom.min.js') }}"></script>

</body>
</html>
