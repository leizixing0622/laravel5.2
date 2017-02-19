<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('home');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
    //组织有关路由
    Route::get('admin/index',['as'=>'admin.index', 'uses'=>'IndexController@index']);
    Route::get('admin/organization/all',['as'=>'admin.organization.all', 'uses'=>'OrganizationController@all']);
    Route::post('admin/organization/store/{id}/{name}',['as'=>'admin.organization.create', 'uses'=>'OrganizationController@store']);
    Route::post('admin/organization/update/{id}/{name}',['as'=>'admin.organization.edit', 'uses'=>'OrganizationController@update']);
    Route::get('admin/organization/delete/{id}',['as'=>'admin.organization.delete', 'uses'=>'OrganizationController@delete']);
    //用户有关路由
    Route::get('admin/user/findByOrg/{id}',['as'=>'admin.user.findByOrg', 'uses'=>'UserController@findByOrg']);
    Route::get('admin/user/findById/{id}',['as'=>'admin.user.findById', 'uses'=>'UserController@findById']);
    Route::post('admin/user/storeByOrg/{org_id}',['as'=>'admin.user.createByOrg', 'uses'=>'UserController@storeByOrg']);
    Route::post('admin/user/update/{id}',['as'=>'admin.user.update', 'uses'=>'UserController@update']);
    Route::get('admin/user/delete/{id}',['as'=>'admin.user.delete', 'uses'=>'UserController@delete']);
    //Route::controller('permissions', 'PermissionManageController');
    Route::controller('roles', 'RoleManageController');
});
