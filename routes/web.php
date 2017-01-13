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



Route::get('{entity_slug}','EntityController@index');
Route::get('entity/create','EntityController@create');

Route::group(['middleware' => 'auth'], function () {
  Route::get('entity/add','EntityController@add');
  Route::post('entity/add','EntityController@submit');
});


// announcement
Route::get('announcement/create','AnnouncementController@create');


Route::get('product','ProductController@index');

Route::group(['middleware' => 'auth'], function () {
  Route::get('product/add','ProductController@add');
  Route::post('product/add','ProductController@addingSubmit');

  Route::get('product/edit/{product_id}','ProductController@edit');
  Route::patch('product/edit/{product_id}',[
    'as' => 'product.edit',
    'uses' => 'ProductController@editingSubmit'
  ]);
});

Route::get('product/{product_slug}','ProductController@detail');


Route::group(['middleware' => 'auth'], function () {
  Route::get('real-estate/add','RealEstateController@add');
  Route::post('real-estate/add','RealEstateController@addingSubmit');

  // Route::get('real-estate/edit/{realEstateId}','RealEstateController@edit');
  // Route::patch('real-estate/edit/{realEstateId}',[
  //   'as' => 'real-estate.edit',
  //   'uses' => 'RealEstateController@editingSubmit'
  // ]);
});


Route::group(['prefix' => 'api/v1', 'middleware' => 'api'], function () {
  Route::get('get_sub_district/{districtId}', 'ApiController@GetSubDistrict');
});

Route::group(['middleware' => 'auth'], function () {
  Route::post('upload_image', 'ApiController@uploadImage');
  // Route::post('delete_image', 'ApiController@deleteImage');
});

