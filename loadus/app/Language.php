<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Language extends Model {

    protected $table = 'tbl_language';
    protected $fillable = ['title', 'slug', 'status'];
    public $column_order = array('a.id', 'a.title', 'a.slug', 'a.created_at', 'a.status', 'b.name');
    public $column_search = array('a.title', 'a.slug', 'a.created_at', 'a.status', 'b.name');

    private function _get_datatables_query() {

        $query = DB::table($this->table.' as a')->select($this->column_order)->leftJoin('users as b', 'a.created_by', '=', 'b.id');

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
        $query = DB::table($this->table.' as a')->select($this->column_order)->leftJoin('users as b', 'a.created_by', '=', 'b.id');
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
        $this->slug = $data['slug'];
        $this->status = $data['status'];
        $this->save();
        return 1;
    }

    public function updateData($dataArr) {
        $data = $this->find($dataArr['id']);
        $data->created_by = auth()->user()->id;
        $data->title = $dataArr['title'];
        $data->slug = $dataArr['slug'];
        $data->status = $dataArr['status'];
        if ($data->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
