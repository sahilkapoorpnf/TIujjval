<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\AdminUser;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminUserController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {


        if ($request->ajax()) {
            $data = User::where(array('user_type' => 2, 'deleted_at' => null))->get();
            // echo "<pre>";print_r($data);die;
            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('full_name', function($row1) {
                                $full_name = $row1->first_name . " " . $row1->last_name;
                                return $full_name;
                            })
                            ->addColumn('action', function($row) {
                                $icon = "ban";
                                if ($row->status == 1) {
                                    $icon = "unlock fa-lg";
                                }
                                $btn = ' <a data-toggle="tooltip" title="View" href="' . url('admin/user/view', $row->id) . '" 
                class="btn btn-xs ">
                <i class="fa fa-eye fa-lg"></i>
               </a>
               
               <a data-toggle="tooltip" title="Edit User" href="' . route('edit-user', $row->id) . '" 
                class="btn btn-xs ">
                <i class="fas fa-edit"></i>
               </a>

               <a id="' . $row->id . '" data-toggle="tooltip" title="Block/Unblock User" class="btn btn-xs block">
                <i class="fa fa-' . $icon . '"></i>
               </a> 

               <a id="' . $row->id . '" data-toggle="tooltip"  title="Delete User"  class="btn btn-xs danger delete-data">
               <i class="fas fa-trash-alt"></i> 
               </a> ';

                                return $btn;
                            })
                            ->rawColumns(['full_name', 'action'])
                            ->make(true);
        }

        return view('admin.user.index');
    }

    public function userlist(Request $request) {

        // $res = User::where('deleted_at', null)->get();
        // // echo "<pre>";print_r($res);die;
        // $data = [];
        // $no = $_POST['start'];
        // foreach ($res as $value) {
        //     $no++;
        //     $row = [];
        //     $row[] = $no;
        //     $row[] = $value->first_name;
        //     $row[] = $value->phone;
        //     $row[] = $value->email;
        //     $row[] = ($value->status == '0' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');
        //    // $row[] = ActionButton($value->id);
        //     $data[] = $row;
        // }
        // $output = array(
        //     "draw" => $_POST['draw'],
        //     "recordsTotal" => '3',//User::find(1)->Countall,
        //     "recordsFiltered" =>'3',//User::find(1)->Countfiltered,
        //     "data" => $data
        // );
        // // print_r($output);die;
        // echo json_encode($output);

        if ($request->ajax()) {
            $data = User::where(array('user_type' => 2, 'deleted_at' => null))
                            // $data = User::where('deleted_at', null)
                            ->orderBy('id', 'DESC')->get();
            // echo "<pre>";print_r($data);die;

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('full_name', function($row1) {
                                $full_name = $row1->first_name . " " . $row1->last_name;
                                return $full_name;
                            })
                            ->addColumn('action', function($row) {
                                $icon = "ban";
                                if ($row->status == 1) {
                                    $icon = "unlock fa-lg";
                                }
                                $btn = ' <a data-toggle="tooltip" title="View" href="' . url('admin/user/view', $row->id) . '" 
                class="btn btn-xs ">
                <i class="fa fa-eye fa-lg"></i>
               </a>
               
               <a data-toggle="tooltip" title="Edit User" href="' . route('edit-user', $row->id) . '" 
                class="btn btn-xs ">
                <i class="fas fa-edit"></i>
               </a>

               <a id="' . $row->id . '" data-toggle="tooltip" title="Block/Unblock User" class="btn btn-xs block status-data" data-status="' . $row->id . '">
                <i class="fa fa-' . $icon . '"></i>
               </a> 

               <a id="' . $row->id . '" data-toggle="tooltip"  title="Delete User"  class="btn btn-xs danger delete-data" data-delete="' . $row->id . '">
               <i class="fas fa-trash-alt"></i> 
               </a> ';

                                return $btn;
                            })
                            ->rawColumns(['full_name', 'action'])
                            ->make(true);
        }
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $data = [
            'titles' => 'Create User',
        ];

        return view('admin.user.create', $data);
        // return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $all = $request->all();
        //dd($all);
        // print_r($all);die;
        $validator = Validator::make($all, [
                    'first_name' => 'required',
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8'],
                    'confirm_password' => 'required',
        ]);


        if ($validator->passes()) {

            $destinationPath = 'public/uploads/users';

            if (!empty($all['user_image'])) {
                $image = $all['user_image'];

                $user_image_name = time() . rand(1, 10000) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $user_image_name);
            } else {
                $user_image_name = "";
            }

            $insClass = new User();
            $insClass->first_name = $all['first_name'];
            $insClass->last_name = $all['last_name'];
            $insClass->user_image = $user_image_name;
            $insClass->email = $all['email'];
            $insClass->phone = $all['phone'];
            $insClass->status = 1;
            $insClass->user_type = 2;
            $insClass->password = Hash::make($all['password']);

            $saved = $insClass->save();
            if ($saved) {
                //return response()->json(['status'=>true,'message'=>'User added successfully.']);
                return redirect('/admin/user')->with('success', 'User Add Successfully!');
            }
        } else {

            return redirect('/admin/user')->with('error', 'Something went wrong please try after sometime!');
            // return response()->json([
            //     'status'=>'invalid',
            //     'errors' => $validator->getMessageBag()->toArray()
            //     ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        // dd($id);die;
        // $user = User::where('id', $id)->first();
        // $res = User::where('id', Crypt::decryptString($id))->first();
        $res = User::where('id', $id)->first();
        ;
        $data = [
            'titles' => 'User',
            'data' => $res,
        ];
        // echo "<pre>";print_r($user);die;
        // return view('admin.users.edit')
        // ->with('user',$user);
        return view('admin.user.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $all = $request->all();
        // dd('fsdfdsf');die;
        // echo "<pre>";print_r($all);die;

        $validator = Validator::make($all, [
                    'first_name' => 'required',
                    'email' => 'required',
                    'status' => 'required',
        ]);


        if ($validator->passes()) {

            $destinationPath = 'public/uploads/users';

            $id = $all['id'];



            if (!empty($all['user_image'])) {
                if (!empty($all['old_user_image'])) {
                    $path = $destinationPath . '/' . $all['old_user_image'];
                    if (file_exists($path)) {
                        unlink("$path");
                    }
                }

                $image = $all['user_image'];
                $user_image_name = time() . rand(1, 10000) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $user_image_name);
            } else {
                $user_image_name = "";
            }
            $insClass = User::find($id);
            $insClass->first_name = $all['first_name'];
            if (!empty($user_image_name)) {
                $insClass->user_image = $user_image_name;
            }

            $insClass->last_name = $all['last_name'];
            $insClass->phone = $all['phone'];
            $insClass->status = $all['status'];
            $saved = $insClass->save();
            if ($saved) {
                // return response()->json(['status'=>true,'message'=>'User updated successfully.']);
                return redirect('/admin/user')->with('success', 'User Update Successfully!');
            }
        } else {

            // return response()->json([
            //     'status'=>'invalid',
            //     'errors' => $validator->getMessageBag()->toArray()
            //     ]);

            return redirect('/admin/user')->with('error', 'Something went wrong please try after sometime!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $all = $request->all();
        // dd($all);
        $delete = User::find($all['id'])->delete();

        if ($delete) {
            return response()->json(['status' => true, 'message' => 'User deleted successfully.']);
        }
    }

    public function statusChange(Request $request) {
        $all = $request->all();

        $users = User::find($all['id']);
        if ($users->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        $users->status = $status;

        $users->save();
        return response()->json(['status' => true, 'message' => 'User updated successfully.']);
    }

    public function view($id) {
        // dd("dfgdf");die;
        $model = new AdminUser();
        $result = $model->view($id);
        // print_r($result);die;

        $data = [
            'titles' => 'View Page',
            'data' => $result,
        ];

        return view('admin.user.view', $data);
    }

    public function uploadUserCsv(Request $request) {
        $users = new User();
        $c = 0;
        $bulkData = array();
        $fileArray = explode('.', $_FILES['import_user']['name']);
        $ext = end($fileArray);
        if ($ext != 'csv')
            return redirect('/admin/user')->with('error', 'Please upload csv file only!');

        $file = fopen($_FILES['import_user']['tmp_name'], 'r');
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
            $c++;
        }
        if ($c == 1) {
            return redirect('/admin/user')->with('error', 'Please add some data on  csv file only!');
        }
        if (is_uploaded_file($_FILES['import_user']['tmp_name'])) {
            $file = fopen($_FILES['import_user']['tmp_name'], 'r');
            $i = 0;
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($i != 0) {
                    if (User::where('email', $emapData[2])->first()) {
                        continue;
                    } else {
                        //$password = mt_rand(100000, 999999);
                        $password = 123456;
                        $userData = array(
                            'first_name' => $emapData[0],
                            'last_name' => $emapData[1],
                            'email' => $emapData[2],
                            'phone' => $emapData[3],
                            'user_type' => 2,
                            'password' => Hash::make($password),
                            'status' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        $email = $emapData[2];
                        $fname = $emapData[0];
                        try {
                            Mail::send('layouts.mailer.bulk_signup', ['fname' => $fname, 'password' => $password, 'email' => $email], function($message) use ($email) {
                                $message->to($email)->subject('Welcome on LOADUS');
                            });
                        } catch (\Exception $e) {//dd('kk');
                            $message_err = $e->getMessage();
                            //print_r($message_err);die;
                            $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
                        }
                        $arr= array();
                        if (empty($arr)) {
                            array_push($bulkData, $userData);
                        }
                    }
                }
                $i++;
            }
            User::insert($bulkData);
            fclose($file);
            return redirect('/admin/user')->with('success', 'User Added Successfully!');
        } else {
            return redirect('/admin/user')->with('error', 'Please upload csv file only!');
        }
    }

}
