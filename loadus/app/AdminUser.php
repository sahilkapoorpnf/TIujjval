<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class AdminUser extends Model {

    use Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'status'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $guard = 'admin';
    public $column_search = array('a.first_name', 'a.last_name', 'a.phone', 'a.email', 'a.status');
    

    public function view($id) {
        $query = DB::table($this->table . ' as a')->select(['a.*'])->where(["id"=>$id]);
        //print_r($query->toSql()); die;
        $result = $query->get()->first();
        if (!empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

}
