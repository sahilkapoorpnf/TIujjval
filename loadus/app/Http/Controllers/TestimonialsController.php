<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Testimonials;
use Illuminate\Support\Facades\Crypt;
use DB;
use Auth;
use App\User;

class TestimonialsController extends Controller {

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
            'title' => 'Testimonials List'
        ];
        return view('admin.testimonials.index', $data);
    }

    public function Datalist() {
        $subs = new Testimonials();
        $res = $subs->Datatables();
        // $res = Faq::where('deleted_at','=', null)->get();
        //echo "<pre>";print_r($res);die;

        $data = [];
        $no = $_POST['start'];

        foreach ($res as $value) {
            $no++;

            $row = [];
            $row[] = $no;
            //$row[] = $value->title;
            $row[] = $value->description;
            $row[] = $value->client_name;
            $row[] = ($value->status == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');
            // $row[] = ActionButton($value->id);
            $row[] = '<a class="btn btn-primary btn-xs" href="testimonials/view/' . Crypt::encryptString($value->id) . '" class="text-blue" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i> </a>
                     <a class="btn btn-success btn-xs" href="testimonials/edit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>
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
            'titles' => 'Create Testimonials',
            'lang' => $lang,
        ];
        return view('admin.testimonials.create', $data);
    }

    public function store(Request $request) {
        if ($request) {

            $all = $request->all();

            $subs = new Testimonials();

            $filename = '';
            $file = $request->file('image');
            if (!empty($file)) {
                $destinationPath = 'public/uploads/testimonials';
                $filename = $destinationPath . '/' . uniqid() . $file->getClientOriginalName();
                $filedata = $file->move($destinationPath, $filename);
            }

            $data = $this->validate($request, [
                //'language_id' => 'required',
                'client_name' => 'required',
                'description' => 'required',
                'status' => 'required',
            ]);
            $subs->image = $filename;
            //$subs->title = $all['title'];
            $subs->client_name = $all['client_name'];
            $subs->description = $all['description'];

            if ($subs->save()) {
                return redirect('/admin/testimonials')->with('success', 'Testimonials Added Successfully!');
            } else {
                return redirect('/admin/testimonials');
            }
        } else {
            return redirect('/admin/testimonials');
        }
    }

    public function view($id) {
        // $model = new Page();
        $result = Testimonials::where('id', '=', Crypt::decryptString($id))->first()->toArray();

        $data = [
            'titles' => 'View Testimonials',
            'data' => $result,
        ];

        return view('admin.testimonials.view', $data);
    }

    public function edit($id) {
        $res = Testimonials::where('id', Crypt::decryptString($id))->first();
        $lang = DB::select('select * from tbl_language WHERE status="1"');
        $data = [
            'titles' => 'Update Testimonials',
            'data' => $res,
            'lang' => $lang,
        ];

        return view('admin.testimonials.create', $data);
    }

    public function update(Request $request, $id) {
        if ($request->isMethod('post')) {
//        echo '<pre>';
            //    dd($request->all()); die;
            $all = $request->all();

            $subs = new Testimonials();
            $data = $this->validate($request, [
//            'language_id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'client_name' => 'required'
            ]);
            $filename = $request->input('testimonials_upload');
            $file = $request->file('image');
            if (!empty($file)) {
                $destinationPath = 'public/uploads/testimonials';
                $filename = $destinationPath . '/' . uniqid() . $file->getClientOriginalName();
                $filedata = $file->move($destinationPath, $filename);
            }
            $data['image'] = $filename;

            $data['id'] = Crypt::decryptString($id);
            $subs = Testimonials::find($data['id']);
            $subs->title = $all['title'];
            $subs->description = $all['description'];
            $subs->client_name = $all['client_name'];
            $subs->image = $filename;
            $subs->status = $all['status'];
            if ($subs->save()) {
                return redirect('/admin/testimonials')->with('success', 'Testimonials Update Successfully!');
            } else {
                return redirect('testimonials/edit/' . Crypt::decryptString($id))->with('error', 'Something went wrong please try after sometime!');
            }
        }
    }

    public function destroy(Request $request) {
        //check user existance plan

        $faq = Testimonials::find(Crypt::decryptString($request->id));
        $result = $faq->delete();
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

}
