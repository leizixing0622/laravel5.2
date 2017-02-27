<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Organization;
use App\File;
use Illuminate\Http\Request;
use Input,Auth;

class UserController extends Controller{

	public function __construct()
	{
	    //调用中间件
	    $this->middleware('auth');
	}


	public function index(){
		return view("admin/users");
	}
	public function all(){
		$users = User::all();
		return array('data'=>$users);
	}
	public function findByOrg($id){
		$users = Organization::find($id)->users()->get();
        return array('data'=>$users);
	}
	public function findById($id){
		$user = User::find($id);
        $avatar = $user->avatar;
    	return array('user'=>$user, 'avatar'=>$avatar);
	}
	public function storeByOrg(Request $request, $org_id){
        $file = new File;
        $file_ext=strtolower(explode('.',$_FILES['file']['name'])[count(explode('.',$_FILES['file']['name']))-1]);
        $file->filename = md5($_FILES['file']['name']).'.'.$file_ext;
        $file->type = $_FILES['file']['type'];
        $file->size = $_FILES['file']['size'];
        $file_tmp = $_FILES['file']['tmp_name'];
        //保存文件到服务器
        move_uploaded_file($file_tmp,public_path().'\\uploadfiles\\avatar\\'.md5($_FILES['file']['name']).'.'.$file_ext);
        $email = $_POST['email'];
    	$result = User::where('email','=',$email)->get();
    	if($result->isEmpty()){
    		$user = new User;
	    	$user->name = $_POST['name'];
	    	$user->email = $email;
            $user->sex = $_POST['sexChecked'];
	    	$user->password = bcrypt($request->get('password'));
    		if($user->save()){
		    	$user->organizations()->attach($org_id);
                //保存文件到数据库
                $file->user_id = $user->id;
                $file->path = public_path().'\\temp\\'.md5($file->filename).'.'.$file_ext;
                if($file->save()){
                    return array("data"=> 3);
                }else{
                    return array("data"=> 4);
                }
	    		return array("data"=> 1);
	    	}else{
		    	return array("data"=> 2);
	    	}
    	}else{
    		return array("data"=> -1);
    	}
        return response()->json($file);
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
    		$user->organizations()->detach();
    		return array("data"=>"success");
    	}else{
	    	return array("data"=>"error");
    	}
	}
}