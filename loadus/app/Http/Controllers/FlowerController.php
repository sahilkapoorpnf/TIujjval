<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use app\User;
use App\GroupFlowersMembers;
use App\GroupFlowerTier;
use App\Position;


use App\Http\Models\Group;

class FlowerController extends Controller{


    public function flower_pool(){
        if( Auth::guard('user')->check() ){
                
            $user_auth=Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            // dd($loggedInUser);
            $limit = 9;
            $is_member = DB::raw("( SELECT 1 FROM `group_flowers_members` as `gfm` WHERE `gfm`.`member_id` = ".$loggedInUser." AND `gfm`.`group_flower_id` = `group_flowers`.`id`) as `is_member`");
            // DB::enableQueryLog();
            
            $total_group_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
                  WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `is_accepted` = 1
                  ORDER BY `gfm`.`created_at` desc) as `total_group_members`");

            $total_group_flowers = DB::raw("( SELECT count(id) FROM `group_flowers` as `gf`
                  WHERE `gf`.`parent_id` = `group_flowers`.`id`
                  ORDER BY `gf`.`created_at` desc) as `total_group_flowers`");

            $flowers = DB::table('group_flowers')
                ->select('*','group_flowers.id as group_id',$total_group_members, $total_group_flowers,$is_member)
                ->leftJoin('group_flowers_members AS gfm', function($join) use($loggedInUser){
                    $join->on('gfm.group_flower_id', '=', 'group_flowers.id')
                    ->where('gfm.member_id', '=', $loggedInUser);
                })
                ->where(array('group_flowers.type'=>2, 'group_flowers.status'=>1, 'group_flowers.deleted_at'=>null));
            //->get();
            try {
                $flowers = $flowers->paginate($limit);
            }catch(NotFoundException $e) {
                $flowers  = array();
            }
            // dd(DB::getQueryLog());
            // echo "<pre>";print_r($flowers);die;
            $total_positions = Position::where('id','!=','1')->get();
            $invitable_users = User::where(array('status'=>1))->get();
            $data = array(
                "title"=>'Group Pool',
                "flowers"=>$flowers,
                "invitable_users"=>$invitable_users,
                'total_positions'=>$total_positions,
            );
            return view('frontend.flower.flower_pool')->with($data);
        }else{
            return redirect('/login?authRedirect=group-pool');
        }
    }

    

	public function create(){

        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $myPlan = getUserSubscriptionDetails($loggedInUser);
            if($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] > 0){
                
                $flowerPlan = getFlowerPlanDetails($loggedInUser);

                if(!empty($flowerPlan['flower_plan_details'])){

                    $users = User::where(array('status'=>1, 'deleted_at'=>null, ['id','!=',$loggedInUser]))->get();

                    $user_flowers = Group::where(array('user_id'=>$loggedInUser,'parent_id'=>0, 'status'=>1, 'deleted_at'=>null, 'type'=> 1))->get();
                    $data = array(
                        'users' => $users,
                        'user_flowers' => $user_flowers
                    );
                    return view('frontend.flower.create')->with($data);
                }else{
                    Session::flash('message', 'Please gift in amount to loadus to create flower'); 
                    Session::flash('alert-class', 'alert-success');
                    return redirect('/stripeFlower');
                }  

            }else if($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] <= 0){
                Session::flash('message', 'Your subscription plan has expired, please buy a new one to create flower'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect('/subscription_list');
            }else{
                Session::flash('message', 'Please buy a subscription plan to create flower.'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect('/subscription_list');
            }
        }else{
            return redirect('/login?authRedirect=create-flower');
        }
	}

    public function edit($id){
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            $id = Crypt::decryptString($id);
            $users = User::where(array('status'=>1, 'deleted_at'=>null, ['id','!=',$loggedInUser]))->get();

            $user_groups = Group::where(array('user_id'=>$loggedInUser,'parent_id'=>0, 'status'=>1, 'deleted_at'=>null, 'type'=> 1))->get();
            $result = Group::with(['groupflowertiers'])->where(array('id'=> $id, 'user_id'=>$loggedInUser))->first();
            $data = array(
                'users' => $users,
                'user_flowers' => $user_groups,
                'flower_details' =>$result
            );
             // dd($data);
            return view('frontend.flower.create')->with($data);
        }else{
            return redirect('/login?authRedirect=create-flower');
        }
    }

	public function store(Request $request){
        if( Auth::guard('user')->check() ){
    		$user_auth=Auth::guard('user')->user();
            $user_id = $loggedInUser = $user_auth->id;

    		$post=$request->all();
            // dd($post);
            $validator = Validator::make($post, [
                'name'=>'required',
                'tier1'=>'required',
                // 'tier2'=>'required',
                // 'tier3'=>'required',
            ]);
            if($post['privacy'] == 0){
                $validator = Validator::make($post, [
                    'password'=>'required',
                ]);
            }

            if($validator->passes()) {
                $uniqueId = generateUniqueGroupFlowerId();

                $destinationPath = 'public/uploads/flower';

                if(!empty($post['id'])){
                    $flower = Group::find($post['id']);
                    if(!empty($post['flower_image'])){

                        if(!empty($flower->image)){

                            $path=$destinationPath.'/'.$flower->image;
                            if(file_exists($path)){
                              unlink("$path");
                            }
                        }

                        $image=$post['flower_image'];
                        $flower_image_name=time().rand(1,10000).'.'.$image->getClientOriginalExtension();
                        $image->move($destinationPath,$flower_image_name);  
                    
                    }else{
                        $flower_image_name=$flower->image;
                    }
                    
                    $flower->name=$post['name'];
                    $flower->image=$flower_image_name;
                    $flower->description=$post['description'];
                    $flower->user_id=$user_id;
                    $flower->status=1;
                    $flower->privacy=$post['privacy'];
                    // $flower->group_flower_unique_id=$uniqueId;
                    if(!empty($post['parent_id'])){

                        $flower->parent_id=$post['parent_id'];
                    }else{
                        $flower->parent_id=null;
                    }
                    
                    if($post['privacy'] == 0){
                        $flower->password=$post['password'];
                    }else{
                        $flower->password=null;
                    }
                    if($flower->save()){
                        for($i = 1; $i <= config('constants.total_tiers'); $i++){

                            $gft=GroupFlowerTier::where(array('group_flower_id'=> $post['id'], 'tier'=>$i))->first();
                            if(empty($gft)){
                                $gft=new GroupFlowerTier();
                            }
                            $price = "tier".$i;
                            $gft->tier = $i;
                            $gft->group_flower_id = $flower->id;
                            $gft->price=$post[$price];
                            $gft->save();
                        }
                        Session::flash('message', 'Flower updated successfully');
                        Session::flash('alert-class', 'alert-success'); 
                        return response()->json(['status'=>true,'message'=>'Flower updated successfully.']);
                    }else{
                        return response()->json([
                            'status'=>'invalid',
                            'errors' => $validator->getMessageBag()->toArray()
                        ]);
                    }
                }else{

                    $myPlan = getUserSubscriptionDetails($loggedInUser);
                    if($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] > 0){
                        
                        $flowerPlan = getFlowerPlanDetails($loggedInUser);

                        if(!empty($flowerPlan['flower_plan_details'])){
                            if(!empty($post['flower_image'])){

                                $image=$post['flower_image'];
                                $flower_image_name=time().rand(1,10000).'.'.$image->getClientOriginalExtension();
                                $image->move($destinationPath,$flower_image_name);  
                            
                            }else{
                                $flower_image_name="";
                            }
                        
                            $flower=new Group();
                            
                            $flower->name=$post['name'];
                            $flower->image=$flower_image_name;
                            $flower->description=$post['description'];
                            $flower->user_id=$user_id;
                            $flower->status=1;
                            $flower->payment_id = $flowerPlan['flower_plan_details']->id;
                            $flower->type=2;
                            $flower->group_flower_unique_id=$uniqueId;
                            $flower->privacy=$post['privacy'];
                            if(!empty($post['parent_id'])){

                                $flower->parent_id=$post['parent_id'];
                            }
                            if($post['privacy'] == 0){
                                $flower->password=$post['password'];
                            }

                            if($flower->save()){
                                $insertedId = $flower->id;
                                for($i = 1; $i <= config('constants.total_tiers'); $i++){
                                    $gft=new GroupFlowerTier();
                                    $price = "tier".$i;
                                    $gft->tier = $i;
                                    $gft->group_flower_id = $insertedId;
                                    $gft->price=$post[$price];
                                    $gft->save();
                                }
                                
                                Session::flash('message', 'Flower created successfully');
                                Session::flash('alert-class', 'alert-success'); 
                                return response()->json(['status'=>true,'message'=>'Flower created successfully.']);
                            }
                        }else{
                            Session::flash('message', 'Please gift in amount to loadus to create flower'); 
                            Session::flash('alert-class', 'alert-success');
                            return redirect('/stripeFlower');
                        }  
        
                    }else if($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] <= 0){
                        Session::flash('message', 'Your subscription plan has expired, please buy a new one to create flower'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect('/subscription_list');
                    }else{
                        Session::flash('message', 'Please buy a subscription plan to create flower.'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect('/subscription_list');
                    }
                }
                
            }else{

                return response()->json([
                    'status'=>'invalid',
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
            }
        }else{
            return redirect('/login?authRedirect=create-flower');
        }
	}
    /***----   Listing of logged-In users created flowers -----***/
    public function created_flowers(){
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $created_flowers = Group::with('groupflowermembers')->where(array('user_id'=>$loggedInUser, 'status'=>1, 'deleted_at'=>null, 'type'=> 2))->get();

            $postions = Position::all();
            $invitable_users = User::where(array('status'=>1))->get();

            $data = array(
                'created_flowers' => $created_flowers,
                'total_positions' => $postions,
                'invitable_users'=>$invitable_users,
            );

            // dd($created_flowers->toarray());
            return view('frontend.flower.created_flowers')->with($data);
        }else{
            return redirect('/login?authRedirect=created-flowers');
        }
    }
    /*** ----- Logged in users joined flowers list ---- **/
    public function joined_flowers(){
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $postions = Position::all();

            $earth_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
                  WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `position_id` = 2
                  ORDER BY `gfm`.`created_at` desc) as `earth_members`");

            $air_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
            WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `position_id` = 3
            ORDER BY `gfm`.`created_at` desc) as `air_members`");

            $fire_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm` WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `position_id` = 4 ORDER BY `gfm`.`created_at` desc) as `fire_members`");

            // DB::enableQueryLog();
            // $joined_flowers = GroupFlowersMembers::where(array('member_id'=>$loggedInUser, 'is_accepted'=>1,['position_id', '!=', 0]))->with(['group_details'])->get(); 

            $joined_flowers = DB::table('group_flowers')
            ->select('*',$earth_members, $air_members, $fire_members)
            ->join('group_flowers_members', 'group_flowers.id', '=', 'group_flowers_members.group_flower_id')
            ->where(array('group_flowers.status'=>1, 'group_flowers.deleted_at'=>null, 'group_flowers.type'=> 2))
            ->where(array('group_flowers_members.member_id' => $loggedInUser,'group_flowers_members.is_accepted'=>1 ))
            ->get();

            $data = array(
                'joined_flowers' => $joined_flowers,
                'total_positions' => $postions,
            );
            // echo "<pre>";print_r($joined_flowers->toArray());die;
            return view('frontend.flower.joined_flowers')->with($data);
        }else{
            return redirect('/login?authRedirect=joined-flowers');
        }
    }
    
    /*** Accept or Cancel Group Member Request Start ***/
    public function acceptFlowerMember(Request $request){

        $post = $request->all();
        $group_flower_id = Crypt::decryptString($post['group_id']);
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $user_id = $user_auth->id; //logged in user

            $group = Group::find($group_flower_id);
            
            if(!empty($group)){

                $groupFlowerMembers = GroupFlowersMembers::where(array('group_flower_id'=>$group_flower_id, 'member_id'=> $user_id))->first();
                
                if(!empty($groupFlowerMembers) > 0){
                    $groupFlowerMembersCount = GroupFlowersMembers::where(array('group_flower_id'=>$group_flower_id, 'is_accepted'=>1))->get()->count();

                    if($groupFlowerMembersCount < 14){
                        if($groupFlowerMembers->is_accepted == 1){
                            $redirectUrl = '/group-pool';
                            $msg = 'You have already accepted the request to become member on flower!!';
                            Session::flash('message', $msg);
                            Session::flash('alert-class', 'alert-success'); 
                            return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                            
                        }else{
    
                            if($group->privacy == 0){
                                $validator = Validator::make($post, [
                                    'password'=>'required',
                                ]);
    
                                if($group->password == $post['password']){
                                    $groupFlowerMembers->is_accepted = 1;
                                    $groupFlowerMembers->save();

                                    if($groupFlowerMembersCount == 13){
                                        $this->flowerSplit($group_flower_id);
                                    }
                                    $redirectUrl = "/accept-group-member-request/".$group_flower_id;
                                    $msg= 'Request accepted successfully!!';
                                    Session::flash('message', $msg);
                                    Session::flash('alert-class', 'alert-success'); 
                                    return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                                    
                                }else{
                                    $redirectUrl = "/accept-group-member-request/".$group_flower_id;
                                    $msg= 'Please enter correct password!!';
                                    Session::flash('message', $msg);
                                    Session::flash('alert-class', 'alert-success'); 
                                    return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                                    
                                }
                            }else{
                                $groupFlowerMembers->is_accepted = 1;
                                $groupFlowerMembers->save();
                                if($groupFlowerMembersCount == 13){
                                    $this->flowerSplit($group_flower_id);
                                }
                                $redirectUrl = "/accept-group-member-request/".$group_flower_id;
                                $msg= 'Request accepted successfully!!';
                                Session::flash('message', $msg);
                                Session::flash('alert-class', 'alert-success'); 
                                return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                                
                            }
                        }
                    }else{
                        // $this->flowerSplit($group_flower_id);
                    }
                    
                }else{
                    $redirectUrl = "/login?authRedirect=accept-group-member-request/".$group_flower_id;
                    $msg= 'Request expired!!';
                    Session::flash('message', $msg);
                    Session::flash('alert-class', 'alert-success'); 
                    return response()->json(['status'=>true,'message'=>'Request expired!!', 'redirectUrl'=>$redirectUrl]);
                }
            }
        }else{
            return redirect('/login?authRedirect=accept-group-member-request/'.$group_flower_id);
        }
    }

    public function details($id=null){

        if(Auth::guard('user')->check()){
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $id = Crypt::decryptString($id);

            $is_member = DB::raw("( SELECT 1 FROM `group_flowers_members` as `gfm` WHERE `gfm`.`member_id` = ".$loggedInUser." AND `gfm`.`group_flower_id` = ".$id.") as `is_member`");
            
            // $flower_details = Group::with(['groupowner','allgroupflowermembers','acceptedgroupflowermembers','groupflowermembers'])->select('*',$is_member)->where(array('id'=>$id,'type'=>2))->first();

            $earth_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
                  WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `position_id` = 2
                  ORDER BY `gfm`.`created_at` desc) as `earth_members`");

            $air_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
            WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `position_id` = 3
            ORDER BY `gfm`.`created_at` desc) as `air_members`");

            $fire_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm` WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `position_id` = 4 ORDER BY `gfm`.`created_at` desc) as `fire_members`");
            //  DB::enableQueryLog();

            $flower_details = DB::table('group_flowers')
                ->select('*','group_flowers.id as group_id',$fire_members,$earth_members, $air_members, $is_member)
                ->leftJoin('group_flowers_members AS gfm', function($join) use($loggedInUser){
                    $join->on('gfm.group_flower_id', '=', 'group_flowers.id')
                    ->where('gfm.member_id', '=', $loggedInUser);
                })
                ->where(array('group_flowers.id' => $id,'group_flowers.type'=>2, 'group_flowers.status'=>1, 'group_flowers.deleted_at'=>null))
            ->first();
            $group_flower_owner = Group::with(['groupowner'])->where(array('id'=>$id,'type'=>2))->first();;
            
            // dd($flower_details);
            
            $flower_positions = array();
            $water = 14;
            $earth = 12;
            $air = 8;
            $fire = 0;
            for($i = 0;$i < 15;$i++){
                if($i>=0 && $i<= 7){
                    $flower_positions[$i] = array(
                        "member_id"=>'',
                        "position_id" => 4,
                        "icon" => asset('public/frontend/img/fire.png'),
                        "flowerClass"=>'tie'.($i+1),
                        "group_flower_user"=>array(
                            "id" => '',
                            "first_name" => '',
                            "last_name" => '',
                            "email" => '',
                            "user_image" => 'user_profile.jpg',
                        ),
                    );
                }else if($i>=8 && $i<= 11){
                    $flower_positions[$i] = array(
                        "member_id"=>'',
                        "position_id" => 3,
                        "icon"=>asset('public/frontend/img/air.png'),
                        "flowerClass"=>'tie'.($i+1),
                        "group_flower_user"=>array(
                            "id" => '',
                            "first_name" => '',
                            "last_name" => '',
                            "email" => '',
                            "user_image" => 'user_profile.jpg',
                        ),
                    );
                }else if($i>=12 && $i<= 13){
                    $flower_positions[$i] = array(
                        "member_id"=>'',
                        "position_id" => 2,
                        "icon"=>asset('public/frontend/img/earth.png'),
                        "flowerClass"=>'tie'.($i+1),
                        "group_flower_user"=>array(
                            "id" => '',
                            "first_name" => '',
                            "last_name" => '',
                            "email" => '',
                            "user_image" => 'user_profile.jpg',
                        ),
                    );
                }else{
                    $flower_positions[$i] = array(
                        "member_id"=>'',
                        "position_id" => 1,
                        "icon"=>asset('public/frontend/img/water.png'),
                        "flowerClass"=>'tie'.($i+1),
                        // "group_flower_user"=>$flower_details['groupowner'],
                        "group_flower_user"=>$group_flower_owner['groupowner'],
                    );
                }
                
            }

            $position_users = GroupFlowersMembers::with(['groupFlowerUser'])->select('position_id','member_id')->where(array('is_accepted'=>1, 'group_flower_id' => $id))->get();
                $position_users_length = count($position_users);
            if(!empty($position_users)){
                $position_users = $position_users->toArray();
                for($j= 0; $j< $position_users_length; $j++){
                    if($position_users[$j]['position_id'] == 4){
                        $flower_positions[$fire] =  array_replace($flower_positions[$fire],$position_users[$j]);
                        $fire++;
                    }else if($position_users[$j]['position_id'] == 3){
                        $flower_positions[$air] =  array_replace($flower_positions[$air],$position_users[$j]);
                        $air++;
                    }else if($position_users[$j]['position_id'] == 2){
                        $flower_positions[$earth] =  array_replace($flower_positions[$earth],$position_users[$j]);
                        $earth++;
                    }
                }
            }
            // echo "<pre>";print_r($position_users);die;
            $total_positions = Position::where('id','!=','1')->get();
            $invitable_users = User::where(array('status'=>1))->get();
            $data = array(
                'title' => 'Flower Details',
                'flower_details' => $flower_details,
                'flower_positions' => $flower_positions,
                'total_positions'=>$total_positions,
                'invitable_users'=>$invitable_users,
            );

            // dd($data);
            return view('frontend.flower.details')->with($data);

        }else{
            return redirect('/login?authRedirect=flower-details/'.$id);
        }
    }


    public function flowerSplit($group_flower_id){
        $group_flower_id = $group_flower_id;

        $groupFlowerMembersCount = GroupFlowersMembers::where(array('group_flower_id'=>$group_flower_id, 'is_accepted'=>1))->get()->count();

        if($groupFlowerMembersCount == 14){

            $groupFlowerEarthMembers =  GroupFlowersMembers::where(array('group_flower_id'=>$group_flower_id, 'is_accepted'=>1, 'position_id'=>2))->get()->toArray();
            $oldGroupDetails = Group::find($group_flower_id);
            $oldGroupDetails->status = 0;

            $oldGroupDetails->save();

            for($i = 0; $i < 2; $i++){
                $group=new Group();
                    
                $group->name = $oldGroupDetails->name;
                $group->image = $oldGroupDetails->image;
                $group->description = $oldGroupDetails->description;
                $group->user_id = $groupFlowerEarthMembers[$i]['member_id'];
                $group->status = 1;
                $group->type = 2;
                $group->parent_id = $oldGroupDetails->parent_id;
                $group->privacy = $oldGroupDetails->privacy;
                $group->password = $oldGroupDetails->password;
                $group->flower_parent_id = $group_flower_id;
                

                if($group->save()){
                    $newGroupId = $group->id;
                    $newGroupOwner = $group->user_id;
                    

                    $tierCount = GroupFlowerTier::where(array('group_flower_id'=> $group_flower_id))->get()->count();
                    $flowerTiers=GroupFlowerTier::where(array('group_flower_id'=> $group_flower_id))->get();

                    if(!empty($flowerTiers)){
                        $flowerTiers=$flowerTiers->toArray();
                    }else{
                        $flowerTiers = array();
                    }
                    // dd($tierCount);
                    for($k = 0; $k < $tierCount; $k++){
                        $gft=new GroupFlowerTier();
                        $gft->tier = $flowerTiers[$k]['price'];
                        $gft->group_flower_id = $newGroupId;
                        $gft->price=$flowerTiers[$k]['price'];
                        $gft->save();
                    }
                    
                    
                    $groupFlowerSplitMembers =  GroupFlowersMembers::where(array('group_flower_id'=>$group_flower_id, 'is_accepted'=>1, ['position_id','!=',2]))->orderBy('position_id','asc')->get();

                    $groupFlowerSplitMembers->toArray();
                    foreach($groupFlowerSplitMembers as $k=>$gfsm){
                        $newGroupFlowerMembers = new GroupFlowersMembers();
                        if($i == 0){
                            if($k%2 == 0){
                                $newGroupFlowerMembers->group_flower_id = $newGroupId;
                                $newGroupFlowerMembers->member_id = $groupFlowerSplitMembers[$k]['member_id'];
                                $newGroupFlowerMembers->sent_by = $newGroupOwner;
                                $newGroupFlowerMembers->position_id = $groupFlowerSplitMembers[$k]['position_id'] - 1;
                                $newGroupFlowerMembers->status = 1;
                                $newGroupFlowerMembers->is_accepted = 1;
                                $newGroupFlowerMembers->save();
                            }
                            

                        }else{

                            if($k%2 == 1){
                                $newGroupFlowerMembers->group_flower_id = $newGroupId;
                                $newGroupFlowerMembers->member_id = $groupFlowerSplitMembers[$k]['member_id'];
                                $newGroupFlowerMembers->sent_by = $newGroupOwner;
                                $newGroupFlowerMembers->position_id = $groupFlowerSplitMembers[$k]['position_id'] - 1;
                                $newGroupFlowerMembers->status = 1;
                                $newGroupFlowerMembers->is_accepted = 1;
                                $newGroupFlowerMembers->save();
                            }  

                        }
                        
                    }
                    $waterUserDetails = userDetails($newGroupOwner);
                    $ghostMembersCount =  GroupFlowersMembers::where(array('group_flower_id'=>$newGroupId, 'is_accepted'=>1, 'is_ghost'=>1))->orderBy('position_id','asc')->get()->count();
                    if($waterUserDetails->user_type == 3 && $ghostMembersCount != 6){
                        for($fires = 1; $fires <= 8; $fires++){
                            $newGroupFlowerMembers = new GroupFlowersMembers();
                            $newGroupFlowerMembers->group_flower_id = $newGroupId;
                            $newGroupFlowerMembers->member_id = $waterUserDetails->id;
                            $newGroupFlowerMembers->sent_by = $newGroupOwner;
                            $newGroupFlowerMembers->position_id = 4;
                            $newGroupFlowerMembers->status = 1;
                            $newGroupFlowerMembers->is_accepted = 1;
                            $newGroupFlowerMembers->is_ghost = 1;
                            $newGroupFlowerMembers->save();
                        }

                        $this->flowerSplit($newGroupId);
                    }else if($waterUserDetails->user_type == 3 && $ghostMembersCount == 6){
                        $ghostGroupDetails = Group::find($newGroupId);
                        $ghostGroupDetails->status = 0;
                        $ghostGroupDetails->save();
                    }


                }
            }

        }
    }

    public function flower_join_cancel_request(Request $request){

        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $user_id=$user_auth->id;

            $post=$request->all();

            $group_flower_id = Crypt::decryptString($post['group_id']);

            $request_details = DB::table('group_flowers')
            ->join('group_flowers_members', 'group_flowers_members.group_flower_id', '=', 'group_flowers.id')
            ->select('*')
            ->where(array('group_flowers.id'=>$group_flower_id,'group_flowers_members.member_id'=> $user_id, 'group_flowers.type'=>2))
            ->first();
            // dd($request_details);
            if(!empty($request_details)){
                if($request_details->is_accepted == 0){
                    $group = GroupFlowersMembers::find($request_details->id);
                    $delete = $group->delete();
                    if($delete){
                        Session::flash('message', 'Request cancelled successfully');
                        Session::flash('alert-class', 'alert-success'); 
                        return response()->json(['status'=>true,'message'=>'Request cancelled successfully.']);
                    }else{
                        return response()->json(['status'=>true,'message'=>'Something went wrong!.']);
                    }
                    
                }else{
                    Session::flash('message', 'Request already accepted');
                    Session::flash('alert-class', 'alert-success'); 
                    return response()->json(['status'=>true,'message'=>'Request already accepted.']);
                }
                
            }else{
                return response()->json(['status'=>true,'message'=>"Flower request already cancelled"]);
            }
            
        }else{
            return redirect('/login?authRedirect=group-pool');
        }
    }

    public function getFlowerJoinRequests(){
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $loggedInUser=$user_auth->id;
            $limit = 10;

            $flowerJoinRequests = DB::table('group_flowers_members as gfm')
            ->join('group_flowers as gf', 'gf.id', '=', 'gfm.group_flower_id')
            ->join('users', 'gfm.member_id', '=', 'users.id')
            ->join('positions','positions.id','=','gfm.position_id')
            ->select('gf.id as group_id','gf.user_id as group_owner_id','gf.name as group_name','users.first_name','gfm.sent_by','gfm.member_id','gfm.is_accepted','gfm.id as gfm_Id','gf.privacy','gfm.position_id','positions.name as position_name')
            ->where('gfm.is_accepted','=',0)
            ->where('gf.type','=',2)
            ->where(function($query) use($loggedInUser) {
                $query->where('gf.user_id', $loggedInUser)
                ->orWhere('gfm.member_id', $loggedInUser );
            });
            // ->orWhere('gfm.member_id','=',$loggedInUser)
            //->get();
            try {
                $flowerJoinRequests = $flowerJoinRequests->paginate($limit);
            }catch(NotFoundException $e) {
                $flowerJoinRequests  = array();
            }

            // echo "<pre>";print_r($flowerJoinRequests->toArray());die;
            $data = array(
                'title' => 'Flower Request',
                'flower_requests' => $flowerJoinRequests,
            );
            return view('frontend.flower.flower_requests')->with($data);

        }else{
            return redirect('/login?authRedirect=group-join-request-list');
        }

    }

    public function cancelInvite(Request $request){
        $post = $request->all();
        // dd($post);
        
        $group_flower_id = Crypt::decryptString($post['group_id']);
        $gfm_id = Crypt::decryptString($post['gfm_id']);
        // $type = $post['type'];
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $user_id = $loggedInUser = $user_auth->id; //logged in user

            $group = Group::find($group_flower_id);
            // dd($group);
            if(!empty($group)){

                $groupFlowerMembers = DB::table('group_flowers_members as gfm')
                ->join('group_flowers as gf', 'gf.id', '=', 'gfm.group_flower_id')
                ->select('gf.*','gfm.*')
                ->where(array('gf.user_id'=> $loggedInUser,'gfm.id'=>$gfm_id,'gfm.sent_by'=>$loggedInUser,'gf.type'=>2))
                ->first();
                // dd($groupFlowerMembers);
                if(!empty($groupFlowerMembers) > 0){

                    if($groupFlowerMembers->is_accepted == 1){
                        $redirectUrl = '/flower-join-request-list';
                        $msg = 'User already accepted the request to become flower member!!';
                        Session::flash('message', $msg);
                        Session::flash('alert-class', 'alert-success'); 
                        return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                        
                    }else{
                        $gfm_new = GroupFlowersMembers::find($gfm_id);
                        $delete = $gfm_new->delete();
                        if($delete){
                            Session::flash('message', 'Invitation request cancelled successfully');
                            Session::flash('alert-class', 'alert-success'); 
                            return response()->json(['status'=>true,'message'=>'Invitation request cancelled successfully.']);
                        }else{
                            return response()->json(['status'=>true,'message'=>'Something went wrong!.']);
                        }
                        
                            
                    }
                }else{
                    $redirectUrl = "/login?authRedirect=accept-group-member-request/".$group_flower_id;
                    $msg= 'Request expired!!';
                    Session::flash('message', $msg);
                    Session::flash('alert-class', 'alert-danger'); 
                    return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                    //return response()->json(['status'=>true,'message'=>'Request expired!!', 'redirectUrl'=>$redirectUrl]);
                }
            }else{
                $msg= 'Group not found, please try again';
                Session::flash('message', $msg);
                Session::flash('alert-class', 'alert-danger'); 
                return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
            }
        }else{
            return redirect('/login?authRedirect=flower-join-request-list');
        }
    }

    public function rejectInvite(Request $request){
        $post = $request->all();
        // dd($post);
        $group_flower_id = Crypt::decryptString($post['group_id']);
        $gfm_id = Crypt::decryptString($post['gfm_id']);
        // $type = $post['type'];
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $user_id = $loggedInUser = $user_auth->id; //logged in user

            $group = Group::find($group_flower_id);
            // dd($group);
            if(!empty($group)){

                $groupFlowerMembers = DB::table('group_flowers_members as gfm')
                ->join('group_flowers as gf', 'gf.id', '=', 'gfm.group_flower_id')
                ->select('gf.*','gfm.*')
                ->where(array('gf.user_id'=> $loggedInUser,'gfm.id'=>$gfm_id, 'gf.type'=>2))
                ->first();
                // dd($groupFlowerMembers);
                if(!empty($groupFlowerMembers) > 0){

                    if($groupFlowerMembers->is_accepted == 1){
                        $redirectUrl = '/group-join-request-list';
                        $msg = 'You already accepted the user request to become flower member!!';
                        Session::flash('message', $msg);
                        Session::flash('alert-class', 'alert-success'); 
                        return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                        
                    }else{
                        $gfm_new = GroupFlowersMembers::find($gfm_id);
                        $delete = $gfm_new->delete();
                        if($delete){
                            Session::flash('message', 'Flower join request rejected successfully');
                            Session::flash('alert-class', 'alert-success'); 
                            return response()->json(['status'=>true,'message'=>'Flower join request rejected successfully.']);
                        }else{
                            return response()->json(['status'=>true,'message'=>'Something went wrong!.']);
                        }          
                    }
                }else{
                    $redirectUrl = "/login?authRedirect=flower-join-request-list";
                    $msg= 'Request expired!!';
                    Session::flash('message', $msg);
                    Session::flash('alert-class', 'alert-danger'); 
                    return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                }
            }else{
                $msg= 'Flower not found, please try again';
                Session::flash('message', $msg);
                Session::flash('alert-class', 'alert-danger'); 
                return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
            }
        }else{
            return redirect('/login?authRedirect=flower-join-request-list');
        }
    }

    public function acceptInvite(Request $request){

        $post = $request->all();
        $group_flower_id = Crypt::decryptString($post['group_id']);

        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $user_id  = $loggedInUser = $user_auth->id; //logged in user

            $group = Group::find($group_flower_id);
            $gfm_id = Crypt::decryptString($post['gfm_id']);
            
            if(!empty($group)){
                
                $groupFlowerMembers = DB::table('group_flowers_members as gfm')
                ->join('group_flowers as gf', 'gf.id', '=', 'gfm.group_flower_id')
                ->select('gf.*','gfm.*')
                ->where(array('gf.user_id'=> $loggedInUser,'gfm.id'=>$gfm_id,'gf.id'=>$group_flower_id))
                ->first();

                if(!empty($groupFlowerMembers) > 0){
                    $groupFlowerMembers = GroupFlowersMembers::find($gfm_id);

                    $groupFlowerMembersCount = GroupFlowersMembers::where(array('group_flower_id'=>$group_flower_id, 'is_accepted'=>1))->get()->count();

                    if($groupFlowerMembersCount < 14){
                        if($groupFlowerMembers->is_accepted == 1){
                            $redirectUrl = '/group-pool';
                            $msg = 'User request already accepted!';
                            Session::flash('message', $msg);
                            Session::flash('alert-class', 'alert-success'); 
                            return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                            
                        }else{
    
                            if($group->privacy == 0){
                                $validator = Validator::make($post, [
                                    'password'=>'required',
                                ]);
    
                                if($group->password == $post['password']){
                                    $groupFlowerMembers->is_accepted = 1;
                                    $groupFlowerMembers->save();

                                    if($groupFlowerMembersCount == 13){
                                        $this->flowerSplit($group_flower_id);
                                    }
                                    $redirectUrl = "/accept-group-member-request/".$group_flower_id;
                                    $msg= 'Request accepted successfully!!';
                                    Session::flash('message', $msg);
                                    Session::flash('alert-class', 'alert-success'); 
                                    return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                                    
                                }else{
                                    $redirectUrl = "/accept-group-member-request/".$group_flower_id;
                                    $msg= 'Please enter correct password!!';
                                    Session::flash('message', $msg);
                                    Session::flash('alert-class', 'alert-success'); 
                                    return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                                    
                                }
                            }else{
                                $groupFlowerMembers->is_accepted = 1;
                                $groupFlowerMembers->save();
                                if($groupFlowerMembersCount == 13){
                                    $this->flowerSplit($group_flower_id);
                                }
                                $redirectUrl = "/accept-group-member-request/".$group_flower_id;
                                $msg= 'Request accepted successfully!!';
                                Session::flash('message', $msg);
                                Session::flash('alert-class', 'alert-success'); 
                                return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                                
                            }
                        }
                    }else{
                        // $this->flowerSplit($group_flower_id);
                    }
                    
                }else{
                    $redirectUrl = "/login?authRedirect=accept-group-member-request/".$group_flower_id;
                    $msg= 'Request expired!!';
                    Session::flash('message', $msg);
                    Session::flash('alert-class', 'alert-success'); 
                    return response()->json(['status'=>true,'message'=>'Request expired!!', 'redirectUrl'=>$redirectUrl]);
                }
            }
        }else{
            return redirect('/login?authRedirect=accept-group-member-request/'.$group_flower_id);
        }
    }

    public function rejectJoin(Request $request){
        $post = $request->all();
        // dd($post);
        $group_flower_id = Crypt::decryptString($post['group_id']);
        $gfm_id = Crypt::decryptString($post['gfm_id']);
        // $type = $post['type'];
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $user_id = $loggedInUser = $user_auth->id; //logged in user

            $group = Group::find($group_flower_id);
            // dd($group);
            if(!empty($group)){

                $groupFlowerMembers = DB::table('group_flowers_members as gfm')
                ->join('group_flowers as gf', 'gf.id', '=', 'gfm.group_flower_id')
                ->select('gf.*','gfm.*')
                ->where(array('gfm.member_id'=> $loggedInUser,'gfm.id'=>$gfm_id, 'gf.type'=>2))
                ->first();
                // dd($groupFlowerMembers);
                if(!empty($groupFlowerMembers) > 0){

                    if($groupFlowerMembers->is_accepted == 1){
                        $redirectUrl = '/group-join-request-list';
                        $msg = 'You already accepted the user request to become flower member!!';
                        Session::flash('message', $msg);
                        Session::flash('alert-class', 'alert-success'); 
                        return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                        
                    }else{
                        $notificationDelete = array(
                            'object_id'=>$groupFlowerMembers->id,
                            'group_flower_id'=>$groupFlowerMembers->group_flower_id,
                            'object_type' => 'flowerinvite',
                        );
                        $gfm_new = GroupFlowersMembers::find($gfm_id);
                        $delete = $gfm_new->delete();
                        if($delete){

                            $this->deleteNotification($notificationDelete);
                            /** Add & Send Notification Start **/
                            $notification = array(
                                'send_by' => $loggedInUser,
                                'send_to' => $groupFlowerMembers->user_id,
                                'group_flower_id' => $group_flower_id,
                                'object_id' => null,
                                'object_type' => 'rejectFlowerJoin',
                                'description' => 'has rejected your request to join your flower '.$groupFlowerMembers->name,
                            );
                            Notification::create($notification);
                            /** Add & Send Notification End **/
                            Session::flash('message', 'Flower join request rejected successfully');
                            Session::flash('alert-class', 'alert-success'); 
                            return response()->json(['status'=>true,'message'=>'Flower join request rejected successfully.']);
                        }else{
                            return response()->json(['status'=>true,'message'=>'Something went wrong!.']);
                        }          
                    }
                }else{
                    $redirectUrl = "/login?authRedirect=flower-join-request-list";
                    $msg= 'Request expired!!';
                    Session::flash('message', $msg);
                    Session::flash('alert-class', 'alert-danger'); 
                    return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                }
            }else{
                $msg= 'Flower not found, please try again';
                Session::flash('message', $msg);
                Session::flash('alert-class', 'alert-danger'); 
                return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
            }
        }else{
            return redirect('/login?authRedirect=flower-join-request-list');
        }
    }

    public function destroy(Request $request){

        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $group = Group::where(array('id'=>Crypt::decryptString($request->id), 'user_id'=>$loggedInUser, 'type'=>2))->first();

            if(!empty($group)){

                $delete = $group->delete();

                if($delete){
                    return response()->json(['status'=>true,'msg'=>'Flower deleted successfully.']);
                }else{
                    return response()->json(['status'=>false,'msg'=>'Something went wrong!.']);
                }
            }else{
                return response()->json(['status'=>false,'msg'=>'Flower not found.']);
            } 
        }else{
            return response()->json(['status'=>false,'msg'=>'please login again.']);
        }
    }

    public function leaveFlower(Request $request){
        
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $group = Group::where(array('id'=>Crypt::decryptString($request->id), 'type'=>2))->first();

            if(!empty($group)){

                $groupFlowerMember = GroupFlowersMembers::where(array('group_flower_id'=>Crypt::decryptString($request->id), 'member_id'=>$loggedInUser, 'is_accepted'=>1))->first();

                if(!empty($groupFlowerMember)){
                    $delete = $groupFlowerMember->delete();

                    if($delete){
                        return response()->json(['status'=>true,'msg'=>'Flower leaved successfully.']);
                    }else{
                        return response()->json(['status'=>false,'msg'=>'Something went wrong!.']);
                    }
                }else{
                    return response()->json(['status'=>false,'msg'=>'Member not found!.']);
                }
            
                
            }else{
                return response()->json(['status'=>false,'msg'=>'Flower not found.']);
            }  
        }else{
            return response()->json(['status'=>false,'msg'=>'please login again.']);
        }
    }

    private function deleteNotification($notificationDelete = array()){

        $getInviteNotification = Notification::where($notificationDelete)->first();
        if(!empty($getInviteNotification)){
            $getInviteNotification->delete();
        }
    }

}