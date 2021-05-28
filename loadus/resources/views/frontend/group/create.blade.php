@extends('layouts.base')
@section('title')
LOADUS
@endsection

@section('content')
<?php
	if(!empty($receiverDetails->user_image)){
		$user_image = asset('public/uploads/users').'/'.$group_flower_details['groupowner']['user_image'];
	}else{
		$user_image = asset('public/uploads/users').'/user_profile.jpg';
	} 
?>
	<section class="dashbaord p-0">
		<button class="menu-btn"><img src="{{asset('public/frontend/img/menu.png')}}"></button>
		<div class="container">
			<div class="row d-flex align-items-stretch">
				@include('layouts.left_sidebar')
				
				<div class="col-md-12 col-lg-9">
		          	<div class="dshContent">
		            <h2 class="title blue"><?= isset($group_details->id) ? "Edit Group" : "Create Group";?></h2>
		            <hr>
		            	<div class="row">
		              		<div class="col-md-12">
		                		<div class="loginForm p-0 pt-3 profile creat-profile">
		                  			<form id="groupForm" method="post" class="form" role="form">
		                    			<div class="row">
					                      	<div class="col-md-10 form-group pb-4">
					                      		<input type="hidden" name="_token" value="{{ csrf_token() }}"   />
					                      		<?php if(isset($group_details->id)){?>  
								              		<input type="hidden" name="old_group_image" value="{{ $group_details->image }}"   />
								              		<input type="hidden" id="id" name="id" value="{{ Crypt::encryptString($group_details->id) }}"   />
									            <?php } ?>  
					                        	<input class="form-control" id="name" name="name" placeholder="Group Name" type="text" value="<?= isset($group_details->name) ? $group_details->name : '';?>" />
					                        	<div class="brd">&nbsp;</div>
				                     	 	</div>
					                      	<div class="col-md-10 form-group pb-4">
					                        	<textarea class="form-control" placeholder="Add Description" name="description"><?= isset($group_details->description) ? $group_details->description : '';?></textarea>
					                        	<div class="brd">&nbsp;</div>
					                      	</div>
		                    			</div>
				                    	<div class="row">
					                      	<div class="col-md-10 form-group pb-4">
					                        	<div class="upload-btn-wrapper">
					                          		<button class="btn">Upload Photo</button>
					                          		<input type="file" name="group_image" />
					                        	</div>
					                        	<div class="brd">&nbsp;</div>
					                      	</div>
				                    	</div>
				                    	<?php if(!isset($group_details->id)){?>  
					                    <div class="row">
											<div class="col-md-10 pb-4">
												<select data-placeholder="Add Members" class="chosen-select" name="group_members[]" multiple>
													<?php foreach($users as $user){?>
														<option value="<?= $user->id?>"><?= $user->email?></option>
													<?php  } ?>
												</select>
											</div>	
					                    </div>
									  	
									  	<div class="row">
				                      		<div class="col-md-10 form-group pb-4">
					                        	
					                        	<select class="form-control" name="parent_id">
											  		<option value="">Add Flower</option>
											  		<?php foreach ($user_flowers as $flower): ?>
											  			
											  		<option value="<?= $flower->id;?>"><?= $flower->name;?></option>

											  		<?php endforeach ?>
											  	</select> 
					                        	<div class="brd">&nbsp;</div>
					                      	</div>
										</div>
										<?php } ?>

										<div class="row">
											<div class="col-md-10 form-group pb-4">
												<label class="select-opt d-inline pull-left mr-5 check">Public
													<input type="radio" <?= (isset($group_details->privacy) && $group_details->privacy == 0) ? "" : "checked" ?> name="privacy" value="1">
													<span class="checkmark"></span>
												</label>
												<label class="select-opt d-inline pull-left check">Private
													<input type="radio" name="privacy" value="0" <?= (isset($group_details->privacy) && $group_details->privacy == 0) ? "checked" : "" ?>>
													<span class="checkmark"></span>
												</label>
											</div>
										</div>

										<div class="row passwordDiv" style="<?= (isset($group_details->privacy) && $group_details->privacy == 0) ? "" : "display: none" ?>">
					                      	<div class="col-md-10 form-group pb-4">
					                        	<input class="form-control" id="password" name="password" placeholder="Password" type="text" value="<?= isset($group_details->password) ? $group_details->password : '';?>" />
					                        	<div class="brd">&nbsp;</div>
					                      	</div>
										</div>

				                    	<div class="row">
				                      		<div class="col-md-12 pt-lg-2 form-group d-flex justify-content-between align-items-center">
				                        		<button>Save</button>
				                      		</div>
				                    	</div>
		                  			</form>
		                		</div>
		              		</div>
		            	</div>
		          	</div>
		        </div>
	      	</div>
	    </div>
  	</section>
<script type="text/javascript" src="{{asset('public/frontend/js/chosen.jquery.js')}}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });

        $('body').on('click','.check', function(){
        	var privacy = $("input[name='privacy']:checked").val();
        	if(privacy == 1){
	        	$('.passwordDiv').hide();
	        }else{
	        	$('.passwordDiv').show();
	        }
        });
	});

	$('document').ready(function(){
		$('#groupForm').validate({
         	rules: {
	           "name": {required: true},
	           "group_image": {required: <?= isset($group_details->id) ? 'false' : 'true'?>},
         	},
    		messages:{
	            "name":{required: "Please enter group name"},
	            "group_image":{required: "Please upload group Image"},
            },

         	submitHandler: function(){

	           	$.ajax({
		         	url:'<?php echo action('GroupController@store') ?>',
		            type:"POST",
		            data: new FormData($('#groupForm')[0]),
		            dataType:'json',
		            contentType:false,
		            cache:false,
		            processData:false,
		            success:function(data){
	               		if(data.status === true){
	             			// window.location.reload();
	                 		window.location.href = "{{url('created-groups')}}";
	               		}else{
	                  		showMessage(data.msg, success=false);
	               		}
	             	},
	             	error: function (xhr, err) {console.log(xhr, err);
						var errMsg = formatErrorMessage(xhr, err);
						showMessage(errMsg, success=false);
			        }
	           	});
     		},
  		});
	});

</script>
@endsection