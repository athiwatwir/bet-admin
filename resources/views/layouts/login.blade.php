<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <!-- Smarty Style -->
    <link href="{{ asset('css/smarty_style/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/smarty_style/vendor_bundle.min.css') }}" rel="stylesheet">
    <!-- up to 10% speed up for external res -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com/">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com/">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <!-- preloading icon font is helping to speed up a little bit -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap">
    <link rel="apple-touch-icon" href="demo.files/logo/icon_512x512.png">

	<link rel="manifest" href="{{ asset('images/manifest/manifest.json') }}">
	<meta name="theme-color" content="#377dff">
</head>
<body>
    <div id="wrapper">          
        @yield('content')
    </div>
</body>
</html>
