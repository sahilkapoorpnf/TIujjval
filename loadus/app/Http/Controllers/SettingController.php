<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
Use DB;
Use App\Setting;

class SettingController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }
    public function index() {
        $data = [
            'title' => 'Home Page Settings'
        ];
        return view('admin.setting.index', $data);
    }

    public function Settinglist() {

        $model = new Setting();
        $res = $model->Datatables();

        $data = [];
        $no = $_POST['start'];

        foreach ($res as $value) {
            $no++;

            $row = [];
            $row[] = $no;
            $row[] = $value->title;
            $row[] = strlen($value->description) > 50 ? substr(preg_replace(['#<[^>]+>#'],' ',$value->description), 0, 50) . "...." : $value->description;
           
          //  $row[] = ($value->status == '0' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');
            // $row[] = ActionButton($value->id);
            $row[] = '<a class="btn btn-success btn-xs" href="setting/edit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>';

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
            'title' => 'Create Home Page Settings',
        ];

        return view('admin.setting.create', $data);
    }

    public function store(Request $request) {
        if ($request->isMethod('post')) {
            $model = new Setting();

            $data = $this->validate($request, [
                'status' => 'required',
            ]);
//            print_r($data);
//            die;
            //$res = $model->saveData($data);
            if ($res) {
                return redirect('/admin/country')->with('success', 'Setting Add Successfully!');
            } else {
                return redirect('/admin/country')->with('error', 'Something went wrong please try after sometime!');
            }
        } else {

            return redirect('/admin/state');
        }
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $res = Setting::where('id', Crypt::decryptString($id))->first();
        $data = [
            'title' => 'Edit Home Page Settings',
            'data' => $res,
        ];
        return view('admin.setting.create', $data);
    }

    public function update(Request $request, $id) {
        $model = new Setting();
        $data = $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,gif',
            'description' => 'required',
        ]);

        $data['status'] = '0';
        
        $filename = '';
        $file = $request->file('image');

        if (!empty($file)) {
            $destinationPath = 'public/uploads';
            $filename = $destinationPath . '/' . uniqid() . $file->getClientOriginalName();
            $filedata = $file->move($destinationPath, $filename);
            $data['image'] = $filename;
        }
//        echo '<pre>';
//        print_r($data);
//        die;

        $result = Setting::where('id', Crypt::decryptString($id))->update($data);
        if ($result) {
            return redirect('/admin/setting')->with('success', 'Setting Update Successfully!');
        } else {
            return redirect('/admin/setting/edit/' . $id)->with('error', 'Something went wrong please try after sometime!');
        }
    }

    
    

}
