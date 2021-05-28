@extends('layouts.base')
@section('title')
LOADUS
@endsection

@section('content')
<?php 
	$loggedInUser = Auth::guard('user')->user()->id;

	if($group_details->user_id == $loggedInUser){
		$chatLink = url('messages');
	}else{
		$chatLink = url('chatHistory').'/'.$group_details->id."?uId=".$group_details->user_id;
	}

?>
<!--group pool -->
<section class="section avail-group groups">
	<div class="container">
		<div class="row top-panel">
			<aside class="col-lg-7">
				<div class="section-title">
					<h2 class="title blue"><?= $group_details->name;?> <span>(Group ID 07212007LOUS)</span></h2>
				</div>
			</aside>
			<aside class="col-lg-5 d-flex tierTp justify-content-lg-between justify-content-lg-end align-items-center">
				<div class="col-lg-auto p-0 d-inline-block"><?= $group_details->total_group_flowers;?> Flowers<span class="d-block"><?= $group_details->total_group_members;?> Members</span></div>
				<div class="col-lg-auto p-0 d-inline-block">
					<a href="<?= $chatLink?>" class="d-inline-block msgLink"><img src="{{asset('public/frontend/img/chat.png')}}"/></a>
					<a href="#" class="d-inline-block lockLink"><img src="{{asset('public/frontend/img/lock-login.png')}}"/></a>
				</div>
			</aside>
		</div>
		<div class="groups-wrap">
			<div class="groups-content">
				<?= $group_details->description;?>
			</div>
			<div class="row">

				<?php if(!empty($group_flowers)){
					foreach ($group_flowers as $flowers) {
						if(!empty($flowers->image)){
							$flower_image = asset('public/uploads/flower').'/'.$flowers->image;
						}else{
							$flower_image = asset('public/uploads/users').'/user_profile.jpg';
						}

						if(!empty($flowers->privacy == 1)){
							$lock = "bg-blue lock-open";
						}else{
							$lock = "bg-grey lock-close";
						}

						foreach($total_positions as $positions){
							if($positions->id == 2){
								$earth = $positions->total_positions - $flowers->earth_members;
							}else if($positions->id == 3){
								$air = $positions->total_positions - $flowers->air_members;
							}else if($positions->id == 4){
								$fire = $positions->total_positions - $flowers->fire_members;
							}
						}


				?>
				<!--  item group 1 -->
				<div class="col-md-4">
					<div class="wrap-shadow">
						<div class="group-img">
						<a href="{{url('flower-details')}}/<?= Crypt::encryptString($flowers->group_id) ?>"><img src="<?= $flower_image;?>" alt="Image not available" /></a>
						</div>
						<div class="group-content">
							<h4 class="flower_name"><?= $flowers->name;?></h4>
							<p><?= substr($flowers->description, 0, 35).'...';?></p>
							<a href="" class="iocn-round group_privacy <?= $lock;?>" data-value="<?= $flowers->privacy;?>"></a>
						</div>
						<div class="d-flex join-btn clearfix">
							<div class="col-auto p-0 box-half">

								<?php if($flowers->is_locked == 1){ ?>	
												
									<a class="btn disabled" href="javascript:void(0)" data-id = "<?= Crypt::encryptString($flowers->id);?>">Flower Locked</a>
								
								<?php }else if($flowers->user_id == Auth::guard('user')->user()->id){ ?>
									<a class="btn invite_flower" href="#" data-id = "<?= Crypt::encryptString($flowers->group_id);?>">Invite User</a>								
								
								<?php } else if(empty($flowers->is_member)){ ?>
									<a class="btn join_flower" href="#" data-id ="<?= Crypt::encryptString($flowers->group_id);?>">Join Flower</a>
								<?php }else if(($flowers->is_member == 1) && $flowers->sent_by == Auth::guard('user')->user()->id && $flowers->is_accepted != 1){ ?>
									<a class="btn invite_flower12" href="#" data-id = "<?= Crypt::encryptString($flowers->group_id);?>">Cancel Request</a>
								<?php } else if($flowers->is_member == 1 && $flowers->sent_by != Auth::guard('user')->user()->id && $flowers->is_accepted != 1){?>
									<a class="btn accept_flower_request" href="#" data-id = "<?= Crypt::encryptString($flowers->group_id);?>">Accept Request</a>
								<?php } ?>
							</div>
							<div class="col pr-0 pl-2 box-half text-right">
								<div><strong>Open Positions</strong></div><div><?= ($fire > 0 ) ? $fire." Fire," : '';?> <?= ($air > 0 ) ? $air." Air," : '';?> <?= ($earth > 0 ) ? $earth." Earth" : '';?></div>
							</div>
						</div>
					</div>
				</div>

				<?php } }?>
				

			</div>
		</div>
	</div>
</section>
<!-- end group pool -->

<!-- Start Popup -->
	<div class="modal fade modalIn" id="mod1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
			<!-- Modal body -->
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><img src="{{ asset('public/frontend/img/close-btn.png') }}"></button>
					<div class="mdTitle">
						<h2 class="title blue">Join Flower <!--<span>Position (fire position)</span>--></h2>
					</div>
					<hr>
					<div class="mdkData">
						<div class="loginForm inviteUser profile pt-0">
							<form id="joinRequest" method="post" class="form" role="form">
								<div class="row">
									<div class="col-md-6 form-group pb-2">
										<input class="form-control" id="name" name="name" placeholder="User Name" type="text" value="<?= Auth::guard('user')->user()->first_name?>" />
										<input type="hidden" name="flower_id" id="flower_id">
										<input type="hidden" name="_token" value="{{ csrf_token() }}"   />
										<div class="brd">&nbsp;</div>
									</div>
									<div class="col-md-6 form-group pb-2">
										<input class="form-control" id="flower_name" name="flower_name" placeholder="Flower Name" type="text"  />
										<div class="brd">&nbsp;</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 form-group pb-2">
										<input class="form-control" id="name" name="name" placeholder="Email ID" type="text" value="<?= Auth::guard('user')->user()->email?>" />
										<div class="brd">&nbsp;</div>
									</div>
									<div class="col-md-6 form-group pb-2">
										<input class="form-control" id="name" name="name" placeholder="Phone number" type="text" value="<?= Auth::guard('user')->user()->phone?>" />
										<div class="brd">&nbsp;</div>
									</div>
								</div>

								<div class="row">
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
								<div class="row">
									<div class="col-md-6 form-group pb-2">
										<select class="form-control" id="userSelect" name="userSelect">
											<option data-display="Select User" selected disabled> Select User </option>
											<?php foreach ($invitable_users as $positions) {?>
												<option value="<?= $positions->id?>" ><?= $positions->email?></option>
											<?php } ?>
										</select>
										
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
									<div class="col-md-6 form-group pb-2">
									<input class="form-control" id="invite_name" name="invite_name" placeholder="User Name" type="text" value="" />
										<div class="brd">&nbsp;</div>
									</div>
									<div class="col-md-6 form-group pb-2">
										<input class="form-control" id="invite_phone" name="invite_phone" placeholder="Phone number" type="text" value="" />
										<div class="brd">&nbsp;</div>
									</div>
								</div>

								<div class="row">
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

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>	
<script type="text/javascript">
	$(document).ready(function(){
		$("body").on('click', '.join_flower', function(){
			$('#mod1').modal('show');
			var id = $(this).data('id');
			var flower_name = $(this).parents('.wrap-shadow').find('.flower_name').text();
			$('#flower_id').val(id);
			$('#flower_name').val(flower_name);

			$.ajax({
	         	url:'<?php echo action('GroupController@getflowerpositions') ?>',
	            type:"post",
	            data: {"_token": "{{ csrf_token() }}","id":id},
	            dataType:'json',
	            success:function(data){
	            	$("#tierSelect").html(data);
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
			// alert(flower_name);
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

		$('#mod1').on('hide.bs.modal', function () {
		  $('#flower_id').val('');
		  $('#flower_name').val('');
		})

		$('#joinRequest').validate({
         	rules: {
	           "id": {required: true},
	           "position_id": {required: true},
         	},
    		messages:{
	            "id":{required: "Please enter group name"},
	            "position_id":{required: "Please select tier"},
            },

         	submitHandler: function(){
	           	$.ajax({
		         	url:'<?php echo action('GroupController@flower_join_request') ?>',
		            type:"POST",
		            data: new FormData($('#joinRequest')[0]),
		            dataType:'json',
		            contentType:false,
		            cache:false,
		            processData:false,
		            success:function(data){
	               		if(data.status === true){
	             			// window.location.reload();
	                 		window.location.href = "{{url('group-details')}}/<?= Crypt::encryptString($group_details->id);?>";
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


		$('#inviteRequest').validate({
         	rules: {
	           "id": {required: true},
	           "position_id": {required: true},
			   "userSelect": {required: true}
         	},
    		messages:{
	            "id":{required: "Please enter group name"},
	            "position_id":{required: "Please select tier"},
				"userSelect":{required: "Please select user"}
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
	                 		window.location.href = "{{url('group-details')}}/<?= Crypt::encryptString($group_details->id);?>";
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

		$('body').on('click','.accept_flower_request',function(){

            var group_privacy = $(this).parents('.wrap-shadow').find('.group_privacy').data('value');
            var group_id = $(this).data('id');
            if(group_privacy == 1){
                $.ajax({
                    url:'<?php echo action('FlowerController@acceptFlowerMember') ?>',
                    type:"POST",
                    data: {"_token": "{{ csrf_token() }}","group_id":group_id},
                    dataType:'json',
                    beforeSend:function(){
                        return confirm("Are you sure you wanted to accept this request ?");    
                    },
                    success:function(data){
                        if(data.status === true){
                            // window.location.reload();
                            window.location.href = "{{url('group-details')}}/<?= Crypt::encryptString($group_details->id);?>";
                        }else{
                            showMessage(data.msg, success=false);
                        }
                    },
                    error: function (xhr, err) {
                        var errMsg = formatErrorMessage(xhr, err);
                        showMessage(errMsg, success=false);
                    }
                });
            }else{
                $('#mod3').modal('show');
                var id = $(this).data('id');
                
                var group_name = $(this).parents('.wrap-shadow').find('.group_name').text();
                
                $('#group_id_accept').val(id);
                $('#group_name_accept').val(group_name);

                $('#acceptGroupJoinRequest').validate({
                    rules: {
                    "id": {required: true},
                    "password": {required: true}
                    },
                    messages:{
                        "id":{required: "Please enter group name"},
                        "password":{required: "Please enter password"}
                    },

                    submitHandler: function(){
                        $.ajax({
                            url:'<?php echo action('FlowerController@acceptFlowerMember') ?>',
                            type:"POST",
                            data: new FormData($('#acceptGroupJoinRequest')[0]),
                            dataType:'json',
                            contentType:false,
                            cache:false,
                            processData:false,
                            success:function(data){
                                if(data.status === true){
                                    // window.location.reload();
                                    window.location.href = "{{url('flower-pool')}}";
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
            }     
        });

	});
</script>
@endsection