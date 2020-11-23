<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('/assets/images/favicon.ico') }}" type="image/ico" />
    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="_base_url" content="{{ url('/') }}">

    <title>
        {{ config('app.name') }} @yield('title')
    </title>

    @include('bo.layouts.css')
    @yield('block_css')
</head>

<body class="adminbody">
    <!-- Start main -->
    <div id="main">
        <!-- top bar navigation -->
        @include('bo.layouts.sidebar')
        <!-- End Navigation -->
        <!-- Left Sidebar -->
        @include('bo.layouts.navbar')
        <!-- End Sidebar -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- END content-page -->
        <footer class="footer">
            <span class="text-right">

            </span>
            <span class="float-right">

            </span>
        </footer>
    </div>
    <!-- END main -->
    @include('bo.layouts.js')
    @yield('block_js')
</body>
</html>