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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test/aes1','TestController@aes1');

Route::get('/test/aesdec','TestController@aesdec');

Route::get('/test/sign1','TestController@sign1');

Route::get('/test/header1','TestController@header1');


Route::get('/reg','User\IndexController@reg');

//登录
Route::get('/login','User\IndexController@login');

Route::get('/test/pay','TestController@testPay');
Route::get('/pay','TestController@pay');

Route::get('/goods','TestController@goods');

Route::get('/oauth/git','OauthController@git');

