@extends('adminlte::master')


@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('public/vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
@stack('css')
@yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
'boxed' => 'layout-boxed',
'fixed' => 'fixed',
'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
<?php // dd(Auth::user()); ?>
@extends('message')

<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
        @if(config('adminlte.layout') == 'top-nav')
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="{{ url(config('adminlte.dashboard_url', 'dashboard')) }}" class="navbar-brand">
                        {!! config('adminlte.logo', '<b>LOADUS</b>') !!}
                    </a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
                @else
                <!-- Logo -->
                <a href="{{ url(config('adminlte.dashboard_url', 'dashboard')) }}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">{!! config('adminlte.logo', '<b>LOADUS</b>ADMIN') !!}</span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle fa5" data-toggle="push-menu" role="button">
                        <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                    </a>
                    @endif
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>   <span id="date"></span>
                                </a>
                            </li>

                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-clock-o"></i> <span id="hours"> </span> : <span id="minutes"></span> : <span id="seconds"></span> : <span id="ampm"></span> 

                                </a>
                            </li> -->


                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php if (Auth::user()->user_image) { ?>
                                        <img src="<?php echo URL::to('/') . '/' . Auth::user()->user_image; ?>" class="user-image" alt="User Image">
                                    <?php } else { ?>
                                        <img src="{{ asset('public/vendor/adminlte/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                                        <?php
                                    }
                                    ?>
                                    <span class="hidden-xs"><?php echo ucfirst(Auth::user()->first_name); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">                                        
                                        <?php if (Auth::user()->user_image) { ?>
                                            <img src="<?php echo URL::to('/') . '/' . Auth::user()->user_image; ?>" class="img-circle" alt="User Image">
                                        <?php } else { ?>
                                            <img src="{{ asset('public/vendor/adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                                            <?php
                                        }
                                        ?>
                                        <p>
                                            <?php echo ucfirst(Auth::user()->first_name); ?>
                                            <small>Member since: <?php echo date('M, Y', strtotime(Auth::user()->created_at)); ?></small>
                                        </p>
                                    </li>

                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo URL::to('/') . '/admin/profile'; ?>" class="btn btn-warning btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="#" class="btn btn-danger btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
                                            <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                                @if(config('adminlte.logout_method'))
                                                {{ method_field(config('adminlte.logout_method')) }}
                                                @endif
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <!-- <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li> -->
                        </ul>
                    </div>
                    @if(config('adminlte.layout') == 'top-nav')
            </div>
            @endif
        </nav>
    </header>

    @if(config('adminlte.layout') != 'top-nav')
    <!-- Left side column. contains the logo and sidebar -->

    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')

    @endif

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @if(config('adminlte.layout') == 'top-nav')
        <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @include('flash-message')
                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
        </div>
        <!-- /.container -->
        @endif
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.18
        </div>
        <strong> &copy; LOADUS - All right reserved <?php echo date('Y', strtotime('-1 years')) . ' - ' . date('Y') ?>.</strong>  
    </footer>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>


            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
@stop

@section('adminlte_js')

<script src="{{ asset('public/vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('public/vendor/adminlte/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('public/vendor/adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<script src="{{ asset('public/vendor/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{ asset('public/vendor/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{ asset('public/vendor/adminlte/dist/js/demo.js')}}"></script>
<script src="{{ asset('public/vendor/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('public/vendor/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('public/vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('public/vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('public/vendor/adminlte/dist/chart/highcharts.js') }}"></script>
<script src="{{ asset('public/vendor/adminlte/dist/chart/highcharts-3d.js') }}"></script>
<script src="{{ asset('public/vendor/adminlte/dist/js/sha256.js') }}"></script>
<script src="{{ asset('public/vendor/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('public/vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
<script>
                                                $(document).ready(function () {
                                                    $('body').tooltip({selector: '[data-toggle="tooltip"]'});
                                                    $(".alert-success").fadeTo(2000, 500).slideUp(500, function () {
                                                        $(".alert-success").slideUp(500);
                                                    });

                                                    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                                                        checkboxClass: 'icheckbox_minimal-blue',
                                                        radioClass: 'iradio_minimal-blue'
                                                    })
                                                    var $dOut = $('#date'),
                                                            $hOut = $('#hours'),
                                                            $mOut = $('#minutes'),
                                                            $sOut = $('#seconds'),
                                                            $ampmOut = $('#ampm');
                                                    var months = [
                                                        'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
                                                    ];

                                                    var days = [
                                                        'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'
                                                    ];

                                                    function update() {
                                                        var date = new Date();

                                                        var ampm = date.getHours() < 12
                                                                ? 'AM'
                                                                : 'PM';

                                                        var hours = date.getHours() == 0
                                                                ? 12
                                                                : date.getHours() > 12
                                                                ? date.getHours() - 12
                                                                : date.getHours();

                                                        var minutes = date.getMinutes() < 10
                                                                ? '0' + date.getMinutes()
                                                                : date.getMinutes();

                                                        var seconds = date.getSeconds() < 10
                                                                ? '0' + date.getSeconds()
                                                                : date.getSeconds();

                                                        var dayOfWeek = days[date.getDay()];
                                                        var month = months[date.getMonth()];
                                                        var day = date.getDate();
                                                        var year = date.getFullYear();

                                                        var dateString = dayOfWeek + ', ' + month + ' ' + day + ', ' + year;

                                                        $dOut.text(dateString);
                                                        $hOut.text(hours);
                                                        $mOut.text(minutes);
                                                        $sOut.text(seconds);
                                                        $ampmOut.text(ampm);
                                                    }

                                                    update();
                                                    window.setInterval(update, 1000);
                                                    $('.select2').select2();
                                                    $('#datepicker').datepicker({
                                                        autoclose: true,
                                                        format: 'dd/mm/yyyy',
                                                        endDate: 'today'
                                                    })
                                                    $("#start_date").datepicker({
                                                        format: 'dd-mm-yyyy',
                                                        endDate: "today",
                                                        autoclose: true,
                                                        todayHighlight: true
                                                    }).on('changeDate', function (selected) {
                                                        var minDate = new Date(selected.date.valueOf());
                                                        $('#end_date').datepicker('setStartDate', minDate);
                                                    });
                                                    $("#end_date").datepicker({
                                                        format: 'dd-mm-yyyy',
                                                        endDate: "today",
                                                        autoclose: true,
                                                        todayHighlight: true

                                                    }).on('changeDate', function (selected) {
                                                        var minDate = new Date(selected.date.valueOf());
                                                        $('#start_date').datepicker('setEndDate', minDate);
                                                    });
                                                });
</script>


<script>
    $(document).ready(function () {
        $(document).on('change', '#chat_file', function (event) {
            var name = document.getElementById("chat_file").files[0].name;
            // event.preventDefault();
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();

            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("chat_file").files[0]);
            var f = document.getElementById("chat_file").files[0];
            var fsize = f.size || f.fileSize;

            if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'pdf', 'doc']) == -1) {
                PNotify.error({
                    title: 'Error!',
                    delay: 2500,
                    text: 'Only gif, png, jpg, jpeg, pdf, doc file are allowed!'
                });
            } else if (fsize > 2000000) {
                PNotify.error({
                    title: 'Error!',
                    delay: 2500,
                    text: 'Image File Size is very big!'
                });
            } else {
                form_data.append("file", document.getElementById('chat_file').files[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('admin/ajaxfile') }}",
                    dataType: 'text', // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    beforeSend: function () {
                        $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                    },
                    success: function (success) {
                        //alert(success);
                       $('#message').val('<a href="../uploads/chat/' + success + '" target="_blank"><i class="fas fa-paperclip"></i>  ' + success + '</a>');

                    }
                });
            }
        });
    });
</script>
@stack('js')
@yield('js')
@stop
