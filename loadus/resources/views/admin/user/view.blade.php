
@extends('adminlte::page')

@section('title', 'Admin LTE')

@section('content_header')

<h1>{{ $titles }}</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $titles }}</a></li>    
</ol>
<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="{{url('/admin/user')}}"><button class="btn btn-success btn-flat">Back</button></a>
    </div> 
</div>
@stop

@section('content')

<div class="box box-success color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> {{ $titles }} </h3>

    </div>
    <div class="box-body">        
        <div class="box-body">
            <?php
            $exclude = ['id', 'password','user_image'];
            $file = ['user_image'];  
            // $file = $location;
            echo dataView($data, $exclude, $file);
            ?>
        </div>

    </div>
</div>

@stop