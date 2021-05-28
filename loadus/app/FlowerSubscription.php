<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class FlowerSubscription extends Model {

    public $table = "tbl_flower_subscription_plans";
    public $column_order = array('a.id', 'a.plan_name', 'a.plan_rate', 'a.description', 'a.created_at', 'a.updated_at', 'a.status', 'a.deleted_at');
    public $column_search = array('a.plan_name', 'a.plan_rate', 'a.status');

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
