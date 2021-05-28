<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use App\Models\Admin;

class AdminController extends Controller
{ 
    
    use AuthenticatesUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('admin');
        // $this->middleware('guest')->except('adminLogout');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login()
    {
        if( \Auth::guard('admin')->check() ){
            return redirect('admin/dashboard');
        }
        return view('admin.auth.login');
    }

    public function login_req(Request $request)
    {
      // dd("dfg");die;
        $all=$request->all();
        // print_r($all);die;
        $validator = Validator::make($all, [
            'email' => 'required',
            'password' => 'required'
           ]);
           
        if($validator->passes()) {
            $email=$all['email'];
            $password=$all['password'];

            $credentials = $request->only('email', 'password');
            $credentials['user_type'] = 1;
            if(Auth::guard('admin')->attempt($credentials)){
            
                return redirect('admin/dashboard');

            }else{
                return Redirect::back()->with(['error'=>'Incorrect Email and Password!!']);
            }
            
            
            
            
        }else{
             return Redirect::back()
                ->withErrors($validator) // send back all errors to the login form
                ->withInput();
                
        }   
    }

    public function logout(){

        if(Auth::guard('admin')->check())
        {
         //dd(\Auth::guard('user'));

          Auth::guard('admin')->logout();
          //  $request->session()->invalidate();
        }
        return  redirect('/admin');
        
    }
}
