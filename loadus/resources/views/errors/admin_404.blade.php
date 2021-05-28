
@extends('adminlte::page')

@section('title', '404 Page not found')

@section('content_header')


@stop

@section('content')
<section class="content-header">
    <h1>
        404 Error Page
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">404 error</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href="<?php echo URL::to('/admin/dashboard'); ?>">return to dashboard</a> or try using the search form.
            </p>
            <h3> <span class="text-danger"><strong>  The page your looking for is not available</strong></span></h3>
            
        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>
<button class="btn btn-success btn-flat" onclick="window.history.back();">Go Back</button>
@stop