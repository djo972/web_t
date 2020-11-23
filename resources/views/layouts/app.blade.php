<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('/assets/images/favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="_base_url" content="{{ url('/') }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">

    <!-- Font Awesome CSS -->
    <link href="{{ asset('/assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('/assets/plugins/scrollbar-plugin/jquery.mCustomScrollbar.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/plugins/jssocials/jssocials.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    @yield('block_css')
</head>
<body class="page_content">
@include('layouts.navbar')

<div class="container-fluid">
    @yield('content')
    <div class="share_links">
        <ul class="list-unstyled ul_links">
            <li class="btn_twitter"></li>
            <li class="btn_facebook"></li>
            <li class="btn_instagram"></li>
        </ul>
    </div>
</div>
<div id="dark" class="dark-light"></div>
<!-- Scripts placed at the end of the document so the pages load faster -->
<!-- jQuery -->
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }} "></script>
<script src="{{ asset('/assets/plugins/jquery-ui/jquery-ui.min.js') }} "></script>
<!-- Bootstrap core JavaScript -->
<script src="{{ asset('/assets/plugins/popper/popper.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }} "></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>
<script src="{{ asset('/assets/plugins/jssocials/jssocials.js') }} "></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-128485554-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-128485554-1');

</script>
@yield('block_js')
@yield('js')
<script type="application/javascript" src="{{ asset('js/app.js') }}" ></script>
<script src="{{ asset('/js/lang/fr.js') }}"></script>
</body>
</html>
