@extends('layouts.base')
@section('title')
LOADUS
@endsection

@section('content')

<?php 
// echo "<pre>";print_r($flower_details->group_id);die;
// echo $flower_details->name;die;
	if(!empty($flower_details)){
		

		if(!empty($flower_details->privacy == 1)){
			$lock = "bg-blue lock-open";
		}else{
			$lock = "bg-grey lock-close";
		}

		foreach($total_positions as $positions){
			if($positions->id == 2){
				$earth = $positions->total_positions - $flower_details->earth_members;
			}else if($positions->id == 3){
				$air = $positions->total_positions - $flower_details->air_members;
			}else if($positions->id == 4){
				$fire = $positions->total_positions - $flower_details->fire_members;
			}
		}

	}

	$loggedInUser = Auth::guard('user')->user()->id;
	// $chatLink = '';
	if($flower_details->user_id == $loggedInUser){
		$chatLink = url('messages');
	}else{
		$chatLink = url('chatHistory').'/'.$flower_details->group_id."?uId=".$flower_details->user_id;
	}
	
?>

<!--group pool -->
<section class="section avail-group">
	<div class="container">
		<div class="row">
			<aside class="col-lg-7">
				<div class="section-title">
					<h2 class="title blue"><?= $flower_details->name;?><!--Business Strategy <span>(Group ID 07212007LOUS)</span>--></h2>
				</div>
			</aside>
			<aside class="col-lg-5 d-flex tierTp justify-content-end align-items-center">
				<div class="pos d-inline-block">Open Positions <span class="d-block"><?= ($fire > 0 ) ? $fire." Fire," : '';?> <?= ($air > 0 ) ? $air." Air," : '';?> <?= ($earth > 0 ) ? $earth." Earth" : '';?> </span></div>
				<a href="<?= $chatLink?>" class="msgLink"><img src="{{ asset('public/frontend/img/chat.png') }}"/></a>

				<?php if($flower_details->is_locked == 1){ ?>	
				
					<button class="btn" disabled data-id = "<?= Crypt::encryptString($flower_details->group_id);?>">Flower Locked</button>
				
				<?php }else if($flower_details->user_id == Auth::guard('user')->user()->id){ ?>
					<button class="joinBtn invite_flower" data-id = "<?= Crypt::encryptString($flower_details->group_id);?>">Invite User</button>
				
				<?php } else if(empty($flower_details->is_member)){ ?>
					<button class="joinBtn join_flower" data-id = "<?= Crypt::encryptString($flower_details->group_id);?>">Join Flower</button>
				<?php }else if(($flower_details->is_member == 1) && $flower_details->sent_by == Auth::guard('user')->user()->id && $flower_details->is_accepted != 1){ ?>
					<button class="joinBtn cancel_flower_request" data-id = "<?= Crypt::encryptString($flower_details->group_id);?>">Cancel Request</button>
				<?php } else if($flower_details->is_member == 1 && $flower_details->sent_by != Auth::guard('user')->user()->id && $flower_details->is_accepted != 1){?>
					<button class="joinBtn accept_flower_request" data-id = "<?= Crypt::encryptString($flower_details->group_id);?>">Accept Request</button>
				<?php } ?>
				
			</aside>
		</div>
		<div class="tiers">
			<div class="text-center">
				<div class="tiersFig d-inline-block">
					<img src="{{ asset('public/frontend/img/lotus.png') }}" class="img-fluid" alt="Loadus" />

					<?php 
					foreach($flower_positions as $pos){
						
						$userImage = asset('public/uploads/users')."/".$pos['group_flower_user']['user_image'];
						$full_name = $pos['group_flower_user']['first_name'].' '.$pos['group_flower_user']['last_name'];
						
					?>
						<div class="tImg <?= $pos['flowerClass']; ?>">
							<a href="#" data-toggle="tooltip" data-placement="left" title="<?= $full_name;?>"><img src="<?= $userImage;?>" class="img-fluid" alt="Loadus" />
								<img class="imgIn" src="<?= $pos['icon'];?>" />
							</a>
						</div>
					<?php } ?>
						
					
				</div>
			</div>
		<div class="row">
			<aside class="col-md-9">
				{{$flower_details->description}}
			</aside>
			<aside class="col-md-3">
				<h2 class="title blue">Tier</h2>
				<ul>
					<li><img src="{{ asset('public/frontend/img/pos1.png') }}" alt="Loadus" />8 Fire positions</li>
					<li><img src="{{ asset('public/frontend/img/pos2.png') }}" alt="Loadus" />4 Air positions</li>
					<li><img src="{{ asset('public/frontend/img/pos3.png') }}" alt="Loadus" />2 Earth positions</li>
					<li><img src="{{ asset('public/frontend/img/pos4.png') }}" alt="Loadus" />1 Water position</li>
				</ul>
			</aside>
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
								
								<div class="col-md-12 form-group pb-2">
									<input class="form-control" id="userSelect123" name="email" placeholder="User Email" type="text"  />
									<div class="brd">&nbsp;</div>
								</div>

								<div class="row">
									<div class="col-md-6 form-group pb-2">
										<!-- <select class="form-control" id="userSelect" name="userSelect">
											<option data-display="Select User" selected disabled> Select Tier </option>
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
			var flower_name = '<?= $flower_details->name;?>';
			$('#invite_flower_id').val(id);
			$('#invite_flower_name').val(flower_name);

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
	                 		window.location.href = "{{url('flower-details')}}/<?= Crypt::encryptString($flower_details->group_id);?>";
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
	                 		window.location.href = "{{url('flower-details')}}/<?= Crypt::encryptString($flower_details->group_id);?>";
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