    <!DOCTYPE html>
    <html lang="en">
    <head>

    <meta charset="utf-8">
    <meta name="description" content="Miminium Admin Template v.1">
    <meta name="author" content="Isna Nur Azis">
    <meta name="keyword" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>d'Eclat</title>

    <!-- start: Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}">
    <link rel="shortcut icon" href="{{asset('asset/img/logo.png')}}">
    <!-- plugins -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/font-awesome.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/simple-line-icons.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/animate.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/icheck/skins/flat/aero.css')}}"/>
    <link href="{{asset('asset/css/style.css')}}" rel="stylesheet">
        </head>

        <body id="mimin" class="dashboard form-signin-wrapper">
        <div style="padding-top:50px;" class="container">
            @yield('content')
        </div>

        <!-- end: Content -->
        <!-- start: Javascript -->
        <script src="{{asset('asset/js/jquery.min.js')}}"></script>
        <script src="{{asset('asset/js/jquery.ui.min.js')}}"></script>
        <script src="{{asset('asset/js/bootstrap.min.js')}}"></script>

        <script src="{{asset('asset/js/plugins/moment.min.js')}}"></script>

        <!-- custom -->
        <script src="asset/js/main.js"></script>
        <!-- end: Javascript -->
    </body>
</html>