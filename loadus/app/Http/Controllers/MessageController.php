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
// use app\Http\Controllers\Session;
use Illuminate\Support\Facades\Session;
use app\User;
use app\Common;
use app\Faq;

use App\Http\Models\Group;
use App\Http\Models\Message;

class MessageController extends Controller
{

	// public function __construct(){
	// 	$this->middleware('auth:user');
	// }

	public function messages(){
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $senderId = $user_auth->id;

            $messageData = Message::with(['messageuserGroup'])->select('*',DB::raw("( SELECT message FROM `messages` as `msg`
                WHERE `msg`.`thread_id` = `messages`.`thread_id`
                ORDER BY `msg`.`created_at` desc limit 1) as `last_message`"))  
                ->where('sender_id', $senderId)
                ->orWhere('reciver_id', $senderId )
                ->groupBy('thread_id')  
                ->get();

            if(!empty($messageData)){
                $messageData = $messageData->toArray();
            }
            // dd($messageData);
            $data = array(
                'title'=>'Messages',
                'messages'=>$messageData,
                'logged_in_user'=>$senderId,

            );

            // dd($data);
            return view('frontend.chat.messages')->with($data);

           
        }else{
            return redirect('/');
        }
		
	}

    // Chat from user to group/flower admin
	public function chatHistory(Request $request){

        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $senderId = $user_auth->id;
            if ($request->has('uId')) {
                $reciverId = $request->input('uId');
                $receiverDetails = User::where(array('id'=>$reciverId))->first();
            }else{
                return redirect('/')->with(['message' => 'Invalid Access!', 'alert-class'=> 'alert-danger']);
            }

            if($senderId == $reciverId){
                return redirect()->back()->with(['message' => 'Please Chat with other user', 'alert-class'=> 'alert-danger']);
            }
            if ($request->id) {
                   $group_flower_id = $request->id;
            }else{
                return redirect('/')->with(['message' => 'Invalid Access!', 'alert-class'=> 'alert-danger']);
            }
            // dd($request->input('uId'));
            $group_flower_details = Group::with(['groupowner'])->where(array('id'=>$group_flower_id,'deleted_at'=>null))->first();
            if(!empty($group_flower_details)){
                $group_flower_details = $group_flower_details->toArray();
                


                
            }
            
            DB::enableQueryLog();

            $messageData = Message::where('group_flower_id',$group_flower_id)
                ->where(function($query) use($senderId, $reciverId ) {
                    $query->where(array('sender_id'=> $senderId,'reciver_id' =>$reciverId ))
                    ->orWhere(function($query) use($senderId, $reciverId ) {
                        $query->where('reciver_id', $senderId)
                        ->where('sender_id', $reciverId );
                    });
                })
            ->get();
            // $messageData = Message::where('group_flower_id',$group_flower_id)
            //                 ->where(function($query) use($senderId, $reciverId ) {
            //                     $query->where(function($query) use($senderId, $reciverId ) {
            //                         $query->where('sender_id', $senderId)
            //                               ->where('reciver_id', $reciverId );
            //                     })
            //                     ->orWhere(function($query) use($senderId, $reciverId ) {
            //                         $query->where('reciver_id', $senderId)
            //                               ->where('sender_id', $reciverId );
            //                     });
            //                 })
            //                 ->get();
                           // dd($messageData);
            
             // dd(DB::getQueryLog());
            if(!empty($messageData)){
                $messageData = $messageData->toArray();
            }else{
                $messageData = array();
            }
            $data = array(
                'title'=>'Message Detail',
                'group_flower_details'=>$group_flower_details,
                'messages'=>$messageData,
                'logged_in_user'=>$senderId,
                'receiverDetails' =>$receiverDetails

            );

            // dd($data);
            return view('frontend.chat.message_detail')->with($data);

           
        }else{
            return redirect('/');
        }
    }

    // Post message :- Chat from user to group/flower admin
    public function postMessage(Request $request){

        if( Auth::guard('user')->check() ){
            $post = $request->all();
            $user_auth=Auth::guard('user')->user();
            $senderId = $user_auth->id;
            $reciverId = $post['group_flower_user'];
            $message = $post['message'];
            $group_flower_id = $post['group_flower_id'];

            $group_flower_details = Group::with(['groupowner'])->where(array('id'=>$group_flower_id, 'status'=>1,'deleted_at'=>null))->first();
            if(!empty($group_flower_details)){
                $group_flower_details = $group_flower_details->toArray();
                // $reciverId  = $group_flower_details['user_id'];
            }
            

            $messageData = Message::where('group_flower_id',$group_flower_id)
                            ->where(function($query) use($senderId, $reciverId ) {
                                $query->where(function($query) use($senderId, $reciverId ) {
                                    $query->where('sender_id', $senderId)
                                          ->where('reciver_id', $reciverId );
                                })
                                ->orWhere(function($query) use($senderId, $reciverId ) {
                                    $query->where('reciver_id', $senderId)
                                          ->where('sender_id', $reciverId );
                                });
                            })
                            ->first();
                            //dd($messageData);
            if(!empty($messageData)){
                $thread_id = $messageData->thread_id;
            }else{
                $thread_id = mt_rand(100000000, 999999999);
            }

            $messageObject=new Message();
            
            $messageObject->thread_id=$thread_id;
            $messageObject->group_flower_id=$group_flower_id;
            $messageObject->sender_id=$senderId;
            $messageObject->reciver_id=$reciverId;
            $messageObject->message=$message;

            if($messageObject->save()){
                $messageId = $messageObject->id;
                $data['threadId'] = $thread_id;
                $data['messageId']= (string) $messageId;
                $data['message']  = $message;
                return response()->json(['status'=>true, 'result'=>$data,'message'=>'Message sent successfully.']);
            }else{
                return response()->json(['status'=>false,'message'=>'Error!!.']);
            }

           
        }else{
            return redirect('/');
        }
    }
}