<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\User;
use App\AdminGroup;
use App\GroupFlowerTier;
use App\Position;
use App\GroupFlowersMembers;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class AdminGroupController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        $data = [
            'title' => 'Groups List'
        ];
        return view('admin.group.index', $data);
    }

    public function getgroupdata(Request $request) {

        if ($request->ajax()) {
            $admingroup = new AdminGroup();
            $res = $admingroup->Datatables();

            $data = [];
            $no = $_POST['start'];
            foreach ($res as $value) {
                $no++;

                $row = [];
                $row[] = $no;
                $row[] = $value->name;
                $row[] = $value->group_flower_unique_id;
                $row[] = $value->description;
                $row[] = $value->first_name;

                $row[] = ($value->is_featured == '1' ? '<a class="label label-danger featured-data" data-toggle="tooltip" title="Click to remove from list" data-featured=' . Crypt::encryptString($value->id) . '>Remove from featured list</a>' : '<a class="label label-success featured-data" data-toggle="tooltip" title="Click to add in featured list" data-featured=' . Crypt::encryptString($value->id) . '> Add to featured list</a>');

                $row[] = ($value->status == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');

                $row[] = '<a class="btn btn-primary btn-xs" href="group/view/' . Crypt::encryptString($value->id) . '" class="text-blue" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i> </a>

                    <a class="btn btn-success btn-xs" href="group/edit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>

                    <a class="btn btn-danger btn-xs delete-data text-danger" data-toggle="tooltip" title="Delete" data-delete=' . Crypt::encryptString($value->id) . '> <i class="fa fa-trash-o"></i> </a>

                    <a class="btn btn-success btn-xs" href="group/addMembers/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Add Members"><i class="fa fa-plus"></i> </a>';


                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $admingroup->Countall(),
                "recordsFiltered" => $admingroup->Countfiltered(),
                "data" => $data
            );

            echo json_encode($output);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $lang = DB::select('select * from tbl_language WHERE status="1"');
        $users = DB::select('select id, first_name, last_name from users WHERE status="1"');

        $data = [
            'titles' => 'Create Group',
            'lang' => $lang,
            'users' => $users,
        ];
        return view('admin.group.create', $data);
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
        //print_r($all);
        $validator = Validator::make($all, [
                    'name' => 'required',
                        // 'rate_tier1'=>'required',
                        // 'rate_tier2'=>'required',
                        // 'rate_tier3'=>'required',
        ]);
        if ($all['privacy'] == 0) {
            $validator = Validator::make($all, [
                        'password' => 'required',
            ]);
        }

        if ($validator->passes()) {
            //generate group flower unique id
            $uniqueId = generateUniqueGroupFlowerId();
            $destinationPath = 'public/uploads/group';


            if (!empty($all['group_image'])) {
                $image = $all['group_image'];
                $group_image_name = time() . rand(1, 10000) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $group_image_name);
            } else {
                $group_image_name = "";
            }

            $admingroup = new AdminGroup();

            $admingroup->name = $all['name'];
            $admingroup->image = $group_image_name;
            $admingroup->description = $all['desc'];
            $admingroup->user_id = $all['group_user_id'];
            $admingroup->status = $all['status'];
            $admingroup->privacy = $all['privacy'];
            $admingroup->group_flower_unique_id = $uniqueId;
            if ($all['privacy'] == 0) {
                $admingroup->password = $all['password'];
            }

            if ($admingroup->save()) {
                // for($i = 1; $i <= config('constants.total_tiers'); $i++){
                //     $gft=new GroupFlowerTier();
                //     $price = "rate_tier".$i;
                //     $gft->tier = $i;
                //     $gft->group_flower_id = $admingroup->id;
                //     $gft->price=$all[$price];
                //     $gft->save();
                // }
                Session::flash('success', 'Group created successfully');
                return response()->json(['status' => true, 'message' => 'Group created successfully.']);
            }
        } else {

            return response()->json([
                        'status' => 'invalid',
                        'errors' => $validator->getMessageBag()->toArray()
            ]);
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
        $result = AdminGroup::with(['groupuser', 'tiers'])->where('id', Crypt::decryptString($id))->first();

        $users = DB::select('select id, first_name, last_name from users WHERE status="1"');

        $data = [
            'titles' => 'Edit Group',
            'data' => $result,
            'users' => $users,
        ];

        return view('admin.group.create', $data);
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

        $validator = Validator::make($all, [
                    'name' => 'required',
                        // 'rate_tier1'=>'required',
                        // 'rate_tier2'=>'required',
                        // 'rate_tier3'=>'required',
        ]);
        if ($all['privacy'] == 0) {
            $validator = Validator::make($all, [
                        'password' => 'required',
            ]);
        }


        if ($validator->passes()) {

            $destinationPath = 'public/uploads/group';

            $id = $all['id'];

            if (!empty($all['group_image'])) {
                if (!empty($all['old_group_image'])) {

                    $path = $destinationPath . '/' . $all['old_group_image'];
                    if (file_exists($path)) {
                        unlink("$path");
                    }
                }

                $image = $all['group_image'];
                $group_image_name = time() . rand(1, 10000) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $group_image_name);
            } else {
                $group_image_name = "";
            }

            $admingroup = AdminGroup::find($id);

            $admingroup->name = $all['name'];
            $admingroup->description = $all['desc'];
            $admingroup->user_id = $all['group_user_id'];
            $admingroup->status = $all['status'];
            $admingroup->privacy = $all['privacy'];
            if ($all['privacy'] == 0) {
                $admingroup->password = $all['password'];
            } else {
                $admingroup->password = null;
            }

            if (!empty($group_image_name)) {
                $admingroup->image = $group_image_name;
            }

            if ($admingroup->save()) {

                // for($i = 1; $i <= config('constants.total_tiers'); $i++){
                //     $gft=GroupFlowerTier::where(array('group_flower_id'=> $id, 'tier'=>$i))->first();
                //     $price = "rate_tier".$i;
                //     $gft->tier = $i;
                //     $gft->group_flower_id = $admingroup->id;
                //     $gft->price=$all[$price];
                //     $gft->save();
                // }
                Session::flash('success', 'Group updated successfully');
                return response()->json(['status' => true, 'message' => 'Group updated successfully.']);
            }
        } else {

            return response()->json([
                        'status' => 'invalid',
                        'errors' => $validator->getMessageBag()->toArray()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $group = AdminGroup::find(Crypt::decryptString($request->id));

        $delete = $group->delete();

        if ($delete) {
            return response()->json(['status' => true, 'message' => 'Group deleted successfully.']);
        }
    }

    public function view($id) {
        $model = new AdminGroup();
        // echo "<pre>";print_r(config('constants.total_tiers'));die;
        //$result = $model->view(Crypt::decryptString($id));
        $result = AdminGroup::with(['groupuser', 'tiers', 'members.groupFlowerUser'])->where('id', Crypt::decryptString($id))->first()->toArray();
        // dd(DB::getQueryLog());
        // echo "<pre>";print_r($result);die;

        $data = [
            'titles' => 'View Group',
            'data' => $result,
        ];

        return view('admin.group.view', $data);
    }

    public function groupMembers(Request $request) {
        $members = AdminGroup::with(['members.groupFlowerUser'])->where('id', $request['group_id'])->first()->toArray();
        // dd($members);die;
        $data = $members['members'];
        return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row) {

                            $btn = ' <a class="btn btn-danger btn-xs data-member text-danger" data-toggle="tooltip" title="Remove Member" data-id=' . Crypt::encryptString($row['id']) . '> <i class="fa fa-trash-o"></i> </a>';
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
        echo json_encode($output);
    }

    public function addMembers($id) {
        $result = AdminGroup::with(['groupuser'])->where('id', Crypt::decryptString($id))->first();

        $data = [
            'title' => 'Add Members to Group',
            'data' => $result,
        ];

        return view('admin.group.add_members', $data);
    }

    public function getuserdata(Request $request) {

        if ($request->ajax()) {
            $result = array();
            // $result = AdminGroup::select('user_id')->where('id',$request['group_id'])->first()->toArray();
            $result = AdminGroup::select('user_id')->where('id', $request['group_id'])->first();
            if (!empty($result)) {
                $result = $result->toArray();
                $xyz_arr = array_values($result);
            }
            // $xyz_arr = array_values($result);
            // $group_flower_members = GroupFlowersMembers::select('member_id')->where('group_flower_id','=', $request['group_id'])->get()->toArray();
            $group_flower_members = array();
            $group_flower_members = GroupFlowersMembers::select('member_id')->where('group_flower_id', '=', $request['group_id'])->get();

            if (!empty($group_flower_members)) {
                $group_flower_members = $group_flower_members->toArray();
                $xyz_arr = array_merge(array_column($group_flower_members, 'member_id'), $xyz_arr);
            }
            $data = User::whereNotIn('id', $xyz_arr)->get();


            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row) {

                                $btn = '<div class="form-check">
                     <input type="checkbox" data-id="' . $row->id . '" class="form-check-input user_check" >
                   </div>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
            echo json_encode($output);
        }
    }

    public function addgroupmember(Request $request) {
        $post = $request->all();
        $validator = Validator::make($post, [
                    'group_id' => 'required',
                    'userIds' => 'required',
        ]);
        $idCount = count($post['userIds']);

        if ($validator->passes()) {
            $details = array();

            for ($i = 0; $i < $idCount; $i++) {
                $gfm = new GroupFlowersMembers();

                $gfm->group_flower_id = $post['group_id'];
                $gfm->member_id = $post['userIds'][$i];
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
                    $link = action([GroupController::class, 'getGroupJoinRequests']);

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
                }
            }
            Session::flash('success', 'Member(s) added to the group sucessfully.');
            return response()->json(['status' => true, 'message' => 'Member(s) added to the group sucessfully.']);
        } else {
            return response()->json([
                        'status' => 'invalid',
                        'errors' => $validator->getMessageBag()->toArray()
            ]);
        }
    }

    public function removeMember(Request $request) {
        $GroupFlowersMembers = GroupFlowersMembers::find(Crypt::decryptString($request->id));

        $delete = $GroupFlowersMembers->delete();

        if ($delete) {

            //notification mail


            return response()->json(['status' => true, 'message' => 'Member removed successfully.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Error! Something went wrong.']);
        }
    }

    public function featured(Request $request) {
        $all = $request->all();
        // dd(config('constants.featured_groups'));

        $featured_groups = AdminGroup::where(array('is_deleted' => 0, 'deleted_at' => null, 'type' => 1, 'is_featured' => 1))->count();

        $group_flower = AdminGroup::find(Crypt::decryptString($all['id']));
        // dd($featured_groups);die;
        if (($featured_groups >= config('constants.featured_groups')) && ($group_flower->is_featured == 1)) {

            $is_featured = 0;

            $group_flower->is_featured = $is_featured;

            if ($group_flower->save()) {

                return response()->json(['status' => true, 'message' => 'Group updated successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'Error occured, please try again!.']);
            }
        } else if ($featured_groups < config('constants.featured_groups')) {

            if ($group_flower->is_featured == 0) {
                $is_featured = 1;
            } else {
                $is_featured = 0;
            }

            $group_flower->is_featured = $is_featured;

            if ($group_flower->save()) {

                return response()->json(['status' => true, 'message' => 'Group updated successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'Error occured, please try again!.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Maximum limit to create featured groups is reached!.']);
        }
    }

    public function uploadGroupCsv(Request $request) {
        $users = new User();
        $c = 0;
        $bulkData = array();
        $fileArray = explode('.', $_FILES['import_group']['name']);
        $ext = end($fileArray);
        if ($ext != 'csv')
            return redirect('/admin/group')->with('error', 'Please upload csv file only!');

        $file = fopen($_FILES['import_group']['tmp_name'], 'r');
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
            $c++;
        }
        if ($c == 1) {
            return redirect('/admin/group')->with('error', 'Please add some data on  csv file only!');
        }
        if (is_uploaded_file($_FILES['import_group']['tmp_name'])) {
            $file = fopen($_FILES['import_group']['tmp_name'], 'r');
            $i = 0;
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($i != 0) {
                    if ($gData = User::where('email', $emapData[0])->first()) {
                        $groupData = array(
                            'group_flower_unique_id' => generateUniqueGroupFlowerId(),
                            'user_id' => $gData['id'],
                            'type' => 1,
                            'name' => $emapData[1],
                            'privacy' => $emapData[2],
                            'password' => (!$emapData[2]) ? Hash::make($emapData[3]) : NULL,
                            'description' => $emapData[4],
                            'status' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        AdminGroup::insert($groupData);
                        //array_push($bulkData, $groupData);
                    } else {
                        //$password = mt_rand(100000, 999999);
                        $password = 123456;
                        $userData = array(
                            'first_name' => explode('@', $emapData[0])[0],
                            'email' => $emapData[0],
                            'user_type' => 2,
                            'password' => Hash::make($password),
                            'status' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        if ($id = DB::table('users')->insertGetId($userData)) {
                            $groupData = array(
                                'group_flower_unique_id' => generateUniqueGroupFlowerId(),
                                'user_id' => $id,
                                'type' => 1,
                                'name' => $emapData[1],
                                'privacy' => $emapData[2],
                                'password' => (!$emapData[2]) ? Hash::make($emapData[3]) : NULL,
                                'description' => $emapData[4],
                                'status' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            );
                            $email = $emapData[0];
                            $fname = explode('@', $emapData[0])[0];
                            try {
                                Mail::send('layouts.mailer.bulk_signup', ['fname' => $fname, 'password' => $password, 'email' => $email], function($message) use ($email) {
                                    $message->to($email)->subject('Welcome on LOADUS');
                                });
                            } catch (\Exception $e) {//dd('kk');
                                $message_err = $e->getMessage();
                                //print_r($message_err);die;
                                $arr = array('msg' => 'Your email is not validated use another', 'status' => false);
                            }
                            AdminGroup::insert($groupData);
                            //array_push($bulkData, $groupData);
                        }
                    }
                }
                $i++;
            }
            //AdminGroup::insert($bulkData);
            fclose($file);
            return redirect('/admin/group')->with('success', 'Group Added Successfully!');
        } else {
            return redirect('/admin/group')->with('error', 'Please upload csv file only!');
        }
    }

}
