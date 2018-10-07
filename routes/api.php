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
    Route::post('loginProvider', 'LoginController@loginProvider');
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

Route::middleware('auth:api')->group(function () {
    Route::group(['namespace' => 'WebApi\UsersModule', 'prefix' => 'customers'], (function () {
        Route::get('logoutCustomer', 'CustomerController@logoutCustomer');
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
        Route::get('getAppointments', 'CustomerController@getCustomerAppointments');
        Route::get('getAppointments/{id}/{servicetype}', 'CustomerController@getCustomerAppointment');
        Route::get('getNotifications', 'CustomerController@getCustomerNotifications');
        Route::get('getMedicalReports', 'CustomerController@getCustomerMedicalReports');
        Route::post('bookingItem/{id}/confirmItem', 'CustomerController@confirmBookingItem');
        Route::get('search/{keyword}', 'CustomerController@search');
    }));

    Route::group(['namespace' => 'WebApi\CategoriesModule', 'prefix' => 'categories'], (function () {
        Route::get('/', 'CategoriesController@getMainCategories');
        Route::post('/{id}/{isPackage?}', 'CategoriesController@getChildCategories');
    }));


    Route::group(['namespace' => 'WebApi\ServicesModule', 'prefix' => 'services'], (function () {
        Route::get('/{id}/questionnaire/{page?}', 'ServicesController@getServiceQuestionnaire');
        Route::post('/lap/calendar', 'ServicesController@getLapCalendar');
        Route::post('/{id}/calendar', 'ServicesController@getServiceCalendar');
        Route::post('/{id}/book', 'ServicesController@book');
        Route::post('/cancelBook/{id}', 'ServicesController@cancelBook');
        Route::post('/{id}/like', 'ServicesController@like');
        Route::post('/{id}/unlike', 'ServicesController@unlike');
        Route::post('/{id}/follow', 'ServicesController@follow');
        Route::post('/{id}/unfollow', 'ServicesController@unFollow');
        Route::post('/{id}/rate', 'ServicesController@rate');
        Route::post('/{id}/review', 'ServicesController@review');
        Route::post('/{id}/view', 'ServicesController@view');
        Route::post('/{id}', 'ServicesController@getService');
    }));

    Route::group(['namespace' => 'WebApi\UsersModule', 'prefix' => 'providers'], (function () {
        Route::post('/{id}', 'ProviderController@getProvider');
        Route::post('/{id}/like', 'ProviderController@like');
        Route::post('/{id}/unlike', 'ProviderController@unlike');
        Route::post('/{id}/follow', 'ProviderController@follow');
        Route::post('/{id}/unfollow', 'ProviderController@unFollow');
        Route::post('/{id}/rate', 'ProviderController@rate');
        Route::post('/{id}/review', 'ProviderController@review');
        Route::post('/{id}/view', 'ProviderController@view');
        Route::get('/bookings/{id}/reports', 'ProviderController@getBookingAvailableReports');
        Route::post('/bookings/{id}/addreport', 'ProviderController@addBookingReport');
    }));

    Route::group(['namespace' => 'WebApi\PromoCodesModule', 'prefix' => 'promo_codes'], (function () {
        Route::post('/register', 'PromoCodesController@registerPromoCode');
    }));
});

//-------------------------------------------- Providers section ----------------------------------------------//

Route::middleware('auth:provider')->group(function () {
    Route::group(['namespace' => 'WebApi\UsersModule', 'prefix' => 'providers'], (function () {
        Route::get('logoutProvider', 'ProviderController@logoutProvider');
        Route::get('/bookings/{id}/reports', 'ProviderController@getBookingAvailableReports');
        Route::post('/bookings/{id}/addreport', 'ProviderController@addBookingReport');
    }));
});