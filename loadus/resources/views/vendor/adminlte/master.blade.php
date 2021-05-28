<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" href="{{ asset('public/frontend') }}/img/favicon.png" type="image/gif" sizes="16x16"> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
            @yield('title', config('adminlte.title', ' 2'))
            @yield('title_postfix', config('adminlte.title_postfix', ''))</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/vendor/font-awesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/dist/css/AdminLTE.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/css/style.css') }}">        
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/css/custom.css') }}">        
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/plugins/iCheck/all.css') }}">
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/bower_components/jvectormap/jquery-jvectormap.css') }}">
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/dist/css/skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/css/PNotifyBrightTheme.css') }}">
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

        @yield('adminlte_css')

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <script src="{{ asset('public/vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('public/vendor/adminlte/dist/js/PNotify.js') }}"></script>
        <script src="{{ asset('public/vendor/adminlte/tiny/tinymce.min.js') }}"></script>
        <script src="{{ asset('public/vendor/adminlte/tiny/jquery.tinymce.min.js') }}"></script>
    </head>  

    <body class="hold-transition @yield('body_class')">

        @yield('body')

        <!-- <div id="dvLoading"></div> -->


        @include('adminlte::plugins', ['type' => 'js'])

        @yield('adminlte_js')


        <script>
$(window).bind("load", function () {
    $("#dvLoading").fadeOut(2000);
});
        </script>


    </body>
</html>
