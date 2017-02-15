<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getIndex(){
    	return view("admin/index");
    }
    
    public function getAllOrg(){
    	$organizations = Organization::all();
    	return $organizations;
    }
    public function postAddOrg($id,$name){
    	$organization = new Organization;
    	$organization -> pid = $id;
    	$organization -> name = $name;
    	if($organization->save()){
    		return "success";
    	}else{
    		return "error";
    	};
    }
    public function postUpdateOrg($id,$name){
    	$organization = Organization::find($id);
    	$organization -> name = $name;
    	if($organization->update()){
    		return "success";
    	}else{
    		return "error";
    	};
    }
    public function postDeleteOrg($id){
    	$organization = Organization::find($id);
    	if($organization->delete()){
    		if(!Organization::where('pid', $id)->get()->isEmpty()){
	    		if(Organization::where('pid', $id)->delete()){
	    			return "success2";
	    		}else{
	    			return "error2";
	    		}
    		}
    		return "success";
    	}else{
    		return "error";
    	};
    }
    public function getUsersByOrg($id){
        $users = User::where('org_id','=',$id)->get();
        return array('data'=>$users);;
    }
}