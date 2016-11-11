<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Route::get('admin/index', 'Admin\IndexController@index');


Route::group( ['middleware' => ['web']],function(){

});

//
Route::group(['middleware' => ['admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::get('','IndexController@index');
    Route::get('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::any('pass','IndexController@pass');
    // 文章分类路由
    Route::resource('category','CategoryController');
    Route::post('cate/changeorder','CategoryController@changeOrder'); // 分类ajax排序
    // 文章路由
    Route::resource('article','ArticleController');

    // 图片上传
    Route::any('upload','CommonController@upload');

    // 友情链接路由
    Route::resource('links','LinksController');
    Route::post('links/changeorder','LinksController@changeOrder'); // 分类ajax排序

    // 友情链接路由
    Route::resource('navs','NavsController');
    Route::post('navs/changeorder','NavsController@changeOrder'); // ajax排序

    // 系统配置路由
    Route::post('conf/changeorder','ConfController@changeOrder'); // ajax排序
    Route::post('conf/changecontent','ConfController@changeContent'); // ajax更改系统配置
    Route::get('conf/putfile','ConfController@putFile'); //  将配置项数据写入配置文件
    Route::resource('conf','ConfController');


});


// 登陆模块
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::any('login','LoginController@login');
    Route::get('code','LoginController@code');
    Route::get('get','LoginController@get');
    Route::get('crypt','LoginController@crypt');
    Route::get('quit','LoginController@quit');
});

 // 前台
Route::group(['namespace'=>'Home'],function(){
    Route::get('/', 'IndexController@index');
    Route::get('cate/{cate_id}', 'IndexController@cate');
    Route::get('art/{art_id}', 'IndexController@art');

});



//Route::get('/', function () {
//        return view('welcome');
//    });
//
//Route::get('/', 'IndexController@index');
