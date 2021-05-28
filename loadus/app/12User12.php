<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {

    public $column_order = array('a.id', 'a.name','a.phone', 'a.email', 'a.created_at', 'a.status', 'b.name as created_by', 'c.title as role');
    public $column_search = array('a.name', 'a.phone', 'a.email', 'a.created_at', 'a.status', 'c.title');

    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    private function _get_datatables_query() {

        $query = DB::table('users as a')->select($this->column_order)
                ->leftJoin('users as b', 'a.created_by', '=', 'b.id')
                ->leftJoin('roles as c', 'a.role', '=', 'c.id');
//        
        if (auth()->user()->role != 1) {
            $query->where('a.created_by', auth()->user()->id);
        }

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

    function getDatatablesAttribute() {

        $query = $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $query->skip($_POST['start'])->take($_POST['length']);
        }
//        print_r($query->toSql()); die;
        $result = $query->get();


        return $result;
    }

    public function getCountallAttribute() {
        $query = DB::table('users as a')->select($this->column_order)
                ->leftJoin('users as b', 'a.created_by', '=', 'b.id')
                ->leftJoin('roles as c', 'a.role', '=', 'c.id');
        if (auth()->user()->role != 1) {
           // $query->where('a.role', 3);
            $query->where('a.created_by', auth()->user()->id);
        }

        $result = $query->get();
        return $result->count();
    }

    function getCountfilteredAttribute() {
        $query = $this->_get_datatables_query();
        $result = $query->get();
        return $result->count();
    }

    public function saveData($data) {
        $this->created_by = auth()->user()->id;
        $this->name = $data['name'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->role = $data['role'];
        $this->status = $data['status'];
        $this->password = Hash::make($data['password']);

        if ($this->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateData($data) {
        $arvind = $this->find($data['id']);
        $arvind->name = $data['name'];
        $arvind->phone = $data['phone'];
        $arvind->email = $data['email'];
        $arvind->role = $data['role'];
        $arvind->status = $data['status'];
        $arvind->updated_by = auth()->user()->id;
        if ($arvind->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateProfile($data) {
        $arvind = $this->find($data['id']);
        $arvind->name = $data['name'];
        $arvind->profile_image = $data['profile_image'];
        $arvind->status = $data['status'];
        $arvind->updated_by = auth()->user()->id;
        if ($arvind->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
