<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input;

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
    		return array("newTreeNode"=>$organization);
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
    public function getUserById($id){
    	$user = User::find($id);
    	return $user;
    }
    public function postUserStoreByOrg(Request $request, $org_id){
    	$email = $request->input('email');
    	$result = User::where('email','=',$email)->get();
    	if($result->isEmpty()){
    		$user = new User;
	    	$user->name = $request->input('name');
	    	$user->email = $email;
	    	$user->password = bcrypt($request->input('password'));
	    	$user->org_id = $org_id;
    		if($user->save()){
	    		return array("data"=> 1);
	    	}else{
		    	return array("data"=>"2");
	    	}
    	}else{
    		return array("data"=> -1);
    	}
    }
    public function postUserUpdateById(Request $request, $id){
    	$user = User::find($id);
    	$user->name = $request->input('name');
    	$user->email = $request->input('email');
    	$user->password = bcrypt($request->input('password'));
    	if($user->save()){
    		return array("data"=>"success");
    	}else{
	    	return array("data"=>"error");
    	}
    }
    public function getUserDeleteById($id){
    	$user = User::find($id);
    	if($user->delete()){
    		return array("data"=>"success");
    	}else{
	    	return array("data"=>"error");
    	}
    }
}
