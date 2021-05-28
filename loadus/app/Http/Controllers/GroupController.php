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
use App\User;
use App\GroupFlowersMembers;
use App\Position;
use App\UserSubscription;
use App\Http\Models\Notification;
use App\Http\Models\Group;

class GroupController extends Controller {

    public function group_pool() {
        if (Auth::guard('user')->check()) {

            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            // dd($loggedInUser);
            $limit = 9;
            $is_member = DB::raw("( SELECT 1 FROM `group_flowers_members` as `gfm` WHERE `gfm`.`member_id` = " . $loggedInUser . " AND `gfm`.`group_flower_id` = `group_flowers`.`id`) as `is_member`");
            DB::enableQueryLog();

            $total_group_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
                  WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `is_accepted` = 1
                  ORDER BY `gfm`.`created_at` desc) as `total_group_members`");

            $total_group_flowers = DB::raw("( SELECT count(id) FROM `group_flowers` as `gf`
                  WHERE `gf`.`parent_id` = `group_flowers`.`id` AND `group_flowers`.`status` = 1 AND `group_flowers`.`deleted_at` is null ORDER BY `gf`.`created_at` desc) as `total_group_flowers`");

            $groups = DB::table('group_flowers')
                    ->select('*', 'group_flowers.id as group_id', $total_group_members, $total_group_flowers, $is_member)
                    ->leftJoin('group_flowers_members AS gfm', function($join) use($loggedInUser) {
                        $join->on('gfm.group_flower_id', '=', 'group_flowers.id')
                        ->where('gfm.member_id', '=', $loggedInUser);
                    })
                    ->where(array('group_flowers.type' => 1, 'group_flowers.status' => 1, 'group_flowers.deleted_at' => null));
            //->get();
            try {
                $groups = $groups->paginate($limit);
            } catch (NotFoundException $e) {
                $groups = array();
            }
            // dd(DB::getQueryLog());
            // echo "<pre>";print_r($groups);die;

            $invitable_users = User::where(array('status' => 1))->get();
            $data = array(
                "title" => 'Group Pool',
                "groups" => $groups,
                "invitable_users" => $invitable_users,
            );
            return view('frontend.group.group_pool')->with($data);
        } else {
            return redirect('/login?authRedirect=group-pool');
        }
    }

    public function create() {
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $myPlan = getUserSubscriptionDetails($loggedInUser);
            if ($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] > 0) {

                $users = User::where(array('status' => 1, 'deleted_at' => null, ['id', '!=', $loggedInUser]))->get();

                $user_flowers = Group::where(array('user_id' => $loggedInUser, 'parent_id' => 0, 'status' => 1, 'deleted_at' => null, 'type' => 2))->get();
                $data = array(
                    'users' => $users,
                    'user_flowers' => $user_flowers
                );
                return view('frontend.group.create')->with($data);
            } else if ($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] <= 0) {
                Session::flash('message', 'Your subscription plan has expired, please buy a new one to create groups');
                Session::flash('alert-class', 'alert-danger');
                return redirect('/subscription_list');
            } else {
                Session::flash('message', 'Please buy a subscription plan to create groups.');
                Session::flash('alert-class', 'alert-danger');
                return redirect('/subscription_list');
            }
        } else {
            return redirect('/login?authRedirect=create-group');
        }
    }

    public function edit($id) {
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            $id = Crypt::decryptString($id);
            $users = User::where(array('status' => 1, 'deleted_at' => null, ['id', '!=', $loggedInUser]))->get();

            $user_flowers = Group::where(array('user_id' => $loggedInUser, 'parent_id' => 0, 'status' => 1, 'deleted_at' => null, 'type' => 2))->get();
            $result = Group::where(array('id' => $id, 'user_id' => $loggedInUser))->first();
            $data = array(
                'users' => $users,
                'user_flowers' => $user_flowers,
                'group_details' => $result
            );
            // dd($data);
            return view('frontend.group.create')->with($data);
        } else {
            return redirect('/login?authRedirect=create-group');
        }
    }

    public function store(Request $request) {
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $user_id = $user_auth->id;
            $myPlan = getUserSubscriptionDetails($user_id);

            if ($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] > 0) {
                $post = $request->all();
                //print_r($post);die;
                $validator = Validator::make($post, [
                            'name' => 'required',
                ]);
                if ($post['privacy'] == 0) {
                    $validator = Validator::make($post, [
                                'password' => 'required',
                    ]);
                }

                if ($validator->passes()) {
                    $uniqueId = generateUniqueGroupFlowerId();

                    $destinationPath = 'public/uploads/group';

                    if (!empty($post['id'])) {
                        $group = Group::find(Crypt::decryptString($post['id']));
                        if (!empty($post['group_image'])) {

                            if (!empty($group->image)) {

                                $path = $destinationPath . '/' . $group->image;
                                if (file_exists($path)) {
                                    unlink("$path");
                                }
                            }

                            $image = $post['group_image'];
                            $group_image_name = time() . rand(1, 10000) . '.' . $image->getClientOriginalExtension();
                            $image->move($destinationPath, $group_image_name);
                        } else {
                            $group_image_name = $group->image;
                        }

                        $group->name = $post['name'];
                        $group->image = $group_image_name;
                        $group->description = $post['description'];
                        $group->user_id = $user_id;
                        $group->status = 1;
                        $group->privacy = $post['privacy'];
                        // $group->group_flower_unique_id=$uniqueId;
                        // $group->parent_id=$post['parent_id'];
                        if ($post['privacy'] == 0) {
                            $group->password = $post['password'];
                        } else {
                            $group->password = null;
                        }
                        if ($group->save()) {
                            Session::flash('message', 'Group updated successfully');
                            Session::flash('alert-class', 'alert-success');
                            return response()->json(['status' => true, 'message' => 'Group updated successfully.']);
                        } else {
                            return response()->json([
                                        'status' => 'invalid',
                                        'errors' => $validator->getMessageBag()->toArray()
                            ]);
                        }
                    } else {
                        if (!empty($post['group_image'])) {

                            $image = $post['group_image'];
                            $group_image_name = time() . rand(1, 10000) . '.' . $image->getClientOriginalExtension();
                            $image->move($destinationPath, $group_image_name);
                        } else {
                            $group_image_name = "";
                        }

                        $group = new Group();

                        $group->name = $post['name'];
                        $group->image = $group_image_name;
                        $group->description = $post['description'];
                        $group->user_id = $user_id;
                        $group->status = 1;
                        $group->privacy = $post['privacy'];
                        $group->group_flower_unique_id=$uniqueId;
                        // $group->parent_id=$post['parent_id'];
                        if ($post['privacy'] == 0) {
                            $group->password = $post['password'];
                        }

                        if ($group->save()) {
                            $insertedId = $group->id;
                            if (!empty($post['parent_id'])) {
                                $user_flowers = Group::find($post['parent_id']);
                                $user_flowers->parent_id = $insertedId;
                                $user_flowers->save();
                            }
                            if (!empty($post['group_members'])) {
                                $idCount = count($post['group_members']);
                                if ($idCount > 0) {
                                    for ($i = 0; $i < $idCount; $i++) {
                                        $gfm = new GroupFlowersMembers();

                                        $gfm->group_flower_id = $insertedId;
                                        $gfm->member_id = $post['group_members'][$i];
                                        $gfm->sent_by = $user_id;
                                        $gfm->status = 1;
                                        $gfm->position_id = 0;

                                        if ($gfm->save()) {
                                            $id = $gfm->id;
                                            $details = GroupFlowersMembers::with(['userGroupFlower', 'groupFlowerUser'])->where('id', $id)->first();
                                            if (!empty($details)) {
                                                $details = $details->toArray();
                                            }

                                            $email = $details['group_flower_user']["email"];
                                            $first_name = $details['group_flower_user']['first_name'];
                                            $password = $details['user_group_flower']['password'];
                                            $link = action([GroupController::class, 'getGroupJoinRequests']); //url('group_invitation_accept'.'/'.Crypt::encryptString($id));

                                            try {
                                                Mail::send('layouts.mailer.groupinvite', ['first_name' => $first_name, 'email' => $email, 'password' => $password, 'link' => $link], function($message) use ($email) {
                                                    $message->to($email)->subject('Invitation on LOADUS Group');
                                                }
                                                );
                                            } catch (\Exception $e) {
                                                // $message_err=$e->getMessage();
                                                // print_r($message_err);exit;
                                                $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
                                            }

                                            /** Add & Send Notification Start * */
                                            $notification = array(
                                                'send_by' => $user_id,
                                                'send_to' => $post['group_members'][$i],
                                                'group_flower_id' => $insertedId,
                                                'object_id' => $id,
                                                'object_type' => 'groupinvite',
                                                'description' => 'has invited you to become member on group ' . $details['user_group_flower']['name'],
                                            );
                                            Notification::create($notification);
                                            /** Add & Send Notification End * */
                                        }
                                    }
                                }
                            }

                            Session::flash('message', 'Group created successfully');
                            Session::flash('alert-class', 'alert-success');
                            return response()->json(['status' => true, 'message' => 'Group created successfully.']);
                        }
                    }
                } else {

                    return response()->json([
                                'status' => 'invalid',
                                'errors' => $validator->getMessageBag()->toArray()
                    ]);
                }
            } else if ($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] <= 0) {
                Session::flash('message', 'Your subscription plan has expired, please buy a new one to create groups');
                Session::flash('alert-class', 'alert-danger');
                return redirect('/subscription_list');
            } else {
                Session::flash('message', 'Please buy a subscription plan to create groups.');
                Session::flash('alert-class', 'alert-danger');
                return redirect('/subscription_list');
            }
        } else {
            return redirect('/login?authRedirect=create-group');
        }
    }

    /*     * *----   Listing of logged-In users created groups -----** */

    public function created_groups() {
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $total_group_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
                  WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `is_accepted` = 1
                  ORDER BY `gfm`.`created_at` desc) as `total_group_members`");

            $total_group_flowers = DB::raw("( SELECT count(id) FROM `group_flowers` as `gf` WHERE `gf`.`parent_id` = `group_flowers`.`id` AND `gf`.`status` = 1 AND `gf`.`deleted_at` is null ORDER BY `gf`.`created_at` desc) as `total_group_flowers`");

            $created_groups = Group::where(array('user_id' => $loggedInUser, 'parent_id' => 0, 'status' => 1, 'deleted_at' => null, 'type' => 1))->select('*', $total_group_members, $total_group_flowers)->get();
            $invitable_users = User::where(array('status' => 1))->get();

            $myPlan = getUserSubscriptionDetails($loggedInUser);

            $data = array(
                'created_groups' => $created_groups,
                'invitable_users' => $invitable_users,
                'myPlan' => $myPlan,
            );
            return view('frontend.group.created_groups')->with($data);
        } else {
            return redirect('/login?authRedirect=created-groups');
        }
    }

    /*     * * ----- Logged in users joined groups list ---- * */

    public function joined_groups() {
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $total_group_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
                  WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `is_accepted` = 1
                  ORDER BY `gfm`.`created_at` desc) as `total_group_members`");

            $total_group_flowers = DB::raw("( SELECT count(id) FROM `group_flowers` as `gf`
                  WHERE `gf`.`parent_id` = `group_flowers`.`id`
                  ORDER BY `gf`.`created_at` desc) as `total_group_flowers`");

            $joined_groups = DB::table('group_flowers')
                    ->select('*', $total_group_members, $total_group_flowers)
                    ->join('group_flowers_members', 'group_flowers.id', '=', 'group_flowers_members.group_flower_id')
                    ->where(array('group_flowers.parent_id' => 0, 'group_flowers.status' => 1, 'group_flowers.deleted_at' => null, 'group_flowers.type' => 1))
                    ->where(array('group_flowers_members.member_id' => $loggedInUser, 'group_flowers_members.is_accepted' => 1))
                    ->get();
            // dd($joined_groups);
            $data = array(
                'title' => 'Joined Groups',
                'joined_groups' => $joined_groups
            );
            return view('frontend.group.joined_groups')->with($data);
        } else {
            return redirect('/login?authRedirect=joined_groups');
        }
    }

    // Send request to other users to join group

    public function group_invitation_old(Request $request){

        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $user_id = $user_auth->id;

            $post = $request->all();
            $group_flower_id = Crypt::decryptString($post['invite_group_id']);
            // dd($post);
            $group = Group::where(array('id' => $group_flower_id, 'user_id' => $user_id, 'type' => 1))->first();

            if (!empty($group)) {
                $gfm = new GroupFlowersMembers();

                $gfm->group_flower_id = $group_flower_id;
                $gfm->member_id = $post['userSelect'];
                $gfm->sent_by = $user_auth->id;
                $gfm->status = 1;
                $gfm->position_id = 0;

                if ($gfm->save()) {
                    $id = $gfm->id;
                    $details = GroupFlowersMembers::with(['userGroupFlower', 'groupFlowerUser'])->where('id', $id)->first();
                    if (!empty($details)) {
                        $details = $details->toArray();
                    }

                    $email = $details['group_flower_user']["email"];
                    $first_name = $details['group_flower_user']['first_name'];
                    $password = $details['user_group_flower']['password'];
                    $link = action([GroupController::class, 'getGroupJoinRequests']); //url('group_invitation_accept'.'/'.Crypt::encryptString($id));

                    try {
                        Mail::send('layouts.mailer.groupinvite', ['first_name' => $first_name, 'email' => $email, 'password' => $password, 'link' => $link], function($message) use ($email) {
                            $message->to($email)->subject('Invitation on LOADUS Group');
                        }
                        );
                    } catch (\Exception $e) {
                        // $message_err=$e->getMessage();
                        // print_r($message_err);exit;
                        $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
                    }

                    /** Add & Send Notification Start * */
                    $notification = array(
                        'send_by' => $user_id,
                        'send_to' => $details['group_flower_user']['id'],
                        'group_flower_id' => $group_flower_id,
                        'object_id' => $id,
                        'object_type' => 'groupinvite',
                        'description' => 'has invited you to become member on Group '.substr($group->name, 0, 10).'...',
                    );
                    
                    Notification::create($notification);

                    /** Add & Send Notification End **/
                    Session::flash('message', 'Group invitation sent successfully');
                    Session::flash('alert-class', 'alert-success');
                    return response()->json(['status' => true, 'message' => 'Group invitation sent successfully.']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Group not found.']);
            }
        } else {
            return redirect('/login?authRedirect=created-groups');
        }
    }


    // Send request to other users to join group
    public function group_invitation(Request $request){

        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $user_id=$user_auth->id;

            $post=$request->all();
            $group_flower_id = Crypt::decryptString($post['invite_group_id']);
            $user_email = trim($post['email']);

            if(!empty($user_email)){
                $checkUserDetails = isUserExists($user_email);
                //dd($checkUserDetails);
                $group = Group::where(array('id'=>$group_flower_id, 'user_id'=>$user_id, 'type'=>1))->first();
                if(!empty($checkUserDetails)){

                    $invite_member_id = $checkUserDetails->id;
                    $group = Group::where(array('id'=>$group_flower_id, 'user_id'=>$user_id, 'type'=>1))->first();
            
                    if(!empty($group)){
                        if($group->user_id != $invite_member_id){

                            $isGroupFlowerMember = GroupFlowersMembers::where(array('member_id'=>$invite_member_id, 'group_flower_id'=> $group_flower_id))->first();

                            if(empty($isGroupFlowerMember)){
                                $gfm = new GroupFlowersMembers();

                                $gfm->group_flower_id = $group_flower_id;
                                $gfm->member_id = $invite_member_id;
                                $gfm->sent_by = $user_auth->id;
                                $gfm->status = 1;
                                $gfm->position_id = 0;

                                if($gfm->save()){
                                    $id = $gfm->id;
                                    $details = GroupFlowersMembers::with(['userGroupFlower','groupFlowerUser'])->where('id',$id)->first();
                                    if(!empty($details)){
                                        $details = $details->toArray();
                                    }

                                    $email = $details['group_flower_user']["email"];
                                    $first_name = $details['group_flower_user']['first_name'];
                                    $password = $details['user_group_flower']['password'];
                                    $link = action([GroupController::class, 'getGroupJoinRequests']);//url('group_invitation_accept'.'/'.Crypt::encryptString($id));

                                    try{
                                        Mail::send('layouts.mailer.groupinvite',['first_name'=>$first_name,'email'=>$email,'password'=>$password,'link'=>$link], function($message) use ($email) {
                                                $message->to($email)->subject('Invitation on LOADUS Group');
                                            }
                                        );
                                    }catch(\Exception $e){
                                        // $message_err=$e->getMessage();
                                        // print_r($message_err);exit;
                                        $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
                                    }

                                    /** Add & Send Notification Start **/
                                    $notification = array(
                                        'send_by' => $user_id,
                                        'send_to' => $details['group_flower_user']['id'],
                                        'group_flower_id' => $group_flower_id,
                                        'object_id' => $id,
                                        'object_type' => 'groupinvite',
                                        'description' => 'has invited you to become member on Group '.substr($group->name, 0, 10).'...',
                                    );
                                    
                                    Notification::create($notification);
                                    /** Add & Send Notification End **/

                                    Session::flash('message', 'Group invitation sent successfully');
                                    Session::flash('alert-class', 'alert-success'); 
                                    return response()->json(['status'=>true,'message'=>'Group invitation sent successfully.']);
                                }
                            }else if(!empty($isGroupFlowerMember) && $isGroupFlowerMember->is_accepted == 1){
                                Session::flash('message', 'User is already member of group.');
                                Session::flash('alert-class', 'alert-success'); 
                                return response()->json(['status'=>true,'message'=>'User is already member of group.']);
                            }else{
                                Session::flash('message', 'User is already invited.');
                                Session::flash('alert-class', 'alert-success'); 
                                return response()->json(['status'=>true,'message'=>'User is already invited.']);
                            }
                        }else{
                            Session::flash('message', 'Group already belongs to you...please invite other users.');
                            Session::flash('alert-class', 'alert-success'); 
                            return response()->json(['status'=>true,'message'=>'Group already belongs to you...please invite other users.']);
                        }
                        
                        
                    }else{
                        return response()->json(['status'=>false,'message'=>'Group not found.']);
                    }
                }else{
                    $email = $user_email;
                    $first_name = (trim($post['invite_name']))? trim($post['invite_name']) : $user_email;
                    $logged_in_user = $user_auth->first_name." ".$user_auth->last_name;
                    $link = action([GroupController::class, 'group_pool']);
                    try{
                        Mail::send('layouts.mailer.groupuserinvite',['first_name'=>$first_name,'email'=>$email,'logged_in_user'=>$logged_in_user,'link'=>$link], function($message) use ($email) {
                                $message->to($email)->subject('Invitation on LOADUS Group');
                            }
                        );
                        $arr = ['status'=>true,'message'=>'Invitation sent successfully.'];
                    }catch(\Exception $e){
                        // $message_err=$e->getMessage();
                        // print_r($message_err);exit;
                        $arr = array('message' => 'Your email is not validated use another', 'status' => false);
                    }
                    Session::flash('message', $arr['message']);
                    Session::flash('alert-class', ($arr['message'] == true) ? 'alert-success' : 'alert-danger');
                    return response()->json($arr);
                }
            }else{
                return redirect('/created-groups');
            }
            // dd($post);
        }else{
            return redirect('/login?authRedirect=created-groups');
        }

    }


    /*** Accept Group Member Request Start ***/
    public function acceptGroupMember(Request $request){

        $post = $request->all();
        $group_flower_id = Crypt::decryptString($post['group_id']);
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $user_id = $user_auth->id; //logged in user

            $group = Group::find($group_flower_id);

            if (!empty($group)) {

                $groupFlowerMembers = GroupFlowersMembers::where(array('group_flower_id' => $group_flower_id, 'member_id' => $user_id))->first();

                if (!empty($groupFlowerMembers) > 0) {
                    if ($groupFlowerMembers->is_accepted == 1) {
                        $redirectUrl = '/group-pool';
                        $msg = 'You have already accepted the request to become group member!!';
                        Session::flash('message', $msg);
                        Session::flash('alert-class', 'alert-success');
                        return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
                    } else {

                        if ($group->privacy == 0) {
                            $validator = Validator::make($post, [
                                        'password' => 'required',
                            ]);

                            if ($group->password == $post['password']) {
                                $groupFlowerMembers->is_accepted = 1;
                                $groupFlowerMembers->save();
                                $redirectUrl = "/accept-group-member-request/" . $group_flower_id;
                                $msg = 'Request accepted successfully!!';
                                Session::flash('message', $msg);
                                Session::flash('alert-class', 'alert-success');
                                return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
                            } else {
                                $redirectUrl = "/accept-group-member-request/" . $group_flower_id;
                                $msg = 'Please enter correct password!!';
                                Session::flash('message', $msg);
                                Session::flash('alert-class', 'alert-success');
                                return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
                            }
                        } else {
                            $groupFlowerMembers->is_accepted = 1;
                            $groupFlowerMembers->save();
                            $redirectUrl = "/accept-group-member-request/" . $group_flower_id;
                            $msg = 'Request accepted successfully!!';
                            Session::flash('message', $msg);
                            Session::flash('alert-class', 'alert-success');
                            return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
                        }
                    }
                } else {
                    $redirectUrl = "/login?authRedirect=accept-group-member-request/" . $group_flower_id;
                    $msg = 'Request expired!!';
                    Session::flash('message', $msg);
                    Session::flash('alert-class', 'alert-success');
                    return response()->json(['status' => true, 'message' => 'Request expired!!', 'redirectUrl' => $redirectUrl]);
                }
            }
        } else {
            return redirect('/login?authRedirect=accept-group-member-request/' . $group_flower_id);
        }
    }

    public function details($id = null) {

        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            // dd($loggedInUser);
            $id = Crypt::decryptString($id);

            $total_group_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
                  WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `is_accepted` = 1
                  ORDER BY `gfm`.`created_at` desc) as `total_group_members`");

            $total_group_flowers = DB::raw("( SELECT count(id) FROM `group_flowers` as `gf`
                  WHERE `gf`.`parent_id` = `group_flowers`.`id`
                  ORDER BY `gf`.`created_at` desc) as `total_group_flowers`");

            $group_details = Group::with(['groupowner'])->select('*', $total_group_members, $total_group_flowers)->where(array('id' => $id, 'type' => 1))->first();

            if (!empty($group_details)) {
                
            } else {
                Session::flash('message', 'Group not found....please try again!!');
                Session::flash('alert-class', 'alert-danger');
                return redirect('joined-groups');
            }

            $is_member = DB::raw("( SELECT 1 FROM `group_flowers_members` as `gfm` WHERE `gfm`.`member_id` = " . $loggedInUser . " AND `gfm`.`group_flower_id` = `group_flowers`.`id`) as `is_member`");

            $earth_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
                  WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `position_id` = 2
                  ORDER BY `gfm`.`created_at` desc) as `earth_members`");

            $air_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm`
            WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `position_id` = 3
            ORDER BY `gfm`.`created_at` desc) as `air_members`");

            $fire_members = DB::raw("( SELECT count(id) FROM `group_flowers_members` as `gfm` WHERE `gfm`.`group_flower_id` = `group_flowers`.`id` AND `position_id` = 4 ORDER BY `gfm`.`created_at` desc) as `fire_members`");
            //  DB::enableQueryLog();

            $group_flowers = DB::table('group_flowers')
                    ->select('*', 'group_flowers.id as group_id', $fire_members, $earth_members, $air_members, $total_group_flowers, $is_member)
                    ->leftJoin('group_flowers_members AS gfm', function($join) use($loggedInUser) {
                        $join->on('gfm.group_flower_id', '=', 'group_flowers.id')
                        ->where('gfm.member_id', '=', $loggedInUser);
                    })
                    ->where(array('group_flowers.parent_id' => $id, 'group_flowers.type' => 2, 'group_flowers.status' => 1, 'group_flowers.deleted_at' => null))
                    ->get();

            $total_positions = Position::where('id', '!=', '1')->get();

            $invitable_users = User::where(array('status' => 1))->get();

            $data = array(
                'title' => 'Group Details',
                'group_details' => $group_details,
                'group_flowers' => $group_flowers,
                'total_positions' => $total_positions,
                'invitable_users' => $invitable_users,
            );
            // dd(DB::getQueryLog());
            //  dd($data);
            return view('frontend.group.details')->with($data);
        } else {
            return redirect('/login?authRedirect=group-details/' . $id);
        }
    }

    public function getflowerpositions(Request $request) {
        $post = $request->all();
        // dd($post);
        $id = Crypt::decryptString($post['id']);
        $details = Group::with(['groupflowermembers'])->where(array('id' => $id, 'type' => 2))->first();
        $total_positions = Position::select(['id', 'name'])->where('id', '!=', '1')->get();

        if (!empty($details)) {

            if (!empty($details->groupflowermembers)) {
                foreach ($details->groupflowermembers as $flower_positons) {

                    if (($flower_positons->position_id == 2) && ($flower_positons->total_positions >= 2)) {

                        unset($total_positions[0]);
                    } else if (($flower_positons->position_id == 3) && ($flower_positons->total_positions >= 4)) {

                        unset($total_positions[1]);
                    } else if (($flower_positons->position_id == 4) && ($flower_positons->total_positions >= 8)) {

                        unset($total_positions[2]);
                    }
                }
                // dd($total_positions);
            }
        }
        $html = '';
        if (!empty($total_positions)) {
            $html = '<option data-display="Select Tier" selected disabled> Select Tier </option>';
            foreach ($total_positions as $positions) {
                $html .= '<option value="' . $positions->id . '" >' . $positions->name . '</option>';
            }
        }
        // echo $html;die;
        return json_encode($html);
    }

    /** Get Users which are not presented or invited for the particular flower */
    public function getInvitableFlowerMembers(Request $request) {
        $post = $request->all();

        $user_auth = Auth::guard('user')->user();
        $loggedInUser = $user_auth->id;
        // dd($post);
        // DB::enableQueryLog();
        $id = Crypt::decryptString($post['id']);
        $invitable_users = DB::table('users')
                ->join('tbl_user_subscriptions', 'tbl_user_subscriptions.user_id', '=', 'users.id')
                ->select('users.*')
                ->where('users.id', '!=', $loggedInUser)
                ->whereNotExists(function ($query) use($id) {
                    $query->select(DB::raw(1))
                    ->from('group_flowers_members')
                    ->whereRaw('group_flowers_members.member_id = users.id')
                    ->whereRaw('group_flowers_members.group_flower_id=' . $id);
                })
                ->get();
        // dd(DB::getQueryLog());

        $html = '';
        if (!empty($invitable_users)) {
            $html = '<option data-display="Select User" selected disabled> Select User </option>';
            foreach ($invitable_users as $users) {
                $html .= '<option value="' . $users->id . '" >' . $users->email . '</option>';
            }
        }
        return json_encode($html);
    }

    /** Get Users which are not presented or invited for the particular Group */
    public function getInvitableGroupMembers(Request $request) {
        $post = $request->all();
        $user_auth = Auth::guard('user')->user();
        $loggedInUser = $user_auth->id;

        $id = Crypt::decryptString($post['id']);


        $invitable_users = DB::table('users')
                ->join('tbl_user_subscriptions', 'tbl_user_subscriptions.user_id', '=', 'users.id')
                ->select('users.*')
                ->where('users.id', '!=', $loggedInUser)
                ->whereNotExists(function ($query) use($id) {
                    $query->select(DB::raw(1))
                    ->from('group_flowers_members')
                    ->whereRaw('group_flowers_members.member_id = users.id')
                    ->whereRaw('group_flowers_members.group_flower_id=' . $id);
                })
                ->get();

        $html = '';
        if (!empty($invitable_users)) {
            $html = '<option data-display="Select User" selected disabled> Select User </option>';
            foreach ($invitable_users as $users) {
                $html .= '<option value="' . $users->id . '" >' . $users->email . '</option>';
            }
        }
        return json_encode($html);
    }

    /*     * ---   Flower Join request from user to flower admin     ---* */

    public function flower_join_request(Request $request) {
        $post = $request->all();
        // dd($post);
        $group_flower_id = Crypt::decryptString($post['flower_id']);
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
        }
        $details = Group::where(array('id' => $group_flower_id, 'type' => 2))->first();
        if (!empty($details)) {
            $water_user = Group::where(array('id' => $group_flower_id, 'type' => 2, 'user_id' => $loggedInUser))->first();

            $membersonposition = GroupFlowersMembers::where(array('group_flower_id' => $group_flower_id, 'position_id' => $post['position_id']))->get()->count();

            $is_member = GroupFlowersMembers::where(array('group_flower_id' => $group_flower_id, 'member_id' => $loggedInUser))->first();
        }
        $total_positions = Position::where(array('id' => $post['position_id']))->first();

        if (empty($water_user)) {
            if (empty($is_member)) {
                // dd($total_positions->total_positions);
                if ($total_positions->total_positions > $membersonposition) {
                    $gfm = new GroupFlowersMembers();

                    $gfm->group_flower_id = $group_flower_id;
                    $gfm->member_id = $user_auth->id;
                    $gfm->sent_by = $user_auth->id;
                    $gfm->position_id = $post['position_id'];
                    $gfm->status = 1;
                    $gfm->is_accepted = 0;

                    if ($gfm->save()) {
                        $id = $gfm->id;
                        // $fulldetails = GroupFlowersMembers::with(['userGroupFlower','groupFlowerUser'])->where('id',$id)->first();
                        $fulldetails = Group::with(['groupowner'])->where('id', $group_flower_id)->first();
                        if (!empty($fulldetails)) {
                            $fulldetails = $fulldetails->toArray();
                        }
                        // dd($fulldetails->toArray());
                        $email = $fulldetails['groupowner']["email"];
                        $first_name = $fulldetails['groupowner']['first_name'];
                        $password = ''; //$fulldetails['user_group_flower']['password'];
                        $link = action([FlowerController::class, 'getFlowerJoinRequests']); //url('group_invitation_accept'.'/'.Crypt::encryptString($id));

                        try {
                            Mail::send('layouts.mailer.flowerjoin', ['first_name' => $first_name, 'email' => $email, 'password' => $password, 'link' => $link], function($message) use ($email) {
                                $message->to($email)->subject('Flower Join Request on LOADUS ');
                            }
                            );
                        } catch (\Exception $e) {
                            // $message_err=$e->getMessage();
                            // print_r($message_err);exit;
                            $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
                        }

                        /** Add & Send Notification Start * */
                        $notification = array(
                            'send_by' => $loggedInUser,
                            'send_to' => $fulldetails['groupowner']['id'],
                            'group_flower_id' => $group_flower_id,
                            'object_id' => $id,
                            'object_type' => 'flowerjoin',
                            'description' => 'has request you to become member on your flower ' . $fulldetails['name'],
                        );
                        Notification::create($notification);

                        /** Add & Send Notification End * */
                        Session::flash('message', 'flower join request sent successfully');
                        Session::flash('alert-class', 'alert-success');
                        return response()->json(['status' => true, 'message' => 'Flower invitation sent successfully.']);
                    }
                } else {
                    Session::flash('message', 'Positions quota over!!');
                    Session::flash('alert-class', 'alert-danger');
                    return response()->json(['status' => true, 'message' => 'Positions quota over!!']);
                }
            } else {
                Session::flash('message', 'You are already a member!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json(['status' => true, 'message' => 'You are already a member!']);
            }
        } else {
            Session::flash('message', 'You can apply to your own flower!!');
            Session::flash('alert-class', 'alert-danger');
            return response()->json(['status' => true, 'message' => 'You can apply to your own flower!']);
        }
    }

    /*     * ---   Flower Invite user from flower admin to User     ---* */


    /**---   Flower Invite user from flower admin to User     ---**/
    public function flower_invite_request_old(Request $request){

        $post = $request->all();
        // dd($post);
        $group_flower_id = Crypt::decryptString($post['invite_flower_id']);
        $invited_user_id = $post['userSelect'];
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
        }
        $details = Group::where(array('id' => $group_flower_id, 'type' => 2))->first();
        if (!empty($details)) {
            $water_user = Group::where(array('id' => $group_flower_id, 'type' => 2, 'user_id' => $invited_user_id))->first();

            $membersonposition = GroupFlowersMembers::where(array('group_flower_id' => $group_flower_id, 'position_id' => $post['position_id']))->get()->count();

            $is_member = GroupFlowersMembers::where(array('group_flower_id' => $group_flower_id, 'member_id' => $invited_user_id))->first();
        }
        $total_positions = Position::where(array('id' => $post['position_id']))->first();

        if (empty($water_user)) {
            if (empty($is_member)) {
                // dd($total_positions->total_positions);
                if ($total_positions->total_positions > $membersonposition) {
                    $gfm = new GroupFlowersMembers();

                    $gfm->group_flower_id = $group_flower_id;
                    $gfm->member_id = $invited_user_id;
                    $gfm->sent_by = $user_auth->id;
                    $gfm->position_id = $post['position_id'];
                    $gfm->status = 1;
                    $gfm->is_accepted = 0;

                    if ($gfm->save()) {
                        $id = $gfm->id;
                        $fulldetails = GroupFlowersMembers::with(['userGroupFlower', 'groupFlowerUser'])->where('id', $id)->first();
                        if (!empty($fulldetails)) {
                            $fulldetails = $fulldetails->toArray();
                        }
                        // dd($fulldetails->toArray());
                        $email = $fulldetails['group_flower_user']["email"];
                        $first_name = $fulldetails['group_flower_user']['first_name'];
                        $password = $fulldetails['user_group_flower']['password'];
                        $link = action([FlowerController::class, 'getFlowerJoinRequests']); //url('group_invitation_accept'.'/'.Crypt::encryptString($id));

                        try {
                            Mail::send('layouts.mailer.flowerinvite', ['first_name' => $first_name, 'email' => $email, 'password' => $password, 'link' => $link], function($message) use ($email) {
                                $message->to($email)->subject('Flower Invite Request on LOADUS');
                            }
                            );
                        } catch (\Exception $e) {
                            // $message_err=$e->getMessage();
                            // print_r($message_err);exit;
                            $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
                        }

                        /** Add & Send Notification Start * */
                        $notification = array(
                            'send_by' => $loggedInUser,
                            'send_to' => $fulldetails['group_flower_user']['id'],
                            'group_flower_id' => $group_flower_id,
                            'object_id' => $id,
                            'object_type' => 'flowerinvite',
                            'description' => 'has invited you to become member on his flower ' . $fulldetails['user_group_flower']['name'],
                        );
                        Notification::create($notification);

                        /** Add & Send Notification End * */
                        Session::flash('message', 'User invite sent successfully');
                        Session::flash('alert-class', 'alert-success');
                        return response()->json(['status' => true, 'message' => 'Flower invitation sent successfully.']);
                    }
                } else {
                    Session::flash('message', 'Positions quota over!!');
                    Session::flash('alert-class', 'alert-danger');
                    return response()->json(['status' => true, 'message' => 'Positions quota over!!']);
                }
            } else {
                Session::flash('message', 'You are already a member!!');
                Session::flash('alert-class', 'alert-success');
                return response()->json(['status' => true, 'message' => 'You are already a member!!']);
            }
        } else {
            Session::flash('message', 'You can not apply to your own flower!!');
            Session::flash('alert-class', 'alert-success');
            return response()->json(['status' => true, 'message' => 'You can not apply to your own flower!!']);
        }
    }


    /**---   Flower Invite user from flower admin to User     ---**/
    public function flower_invite_request_olds(Request $request){
        $post = $request->all();
        // dd($post);
        $group_flower_id = Crypt::decryptString($post['invite_flower_id']);
        // $invited_user_id = $post['userSelect'];
        if(Auth::guard('user')->check()){
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            $user_email = trim($post['email']);

            if(!empty($user_email)){
                $checkUserDetails = isUserExists($user_email);
                if(!empty($checkUserDetails)){
                    $invited_user_id = $checkUserDetails->id;

                    $details = Group::where(array('id'=>$group_flower_id,'type'=>2))->first();
                    if(!empty($details)){
                        $water_user = Group::where(array('id'=>$group_flower_id,'type'=>2, 'user_id'=>$invited_user_id))->first();

                        $membersonposition = GroupFlowersMembers::where(array('group_flower_id'=>$group_flower_id, 'position_id'=>$post['position_id']))->get()->count();
                        
                        $is_member = GroupFlowersMembers::where(array('group_flower_id'=>$group_flower_id, 'member_id'=>$invited_user_id))->first();

                        $total_positions = Position::where(array('id'=>$post['position_id']))->first();

                        if(empty($water_user)){
                            if(empty($is_member)){
                                // dd($total_positions->total_positions);
                                if($total_positions->total_positions > $membersonposition){
                                    $gfm = new GroupFlowersMembers();

                                    $gfm->group_flower_id = $group_flower_id;
                                    $gfm->member_id = $invited_user_id;
                                    $gfm->sent_by = $user_auth->id;
                                    $gfm->position_id = $post['position_id'];
                                    $gfm->status = 1;
                                    $gfm->is_accepted = 0;

                                    if($gfm->save()){
                                        $id = $gfm->id;
                                        $fulldetails = GroupFlowersMembers::with(['userGroupFlower','groupFlowerUser'])->where('id',$id)->first();
                                        if(!empty($fulldetails)){
                                            $fulldetails = $fulldetails->toArray();
                                        }
                                        // dd($fulldetails->toArray());
                                        $email = $fulldetails['group_flower_user']["email"];
                                        $first_name = $fulldetails['group_flower_user']['first_name'];
                                        $password = $fulldetails['user_group_flower']['password'];
                                        $link = action([FlowerController::class, 'getFlowerJoinRequests']);//url('group_invitation_accept'.'/'.Crypt::encryptString($id));
                    
                                        try{
                                            Mail::send('layouts.mailer.flowerinvite',['first_name'=>$first_name,'email'=>$email,'password'=>$password,'link'=>$link], function($message) use ($email) {
                                                    $message->to($email)->subject('Flower Invite Request on LOADUS');
                                                }
                                            );
                                        }catch(\Exception $e){
                                            // $message_err=$e->getMessage();
                                            // print_r($message_err);exit;
                                            $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
                                        }

                                        /** Add & Send Notification Start **/
                                        $notification = array(
                                            'send_by' => $loggedInUser,
                                            'send_to' => $fulldetails['group_flower_user']['id'],
                                            'group_flower_id' => $group_flower_id,
                                            'object_id' => $id,
                                            'object_type' => 'flowerinvite',
                                            'description' => 'has invited you to become member on his flower '.$fulldetails['user_group_flower']['name'],
                                        );
                                        Notification::create($notification);
                                        
                                        /** Add & Send Notification End **/
                                        Session::flash('message', 'User invite sent successfully');
                                        Session::flash('alert-class', 'alert-success'); 
                                        return response()->json(['status'=>true,'message'=>'Flower invitation sent successfully.']);
                                    }
                                }else{
                                    Session::flash('message', 'Positions quota over!!');
                                    Session::flash('alert-class', 'alert-danger'); 
                                    return response()->json(['status'=>true,'message'=>'Positions quota over!!']);
                                    
                                }
                            }else{
                                Session::flash('message', 'Member already added or invited on flower!!');
                                Session::flash('alert-class', 'alert-success'); 
                                return response()->json(['status'=>true,'message'=>'Member already added or invited on flower!!']);
                            }
                        }else{
                            Session::flash('message', 'You can not apply to your own flower!!');
                            Session::flash('alert-class', 'alert-success'); 
                            return response()->json(['status'=>true,'message'=>'You can not apply to your own flower!!']);
                        }

                    }else{
                        return response()->json(['status'=>false,'message'=>'Flower not found.']);
                    }
                }else{
                    $email = $user_email;
                    $first_name = (trim($post['invite_name']))? trim($post['invite_name']) : $user_email;
                    $logged_in_user = $user_auth->first_name." ".$user_auth->last_name;
                    $link = action([FlowerController::class, 'getFlowerJoinRequests']);
                    try{
                        Mail::send('layouts.mailer.floweruserinvite',['first_name'=>$first_name,'email'=>$email,'logged_in_user'=>$logged_in_user,'link'=>$link], function($message) use ($email) {
                                $message->to($email)->subject('Invitation on LOADUS Flower');
                            }
                        );
                        $arr = ['status'=>true,'message'=>'Invitation sent successfully.'];
                    }catch(\Exception $e){
                        // $message_err=$e->getMessage();
                        // print_r($message_err);exit;
                        $arr = array('message' => 'Your email is not validated use another', 'status' => false);
                    }
                    Session::flash('message', $arr['message']);
                    Session::flash('alert-class', ($arr['message'] == true) ? 'alert-success' : 'alert-danger');
                    return response()->json($arr);
                }
            }else{
                return redirect('/created-flowers');
            }
            
        }else{
            return redirect('/login?authRedirect=created-flowers');
        }
    }

    /**---   Flower Invite user from flower admin to User     ---**/
    public function flower_invite_request(Request $request){
        $post = $request->all();
        // dd($post);
        $group_flower_id = Crypt::decryptString($post['invite_flower_id']);
        // $invited_user_id = $post['userSelect'];
        if(Auth::guard('user')->check()){
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            $user_email = trim($post['email']);

            if(!empty($user_email)){
                $checkUserDetails = isUserExists($user_email);
                if(!empty($checkUserDetails)){
                    $invited_user_id = $checkUserDetails->id;

                    $details = Group::where(array('id'=>$group_flower_id,'type'=>2))->first();
                    if(!empty($details)){
                        $water_user = Group::where(array('id'=>$group_flower_id,'type'=>2, 'user_id'=>$invited_user_id))->first();

                        $membersonposition = GroupFlowersMembers::where(array('group_flower_id'=>$group_flower_id, 'position_id'=>$post['position_id']))->get()->count();
                        
                        $is_member = GroupFlowersMembers::where(array('group_flower_id'=>$group_flower_id, 'member_id'=>$invited_user_id))->first();

                        $total_positions = Position::where(array('id'=>$post['position_id']))->first();
                        if($details->is_locked == 0){
                            if(empty($water_user)){
                                if(empty($is_member)){
                                    // dd($total_positions->total_positions);
                                    if($details->flower_parent_id != null){
                                        if($post['position_id'] == 4 && $membersonposition == 0){
                                            $lockedFlower = Group::find($group_flower_id);
                                            $lockedFlower->is_locked = 1;
    
                                            if($lockedFlower->save()){
                                                /** Add & Send Notification Start **/
                                                $notification = array(
                                                    'send_by' => $loggedInUser,
                                                    'send_to' => $details->user_id,
                                                    'group_flower_id' => $group_flower_id,
                                                    'object_id' => $details->id,
                                                    'object_type' => 'flowerlock',
                                                    'description' => 'Your flower <b>'.$details->name.'</b> has been locked, please gift on other flower to resume sending invites on fire positions',
                                                );
                                                Notification::create($notification);
                                            }
    
                                        }  
                                    }
                                    if($total_positions->total_positions > $membersonposition){
                                        $gfm = new GroupFlowersMembers();
    
                                        $gfm->group_flower_id = $group_flower_id;
                                        $gfm->member_id = $invited_user_id;
                                        $gfm->sent_by = $user_auth->id;
                                        $gfm->position_id = $post['position_id'];
                                        $gfm->status = 1;
                                        $gfm->is_accepted = 0;
    
                                        if($gfm->save()){
                                            $id = $gfm->id;
                                            $fulldetails = GroupFlowersMembers::with(['userGroupFlower','groupFlowerUser'])->where('id',$id)->first();
                                            if(!empty($fulldetails)){
                                                $fulldetails = $fulldetails->toArray();
                                            }
                                            // dd($fulldetails->toArray());
                                            $email = $fulldetails['group_flower_user']["email"];
                                            $first_name = $fulldetails['group_flower_user']['first_name'];
                                            $password = $fulldetails['user_group_flower']['password'];
                                            $link = action([FlowerController::class, 'getFlowerJoinRequests']);//url('group_invitation_accept'.'/'.Crypt::encryptString($id));
                        
                                            try{
                                                Mail::send('layouts.mailer.flowerinvite',['first_name'=>$first_name,'email'=>$email,'password'=>$password,'link'=>$link], function($message) use ($email) {
                                                        $message->to($email)->subject('Flower Invite Request on LOADUS');
                                                    }
                                                );
                                            }catch(\Exception $e){
                                                // $message_err=$e->getMessage();
                                                // print_r($message_err);exit;
                                                $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
                                            }
    
                                            /** Add & Send Notification Start **/
                                            $notification = array(
                                                'send_by' => $loggedInUser,
                                                'send_to' => $fulldetails['group_flower_user']['id'],
                                                'group_flower_id' => $group_flower_id,
                                                'object_id' => $id,
                                                'object_type' => 'flowerinvite',
                                                'description' => 'has invited you to become member on his flower '.$fulldetails['user_group_flower']['name'],
                                            );
                                            Notification::create($notification);
                                            
                                            /** Add & Send Notification End **/
                                            Session::flash('message', 'User invite sent successfully');
                                            Session::flash('alert-class', 'alert-success'); 
                                            return response()->json(['status'=>true,'message'=>'Flower invitation sent successfully.']);
                                        }
                                    }else{
                                        Session::flash('message', 'Positions quota over!!');
                                        Session::flash('alert-class', 'alert-danger'); 
                                        return response()->json(['status'=>true,'message'=>'Positions quota over!!']);
                                        
                                    }
                                    
                                    
                                }else{
                                    Session::flash('message', 'Member already added or invited on flower!!');
                                    Session::flash('alert-class', 'alert-success'); 
                                    return response()->json(['status'=>true,'message'=>'Member already added or invited on flower!!']);
                                }
                            }else{
                                Session::flash('message', 'You can not apply to your own flower!!');
                                Session::flash('alert-class', 'alert-success'); 
                                return response()->json(['status'=>true,'message'=>'You can not apply to your own flower!!']);
                            }
                        }else{
                            Session::flash('message', 'Flower is locked, please gift on another flower to resume sending invitations to users.!!');
                            Session::flash('alert-class', 'alert-success'); 
                            return response()->json(['status'=>true,'message'=>'Flower is locked, please gift on another flower to resume sending invitations to users.']);
                        }
                    }else{
                        return response()->json(['status'=>false,'message'=>'Flower not found.']);
                    }
                }else{
                    $email = $user_email;
                    $first_name = (trim($post['invite_name']))? trim($post['invite_name']) : $user_email;
                    $logged_in_user = $user_auth->first_name." ".$user_auth->last_name;
                    $link = action([FlowerController::class, 'getFlowerJoinRequests']);
                    try{
                        Mail::send('layouts.mailer.floweruserinvite',['first_name'=>$first_name,'email'=>$email,'logged_in_user'=>$logged_in_user,'link'=>$link], function($message) use ($email) {
                                $message->to($email)->subject('Invitation on LOADUS Flower');
                            }
                        );
                        $arr = ['status'=>true,'message'=>'Invitation sent successfully.'];
                    }catch(\Exception $e){
                        // $message_err=$e->getMessage();
                        // print_r($message_err);exit;
                        $arr = array('message' => 'Your email is not validated use another', 'status' => false);
                    }
                    Session::flash('message', $arr['message']);
                    Session::flash('alert-class', ($arr['message'] == true) ? 'alert-success' : 'alert-danger');
                    return response()->json($arr);
                }
            }else{
                return redirect('/created-flowers');
            }
            
        }else{
            return redirect('/login?authRedirect=created-flowers');
        }
    }

    public function getUserDetails(Request $request){

        $post = $request->all();
        // dd($post);
        $user_details = userDetails($post['id']);
        return json_encode($user_details);
    }

    // Send request to other users to join group
    public function group_join_request(Request $request) {

        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $user_id = $user_auth->id;

            $post = $request->all();
            $group_flower_id = Crypt::decryptString($post['group_id']);
            // dd($post);
            $group = Group::where(array('id' => $group_flower_id, 'type' => 1))->first();

            if (!empty($group)) {
                $group = GroupFlowersMembers::where(array('group_flowers_members.group_flower_id' => $group_flower_id, 'group_flowers_members.member_id' => $user_id))->first();

                if (empty($group)) {
                    $gfm = new GroupFlowersMembers();

                    $gfm->group_flower_id = $group_flower_id;
                    $gfm->member_id = $user_auth->id;
                    $gfm->sent_by = $user_auth->id;
                    $gfm->status = 1;
                    $gfm->position_id = 0;

                    if ($gfm->save()) {
                        $id = $gfm->id;
                        $details = Group::with(['groupowner'])->where('id', $group_flower_id)->first();
                        if (!empty($details)) {
                            $details = $details->toArray();
                        }
                        // dd($details);
                        $email = $details['groupowner']["email"];
                        $first_name = $details['groupowner']['first_name'];
                        $password = ''; //$details['user_group_flower']['password'];
                        $user_first_name = $user_auth->first_name;
                        $link = action([GroupController::class, 'getGroupJoinRequests']); //url('group_invitation_accept'.'/'.Crypt::encryptString($id));

                        try {
                            Mail::send('layouts.mailer.groupjoin', ['first_name' => $first_name, 'email' => $email, 'user_first_name' => $user_first_name, 'link' => $link], function($message) use ($email) {
                                $message->to($email)->subject('Join Request on LOADUS Group');
                            }
                            );
                        } catch (\Exception $e) {
                            // $message_err=$e->getMessage();
                            // print_r($message_err);exit;
                            $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
                        }

                        /** Add & Send Notification Start * */
                        $notification = array(
                            'send_by' => $user_id,
                            'send_to' => $details['groupowner']['id'],
                            'group_flower_id' => $group_flower_id,
                            'object_id' => $id,
                            'object_type' => 'groupjoin',
                            'description' => 'has request you to become member on Group ' . substr($details['name'], 0, 10) . '...',
                        );
                        Notification::create($notification);

                        /** Add & Send Notification End * */
                        Session::flash('message', 'Group join request sent successfully');
                        Session::flash('alert-class', 'alert-success');
                        return response()->json(['status' => true, 'message' => 'Group join request sent successfully.']);
                    }
                } else {
                    Session::flash('message', 'You have already sent Group join request');
                    Session::flash('alert-class', 'alert-success');
                    return response()->json(['status' => true, 'message' => 'You have already sent Group join request.']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Group not found.']);
            }
        } else {
            return redirect('/login?authRedirect=group-pool');
        }
    }

    // Send request to other users to join group
    public function group_join_cancel_request(Request $request) {

        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $user_id = $user_auth->id;

            $post = $request->all();
            $request_details = DB::table('group_flowers')
                    ->join('group_flowers_members', 'group_flowers_members.group_flower_id', '=', 'group_flowers.id')
                    ->select('*')
                    ->where(array('group_flowers.id' => Crypt::decryptString($post['group_id']), 'group_flowers_members.member_id' => $user_id))
                    ->first();
            // dd($request_details);

            if(!empty($request_details)){
                if($request_details->is_accepted == 0){
                    $notificationDelete = array(
                        'object_id'=>$request_details->id,
                        'group_flower_id'=>$request_details->group_flower_id,
                        'object_type' => 'groupjoin',
                    );
                    $group = GroupFlowersMembers::find($request_details->id);
                    $delete = $group->delete();
                    if($delete){
                        $this->deleteNotification($notificationDelete);

                        Session::flash('message', 'Request cancelled successfully');
                        Session::flash('alert-class', 'alert-success');
                        return response()->json(['status' => true, 'message' => 'Request cancelled successfully.']);
                    } else {
                        return response()->json(['status' => true, 'message' => 'Something went wrong!.']);
                    }
                } else {
                    Session::flash('message', 'Request already accepted');
                    Session::flash('alert-class', 'alert-success');
                    return response()->json(['status' => true, 'message' => 'Request already accepted.']);
                }
            } else {
                return response()->json(['status' => true, 'message' => "Group request already cancelled"]);
            }
        } else {
            return redirect('/login?authRedirect=group-pool');
        }
    }

    public function getGroupJoinRequests(){
        if( Auth::guard('user')->check() ){

            $user_auth=Auth::guard('user')->user();
            $loggedInUser=$user_auth->id;
            $limit = 10;
            
            $myPlan = getUserSubscriptionDetails($loggedInUser);
            if($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] > 0){
                
                $groupJoinRequests = DB::table('group_flowers_members as gfm')
                ->join('group_flowers as gf', 'gf.id', '=', 'gfm.group_flower_id')
                ->join('users', 'gfm.member_id', '=', 'users.id')
                ->select('gf.id as group_id','gf.user_id as group_owner_id','gf.name as group_name','users.first_name','gfm.sent_by','gfm.member_id','gfm.is_accepted','gfm.id as gfm_Id','gf.privacy')
                ->where('gfm.is_accepted','=',0)
                ->where('gf.type','=',1)
                // ->where('gfm.')
                ->where(function($query) use($loggedInUser) {
                    $query->where('gf.user_id', $loggedInUser)
                    ->orWhere('gfm.member_id', $loggedInUser );
                });
                // ->orWhere('gfm.member_id','=',$loggedInUser)
                //->get();
                try {
                    $groupJoinRequests = $groupJoinRequests->paginate($limit);
                }catch(NotFoundException $e) {
                    $groupJoinRequests  = array();
                }

// echo "<pre>";print_r($groupJoinRequests->toArray());die;
                $data = array(
                    'title' => 'Group Request',
                    'group_requests' => $groupJoinRequests,
                );
                return view('frontend.group.group_requests')->with($data);

                
            }else if($myPlan['is_subscribed'] == 1 && $myPlan['balanceDay'] <= 0){
                Session::flash('message', 'Your subscription plan has expired, please buy a new one to see requests'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect('/subscription_list');
            } else {
                Session::flash('message', 'Please buy a subscription plan to see requests.');
                Session::flash('alert-class', 'alert-danger');
                return redirect('/subscription_list');
            }
        } else {
            return redirect('/login?authRedirect=group-join-request-list');
        }
    }

    public function cancelInvite(Request $request) {
        $post = $request->all();
        // dd($post);
        $group_flower_id = Crypt::decryptString($post['group_id']);
        $gfm_id = Crypt::decryptString($post['gfm_id']);
        // $type = $post['type'];
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $user_id = $loggedInUser = $user_auth->id; //logged in user

            $group = Group::find($group_flower_id);
            // dd($group);
            if (!empty($group)) {

                $groupFlowerMembers = DB::table('group_flowers_members as gfm')
                        ->join('group_flowers as gf', 'gf.id', '=', 'gfm.group_flower_id')
                        ->select('gf.*', 'gfm.*')
                        ->where(array('gf.user_id' => $loggedInUser, 'gfm.id' => $gfm_id, 'gfm.sent_by' => $loggedInUser))
                        ->first();
                // dd($groupFlowerMembers);
                if (!empty($groupFlowerMembers) > 0) {

                    if ($groupFlowerMembers->is_accepted == 1) {
                        $redirectUrl = '/group-join-request-list';
                        $msg = 'User already accepted the request to become group member!!';
                        Session::flash('message', $msg);

                        Session::flash('alert-class', 'alert-success'); 
                        return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                        
                    }else{
                        $notificationDelete = array(
                            'object_id'=>$groupFlowerMembers->id,
                            'group_flower_id'=>$groupFlowerMembers->group_flower_id,
                            'object_type' => 'groupinvite',
                        );
                        $gfm_new = GroupFlowersMembers::find($gfm_id);
                        $delete = $gfm_new->delete();
                        if($delete){

                            $this->deleteNotification($notificationDelete);
                            
                            Session::flash('message', 'Request cancelled successfully');
                            Session::flash('alert-class', 'alert-success');
                            return response()->json(['status' => true, 'message' => 'Request cancelled successfully.']);
                        } else {
                            return response()->json(['status' => true, 'message' => 'Something went wrong!.']);
                        }
                    }
                } else {
                    $redirectUrl = "/login?authRedirect=accept-group-member-request/" . $group_flower_id;
                    $msg = 'Request expired!!';
                    Session::flash('message', $msg);
                    Session::flash('alert-class', 'alert-danger');
                    return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
                    //return response()->json(['status'=>true,'message'=>'Request expired!!', 'redirectUrl'=>$redirectUrl]);
                }
            } else {
                $msg = 'Group not found, please try again';
                Session::flash('message', $msg);
                Session::flash('alert-class', 'alert-danger');
                return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
            }
        } else {
            return redirect('/login?authRedirect=group-join-request-list');
        }
    }

    public function rejectInvite(Request $request) {
        $post = $request->all();
        // dd($post);
        $group_flower_id = Crypt::decryptString($post['group_id']);
        $gfm_id = Crypt::decryptString($post['gfm_id']);
        // $type = $post['type'];
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $user_id = $loggedInUser = $user_auth->id; //logged in user

            $group = Group::find($group_flower_id);
            // dd($group);
            if (!empty($group)) {

                $groupFlowerMembers = DB::table('group_flowers_members as gfm')
                        ->join('group_flowers as gf', 'gf.id', '=', 'gfm.group_flower_id')
                        ->select('gf.*', 'gfm.*')
                        ->where(array('gf.user_id' => $loggedInUser, 'gfm.id' => $gfm_id))
                        ->first();
                // dd($groupFlowerMembers);
                if (!empty($groupFlowerMembers) > 0) {

                    if ($groupFlowerMembers->is_accepted == 1) {
                        $redirectUrl = '/group-join-request-list';
                        $msg = 'You already accepted the user request to become group member!!';
                        Session::flash('message', $msg);
                        Session::flash('alert-class', 'alert-success'); 
                        return response()->json(['status'=>true,'message'=>$msg, 'redirectUrl'=>$redirectUrl]);
                        
                    }else{
                        $notificationDelete = array(
                            'object_id'=>$groupFlowerMembers->id,
                            'group_flower_id'=>$groupFlowerMembers->group_flower_id,
                            'object_type' => 'groupjoin',
                        );
                        $gfm_new = GroupFlowersMembers::find($gfm_id);
                        $delete = $gfm_new->delete();
                        if($delete){

                            $this->deleteNotification($notificationDelete);
                            $notification = array(
                                'send_by' => $loggedInUser,
                                'send_to' => $groupFlowerMembers->member_id,
                                'group_flower_id' => $group_flower_id,
                                'object_id' => null,
                                'object_type' => 'rejectGroupInvite',
                                'description' => 'has rejected your request to join his group '.$groupFlowerMembers->name,
                            );
                            Notification::create($notification);
                            
                            Session::flash('message', 'Request rejected successfully');
                            Session::flash('alert-class', 'alert-success');
                            return response()->json(['status' => true, 'message' => 'Request rejected successfully.']);
                        } else {
                            return response()->json(['status' => true, 'message' => 'Something went wrong!.']);
                        }
                    }
                } else {
                    $redirectUrl = "/login?authRedirect=group-join-request-list";
                    $msg = 'Request expired!!';
                    Session::flash('message', $msg);
                    Session::flash('alert-class', 'alert-danger');
                    return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
                }
            } else {
                $msg = 'Group not found, please try again';
                Session::flash('message', $msg);
                Session::flash('alert-class', 'alert-danger');
                return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
            }
        } else {
            return redirect('/login?authRedirect=group-join-request-list');
        }
    }

    // User requested to join group admin's group and group admin has the option to accept his request
    public function acceptInvite(Request $request) {
        $post = $request->all();
        // dd($post);
        $group_flower_id = Crypt::decryptString($post['group_id']);
        $gfm_id = Crypt::decryptString($post['gfm_id']);
        // $type = $post['type'];
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $user_id = $loggedInUser = $user_auth->id; //logged in user

            $group = Group::find($group_flower_id);
            // dd($group);
            if (!empty($group)) {

                $groupFlowerMembers = DB::table('group_flowers_members as gfm')
                        ->join('group_flowers as gf', 'gf.id', '=', 'gfm.group_flower_id')
                        ->select('gf.*', 'gfm.*')
                        ->where(array('gf.user_id' => $loggedInUser, 'gfm.id' => $gfm_id))
                        ->first();
                // dd($groupFlowerMembers);
                if (!empty($groupFlowerMembers) > 0) {

                    if ($groupFlowerMembers->is_accepted == 1) {
                        $redirectUrl = '/group-join-request-list';
                        $msg = 'You already accepted the user request to become group member!!';
                        Session::flash('message', $msg);
                        Session::flash('alert-class', 'alert-success');
                        return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
                    } else {
                        $notificationDelete = array(
                            'object_id' => $groupFlowerMembers->id,
                            'group_flower_id' => $groupFlowerMembers->group_flower_id,
                            'object_type' => 'groupjoin',
                        );
                        $gfm_new = GroupFlowersMembers::find($gfm_id);
                        $gfm_new->is_accepted = 1;
                        $saveData = $gfm_new->save();
                        if ($saveData) {

                            $this->deleteNotification($notificationDelete);
                            /** Add & Send Notification Start * */
                            $notification = array(
                                'send_by' => $loggedInUser,
                                'send_to' => $groupFlowerMembers->member_id,
                                'group_flower_id' => $group_flower_id,
                                'object_id' => $gfm_id,
                                'object_type' => 'acceptGroupInvite',
                                'description' => 'has accepted your request to join his group ' . $groupFlowerMembers->name,
                            );
                            Notification::create($notification);
                            Session::flash('message', 'User request accepted successfully');
                            Session::flash('alert-class', 'alert-success');
                            return response()->json(['status' => true, 'message' => 'User request accepted successfully.']);
                        } else {
                            return response()->json(['status' => true, 'message' => 'Something went wrong!.']);
                        }
                    }
                } else {
                    $redirectUrl = "/login?authRedirect=group-join-request-list";
                    $msg = 'Request expired!!';
                    Session::flash('message', $msg);
                    Session::flash('alert-class', 'alert-danger');
                    return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
                }
            } else {
                $msg = 'Group not found, please try again';
                Session::flash('message', $msg);
                Session::flash('alert-class', 'alert-danger');
                return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
            }
        } else {
            return redirect('/login?authRedirect=group-join-request-list');
        }
    }

    public function rejectJoin(Request $request) {
        $post = $request->all();
        // dd($post);
        $group_flower_id = Crypt::decryptString($post['group_id']);
        $gfm_id = Crypt::decryptString($post['gfm_id']);
        // $type = $post['type'];
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $user_id = $loggedInUser = $user_auth->id; //logged in user

            $group = Group::find($group_flower_id);
            // dd($group);
            if (!empty($group)) {

                $groupFlowerMembers = DB::table('group_flowers_members as gfm')
                        ->join('group_flowers as gf', 'gf.id', '=', 'gfm.group_flower_id')
                        ->select('gf.*', 'gfm.*')
                        ->where(array('gfm.member_id' => $loggedInUser, 'gfm.id' => $gfm_id))
                        ->first();
                // dd($groupFlowerMembers);
                if (!empty($groupFlowerMembers) > 0) {

                    if ($groupFlowerMembers->is_accepted == 1) {
                        $redirectUrl = '/group-join-request-list';
                        $msg = 'You already accepted the user request to become group member!!';
                        Session::flash('message', $msg);
                        Session::flash('alert-class', 'alert-success');
                        return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
                    } else {
                        $notificationDelete = array(
                            'object_id' => $groupFlowerMembers->id,
                            'group_flower_id' => $groupFlowerMembers->group_flower_id,
                            'object_type' => 'groupinvite',
                        );
                        $gfm_new = GroupFlowersMembers::find($gfm_id);
                        $delete = $gfm_new->delete();
                        if ($delete) {

                            $this->deleteNotification($notificationDelete);
                            /** Add & Send Notification Start * */
                            $notification = array(
                                'send_by' => $loggedInUser,
                                'send_to' => $groupFlowerMembers->user_id,
                                'group_flower_id' => $group_flower_id,
                                'object_id' => null,
                                'object_type' => 'rejectGroupJoin',
                                'description' => 'has rejected your request to join your group ' . $groupFlowerMembers->name,
                            );
                            Notification::create($notification);
                            /** Add & Send Notification End * */
                            Session::flash('message', 'Request rejected successfully');
                            Session::flash('alert-class', 'alert-success');
                            return response()->json(['status' => true, 'message' => 'Request rejected successfully.']);
                        } else {
                            return response()->json(['status' => true, 'message' => 'Something went wrong!.']);
                        }
                    }
                } else {
                    $redirectUrl = "/login?authRedirect=group-join-request-list";
                    $msg = 'Request expired!!';
                    Session::flash('message', $msg);
                    Session::flash('alert-class', 'alert-danger');
                    return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
                }
            } else {
                $msg = 'Group not found, please try again';
                Session::flash('message', $msg);
                Session::flash('alert-class', 'alert-danger');
                return response()->json(['status' => true, 'message' => $msg, 'redirectUrl' => $redirectUrl]);
            }
        } else {
            return redirect('/login?authRedirect=group-join-request-list');
        }
    }

    public function destroy(Request $request) {

        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $group = Group::where(array('id' => Crypt::decryptString($request->id), 'user_id' => $loggedInUser, 'type' => 1))->first();

            if (!empty($group)) {

                $delete = $group->delete();

                if ($delete) {
                    return response()->json(['status' => true, 'msg' => 'Group deleted successfully.']);
                } else {
                    return response()->json(['status' => false, 'msg' => 'Something went wrong!.']);
                }
            } else {
                return response()->json(['status' => false, 'msg' => 'Group not found.']);
            }
        } else {
            return response()->json(['status' => false, 'msg' => 'please login again.']);
        }
    }

    public function leaveGroup(Request $request) {

        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            $group = Group::where(array('id' => Crypt::decryptString($request->id), 'type' => 1))->first();

            if (!empty($group)) {

                $groupFlowerMember = GroupFlowersMembers::where(array('group_flower_id' => Crypt::decryptString($request->id), 'member_id' => $loggedInUser, 'is_accepted' => 1))->first();

                if (!empty($groupFlowerMember)) {
                    $delete = $groupFlowerMember->delete();

                    if ($delete) {
                        return response()->json(['status' => true, 'msg' => 'Group leaved successfully.']);
                    } else {
                        return response()->json(['status' => false, 'msg' => 'Something went wrong!.']);
                    }
                } else {
                    return response()->json(['status' => false, 'msg' => 'Member not found!.']);
                }
            } else {
                return response()->json(['status' => false, 'msg' => 'Group not found.']);
            }
        } else {
            return response()->json(['status' => false, 'msg' => 'please login again.']);
        }
    }


    private function deleteNotification($notificationDelete = array()){


        $getInviteNotification = Notification::where($notificationDelete)->first();
        if (!empty($getInviteNotification)) {
            $getInviteNotification->delete();
        }
    }

    public function checkUser(Request $request){

        $post = $request->all();
        $checkUser = [
            'is_user'=>false,
            'first_name'=>'',
            'phone'=>'',
        ];

        $checkUserDetails = isUserExists($post['email']);
        if(!empty($checkUserDetails)){
            $checkUser = array(
                'is_user'=>true,
                'first_name'=>$checkUserDetails->first_name,
                'phone'=>$checkUserDetails->phone,
            ); 
            
        }
        return json_encode($checkUser);

    }

    public function flower_join_ghost(Request $request){
        
        $post = $request->all();

        $group_flower_id = $post['group_flower_id'];
        
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

             
        }else{
            return response()->json(['status'=>false,'msg'=>'please login again.']);
        }

    }


}
