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
									<h2 class="title blue">Joined Groups</h2>
								</div>
							</aside>
						</div>
						<div class="row groups-item joined-flower">
						<!--  item group 1 -->
							<?php foreach ($joined_groups as $joinedGroups) {
								if(!empty($joinedGroups->image)){
									$group_image = asset('public/uploads/group').'/'.$joinedGroups->image;
								}else{
									$group_image = asset('public/uploads/users').'/user_profile.jpg';
								} 
							?>
								<div class="col-sm-6 col-md-6 col-lg-4 joinedGroups">
									<div class="wrap-shadow">
										<div class="group-img">
											<!-- <img src="<?= $group_image; ?>" alt="" /> -->
											<a href="group-details/<?= Crypt::encryptString($joinedGroups->group_flower_id) ?>"><img src="<?= $group_image; ?>" alt="" /></a>
										</div>
										<div class="group-content">
											<h4><?= $joinedGroups->name;?></h4>
										</div>
										<div class="d-flex flex-row-reverse join-btn clearfix">
											<div class="col box-half p-0 text-right">
												<div><span><?= $joinedGroups->total_group_flowers;?> Flowers</span> &#124; <span><?= $joinedGroups->total_group_members;?> Members</span></div>
											</div>
										</div>
									</div>
									<div class="text-right ot-option">
										<a href="javascript:void(0)" data-delete="<?= Crypt::encryptString($joinedGroups->group_flower_id);?>" class="leave_group">Leave group</a>
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

			$("body").on('click', '.leave_group', function(){

				var id = $(this).data('delete');
				var parentDiv = $(this).parents('.joinedGroups')

				$.ajax({
					url:'<?php echo action('GroupController@leaveGroup') ?>',
					type:"post",
					data: {"_token": "{{ csrf_token() }}","id":id},
					dataType:'json',
					beforeSend:function(){
						return confirm("Are you sure you wanted to leave this group ?");    
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