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
}