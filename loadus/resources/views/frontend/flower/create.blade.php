@extends('layouts.base')
@section('title')
LOADUS
@endsection

@section('content')

	<section class="dashbaord p-0">
		<button class="menu-btn"><img src="{{asset('public/frontend/img/menu.png')}}"></button>
		<div class="container">
			<div class="row d-flex align-items-stretch">
				@include('layouts.left_sidebar')
				
				<div class="col-md-12 col-lg-9">
				  	<div class="dshContent">
						<h2 class="title blue"><?= isset($flower_details->id) ? "Edit Flower" : "Create Flower";?></h2>
						<hr>
						<div class="row">
					  		<div class="col-md-12">
								<div class="loginForm p-0 pt-3 profile ">
						  			<form id="flowerForm" method="post" class="form" role="form">
										<div class="row">
							  				<div class="col-md-10 form-group pb-4">
							  					<input type="hidden" name="_token" value="{{ csrf_token() }}"   />
							  					<?php if(isset($flower_details->id)){?>  
								              		<input type="hidden" name="old_group_image" value="{{ $flower_details->image }}"   />
								              		<input type="hidden" id="id" name="id" value="{{ $flower_details->id }}"   />
									            <?php } ?>
												<input class="form-control" id="name" name="name" placeholder="Flower Name" type="text" value="<?= isset($flower_details->name) ? $flower_details->name : '';?>" />
												<div class="brd">&nbsp;</div>
							  				</div>
							  				<div class="col-md-10 form-group pb-4">
												<textarea class="form-control" placeholder="Add Description" name="description"><?= isset($flower_details->description) ? $flower_details->description : '';?></textarea>
												<div class="brd">&nbsp;</div>
							  				</div>
										</div>
										<div class="row">
							  				<div class="col-md-10 form-group pb-4">
												<div class="upload-btn-wrapper">
								  					<button class="btn">Upload Photo</button>
								  					<input type="file" name="flower_image" />
												</div>
												<div class="brd">&nbsp;</div>
							  				</div>
										</div>
										<div class="row">
							  				<div class="col-md-10 form-group pb-4">
												<select class="form-control" name="parent_id">
													<option data-display="Select Group" selected disabled> Select Group </option>
													<?php foreach($user_flowers as $flowers){?>
														<option value="<?= $flowers->id;?>" ><?= $flowers->name;?></option>
													<?php } ?>
								  				</select>
												<div class="brd">&nbsp;</div>
							  				</div>
										</div>
										<div class="row">
											<p class="col-md-12 stePrice">Set Price in $</p>
											<?php if(isset($flower_details->groupflowertiers) && !empty(isset($flower_details->groupflowertiers))){

												foreach ($flower_details->groupflowertiers as $tiers) {
											?>
												<div class="col-md-4 form-group pb-4">
								  					<input class="form-control" id="tier<?=$tiers->tier?>" name="tier<?=$tiers->tier?>" placeholder="Tier <?=$tiers->tier?>" type="number" min="0" value="<?=$tiers->price?>" />
													<div class="brd">&nbsp;</div>
								  				</div>
											<?php }}else{
												for($i = 1; $i <= config('constants.total_tiers'); $i++){?>

												<div class="col-md-4 form-group pb-4">
													<input class="form-control" id="tier<?=$i?>" name="tier<?=$i?>" placeholder="Tier <?=$i?>" type="number" min="0" />
													<div class="brd">&nbsp;</div>
												</div>
												
								  				<!-- <div class="col-md-4 form-group pb-4">
								  					<input class="form-control" id="tier1" name="tier1" placeholder="Tier 1 (Earth)" type="number" min="0" />
													<div class="brd">&nbsp;</div>
								  				</div> -->
								  				<!-- <div class="col-md-4 form-group pb-4">
								  					<input class="form-control" id="tier2" name="tier2" placeholder="Tier 2 (Air)" type="number" min="0" />
								  					<div class="brd">&nbsp;</div>
								  				</div>
								  				<div class="col-md-4 form-group pb-4">
								  					<input class="form-control" id="tier3" name="tier3" placeholder="Tier 3 (Fire)" type="number" min="0" />
													<div class="brd">&nbsp;</div>
								  				</div>-->
								  			<?php }} ?>
										</div>
							  			<div class="row">
											<div class="col-md-12">
												<div class="totalMember">
													<h4>Total Member</h4>
													<ul>
														<li>07 Member</li>
													</ul>
												</div>
												<div class="totalMember">
													<h4>Open Possition</h4>
													<ul>
														<li>Tier 1 (Earth) - 01</li>
														<li>Tier 2 (Air) - 03</li>
														<li>Tier 3 (Fire) - 04</li>
														<!-- <li><a href="#" data-toggle="modal" data-target="#mod1">+ Add Member</a></li> -->
													</ul>
												</div>
											</div>
											<div class="brd">&nbsp;</div>
							  			</div>
							  			<div class="row">
											<div class="col-md-10 form-group pb-4">
												<label class="select-opt d-inline pull-left mr-5 check">Public
													<input type="radio" <?= (isset($flower_details->privacy) && $flower_details->privacy == 0) ? "" : "checked" ?> name="privacy" value="1">
													<span class="checkmark"></span>
												</label>
												<label class="select-opt d-inline pull-left check">Private
													<input type="radio" name="privacy" value="0" <?= (isset($flower_details->privacy) && $flower_details->privacy == 0) ? "checked" : "" ?>>
													<span class="checkmark"></span>
												</label>
											</div>
										</div>

										<div class="row passwordDiv" style="<?= (isset($flower_details->privacy) && $flower_details->privacy == 0) ? "" : "display: none" ?>">
					                      	<div class="col-md-10 form-group pb-4">
					                        	<input class="form-control" id="password" name="password" placeholder="Password" type="text" value="<?= isset($flower_details->password) ? $flower_details->password : '';?>" />
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
		$('#flowerForm').validate({
         	rules: {
	           "name": {required: true},
	           "tier1": {required: true},
	        //    "tier2": {required: true},
	        //    "tier3": {required: true},
	           "flower_image": {required: <?= isset($flower_details->id) ? 'false' : 'true'?>},
			   "parent_id": {required: true},
         	},
    		messages:{
	            "name":{required: "Please enter flower name"},
	            "tier1":{required: "Please enter Tier 1 (Earth) Price"},
	            // "tier2":{required: "Please enter Tier 2 (Air) Price"},
	            // "tier3":{required: "Please enter Tier 3 (Fire) Price"},
	            "parent_id":{required: "Please select a group or join a group"},
				"group_image":{required: "Please upload flower Image"},
            },

         	submitHandler: function(){

	           	$.ajax({
		         	url:'<?php echo action('FlowerController@store') ?>',
		            type:"POST",
		            data: new FormData($('#flowerForm')[0]),
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
	});

</script>
@endsection