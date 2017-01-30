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

Route::get('working_experience','WorkingExperienceController@index');
Route::group(['middleware' => 'auth'], function () {
  Route::post('working_experience','WorkingExperienceController@start');
});


// community / shop
// Route::get('community/shop_feature','ShopController@feature');

Route::get('shop/{slug}','ShopController@index');
Route::group(['middleware' => 'auth'], function () {
  Route::get('community/shop_create','ShopController@create');
  Route::post('community/shop_create','ShopController@submitCreating');

  Route::get('shop/{slug}/product','ShopController@product');

  Route::get('shop/{slug}/job','ShopController@job');
  Route::get('shop/{slug}/job_add','JobController@add');
  Route::post('shop/{slug}/job_add','JobController@submitAdding');

  Route::get('shop/{slug}/advertisement','ShopController@advertisement');

  Route::get('shop/{slug}/branch_add','BranchController@add');
  Route::post('shop/{slug}/branch_add','BranchController@submitAdding');

  Route::get('shop/{slug}/management','ShopController@product');
  Route::get('shop/{slug}/setting','ShopController@setting');
});

// Announcement
Route::get('announcement/create','AnnouncementController@create');

// Person Post Item
Route::group(['middleware' => 'auth'], function () {
  Route::get('item/post','ItemController@post');
  Route::post('item/post','ItemController@submitPosting');

  // Route::get('item/edit/{item_id}','ItemController@edit');
  // Route::patch('item/edit/{item_id}',[
  //   'as' => 'item.edit',
  //   'uses' => 'ItemController@editingSubmit'
  // ]);
});

Route::get('item/list','ItemController@listView');
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
  Route::get('job/post','JobController@post');
  Route::post('job/post','JobController@submitPosting');

  // Route::get('job/edit/{job_id}','JobController@edit');
  // Route::patch('job/edit/{job_id}',[
  //   'as' => 'job.edit',
  //   'uses' => 'JobController@editingSubmit'
  // ]);
});

// Real Estate
Route::group(['middleware' => 'auth'], function () {
  Route::get('real-estate/post','RealEstateController@post');
  Route::post('real-estate/post','RealEstateController@submitPosting');

  // Route::get('real-estate/edit/{realEstateId}','RealEstateController@edit');
  // Route::patch('real-estate/edit/{realEstateId}',[
  //   'as' => 'real-estate.edit',
  //   'uses' => 'RealEstateController@editingSubmit'
  // ]);
});

Route::get('real-estate/list','RealEstateController@listView');
Route::get('real-estate/detail/{real_estate_id}','RealEstateController@detail');


Route::group(['prefix' => 'api/v1', 'middleware' => 'api'], function () {
  Route::get('get_sub_district/{districtId}', 'ApiController@GetSubDistrict');
  Route::get('token', 'ApiController@token');
});

Route::group(['middleware' => 'auth'], function () {
  Route::post('upload_image', 'ApiController@uploadImage');
  // Route::post('delete_image', 'ApiController@deleteImage');
});

