<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input,Auth;

class OrganizationController extends Controller{
	
	public function __construct()
	{
	    //调用中间件
	    $this->middleware('auth');
	}
	
	public function index(){
		return view("admin/index");
	}
	
	public function all(){
		$organizations = Organization::all();
    	return $organizations;
	}
	public function store($id,$name){
		$organization = new Organization;
    	$organization -> pid = $id;
    	$organization -> name = $name;
    	if($organization->save()){
    		return array("newTreeNode"=>$organization);
    	}else{
    		return "error";
    	};
	}
	public function update($id,$name){
		$organization = Organization::find($id);
    	$organization -> name = $name;
    	if($organization->update()){
    		return "success";
    	}else{
    		return "error";
    	};
	}
	public function delete($id){
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
}