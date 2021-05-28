@extends('layouts.base')
@section('content')

<section class="login">
   <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="loginBox position-relative">
                    <div class="space50"><h2 class="title blue">Reset Password</h2></div>
                    <div class="loginForm">


                        <form id="resetpasswordForm" method="post" class="form" role="form" action="javascript:void(0)">
                            {{ csrf_field() }}
                            <div class="row">
                                <input class="" name="email" type="hidden" value="{{$user->email}}" />
                                <input class="" name="remember_token" type="hidden" value="{{$user->remember_token}}" />
                                <div class="col-md-12 form-group">
                                   <div class="d-flex">
                                   <div class="icon"><img src="{{asset('public/frontend/img/lock.png')}}"></div>
                                   <input class="form-control" id="password" name="password" placeholder="Password" type="password"  /></div>
                                   <div class="brd">&nbsp;</div>
                                </div>

                                <div class="col-md-12 form-group pb-4">
                                   <div class=" d-flex"><div class="icon"><img src="{{asset('public/frontend/img/lock.png')}}"></div>
                                   <input class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" type="password"  /></div>
                                   <div class="brd">&nbsp;</div>
                                </div>
                                <div class="col-md-12 pt-lg-5 form-group d-md-flex justify-content-between align-items-center">
                                   <button type="submit" id="passwordForm">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
<script>

    $.validator.addMethod("pwcheck", function (value) {
        return /^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/.test(value)
    });
    $('#resetpasswordForm').on('submit').validate({

        rules: {

            password: {
                required: true,
                minlength: 6,
                // pwcheck: true,

            },
            cpassword: {
                required: true,
                equalTo: "#password"

            },
        },

        messages: {
            password: {
                required: "This field is required",
                // pwcheck: "Password should be  alphanumeric with at-least 1 number and 1 uppercase character!",
                minlength: "Password length should be  8 charector!"

            },
            cpassword: {
                equalTo: "Confirm password does not match!",
            },
        },
        submitHandler: function(){
            $.ajax({
                url:"{{ url('update-password') }}",
                type:"POST",
                data: new FormData($('#resetpasswordForm')[0]),
                dataType:'json',
                contentType:false,
                cache:false,
                processData:false,
                success:function(data){
                    if(data.status === true){
                      window.location.href = "{{url('/login')}}";
                    }else{
                       showMessage(data.msg, success=false);
                    }
                },
                error: function (xhr, err) {
                    var errMsg = formatErrorMessage(xhr, err);
                    showMessage(errMsg, success=false);
                }
            });
        },
    });
    
</script>
@stop
