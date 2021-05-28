@extends('layouts.base')
@section('title')
LOADUS
@endsection
@section('content')
<!-- Sign-Up -->
<!-- Login -->
      <section class="login">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-lg-9">
                  <div class="loginBox position-relative">
                     <div class="space50"><h2 class="title blue">Sign Up Now</h2></div>
                     <div class="loginForm">
                        <!-- <form id="signUpForm" method="post" class="form" role="form" action="{{ url('userSignup') }}"> -->
                        <form id="signUpForm" method="post" class="form" role="form" action="javascript:void(0)">
                           {{ csrf_field() }}
                           <div class="row">
                              <div class="col-md-6 form-group pb-4">
                                 <div class=" d-flex"><div class="icon"><img src="{{asset('public/frontend/img/user.png')}}"></div>
                                 <input class="form-control" id="first_name" name="first_name" placeholder="First Name *" type="text"  /></div>
                                 <div class="brd">&nbsp;</div>
                              </div>
                              <div class="col-md-6 form-group pb-4">
                                 <div class=" d-flex"><div class="icon"><img src="{{asset('public/frontend/img/user.png')}}"></div>
                                 <input class="form-control" id="last_name" name="last_name" placeholder="Last Name" type="text"  /></div>
                                 <div class="brd">&nbsp;</div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12 form-group pb-4">
                                 <div class="d-flex">
                                 <div class="icon"><img src="{{asset('public/frontend/img/phone2.png')}}"></div>
                                 <input class="form-control" id="phone" name="phone" placeholder="Contact Number*" type="Phone"  /></div>
                                 <div class="brd">&nbsp;</div>

                              </div>
                              <div class="col-md-12 form-group pb-4">
                                 <div class="d-flex">
                                 <div class="icon"><img src="{{asset('public/frontend/img/email.png')}}"></div>
                                 <input class="form-control" id="email" name="email" placeholder="Email*" type="email"  /></div>
                                 <div class="brd">&nbsp;</div>

                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6 form-group pb-4">
                                 <div class=" d-flex"><div class="icon"><img src="{{asset('public/frontend/img/user.png')}}"></div>
                                 <input class="form-control" id="password" name="password" placeholder="Password*" type="password"  /></div>
                                 <div class="brd">&nbsp;</div>
                              </div>
                              <div class="col-md-6 form-group pb-4">
                                 <div class=" d-flex"><div class="icon"><img src="{{asset('public/frontend/img/user.png')}}"></div>
                                 <input class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password*" type="password"  /></div>
                                 <div class="brd">&nbsp;</div>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="col-md-12 pt-lg-2 pb-4 form-group">
                                  <p class="cstm"><label><input type="checkbox" name="option[]" value="" ></label>I accept <a href="terms-condition" target="_blank">terms and conditions</a> of Loadus.</p>
                                 
                              </div>
                              <div class="col-md-12 pt-lg-2 form-group d-flex justify-content-between align-items-center">
                                 <button type="submit" id="signUpSubmit">Submit</button>
                                 
                              </div>
                              
                           </div>
                        </form>
                     
                  </div>
               
               </div>
            </div>
         </div>
      </section>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
<!-- custom check box --> 
<script type="text/javascript">
  function customCheckbox(checkboxName){
    var checkBox = $('input[name="'+ checkboxName +'"]');
    $(checkBox).each(function(){
      $(this).wrap( "<span class='custom-checkbox'></span>" );
      if($(this).is(':checked')){
        $(this).parent().addClass("selected");
      }
    });
    $(checkBox).click(function(){
      $(this).parent().toggleClass("selected");
    });
  }
  $(document).ready(function (){
    customCheckbox("option[]");
  })
  var isChecked = $("input[type='checkbox']").is(":checked");
  // alert(isChecked);
  if(isChecked === false){
    document.getElementById("signUpSubmit").disabled = true;
  }
  $('body').on("click","input[type='checkbox']", function(){
    var isChecked = $("input[type='checkbox']").is(":checked");
    if(isChecked === false){
      document.getElementById("signUpSubmit").disabled = true;
    }else{
      document.getElementById("signUpSubmit").disabled = false;
    }
  });

  $('#signUpForm').validate({
    rules: {
      "first_name": {required: true},
      "phone": {required: true},
      "email": {required: true, email:true},
      "password": {required: true, minlength: 6},
      "cpassword": {required: true, equalTo: "#password"},
    },
    messages:{
      "first_name":{required: "Please enter first_name"},
      "phone":{required: "Please enter Contact Number"},
      "email":{required: "Please enter valid email", email: "Please enter valid email"},
      "password": {required: "Please enter a password.", minlength: "Password must be at least 6 characters long."},
      "cpassword": {required: "Please enter a password.", equalTo: "Confirm Password must be same as password."},
    },

    submitHandler: function(){

      $.ajax({
        url:"{{ url('userSignup') }}",
        type:"POST",
        data: new FormData($('#signUpForm')[0]),
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