<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
       $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() { 
        
        // return view('frontend.home');
        return view('home');
        
        
    }
    
    public function my404() {        
        return view('errors.admin_404');
    }

    public function Chat(Request $request) {
        if ($request->isMethod('post')) {
            //$id = Crypt::decryptString($request->to);
            //$data = User::where('id', $id)->first();
            $FormArray = [                
                'user_id' => auth()->user()->id,
                'from' => auth()->user()->id,
                'to' => $request->to,
                'message' => $request->message,
            ];


            $lid = DB::table('tbl_admin_staff_chat')->insertGetId($FormArray);
            if ($lid) {
                $result = DB::table('tbl_admin_staff_chat')->where('id', $lid)->get();
                foreach ($result as $val) {
                    if ($val->from != auth()->user()->id) {
                        $clas = 'right';
                        $name = auth()->user()->name;
                        $img = auth()->user()->profile_image;
                    } else {
                        $clas = '';
                        $name = auth()->user()->name;
                        $img = auth()->user()->profile_image;
                    }
                    echo '<div class="direct-chat-msg ' . $clas . '">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name pull-right">' . $name . '</span>
                                        <span class="direct-chat-timestamp pull-left">' . date("F j, g:i a", strtotime($val->created_at)) . '</span>
                                    </div>
                                   
                                    <img class="direct-chat-img" src=' . '../' . $img . '>
                                   
                                    <div class="direct-chat-text">
                                        ' . $val->message . '
                                    </div>
                                </div>';
                }
            } else {
                echo '0';
            }
        }
    }
    
     public function imguploadpost(Request $request) {
        if ($request->isMethod('post')) {
            $file = $request->file('file');
            if (!empty($file)) {
                $destinationPath = 'uploads/chat';
                $filename = $destinationPath . '/' . uniqid() . $file->getClientOriginalName();
                $filedata = $file->move($destinationPath, $filename);
                return $filename;
            } else {
                return false;
            }
        }
    }

}
