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
                    <li class="pushy-link"><a href="{{ url('dashboard') }}">Profile</a></li>
                    <!-- <li class="pushy-submenu">
                        <button id="">My groups</button>
                        <ul>
                            <li class="">
                                
                                {{ link_to_action('GroupController@group_pool','Group Pool') }} 
                            </li>

                            <li class="">
                                
                                {{ link_to_action('GroupController@joined_groups','Joined groups') }} 
                            </li>


                            <li class="">
                               

                                {{ link_to_action('GroupController@created_groups','created groups') }} 

                            </li>

                            <li class="">
                                
                                {{ link_to_action('GroupController@getGroupJoinRequests','Group Join Requests') }} 
                            </li>


                        </ul>
                    </li>
                    <li class="pushy-submenu">
                        <button id="">My flowers</button>
                        <ul>


                            <li class="">
                                
                                {{ link_to_action('FlowerController@joined_flowers','Joined flowers') }} 
                            </li>
                            <li class="">
                               
                                {{ link_to_action('FlowerController@created_flowers','My Campaigns') }} 
                            </li>

                            <li class="">
                                
                                {{ link_to_action('FlowerController@getFlowerJoinRequests','Flower Join Requests') }} 
                            </li>
                            
                            <li class="">
                                
                                {{ link_to_action('FlowerSubscriptionController@FlowerSubsList','Flower Subscription Plan') }} 
                            </li>
                        </ul>
                    </li>

                    <li class="pushy-link">
                        {{ link_to_action('MessageController@messages','Message') }} 
                        
                    </li> -->
                    <!--<li class="pushy-link"><a href="#subscription.html">Subcriptions</a></li>-->
                    <li class="pushy-link">
                        {{ link_to_action('SubscriptionController@my_subscription','Subscription') }} 
                    </li>

                    <li class="pushy-link">
                        {{ link_to_action('NotificationController@index','Notifications') }} 
                        <!-- <a href="#notifications.html">Notifications</a> -->
                    </li>
                    <li class="pushy-link"><a href="{{ url('add-business') }}">Add Buisness</a></li>
                    <?php if (\Auth::guard('user')->check()) { ?>
                        <li class="pushy-link"><a href="{{ url('userLogout') }}">Logout</a></li>
                        <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
</div>
