<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;
use DB;

class AdminGroup extends Model
{
    use Notifiable;
    
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    protected $table = 'group_flowers';
    
    public $column_order = array('a.id', 'a.name','a.group_flower_unique_id', 'a.is_featured','a.description', 'a.created_at', 'a.status','u.first_name');
    public $column_search = array('a.name','a.group_flower_unique_id','a.description','a.created_at', 'a.status','u.first_name');
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    private function _get_datatables_query() {

        $query = DB::table($this->table . ' as a')->select($this->column_order)
                ->join('users as u', 'a.user_id', '=', 'u.id')
                ->where(array('u.deleted_at'=>null, 'u.status'=>1,'a.deleted_at'=>null, 'a.type'=>1));

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

    private function _get_datatables_query_flower() {

        $query = DB::table($this->table . ' as a')->select($this->column_order)
                ->join('users as u', 'a.user_id', '=', 'u.id')
                ->where(array('u.deleted_at'=>null, 'u.status'=>1,'a.deleted_at'=>null, 'a.type'=>2));

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

    function Datatables_flower() {
        //DB::enableQueryLog(); 
        $query = $this->_get_datatables_query_flower();
        if ($_POST['length'] != -1) {
            $query->skip($_POST['start'])->take($_POST['length']);
        }
       // print_r($query->toSql()); die;
        $result = $query->get();


        return $result;
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
        $query = DB::table($this->table . ' as a')->select($this->column_order)
                ->join('users as u', 'a.user_id', '=', 'u.id')
                ->where(array('u.deleted_at'=>null, 'u.status'=>1,'a.deleted_at'=>null, 'a.type'=>1));

        $result = $query->get();
        return $result->count();
    }
    public function Countall_flower() {
        $query = DB::table($this->table . ' as a')->select($this->column_order)
                ->join('users as u', 'a.user_id', '=', 'u.id')
                ->where(array('u.deleted_at'=>null, 'u.status'=>1,'a.deleted_at'=>null, 'a.type'=>2,'a.parent_id'=>0));

        $result = $query->get();
        return $result->count();
    }

    function Countfiltered_flower() {
        $query = $this->_get_datatables_query_flower();
        $result = $query->get();
        return $result->count();
    }
    function Countfiltered() {
        $query = $this->_get_datatables_query();
        $result = $query->get();
        return $result->count();
    }

    public function view($id) {
        $query = DB::table($this->table . ' as a')->select(['a.*', 'u.first_name', 'u.last_name'])
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->join('group_flowers_tiers as gft', 'gft.group_flower_id', '=', 'a.id')
            ->where('a.id', $id);
        // print_r($query->toSql()); die;
        $result = $query->get()->first();
        if (!empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public function tiers() {
        return $this->hasMany('App\GroupFlowerTier', 'group_flower_id', 'id');
    }
    // Get member's of a flower
    public function members() {
        return $this->hasMany('App\GroupFlowersMembers', 'group_flower_id', 'id');
    }
    public function groupuser()
    {
        return $this->belongsTo('App\User', 'user_id','id');
    }

    // Get group_ids of member
    public function members_group(){
        return $this->hasMany('App\GroupFlowersMembers', 'member_id', 'id');
    }

    // Get member's of a flower by position id
    public function membersbyposition() {
        return $this->hasMany('App\GroupFlowersMembers', 'group_flower_id', 'id')->groupBy('position_id');
    }
    
}
