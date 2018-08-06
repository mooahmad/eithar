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
        Route::post('verifyCustomerEmail', 'CustomerController@verifyCustomerEmail');
        Route::get('resendEmailVerificationCode', 'CustomerController@resendEmailVerificationCode');
        Route::post('editCustomer', 'CustomerController@editCustomer');
        Route::post('addCustomerFamilyMember', 'CustomerController@addCustomerFamilyMember');
        Route::post('editCustomerFamilyMember', 'CustomerController@editCustomerFamilyMember');
        Route::post('getCustomerFamilyMember', 'CustomerController@getCustomerFamilyMember');
        Route::post('deleteCustomerFamilyMember', 'CustomerController@deleteCustomerFamilyMember');
        Route::get('getCustomerFamilyMembers', 'CustomerController@getCustomerFamilyMembers');
    });
    Route::namespace('WebApi\CategoriesModule')->group(function () {
        Route::get('getMainCategories', 'CategoriesController@getMainCategories');
        Route::get('getChildCategories/{id}', 'CategoriesController@getChildCategories');
    });
});

Route::namespace('WebApi\UsersModule')->group(function () {
    Route::post('forgetPassword', 'CustomerController@forgetPassword');
    Route::post('updateForgottenPassword', 'CustomerController@updateForgottenPassword');
});

Route::namespace('WebApi\CountriesModule')->group(function () {
    Route::get('getCountries', 'CountriesController@getCountries');
});
Route::namespace('WebApi\CitiesModule')->group(function () {
    Route::get('getCities/{countryID}', 'CitiesController@getCities');
});



