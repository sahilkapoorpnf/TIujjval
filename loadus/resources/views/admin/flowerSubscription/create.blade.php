
@extends('adminlte::page')

@section('title', "$titles")

@section('content_header')

<h1>{{ $titles }}</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $titles }}</a></li>    
</ol>
<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="{{url('/admin/flowerSubs')}}"><button class="btn btn-success btn-flat">Back</button></a>
    </div> 
</div>
@stop

@section('content')
<?php
?>
<div class="box box-success color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> {{ $titles }} </h3>

    </div>
    <div class="box-body">
        <?php $action = 'admin/flowsubsupdate/' . Crypt::encryptString($data->id); ?>
        {{ Form::open(array('url' => $action,'id'=>'myForm','files'=>'true')) }}
        <div class="box-body">

            <div class=" col-md-12">
                <div class="form-group">
                    <label>Subscription Name</label>                        
                    <?php echo Form::text('plan_name', isset($data->plan_name) ? $data->plan_name : Input::get('plan_name'), array('class' => 'form-control', 'placeholder' => 'Plan Name')); ?>
                </div>
            </div>

            <div class=" col-md-12">
                <div class="form-group">
                    <label>Subscription Rate</label>                        
                    <?php echo Form::number('plan_rate', isset($data->plan_rate) ? $data->plan_rate : Input::get('plan_rate'), array('class' => 'form-control', 'placeholder' => 'Plan Rate', 'min' => 0)); ?>
                </div>
            </div>

            <div class=" col-md-12">
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="description" name="description"><?php echo isset($data->description) ? $data->description : Input::get('description') ?></textarea>
                </div>
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

            title: {
                required: true,

            },
            description: {
                required: true,

            },
            slug: {
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


<script type="text/javascript">
    tinymce.init({
        selector: '#description',
        theme: 'modern',
        height: 300,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor'
        ],
        content_css: 'css/content.css',
        formats: {
            // Changes the default format for the bold button to produce a span with a bold class
            bold: {inline: 'span', classes: 'bold'}
        },
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '<?php echo url('/'); ?>/admin/page/uploadimg');
            var token = '{{ csrf_token() }}';
            xhr.setRequestHeader("X-CSRF-Token", token);
            xhr.onload = function () {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }

    });
</script>



@stop