<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input;

class RoleManageController extends Controller
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
    	return view("admin/roles");
    }
    
     public function getAllRoles(){
    	$result = Role::all();
    	return $result;
    }
    
    public function getAddRole($id,$name){
    	$role = new Role;
    	$role -> pid = $id;
    	$role -> name = $name;
    	if($role->save()){
    		return array("newTreeNode"=>$role);
    	}else{
    		return "error";
    	};
    }
    
    public function postUpdateRole($id,$name){
    	$role = Role::find($id);
    	$role -> name = $name;
    	if($role->update()){
    		return "success";
    	}else{
    		return "error";
    	};
    }
    
    public function postDeleteRole($id){
    	$role = Role::find($id);
    	if($role->delete()){
    		return "success";
    	}else{
    		return "error";
    	};
    }
}
    
