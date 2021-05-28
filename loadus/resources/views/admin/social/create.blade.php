
@extends('adminlte::page')

@section('title', "$title")

@section('content_header')

<h1>{{$title}}</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $title }}</a></li>    
</ol>
<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="{{url('/admin/social')}}"><button class="btn btn-success btn-flat">Back</button></a>
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
        <?php $action = isset($data->id) ? 'admin/social/update/' . Crypt::encryptString($data->id) : 'admin/social/store'; ?>
        {{ Form::open(array('url' => $action,'id'=>'myForm')) }}
        <div class="box-body">
            
            <div class=" col-md-6">
                <div class="form-group">
                    <label>Name</label>                        
                    <?php echo Form::text('name', isset($data->name) ? $data->name : Input::get('name'), array('class' => 'form-control', 'placeholder' => 'Name')); ?>
                </div>
            </div>
            
            <div class=" col-md-6">
                <div class="form-group">
                    <label>Link</label>                        
                    <?php echo Form::text('link', isset($data->link) ? $data->link : Input::get('link'), array('class' => 'form-control', 'placeholder' => 'Link')); ?>
                </div>
            </div>
            
            <div class=" col-md-6">
                <div class="form-group">
                    <label>Icon</label>                        
                    <?php echo Form::text('icon', isset($data->icon) ? $data->icon : Input::get('icon'), array('class' => 'form-control', 'placeholder' => 'Icon')); ?>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label>Status</label>
                <?php
                $select = isset($data->status) ? $data->status : Input::get('status');
                $status = ['' => '---Select---', '1' => 'Active', '0' => 'In-Active'];
                echo Form::select('status', $status, $select, ['class' => 'form-control']);
                ?>
            </div>

        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-success btn-flat"><?php echo isset($data->id) ? 'Update' : 'Submit' ?></button>
        </div>
        {{ Form::close() }}
    </div>
</div>
<script src="<?php echo URL::to('/public/vendor/adminlte/dist/js/validation.js'); ?>"></script>

<script>
$(function () { 
    
    $('#myForm').on('submit').validate({

        rules: {

            name: {
                required: true,

            },
            link: {
                required: true,
            },
             icon: {
                required: true,
            },
            status: {
                required: true,

            }
        },

//        messages: {
//            password: {
//                required: "This field is required",
//                             
//            },
//        }
//        ,
        submitHandler: function (form) {
            form.submit();
        }
    });

});
</script>



@stop