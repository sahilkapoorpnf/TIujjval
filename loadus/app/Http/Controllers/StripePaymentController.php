<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Subscription;
use Illuminate\Support\Facades\Crypt;
use DB;
use Auth;
use App\UserSubscription;
use App\User;
use App\GroupFlowerPayment;
use App\Strip;

class StripePaymentController extends Controller {

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth:admin')->except(array('stripe', 'stripePost'));
        // $this->middleware('auth:user');
    }

    public function index() {
        $data = [
            'title' => 'Strip Info List'
        ];
        return view('admin.strip.index', $data);
    }

    public function Datalist() {
        $subs = new Strip();
        $res = $subs->Datatables();
        // $res = Faq::where('deleted_at','=', null)->get();
        //echo "<pre>";print_r($res);die;

        $data = [];
        $no = $_POST['start'];

        foreach ($res as $value) {
            $no++;

            $row = [];
            $row[] = $no;
            $row[] = $value->strip_name;
            $row[] = $value->strip_secret_key;
            $row[] = $value->strip_public_key;
            $row[] = $value->description;
            $row[] = ($value->status == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');
            // $row[] = ActionButton($value->id);
            $row[] = '<a class="btn btn-success btn-xs" href="stripedit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>';


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

    public function edit($id) {
        $res = Strip::where('id', Crypt::decryptString($id))->first();
        $lang = DB::select('select * from tbl_language WHERE status="1"');
        $data = [
            'titles' => 'Update Subscription',
            'data' => $res,
            'lang' => $lang,
        ];

        return view('admin.strip.create', $data);
    }

    public function update(Request $request, $id) {
        if ($request->isMethod('post')) {
//        echo '<pre>';
            //    dd($request->all()); die;
            $all = $request->all();

            $subs = new Strip();
            $data = $this->validate($request, [
//            'language_id' => 'required',
                'strip_name' => 'required',
                'strip_secret_key' => 'required',
                'strip_public_key' => 'required'
            ]);
            // $data['subscription_image'] = $filename;

            $data['id'] = Crypt::decryptString($id);
            $subs = Strip::find($data['id']);
            $subs->strip_name = $all['strip_name'];
            $subs->strip_secret_key = $all['strip_secret_key'];
            $subs->strip_public_key = $all['strip_public_key'];
            $subs->description = $all['description'];
            if ($subs->save()) {
                return redirect('/admin/stripeinfo')->with('success', 'Subscription Update Successfully!');
            } else {
                return redirect('/admin/stripedit/' . Crypt::decryptString($id))->with('error', 'Something went wrong please try after sometime!');
            }
        }
    }

    public function stripe(Request $request) {
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            $subs = DB::select("select * from subscriptions WHERE `id` = " . Crypt::decryptString($request->id) . " AND status=1");
            $lang = DB::select('select * from tbl_language WHERE status="1"');
            $user = DB::select("select * from users WHERE `id` = $loggedInUser AND status=1");
            $stripeDetails = DB::table('tbl_strips')->where(array('status' => 1))->first();
            $data = [
                'titles' => 'Update Subscription',
                'subsData' => $subs,
                'userData' => $user,
                'lang' => $lang,
                'strip_key'=>$stripeDetails->strip_public_key
            ];
            return view('stripe', $data);
        } else {
            return redirect('/signup');
        }
    }

    public function stripeFlower() {

        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            $flowerplanDetails = DB::table('tbl_flower_subscription_plans')->where(array('id' => 1, 'status'=>1))->first();
            $stripeDetails = DB::table('tbl_strips')->where(array('status' => 1))->first();
            if(!empty($flowerplanDetails)){
                $data = [
                    'titles' => 'Flower Payment',
                    'flowerplanDetails'=>$flowerplanDetails,
                    'strip_key'=>$stripeDetails->strip_public_key
                ];
                return view('frontend.flower.stripeFlower', $data);
            }else{
                Session::flash('message', 'Flower plan not found');
                Session::flash('alert-class', 'alert-success'); 
                return redirect()->action([FlowerController::class, 'created_flowers']);
            }
            
        } else {
            return redirect('/login');
        }
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function stripePost(Request $request) {
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;
            $post = $request->all();
            // dd($request->id);
            if(!empty($request->id)){
            // $subs = DB::select("select * from subscriptions WHERE `id` = " . Crypt::decryptString($request->id) . " AND status=1");
            
                $planDetails = Subscription::where(array('id'=>Crypt::decryptString($request->id), 'status'=>1))->first();
                $stripeDetails = DB::table('tbl_strips')->where(array('status' => 1))->first();
                
                
                if(!empty($planDetails)){
                    if(!empty($planDetails->subscription_rate)){
                        $planRate = round($planDetails->subscription_rate*100);
                        //dd($planRate);
                        Stripe\Stripe::setApiKey($stripeDetails->strip_secret_key);
                        $response = Stripe\Charge::create([
                            "amount" => $planRate,
                            "currency" => "usd",
                            "source" => $request->stripeToken,
                            "description" => "payment from loadus"
                        ]);
                        if ($response['status'] == 'succeeded') {
                            $subs = new UserSubscription();
                            $subs->user_id = $loggedInUser;
                            $subs->user_email = $user_auth->email;
                            $subs->subscription_type = $request->subscription_type;
                            $subs->subscription_rate = $planDetails->subscription_rate;
                            $subs->subscription_id = $planDetails->id;
                            $subs->description = $planDetails->description;
                            $subs->payment_mode = 1;
                            $subs->payment_status = 1;
                            $subs->payment_by = 2;
                            $subs->transaction_id = $response['id'];
                            $subs->payment_date = date("Y-m-d H:i:s");
                            $subs->save();
                            Session::flash('success', 'Payment successful!');
                            return back();
                        } else {
                            Session::flash('failure', 'Payment failed!');
                            return back();
                        }
                    }else{
                        Session::flash('message', 'Invalid plan, please try again!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect('/subscription_list');
                    
                    }
                }else{
                    Session::flash('message', 'Plan not found, please try again!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect('/subscription_list');
                }
            }else{
                Session::flash('message', 'Invalid request!!');
                Session::flash('alert-class', 'alert-danger');
                return redirect('/subscription_list');
            }
        }else{
            return redirect('/login');
        }
        
        
    }
    /***Payment made by user on loadus to create flower */
    public function flowerPayment(Request $request) {

        $post = $request->all();
        if (Auth::guard('user')->check()) {
            $user_auth = Auth::guard('user')->user();
            $loggedInUser = $user_auth->id;

            // $flowerplanDetails = '99';
            $flowerplanDetails = DB::table('tbl_flower_subscription_plans')->where(array('id' => 1, 'status'=>1))->first();
            $stripeDetails = DB::table('tbl_strips')->where(array('status' => 1))->first();
            
            if(!empty($flowerplanDetails)){
                if(!empty($flowerplanDetails->plan_rate)){
                    $planRate = round(($flowerplanDetails->plan_rate)*100);
                    //dd($planRate);
                    Stripe\Stripe::setApiKey($stripeDetails->strip_secret_key);
                    $response = Stripe\Charge::create([
                        "amount" => $planRate,
                        "currency" => "usd",
                        "source" => $request->stripeToken,
                        "description" => "flower creation payment from loadus"
                    ]);
                    if ($response['status'] == 'succeeded') {
                        $subs = new GroupFlowerPayment();
                        $subs->user_id = $loggedInUser;
                        $subs->amount = $flowerplanDetails->plan_rate;
                        $subs->payment_status = 1;
                        $subs->transaction_id = $response['id'];
                        $subs->save();
                        Session::flash('success', 'Payment successful!');
                        // return back();
                        return redirect()->action([FlowerController::class, 'create']);
                    } else {
                        Session::flash('failure', 'Payment failed!');
                        return back();
                    }
                } else {
                    Session::flash('message', 'Invalid plan, please try again!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect('/created-flowers');
                
                }
            } else {
                Session::flash('message', 'Plan not found, please try again!');
                Session::flash('alert-class', 'alert-danger');
                return redirect('/created-flowers');
            }
        }else{
            Session::flash('message', 'Session expired, please login again!!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/login');
        }
    }

}
