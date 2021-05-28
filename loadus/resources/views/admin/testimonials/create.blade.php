
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
        <a href="{{url('/admin/testimonials')}}"><button class="btn btn-success btn-flat">Back</button></a>
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
        <?php $action = isset($data->id) ? 'admin/testimonials/update/' . Crypt::encryptString($data->id) : 'admin/testimonials/store'; ?>
        {{ Form::open(array('url' => $action,'id'=>'myForm','files'=>'true')) }}
        <div class="box-body">

<!--            <div class=" col-md-12">
                <div class="form-group">
                    <label>Title</label>                        
                    <?php echo Form::text('title', isset($data->title) ? $data->title : Input::get('title'), array('class' => 'form-control', 'placeholder' => 'Title')); ?>
                </div>
            </div>-->

            <div class=" col-md-12">
                <div class="form-group">
                    <label>Client Name</label>                        
                    <?php echo Form::text('client_name', isset($data->client_name) ? $data->client_name : Input::get('client_name'), array('class' => 'form-control', 'placeholder' => 'Client Name')); ?>
                </div>
            </div>

            <div class=" col-md-12">
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="description" name="description"><?php echo isset($data->description) ? $data->description : Input::get('description') ?></textarea>
                </div>
            </div>



            <div class=" col-md-6">
                <div class="form-group">
                    <label>Image</label> 
                    <input type="file" name="image" class="form-control" style="padding: 0px">
                </div>
            </div>

            <input type="hidden" name="testimonials_upload" value="<?php echo isset($data->image) ? $data->image : Input::get('image') ?>"> 
            <div class="form-group col-md-6">
                <?php
                if (!empty($data->image)) {
                    echo '<a href="../../../' . $data->image . '" target="_blank"><img class="img-circle" src="../../../' . $data->image . '"></a>';
                }
                ?>
            </div>

            <div class="form-group col-md-12">
                <label>Status</label>
                <?php
                $select = isset($data->status) ? $data->status : Input::get('status');
                $status = ['1' => 'Active', '0' => 'In-Active'];
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