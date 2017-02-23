<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input,Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     //Controller的构造方法
	public function __construct()
	{
	    //调用中间件
	    $this->middleware('auth');
	}
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function permissions(){
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
			if(Permission::find($v)->type == 2 || Permission::find($v)->pid == 36 || Permission::find($v)->id == 36){

			}else{
				$arr2[] = Permission::find($v);
			}
		}
		return $arr2;
    }
}
