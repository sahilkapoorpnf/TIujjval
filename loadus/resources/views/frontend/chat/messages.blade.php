@extends('layouts.base')
@section('title')
LOADUS
@endsection

@section('content')
<?php
use App\User;
	
?>
	<section class="dashbaord p-0">
		<button class="menu-btn"><img src="{{asset('public/frontend/img/menu.png')}}"></button>
		<div class="container">
			<div class="row">
				@include('layouts.left_sidebar')
				
				<div class="col-md-12 col-lg-9">
					<div class="dshContent">
						<h2 class="title blue">Messages</h2>
						<div class="formContainer">
							<ul class="msgList">
								<?php 
									foreach ($messages as $msg) {
										$other_user_id = ($msg['sender_id'] == $logged_in_user) ? $msg['reciver_id'] : $msg['sender_id'];
										$other_user_details = User::where(array('id'=>$other_user_id))->first();

										if(!empty($other_user_details->user_image)){
											$user_image = asset('public/uploads/users').'/'.$other_user_details['user_image'];
										}else{
											$user_image = asset('public/uploads/users').'/user_profile.jpg';
										} 
								?>
								<li class="row d-flex justify-content-between align-items-center">
									<div class="col-md-9 col msgDetail">
										<div class="d-md-flex align-items-md-center">
											<?php 
												$chatLink = url('chatHistory').'/'.$msg['messageuser_group']['id']."?uId=".$other_user_id;
											?>
											<a href="<?= $chatLink?>"><figure><img src="{{$user_image}}"></figure></a>
											<div class="nameDetail">
												<h4><?= $other_user_details->first_name?> </h4>
												<p><?= $msg['last_message']?></p>
											</div>
										</div>
									</div>
									<div class="col-md-3 col application">
										<a href="#">Group ID</a>
										<span><?= $msg['messageuser_group']['id']?></span>
									</div>
								</li>
								<?php 
									}
								?>
							</ul>
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