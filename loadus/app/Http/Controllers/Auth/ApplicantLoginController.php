<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;

class ApplicantLoginController extends Controller {

    public function index() {
        if (!empty(Auth::guard('applicant')->user()->id)) {
            return redirect('/dashboard');
        }
        if (empty(Auth::guard('applicant')->user()->id)) {
            return redirect('/');
        }
//        return view('front/auth.login');
    }

    protected function userLogin(Request $request) {
        $message = DB::table('tbl_message')->where('message_type', 'LOGIN_MESSAGE')->first();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard("applicant")->attempt(['email' => $request->email, 'password' => $request->password, 'verified' => '1'])) {
            // return redirect('/dashboard')->with('success', 'You have been login successfully!');
            if (Auth::guard("applicant")->user()->status == '0') {
                // echo '1';
                print_r(json_encode(array (
                    'response' => 1,
                    'message'  => $message->message
                )));
            } else {
                // echo '2';
                print_r(json_encode(array (
                    'response' => 2,
                    'message'  => 'Your Account is de-activated please contact administrator!'
                )));
            }
        } else {
            // echo '0';
            print_r(json_encode(array (
                'response' => 0,
                'message'  => 'These credentials do not match our records!'
            )));

        }
        //return back()->withInput($request->only('email'))->with('error', 'Invalid user email and password!');
    }

}
