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
									<h2 class="title blue">Joined Flowers</h2>
								</div>
							</aside>
						</div>
						<div class="row groups-item joined-flower">
						<!--  item group 1 -->
							<?php foreach ($joined_flowers as $joinedFlowers) {
								// dd($joinedFlowers->name);

								foreach($total_positions as $positions){
									if($positions->id == 2){
										$earth = $positions->total_positions - $joinedFlowers->earth_members;
									}else if($positions->id == 3){
										$air = $positions->total_positions - $joinedFlowers->air_members;
									}else if($positions->id == 4){
										$fire = $positions->total_positions - $joinedFlowers->fire_members;
									}
								}

								if(!empty($joinedFlowers->image)){
									$flower_image = asset('public/uploads/flower').'/'.$joinedFlowers->image;
								}else{
									$flower_image = asset('public/uploads/users').'/user_profile.jpg';
								} 

								if(!empty($joinedFlowers->position_id == 2)){
									$icon_image = asset('public/frontend/img/earth.png');
								}else if(!empty($joinedFlowers->position_id == 3)){
									$icon_image = asset('public/frontend/img/air-icon.png');
								}else if(!empty($joinedFlowers->position_id == 4)){
									$icon_image = asset('public/frontend/img/fire-icon.png');
								}
							?>

								<div class="col-sm-6 col-md-6 col-lg-4 joinedFlowers">
									<div class="wrap-shadow">
										<div class="group-img">
										<a href="flower-details/<?= Crypt::encryptString($joinedFlowers->group_flower_id) ?>"><img src="<?= $flower_image; ?>" alt="" /></a>
										</div>
										<div class="group-content">
											<h4><?= $joinedFlowers->name;?></h4>
											<!-- <p class="id-blue">Business Week (Group id 59875874)</p> -->
											<a href="" class="iocn-round bg-white"><img src="<?= $icon_image;?>" alt="icon"></a>
										</div>
										<div class="d-flex flex-row-reverse join-btn clearfix">
											<div class="col-auto p-0 box-half">
												<!-- <a class="btn" href="">invite user</a> -->
											</div>
											<div class="col box-half pl-0 pr-2 text-left">
												<div class="txt-mdm">Open Positions</div><div class="txt-rgl"><?= ($fire > 0 ) ? $fire." Fire," : '';?> <?= ($air > 0 ) ? $air." Air," : '';?> <?= ($earth > 0 ) ? $earth." Earth" : '';?></div>
											</div>
										</div>
									</div>
									<div class="text-right ot-option">
										<!-- <a href="">Leave Flower</a> -->
										<a href="javascript:void(0)" data-delete="<?= Crypt::encryptString($joinedFlowers->group_flower_id);?>" class="leave_flower">Leave Flower</a>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
	      	</div>
	    </div>
  	</section>

	<script>
		$(document).ready(function(){

			$("body").on('click', '.leave_flower', function(){

				var id = $(this).data('delete');
				var parentDiv = $(this).parents('.joinedFlowers')

				$.ajax({
					url:'<?php echo action('FlowerController@leaveFlower') ?>',
					type:"post",
					data: {"_token": "{{ csrf_token() }}","id":id},
					dataType:'json',
					beforeSend:function(){
						return confirm("Are you sure you wanted to leave this flower ?");    
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