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
    Route::group(['namespace' => 'WebApi\UsersModule', 'prefix' => 'customers'], (function () {
        Route::post('updateAvatar', 'CustomerController@updateCustomerAvatar');
        Route::post('updateNationalId', 'CustomerController@updateCustomerNationalId');
        Route::post('verifyEmail', 'CustomerController@verifyCustomerEmail');
        Route::get('resendEmailVerificationCode', 'CustomerController@resendEmailVerificationCode');
        Route::post('edit', 'CustomerController@editCustomer');
        Route::post('addFamilyMember', 'CustomerController@addCustomerFamilyMember');
        Route::post('editFamilyMember', 'CustomerController@editCustomerFamilyMember');
        Route::post('getFamilyMember', 'CustomerController@getCustomerFamilyMember');
        Route::post('deleteFamilyMember', 'CustomerController@deleteCustomerFamilyMember');
        Route::get('getFamilyMembers', 'CustomerController@getCustomerFamilyMembers');
    }));

    Route::group(['namespace' => 'WebApi\CategoriesModule', 'prefix' => 'categories'], (function () {
        Route::get('/', 'CategoriesController@getMainCategories');
        Route::get('/{id}', 'CategoriesController@getChildCategories');
        Route::get('/service/{id}/questionnaire/{page?}', 'CategoriesController@getServiceQuestionnaire');
    }));

    Route::group(['namespace' => 'WebApi\UsersModule', 'prefix' => 'providers'], (function () {
        Route::post('/{id}', 'ProviderController@getProvider');
    }));

    Route::group(['namespace' => 'WebApi\PromoCodesModule', 'prefix' => 'promo_codes'], (function () {
        Route::post('/register', 'PromoCodesController@registerPromoCode');
    }));
});

Route::group(['namespace' => 'WebApi\UsersModule', 'prefix' => 'customers'], (function () {
    Route::post('forgetPassword', 'CustomerController@forgetPassword');
    Route::post('updateForgottenPassword', 'CustomerController@updateForgottenPassword');
}));

Route::group(['namespace' => 'WebApi\CountriesModule', 'prefix' => 'countries'], (function () {
    Route::get('/', 'CountriesController@getCountries');
}));

Route::group(['namespace' => 'WebApi\CitiesModule', 'prefix' => 'cities'], (function () {
    Route::get('/{countryID}', 'CitiesController@getCities');
}));



