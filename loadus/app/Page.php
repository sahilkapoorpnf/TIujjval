<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Page extends Model {

    protected $table = 'tbl_pages';
    protected $fillable = ['title', 'description', 'slug', 'status'];
    public $column_order = array('a.id', 'a.description', 'a.title', 'a.slug', 'a.created_at', 'a.status');
    public $column_search = array('a.title', 'a.description', 'a.slug', 'a.created_at', 'a.status');

    private function _get_datatables_query() {

        $query = DB::table($this->table . ' as a')->select($this->column_order);
                
                // ->leftJoin('tbl_language as c', 'a.language_id', '=', 'c.id');

        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $query->where($item, 'like', '%' . $_POST['search']['value'] . '%');
                } else {
                    $query->orWhere($item, 'like', '%' . $_POST['search']['value'] . '%');
                }
            }
            $i++;
        }
        $query->orderByRaw('id DESC');
        return $query;
    }

    function Datatables() {

        $query = $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $query->skip($_POST['start'])->take($_POST['length']);
        }
//        print_r($query->toSql()); die;
        $result = $query->get();


        return $result;
    }

    public function Countall() {
        $query = DB::table($this->table . ' as a')->select($this->column_order);
                // ->leftJoin('tbl_language as c', 'a.language_id', '=', 'c.id');

        $result = $query->get();
        return $result->count();
    }

    function Countfiltered() {
        $query = $this->_get_datatables_query();
        $result = $query->get();
        return $result->count();
    }

    public function saveData($data) {
        $this->created_by = auth()->user()->id;
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->slug = $this->slugify($data['title']);
        $this->featured_img = $data['featured_img'];
        $this->meta_title = $data['meta_title'];
        $this->meta_description = $data['meta_description'];
        $this->meta_key = $data['meta_key'];
        $this->status = $data['status'];
        $this->save();
        return 1;
    }

    public function updateData($dataArr) {
        $data = $this->find($dataArr['id']);
        $data->created_by = auth()->user()->id;
        $data->title = $dataArr['title'];
        $data->description = $dataArr['description'];
        $data->slug = $this->slugify($dataArr['title']);
        $data->featured_img = $dataArr['featured_img'];
        $data->meta_title = $dataArr['meta_title'];
        $data->meta_description = $dataArr['meta_description'];
        $data->meta_key = $dataArr['meta_key'];
        $data->status = $dataArr['status'];
        if ($data->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function view($id) {
        $query = DB::table($this->table . ' as a')->select(['a.*']);
                        // ->leftJoin('tbl_language as c', 'a.language_id', '=', 'c.id')->where('a.id', $id);
        //print_r($query->toSql()); die;
        $result = $query->get()->first();
        if (!empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}
