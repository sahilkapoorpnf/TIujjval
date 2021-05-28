<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model {

    public $table = "tbl_banners";
    public $column_order = array('a.id', 'a.banner_name','a.read_more_link', 'a.banner_image', 'a.description', 'a.created_at', 'a.updated_at', 'a.status');
    public $column_search = array('a.banner_name', 'a.banner_image', 'a.status');

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
//        print_r($result);die;
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
