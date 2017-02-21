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
    public function __construct()
    {
        $this->middleware('auth');
    }

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
			$arr2[] = Permission::find($v);
		}
		return $arr2;
    }
}
