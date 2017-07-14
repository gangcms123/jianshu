<?php
//注册页面
Route::get('/register','RegisterController@index')->name('register');
Route::post('/register','RegisterController@register')->name('registerstore');
//登录页面
Route::get('/login','LoginController@index')->name('login');
Route::post('/login','LoginController@login')->name('loginstore');
//前台路由
Route::group(['middleware'=>'auth:web'],function (){
    Route::get('/','PostController@index');
    //退出
    Route::get('/logout','LoginController@logout')->name('logout');
    //个人设置页面
    Route::get('/user/me/setting','UserController@setting')->name('setting');
    Route::get('/user/{user}','UserController@show')->name('myshow');
    Route::post('/user/{user}/fan','UserController@fan')->name('fan');
    Route::post('/user/{user}/unfan','UserController@unfan')->name('unfan');
    Route::post('/user/me/setting','UserController@settingstore')->name('settingstore');
    //搜索页面
    Route::get('/posts/search','PostController@search')->name('search');
    //文章列表页
    Route::get('/posts','PostController@index')->name('index');
    //创建文章
    Route::get('/posts/create','\App\Http\Controllers\PostController@create')->name('create');
    Route::post('/posts','PostController@store');
    //文章详情页
    Route::get('/posts/{post}','PostController@show')->name('show');
    //编辑文章
    Route::get('/posts/{post}/edit','PostController@edit')->name('edit');
    Route::put('/posts/{post}','PostController@update')->name('editsave');
    //删除文章
    Route::get('/posts/{post}/delete','PostController@delete')->name('delete');
    //点赞
    Route::get('/posts/{post}/zan','PostController@zan')->name('zan');
    Route::get('/posts/{post}/unzan','PostController@unzan')->name('unzan');
    //图片上传
    Route::post('/posts/image/upload','PostController@imageUpload')->name('imageUpload');
    //提交评论
    Route::post('/posts/{post}/comment','PostController@comment')->name('comment');
    //专题
    Route::get('/topic/{topic}','TopicController@show')->name('topic');
    Route::post('/topic/{topic}/submit','TopicController@submit')->name('submit');
    //通知
    Route::get('/notices','NoticeController@index')->name('notice');
});

Route::group(['prefix'=>'admin'],function (){
    Route::get('/login','\App\Admin\Controllers\LoginController@index');
    Route::post('/login','\App\Admin\Controllers\LoginController@login');
    Route::get('/logout','\App\Admin\Controllers\LoginController@logout');
    Route::group(['middleware' => 'auth:admin'],function (){

        //后台首页
        Route::get('/home','\App\Admin\Controllers\HomeController@index');

        Route::group(['middleware' => 'can:system'],function (){
            //后台账号管理模块
            Route::get('/users','\App\Admin\Controllers\UserController@index');
            Route::get('/users/create','\App\Admin\Controllers\UserController@create');
            Route::post('/users/store','\App\Admin\Controllers\UserController@store');
            Route::get('/users/{user}/role','\App\Admin\Controllers\UserController@role');
            Route::post('/users/{user}/role','\App\Admin\Controllers\UserController@storeRole');

            //角色
            Route::get('/roles','\App\Admin\Controllers\RoleController@index');
            Route::get('/roles/create','\App\Admin\Controllers\RoleController@create');
            Route::post('/roles/store','\App\Admin\Controllers\RoleController@store');
            Route::get('/roles/{role}/permission','\App\Admin\Controllers\RoleController@permission');
            Route::post('/roles/{role}/permission','\App\Admin\Controllers\RoleController@storePermission');

            //权限
            Route::get('/permissions','\App\Admin\Controllers\PermissionController@index');
            Route::get('/permissions/create','\App\Admin\Controllers\PermissionController@create');
            Route::post('/permissions/store','\App\Admin\Controllers\PermissionController@store');
        });

        Route::group(['middleware' => 'can:post'],function (){
            //审核模块
            Route::get('/posts','\App\Admin\Controllers\PostController@index');
            Route::post('/posts/{post}/status','\App\Admin\Controllers\PostController@status');
        });

        Route::group(['middleware' => 'can:topic'],function (){
            Route::resource('topics','\App\Admin\Controllers\TopicController',['only' => ['index','create','store','destroy']]);
        });

        Route::group(['middleware' => 'can:notice'],function (){
            Route::resource('notices','\App\Admin\Controllers\NoticeController',['only' => ['index','create','store']]);
        });

    });
});

