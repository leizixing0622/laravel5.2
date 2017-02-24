<?php
Route::group(['middleware' => 'web'], function () {
	Route::auth();
	Route::get ('/', 'HomeController@index');
});
Route::group(['middleware' => 'web','getpermission'], function () {
    Route::auth();
	Route::get('admin/index',['as'=>'admin.index', 'uses'=>'IndexController@index']) ;
	Route::get('admin/organization/index',['as'=>'admin.organization.index', 'uses'=>'OrganizationController@index']) ;
    Route::get('admin/organization/all',['as'=>'admin.organization.all', 'uses'=>'OrganizationController@all']) ;
    Route::post('admin/organization/store/{id}/{name}',['as'=>'admin.organization.create', 'uses'=>'OrganizationController@store']) ;
    Route::post('admin/organization/update/{id}/{name}',['as'=>'admin.organization.edit', 'uses'=>'OrganizationController@update']) ;
    Route::get('admin/organization/delete/{id}',['as'=>'admin.organization.delete', 'uses'=>'OrganizationController@delete']) ;
    //用户有关路由
    Route::get('admin/user/index',['as'=>'admin.user.index', 'uses'=>'UserController@index']) ;
    Route::get('admin/user/all',['as'=>'admin.user.all', 'uses'=>'UserController@all']) ;
    Route::get('admin/user/findByOrg/{id}',['as'=>'admin.user.findByOrg', 'uses'=>'UserController@findByOrg']) ;
    Route::get('admin/user/findById/{id}',['as'=>'admin.user.findById', 'uses'=>'UserController@findById']) ;
    Route::post('admin/user/storeByOrg/{org_id}',['as'=>'admin.user.createByOrg', 'uses'=>'UserController@storeByOrg']) ;
    Route::post('admin/user/update/{id}',['as'=>'admin.user.update', 'uses'=>'UserController@update']) ;
    Route::get('admin/user/delete/{id}',['as'=>'admin.user.delete', 'uses'=>'UserController@delete']) ;
    //权限有关的路由
    Route::get('admin/permission/index',['as'=>'admin.permission.index','uses'=>'PermissionController@index']) ;
    Route::get('admin/permission/all',['as'=>'admin.permission.all','uses'=>'PermissionController@all']) ;
    Route::get('admin/permission/findById/{id}',['as'=>'admin.permission.findById','uses'=>'PermissionController@findById']) ;
    Route::get('admin/permission/store/{id}/{name}',['as'=>'admin.permission.create','uses'=>'PermissionController@store']) ;
    Route::post('admin/permission/update/{id}/{name}',['as'=>'admin.permission.update','uses'=>'PermissionController@update']) ;
    Route::post('admin/permission/updateDetail/{id}',['as'=>'admin.permission.updateDetail','uses'=>'PermissionController@updateDetail']) ;
    Route::get('admin/permission/delete/{id}',['as'=>'admin.permission.delete','uses'=>'PermissionController@delete']) ;
    //角色有关路由
    Route::get('admin/role/index',['as'=>'admin.role.index','uses'=>'RoleController@index']) ;
    Route::get('admin/role/all',['as'=>'admin.role.all','uses'=>'RoleController@all']) ;
    Route::get('admin/role/store/{id}/{name}',['as'=>'admin.role.create','uses'=>'RoleController@store']) ;
    Route::post('admin/role/update/{id/{name}}',['as'=>'admin.role.update','uses'=>'RoleController@update']) ;
    Route::get('admin/role/delete/{id}',['as'=>'admin.role.delete','uses'=>'RoleController@delete']) ;
    //前台页面菜单路由
    Route::get('home/permission/all',['as'=>'home.permission.all','uses'=>'HomeController@permissions']) ;
	//后台页面菜单路由
    Route::get('index/permission/all',['as'=>'index.permission.all','uses'=>'IndexController@permissions']) ;
    //测试
	Route::get('test',['as'=>'test','uses'=>'TestController@test']) ;
	//角色权限分配
	Route::get('admin/role-permission/index',['as'=>'admin.rolePermission.index','uses'=>'RolePermissionController@index']);
	Route::get('admin/role-permission/all-roles',['as'=>'admin.rolePermission.allRoles','uses'=>'RolePermissionController@allRoles']);
	Route::get('admin/role-permission/find-by-role/{id}',['as'=>'admin.rolePermission.findByRole','uses'=>'RolePermissionController@findByRole']);
	Route::post('admin/role-permission/store-by-role/{id}',['as'=>'admin.rolePermission.storeByRole','uses'=>'RolePermissionController@storeByRole']);
    //用户角色分配
    Route::get('admin/user-role/index',['as'=>'admin.userRole.index','uses'=>'UserRoleController@index']);
    Route::get('admin/user-role/all-users',['as'=>'admin.userRole.allUsers','uses'=>'UserRoleController@allUsers']);
    Route::get('admin/user-role/all-roles',['as'=>'admin.userRole.allRoles','uses'=>'UserRoleController@allRoles']);
    Route::get('admin/user-role/find-by-user/{id}',['as'=>'admin.userRole.findByUser','uses'=>'UserRoleController@findByUser']);
    Route::post('admin/user-role/store-by-user/{id}',['as'=>'admin.userRole.storeByUser','uses'=>'UserRoleController@storeByUser']);
});
//没有权限跳转
Route::get('/illegal', ['as'=>'illegal',function(){
   return view('illegal');
}]);