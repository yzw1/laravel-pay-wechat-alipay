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

Route::get('ali/toaccount','AlipayController@toaccountTransfer');//单笔转账
Route::get('ali/query','AlipayController@orderQuery');//单笔转账查询

