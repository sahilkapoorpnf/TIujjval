<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Auth;
use App\Banner;

class BannerController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        $data = [
            'title' => "Banner"
        ];
        return view('admin.banner.index', $data);
    }

    public function datalist() {

        $subs = new Banner();
        $res = $subs->Datatables();

        $data = [];
        $no = $_POST['start'];

        foreach ($res as $value) {
            $no++;

            $row = [];
            $row[] = $no;
            $row[] = $value->banner_name;
            $row[] = '<img src='.asset($value->banner_image). '>';
            $row[] = $value->description;
            $row[] = $value->read_more_link;
            $row[] = ($value->status == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');
            // $row[] = ActionButton($value->id);
            $row[] = '<a class="btn btn-success btn-xs" href="banner/edit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>';


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
        $res = Banner::where('id', Crypt::decryptString($id))->first();
        $lang = DB::select('select * from tbl_language WHERE status="1"');
        $data = [
            'titles' => 'Update Banner',
            'data' => $res,
            'lang' => $lang,
        ];

        return view('admin.banner.create', $data);
    }

    public function update(Request $request, $id) {
        if ($request->isMethod('post')) {
//        echo '<pre>';
            //    dd($request->all()); die;
            $all = $request->all();

            $subs = new Banner();

            $filename = $request->input('banner_upload');
            $file = $request->file('banner_image');
            if (!empty($file)) {
                $destinationPath = 'public/uploads/banner';
                $filename = $destinationPath . '/' . uniqid() . $file->getClientOriginalName();
                $filedata = $file->move($destinationPath, $filename);
            }
            $data = $this->validate($request, [
//            'language_id' => 'required',
                'banner_name' => 'required'
            ]);
            // $data['subscription_image'] = $filename;

            $data['id'] = Crypt::decryptString($id);
            $subs = Banner::find($data['id']);
            $subs->banner_image = $filename;
            $subs->banner_name = $all['banner_name'];
            $subs->description = $all['description'];
            $subs->read_more_link = $all['read_more_link'];
            if ($subs->save()) {
                return redirect('/admin/banner')->with('success', 'Subscription Update Successfully!');
            } else {
                return redirect('/admin/banner/edit/' . Crypt::decryptString($id))->with('error', 'Something went wrong please try after sometime!');
            }
        }
    }

}
