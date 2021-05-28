<?php

namespace App\Http\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;
use DB;

class Message extends Model
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    protected $table = 'messages';
    
    
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
    public function messageuserGroup(){
        return $this->belongsTo('App\Http\Models\Group', 'group_flower_id','id')->select(['id', 'name']);
    }

    public function messageUser(){
        return $this->belongsTo('App\User', 'user_id','id')->select(['id', 'first_name', 'last_name','email','user_image']);
    }
    
    
}
