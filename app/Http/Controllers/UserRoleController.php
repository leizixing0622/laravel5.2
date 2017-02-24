<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use Illuminate\Http\Request;
use Input;

class UserRoleController extends Controller
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
        return view("admin/users-roles");
    }

    public function allUsers(){
        $result = User::all();
        return array('data'=>$result);
    }

    public function allRoles() {
        $result = Role::all();
        return response()->json($result);
    }

    public function findByUser ($id) {
        $result = User::find($id)->roles;
        return response()->json($result);
    }

    public function storeByUser(Request $request, $id){
        $user = User::find($id);
        $arr = $request->get('data');
        $arr2 = array();
        foreach($arr as $v){
            $arr2[] = (int)$v;
        }
        $user->roles()->sync($arr2);
        return response()->json($user->roles);
    }
}

