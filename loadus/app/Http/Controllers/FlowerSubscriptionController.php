<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Auth;
use App\FlowerSubscription;

class FlowerSubscriptionController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin')->except('FlowerSubsList');
    }

    public function index() {
        $data = [
            'title' => 'Flower Subscription List'
        ];
        return view('admin.flowerSubscription.index', $data);
    }

    public function datalist() {

        $subs = new FlowerSubscription();
        $res = $subs->Datatables();

        $data = [];
        $no = $_POST['start'];

        foreach ($res as $value) {
            $no++;

            $row = [];
            $row[] = $no;
            $row[] = $value->plan_name;
            $row[] = $value->plan_rate;
            $row[] = $value->description;
            $row[] = ($value->status == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');
            // $row[] = ActionButton($value->id);
            $row[] = '<a class="btn btn-success btn-xs" href="flowsubsedit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>';


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
        $res = FlowerSubscription::where('id', Crypt::decryptString($id))->first();
        $lang = DB::select('select * from tbl_language WHERE status="1"');
        $data = [
            'titles' => 'Update Flower Subscription',
            'data' => $res,
            'lang' => $lang,
        ];

        return view('admin.flowerSubscription.create', $data);
    }

    public function update(Request $request, $id) {
        if ($request->isMethod('post')) {
            $all = $request->all();

            $subs = new FlowerSubscription();

            $data = $this->validate($request, [
//            'language_id' => 'required',
                'plan_name' => 'required',
                'plan_rate' => 'required'
            ]);

            $data['id'] = Crypt::decryptString($id);
            $subs = FlowerSubscription::find($data['id']);
            $subs->plan_name = $all['plan_name'];
            $subs->plan_rate = $all['plan_rate'];
            $subs->description = $all['description'];
            if ($subs->save()) {
                return redirect('/admin/flowerSubs')->with('success', 'Subscription Update Successfully!');
            } else {
                return redirect('/admin/flowsubsedit/' . Crypt::decryptString($id))->with('error', 'Something went wrong please try after sometime!');
            }
        }
    }

    public function FlowerSubsList() {
        if (Auth::guard('user')->check()) {

            $flowSubsList = DB::select('select * from tbl_flower_subscription_plans WHERE `status`=1 ORDER BY created_at DESC LIMIT 1');

            $data = [
                'titles' => 'Flower Subscription Plan',
                'subscription' => $flowSubsList
            ];
            return view('frontend.flower.subscription-list', $data);
        } else {
            return redirect('/');
        }
    }

}
