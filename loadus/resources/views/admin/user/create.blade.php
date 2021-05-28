
@extends('adminlte::page')

@section('title', "$titles")

@section('content_header')

<h1>{{ $titles }}</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $titles }}</a></li>    
</ol>
<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="{{url('/admin/user')}}"><button class="btn btn-success btn-flat">Back</button></a>
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
        <?php $action = isset($data->id) ? 'admin/user/update/'.$data->id : 'admin/user/store'; ?>
        {{ Form::open(array('url' => $action,'id'=>'myForm','autocomplete'=>'off', 'enctype'=>"multipart/form-data")) }}
        <div class="box-body">
            {{Form::hidden('pass',null,['id'=>'pass'])}}

            <div class=" col-md-6">
                <div class="form-group">
                    <label>First Name</label>
                    <?php if(isset($data->id)){?>  
                    <input type="hidden" name="old_user_image" value="{{ $data->user_image }}"   />
                    <input type="hidden" name="id" value="{{ $data->id }}"   /><?php } ?>                     
                    <?php echo Form::text('first_name', isset($data->first_name) ? $data->first_name : Input::get('first_name'), array('class' => 'form-control', 'placeholder' => 'Name')); ?>
                </div>
            </div>

            <div class=" col-md-6">
                <div class="form-group">
                    <label>Last Name</label>                        
                    <?php echo Form::text('last_name', isset($data->last_name) ? $data->last_name : Input::get('last_name'), array('class' => 'form-control', 'placeholder' => 'Name')); ?>
                </div>
            </div>

            <div class=" col-md-6">
                <div class="form-group">
                    <label>Phone Number</label>                        
                    <?php echo Form::text('phone', isset($data->phone) ? $data->phone : Input::get('phone'), array('class' => 'form-control', 'maxlength' => '10', 'placeholder' => 'Phone number')); ?>
                </div>
            </div>

            <div class=" col-md-6">
                <div class="form-group">
                    <label>Email</label>                        
                    <?php echo Form::text('email', isset($data->email) ? $data->email : Input::get('email'), array('class' => 'form-control', 'placeholder' => 'Email')); ?>
                </div>
            </div>
            <?php if (!isset($data->password)) { ?>
                <div class=" col-md-6">
                    <div class="form-group">
                        <label>Password</label>                        
                        <?php echo Form::password('password', array('class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password'), isset($data->password) ? $data->password : Input::get('password')); ?>
                    </div>
                </div>

                <div class=" col-md-6">
                    <div class="form-group">
                        <label>Confirm Password</label>                        
                        <?php echo Form::password('confirm_password', array('class' => 'form-control', 'id' => 'confirm_password', 'placeholder' => 'Confirm Password'), isset($data->confirm_password) ? $data->confirm_password : Input::get('password')); ?>
                    </div>
                </div>

            <?php } ?>

                <div  class="form-group">
                  <label>User Image</label>      
                  <input class="form-control" id="user_image" name="user_image" type="file">
                    <?php if(isset($data->id)){?>
                      <a target="_blank" href="{{url('public/uploads')}}/users/{{$data->user_image}}">
                      <img src="{{asset('public/uploads')}}/users/{{$data->user_image}}" width="80" height="80"  />
                      </a>
                    <?php }?>
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
            <button type="submit" class="btn btn-success btn-flat" onclick="hasashing()"><?php echo isset($data->id) ? 'Update' : 'Submit' ?></button>
        </div>
        {{ Form::close() }}
    </div>
</div>
<script src="<?php echo URL::to('/vendor/adminlte/dist/js/validation.js'); ?>"></script>

<script>
                $(function () {
                    $('#myForm').on('submit').validate({

                        rules: {

                            first_name: {
                                required: true,
                            },
                            phone: {
                                required: true,
                                minlength: 10,
                                maxlength: 10,
                                number: true,
                            },
                            email: {
                                required: true,
                                email: true,
                                isemail: true,

                            },
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
                            status: {
                                required: true,
                                number: true

                            }
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
                            email: {
                                isemail: "Please enter a valid email address.",

                            },
                        }
                        ,
                        submitHandler: function (form) {
                            form.submit();
                        }

                    });
                    $.validator.addMethod("pwcheck", function (value) {
                        return /^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/.test(value)
                    });
                    $.validator.addMethod("isemail", function (value) {
                        return /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value)
                    });

                });
</script>
<script type="text/javascript">
    function hasashing() {
        if (document.getElementById('password').value != '') {
            var Apass = document.getElementById('password').value;
            $('#pass').val(Apass)+"TR";

            var pass = document.getElementById('password').value + "<?php echo Config::get('constants.KEY.PKEY'); ?>";
            var hashpass = SHA256(pass)+"TR";;


            var pass1 = document.getElementById('confirm_password').value + "<?php echo Config::get('constants.KEY.PKEY'); ?>";
            var hashpass1 = SHA256(pass1)+"TR";;


            // alert(hashpass);
            document.getElementById('password').value = hashpass;
            document.getElementById('confirm_password').value = hashpass1;
        }
    }
</script>



@stop