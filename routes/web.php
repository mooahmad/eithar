<?php

Auth::routes();

define('ADL', 'Administrator/layouts');
define('AD', 'Administrator');
define('ADN', 'Administrator\UsersModule');
define('FEL', 'Frontend/layouts');
define('FE', 'Frontend');
define('CAT', 'Categories');
define('CATN', 'Administrator\Categories');

Route::group(['prefix' => 'password'], function () {
    Route::view('forgotpassword', 'auth.passwords.forgotPassword')->name('forgotPassword');
    Route::view('resetpassword', 'auth.passwords.reset')->name('adminReset');
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('adminforget', 'ForgotPasswordController@sendAdminForget')->name('adminForget');
        Route::post('adminreset', 'ForgotPasswordController@resetAdminForget')->name('adminResetPassword');
    });
});


Route::group(['middleware' => 'AdminAuth', 'namespace' => ADN, 'prefix' => AD], function () {
    //logout
    Route::get('logout', 'AdminsController@logout')->name('Logout');
    // home
    Route::get('home', 'AdminsController@index')->name('Home');
    // admins
    Route::resource('admins', 'AdminsController',
                    ['names' => [
                        'index'   => 'show admin',
                        'create'  => 'create admin',
                        'show'    => 'show admin',
                        'edit'    => 'edit admin',
                        'destroy' => 'delete admin'
                    ]]);
    Route::get('getadminsdatatable', 'AdminsController@getAdminsDataTable')->name('getAdminsDatatable');
    Route::post('deleteadmins', 'AdminsController@deleteAdmins')->name('deleteAdmins');
});

Route::group(['middleware' => 'AdminAuth', 'namespace' => CATN, 'prefix' => CAT], function () {
    Route::resource('categories', 'CategoriesController',
                    ['names' => [
                        'index'   => 'show category',
                        'create'  => 'create category',
                        'show'    => 'show category',
                        'edit'    => 'edit category',
                        'destroy' => 'delete category'
                    ]]);
    Route::get('getcategoriesdatatable', 'CategoriesController@getCategoriesDataTable')->name('getCategoriesDatatable');
    Route::post('deletecategories', 'CategoriesController@deleteCategories')->name('deleteCategories');
});


