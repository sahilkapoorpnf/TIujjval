<?php

namespace App\Http\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;
use DB;

class Group extends Model
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

    public function groupowner()
    {
        return $this->belongsTo('App\User', 'user_id','id')->select(['id', 'first_name', 'last_name','email','user_image']);
    }
    /** Used to get count of flower members on particular position in flower**/
    public function groupflowermembers()
    {
        return $this->hasMany('App\GroupFlowersMembers', 'group_flower_id','id')->select(['group_flower_id','position_id',DB::raw('COUNT(id) as total_positions')])->groupBy('position_id');
    }

    public function groupflowertiers()
    {
        return $this->hasMany('App\GroupFlowerTier', 'group_flower_id','id');
    }
    /*** All group flower members  ***/
    public function allgroupflowermembers()
    {
        return $this->hasMany('App\GroupFlowersMembers', 'group_flower_id','id');
    }

    public function acceptedgroupflowermembers()
    {
        return $this->hasMany('App\GroupFlowersMembers', 'group_flower_id','id')->where(array('is_accepted'=>1));
    }

    /*** All flower of a group  ***/
    public function groupFlowers()
    {
        return $this->hasMany('App\Http\Models\Group', 'parent_id','id');
    }


    
}
