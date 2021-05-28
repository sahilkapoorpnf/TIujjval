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
						<div class="row d-flex justify-content-between align-items-center top-panel">
							<aside class="col-auto">
								<div class="section-title">
									<h2 class="title blue">Created Flowers</h2>
								</div>
							</aside>
							<aside class="col-auto d-flex tierTp justify-content-end align-items-center">
								<!-- <button class="joinBtn">Create Flower</button> -->
								{{ link_to_action('FlowerController@create','Create Flower', null, array('class' => 'joinBtn')) }}
							</aside>
						</div>
						<div class="row groups-item">
						<!--  item group 1 -->
							<?php 
							
							foreach ($created_flowers as $userFlowers) {

								foreach($total_positions as $positions){
									if($positions->id == 2){
										$earth = $positions->total_positions;
									}else if($positions->id == 3){
										$air = $positions->total_positions;
									}else if($positions->id == 4){
										$fire = $positions->total_positions;
									}
								}
								if(!empty($userFlowers->image)){
									$flower_image = asset('public/uploads/flower').'/'.$userFlowers['image'];
								}else{
									$flower_image = asset('public/uploads/users').'/user_profile.jpg';
								}
								// dd($userFlowers->groupflowermembers);
								
								foreach($userFlowers->groupflowermembers as $mem){
									if($mem->position_id == 2){
										$earth = $earth - $mem->total_positions;
									}else if($mem->position_id == 3){
										$air = $air - $mem->total_positions;
									}else if($mem->position_id == 4){
										$fire = $fire - $mem->total_positions;
									}
								}
								?>
								<div class="col-sm-6 col-md-6 col-lg-4 createdFlowers">
									<div class="wrap-shadow">
										<div class="group-img">
										<a href="flower-details/<?= Crypt::encryptString($userFlowers->id) ?>"><img src="<?= $flower_image;?>" alt="" /></a>
										</div>
										<div class="group-content">
											<h4 class="flower_name"><?= $userFlowers->name;?></h4>
											<!-- <p class="id-blue">Business Week (Group id 59875874)</p> -->
											<a href="" class="iocn-round bg-white"><img src="{{asset('public/frontend/img/water.png')}}" alt="icon"></a>
										</div>
										<div class="d-flex flex-row-reverse join-btn clearfix">
											<div class="col-auto p-0 box-half">
											<?php if($userFlowers->is_locked == 1){ ?>	
												
												<a class="btn disabled" href="javascript:void(0)" data-id = "<?= Crypt::encryptString($userFlowers->id);?>">Flower Locked</a>

											<?php }else{?>
				
												<a class="btn invite_flower" href="javascript:void(0)" data-id = "<?= Crypt::encryptString($userFlowers->id);?>">invite user</a>

											<?php } ?>
											</div>
											<div class="col box-half pl-0 pr-2 text-left">
												<div class="txt-mdm">Open Positions</div><div class="txt-rgl"><?= ($fire > 0 ) ? $fire." Fire," : '';?> <?= ($air > 0 ) ? $air." Air," : '';?> <?= ($earth > 0 ) ? $earth." Earth" : '';?></div>
											</div>
										</div>
									</div>
									<div class="text-right ot-option">
										<!-- <a href="">Edit</a> &#124; <a href="">Delete</a> -->
										<?php echo link_to_action('FlowerController@edit','Edit', Crypt::encryptString($userFlowers->id)); ?>
												 &#124; <a href="javascript:void(0)" data-delete="<?= Crypt::encryptString($userFlowers->id);?>" class="delete-data">Delete</a><?php //echo link_to_action('FlowerController@delete','Delete', $userFlowers->id); ?>
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
						<h2 class="title blue">Invite User <!--<span>Position (fire position)</span>--></h2>
					</div>
					<hr>
					<div class="mdkData">
						<div class="loginForm inviteUser profile pt-0">
							<form id="inviteRequest" method="post" class="form" role="form">
								
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

										<input type="hidden" name="invite_flower_id" id="invite_flower_id">
										<input type="hidden" name="_token" value="{{ csrf_token() }}"   />
										<div class="brd">&nbsp;</div>
									</div>
									<div class="col-md-6 form-group pb-2">
										<input class="form-control" id="invite_flower_name" name="invite_flower_name" placeholder="Flower Name" type="text"  />
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

									<div class="col-md-6 form-group pb-2">
										<select class="form-control" id="tierSelect" name="position_id">
											<option data-display="Select Tier" selected disabled> Select Tier </option>
											<?php foreach ($total_positions as $positions) {?>
											<option value="<?= $positions->id?>" ><?= $positions->name?></option>
										<?php } ?>
										  </select>
										<div class="brd">&nbsp;</div>
									</div>

								</div>

								<!-- <div class="row">
									<div class="col-md-6 form-group pb-2">
										<select class="form-control" id="tierSelect" name="position_id">
											<option data-display="Select Tier" selected disabled> Select Tier </option>
											<?php foreach ($total_positions as $positions) {?>
											<option value="<?= $positions->id?>" ><?= $positions->name?></option>
										<?php } ?>
										  </select>
										<div class="brd">&nbsp;</div>
									</div>
								</div>								 -->
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

		$("body").on('click', '.invite_flower', function(){
			$('#mod2').modal('show');
			var id = $(this).data('id');
			var flower_name = $(this).parents('.wrap-shadow').find('.flower_name').text();
			// alert(id);
			$('#invite_flower_id').val(id);
			$('#invite_flower_name').val(flower_name);

			$.ajax({
	         	url:'<?php echo action('GroupController@getflowerpositions') ?>',
	            type:"post",
	            data: {"_token": "{{ csrf_token() }}","id":id},
	            dataType:'json',
	            success:function(data){
	            	$('#mod2').find("#tierSelect").html(data);
             	},
             	error: function (xhr, err) {
					var errMsg = formatErrorMessage(xhr, err);
					showMessage(errMsg, success=false);
		        }
           	});

			$.ajax({
				url:'<?php echo action('GroupController@getInvitableFlowerMembers') ?>',
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

		$("body").on('click', '.delete-data', function(){

			var id = $(this).data('delete');
			var parentDiv = $(this).parents('.createdFlowers')

			$.ajax({
				url:'<?php echo action('FlowerController@destroy') ?>',
				type:"post",
				data: {"_token": "{{ csrf_token() }}","id":id},
				dataType:'json',
				beforeSend:function(){
					return confirm("Are you sure you wanted to delete this flower ?");    
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

		$('#inviteRequest').validate({
         	rules: {
	           	"id": {required: true},
	           	"position_id": {required: true},
				// "userSelect": {required: true},
				"email": {required: true, email: true}
         	},
    		messages:{
	            "id":{required: "Please enter group name"},
	            "position_id":{required: "Please select tier"},
				// "userSelect":{required: "Please select user"},
				"email":{required: "Please enter a email", email: "Please enter valid email"}
            },

         	submitHandler: function(){
	           	$.ajax({
		         	url:'<?php echo action('GroupController@flower_invite_request') ?>',
		            type:"POST",
		            data: new FormData($('#inviteRequest')[0]),
		            dataType:'json',
		            contentType:false,
		            cache:false,
		            processData:false,
		            success:function(data){
	               		if(data.status === true){
	             			// window.location.reload();
	                 		window.location.href = "{{url('created-flowers')}}";
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