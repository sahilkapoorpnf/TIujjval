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

class AdminFlowerController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        $data = [
            'title' => 'Flower List'
        ];
        return view('admin.flower.index', $data);
    }

    public function getflowerdata(Request $request) {

        if ($request->ajax()) {
            $adminflower = new AdminGroup();
            $res = $adminflower->Datatables_flower();

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

                $row[] = '<a class="btn btn-primary btn-xs" href="flower/view/' . Crypt::encryptString($value->id) . '" class="text-blue" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i> </a>

                    <a class="btn btn-success btn-xs" href="flower/edit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>

                    <a class="btn btn-danger btn-xs delete-data text-danger" data-toggle="tooltip" title="Delete" data-delete=' . Crypt::encryptString($value->id) . '> <i class="fa fa-trash-o"></i> </a>

                    <a class="btn btn-success btn-xs" href="flower/addMembers/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Add Members"><i class="fa fa-plus"></i> </a>';


                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $adminflower->Countall_flower(),
                "recordsFiltered" => $adminflower->Countfiltered_flower(),
                "data" => $data
            );
            //echo "<pre>";print_r($output);
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
        $users = User::where(array('deleted_at' => null, 'status' => 1))->select(['id', 'first_name', 'last_name'])->get();
        // $position = Position::where('id','!=', '1')->get();
        $position = Position::all();

        $data = [
            'titles' => 'Create Flower',
            'lang' => $lang,
            'users' => $users,
            'position' => $position,
        ];
        return view('admin.flower.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $all = $request->all();
        $validator = Validator::make($all, [
                    'name' => 'required',
        ]);
        if ($all['privacy'] == 0) {
            $validator = Validator::make($all, [
                        'password' => 'required',
            ]);
        }

        if ($validator->passes()) {
            $uniqueId = generateUniqueGroupFlowerId();

            $destinationPath = 'public/uploads/flower';

            if (!empty($all['group_image'])) {
                $image = $all['group_image'];
                $group_image_name = time() . rand(1, 10000) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $group_image_name);
            } else {
                $group_image_name = "";
            }

            $admingroup = new AdminGroup();

            $admingroup->name = $all['name'];
            $admingroup->type = 2;
            $admingroup->image = $group_image_name;
            $admingroup->description = $all['desc'];
            $admingroup->user_id = $all['group_user_id'];
            $admingroup->status = $all['status'];
            $admingroup->privacy = $all['privacy'];
            $admingroup->parent_id = !empty($all['group_id']) ? $all['group_id'] : 0;
            $admingroup->group_flower_unique_id = $uniqueId;
            if ($all['privacy'] == 0) {
                $admingroup->password = $all['password'];
            }

            if ($admingroup->save()) {
                for ($i = 1; $i <= config('constants.total_tiers'); $i++) {
                    $gft = new GroupFlowerTier();
                    $price = "rate_tier" . $i;
                    $gft->tier = $i;
                    $gft->group_flower_id = $admingroup->id;
                    $gft->price = $all[$price];
                    $gft->save();
                }

                foreach ($all['members_positions'] as $memberPositions) {
                    $position_id = $memberPositions['position_id'];
                    for ($i = 0; $i < count($memberPositions['member_id']); $i++) {

                        $gfm = new GroupFlowersMembers();
                        $gfm->member_id = $memberPositions['member_id'][$i];
                        $gfm->group_flower_id = $admingroup->id;
                        $gfm->position_id = $position_id;
                        $gfm->save();

                        // Notification
                    }
                }


                Session::flash('success', 'Flower created successfully');
                return response()->json(['status' => true, 'message' => 'Flower created successfully.']);
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
        $id = Crypt::decryptString($id);
        $result = AdminGroup::with(['groupuser', 'tiers'])->where('id', $id)->first();
        $memberPositions = GroupFlowersMembers::where(array('group_flower_id' => $id))->get()->groupBy('position_id');
        if (!empty($memberPositions)) {
            $memberPositions = $memberPositions->toArray();
        }
        $users = DB::select('select id, first_name, last_name from users WHERE status="1"');
        $position = Position::all();
        $userGroups = [];

        if (!empty($result)) {
            $group_user_id = $result->user_id;
            $query = DB::table('group_flowers as gf')->select(['gf.id', 'gf.name'])
                    ->leftjoin('group_flowers_members as gfm', 'gfm.group_flower_id', '=', 'gf.id')
                    ->where('gf.type', '=', '1')
                    ->where(function($query)use($group_user_id) {
                        $query->where('gfm.member_id', '=', $group_user_id)
                        ->orWhere('gf.user_id', '=', $group_user_id);
                    })
                    ->get();
            if (!empty($query)) {
                $userGroups = $query->toArray();
            } else {
                $userGroups = [];
            }
        }


        $data = [
            'titles' => 'Edit Flower',
            'data' => $result,
            'users' => $users,
            'position' => $position,
            'user_Groups' => $userGroups,
            'memberPositions' => $memberPositions,
        ];


        return view('admin.flower.create', $data);
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
        ]);
        if ($all['privacy'] == 0) {
            $validator = Validator::make($all, [
                        'password' => 'required',
            ]);
        }


        if ($validator->passes()) {

            $destinationPath = 'public/uploads/flower';

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

                for ($i = 1; $i <= config('constants.total_tiers'); $i++) {

                    $gft = GroupFlowerTier::where(array('group_flower_id' => $id, 'tier' => $i))->first();
                    if (empty($gft)) {
                        $gft = new GroupFlowerTier();
                    }
                    $price = "rate_tier" . $i;
                    $gft->tier = $i;
                    $gft->group_flower_id = $admingroup->id;
                    $gft->price = $all[$price];
                    $gft->save();
                }
                /* $adminFlower=GroupFlowersMembers::where('group_flower_id',$id)->get();
                  $existingMemberIds = array();
                  if(!empty($adminFlower)){
                  $adminFlowerMems = $adminFlower->toArray();
                  $existingMemberIds = array_column($adminFlowerMems, 'member_id');
                  $adminFlower->each->delete();
                  }

                  foreach ($all['members_positions'] as $memberPositions ){
                  $position_id = $memberPositions['position_id'];
                  for($i = 0; $i< count($memberPositions['member_id']); $i++ ){

                  $gfm=new GroupFlowersMembers();
                  $gfm->member_id = $memberPositions['member_id'][$i];
                  $gfm->group_flower_id = $admingroup->id;
                  $gfm->position_id=$position_id;
                  $gfm->save();

                  if(!in_array($memberPositions['member_id'][$i], $existingMemberIds)){
                  // Notification
                  }

                  }
                  } */
                Session::flash('success', 'Flower updated successfully');
                return response()->json(['status' => true, 'message' => 'Flower updated successfully.']);
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
        $result = AdminGroup::with(['groupuser', 'tiers', 'members.groupFlowerUser'])->where('id', Crypt::decryptString($id))->first();
        if (!empty($result)) {
            $result = $result->toArray();
        }
        $data = [
            'titles' => 'View Flower',
            'data' => $result,
        ];

        return view('admin.flower.view', $data);
    }

    public function groupMembers(Request $request) {
        $members = AdminGroup::with(['members.groupFlowerUser'])->where('id', $request['group_id'])->first()->toArray();
        $position = [];
        $position = Position::all();
        if (!empty($position)) {
            $position = $position->toArray();
        }
        // dd($position);die;
        $data = $members['members'];
        return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('position_name', function($row) {
                            $position = [];
                            $position = Position::all();
                            if (!empty($position)) {
                                $position = $position->toArray();
                            }
                            foreach ($position as $p) {
                                if ($p['id'] == $row['position_id']) {
                                    $btn = $p['name'];
                                }
                            }

                            return $btn;
                        })
                        ->addColumn('action', function($row) {

                            $btn = ' <a class="btn btn-danger btn-xs data-member text-danger" data-toggle="tooltip" title="Remove Member" data-id=' . Crypt::encryptString($row['id']) . '> <i class="fa fa-trash-o"></i> </a>';
                            return $btn;
                        })
                        ->rawColumns(['position_name', 'action'])
                        ->make(true);
        echo json_encode($output);
    }

    public function addMembers($id) {
        $result = AdminGroup::with(['groupuser'])->where('id', Crypt::decryptString($id))->first();

        $data = [
            'title' => 'Add Members to Flower at Fire Position',
            'data' => $result,
        ];

        return view('admin.flower.add_members', $data);
    }

    public function getuserdata(Request $request) {

        if ($request->ajax()) {
            $result = AdminGroup::select('user_id')->where('id', $request['group_id'])->first();
            if (!empty($result)) {
                $result = $result->toArray();
            }

            $xyz_arr = array_values($result);

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
                $gfm->position_id = 4;

                if ($gfm->save()) {
                    $id = $gfm->id;
                    $details = GroupFlowersMembers::with(['userGroupFlower', 'groupFlowerUser'])->where('id', $id)->first();
                    if (!empty($details)) {
                        $details = $details->toArray();
                    }

                    $email = $details['group_flower_user']["email"];
                    $first_name = $details['group_flower_user']['first_name'];
                    $password = $details['user_group_flower']['password'];
                    $link = action([FlowerController::class, 'getFlowerJoinRequests']); //url('group_invitation_accept'.'/'.Crypt::encryptString($id));

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
            Session::flash('success', 'Member(s) added to the flower sucessfully.');
            return response()->json(['status' => true, 'message' => 'Member(s) added to the flower sucessfully.']);
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
        // dd(config('constants.featured_flowers'));

        $featured_flowers = AdminGroup::where(array('is_deleted' => 0, 'deleted_at' => null, 'type' => 2, 'is_featured' => 1))->count();

        $group_flower = AdminGroup::find(Crypt::decryptString($all['id']));
        // dd($featured_flowers);die;
        if (($featured_flowers >= config('constants.featured_flowers')) && ($group_flower->is_featured == 1)) {

            $is_featured = 0;

            $group_flower->is_featured = $is_featured;

            if ($group_flower->save()) {

                return response()->json(['status' => true, 'message' => 'Flower feature status updated successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'Error occured, please try again!.']);
            }
        } else if ($featured_flowers < config('constants.featured_flowers')) {

            if ($group_flower->is_featured == 0) {
                $is_featured = 1;
            } else {
                $is_featured = 0;
            }

            $group_flower->is_featured = $is_featured;

            if ($group_flower->save()) {

                return response()->json(['status' => true, 'message' => 'Flower feature status updated successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'Error occured, please try again!.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Maximum limit to create featured groups is reached!.']);
        }
    }

    public function getGroups(Request $request) {
        $post = $request->all();
        $id = $post['id'];
        // dd($id);
        // DB::enableQueryLog(); 
        $query = DB::table('group_flowers as gf')->select(['gf.id', 'gf.name'])
                ->leftjoin('group_flowers_members as gfm', 'gfm.group_flower_id', '=', 'gf.id')
                ->where('gf.type', '=', '1')
                ->where(function($query)use($id) {
                    $query->where('gfm.member_id', '=', $id)
                    ->orWhere('gf.user_id', '=', $id);
                })
                ->get();
        // dd(DB::getQueryLog());
        $result = $query->toArray();
        if (!empty($result)) {
            echo '<option value="">Select Group</option>';
            foreach ($result as $data) {
                echo '<option value="' . $data->id . '">' . $data->name . '</option>';
            }
        } else {
            echo '<option value="">Select Group</option>';
        }
    }

    public function uploadFlowerCsv(Request $request) {
        $users = new User();
        $c = 0;
        $bulkData = array();
        $fileArray = explode('.', $_FILES['import_flower']['name']);
        $ext = end($fileArray);
        if ($ext != 'csv')
            return redirect('/admin/flower')->with('error', 'Please upload csv file only!');

        $file = fopen($_FILES['import_flower']['tmp_name'], 'r');
        while (($csvDatat = fgetcsv($file, 10000, ",")) !== FALSE) {
            $c++;
        }
        if ($c == 1) {
            return redirect('/admin/flower')->with('error', 'Please add some data on  csv file only!');
        }
        if (is_uploaded_file($_FILES['import_flower']['tmp_name'])) {
            $file = fopen($_FILES['import_flower']['tmp_name'], 'r');
            $i = 0;
            while (($csvDatat = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($i != 0) {
                    $uData = User::where('email', $csvDatat[1])->first();
                    $gData = AdminGroup::where('group_flower_unique_id', $csvDatat[0])->first();
                    if ($uData && $gData) {
                        $groupData = array(
                            'group_flower_unique_id' => generateUniqueGroupFlowerId(),
                            'user_id' => $uData->id,
                            'type' => 2,
                            'name' => $csvDatat[2],
                            'parent_id' => $gData->id,
                            'privacy' => $csvDatat[3],
                            'password' => (!$csvDatat[3]) ? Hash::make($csvDatat[4]) : NULL,
                            'description' => $csvDatat[5],
                            'status' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        AdminGroup::insert($groupData);
                        //array_push($bulkData, $groupData);
                    } else {
                       // $password = mt_rand(100000, 999999);
                        $password = 123456;
                        $users = new User();
                        $users->first_name = explode('@', $csvDatat[1])[0];
                        $users->email = $csvDatat[1];
                        $users->user_type = 2;
                        $users->password = Hash::make($password);
                        $users->status = 1;
                        $users->created_at = date('Y-m-d H:i:s');
                        $users->updated_at = date('Y-m-d H:i:s');
                        $gData = AdminGroup::where('group_flower_unique_id', $csvDatat[0])->first();
                        if ($users->save() && $gData) {
                            $groupData = array(
                                'group_flower_unique_id' => generateUniqueGroupFlowerId(),
                                'user_id' => $users->id,
                                'type' => 2,
                                'name' => $csvDatat[2],
                                'parent_id' => $gData->id,
                                'privacy' => $csvDatat[3],
                                'password' => (!$csvDatat[3]) ? Hash::make($csvDatat[4]) : NULL,
                                'description' => $csvDatat[5],
                                'status' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            );

                            $email = $csvDatat[1];
                            $fname = explode('@', $csvDatat[1])[0];
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
                            if(empty($arr)){
                                AdminGroup::insert($groupData);
                            }
                            //array_push($bulkData, $groupData);
                        }
                    }
                }
                $i++;
            }
            //AdminGroup::insert($bulkData);
            fclose($file);
            return redirect('/admin/flower')->with('success', 'Group Added Successfully!');
        } else {
            return redirect('/admin/flower')->with('error', 'Please upload csv file only!');
        }
    }

    public function uploadFlowerMemberCsv(Request $request) {
        $users = new User();
        $position = Position::all();
        if (!empty($position)) {
            $databasePositionArray = $position->toArray();
        }

//        dd($position->toarray());
        foreach ($position as $val) {
            $positionArray[$val['id']] = $val['name'];
        }
        $c = 0;
        $bulkData = array();
        $fileArray = explode('.', $_FILES['import_flower_member']['name']);
        $ext = end($fileArray);
        if ($ext != 'csv')
            return redirect('/admin/flower')->with('error', 'Please upload csv file only!');

        $file = fopen($_FILES['import_flower_member']['tmp_name'], 'r');
        while (($csvDatat = fgetcsv($file, 10000, ",")) !== FALSE) {
            $c++;
        }
        if ($c == 1) {
            return redirect('/admin/flower')->with('error', 'Please add some data on  csv file only!');
        }
        if (is_uploaded_file($_FILES['import_flower_member']['tmp_name'])) {
            $file = fopen($_FILES['import_flower_member']['tmp_name'], 'r');
            $i = 0;
            while (($csvDatat = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($i != 0) {
                    if ($var = array_search(strtolower($csvDatat[2]), array_map('strtolower', $positionArray))) {
                        $position_id = $var;
                    } else {
                        continue;
                    }
                    $uData = User::where('email', $csvDatat[2])->first();
                    $gData = AdminGroup::where('group_flower_unique_id', $csvDatat[0])->first();
                    $checkPositions = GroupFlowersMembers::where(array('group_flower_id' => $gData->id, 'position_id' => $position_id))->get()->count();
                    if ($checkPositions >= $databasePositionArray[$position_id - 1]['total_positions']) {
                        continue;
                    } else {
                        if (!empty($uData) && !empty($gData)) {
                            $memberData = array(
                                'group_flower_id' => $gData->id,
                                'member_id' => $uData->id,
                                'sent_by' => 1,
                                'position_id' => $position_id,
                                'is_accepted' => 1,
                                'status' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            );
                            GroupFlowersMembers::insert($memberData);
                            //array_push($bulkData, $memberData);
                        } else {
                            $users = new User();
                            //$password = mt_rand(100000, 999999);
                            $password = 123456;
                            $users->first_name = explode('@', $csvDatat[1])[0];
                            //$users->last_name = (!empty(explode(' ', $csvDatat[1])[1])) ? str_replace(explode(' ', $csvDatat[1])[0], "", $csvDatat[1]) : NULL;
                            $users->email = $csvDatat[1];
                            $users->user_type = 2;
                            $users->password = Hash::make($password);
                            $users->status = 1;
                            $users->created_at = date('Y-m-d H:i:s');
                            $users->updated_at = date('Y-m-d H:i:s');
                            $gData = AdminGroup::where('group_flower_unique_id', $csvDatat[0])->first();

                            if ($users->save() && $gData) {
                                $memberData = array(
                                    'group_flower_id' => $gData->id,
                                    'member_id' => $users->id,
                                    'sent_by' => 1,
                                    'position_id' => $position_id,
                                    'is_accepted' => 1,
                                    'status' => 1,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                );

                                $email = $csvDatat[1];
                                $fname = explode('@', $csvDatat[1])[0];
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
                                    GroupFlowersMembers::insert($memberData);
                                }
                            }
                        }
                    }
                }
                $i++;
            }
            //GroupFlowersMembers::insert($bulkData);
            fclose($file);
            return redirect('/admin/flower')->with('success', 'Flower Member Uploaded Successfully!');
        } else {
            return redirect('/admin/flower')->with('error', 'Please upload csv file only!');
        }
    }

}
