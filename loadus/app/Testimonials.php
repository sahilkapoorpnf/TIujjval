<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Testimonials extends Model {

    protected $table = 'tbl_testimonials';
    // public $timestamps = FALSE;

    public $column_order = array('a.id', 'a.title', 'a.description', 'a.client_name', 'a.image', 'a.status', 'a.created_at', 'a.updated_at','a.deleted_at');
    public $column_search = array('a.title', 'a.description', 'a.client_name', 'a.status');

    private function _get_datatables_query() {

        $query = DB::table($this->table . ' as a')->select($this->column_order);

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

        $result = $query->get();
        return $result->count();
    }

    function Countfiltered() {
        $query = $this->_get_datatables_query();
        $result = $query->get();
        return $result->count();
    }

}
