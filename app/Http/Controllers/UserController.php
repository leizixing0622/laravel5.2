<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input;

class UserController extends Controller{
	
	public function findByOrg($id){
		$users = User::where('org_id','=',$id)->get();
        return array('data'=>$users);
	}
	public function findById($id){
		$user = User::find($id);
    	return $user;
	}
	public function storeByOrg(Request $request, $org_id){
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
	public function update(Request $request, $id){
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
	public function delete($id){
		$user = User::find($id);
    	if($user->delete()){
    		return array("data"=>"success");
    	}else{
	    	return array("data"=>"error");
    	}
	}
}