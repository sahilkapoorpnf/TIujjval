@extends('layouts.base')
@section('title')
LOADUS
@endsection

@section('content')

	<section class="dashbaord p-0 groups-aside groups">
		<button class="menu-btn"><img src="{{asset('public/frontend/img/menu.png')}}"></button>
		<div class="container">
			<div class="row d-flex align-items-stretch">
				@include('layouts.left_sidebar')
				
				<div class="col">
					<div class="dshContent">
						<div class="row top-panel">
							<aside class="col-lg-7">
								<div class="section-title">
									<h2 class="title blue">Created Groups</h2>
								</div>
							</aside>
							<aside class="col-lg-5 d-flex tierTp justify-content-end align-items-center">
								<!-- <button class="joinBtn">Create Group</button> -->
								<?php if($myPlan['is_subscribed'] == 0){?>

									<span style="color:red">Please buy a subscription plan to create groups.</span>
									
								<?php }else if($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] > 0){?>
									{{ link_to_action('GroupController@create','Create Group', null, array('class' => 'joinBtn')) }} 
								<?php } else if($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] <= 0){?>
									<span style="color:red">Your subscription plan has expired, please buy a new one to create groups.</span>
								<?php }?>
								
							</aside>
						</div>
						<div class="row groups-item">
						<!--  item group 1 -->

							<?php //dd($created_groups->toArray());
							foreach ($created_groups as $userGroups) {
								if(!empty($userGroups->image)){
									$group_image = asset('public/uploads/group').'/'.$userGroups['image'];
								}else{
									$group_image = asset('public/uploads/users').'/user_profile.jpg';
								} 
							?>
								<!--  item group 1 -->
								<div class="col-sm-6 col-md-6 col-lg-4 createdGroups">
									<div class="wrap-shadow">
										<div class="group-img">
											<!-- <img src="<?= $group_image;?>" alt="" /> -->
											<a href="group-details/<?= Crypt::encryptString($userGroups->id) ?>"><img src="<?= $group_image;?>" alt="" /></a>
										</div>
										<div class="group-content">
											<h4 class="group_name"><?= $userGroups->name;?></h4>
										</div>
										<div class="d-flex join-btn clearfix">
											<div class="col-auto p-0 box-half">
												<a class="btn invite_group" href="javascript:void(0)" data-id="<?= Crypt::encryptString($userGroups->id); ?>">invite user</a>
											</div>
											<div class="col box-half pr-0 pl-2 text-right">
												<div class="txt-mdm"><?= $userGroups->total_group_flowers?> Flowers</div><div class="txt-mdm"><?= $userGroups->total_group_members?>  Members</div>
											</div>
										</div>
									</div>
									<div class="text-right ot-option">
										<!-- <a href="">Edit</a> &#124; <a href="">Delete</a> -->
										<?php echo link_to_action('GroupController@edit','Edit', Crypt::encryptString($userGroups->id)); ?>
										  &#124; <?php //echo link_to_action('GroupController@delete','Delete', Crypt::encryptString($userGroups->id)); ?><a href="javascript:void(0)" data-delete="<?= Crypt::encryptString($userGroups->id);?>" class="delete-data">Delete</a>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
	      	</div>
	    </div>
  	</section>

	<!-- Start Popup -->
	<div class="modal fade modalIn" id="mod2">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
			<!-- Modal body -->
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><img src="{{ asset('public/frontend/img/close-btn.png') }}"></button>
					<div class="mdTitle">
						<h2 class="title blue">Invite User to join group <!--<span>Position (fire position)</span>--></h2>
					</div>
					<hr>
					<div class="mdkData">
						<div class="loginForm inviteUser profile pt-0">
							<form id="inviteGroupRequest" method="post" class="form" role="form">
								<div class="col-md-12 form-group pb-2">
									<input class="form-control" id="userSelect123" name="email" placeholder="User Email" type="text"  />
									<div class="brd">&nbsp;</div>
								</div>
								<div class="row">
									<div class="col-md-6 form-group pb-2">
										<!-- <select class="form-control" id="userSelect" name="userSelect">
											<option data-display="Select User" selected disabled> Select User </option>
											<?php foreach ($invitable_users as $positions) {?>
												<option value="<?= $positions->id?>" ><?= $positions->email?></option>
											<?php } ?>
										</select> -->
										<input class="form-control" id="invite_name" name="invite_name" placeholder="User Name" type="text" value="" />
										<input type="hidden" name="invite_group_id" id="invite_group_id">
										<input type="hidden" name="_token" value="{{ csrf_token() }}"   />
										<div class="brd">&nbsp;</div>
									</div>
									<div class="col-md-6 form-group pb-2">
										<input class="form-control" id="invite_group_name" name="invite_group_name" placeholder="Group Name" type="text"  />
										<div class="brd">&nbsp;</div>
									</div>
								</div>
								<div class="row">
									<!-- <div class="col-md-6 form-group pb-2">
									<input class="form-control" id="invite_name" name="invite_name" placeholder="User Name" type="text" value="" />
										<div class="brd">&nbsp;</div>
									</div> -->
									<div class="col-md-6 form-group pb-2">
										<input class="form-control" id="invite_phone" name="invite_phone" placeholder="Phone number" type="text" value="" />
										<div class="brd">&nbsp;</div>
									</div>
								</div>
								<!-- added for email part -start -->
								<!-- <div class="col-md-12 form-group pb-2">
									<input class="form-control" id="userSelect123" name="email" placeholder="User Email" type="text"  />
									<div class="brd">&nbsp;</div>
								</div> -->
								<!-- added for email part -end -->
							
								<div class="row">
										<div class="col-md-12 pt-lg-2 sendInv form-group d-flex justify-content-between align-items-center">
										<button>Send inviation</button>
									</div>
									
								</div>
							</form>										
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<!-- close Popup -->
<script type="text/javascript" src="{{asset('public/frontend/js/chosen.jquery.js')}}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>

<script>
	$(document).ready(function(){

		$("body").on('click', '.invite_group', function(){
			$('#mod2').modal('show');
			var id = $(this).data('id');
			var flower_name = $(this).parents('.wrap-shadow').find('.group_name').text();
			// alert(flower_name);
			$('#invite_group_id').val(id);
			$('#invite_group_name').val(flower_name);

			$.ajax({
				url:'<?php echo action('GroupController@getInvitableGroupMembers') ?>',
				type:"post",
				data: {"_token": "{{ csrf_token() }}","id":id},
				dataType:'json',
				success:function(data){
					$("#userSelect").html(data);
				},
				error: function (xhr, err) {
					var errMsg = formatErrorMessage(xhr, err);
					showMessage(errMsg, success=false);
				}
			});
		});

		$('body').on('change','#userSelect', function(){
			var user_id = $(this).val();
			$.ajax({
				url:'<?php echo action('GroupController@getUserDetails') ?>',
				type:"post",
				data: {"_token": "{{ csrf_token() }}","id":user_id},
				dataType:'json',
				success:function(data){
					console.log(data);
					$('#invite_phone').val(data.phone);
					$('#invite_name').val(data.first_name);
				},
				error: function (xhr, err) {
					var errMsg = formatErrorMessage(xhr, err);
					showMessage(errMsg, success=false);
				}
			});
		});

		$('body').on('change','#userSelect123', function(){
			var email = $(this).val();
			$.ajax({
				url:'<?php echo action('GroupController@checkUser') ?>',
				type:"post",
				data: {"_token": "{{ csrf_token() }}","email":email},
				dataType:'json',
				success:function(data){
					// console.log(data);
					// if(data.is_user == true){
						$('#invite_phone').val(data.phone);
						$('#invite_name').val(data.first_name);
					// }	
				},
				error: function (xhr, err) {
					var errMsg = formatErrorMessage(xhr, err);
					showMessage(errMsg, success=false);
				}
			});
		});

		$('#inviteGroupRequest').validate({
         	rules: {
	           	"id": {required: true},
				// "userSelect": {required: true},
			   	"email": {required: true, email: true}
         	},
    		messages:{
	            "id":{required: "Please enter group name"},
				// "userSelect":{required: "Please select user"},
				"email":{required: "Please enter a email", email: "Please enter valid email"}
            },

         	submitHandler: function(){
	           	$.ajax({
		         	url:'<?php echo action('GroupController@group_invitation') ?>',
		            type:"POST",
		            data: new FormData($('#inviteGroupRequest')[0]),
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
	             	error: function (xhr, err) {
						var errMsg = formatErrorMessage(xhr, err);
						showMessage(errMsg, success=false);
			        }
	           	});
     		},
  		});

		$("body").on('click', '.delete-data', function(){

			var id = $(this).data('delete');
			var parentDiv = $(this).parents('.createdGroups')

			$.ajax({
				url:'<?php echo action('GroupController@destroy') ?>',
				type:"post",
				data: {"_token": "{{ csrf_token() }}","id":id},
				dataType:'json',
				beforeSend:function(){
                    return confirm("Are you sure you wanted to delete this group ?");    
                },
				success:function(data){
					if(data.status == true){
						parentDiv.remove();
						showMessage(data.msg, success=true);
					}else{
						showMessage(data.msg, success=false);
					}
					
				},
				error: function (xhr, err) {
					var errMsg = formatErrorMessage(xhr, err);
					showMessage(errMsg, success=false);
				}
			});
		});

	});
</script>

@endsection