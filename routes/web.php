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


Route::get('/auth/qq', 'Auth\QQAuthorizationController@showQR');
Route::get('/auth/qq/qr_check', 'Auth\QQAuthorizationController@checkSweepCode');
Route::post('/auth/qq/login_success', 'Auth\QQAuthorizationController@loginSuccess');
Route::post('/auth/qq/login_gtk', 'Auth\QQAuthorizationController@gtk');

Route::get('/replace', 'Home\ReplaceController@index');
Route::get('/authorization/qianku', 'Home\AuthorizationLoginController@qianku');
Route::post('/replace/build', 'Home\ReplaceController@build');
Route::post('/replace/store', 'Home\ReplaceController@store');
Route::group(['middleware' => 'auth','namespace'=>'Home'], function () {
    Route::get('/', 'IndexController@show')->name('home');
    Route::get('/ibaout/varify', 'VerifyController@iboutuVerify');
    Route::post('/build', 'IndexController@build')->middleware("auth.user.download");
    Route::get('/ibaout/varify/show', 'VerifyController@iboutu');
});







