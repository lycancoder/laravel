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

// Home 路由组，添加 home 前缀（访问：localhost/home），去掉 prefix（访问：localhost）
Route::group(['namespace' => 'Home', 'prefix' => 'home'], function () {
    // 控制器在 App\Http\Controllers\Home 命名空间下
    Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);
});

