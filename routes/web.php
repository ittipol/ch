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

// pattern
// Route::get('{modelAlias}/add','FormController@add');
// ---------------------------------------------------------

// Entity ======================================
// > index
Route::get('{entity_slug}','EntityController@index');
// > create
Route::get('entity/create','EntityController@create');
// > add
Route::get('entity/add','EntityController@add');
Route::post('entity/add','EntityController@submit');

// Route::get('{modelAlias}/form/{action}','FormController@form');
// ======================================

// Product ======================================
Route::get('product','ProductController@index');
// > view
Route::get('product/{product_slug}','ProductController@detail');
// > add
Route::get('product/add','ProductController@add');
Route::post('product/add','ProductController@submit');


Route::group(['prefix' => 'api/v1', 'middleware' => 'api'], function () {
  Route::get('get_sub_district/{districtId}', 'ApiController@GetSubDistrict');
});

Route::group(['middleware' => 'auth'], function () {
  Route::post('upload_image', 'ApiController@uploadImage');
  // Route::post('delete_image', 'ApiController@deleteImage');
});

