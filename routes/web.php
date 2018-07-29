<?php

Auth::routes();

define('ADL','Administrator/layouts');
define('AD','Administrator');
define('ADN','Administrator\UsersModule');
define('FEL','Frontend/layouts');
define('FE','Frontend');

Route::group(['middleware'=>'AdminAuth','namespace'=>ADN,'prefix'=>AD],function (){
    Route::get('logout','AdminsController@logout')->name('Logout');
    Route::get('home','AdminsController@index')->name('Home');
    Route::resource('admins','AdminsController',['names'=>['index'=>'Show Admins','create'=>'Create New Admin','edit'=>'Edit Admin','show'=>'Show Admin']]);
    Route::patch('change-password/{id}','AdminsController@userUpdatePassword');
});


