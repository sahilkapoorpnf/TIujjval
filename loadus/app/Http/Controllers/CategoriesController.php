<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Crypt;
use DB;
use Auth;
use App\User;
use Illuminate\Support\Facades\Input;

class CategoriesController extends Controller {

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth:admin')->except(array('stripe', 'stripePost'));
        // $this->middleware('auth:user');
    }

    public function index(Request $request){ 
        $title ='Categories List';
        $categories=DB::table('categories')->where('deleted_status','0')->paginate(10);
        return view('admin.categories.index',get_defined_vars());
    }
    
    public function add(Request $request){ 
        $title ='Loadus - Categories Add';
        
        if ($request->isMethod('post')) {
            $file = Input::file('image');
            $name = time() . '-' . $file->getClientOriginalName();
            if ($image = $file->move(public_path() . '/categories/', $name)) {
                DB::table('categories')->insert([
                    'title'=>$request->title,
                    'icon'=>$name,
                ]);
                return redirect()->back()->with('success', 'Congrats! new category has been created');
            }
        }
        return view('admin.categories.create',get_defined_vars());
    }
    
    public function delete(Request $request,$id){
        DB::table('categories')->where('id',$id)->update([
            'deleted_status'=>'1'
        ]);
        return redirect()->back()->with('success', 'Record has been deleted successfully.');
    }
    
    public function edit(Request $request,$id){ 
        $title ='Loadus - Categories Update';
        
        $userData = DB::table('categories')->where('id', $id)->first();
        if ($request->isMethod('post')) {
                
                if ($file = $request->hasFile('image')) {
                    $file = $request->file('image');
                    $imageType = $file->getClientmimeType();
                    $fileName = $file->getClientOriginalName();
                    $fileNameUnique = time() . '_' . $fileName;
                    $destinationPath = public_path() . '/categories/';
                    $file->move($destinationPath, $fileNameUnique);
                    $imageData = $fileNameUnique;
                } else {
                    $imageData = $userData->icon;
                }
                DB::table('categories')
                        ->where('id', $id)
                        ->update([
                            'title'=>$request->title,
                            'status'=>$request->status,
                            'icon'=>$imageData,
                                ]);
                return redirect()->back()->with('success', 'You record has updated the record!');
            
        }
        return view('admin.categories.edit',get_defined_vars());
    }
    
    

}
