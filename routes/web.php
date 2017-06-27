<?php

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
Route::get('/posts/{post}/zan','PostController@delete')->name('zan');

//图片上传
Route::post('/posts/image/upload','PostController@imageUpload')->name('zan');