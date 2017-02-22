<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;
use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input,Auth;

class GetPermission{
	
	public function handle($request, Closure $next){
		if(($request->ajax() && !$request->pjax()) || $request->wantsJson()){
			
			return $next($request);
			
		}else{
			
			$url = $request->url();
			if($url == 'login' || 'logout'){
				return $next($request);
			}
			$root =  url('');
			$result = substr($url,strlen($root)+1,strlen($url)-1);
			//echo $result;
			$arr = array();
			$result2 = Auth::user()->roles;
			foreach($result2 as $value){
				$result2 = Role::find($value->id)->permissions;
				foreach($result2 as $value){
					$arr[] = $value->id;
				}
			}
			$arr2 = array();
			foreach($arr as $v){
				$arr2[] = Permission::find($v)->url;
			}
			
			//print_r($arr2);
			if(in_array($result, $arr2)){
				//通过验证
				return $next($request);
			}else{
				//不通过验证
				return redirect()->route('illegal');
			}
			
		}
	}
}