<?php
$controller = class_basename(Route::current()->controller);
$currentAction = \Route::getCurrentRoute()->getActionName();
list($controller, $action) = explode('@', $currentAction);
$controller = preg_replace('/.*\\\/', '', $controller);
// dd($controller);die;
// dd($action);die;
?>
<header class="header sticky-header <?php echo ($controller == 'HomeController' && $action == 'index') ? '' : 'headerInn'; ?>">
    <div class="container">
        <div class="row d-flex justify-content-sm-between">
            <div class="col-6 col-sm-4 col-md-2 col-lg-2 col-xl-3">
                <div class="logo">
                    <a href="{{ url('home') }}" title=""><img src="{{asset('public/frontend/img/logo.png')}}" alt="Loadus" /></a>
                </div>
            </div>
            <div class="col-6 col-sm-8 col-md-10 col-lg-10 col-xl-9 d-sm-flex align-items-center justify-content-sm-end">
                <div class="col-auto p-0 justify-content-end">
                    <div class="menu sticky-menu">
                        <nav class="wsmenu clearfix">
                            <ul class="mobile-sub wsmenu-list">
                                <li><a href="{{ url('home') }}" class="<?php echo ($controller == 'UserController' && $action == 'home') ? 'active' : ''; ?>">Home</a></li>


                                <!-- <li><a href="{{ url('about-us') }}" class="<?php echo ($controller == 'UserController' && $action == 'about_us') ? 'active' : ''; ?>">About Loadus</a></li> -->
                                

                                <li><span class="wsmenu-click"><i class="wsmenu-arrow fa fa-angle-down"></i></span><a href="#">About Loadus</a>
                                    <ul class="wsmenu-submenu">
                                        <li><a href="{{ url('about-us') }}">About Loadus</a></li>
                                        <li><a href="{{ url('Faq') }}">Loadus FAQ</a></li>
                                        <li><a href="{{ url('how-it-works') }}">How It Works</a></li>
                                        <li><a href="{{ url('testimonials') }}">Loadus Testimonials</a></li>
                                    </ul>
                                </li>

                                <li><a href="{{ url('loadus-business') }}" class="<?php echo ($controller == 'UserController' && $action == 'loadus_business') ? 'active' : ''; ?>">Loadus Business</a>
                                </li>


                                <!-- <li><a href="{{ url('contact-us') }}" class="<?php echo ($controller == 'UserController' && $action == 'contact_us') ? 'active' : ''; ?>"> Contact Us</a></li> -->

                                <li><a href="{{ url('loadus-library') }}" class="<?php echo ($controller == 'UserController' && $action == 'loadus_library') ? 'active' : ''; ?>"> Loadus Library</a></li>

                                <?php if (\Auth::guard('user')->check()) { ?>
                                                        
                                <?php } else { ?>
                                    <li><a href="{{ url('login') }}" class="<?php echo ($controller == 'UserController' && $action == 'login') ? 'active' : ''; ?>">Login</a></li>
                                    <li><a href="{{ url('signup') }}" class="<?php echo ($controller == 'UserController' && $action == 'signup') ? 'active' : ''; ?>">Sign Up</a></li>
                                <?php } ?>
                            </ul>
                        </nav>
                    </div>
                </div>
                <?php if (\Auth::guard('user')->check()) { ?>
                    <div class="col-lg-auto p-0">
                        <div class="account-setting pl-5 pl-sm-2">							
                            <button data-target="#" data-toggle="dropdown" class="dropdown-toggle hidden-md-down p-0" aria-haspopup="true" aria-expanded="false"><span class="expand-more">Welcome <?php echo ucfirst(Auth::guard('user')->user()->first_name); ?></span><i class="fa fa-chevron-down" aria-hidden="true"></i></button><button data-target="#" data-toggle="dropdown" class=" btn-unstyle hidden-lg-up p-0" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i></button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <ul>
                                    <li>
                                        <a href="{{ url('dashboard') }}" class="dropdown-item">My Account</a>
                                    </li>
                                    <!-- <li>
                                        {!! link_to_action('FlowerController@joined_flowers','Joined flowers',[],["class"=>"dropdown-item"]) !!} 
                                    </li>
                                    <li>
                                        {{ link_to_action('FlowerController@getFlowerJoinRequests','Flower Join Requests',[],["class"=>"dropdown-item"]) }} 
                                    </li> -->
                                    <li>
                                        {{ link_to_action('NotificationController@index','Notifications',[],["class"=>"dropdown-item"]) }} 
                                        <!-- <a href="" class="dropdown-item" >Notifications</a> -->
                                    </li>
                                    <li>
                                        <a href="{{ url('userLogout') }}" title="" class="dropdown-item"><span>Sign out</span></a>
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
                <div class="col-auto p-0">
                    <!--Search icon-->
                    <div class="searchbox">
                        <a href="#" id="search-active" class="mobile-search text-white"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                    <!--device nav icon-->
                    <div class="wsmobileheader clearfix">
                        <a id="wsnavtoggle" class="animated-arrow"><span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
