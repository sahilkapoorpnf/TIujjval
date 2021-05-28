<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Mail;
// use App\Http\Controllers\Session;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Common;
use App\Faq;
use App\Page;
use App\Http\Models\Group;
use App\Banner;
use App\Testimonials;

class UserController extends Controller
{
    public function login(Request $request){
        $post=$request->all();
        // dd($post);
        $data = array(
            'authRedirect'=> !empty($post['authRedirect']) ? $post['authRedirect'] : '',
        );

        if( \Auth::guard('user')->check() ){
            return redirect('/');
        }

        return view('frontend.login')->with($data);
    }

    public function signup(){
        return view('frontend.signup');
    }

    public function forgot_password(){
        return view('frontend.forgot_password');
    }
    
    public function userLogin(Request $request){
        $post=$request->all();
        // dd($post);
        $validator = Validator::make($post, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $redirectUrl = !empty($post['authRedirect']) ? $post['authRedirect'] : 1;
        $authRedirect = '/dashboard';
        if(Auth::guard('user')->attempt(array('email' => $post['email'],'password'=>$post['password'], 'status' => 1, 'deleted_at'=>null))){
            switch ($redirectUrl) {
                case 'create-group':
                    $authRedirect = '/create-group';
                break;
                default:
                    $authRedirect = '/dashboard'; 
                break;
            }
            $arr = array('msg' => 'You are logged in Successfully!', 'status' => true, 'authRedirect'=>$authRedirect);
        }else{
            $arr = array('msg' => 'Invalid email address and password. Please try again!', 'status' => false);
        } 

        return response()->json($arr);
    }

    public function logout(Request $request) {
        if(Auth::guard('user')->check()) {
         //dd(\Auth::guard('user'));
    
          Auth::guard('user')->logout();
          //  $request->session()->invalidate();
        }
        return  redirect('/');
    }

    public function userSignup(Request $request){
       $post=$request->all();
       //dd($post);die;
       $email = $request->input('email');
        $data = [
            'first_name' =>  $post['first_name'],
            'last_name' =>   $post['last_name'],
            'phone' =>   $post['phone'],
            'email' => $post['email'],
            'password' => Hash::make($post['password']),
            'user_type' => 2,
            'status' => 1
            ];
        $email_exit = DB::table('users')->where('email', $email)->first();
        
        // print_r($userData);die;
        if(!empty($email_exit)){ 
            $arr = array('msg' => 'Email Address already exist. Please try with new Email Id!', 'status' => false);
            return Response()->json($arr);
        }else{

            $current_timestamp=time();
            $allowed_hours=2*3600;
            $total_expire_time=$current_timestamp+$allowed_hours;
            $encrypted=Crypt::encryptString($total_expire_time);
            $data['token']=$total_expire_time;
            $data['created_at']=date('Y-m-d H:i:s');
            // print_r($data);die;
            try{
                Mail::send('layouts.mailer.signup',['fname'=>$post["first_name"], 'token'=>$encrypted,'email'=>$email], function($message) use ($email) {
                    // echo "<pre>";print_r($message);die;
                 $message->to($email)->subject('Welcome on LOADUS');
        
               });
            }catch(\Exception $e){
                $message_err=$e->getMessage();
                // print_r($message_err);exit;
                $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
            }
            $arr = [];
            if(empty($arr)){
                $id = DB::table('users')->insertGetId($data);

                if($id){ 
                    $arr = array('msg' => 'You are registered Successfully! Check email for verification', 'status' => true);
                    Session::flash('message', 'You are registered Successfully! Check email for verification'); 
                    Session::flash('alert-class', 'alert-success'); 

                }else{
                    $arr = array('msg' => 'Something goes to wrong. Please try again later!', 'status' => false);
                }    
                
            }
            return Response()->json($arr);
        }
    }

    public function signup_mail_verification($email,$id){
        
        try{
            $decrypted = Crypt::decryptString($id);
        }catch(DecryptException $e){
            $decrypted="";
        }
            
        if(!empty($decrypted)){

            $current_timestamp=time();
            

            $user=DB::table('users')->select('id','token')->where('email', $email)->first();
            $user_token=$user->token;
            $id=$user->id;
            if($user_token==$decrypted){     
                $data = ['status' =>1];
                DB::table('users')
                    ->where('id', $id)
                    ->update($data);
                
                $status=1;        
                $message="Congratulations! You’re on Board!";
                Session::flash('message', 'Congratulations! You’re on Board!'); 
                Session::flash('alert-class', 'alert-success');

            
            }else{
                $status=0;

                $message="Your mail token missmatched! verify it again";
                Session::flash('message', 'Your mail token missmatched! verify it again'); 
                Session::flash('alert-class', 'alert-danger');
            }
         
        }else{
            Session::flash('message', 'Your clicking url is not valid! verify it again'); 
            Session::flash('alert-class', 'alert-danger');
            $message="Your clicking url is not valid! verify it again";
            $status=0;
        }
        return redirect('/');
    } 

    public function forgotPassword(Request $request){
        if ($request->isMethod('post')) {
            $common = new Common();


            $validator = Validator::make($request->all(), [
                        'email' => 'required|email',
            ]);

            if (!$validator->passes()) {
                return response()->json(['error' => $validator->errors()->all()]);
            }
            $model = [
                'remember_token' => hash('sha256', $common->randString(30)),
            ];
            $affected = User::where([['email', '=', $request->email]])->update($model);
            $user = User::where([['email', '=', $request->email]])->first();
            if ($user) {
                $email = $request->email;
                $Maildata = [
                    'first_name' => $user->first_name . '  ' . $user->last_name,
                    'email' => $request->email,
                    'link' => env('APP_URL'). 'reset-password/' . $user->remember_token . '/' . $request->email,
                ];

                // echo "<pre>";print_r($Maildata);die;

                Mail::send('layouts.mailer.forget_password',$Maildata, function($message) use ($email) {
                 $message->to($email)->subject('Forgot Password');
        
               });
                
                Session::flash('message', 'Password reset link sent to your email sucessfully!'); 
                Session::flash('alert-class', 'alert-success');
                return response()->json(['msg' => 'Password reset link sent to your email sucessfully!!.', 'status'=>true]);

                echo '1';
            } else {
               return response()->json(['msg' => 'Email id not found!!.', 'status'=>false]);
            }
        }
    }

    public function resetpassword(Request $request, $token = null, $email = null) {

        if (!empty($email) && !empty($token)) {
            $user = User::where([['email', '=', $email]])->first();
            if (empty($user)) {
                return redirect('home')->with(['message' => 'Invalid Access!', 'alert-class'=> 'alert-danger']);
            }

            $userToken = User::where([['email', '=', $email], ['remember_token', '=', $token]])->first();
            if (empty($userToken)) {
                
                return redirect('home')->with(['message' => 'Password reset link has been expired!','alert-class'=> 'alert-success']);
            }

            $hourdiff = round((strtotime(date('Y-m-d H:i:s')) - strtotime($user->updated_at)) / 60, 0);
           // echo $hourdiff; die;
            // if ($hourdiff >= 60) {
            //     return redirect('home')->with(['message' => 'Password reset link has expired!']);
            //     die;
            // }
            if ($user) {
                $data = [
                    'title' => 'Reset Password',
                    'user' => $user,
                ];
                return view('frontend.reset_password', $data);
            } else {
                return redirect('home')->with(['message' => 'Token mismatch, please forgot password again!', 'alert-class'=> 'alert-danger']);
            }
        } else {
            return redirect('home')->with(['message' => 'Token mismatch, please forgot password again!', 'alert-class'=> 'alert-danger']);
        }
    }

    public function updatepassword(Request $request) {
        $common = new Common();
        if ($request->isMethod('post')) {

            // $data = $request->validate([
            //     'password' => 'required|confirmed|min:6',
            // ]);
            $model = [
                'password' => Hash::make($request->password),
                'remember_token' => hash('sha256', $common->randString(30)),
            ];
            $affected = User::where([['email', '=', $request->email], ['remember_token', '=', $request->remember_token]])->update($model);
            // echo "<pre>";print_r($affected);die;
            if ($affected) {
                Session::flash('message', 'Password Reset Successfully.Please login'); 
                Session::flash('alert-class', 'alert-success');
                return response()->json(['msg' => 'Password Reset Successfully.Please login.', 'status'=>true]);
                // return redirect('home')->with('success', 'Password Reset Successfully!');
            } else {
                return response()->json(['msg' => 'Somethong went wrong please try again!', 'status'=>false]);
                //return redirect('forgot-password/' . $request->remember_token . '/' . $request->email)->with('error', 'Somethong went wrong please try again!');
            }
        }
    }

    public function change_password(Request $request) {
        if( \Auth::guard('user')->check() ){

            $common = new Common();
            if ($request->isMethod('post')) {

                $data = $request->validate([
                    'old_password' => 'required',
                    'new_password' => 'required|min:8'
                ]);
                $old_password = Hash::make($request->old_password);
                $user_auth=Auth::guard('user')->user();

                if(Hash::check($request->old_password, $user_auth->password)){
                    $data = $user_auth->fill([
                        'password' => Hash::make($request->new_password)
                    ]);

                    if($data->save()){

                        Session::flash('message', 'Password changed successfully.'); 
                        Session::flash('alert-class', 'alert-success');

                        return response()->json(['msg' => 'Password changed successfully.', 'status'=>true]);
                    }else{
                        return response()->json(['msg' => 'Something went wrong!!', 'status'=>false]);
                    }
                }else{
                    return response()->json(['msg' => 'Old password did not match..please enter again.', 'status'=>false]);
                }

            }else if ($request->isMethod('get')){
                return view('frontend.change_password');
            }else{
                return redirect()->back();
            }
        }else{
            return redirect('/');
        }
    }

    public function dashboard(Request $request){
        
        if( \Auth::guard('user')->check() ){  
            
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $myPlan = getUserSubscriptionDetails($loggedInUser);
            
            $user_auth=Auth::guard('user')->user();
            $id=$user_auth->id;
            $user = User::where('id', $id)->first();
            $data = array("user"=>$user,'myPlan'=>$myPlan);

            return view('frontend.dashboard',$data);

        }else{
            return redirect('/');
        }
        
    }

    public function dashboard_old(Request $request){
        if( \Auth::guard('user')->check() )
        {   $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $myPlan1 = getUserSubscriptionDetails($loggedInUser);
            // dd($myPlan);
            //check plan
            $balanceDay = '';
            $myPlan = DB::select("select * from tbl_user_subscriptions WHERE user_id = $loggedInUser AND payment_status =1 ORDER BY created_at DESC LIMIT 1");
            if (!empty($myPlan)) {
                $buyDate = $myPlan[0]->created_at;
                $planType = $myPlan[0]->subscription_type;
                if ($planType == 1 || $planType == 3) {
                    $expiryDate = date("Y-m-d H:i:s", strtotime('+30 days', strtotime($buyDate)));
                    $balanceDay = round((strtotime($expiryDate) - strtotime(date("Y-m-d H:i:s"))) / (60 * 60 * 24));
                }
                if ($planType == 2 || $planType == 4) {
                    $expiryDate = date("Y-m-d H:i:s", strtotime('+365 days', strtotime($buyDate)));
                    $balanceDay = round((strtotime($expiryDate) - strtotime(date("Y-m-d H:i:s"))) / (60 * 60 * 24));
                }

                if($balanceDay>0){
                    $balanceDay = $balanceDay;
                }else{
                    $balanceDay = 0;
                }
                $user_auth=Auth::guard('user')->user();
                $id=$user_auth->id;
                $user = User::where('id', $id)->first();
                $data = array("user"=>$user,"balanceDay"=>$balanceDay,'myPlan'=>$myPlan1);
            }else{
                $user_auth=Auth::guard('user')->user();
                $id=$user_auth->id;
                $user = User::where('id', $id)->first();
                $data = array("user"=>$user,"balanceDay"=>0, 'myPlan'=>$myPlan1);
            }
            // dd($data);
            return view('frontend.dashboard',$data);
            //->with('user',$data);

        }else{
            return redirect('/');
        }
        
    }

    public function updateProfile(Request $request){

        if( \Auth::guard('user')->check() )
        {
            $all=$request->all();

            $validator = Validator::make($all, [
                'first_name'=>'required',
                'email'=>'required',
            ]);
        
        
            if($validator->passes()) {
            
                $destinationPath = 'public/uploads/users';

                $id=$all['id'];
                $user = User::where('id', $id)->first();


                if(!empty($all['user_image'])){
                    if(!empty($all['old_user_image']))
                    {
                        $path=$destinationPath.'/'.$all['old_user_image'];
                        if(file_exists($path))
                        {
                          unlink("$path");
                        }
                    }
                    
                    $image=$all['user_image'];
                    $user_image_name=time().rand(1,10000).'.'.$image->getClientOriginalExtension();
                    $image->move($destinationPath,$user_image_name);  
                
                }else{
                    $user_image_name="";
                }
                $insClass=User::find($id);
                $insClass->first_name=$all['first_name'];
                if(!empty($user_image_name)){
                    $insClass->user_image=$user_image_name;
                }
                
                $insClass->last_name=$all['last_name'];
                $insClass->email=$all['email'];
                $insClass->phone=$all['phone'];
                if($user->email != $all['email']){
                    $insClass->status = 0;
                    $email_exit = DB::table('users')->where('email', $all['email'])->first();
                    if(!empty($email_exit)){ 
                        $arr = array('msg' => 'Email Address already exist. Please try with new Email Id!', 'status' => false);
                        return Response()->json($arr);
                    }
                }
                $saved=$insClass->save();
                if($saved && ($user->email == $all['email'])) {

                    return response()->json(['status'=>true,'msg'=>'User updated successfully.']);
                    
                }else if($saved && ($user->email != $all['email'])){

                    $current_timestamp=time();
                    $allowed_hours=2*3600;
                    $total_expire_time=$current_timestamp+$allowed_hours;
                    $encrypted=Crypt::encryptString($total_expire_time);
                    $data['token']=$total_expire_time;
                    $email = $all["email"];
                    try{
                        $insClass->token=$total_expire_time;
                        $insClass->save();
                        Mail::send('layouts.mailer.update_mail',['fname'=>$all["first_name"], 'token'=>$encrypted,'email'=>$email], function($message) use ($email) {
                         $message->to($email)->subject('Welcome on LOADUS');
                
                       });
                    }catch(\Exception $e){
                        // $message_err=$e->getMessage();
                        // print_r($message_err);exit;
                        $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
                    }
                    if(empty($arr)){
                        Auth::guard('user')->logout();

                        Session::flash('message', 'User updated Successfully! Check email for verification'); 
                        Session::flash('alert-class', 'alert-success');

                        $arr = array('msg' => 'User updated Successfully! Check email for verification', 'status' => '5');
                        return Response()->json($arr);
                    }else{
                        return Response()->json($arr);
                    }
                    

                }else{
                    return response()->json(['status'=>false,'msg'=>'Something went wrong!!.']);
                }
            }else{

                return response()->json([
                    'status'=>'invalid',
                    'errors' => $validator->getMessageBag()->toArray()
                    ]);

            }
            
        }else{
            return redirect('/');
        }
        
    }

    public function home() {

        $subscriptionType = array("1" => "Monthly", "2" => "Yearly");
        
        $subsMonthly = DB::select('select * from subscriptions WHERE subscription_type =1 AND `status`=1 ORDER BY created_at DESC LIMIT 1');

        $subsYearly = DB::select("select * from subscriptions WHERE subscription_type =2 AND `status`=1 ORDER BY created_at DESC LIMIT 1");

        $total_group_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
                WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `is_accepted` = 1
                ORDER BY `gfm`.`created_at` desc) as `total_group_members`");

        $total_group_flowers = DB::raw("( SELECT count(id) FROM `group_flowers` as `gf`
                WHERE `gf`.`parent_id` = `group_flowers`.`id`
                ORDER BY `gf`.`created_at` desc) as `total_group_flowers`");

        $banner = Banner::where(array('status'=>1))->first();

        if( Auth::guard('user')->check() ){
                
            $user_auth=Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $is_member = DB::raw("( SELECT 1 FROM `group_flowers_members` as `gfm` WHERE `gfm`.`member_id` = ".$loggedInUser." AND `gfm`.`group_flower_id` = `group_flowers`.`id`) as `is_member`");
                
        }else{
            $is_member =  DB::raw("0 as `is_member`");
        }

        $featured_groups = DB::table('group_flowers')
            ->select('*','group_flowers.id as group_id',$total_group_members, $total_group_flowers,$is_member)
            ->where(array('group_flowers.type'=>1, 'group_flowers.status'=>1, 'group_flowers.is_featured'=>1, 'group_flowers.deleted_at'=>null))
        ->get();

        // dd($featured_groups->toArray());

        $subs = array_merge($subsMonthly, $subsYearly);
        $data = array(
            'title' => 'Contact Us',
            'subscription' => $subs,
            'subscriptionType' => $subscriptionType,
            'featured_groups' => $featured_groups,
            'banner' => $banner,
        );
        return view('frontend.home', $data);
        
        
    }

    public function contact_us() { 
        
        $data = array(
            'title' => 'Contact Us',
        );
        return view('frontend.pages.contact_us')->with($data);
    }

    public function about_us() { 
        $aboutUs = Page::where(array("slug"=>"about-us","status"=>"1"))->get()->toArray();
        $data = array(
            'title' => 'About Us',
            'aboutUs' => $aboutUs
        );
        return view('frontend.pages.about_us')->with($data);
    }

    public function faq() { 

        $faq = Faq::where('status','=','1')->get()->toArray();
        //echo "<pre>";print_r($faq);die;
        $data = array(
            'title' => 'Faq',
            'faq' => $faq,
        );
        return view('frontend.pages.faq')->with($data);
    }
    
    public function testimonials() { 
        $testimonials = Testimonials::where(array("status"=>"1"))->get()->toArray();
        $data = array(
            'title' => 'Testimonials',
            'testimonials' => $testimonials
        );
        return view('frontend.pages.testimonials')->with($data);
    }
    
    public function howItWorks() { 
        $howItWorks = Page::where(array("slug"=>"how-it-works","status"=>"1"))->get()->toArray();
        $data = array(
            'title' => 'How It Works',
            'howItWorks' => $howItWorks
        );
        return view('frontend.pages.how-it-works')->with($data);
    }
    
    public function termsAndCondition() { 
        $termsAndCondition = Page::where(array("slug"=>"terms-and-condition","status"=>"1"))->get()->toArray();
        $data = array(
            'title' => 'Terms And Condition',
            'termsAndCondition' => $termsAndCondition
        );
        return view('frontend.pages.terms-and-condition')->with($data);
    }
    
    public function privacyPolicy() { 
        $privacyPolicy = Page::where(array("slug"=>"privacy-and-policy","status"=>"1"))->get()->toArray();
        $data = array(
            'title' => 'Privacy Policy',
            'privacyPolicy' => $privacyPolicy
        );
        return view('frontend.pages.privacy-policy')->with($data);
    }
    
    public function loadus_business() { 

        // $faq = Faq::where('status','=','1')->get()->toArray();
        //echo "<pre>";print_r($faq);die;
        $data = array(
            'title' => 'Loadus Business',
            // 'faq' => $faq,
        );
        return view('frontend.pages.business')->with($data);
    }
    
    public function loadus_categories(){
        // $faq = Faq::where('status','=','1')->get()->toArray();
        //echo "<pre>";print_r($faq);die;
        $data = array(
            'title' => 'Loadus Business',
            // 'faq' => $faq,
        );
        return view('frontend.pages.categories')->with($data);
        
    }
    
    public function loadus_library() { 

        // $faq = Faq::where('status','=','1')->get()->toArray();
        //echo "<pre>";print_r($faq);die;
        $data = array(
            'title' => 'Loadus Library',
            // 'faq' => $faq,
        );
        return view('frontend.pages.loadus_library')->with($data);
    }
    
    public function contactUs(Request $request) { 

        //if ($user) {
//                $first_name = $request->first_name;
//                $last_name = $request->last_name;
//                $phone = $request->phone;
                $email = $request['email'];
                $message = $request['message'];
                $Maildata = [
                    'first_name' => $request['first_name'] . '  ' . $request['last_name'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'message' => $request['message'],
                ];

                // echo "<pre>";print_r($Maildata);die;

                Mail::send('layouts.mailer.contact_us',$Maildata, function($message) use ($email) {
                 $message->to($email)->subject('Contact Us');
        
               });
                
                Session::flash('message', 'Password reset link sent to your email sucessfully!'); 
                Session::flash('alert-class', 'alert-success');
                return response()->json(['msg' => 'Password reset link sent to your email sucessfully!!.', 'status'=>true]);

                echo '1';
//            } else {
//               return response()->json(['msg' => 'Email id not found!!.', 'status'=>false]);
//            }
    }
    
    public function add_business(Request $request){
        if( \Auth::guard('user')->check() ){  
            
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $myPlan = getUserSubscriptionDetails($loggedInUser);
            if($myPlan['is_subscribed']==0){
                $user_auth=Auth::guard('user')->user();
                $id=$user_auth->id;
                $user = User::where('id', $id)->first();
                $data = array("user"=>$user,'myPlan'=>$myPlan);
                $sub_categories=DB::table('sub_categories')->where('status','1')->where('deleted_status','0')->get();
                if($request->all()){
                    //echo "<pre>"; print_r($request->all()); die;
                    $checkBCount=DB::table('tbl_businesses')->where('user_id',$loggedInUser)->count();
                    if($checkBCount>1){
                        return redirect()->back()->with('error', 'You has already registered two businesses');    
                    }
                    $title = $request->title;
                    $description = $request->description;
                    $open_time = $request->open_time;
                    $close_time = $request->close_time;
                    $services = $request->services;
                    $phone = $request->phone;
                    $address = $request->address;
                    $url = $request->url;
                    $source = $request->source;
                    $lat_source = $request->lat_source;
                    $source_long = $request->source_long;
                    //insert new business
                    $business_id=DB::table('tbl_businesses')->insertGetId([
                        'user_id'=>$loggedInUser,
                        'title'=>$title,
                        'description'=>$description,
                        'open_time'=>$open_time,
                        'end_time'=>$close_time,
                        'services'=>$services,
                        'phone'=>$phone,
                        'address'=>$address,
                        'website'=>$url,
                        'location'=>$source,
                        'source_lat'=>$lat_source,
                        'source_long'=>$source_long
                    ]);
                    //insert subcats
                    foreach($request->sub_category_ids as $sub_category_id){
                        DB::table('business_categories')->insert([
                            'business_id'=>$business_id,
                            'sub_cat_id'=>$sub_category_id
                        ]);
                    }
                    
                    //insert days
                    if(isset($request->day) && count($request->day)>0){
                        foreach($request->day as $days){
                            DB::table('business_days')->insert([
                                'business_id'=>$business_id,
                                'title'=>$days
                            ]);
                        }
                    }
                    
                    //insert tags
                    if(isset($request->tags) && !empty($request->tags)){
                        $tags=explode(',',$request->tags);
                        foreach($tags as $tag){
                            DB::table('business_tags')->insert([
                                'business_id'=>$business_id,
                                'title'=>$tag
                            ]);
                        }
                    }
                    
                    //insert images
                    foreach($request->file('images') as $file){
                        $imageType = $file->getClientmimeType();
                        $fileName = $file->getClientOriginalName();
                        $fileNameUnique = time() . '_' . $fileName;
                        $destinationPath = public_path() . '/business_images/';
                        $file->move($destinationPath, $fileNameUnique);
                        $imageData = $fileNameUnique;
                        DB::table('business_images')->insert([
                            'business_id'=>$business_id,
                            'title'=>$imageData
                        ]);
                    }
                    
                    return redirect()->back()->with('success', 'Your new business has been created successfully.');
                }
                return view('frontend.add_business',get_defined_vars());    
            }else{
                return redirect('/dashboard')->with('msg', 'Only subscribed user can use this feature.');
               
            }
            

        }else{
            return redirect('/');
        }
    }


}