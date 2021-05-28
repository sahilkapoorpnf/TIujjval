<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Mailtemplate extends Model {

    protected $table = 'tbl_mail_template';
    protected $fillable = ['title', 'description'];
    // public $column_order = array('a.id','a.name',  'a.status','b.name as username');
    public $column_search = array('a.title', 'a.description', 'b.name',);

    private function _get_datatables_query() {

        $query = DB::table($this->table . ' as a')->select(DB::raw('DATE_FORMAT(a.created_at, "%d-%m-%Y") as created_at'), 'a.id', 'a.title', 'a.description',  'a.status');

        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $query->where($item, 'like', '%' . $_POST['search']['value'] . '%');
                } else {
                    $query->orWhere($item, 'like', '%' . $_POST['search']['value'] . '%');
                    $query->orWhere(DB::raw('DATE_FORMAT(a.created_at, "%d-%m-%Y %H:%i:%s")'), 'like', '%' . $_POST['search']['value'] . '%');
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
        $query = DB::table($this->table . ' as a')->select(DB::raw('DATE_FORMAT(a.created_at, "%d-%m-%Y %H:%i:%s") as created_at'), 'a.id', 'a.title', 'a.description', 'a.status');

        $result = $query->get();
        return $result->count();
    }

    function Countfiltered() {
        $query = $this->_get_datatables_query();
        $result = $query->get();
        return $result->count();
    }

}
