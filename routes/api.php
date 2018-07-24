<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Auth')->group(function () {
    Route::post('registerCustomer', 'RegisterController@registerCustomer');
    Route::post('loginCustomer', 'LoginController@loginCustomer');
});

Route::middleware('auth:api')->group(function () {
    Route::namespace('WebApi\UsersModule')->group(function () {
        Route::post('updateCustomerAvatar', 'CustomerController@updateCustomerAvatar');
        Route::post('updateCustomerNationalId', 'CustomerController@updateCustomerNationalId');
        Route::post('editCustomer', 'CustomerController@editCustomer');
        Route::post('verifyCustomerEmail', 'CustomerController@verifyCustomerEmail');
        Route::post('addCustomerFamilyMember', 'CustomerController@addCustomerFamilyMember');
        Route::post('editCustomerFamilyMember', 'CustomerController@editCustomerFamilyMember');
        Route::post('getCustomerFamilyMember', 'CustomerController@getCustomerFamilyMember');
        Route::post('deleteCustomerFamilyMember', 'CustomerController@deleteCustomerFamilyMember');
        Route::get('getCustomerFamilyMembers', 'CustomerController@getCustomerFamilyMembers');
    });
});



