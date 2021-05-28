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
	// echo "<pre>";print_r($group_flower_details);die;
?>
<section class="dashbaord p-0">
		<button class="menu-btn"><img src="{{asset('public/frontend/img/menu.png')}}"></button>
		<div class="container">
			<div class="row">
				@include('layouts.left_sidebar')
				
				<div class="col-md-12 col-lg-9">
					<div class="dshContent pl-0 pr-0">
						<div class="formContainer p-0">
							<div class="userApp d-flex justify-content-between align-items-center">
								<div class="userImage">									
									<div class="d-flex align-items-center">

										<figure><img src="<?= $user_image?>"></figure>
										<div class="nameDetail" id="group_flower_id" data-id="<?= $group_flower_details['id']?>">
											<h5><?= !empty($group_flower_details) ? $group_flower_details['name'] : '';?></h5>
											<p><a href="" id="group_flower_user" data-id="<?= $receiverDetails->id;?>"><?= ($group_flower_details['type'] == 1) ? "Group ID" : "Flower ID"?></a> <?= !empty($group_flower_details) ? $group_flower_details['id'] : '';?></p>
										</div>
									</div>
								</div>
								<a href="" class="back">Back</a>
							</div>
							<div class="custom-bar" data-simplebar="init">
								<div class="chatList">
									<ul class="chatmessages">
										<?php  
											if(!empty($messages)){
												foreach ($messages as $message) {
													$id = $message['id'];
													$class = ($message['sender_id'] == $logged_in_user) ? 'customerChat' : 'plumberChat';
										?>
													<li class="<?= $class;?>">
														<?php if($message['sender_id'] != $logged_in_user){ 
														?>
														<figure><img src="<?= $user_image?>"></figure>
													<?php } ?>
														<p><span><?= $message[
															'message']?></span></p>
													</li>
										<?php 
												}	
											}
										?>
									</ul>
								</div>
							</div>
							<div class="chatBox">
								<input type="text" name="message" class="typeChat" placeholder="Type Message Here">
								<button type="submit" class="submitChat"><img src="{{asset('public/frontend/img//chatIcon.png')}}"></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>	
	<script type="text/javascript">
		$(document).ready(function (){
	        var messageId = "<?= !empty($id) ? $id : '' ?>";
	        var group_flower_id = $('#group_flower_id').data('id');
	        var group_flower_user = $('#group_flower_user').data('id');
			$('.submitChat').on('click', function() {
		        var input = $('.typeChat').val();
		        var message = input.trim();
		        if(message != ''){
		            var loaderid = customLoadingOnPlaceHolder('Message Sending', $('.typeChat'));
		            $('.typeChat').val('');
		            $.ajax({
		                type:'POST',
		                url:"{{url('postMessage')}}",
		                dataType: 'json',
		                data:{"_token": "{{ csrf_token() }}","group_flower_id": group_flower_id, "group_flower_user": group_flower_user, "message": message
						},
		                success:function(data){
		                    if(data.status===true){
		                        if(data.result.messageId > messageId){
		                            var list = '';
		                            messageId = data.result.messageId;
		                            
		                            list += (`<li class="customerChat">
		                                        <p><span>`+data.result.message+`<span></p>
		                                        </li>`);
		                            $('.chatmessages').append(list);

		                        }
		                    }
		                },
		                complete: function(){
		                    window.clearInterval(loaderid);
		                }
		            });
		        }
		        
		    });	
		    function customLoadingOnPlaceHolder(text, obj) {
	            var i = 0;
	            return window.setInterval(function() {
	                obj.attr( 'placeholder', (text+Array((++i % 6)+1).join(".")) );                
	            }, 500);
	        }
		});
	</script>

@endsection