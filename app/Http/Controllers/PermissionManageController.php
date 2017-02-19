<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input;

class PermissionManageController extends Controller
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
    	return view("admin/permissions");
    }
    
    public function getAllPermissions(){
    	$result = Permission::all();
    	return $result;
    }
    
    public function getAddPermission($id,$name){
    	$permission = new Permission;
    	$permission -> pid = $id;
    	$permission -> display_name = $name;
    	if($permission->save()){
    		return array("newTreeNode"=>$permission);
    	}else{
    		return "error";
    	};
    }
    
    public function postUpdatePermission($id,$name){
    	$permission = Permission::find($id);
    	$permission -> display_name = $name;
    	if($permission->update()){
    		return "success";
    	}else{
    		return "error";
    	};
    }
    
    public function postDeletePermission($id){
    	$permission = Permission::find($id);
    	if($permission->delete()){
    		return "success";
    	}else{
    		return "error";
    	};
    }
}