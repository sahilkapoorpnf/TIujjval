<?php

Route::get('locale/{language}', function ($locale) {
    Session::put('language', $locale);
    return redirect()->back();
});


// Route::group(['prefix' => 'admin'], function() {
//     Auth::routes();
// });
// Cache clear route
Route::get(
    'cache-clear',
    function () {
        \Artisan::call('config:cache');
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        return redirect()->back();
    }
);
// Home

Route::get('/admin', 'AdminController@login');
Route::post('login_req','AdminController@login_req');
Route::post('/mycapcha', 'Auth\LoginController@refereshcapcha');
Route::prefix('admin')->group(function() {

    Route::post('/logout', 'AdminController@logout');
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/my404', 'HomeController@my404');
    Route::post('/adminchat', 'HomeController@chat');
    Route::post('/ajaxfile', 'HomeController@imguploadpost');


    //User Route


    /** Working  ***/
    Route::get('/user', 'AdminUserController@index');
    Route::post('/userdata','AdminUserController@userlist');//start
    Route::get('/user/create', 'AdminUserController@create');
    Route::post('/user/store', 'AdminUserController@store');
    Route::post('/user/update/{id}', 'AdminUserController@update');
    Route::get('/user/edit/{id}', 'AdminUserController@edit')->name('edit-user');
    Route::get('/user/view/{id}', 'AdminUserController@view');
    Route::post('/user/deleteuser', 'AdminUserController@destroy');
    Route::post('/user/statusChange', 'AdminUserController@statusChange');
    Route::post('/user/uploadUserCsv', 'AdminUserController@uploadUserCsv');

    //Page Route 
    Route::get('/page', 'PageController@index');
    Route::post('/getpagedata', 'PageController@datalist');
    Route::get('/page/create', 'PageController@create');
    Route::post('/page/store', 'PageController@store');
    Route::get('/page/edit/{id}', 'PageController@edit');
    Route::get('/page/view/{id}', 'PageController@view');
    Route::post('/page/update/{id}', 'PageController@update');
    Route::post('/deletepage', 'PageController@destroy');
    Route::get('/page/mail', 'PageController@email');
    Route::post('/page/uploadimg', 'PageController@uploadfile');

    //Social Media Controller 
    Route::get('/social', 'SocialController@index');
    Route::post('/socialdata', 'SocialController@sociallist');
    Route::get('/social/create', 'SocialController@create');
    Route::post('/social/store', 'SocialController@store');
    Route::get('/social/edit/{id}', 'SocialController@edit');
    Route::post('/social/update/{id}', 'SocialController@update');
    Route::post('/social/delete', 'SocialController@destroy');

    //ProfileController    
    Route::get('/profile', 'ProfileController@index');
    Route::post('/profile/update', 'ProfileController@update');
    Route::any('/profile/passchange', 'ProfileController@passchange');

    //Setting Controller 
    Route::get('/setting', 'SettingController@index');
    Route::post('/settingdata', 'SettingController@settinglist');
    Route::get('/setting/edit/{id}', 'SettingController@edit');
    Route::post('/setting/update/{id}', 'SettingController@update');

    //Group Controller
    Route::get('/group', 'AdminGroupController@index');
    Route::post('/getgroupdata','AdminGroupController@getgroupdata');
    Route::post('/group/getuserdata','AdminGroupController@getuserdata');
    Route::get('/group/create','AdminGroupController@create');
    Route::post('/group/store','AdminGroupController@store');
    Route::get('/group/view/{id}', 'AdminGroupController@view');
    Route::post('/group/deletegroup', 'AdminGroupController@destroy');
    Route::post('/group/removeMember', 'AdminGroupController@removeMember');
    Route::get('/group/edit/{id}', 'AdminGroupController@edit');
    Route::get('/group/addMembers/{id}', 'AdminGroupController@addMembers');
    Route::post('/group/update', 'AdminGroupController@update');
    Route::post('/group/addgroupmember', 'AdminGroupController@addgroupmember');
    Route::post('/group/featured', 'AdminGroupController@featured');
    Route::post('/group/groupMembers', 'AdminGroupController@groupMembers');
    Route::post('/group/uploadGroupCsv', 'AdminGroupController@uploadGroupCsv');


    //Group Controller
    Route::get('/flower', 'AdminFlowerController@index');
    Route::post('/getflowerdata','AdminFlowerController@getflowerdata');
    Route::post('/flower/getuserdata','AdminFlowerController@getuserdata');
    Route::get('/flower/create','AdminFlowerController@create');
    Route::post('/flower/store','AdminFlowerController@store');
    Route::get('/flower/view/{id}', 'AdminFlowerController@view');
    Route::post('/flower/deletegroup', 'AdminFlowerController@destroy');
    Route::post('/flower/removeMember', 'AdminFlowerController@removeMember');
    Route::get('/flower/edit/{id}', 'AdminFlowerController@edit');
    Route::get('/flower/addMembers/{id}', 'AdminFlowerController@addMembers');
    Route::post('/flower/update', 'AdminFlowerController@update');
    Route::post('/flower/addgroupmember', 'AdminFlowerController@addgroupmember');
    Route::post('/flower/featured', 'AdminFlowerController@featured');
    Route::post('/flower/groupMembers', 'AdminFlowerController@groupMembers');
    Route::post('/flower/getGroups','AdminFlowerController@getGroups');
    Route::post('/flower/uploadFlowerCsv', 'AdminFlowerController@uploadFlowerCsv');
    Route::post('/flower/uploadFlowerMemberCsv', 'AdminFlowerController@uploadFlowerMemberCsv');



    //Faq Route 
    Route::get('/faq', 'FaqController@index');
    Route::post('/getfaqdata', 'FaqController@datalist');
    Route::get('/faq/create', 'FaqController@create');
    Route::post('/faq/store', 'FaqController@store');
    Route::get('/faq/edit/{id}', 'FaqController@edit');
    Route::get('/faq/view/{id}', 'FaqController@view');
    Route::post('/faq/update/{id}', 'FaqController@update');
    Route::post('/deletefaq', 'FaqController@destroy');
    Route::post('/faq/uploadimg', 'FaqController@uploadfile');

    /************ Working End            *****/
    
    //Subscription Route 
    Route::get('/subscription', 'SubscriptionController@index');
    Route::post('/getsubsdata', 'SubscriptionController@datalist');
    Route::get('/subscription/create', 'SubscriptionController@create');
    Route::post('/subscription/store', 'SubscriptionController@store');
    Route::get('/subscription/edit/{id}', 'SubscriptionController@edit');
    Route::get('/subscription/view/{id}', 'SubscriptionController@view');
    Route::post('/subscription/update/{id}', 'SubscriptionController@update');
    Route::post('/deletesubs', 'SubscriptionController@destroy');
    Route::get('/user-subscription', 'SubscriptionController@userSubscription');
    Route::post('/getusersubs', 'SubscriptionController@user_subscription_datalist');
    Route::post('/buysubs', 'SubscriptionController@destroy');
    Route::get('/flowerSubs', 'FlowerSubscriptionController@index');
    Route::post('/getflowersubsdata', 'FlowerSubscriptionController@datalist');
    Route::get('/flowsubsedit/{id}', 'FlowerSubscriptionController@edit');
    Route::post('/flowsubsupdate/{id}', 'FlowerSubscriptionController@update');
    // Route::get('/flower-subscription','FlowerSubscriptionController@FlowerSubsList');
//    Route::post('/faq/uploadimg', 'FaqController@uploadfile');

    /************ Working End            *****/

//Banner Route 
    Route::get('/banner', 'BannerController@index');
    Route::post('/getBannerData', 'BannerController@datalist');
    //Route::get('/subscription/create', 'SubscriptionController@create');
    //Route::post('/subscription/store', 'SubscriptionController@store');
    Route::get('/banner/edit/{id}', 'BannerController@edit');
    //Route::get('/subscription/view/{id}', 'SubscriptionController@view');
    Route::post('/banner/update/{id}', 'BannerController@update');
    //Route::post('/deletesubs', 'SubscriptionController@destroy');

    
    // Message Route added by Shiv
    Route::get('/message', 'MessageController@index');
    Route::post('/getmessagedata', 'MessageController@datalist');
    Route::get('/message/edit/{id}', 'MessageController@edit');
    Route::post('/message/update/{id}', 'MessageController@update');
    Route::post('/deletemessage', 'MessageController@destroy');


    //Form Builder Controller 
    Route::get('/formbuilder', 'FormbuilderController@index');
    Route::post('/formbuilder/save', 'FormbuilderController@store');
    Route::get('/formbuildertwo', 'FormbuildertwoController@index');
    Route::post('/formbuildertwo/save', 'FormbuildertwoController@store');

    

    //Slider Controller 
    Route::get('/slider', 'SliderController@index');
    Route::post('/sliderdata', 'SliderController@sliderlist');
    Route::get('/slider/create', 'SliderController@create');
    Route::post('/slider/store', 'SliderController@store');
    Route::post('/slider/deleteslider', 'SliderController@destroy');
    Route::get('/slider/edit/{id}', 'SliderController@edit');
    Route::post('/slider/update/{id}', 'SliderController@update');



    // Mailtemplate Status Controller 
    Route::get('/mailtemplate', 'MailtemplateController@index');
    Route::post('/mailtemplatedata', 'MailtemplateController@templatelist');
    Route::get('/mailtemplate/create', 'MailtemplateController@create');
    Route::post('/mailtemplate/store', 'MailtemplateController@store');
    Route::post('/mailtemplate/deletemailtemplate', 'MailtemplateController@destroy');
    Route::get('/mailtemplate/edit/{id}', 'MailtemplateController@edit');
    Route::post('/mailtemplate/update/{id}', 'MailtemplateController@update');


});


Route::get('/', 'UserController@home')->name('home');
Route::get('/home', 'UserController@home')->name('home');
Route::any('/contact-us', 'UserController@contact_us')->name('contact-us');
Route::any('/about-us', 'UserController@about_us')->name('about-us');
Route::any('/loadus-library', 'UserController@loadus_library')->name('loadus-library');
Route::any('/testimonials', 'UserController@testimonials')->name('testimonials');
Route::any('/how-it-works', 'UserController@howItWorks')->name('how-it-works');
Route::any('/terms-condition', 'UserController@termsAndCondition')->name('Terms-And-Condition');
Route::any('/privacy-policy', 'UserController@privacyPolicy')->name('privacy-policy');

Route::any('/loadus-business', 'UserController@loadus_business')->name('loadus-business');
Route::any('/loadus-categories', 'UserController@loadus_categories')->name('loadus-categories');
/***  --------------------Frontend ---------------------***/ 
Route::get('login','UserController@login')->name('login');
Route::post('userLogin','UserController@userLogin')->name('userLogin');
Route::get('userLogout','UserController@logout');

Route::get('signup','UserController@signup')->name('signup');
Route::get('forgot-password','UserController@forgot_password')->name('forgot-password');
Route::post('forgotPassword','UserController@forgotPassword')->name('forgotPassword');
Route::get('/reset-password/{token}/{email}', 'UserController@resetpassword');
Route::post('/update-password', 'UserController@updatepassword')->name('update-password');
// Route::get('/change_password', 'UserController@change_password')->name('change_password');
Route::get('/change-password', 'UserController@change_password')->name('change-password');
Route::post('/changePassword', 'UserController@change_password')->name('changePassword');
Route::get('dashboard','UserController@dashboard')->name('dashboard');
Route::get('add-business','UserController@add_business');
Route::post('add-business','UserController@add_business');
Route::get('home','UserController@home')->name('home');
Route::post('updateProfile','UserController@updateProfile');
Route::post('userSignup','UserController@userSignup')->name('userSignup');
Route::get('signup_mail_verification/{email}/{id}','UserController@signup_mail_verification');
Route::get('Faq','UserController@faq')->name('Faq');
Route::post('contactUs','UserController@contactUs')->name('contactUs');

Route::get('chatHistory/{id}', 'MessageController@chatHistory');
Route::post('postMessage', 'MessageController@postMessage');
Route::get('messages', 'MessageController@messages');

Route::get('create-group','GroupController@create')->name('create-group');
Route::get('edit-group/{id}', 'GroupController@edit');
Route::get('created-groups','GroupController@created_groups')->name('created-groups');
Route::get('joined-groups','GroupController@joined_groups')->name('joined-groups');
Route::post('store-group','GroupController@store')->name('store-group');
// Route::get('accept-group-member-request/{id}','GroupController@acceptGroupMember')->name('accept-group-member-request');
Route::get('reject-group-member-request/{id}','GroupController@rejectGroupMember')->name('accept-group-member-request');
Route::get('group-pool','GroupController@group_pool')->name('group-pool');
Route::get('group-details/{id}','GroupController@details');

Route::post('delete-group', 'GroupController@destroy');
Route::post('leave-group', 'GroupController@leaveGroup');

Route::post('delete-flower', 'FlowerController@destroy');
Route::post('leave-flower', 'FlowerController@leaveFlower');


Route::get('create-flower','FlowerController@create')->name('create-flower');
Route::post('store','FlowerController@store')->name('store');
Route::get('edit-flower/{id}', 'FlowerController@edit');
Route::get('created-flowers', 'FlowerController@created_flowers')->name('created-flowers');
Route::get('joined-flowers', 'FlowerController@joined_flowers')->name('joined-flowers');
Route::get('flower-details/{id}', 'FlowerController@details');


Route::get('flower-pool','FlowerController@flower_pool')->name('flower-pool');

Route::post('flower-positions', 'GroupController@getflowerpositions');

Route::post('get-user-details', 'GroupController@getUserDetails');
Route::post('flower-user-members', 'GroupController@getInvitableFlowerMembers');
Route::post('group-user-members', 'GroupController@getInvitableGroupMembers');


Route::post('flower-join-request', 'GroupController@flower_join_request');
Route::post('flower-invite-request', 'GroupController@flower_invite_request');

Route::post('group-invite-request', 'GroupController@group_invitation');
Route::post('group-join-request', 'GroupController@group_join_request');

Route::post('group-join-cancel-request', 'GroupController@group_join_cancel_request');
Route::post('flower-join-cancel-request', 'FlowerController@flower_join_cancel_request');

Route::post('accept-group-member-request','GroupController@acceptGroupMember')->name('accept-group-member-request');
Route::post('accept-flower-member-request','FlowerController@acceptFlowerMember')->name('accept-flower-member-request');
Route::get('group-join-request-list', 'GroupController@getGroupJoinRequests');
Route::post('cancel-invite', 'GroupController@cancelInvite');
Route::post('reject-invite', 'GroupController@rejectInvite');
Route::post('reject-join', 'GroupController@rejectJoin');

Route::post('accept-invite', 'GroupController@acceptInvite');

Route::post('cancel-flower-invite', 'FlowerController@cancelInvite');
Route::post('reject-flower-invite', 'FlowerController@rejectInvite');
Route::post('accept-flower-invite', 'FlowerController@acceptInvite');
Route::post('reject-flower-join', 'FlowerController@rejectJoin');

Route::get('flower-join-request-list', 'FlowerController@getFlowerJoinRequests');




Route::get('Notifications', 'NotificationController@index');



#subscription route
Route::get('/my-subscription','SubscriptionController@my_subscription');
Route::get('/subscription_list','SubscriptionController@subscription_list');

#strip payment gateway
Route::get('stripe/{id}', 'StripePaymentController@stripe');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');

Route::get('/flower-subscription','FlowerSubscriptionController@FlowerSubsList');


Route::get('/stripeFlower', 'StripePaymentController@stripeFlower');
Route::post('flowerPayment', 'StripePaymentController@flowerPayment')->name('flowerPayment');

Route::post('check-user', 'GroupController@checkUser')->name('check-user');


Route::get('/admin/stripeinfo', 'StripePaymentController@index');
Route::post('/admin/getstripdata', 'StripePaymentController@datalist');
Route::get('/admin/stripedit/{id}', 'StripePaymentController@edit');
Route::post('/admin/strip/update/{id}', 'StripePaymentController@update');

Route::get('/admin/testimonials', 'TestimonialsController@index');
Route::post('/admin/getTestimonials', 'TestimonialsController@datalist');
Route::get('/admin/testimonials/create', 'TestimonialsController@create');
Route::post('/admin/testimonials/store', 'TestimonialsController@store');
Route::get('/admin/testimonials/edit/{id}', 'TestimonialsController@edit');
Route::post('/admin/testimonials/update/{id}', 'TestimonialsController@update');
Route::get('/admin/testimonials/view/{id}', 'TestimonialsController@view');
Route::post('/admin/deleteTestimonials', 'TestimonialsController@destroy');

Route::post('/admin/categories', 'CategoriesController@index');
Route::get('/admin/categories', 'CategoriesController@index');
Route::get('/admin/categories/add', 'CategoriesController@add');
Route::post('/admin/categories/add', 'CategoriesController@add');
Route::get('/admin/categories/delete/{id}', 'CategoriesController@delete');
Route::get('/admin/categories/edit/{id}', 'CategoriesController@edit');
Route::post('/admin/categories/edit/{id}', 'CategoriesController@edit');

Route::post('/admin/sub-categories/{id}', 'SubCategoriesController@index');
Route::get('/admin/sub-categories/{id}', 'SubCategoriesController@index');
Route::get('/admin/sub-categories/add/{id}', 'SubCategoriesController@add');
Route::post('/admin/sub-categories/add/{id}', 'SubCategoriesController@add');
Route::get('/admin/sub-categories/delete/{id}', 'SubCategoriesController@delete');
Route::get('/admin/sub-categories/edit/{id}', 'SubCategoriesController@edit');
Route::post('/admin/sub-categories/edit/{id}', 'SubCategoriesController@edit');
/***  --------------------Frontend END---------------------***/ 







