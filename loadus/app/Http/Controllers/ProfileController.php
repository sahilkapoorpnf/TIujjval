<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Language;
use Illuminate\Support\Facades\Crypt;
use Auth;
use App\User;
use App\Admin;
use DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {
    public function __construct() 
    {
    $this->middleware('auth:admin');
    }
    public function index() {
        $user_auth=Auth::guard('admin')->user();
        // echo "<pre>";print_r($user_auth);die;
        $id=$user_auth->id;
        $res = Admin::where('id', $id)->first();
        $data = [
            'titles' => 'Profile',
            'data' => $res,
        ];
         //echo "<pre>";print_r($data);die;
        return view('admin.profile.index', $data);
    }

    public function update(Request $request) {

        $user = new Admin();
        $data = $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);
        $filename = $request->input('profile_image_old');
        if ($request->file('profile_image')) {
            $file = $request->file('profile_image');
            $destinationPath = 'public/uploads/admin/profile';
            $filename = $destinationPath . '/' . uniqid() . $request->files->get('profile_image')->getClientOriginalName();
            $filedata = $file->move($destinationPath, $filename);
        }


        $data['id'] = auth('admin')->user()->id;
        $data['profile_image'] = $filename;

        $result = $user->updateProfile($data);
        if ($result) {
            return redirect('/admin/profile')->with('success', 'Your profile is Updated Successfully!');
        } else {
            return redirect('/admin/profile/')->with('error', 'Something went wrong please try after sometime!');
        }
    }

    public function passchange(Request $request) {

        $user = new User();
        $res = User::where('id', Auth::user()->id)->first();

        $data = [
            'title' => 'Password Change',
            'data' => $res,
        ];
        if ($request->isMethod('post')) {
            $model = $this->validate($request, [
                'password' => 'required|min:8',
            ]);
//            echo  Hash::make($request->password); die;
            $affected = DB::table('users')->where('id', Auth::user()->id)->update(['password' => Hash::make($request->password)]);
            if ($affected) {
                Auth::logout();
                return redirect('/admin')->with('success', 'You password has been change successfully!');
            }
        }
        return view('admin.profile.password', $data);
    }

}
