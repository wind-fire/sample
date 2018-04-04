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

/*Route::get('/', function () {
    return view('welcome');
});*/

//Route::get('/','StaticPagesController@home');
//Route::get('/help','StaticPagesController@help');
//Route::get('/about','StaticPagesController@about');
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

//用户注册页
Route::get('signup', 'UsersController@create')->name('signup');

//路由声明时必须使用 Eloquent 模型的单数小写格式来作为路由片段参数，User 对应 {user}
//新增resource方法遵循RESTful架构为用户资源生成路由，第一个参数为资源名称，第二个参数为控制器名称
Route::resource('users','UsersController');

/*登录以及注销的路由*/
Route::get('login', 'SessionsController@create')->name('login'); //显示登录页面
Route::post('login', 'SessionsController@store')->name('login'); //创建新会话（登录）
Route::delete('logout', 'SessionsController@destroy')->name('logout'); //销毁会话（退出登录）

/*激活用户链接路由*/
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');