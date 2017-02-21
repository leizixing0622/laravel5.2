<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input,Auth;

class TestController extends Controller{
	public function test(){
		$arr = array();
		$result = Auth::user()->roles;
		foreach($result as $value){
			$result2 = Role::find($value->id)->permissions;
			foreach($result2 as $value){
				$arr[] = $value->id;
			}
		}
		sort($arr);
		$arr2 = array();
		foreach($arr as $v){
			$arr2[] = Permission::find($v);
		}
		var_dump($arr2);
	}
}