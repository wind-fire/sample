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

<<<<<<< HEAD
/*激活用户链接路由*/
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
=======
/*用户账户激活邮件*/
Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');

/*用户密码重设功能*/
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

/*创建微博，删除微博*/
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);

/*关注人列表和粉丝列表*/
Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');

/*关注用户和取消用户*/
Route::post('/users/followers/{user}', 'FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');

