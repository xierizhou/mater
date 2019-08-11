<?php
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

        Route::resource('agent', 'Admin\AgentController',['except' => ['show']]);
        Route::resource('grade', 'Admin\GradeController',['except' => ['show']]);
        Route::resource('channel_account', 'Admin\ChannelAccountController',['except' => ['show']]);
    });
});
