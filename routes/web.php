<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('logout',function(){
  Auth::logout();
  Session::flush();
  return redirect('/');
});

// Login
Route::get('login','UserController@login');
Route::post('login','UserController@auth');


Route::get('safe_image/{file}', 'StaticFileController@serveImages');
Route::group(['middleware' => 'auth'], function () {
  Route::get('avatar', 'StaticFileController@avatar');
});

// Entity ======================================
Route::get('{entity_slug}','EntityController@index');
Route::get('entity/create','EntityController@create');
Route::get('entity/add','EntityController@add');
Route::post('entity/add','EntityController@submit');

// Route::get('{modelAlias}/form/{action}','FormController@form');
// ======================================

// Route::get('{modelAlias}/add','FormController@add');

// Product ======================================
Route::get('product/add','ProductController@add');




Route::group(['prefix' => 'api/v1', 'middleware' => 'auth'], function () {
  Route::get('get_sub_district/{districtId}', 'ApiController@GetSubDistrict');
});

Route::group(['middleware' => 'auth'], function () {
  Route::post('upload_image', 'ApiController@uploadTempImage');
  Route::post('delete_image', 'ApiController@deleteTempImage');
});

