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


Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');


Route::get('/replace', 'Home\ReplaceController@index');
Route::get('/authorization/qianku', 'Home\AuthorizationLoginController@qianku');
Route::post('/replace/build', 'Home\ReplaceController@build');
Route::post('/replace/store', 'Home\ReplaceController@store');
Route::group(['middleware' => 'auth','namespace'=>'Home'], function () {
    Route::get('/', 'IndexController@show')->name('home');
    Route::post('/build', 'IndexController@build')->middleware("auth.user.download");
});



Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'Admin\LoginController@showLoginForm');
    Route::post('login', 'Admin\LoginController@login');
    Route::any('logout', 'Admin\LoginController@logout');
    Route::get('/', 'Admin\IndexController@index');

    Route::group(['middleware' => 'auth.admin:admin'], function () {
        Route::get('/', 'Admin\IndexController@index');
        Route::get('/welcome', 'Admin\IndexController@welcome');
        Route::resource('materials', 'Admin\MaterialsController',['except' => ['show']]);
        Route::resource('channel', 'Admin\ChannelController',['except' => ['show']]);
        Route::resource('user', 'Admin\UserController',['except' => ['show']]);
        Route::resource('user_material', 'Admin\UserMaterialController',['except' => ['show']]);
        Route::resource('material_price', 'Admin\MaterialPriceController',['except' => ['show']]);
    });
});




