<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
Use DB;
use App\Mailtemplate;

class MailtemplateController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        $data = [
            'title' => 'Template List'
        ];
        return view('mailtemplate.index', $data);
    }

    public function Templatelist() {

        $model = new Mailtemplate();
        $res = $model->Datatables();

        $data = [];
        $no = $_POST['start'];

        foreach ($res as $value) {
            $no++;

            $row = [];
            $row[] = $no;
            $row[] = $value->title;
            // $row[] = '<img class="img-circle" src="../' . ($value->image ? $value->image : 'uploads/noimage.jpg') . '" width="80%">';
            $row[] = strlen($value->description) > 50 ? substr(preg_replace(['#<[^>]+>#'], ' ', $value->description), 0, 50) . "...." : $value->description;
            $row[] = ($value->status == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>');
            // $row[] = ActionButton($value->id);
                $row[] = '
        <a class="btn btn-success btn-xs" href="mailtemplate/edit/' . Crypt::encryptString($value->id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>';

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
            'title' => 'Create Template',
        ];

        return view('mailtemplate.create', $data);
    }

    public function store(Request $request) {
        if ($request->isMethod('post')) {
            $model = new Mailtemplate();

            $data = $this->validate($request, [
                'title' => 'required',
                'description' => 'required',
            ]);
            $model->title = $request->title;
            $model->description = $request->description;
            $model->status = $request->status;
            $res = $model->save();
            if ($res) {
                return redirect('/admin/mailtemplate')->with('success', 'Template Added Successfully!');
            } else {
                return redirect('/admin/mailtemplate')->with('error', 'Something went wrong please try after sometime!');
            }
        } else {

            return redirect('/admin/mailtemplate');
        }
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $res = Mailtemplate::where('id', Crypt::decryptString($id))->first();
        $data = [
            'title' => 'Edit Template',
            'data' => $res,
        ];
        return view('mailtemplate.create', $data);
    }

    public function update(Request $request, $id) {
        $model = new Mailtemplate();
        $data = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $data['status'] = $request->status;
//        echo '<pre>';
//        print_r($data);
//        die;

        $result = Mailtemplate::where('id', Crypt::decryptString($id))->update($data);
        if ($result) {
            return redirect('/admin/mailtemplate')->with('success', 'Template Updated Successfully!');
        } else {
            return redirect('/admin/mailtemplate/edit/' . $id)->with('error', 'Something went wrong please try after sometime!');
        }
    }

    public function destroy(Request $request) {
        if ($request->ajax()) {
            $model = Mailtemplate::find(Crypt::decryptString($request->id));
            $result = $model->delete();
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

}
