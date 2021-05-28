<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;
use Illuminate\Support\Facades\Crypt;
use DB;

class FaqController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }
    public function index() {
        $data = [
            'title' => 'Faq List'
        ];
        return view('admin.faq.index', $data);
    }

    public function Datalist() {

    	$faq = new Faq();
        $res = $faq->Datatables();
        // $res = Faq::where('deleted_at','=', null)->get();
        // echo "<pre>";print_r($res);die;

        $data = [];
        $no = $_POST['start'];

        foreach ($res as $value) {
            $no++;

            $row = [];
            $row[] = $no;
            $row[] = $value->question;
            $row[] = ($value->status == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');
            // $row[] = ActionButton($value->id);
            $row[] = '<a class="btn btn-primary btn-xs" href="faq/view/' . Crypt::encryptString($value->id) . '" class="text-blue" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i> </a>

                <a class="btn btn-success btn-xs" href="faq/edit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>

                <a class="btn btn-danger btn-xs delete-data text-danger" data-toggle="tooltip" title="Delete" data-delete=' . Crypt::encryptString($value->id) . '> <i class="fa fa-trash-o"></i> </a>';


            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $faq->Countall(),
            "recordsFiltered" => $faq->Countfiltered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function create() {

        $lang = DB::select('select * from tbl_language WHERE status="1"');

        $data = [
            'titles' => 'Create Faq',
            'lang' => $lang,
        ];
        return view('admin.faq.create', $data);
    }

    public function store(Request $request) {
        if ($request) {

        	$all=$request->all();

            $faq = new Faq();

            // $filename = '';
            // $file = $request->file('featured_img');
            // if (!empty($file)) {
            //     $destinationPath = 'public/uploads/faqs';
            //     $filename = $destinationPath . '/' . uniqid() . $file->getClientOriginalName();
            //     $filedata = $file->move($destinationPath, $filename);
            // }

            $data = $this->validate($request, [
                //'language_id' => 'required',
                'question' => 'required',
                'answer' => 'required',
                'status' => 'required',
            ]);
            // $data['featured_img'] = $filename;
            $faq->question = $all['question'];
            $faq->answer = $all['answer'];
            $faq->status = $all['status'];
            if($faq->save()){
            	return redirect('/admin/faq')->with('success', 'Faq Add Successfully!');
            }else{
            	return redirect('/admin/faq');
            }
            
        } else {
            return redirect('/admin/faq');
        }
    }

    public function edit($id) {
        $res = Faq::where('id', Crypt::decryptString($id))->first();
        $lang = DB::select('select * from tbl_language WHERE status="1"');
        $data = [
            'titles' => 'Update Faq',
            'data' => $res,
            'lang' => $lang,
        ];

        return view('admin.faq.create', $data);
    }

    public function update(Request $request, $id) {
        if ($request->isMethod('post')) {
//        echo '<pre>';
//        dd($request); die;
            $all=$request->all();

            $faq = new Faq();

            // $filename = $request->input('featured_upload');
            // $file = $request->file('featured_img');
            // if (!empty($file)) {
            //     $destinationPath = 'public/uploads/faqs';
            //     $filename = $destinationPath . '/' . uniqid() . $file->getClientOriginalName();
            //     $filedata = $file->move($destinationPath, $filename);
            // }
            $data = $this->validate($request, [
//            'language_id' => 'required',
                'question' => 'required',
                'answer' => 'required',
                'status' => 'required',
            ]);
            // $data['featured_img'] = $filename;

            $data['id'] = Crypt::decryptString($id);
            $faq=Faq::find($data['id']);

            $faq->question = $all['question'];
            $faq->answer = $all['answer'];
            $faq->status = $all['status'];
            if ($faq->save()) {
                return redirect('/admin/faq')->with('success', 'Faq Update Successfully!');
            } else {
                return redirect('/admin/faq/edit/' . Crypt::decryptString($id))->with('error', 'Something went wrong please try after sometime!');
            }
        }
    }

    public function destroy(Request $request) {

        $faq = Faq::find(Crypt::decryptString($request->id));
        $result = $faq->delete();
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function view($id) {
        // $model = new Page();
        $result = Faq::where('id','=', Crypt::decryptString($id))->first()->toArray();
         // print_r($result);die;

        $data = [
            'titles' => 'View Faq',
            'data' => $result,
        ];

        return view('admin.faq.view', $data);
    }

    

    public function uploadfile(Request $request) {
        $file = $request->file('file');
        $destinationPath = 'public/uploads/faqs';
        $filename = $destinationPath . '/' . uniqid() . $request->files->get('file')->getClientOriginalName();
        $filedata = $file->move($destinationPath, $filename);
//        echo $request->files->get('file')->getClientOriginalName();
//        echo $filename;
        return json_encode(['location' => url('/') . '/' . $filename]);

//        $imgpath = request()->file('file')->store('uploads', 'public');
//        return response()->json_encode(['location' => $imgpath]);
    }

}
