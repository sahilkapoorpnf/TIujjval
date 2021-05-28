<?php $__env->startSection('title', 'Admin LTE'); ?>

<?php $__env->startSection('content_header'); ?>

<h1><?php echo e($titles); ?></h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#"><?php echo e($titles); ?></a></li>    
</ol>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
?>
<div class="box box-success color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo e($titles); ?> </h3>

    </div>
    <div class="box-body">
        <?php $action = isset($data->id) ? 'admin/profile/update' : ''; ?>
        <?php echo e(Form::open(array('url' => $action,'id'=>'myForm','enctype'=>"multipart/form-data"))); ?>

        <div class="box-body">

            <div class=" col-md-6">
                <div class="form-group">
                    <label>Name</label>                        
                    <?php echo Form::text('name', isset($data->first_name) ? $data->first_name : Input::get('name'), array('class' => 'form-control', 'placeholder' => 'Name')); ?>
                </div>
            </div>

            <div class=" col-md-6">
                <div class="form-group">
                    <label>Email</label>                        
                    <?php echo Form::text('email', isset($data->email) ? $data->email : Input::get('email'), array('class' => 'form-control', 'placeholder' => 'Email', 'readonly')); ?>
                </div>
            </div>

            <div class=" col-md-6">
                <div class="form-group">
                    <label>Profile Image</label>                        
                    <input type="file" name="profile_image" id="file-input" class="form-control"  accept="image/*" style="padding: 0">
                </div>
            </div>
            <input type="hidden" name="profile_image_old" value="<?php echo $data->user_image; ?>">

            <div class="form-group col-md-6">
                <label>Status</label>
                <?php
                $select = isset($data->status) ? $data->status : Input::get('status');
                $status = ['' => '---Select---', '1' => 'Active', '0' => 'In-Active'];
                echo Form::select('status', $status, $select, ['class' => 'form-control']);
                ?>
            </div>
            <div class="form-group col-md-6" id="thumb-output">
                <img src="<?php echo URL::to('/'.$data->user_image); ?>" class="thumb" alt="Profile Image" title="Profile Image">
            </div>
            

        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-success btn-flat" onclick="hasashing()"><?php echo isset($data->id) ? 'Update' : 'Submit' ?></button>
        </div>
        <?php echo e(Form::close()); ?>

    </div>
</div>
<script src="<?php echo URL::to('public/vendor/adminlte/dist/js/validation.js'); ?>"></script>

<script>
                $(function () {
                    $('#myForm').on('submit').validate({

                        rules: {

                            name: {
                                required: true,

                            },
                            email: {
                                required: true,
                                email: true,

                            },
                            password: {
                                required: true,
                                minlength: 8,
                                pwcheck: true,

                            },
                            role: {
                                required: true,
                                number: true

                            },
                            status: {
                                required: true,
                                number: true

                            }
                        },

                        messages: {
                            password: {
                                required: "This field is required",
                                pwcheck: "Password should be upper case lower case and alphanumeric!",
                                minlength: "Password length should be  8 charector!"

                            },
                        }
                        ,
                        submitHandler: function (form) {
                            form.submit();
                        }

                    });
                    $.validator.addMethod("pwcheck", function (value) {
                        return /^(?=.*[a-z])[A-Za-z0-9\d=!\-@._*]+$/.test(value)
                                && /[a-z]/.test(value)
                                && /\d/.test(value)
                    });

                    ///// Image Thumb
                    $('#file-input').on('change', function () { //on file input change
                        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
                        {
                            $('#thumb-output').html(''); //clear html of output element
                            var data = $(this)[0].files; //this file data

                            $.each(data, function (index, file) { //loop though each file
                                if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) { //check supported file type
                                    var fRead = new FileReader(); //new filereader
                                    fRead.onload = (function (file) { //trigger function on successful read
                                        return function (e) {
                                            var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
                                            $('#thumb-output').append(img); //append image to output element
                                        };
                                    })(file);
                                    fRead.readAsDataURL(file); //URL representing the file's data.
                                }
                            });

                        } else {
                            alert("Your browser doesn't support File API!"); //if File API is absent
                        }
                    });

                });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/admin/profile/index.blade.php ENDPATH**/ ?>