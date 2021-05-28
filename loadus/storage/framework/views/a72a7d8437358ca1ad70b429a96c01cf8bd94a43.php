<?php
$controller = class_basename(Route::current()->controller);
$currentAction = \Route::getCurrentRoute()->getActionName();
list($controller, $action) = explode('@', $currentAction);
$controller = preg_replace('/.*\\\/', '', $controller);
// dd($controller);die;
// dd($action);die;
?>






<!-- ======================= Header Section ======================= -->
<header class="">
	<section class="header">
		<div class="container">
			<div class="menuTop">
				<div class="logo"><a href="<?php echo e(url('home')); ?>">
					<img src="<?php echo e(asset('public/frontend/img/logo.png')); ?>" alt="logo"></a>
				</div>
				<input type="checkbox" id="menuIcon">
				<label for="menuIcon" class="fas fa-bars"></label>
				<div class="navi">
					<ul>
						<li><a href="<?php echo e(url('home')); ?>" class="<?php echo ($controller == 'UserController' && $action == 'home') ? 'active' : ''; ?>">Home</a></li>
						<li><a href="#">About Loadus</a></li>
						<li><a href="<?php echo e(url('loadus-business')); ?>" class="<?php echo ($controller == 'UserController' && $action == 'loadus_business') ? 'active' : ''; ?>">Loadus Business</a></li>
						<li><a href="<?php echo e(url('loadus-library')); ?>" class="<?php echo ($controller == 'UserController' && $action == 'loadus_library') ? 'active' : ''; ?>">Loadus Library</a></li>
						<?php if (\Auth::guard('user')->check()) { ?>
                                                        
                                <?php } else { ?>
                                    <li><a href="<?php echo e(url('login')); ?>" class="<?php echo ($controller == 'UserController' && $action == 'login') ? 'active' : ''; ?>">Login</a></li>
                                    <li><a href="<?php echo e(url('signup')); ?>" class="<?php echo ($controller == 'UserController' && $action == 'signup') ? 'active' : ''; ?>">Sign Up</a></li>
                                <?php } ?>
						<li><a class="searchbtn" href="#"><i class="fas fa-search"></i></a></li>
					</ul>
					<?php if (\Auth::guard('user')->check()) { ?>
                    <div class="col-lg-auto p-0">
                        <div class="account-setting pl-5 pl-sm-2">							
                            <button data-target="#" data-toggle="dropdown" class="dropdown-toggle hidden-md-down p-0" aria-haspopup="true" aria-expanded="false"><span class="expand-more">Welcome <?php echo ucfirst(Auth::guard('user')->user()->first_name); ?></span><i class="fa fa-chevron-down" aria-hidden="true"></i></button><button data-target="#" data-toggle="dropdown" class=" btn-unstyle hidden-lg-up p-0" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i></button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <ul>
                                    <li>
                                        <a href="<?php echo e(url('dashboard')); ?>" class="dropdown-item">My Account</a>
                                    </li>
                                    <!-- <li>
                                        <?php echo link_to_action('FlowerController@joined_flowers','Joined flowers',[],["class"=>"dropdown-item"]); ?> 
                                    </li>
                                    <li>
                                        <?php echo e(link_to_action('FlowerController@getFlowerJoinRequests','Flower Join Requests',[],["class"=>"dropdown-item"])); ?> 
                                    </li> -->
                                    <li>
                                        <?php echo e(link_to_action('NotificationController@index','Notifications',[],["class"=>"dropdown-item"])); ?> 
                                        <!-- <a href="" class="dropdown-item" >Notifications</a> -->
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('userLogout')); ?>" title="" class="dropdown-item"><span>Sign out</span></a>
                                    </li>
                                </ul>
                            </div>
                            <?php 
                            $loggedInUser = Auth::guard('user')->user()->id;
                            $notificationCount = getTopNotifications($loggedInUser);
                            if($notificationCount['unreadNotification'] > 0){
                            ?>
                                <span class="requested"><?= $notificationCount['unreadNotification']?></span>
                            <?php } ?>
                        </div>
                        <!--device nav icon-->
                        <div class="wsmobileheader clearfix">
                            <a id="wsnavtoggle" class="animated-arrow"><span></span></a>
                        </div>
                    </div>
                <?php } ?>
				</div>
			</div>
			
		</div>
	</section>
</header>
<!-- ======================= Header Section Exit ======================= --><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/layouts/sahil-header.blade.php ENDPATH**/ ?>