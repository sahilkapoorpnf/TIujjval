
@extends('adminlte::page')

@section('title', "$title")

@section('content_header')

<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $title }}</a></li>    
</ol>
<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="{{url('/admin/categories')}}"><button class="btn btn-success btn-flat">Back</button></a>
    </div> 
</div>
@stop

@section('content')
<?php
?>
<div class="box box-success color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> {{ $title }} </h3>

    </div>
    <div class="box-body">
        <form method="post" enctype="multipart/form-data">
            {{csrf_field()}}
        <div class="box-body">

            <div class=" col-md-12">
                <div class="form-group">
                    <label>Title</label>                        
                    <?php echo Form::text('title', isset($userData->title) ? $userData->title : Input::get('title'), array('class' => 'form-control','required'=>true, 'placeholder' => 'Title')); ?>
                </div>
            </div>


            <div class=" col-md-12">
                <div class="form-group">
                    <label>Image</label> 
                    <input type="file" name="image" class="form-control" style="padding: 0px">
                </div>
            </div>
            @if($userData->icon!='')
            <img src="{{asset('public/sub_categories/'.$userData->icon)}}" width="50" height="50">
            @endif
            <div class="form-group col-md-12">
                <label>Status</label>
                <?php
                $select = isset($userData->status) ? $userData->status : Input::get('status');
                $status = ['1' => 'Active', '0' => 'In-Active'];
                echo Form::select('status', $status, $select, ['class' => 'form-control','required'=>true]);
                ?>
            </div>

        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-success btn-flat">Update</button>
        </div>
        </form>
    </div>
</div>


@stop