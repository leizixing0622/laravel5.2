<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function index(){
    	return view("admin/permissions");
    }
    
    public function all(){
    	$result = Permission::all();
    	return $result;
    }
    
    public function store($id,$name){
    	$permission = new Permission;
    	$permission -> pid = $id;
    	$permission -> display_name = $name;
    	if($permission->save()){
    		return array("newTreeNode"=>$permission);
    	}else{
    		return "error";
    	};
    }
    
    public function update($id,$name){
    	$permission = Permission::find($id);
    	$permission -> display_name = $name;
    	if($permission->update()){
    		return "success";
    	}else{
    		return "error";
    	};
    }
    
    public function delete($id){
    	$permission = Permission::find($id);
    	if($permission->delete()){
    		return "success";
    	}else{
    		return "error";
    	};
    }
}