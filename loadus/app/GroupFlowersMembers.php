<?php

namespace App;
use DB;
// namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class GroupFlowersMembers extends Model
{
    protected $table = 'group_flowers_members';

    // public $timestamps = FALSE;
    // Used to get details of members
    public function groupFlowerUser(){
	    return $this->belongsTo('App\User', 'member_id', 'id')->select(['id', 'first_name', 'last_name','email','user_image']);
	}
	// Get Users of a particualr group.
	public function userGroupFlower(){
	    return $this->belongsTo('App\AdminGroup', 'group_flower_id', 'id');
	}
	
	
	// Get group_ids of water users from group_flowers table
    public function users_group(){
        return $this->hasMany('App\AdminGroup', 'id', 'group_flower_id')->where('type','1')->select(['id']);
    }

    public function group_details(){
    	return $this->belongsTo('App\Http\Models\Group', 'group_flower_id', 'id')->with('allgroupflowermembers');
    }


    
}
