<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use App\Social;

class SocialController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        $data = [
            'title' => 'Social Media'
        ];
        return view('admin.social.index', $data);
    }

    public function Sociallist() {

        $model = new Social();
        $res = $model->Datatables();

        $data = [];
        $no = $_POST['start'];

        foreach ($res as $value) {
            $no++;

            $row = [];
            $row[] = $no;
            $row[] = $value->name;
            $row[] = $value->link;
            $row[] = $value->icon;
            $row[] = ($value->status == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');
            // $row[] = ActionButton($value->id);
            $row[] = '<a class="btn btn-success btn-xs" href="social/edit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>

                 <!--<a class="btn btn-danger btn-xs delete-data text-danger" data-toggle="tooltip" title="Delete" data-delete=' . Crypt::encryptString($value->id) . '> <i class="fa fa-trash-o"></i> </a>-->';

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $model->Countall(),
            "recordsFiltered" => $model->Countfiltered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function create() {

        $data = [
            'title' => 'Create Social',
        ];
        return view('admin.social.create', $data);
    }

    public function store(Request $request) {
        if ($request->isMethod('post')) {
            $model = new Social();

            $data = $this->validate($request, [
                'name' => 'required',
                'link' => 'required',
                'icon' => 'required',
                'status' => 'required',
            ]);
            $data['created_by'] = auth()->user()->id;
//            echo '<pre>';
//            print_r($data);
//            die;
            $res = DB::table('tbl_social_media')->insert($data);
            if ($res) {
                return redirect('/admin/social')->with('success', 'Social Media Add Successfully!');
            } else {
                return redirect('/admin/social')->with('error', 'Something went wrong please try after sometime!');
            }
        } else {

            return redirect('/admin/social');
        }
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $res = Social::where('id', Crypt::decryptString($id))->first();

        $data = [
            'title' => 'Edit Social',
            'data' => $res,
        ];
        return view('admin.social.create', $data);
    }

    public function update(Request $request, $id) {
        $model = new Social();
        $data = $this->validate($request, [
            'name' => 'required',
            'link' => 'required',
            'icon' => 'required',
            'status' => 'required',
        ]);
        $data['updated_by'] = auth()->user()->id;
//        echo '<pre>';
//        print_r($data);
//        die;

        $result = DB::table('tbl_social_media')->where('id', Crypt::decryptString($id))->update($data);

        if ($result) {
            return redirect('/admin/social')->with('success', 'Social Media Update Successfully!');
        } else {
            return redirect('/admin/social/edit/' . $id)->with('error', 'Something went wrong please try after sometime!');
        }
    }

    public function destroy(Request $request) {

        $model = Social::find(Crypt::decryptString($request->id));
        $result = $model->delete();
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

}
