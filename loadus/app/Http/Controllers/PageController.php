<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Facades\Crypt;
use DB;
use Mail;
use Psy\Util\Json;

class PageController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }
    public function index() {
        $data = [
            'title' => 'Pages List'
        ];
        return view('admin.page.index', $data);
    }

    public function Datalist() {

        $arvind = new Page();
        $res = $arvind->Datatables();

        $data = [];
        $no = $_POST['start'];

        foreach ($res as $value) {
            $no++;

            $row = [];
            $row[] = $no;
//            $row[] = $value->language;
            $row[] = $value->title;
            //$row[] = strlen($value->description) > 80 ? substr($value->description, 0, 80) . "...." : $value->description;
            $row[] = $value->slug;
            $row[] = ($value->status == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');
            // $row[] = ActionButton($value->id);
            $row[] = '<a class="btn btn-primary btn-xs" href="page/view/' . Crypt::encryptString($value->id) . '" class="text-blue" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i> </a>

                <a class="btn btn-success btn-xs" href="page/edit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>

                <a class="btn btn-danger btn-xs delete-data text-danger" data-toggle="tooltip" title="Delete" data-delete=' . Crypt::encryptString($value->id) . '> <i class="fa fa-trash-o"></i> </a>';


            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $arvind->Countall(),
            "recordsFiltered" => $arvind->Countfiltered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function create() {

        $lang = DB::select('select * from tbl_language WHERE status="1"');

        $data = [
            'titles' => 'Create Page',
            'lang' => $lang,
        ];
        return view('admin.page.create', $data);
    }

    public function store(Request $request) {
        if ($request) {
//             echo '<pre>';
//              dd($request); die;
            $page = new Page();

            $filename = '';
            $file = $request->file('featured_img');
            if (!empty($file)) {
                $destinationPath = 'public/uploads';
                $filename = $destinationPath . '/' . uniqid() . $file->getClientOriginalName();
                $filedata = $file->move($destinationPath, $filename);
            }

            $data = $this->validate($request, [
                //'language_id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'status' => 'required',
            ]);
            $data['language_id'] = 1;
            $data['featured_img'] = $filename;
            $data['meta_title'] = $request->input('meta_title');
            $data['meta_description'] = $request->input('meta_description');
            $data['meta_key'] = $request->input('meta_key');
            $page->saveData($data);
            return redirect('/admin/page')->with('success', 'Page Add Successfully!');
        } else {
            return redirect('/admin/page');
        }
    }

    public function edit($id) {
        $res = Page::where('id', Crypt::decryptString($id))->first();
        $lang = DB::select('select * from tbl_language WHERE status="1"');
        $data = [
            'titles' => 'Update Page',
            'data' => $res,
            'lang' => $lang,
        ];

        return view('admin.page.create', $data);
    }

    public function update(Request $request, $id) {
        if ($request->isMethod('post')) {
//        echo '<pre>';
//        dd($request); die;
            $page = new Page();
            $filename = $request->input('featured_upload');
            $file = $request->file('featured_img');
            if (!empty($file)) {
                $destinationPath = 'public/uploads';
                $filename = $destinationPath . '/' . uniqid() . $file->getClientOriginalName();
                $filedata = $file->move($destinationPath, $filename);
            }
            $data = $this->validate($request, [
//            'language_id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'status' => 'required',
            ]);
            $data['language_id'] = 1;
            $data['featured_img'] = $filename;
            $data['meta_title'] = $request->input('meta_title');
            $data['meta_description'] = $request->input('meta_description');
            $data['meta_key'] = $request->input('meta_key');

            $data['id'] = Crypt::decryptString($id);
//        echo '<pre>';
//        print_r($data); die;
            $result = $page->updateData($data);
            if ($result) {
                return redirect('/admin/page')->with('success', 'Page Update Successfully!');
            } else {
                return redirect('/admin/page/edit/' . Crypt::decryptString($id))->with('error', 'Something went wrong please try after sometime!');
            }
        }
    }

    public function destroy(Request $request) {

        $page = Page::find(Crypt::decryptString($request->id));
        $result = $page->delete();
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function view($id) {
        $model = new Page();
        $result = $model->view(Crypt::decryptString($id));
        // print_r($result);die;

        $data = [
            'titles' => 'View Page',
            'data' => $result,
        ];

        return view('admin.page.view', $data);
    }

    public function email() {

        Mail::send('emails.welcome', ['name' => "Arvind Kumar Singh"], function($message) {
            $message->from('flattern@gmail.com', 'Flattern');
            $message->to('arvind.singh@sourcesoftsolutions.com', 'Tutorials Point')->subject('Laravel Basic Testing Mail');
        });
        echo "Basic Email Sent. Check your inbox.";
    }

    public function uploadfile(Request $request) {
        $file = $request->file('file');
        $destinationPath = 'public/uploads';
        $filename = $destinationPath . '/' . uniqid() . $request->files->get('file')->getClientOriginalName();
        $filedata = $file->move($destinationPath, $filename);
//        echo $request->files->get('file')->getClientOriginalName();
//        echo $filename;
        return json_encode(['location' => url('/') . '/' . $filename]);

//        $imgpath = request()->file('file')->store('uploads', 'public');
//        return response()->json_encode(['location' => $imgpath]);
    }

}
