<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input;

class RolePermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
	{
	    //调用中间件
	    $this->middleware('auth');
	}

    public function index(){
    	return view("admin/roles-permissions");
    }

    public function allRoles(){
    	$result = Role::all();
    	return array('data'=>$result);
    }

    public function findByRole($id){
    	$result = Role::find($id)->permissions;
    	return array('data'=>$result);
    }

    public function storeByRole(Request $request, $id){
        $role = Role::find($id);
        $arr = $request->get('data');
        $arr2 = array();
        foreach($arr as $k => $v){
            $arr2[] = (int)$v['id'];
        }
        $role->permissions()->sync($arr2);
        return response()->json($role->permissions);
    }
}

