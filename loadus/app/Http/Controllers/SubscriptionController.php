<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;
use Illuminate\Support\Facades\Crypt;
use DB;
use Auth;
use App\UserSubscription;
use App\User;

class SubscriptionController extends Controller {

    public $subscriptionType = ['1' => 'Basic Monthly', '2' => 'Basic Yearly','3' => 'Pro Monthly', '4' => 'Pro Yearly'];

    public function __construct() {
       $this->middleware('auth:admin')->except(array('my_subscription','subscription_list'));
        // $this->middleware('auth:user');
    }

    public function index() {
        $data = [
            'title' => 'Subscription List'
        ];
        return view('admin.subscription.index', $data);
    }

    public function Datalist() {
        $subs = new Subscription();
        $res = $subs->Datatables();
        // $res = Faq::where('deleted_at','=', null)->get();
        //echo "<pre>";print_r($res);die;

        $data = [];
        $no = $_POST['start'];

        foreach ($res as $value) {
            $no++;

            $row = [];
            $row[] = $no;
            $row[] = $this->subscriptionType[$value->subscription_type];
            $row[] = $value->subscription_name;
            $row[] = $value->subscription_rate;
            $row[] = ($value->status == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');
            // $row[] = ActionButton($value->id);
            $row[] = '<a class="btn btn-primary btn-xs" href="subscription/view/' . Crypt::encryptString($value->id) . '" class="text-blue" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i> </a>

                <a class="btn btn-success btn-xs" href="subscription/edit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>

                <a class="btn btn-danger btn-xs delete-data text-danger" data-toggle="tooltip" title="Delete" data-delete=' . Crypt::encryptString($value->id) . '> <i class="fa fa-trash-o"></i> </a>';


            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $subs->Countall(),
            "recordsFiltered" => $subs->Countfiltered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function create() {

        $lang = DB::select('select * from tbl_language WHERE status="1"');

        $data = [
            'titles' => 'Create Subscription',
            'lang' => $lang,
        ];
        return view('admin.subscription.create', $data);
    }

    public function store(Request $request) {
        if ($request) {

            $all = $request->all();

            $subs = new Subscription();

            $filename = '';
            $file = $request->file('subscription_image');
            if (!empty($file)) {
                $destinationPath = 'public/uploads/subscription';
                $filename = $destinationPath . '/' . uniqid() . $file->getClientOriginalName();
                $filedata = $file->move($destinationPath, $filename);
            }

            $data = $this->validate($request, [
                //'language_id' => 'required',
                'subscription_name' => 'required',
                'subscription_type' => 'required',
                'status' => 'required',
            ]);
            $subs->subscription_image = $filename;
            $subs->subscription_name = $all['subscription_name'];
            $subscription_type = $subs->subscription_type = $all['subscription_type'];
            $subs->subscription_rate = $all['subscription_rate'];
            $subs->description = $all['description'];

            if ($subs->save()) {
                return redirect('/admin/subscription')->with('success', 'Subscription Added Successfully!');
            } else {
                return redirect('/admin/subscription');
            }
        } else {
            return redirect('/admin/subscription');
        }
    }

    public function view($id) {
        // $model = new Page();
        $result = Subscription::where('id', '=', Crypt::decryptString($id))->first()->toArray();
        // print_r($result);die;
        $result['subscription_type'] = $this->subscriptionType[$result['subscription_type']];

        $data = [
            'titles' => 'View Subscription',
            'data' => $result,
        ];

        return view('admin.subscription.view', $data);
    }

    public function edit($id) {
        $res = Subscription::where('id', Crypt::decryptString($id))->first();
        $lang = DB::select('select * from tbl_language WHERE status="1"');
        $data = [
            'titles' => 'Update Subscription',
            'data' => $res,
            'lang' => $lang,
        ];

        return view('admin.subscription.create', $data);
    }

    public function update(Request $request, $id) {
        if ($request->isMethod('post')) {
//        echo '<pre>';
    //    dd($request->all()); die;
            $all = $request->all();

            $subs = new Subscription();

            $filename = $request->input('subscription_upload');
            $file = $request->file('subscription_image');
            if (!empty($file)) {
                $destinationPath = 'public/uploads/subscription';
                $filename = $destinationPath . '/' . uniqid() . $file->getClientOriginalName();
                $filedata = $file->move($destinationPath, $filename);
            }
            $data = $this->validate($request, [
//            'language_id' => 'required',
                'subscription_name' => 'required',
                'subscription_type' => 'required',
                'subscription_rate' => 'required',
                'status' => 'required',
            ]);
            // $data['subscription_image'] = $filename;

            $data['id'] = Crypt::decryptString($id);
            $subs = Subscription::find($data['id']);
            $subs->subscription_image = $filename;
            $subs->subscription_name = $all['subscription_name'];
            $subs->subscription_type = $all['subscription_type'];
            $subs->subscription_rate = $all['subscription_rate'];
            $subs->description = $all['description'];
            $subs->status = $all['status'];
            if ($subs->save()) {
                return redirect('/admin/subscription')->with('success', 'Subscription Update Successfully!');
            } else {
                return redirect('/admin/subscription/edit/' . Crypt::decryptString($id))->with('error', 'Something went wrong please try after sometime!');
            }
        }
    }

    public function destroy(Request $request) {
        //check user existance plan

        $faq = Subscription::find(Crypt::decryptString($request->id));
        $result = $faq->delete();
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function my_subscription() {
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            $balanceDay = 0;
            //check plan
            $myPlan = DB::select("select * from tbl_user_subscriptions WHERE user_id = $loggedInUser AND payment_status =1 ORDER BY created_at DESC LIMIT 1");
            if (!empty($myPlan)) {
                $buyDate = $myPlan[0]->created_at;
                $planType = $myPlan[0]->subscription_type;
                if ($planType == 1) {
                    $expiryDate = date("Y-m-d H:i:s", strtotime('+30 days', strtotime($buyDate)));
                    $balanceDay = round((strtotime($expiryDate) - strtotime(date("Y-m-d H:i:s"))) / (60 * 60 * 24));
                }
                if ($planType == 2) {
                    $expiryDate = date("Y-m-d H:i:s", strtotime('+365 days', strtotime($buyDate)));
                    $balanceDay = round((strtotime($expiryDate) - strtotime(date("Y-m-d H:i:s"))) / (60 * 60 * 24));
                }

                if ($planType == 3) {
                    $expiryDate = date("Y-m-d H:i:s", strtotime('+30 days', strtotime($buyDate)));
                    $balanceDay = round((strtotime($expiryDate) - strtotime(date("Y-m-d H:i:s"))) / (60 * 60 * 24));
                }
                if ($planType == 4) {
                    $expiryDate = date("Y-m-d H:i:s", strtotime('+365 days', strtotime($buyDate)));
                    $balanceDay = round((strtotime($expiryDate) - strtotime(date("Y-m-d H:i:s"))) / (60 * 60 * 24));
                }
            } 

            if ($balanceDay > 0) {
                $myPlan[0]->balance_day = $balanceDay;
                $subs = $myPlan;
            } else {
                $subs = array();
            }

            $data = [
                'titles' => 'Subscription List',
                'subscription' => $subs,
                'subscriptionType' => $this->subscriptionType
            ];
            return view('frontend.subscription.my-subscription', $data);
        } else {
            return redirect('/');
        }
    }

    public function subscription_list() {
        if (Auth::guard('user')->check()) {

            $subsMonthly = DB::select('select * from subscriptions WHERE subscription_type =1 AND `status`=1 ORDER BY created_at DESC LIMIT 1');

            $subsYearly = DB::select("select * from subscriptions WHERE subscription_type =2 AND `status`=1 ORDER BY created_at DESC LIMIT 1");

            $proSubsMonthly = DB::select('select * from subscriptions WHERE subscription_type =3 AND `status`=1 ORDER BY created_at DESC LIMIT 1');

            $proSubsYearly = DB::select("select * from subscriptions WHERE subscription_type =4 AND `status`=1 ORDER BY created_at DESC LIMIT 1");

            // $subs = array_merge($subsMonthly, $subsYearly, $proSubsMonthly, $proSubsYearly);

            $subs = array_merge($subsMonthly, $subsYearly);
            $subs2 = array_merge($proSubsMonthly, $proSubsYearly);
            
            $data = [
                'titles' => 'Subscription List',
                'subscription' => $subs,
                'subscription2' => $subs2,
                'subscriptionType' => $this->subscriptionType
            ];
            return view('frontend.subscription.subscription-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function userSubscription() {
        $data = [
            'title' => 'User Subscription List'
        ];
        return view('admin.subscription.user-subscription', $data);
    }

    public function user_subscription_datalist() {//echo "test";die;
        $userSubs = new UserSubscription();
        $res = $userSubs->Datatables();
        // $res = Faq::where('deleted_at','=', null)->get();
        //echo "<pre>";print_r($res);die;

        $data = [];
        $no = $_POST['start'];

        foreach ($res as $value) {
            $no++;

            $row = [];
            $row[] = $no;
            $row[] = '<a data-toggle="tooltip" title="View User Detail" href="' . url('admin/user/view', $value->user_id) . '">' . $value->user_email . '</a>';
            $row[] = $this->subscriptionType[$value->subscription_type];
            $row[] = $value->subscription_rate;
            $row[] = $value->created_at;
            if ($value->subscription_type == 1) {
                $expiryDate = date("Y-m-d H:i:s", strtotime('+30 days', strtotime($value->created_at)));
                $row[] = $expiryDate;
                $balanceDay = round((strtotime($expiryDate) - strtotime(date("Y-m-d H:i:s"))) / (60 * 60 * 24));
                $row[] = ($balanceDay > 0 ? '<span class="label label-success">' . $balanceDay . '</span>' : '<span class="label label-danger">Expired</span>');
            }
            if ($value->subscription_type == 2) {
                $expiryDate = date("Y-m-d H:i:s", strtotime('+365 days', strtotime($value->created_at)));
                $row[] = $expiryDate;
                $balanceDay = round((strtotime($expiryDate) - strtotime(date("Y-m-d H:i:s"))) / (60 * 60 * 24));
                $row[] = ($balanceDay > 0 ? '<span class="label label-success">' . $balanceDay . '</span>' : '<span class="label label-danger">Expired</span>');
            }

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $userSubs->Countall(),
            "recordsFiltered" => $userSubs->Countfiltered(),
            "data" => $data
        );

        echo json_encode($output);
    }

}
