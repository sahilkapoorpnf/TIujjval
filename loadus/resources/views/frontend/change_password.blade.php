@extends('layouts.base')
@section('title')
LOADUS
@endsection

@section('content')
<section class="dashbaord p-0">
	<button class="menu-btn"><img src="{{asset('public/frontend/img/menu.png')}}"></button>
	<div class="container">
		<div class="row">
			@include('layouts.left_sidebar')
			<div class="col-md-12 col-lg-9">
				<div class="dshContent">
					<h2 class="title blue">Change Password</h2>
					<hr>
					<form id="changePassword" method="post" class="form" role="form" action="javascript:void(0)">
						{{ csrf_field() }}
					<div class="row">
						<div class="col-md-9">
							<div class="loginForm p-0 pr-lg-5 profile pt-3">
								
								<div class="row">
									<div class="col-md-12 form-group pb-4">
										<div class="d-flex">
										<div class="icon"><img src="{{asset('public/frontend/img/lock.png')}}"></div>
										<input class="form-control" id="old_password" name="old_password" placeholder="Please enter old password" type="password"  /></div>
										<div class="brd">&nbsp;</div>
									</div>

									<div class="col-md-12 form-group pb-4">
										<div class="d-flex">
										<div class="icon"><img src="{{asset('public/frontend/img/lock.png')}}"></div>
										<input class="form-control" id="new_password" name="new_password" placeholder="Please enter new password" type="password"  /></div>
										<div class="brd">&nbsp;</div>
									</div>
									<div class="col-md-12 form-group pb-4">
										<div class="d-flex">
										<div class="icon"><img src="{{asset('public/frontend/img/lock.png')}}"></div>
										<input class="form-control" id="confirm_new_password" name="confirm_new_password"  placeholder="Please enter new password again" type="password"  /></div>
										<div class="brd">&nbsp;</div>
									</div>	
								</div>
							
							
								<div class="row">
									<div class="col-md-12 pt-lg-2 form-group d-flex justify-content-between align-items-center">
										<button type="submit">Save</button>
									</div>
								</div>
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

		$('#changePassword').validate({
	        rules: {
	           "old_password": {required: true},
	           "new_password": {required: true, minlength: 8},
	           "confirm_new_password": {required: true, equalTo: "#new_password"},
	        },
	        messages:{
	            "old_password":{required: "Please enter old password"},
	            "new_password":{required: "Please enter new password", minlength: "Password must be at least 8 characters long"},
	            "confirm_new_password":{required: "Please confirm new password", equalTo: "Confirm Password must be same as password"},
	        },

	        submitHandler: function(){

	            $.ajax({
		            url:"{{ url('changePassword') }}",
		            type:"POST",
		            data: new FormData($('#changePassword')[0]),
		            dataType:'json',
		            contentType:false,
		            cache:false,
		            processData:false,
		            success:function(data){
		                if(data.status === true){
		                	window.location.href = "{{route('dashboard')}}";
		                	// showMessage(data.msg, success=true);
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
	});
</script>

@endsection