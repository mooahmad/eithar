<?php

Auth::routes();


define('ADL','Administrator/layouts');
define('AD','Administrator/UsersModule');
define('FEL','Frontend/layouts');
define('FE','Frontend');

Route::get('/',function (){
    return view('welcome');
});

Route::group(['middleware'=>'guest'], function (){
    Route::get('admins/login','LoginController@login')->name('Login');
    Route::post('admins/login','LoginController@checkLogin');
});

Route::group(['middleware'=>'AdminAuth','namespace'=>AD,'prefix'=>AD],function (){

    Route::get('logout','AdminsController@logout')->name('Logout');

    Route::get('home','AdminsController@index')->name('Home');

    Route::resource('admins','AdminsController',['names'=>['index'=>'Show Admins','create'=>'Create New Admin','edit'=>'Edit Admin','show'=>'Show Admin']]);
    Route::patch('change-password/{id}','AdminsController@user_update_password');
});


