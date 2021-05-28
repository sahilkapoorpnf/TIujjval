@extends('layouts.base')
@section('title')
LOADUS
@endsection
@section('content')
<!-- Login -->
<section class="login">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-9">
            <div class="loginBox position-relative">
               <div class="space50"><h2 class="title blue">Forgot Password</h2></div>
               <div class="loginForm">
                  <!-- <form id="loginInForm" method="post" class="form" role="form" action="{{ url('userLogin') }}"> -->
                  <form id="forgotPassForm" method="post" class="form" role="form" action="javascript:void(0)">
                     {{ csrf_field() }}
                     <div class="row">
                        <div class="col-md-12 form-group pb-4">
                           <div class=" d-flex"><div class="icon"><img src="{{asset('public/frontend/img/user.png')}}"></div>
                           <input class="form-control" id="email" name="email" placeholder="User Email" type="email"  /></div>
                           <div class="brd">&nbsp;</div>
                        </div>
                        
                        <div class="col-md-12 pt-lg-5 form-group d-md-flex justify-content-between align-items-center">
                           <button type="submit" id="forgotForm">Submit</button>
                        </div>
                       
                     </div>
                  </form>
               
            </div>
         
         </div>
      </div>
   </div>
</section>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $('#forgotPassForm').validate({
      rules: {
        "email": {required: true, email:true},
      },
      messages:{
        "email":{required: "Please enter valid email", email: "Please enter valid email"},

      },
      submitHandler: function(){
        $.ajax({
          url:"{{ url('forgotPassword') }}",
          type:"POST",
          data: new FormData($('#forgotPassForm')[0]),
          dataType:'json',
          contentType:false,
          cache:false,
          processData:false,
          success:function(data){
            if(data.status === true){
              // window.location.reload();
              window.location.href = "{{url('/')}}";
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



@endsection