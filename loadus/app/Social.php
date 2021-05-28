<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Social extends Model {

    protected $table = 'tbl_social_media';
    protected $fillable = [
        'link', 'icon'
    ];
    public $column_search = array('a.name', 'a.link', 'a.icon');

    private function _get_datatables_query() {

        $query = DB::table($this->table . ' as a')->select(DB::raw('DATE_FORMAT(a.created_at, "%d-%m-%Y %H:%i:%s") as created_at'), 'a.id', 'a.name', 'a.link', 'a.icon', 'a.status');


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
        $query->orderByRaw('a.id DESC');
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
        $query = DB::table($this->table . ' as a')->select(DB::raw('DATE_FORMAT(a.created_at, "%d-%m-%Y %H:%i:%s") as created_at'), 'a.id', 'a.name', 'a.link', 'a.icon', 'a.status');

        $result = $query->get();
        return $result->count();
    }

    function Countfiltered() {
        $query = $this->_get_datatables_query();
        $result = $query->get();
        return $result->count();
    }

}
