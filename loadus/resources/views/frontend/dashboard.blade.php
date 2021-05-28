@extends('layouts.base')
@section('title')
LOADUS
@endsection

@section('content')
<?php 
	if(!empty($user->user_image)){
		$user_image = $user->user_image;
	}else{
		$user_image = 'user_profile.jpg';
	}
?>
@if(session()->has('msg'))
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session()->get('msg') }}
    </div>
    @endif
<section class="dashbaord p-0">
	<div class="container">
		<button class="menu-btn"><img src="{{asset('public/frontend/img/menu.png')}}"></button>
		<div class="row">
			@include('layouts.left_sidebar')
			<div class="col">
				<div class="dshContent">
					<h2 class="title blue">Your Profile <span>({{$myPlan['text']}})</span></h2>
					<hr>
					<form id="updateProfile" method="post" class="form" role="form" action="javascript:void(0)">
						{{ csrf_field() }}
						<div class="row d-flex flex-row-reverse">
							<div class="col-md-3 text-center">
								<input type="file" name="user_image" id="fileInput" accept="image/*" style="display:none;"> 
								<div class="ussePic"><img src = "{{asset('public/uploads') }}/users/{{$user_image }}" id="userPic"><a href="javascript:void(0)"><i class="fa fa-camera" id="changeProfileImage"></i></a></div>
							</div>
							<div class="col-md-9">
								<div class="loginForm p-0 pr-lg-5 profile pt-3">
								<!-- <form id="contact" method="post" class="form" role="form"> -->
									<div class="row">
										<div class="col-md-6 form-group pb-4">
											<div class=" d-flex"><div class="icon"><img src="{{asset('public/frontend/img/user.png')}}"></div>
											<input type="hidden" name="old_user_image" value="{{ $user->user_image }}"   />
											<input type="hidden" name="id" value="{{$user->id}}">
											<input class="form-control" id="first_name" name="first_name" value="{{$user->first_name }}" placeholder="Jonthan" type="text"  /></div>
											<div class="brd">&nbsp;</div>
										</div>
										<div class="col-md-6 form-group pb-4">
											<div class=" d-flex"><div class="icon"><img src="{{asset('public/frontend/img/user.png')}}"></div>
											<input class="form-control" id="last_name" name="last_name" placeholder="Doe"  value="{{$user->last_name }}" type="text" /></div>
											<div class="brd">&nbsp;</div>
										</div>
									</div>
									<div class="row">
										
										<div class="col-md-12 form-group pb-4">
											<div class="d-flex">
											<div class="icon"><img src="{{asset('public/frontend/img/email.png')}}"></div>
											<input class="form-control" id="email" name="email" placeholder="Jonthandoe@gmail.com" value="{{$user->email}}" type="email"  /></div>
											<div class="brd">&nbsp;</div>

										</div>
										<div class="col-md-12 form-group pb-4">
											<div class="d-flex">
											<div class="icon"><img src="{{asset('public/frontend/img/phone3.png')}}"></div>
											<input class="form-control" id="phone" name="phone" value="{{$user->phone}}" placeholder="+1 - 6985-9857" type="Phone"  /></div>
											<div class="brd">&nbsp;</div>

										</div>	
									</div>
									<div class="row">
										<div class="col-md-12 pt-lg-2 form-group d-flex justify-content-between align-items-center">
											<button type="submit">Save</button>
											<a href="{{route('change-password')}}">Change Password ?</a>	
										</div>
									</div>
								<!-- </form> -->
								</div>
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
	
    $(document).ready(function() {

		$('#updateProfile').validate({
	        rules: {
	           "first_name": {required: true},
	           "phone": {required: true},
	           "email": {required: true, email:true},
	        },
	        messages:{
	            "first_name":{required: "Please enter first_name"},
	            "phone":{required: "Please enter Contact Number"},
	            "email":{required: "Please enter valid email", email: "Please enter valid email"},
	        },

	        submitHandler: function(){

	            $.ajax({
		            url:"{{ url('updateProfile') }}",
		            type:"POST",
		            data: new FormData($('#updateProfile')[0]),
		            dataType:'json',
		            contentType:false,
		            cache:false,
		            processData:false,
		            success:function(data){
		                if(data.status === true){
		                 // window.location.reload();
		                	// window.location.href = "/";
		                	showMessage(data.msg, success=true);
		                }else if(data.status === '5'){
		                	window.location.href = "{{url('login')}}"; 
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

	    $('#changeProfileImage').on('click', function() {
	        $("#fileInput").trigger('click');
	    });

	    var imagesrc = $('#userPic').attr('src');
		function filePreview(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        reader.onload = function (e) {
		           // $('#signupForm + img').remove();
		            /*$('.userPic').html('<img src="'+e.target.result+'"/>');*/
		            $('#userPic').attr('src', e.target.result);
		        }
		        reader.readAsDataURL(input.files[0]);
		    }
		}
		$('body').on('change',"#fileInput", function () {
		    filePreview(this);
		});

		$('body').on('click',"#fileInput", function () {
		    $('#userPic').attr('src', imagesrc);
		});
	});
</script>

@endsection