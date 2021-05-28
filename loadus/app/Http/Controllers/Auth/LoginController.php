<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use DB;
use Session;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

//use AuthenticatesUsers;
    use AuthenticatesUsers {
        redirectPath as laravelRedirectPath;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';
    public $maxAttempts = 5;

    /**
     * Set how many seconds a lockout will last.
     */
    public $decayMinutes = 30;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function index(Request $request) {
        $request->session()->regenerate();
        session()->regenerate();
        return view('auth.login');
    }

    protected function validateLogin(Request $request) {
        $messages = [
            'captcha' => 'Wrong captcha code Please try again.'
        ];
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string', 'captcha' => ['required', 'captcha'],
                ], $messages);
    }

    protected function authenticated(Request $request, $user) {
       // dd($user);
        if ($user->status == '0') {
            $login_id = DB::table('tbl_login_log')->insertGetId(
                    ['user_id' => auth()->user()->id, 'ip' => $this->Ip()]
            );
            Session::put('login_id', $login_id);
            return redirect('/admin/dashboard')->with(['success' => 'You have been login successfully!']);
        }else{
           Auth::logout();
          return redirect('/admin/login')->with('error', 'Your account is de-activated, contact administrator!');  
        }
        
    }

//    public function redirectPath() {
//        if (auth()->user()->status == '1') {
//            $this->deactive();
//        } else {
//            $login_id = DB::table('tbl_login_log')->insertGetId(
//                    ['user_id' => auth()->user()->id, 'ip' => $this->Ip()]
//            );
//            Session::put('login_id', $login_id);
//
//            session()->flash('success', 'You have been login successfully!');
//            return $this->laravelRedirectPath();
//        }
//    }

    public function logout(Request $request) {
        DB::table('tbl_login_log')->where('id', Session::get('login_id'))->update(['logout_time' => date('Y-m-d H:i:s')]);
        Auth::logout();
        return redirect('/admin')->with('success', 'You have been logged out successfully!');
    }

    public function refereshcapcha() {
        return captcha_img('inverse');
    }

    public function Ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

}
