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

// Register
Route::get('register','UserController@registerForm')->middleware('guest');
Route::post('register','UserController@register')->middleware('guest');

Route::get('safe_image/{file}', 'StaticFileController@serveImages');
Route::group(['middleware' => 'auth'], function () {
  Route::get('avatar', 'StaticFileController@avatar');
});


// ENTITY
// Route::get('{entity_slug}','EntityController@index');
// Route::get('entity/create','EntityController@create');

// Route::group(['middleware' => 'auth'], function () {
//   Route::get('entity/add','EntityController@add');
//   Route::post('entity/add','EntityController@submit');
// });

// Announcement
Route::get('announcement/create','AnnouncementController@create');

// Person -> Item
Route::group(['middleware' => 'auth'], function () {
  Route::get('item/post','ItemController@post');
  Route::post('item/post','ItemController@submitPosting');

  // Route::get('item/edit/{item_id}','ItemController@edit');
  // Route::patch('item/edit/{item_id}',[
  //   'as' => 'item.edit',
  //   'uses' => 'ItemController@editingSubmit'
  // ]);
});
Route::get('item/detail/{item_id}','ItemController@detail');

// PRODUCT
// Route::group(['middleware' => 'auth'], function () {
//   Route::get('product/add','ProductController@add');
//   Route::post('product/add','ProductController@addingSubmit');

//   Route::get('product/edit/{product_id}','ProductController@edit');
//   Route::patch('product/edit/{product_id}',[
//     'as' => 'product.edit',
//     'uses' => 'ProductController@editingSubmit'
//   ]);
// });
// Route::get('product','ProductController@index');
// Route::get('product/{product_slug}','ProductController@detail');

// JOB
Route::group(['middleware' => 'auth'], function () {
  Route::get('job/add','JobController@post');
  Route::post('job/add','JobController@submitPosting');

  // Route::get('job/edit/{job_id}','JobController@edit');
  // Route::patch('job/edit/{job_id}',[
  //   'as' => 'job.edit',
  //   'uses' => 'JobController@editingSubmit'
  // ]);
});

// PROPERTY
Route::group(['middleware' => 'auth'], function () {
  Route::get('real-estate/post','RealEstateController@post');
  Route::post('real-estate/post','RealEstateController@submitPosting');

  // Route::get('real-estate/edit/{realEstateId}','RealEstateController@edit');
  // Route::patch('real-estate/edit/{realEstateId}',[
  //   'as' => 'real-estate.edit',
  //   'uses' => 'RealEstateController@editingSubmit'
  // ]);
});
Route::get('real-estate/detail/{real_estate_id}','RealEstateController@detail');


Route::group(['prefix' => 'api/v1', 'middleware' => 'api'], function () {
  Route::get('get_sub_district/{districtId}', 'ApiController@GetSubDistrict');
});

Route::group(['middleware' => 'auth'], function () {
  Route::post('upload_image', 'ApiController@uploadImage');
  // Route::post('delete_image', 'ApiController@deleteImage');
});

