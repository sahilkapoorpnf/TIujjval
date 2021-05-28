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
use App\Http\Models\Notification;

class NotificationController extends Controller
{

	// public function __construct(){
	// 	$this->middleware('auth:user');
	// }

	public function index(){
        if( Auth::guard('user')->check() ){
            $user_auth=Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            $limit = 2;
            $notifications = DB::table('notifications')
                            ->join('users','users.id','=','notifications.send_by')
                            ->leftJoin('group_flowers as gf','gf.id','=','notifications.group_flower_id')
                            ->select('notifications.*','users.first_name','users.last_name')
                            ->where(array('notifications.send_to' => $loggedInUser,'users.status'=>1))
                            ->groupBy('notifications.id')
                            ->orderByDesc('notifications.id');
            try {
                $notifications = $notifications->paginate($limit);
            }catch(NotFoundException $e) {
                $notifications  = array();
            }

            if(count($notifications) > 0) {
                $unreadId = [];
                foreach($notifications as $notification) {
                    if($notification->is_read == 0) {
                        $unreadId[] = $notification->id;
                    }
                }
                if(!empty($unreadId)) {
                    $query = Notification::where(array('send_to' => $loggedInUser))->whereIn('id', $unreadId)->update(['is_read' => 1]);
                }
            }
            // echo "<pre>";print_r($notifications);die;
            $data = array(
                'title' => 'Notifications',
                'notifications' => $notifications,
            );

            return view('frontend.notification.index')->with($data);

           
        }else{
            return redirect('/');
        }
		
	}

    
}