<div class="col-lg-auto pl-0">
    <!-- aside menu -->
    <div class="sideMenu left-grey">
        <nav class="pushy pushy-left" data-focus="#first-link">
            <div class="pushy-content">
                <ul>
                    <!-- <li class="pushy-submenu">
                    <button id="first-link">Profile</button>
                            <ul>
                                    <li class=""><a href="#">Item 1</a></li>
                                    <li class=""><a href="#">Item 2</a></li>
                                    <li class=""><a href="#">Item 3</a></li>
                            </ul>
                    </li> -->
                    <li class="pushy-link"><a href="<?php echo e(url('dashboard')); ?>">Profile</a></li>
                    <!-- <li class="pushy-submenu">
                        <button id="">My groups</button>
                        <ul>
                            <li class="">
                                
                                <?php echo e(link_to_action('GroupController@group_pool','Group Pool')); ?> 
                            </li>

                            <li class="">
                                
                                <?php echo e(link_to_action('GroupController@joined_groups','Joined groups')); ?> 
                            </li>


                            <li class="">
                               

                                <?php echo e(link_to_action('GroupController@created_groups','created groups')); ?> 

                            </li>

                            <li class="">
                                
                                <?php echo e(link_to_action('GroupController@getGroupJoinRequests','Group Join Requests')); ?> 
                            </li>


                        </ul>
                    </li>
                    <li class="pushy-submenu">
                        <button id="">My flowers</button>
                        <ul>


                            <li class="">
                                
                                <?php echo e(link_to_action('FlowerController@joined_flowers','Joined flowers')); ?> 
                            </li>
                            <li class="">
                               
                                <?php echo e(link_to_action('FlowerController@created_flowers','My Campaigns')); ?> 
                            </li>

                            <li class="">
                                
                                <?php echo e(link_to_action('FlowerController@getFlowerJoinRequests','Flower Join Requests')); ?> 
                            </li>
                            
                            <li class="">
                                
                                <?php echo e(link_to_action('FlowerSubscriptionController@FlowerSubsList','Flower Subscription Plan')); ?> 
                            </li>
                        </ul>
                    </li>

                    <li class="pushy-link">
                        <?php echo e(link_to_action('MessageController@messages','Message')); ?> 
                        
                    </li> -->
                    <!--<li class="pushy-link"><a href="#subscription.html">Subcriptions</a></li>-->
                    <li class="pushy-link">
                        <?php echo e(link_to_action('SubscriptionController@my_subscription','Subscription')); ?> 
                    </li>

                    <li class="pushy-link">
                        <?php echo e(link_to_action('NotificationController@index','Notifications')); ?> 
                        <!-- <a href="#notifications.html">Notifications</a> -->
                    </li>
                    <li class="pushy-link"><a href="<?php echo e(url('add-business')); ?>">Add Buisness</a></li>
                    <?php if (\Auth::guard('user')->check()) { ?>
                        <li class="pushy-link"><a href="<?php echo e(url('userLogout')); ?>">Logout</a></li>
                        <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
</div>
<?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/layouts/left_sidebar.blade.php ENDPATH**/ ?>