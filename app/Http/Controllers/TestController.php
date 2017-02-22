<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input,Auth;

class TestController extends Controller{
	public function test(Request $request){
		if(($request->ajax() && !$request->pjax()) || $request->wantsJson()){
			return 1;
		}else{
			return 2;
		}
	}
	function expectsJson(){
		return ($this->ajax() && !$this->pjax()) || $this->wantsJson();
	}
}