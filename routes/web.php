<?php

define('ADL', 'Administrator/layouts');
define('AD', 'Administrator');
define('ADN', 'Administrator\UsersModule');
define('FEL', 'Frontend/layouts');
define('FE', 'Frontend');
define('CATN', 'Administrator\Categories');
define('SRVN', 'Administrator\Services');
define('PRON', 'Administrator\Providers');
define('QUN', 'Administrator\Questionnaire');
define('PRCN', 'Administrator\promo_codes');
define('INVN', 'Administrator\Invoices');

//Frontend Routes
Route::group(['namespace' => FE], function () {
    Route::group(['middleware' => 'Language', 'prefix' => Request::segment(1)], function () {
        Route::group(['prefix' => session()->get('lang')], function () {
            Route::get('/', 'FrontendController@index')->name('home');
        });
    });
});

Auth::routes();

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

Route::group(['middleware' => 'AdminAuth', 'namespace' => CATN, 'prefix' => AD], function () {
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

Route::group(['middleware' => 'AdminAuth', 'namespace' => SRVN, 'prefix' => AD], function () {
    Route::resource('services', 'ServicesController',
                    ['names' => [
                        'index'   => 'show service',
                        'create'  => 'create service',
                        'show'    => 'show service',
                        'edit'    => 'edit service',
                        'destroy' => 'delete service'
                    ]]);
    Route::get('getservicesdatatable', 'ServicesController@getServicesDataTable')->name('getServicesDatatable');
    Route::post('deleteservices', 'ServicesController@deleteServices')->name('deleteServices');

    // questionnaires section
    Route::get('services/{id}/questionnaire', 'ServicesController@showServiceQuestionnaire')->name('showServiceQuestionnaire');
    Route::get('services/{id}/questionnaire/create', 'ServicesController@createServiceQuestionnaire')->name('createServiceQuestionnaire');
    Route::post('services/{id}/questionnaire/store', 'ServicesController@storeServiceQuestionnaire')->name('storeServiceQuestionnaire');
    Route::get('services/{id}/questionnaire/{questionnaireId}/edit', 'ServicesController@editServiceQuestionnaire')->name('editServiceQuestionnaire');
    Route::post('services/{id}/questionnaire/{questionnaireId}/update', 'ServicesController@updateServiceQuestionnaire')->name('updateServiceQuestionnaire');
    Route::get('services/{id}/questionnaire/{page}', 'ServicesController@getAvailablePageOrders')->name('getAvailablePageOrders');
    Route::post('services/questionnaire/options', 'ServicesController@getQuestionnaireOptions')->name('getQuestionnaireOptions');
    Route::get('services/questionnaire/symbollevels/{type}', 'ServicesController@getSymbolLevels')->name('getSymbolLevels');

    // questionnaires dataTable
    Route::post('services/{id}/questionnaire/datatable', 'ServicesController@getQuestionnaireDatatable')->name('getQuestionnaireDatatable');
    Route::post('deleteQuestionnaire', 'ServicesController@deleteQuestionnaire')->name('deleteQuestionnaire');
});

Route::group(['middleware' => 'AdminAuth', 'namespace' => PRON, 'prefix' => AD], function () {
    Route::resource('providers', 'ProvidersController',
                    ['names' => [
                        'index'   => 'show provider',
                        'create'  => 'create provider',
                        'show'    => 'show provider',
                        'edit'    => 'edit provider',
                        'destroy' => 'delete provider'
                    ]]);
    Route::get('getprovidersdatatable', 'ProvidersController@getProvidersDataTable')->name('getProvidersDatatable');
    Route::post('deleteproviders', 'ProvidersController@deleteProviders')->name('deleteProviders');

    // calendar section
    Route::get('providers/{id}/calendar', 'ProvidersController@showProviderCalendar')->name('showProviderCalendar');
    Route::get('providers/{id}/calendar/create', 'ProvidersController@createProviderCalendar')->name('createProviderCalendar');
    Route::post('providers/{id}/calendar/store', 'ProvidersController@storeProviderCalendar')->name('storeProviderCalendar');
    Route::get('providers/{id}/calendar/{calendarId}/edit', 'ProvidersController@editProviderCalendar')->name('editProviderCalendar');
    Route::post('providers/{id}/calendar/{calendarId}/update', 'ProvidersController@updateProviderCalendar')->name('updateProviderCalendar');

    // calendar dataTable
    Route::post('providers/{id}/calendar/datatable', 'ProvidersController@getCalendarDatatable')->name('getCalendarDatatable');
    Route::post('deleteCalendar', 'ProvidersController@deleteCalendar')->name('deleteCalendar');
});

Route::group(['middleware' => 'AdminAuth', 'namespace' => PRCN, 'prefix' => AD], function () {
    Route::resource('promo_codes', 'PromoCodesController',
        ['names' => [
            'index'   => 'show promo code',
            'create'  => 'create promo code',
            'show'    => 'show promo code',
            'edit'    => 'edit promo code',
            'destroy' => 'delete promo code'
        ]]);
    Route::get('getpromocodesdatatable', 'PromoCodesController@getPromoCodesDataTable')->name('getPromoCodesDataTable');
    Route::post('deletepromocodes', 'PromoCodesController@deletePromoCodes')->name('deletePromoCodes');
});

Route::group(['middleware' => 'AdminAuth', 'namespace' => INVN, 'prefix' => AD], function () {
    Route::resource('invoices', 'InvoicesController',
        ['names' => [
            'index'   => 'Show Invoices',
            'create'  => 'Create Invoice',
            'show'    => 'Show Invoice',
            'edit'    => 'Edit Invoice',
            'destroy' => 'Delete Invoice'
        ]]);
//    Route::get('getpromocodesdatatable', 'PromoCodesController@getPromoCodesDataTable')->name('getPromoCodesDataTable');
//    Route::post('deletepromocodes', 'PromoCodesController@deletePromoCodes')->name('deletePromoCodes');
});

