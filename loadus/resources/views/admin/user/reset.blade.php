
@extends('adminlte::page')

@section('title', "$title")

@section('content_header')

<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $title }}</a></li>    
</ol>
<div class="clearfix cbutton">
    <div class="pull-right">
        <a  href="<?php echo URL::to('/admin/user'); ?>" style="float: right"><button class="btn btn-success btn-flat">Back</button></a>
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
        <?php $action = isset($data->id) ? 'admin/user/updatepass/'. Crypt::encryptString($data->id) : ''; ?>
        {{ Form::open(array('url' => $action,'id'=>'myForm','enctype'=>"multipart/form-data")) }}
        <div class="box-body">

            <div class=" col-md-6">
                <div class="form-group">
                    <label>Password</label>                        
                    <input type="password" name="password" id="password" class="form-control"  placeholder="Password">
                </div>
            </div>

            <div class=" col-md-6">
                <div class="form-group">
                    <label>Confirm Password</label>                        
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                </div>
            </div>



            <div class="box-footer">
                <button type="submit" class="btn btn-success btn-flat" onclick="hasashing()"><?php echo isset($data->id) ? 'Update' : 'Submit' ?></button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <script src="<?php echo URL::to('/public/vendor/adminlte/dist/js/validation.js'); ?>"></script>

    <script>
                    $(function () {
                        $('#myForm').on('submit').validate({

                            rules: {

                                password: {
                                    required: true,
                                    minlength: 8,
                                    pwcheck: true,

                                },
                                confirm_password: {
                                    required: true,
                                    minlength: 8,
                                    pwcheck: true,
                                    equalTo: "#password"

                                },

                            },

                            messages: {
                                password: {
                                    required: "This field is required",
                                    pwcheck: "Password should be  alphanumeric with one upper character and one lower character!",
                                    minlength: "Password length should be  8 character!"

                                },
                                confirm_password: {
                                    pwcheck: "Password should be  alphanumeric with one upper character and one lower character!",
                                    equalTo: "Confirm password does not match!",                                    

                                },
                                
                            },
                            
                            submitHandler: function (form) {
                                form.submit();
                            }

                        });
                        $.validator.addMethod("pwcheck", function (value) {
                            return /^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/.test(value)
                        });

                    });
                    function hasashing() {
                        if (document.getElementById('password').value != '') {
                            var pass = document.getElementById('password').value + "<?php echo Config::get('constants.KEY.PKEY'); ?>";
                            var hashpass = SHA256(pass)+"TR";
                            
                            var pass1 = document.getElementById('confirm_password').value + "<?php echo Config::get('constants.KEY.PKEY'); ?>";
                            var hashpass1 = SHA256(pass1)+"TR";
//                             alert(hashpass);
                            document.getElementById('password').value = hashpass;
                            document.getElementById('confirm_password').value = hashpass1;
                        }
                    }
    </script>

    @stop