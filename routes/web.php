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

// Announcement
Route::get('announcement/create','AnnouncementController@create');

// Experience
Route::group(['middleware' => 'auth'], function () {
  Route::get('experience','PersonExperienceController@index');
  Route::post('experience','PersonExperienceController@start');

  Route::get('experience/profile','PersonExperienceController@profileEdit');
  Route::patch('experience/profile','PersonExperienceController@profileEditingSubmit');

  // Route::get('experience/working','PersonExperienceController@index');
  // Route::get('experience/education','PersonExperienceController@index');
  // Route::get('experience/project','PersonExperienceController@index');
  // Route::get('experience/article','PersonExperienceController@index');
  // Route::get('experience/volunteer','PersonExperienceController@index');
  // Route::get('experience/training','PersonExperienceController@index');
  // Route::get('experience/skill','PersonExperienceController@index');
  // Route::get('experience/language','PersonExperienceController@index');


});


// community / shop
// Route::get('community/shop_feature','ShopController@feature');
Route::get('shop/{slug}','ShopController@index');

Route::group(['middleware' => 'auth'], function () {
  Route::get('community/shop_create','ShopController@create');
  Route::post('community/shop_create','ShopController@creatingSubmit');

  Route::get('shop/{slug}/product','ShopController@product');

  Route::get('shop/{slug}/advertisement','ShopController@advertisement');

  Route::get('shop/{slug}/manage','ShopController@product');
  Route::get('shop/{slug}/setting','ShopController@setting');
});


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

// Job
Route::get('job/detail/{job_id}','JobController@detail');

Route::group(['middleware' => 'auth'], function () {

  Route::get('shop/{slug}/job','ShopController@job');
  
  Route::get('shop/{slug}/job_add','JobController@add');
  Route::post('shop/{slug}/job_add','JobController@addingSubmit');

  Route::get('shop/{slug}/job_edit/{job_id}','JobController@edit');
  Route::patch('shop/{slug}/job_edit/{job_id}',[
    'uses' => 'JobController@editingSubmit'
  ]);
});

// Branch
Route::group(['middleware' => 'auth'], function () {
  Route::get('shop/{slug}/branch_detail/{branch_id}','BranchController@detail');

  Route::get('shop/{slug}/branch_add','BranchController@add');
  Route::post('shop/{slug}/branch_add','BranchController@addingSubmit');
});

// Person Post Item
Route::get('item/list','ItemController@listView');
Route::get('item/detail/{item_id}','ItemController@detail');

Route::group(['middleware' => 'auth'], function () {
  Route::get('item/post','ItemController@post');
  Route::post('item/post','ItemController@postingSubmit');

  // Route::get('item/edit/{item_id}','ItemController@edit');
  // Route::patch('item/edit/{item_id}',[
  //   'as' => 'item.edit',
  //   'uses' => 'ItemController@editingSubmit'
  // ]);
});

// Real Estate
Route::get('real-estate/list','RealEstateController@listView');
Route::get('real-estate/detail/{real_estate_id}','RealEstateController@detail');

Route::group(['middleware' => 'auth'], function () {
  Route::get('real-estate/post','RealEstateController@post');
  Route::post('real-estate/post','RealEstateController@postingSubmit');

  Route::get('real-estate/edit/{real_estate_id}','RealEstateController@edit');
  Route::patch('real-estate/edit/{real_estate_id}',[
    'uses' => 'RealEstateController@editingSubmit'
  ]);
});

Route::group(['prefix' => 'api/v1', 'middleware' => 'api'], function () {
  Route::get('get_sub_district/{districtId}', 'ApiController@GetSubDistrict');
  Route::get('token', 'ApiController@token');
});

Route::group(['middleware' => 'auth'], function () {
  Route::post('upload_image', 'ApiController@uploadImage');
  // Route::post('delete_image', 'ApiController@deleteImage');
});

