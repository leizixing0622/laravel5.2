<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input;

class RolePermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
	{
	    //调用中间件
	    $this->middleware('auth');
	}
    
    public function index(){
    	return view("admin/roles-permissions");
    }
    
    public function allRoles(){
    	$result = Role::all();
    	return array('data'=>$result);
    }
    
    public function findByRole($id){
    	$result = Role::find($id)->permissions;
    	return array('data'=>$result);
    }
    /* public function all(){
    	$result = Role::all();
    	return $result;
    }
    
    public function store($id,$name){
    	$role = new Role;
    	$role -> pid = $id;
    	$role -> name = $name;
    	if($role->save()){
    		return array("newTreeNode"=>$role);
    	}else{
    		return "error";
    	};
    }
    
    public function update($id,$name){
    	$role = Role::find($id);
    	$role -> name = $name;
    	if($role->update()){
    		return "success";
    	}else{
    		return "error";
    	};
    }
    
    public function delete($id){
    	$role = Role::find($id);
    	if($role->delete()){
    		return "success";
    	}else{
    		return "error";
    	};
    }*/
}
    
