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
define('CUSN', 'Administrator\Customers');
define('BSN', 'Administrator\BookingServices');
define('MRP', 'Administrator\MedicalReports');
define('MMRP', 'Administrator\MeetingsMedicalReports');
define('SET', 'Administrator\Settings');

/*-------------------------------------
----------- Frontend Routes -----------
-------------------------------------*/
Route::group(['namespace' => FE], function () {
    Route::group(['middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],'prefix' => LaravelLocalization::setLocale()], function () {
        Route::get('/', 'FrontendController@index')->name('home');

        Route::group(['namespace'=>'CategoriesFront'],function (){
            Route::get('categories/{category}/{name}', 'CategoriesFrontController@showSubCategories')->name('show-subcategories');
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
            'index' => 'show admin',
            'create' => 'create admin',
            'show' => 'show admin',
            'edit' => 'edit admin',
            'destroy' => 'delete admin'
        ]]);
    Route::get('getadminsdatatable', 'AdminsController@getAdminsDataTable')->name('getAdminsDatatable');
    Route::post('deleteadmins', 'AdminsController@deleteAdmins')->name('deleteAdmins');
});

Route::group(['middleware' => 'AdminAuth', 'namespace' => CATN, 'prefix' => AD], function () {
    Route::resource('categories', 'CategoriesController',
        ['names' => [
            'index' => 'show category',
            'create' => 'create category',
            'show' => 'show category',
            'edit' => 'edit category',
            'destroy' => 'delete category'
        ]]);
    Route::get('getcategoriesdatatable', 'CategoriesController@getCategoriesDataTable')->name('getCategoriesDatatable');
    Route::post('deletecategories', 'CategoriesController@deleteCategories')->name('deleteCategories');
});

Route::group(['middleware' => 'AdminAuth', 'namespace' => SRVN, 'prefix' => AD], function () {
    Route::resource('services', 'ServicesController',
        ['names' => [
            'index' => 'show service',
            'create' => 'create service',
            'show' => 'show service',
            'edit' => 'edit service',
            'destroy' => 'delete service'
        ]]);
    Route::get('getservicesdatatable', 'ServicesController@getServicesDataTable')->name('getServicesDatatable');
    Route::post('deleteservices', 'ServicesController@deleteServices')->name('deleteServices');
    Route::get('getservicestypes/{categoryId}/{serviceId?}', 'ServicesController@getServicesTypes')->name('getServicesTypes');

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

    // calendar section
    Route::get('services/{id}/calendar', 'ServicesController@showServiceCalendar')->name('showServiceCalendar');
    Route::get('services/{id}/calendar/create', 'ServicesController@createServiceCalendar')->name('createServiceCalendar');
    Route::post('services/{id}/calendar/store', 'ServicesController@storeServiceCalendar')->name('storeServiceCalendar');
    Route::get('services/{id}/calendar/{calendarId}/edit', 'ServicesController@editServiceCalendar')->name('editServiceCalendar');
    Route::post('services/{id}/calendar/{calendarId}/update', 'ServicesController@updateServiceCalendar')->name('updateServiceCalendar');

    // calendar dataTable
    Route::post('services/{id}/calendar/datatable', 'ServicesController@getCalendarDatatable')->name('getServiceCalendarDatatable');
    Route::post('deleteServiceCalendar', 'ServicesController@deleteCalendar')->name('deleteServiceCalendar');

    // lap calendar section
    Route::get('lap/calendar', 'ServicesController@showServiceLapCalendar')->name('showServiceLapCalendar');
    Route::get('lap/calendar/create', 'ServicesController@createServiceLapCalendar')->name('createServiceLapCalendar');
    Route::post('lap/calendar/store', 'ServicesController@storeServiceLapCalendar')->name('storeServiceLapCalendar');
    Route::get('lap/calendar/{calendarId}/edit', 'ServicesController@editServiceLapCalendar')->name('editServiceLapCalendar');
    Route::post('lap/calendar/{calendarId}/update', 'ServicesController@updateServiceLapCalendar')->name('updateServiceLapCalendar');

    // calendar dataTable
    Route::post('lap/calendar/datatable', 'ServicesController@getLapCalendarDatatable')->name('getServiceLapCalendarDatatable');
    Route::post('deleteServiceLapCalendar', 'ServicesController@deleteLapCalendar')->name('deleteServiceLapCalendar');
});

Route::group(['middleware' => 'AdminAuth', 'namespace' => PRON, 'prefix' => AD], function () {
    Route::resource('providers', 'ProvidersController',
        ['names' => [
            'index' => 'show provider',
            'create' => 'create provider',
            'show' => 'show provider',
            'edit' => 'edit provider',
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
            'index' => 'show promo code',
            'create' => 'create promo code',
            'show' => 'show promo code',
            'edit' => 'edit promo code',
            'destroy' => 'delete promo code'
        ]]);
    Route::get('getpromocodesdatatable', 'PromoCodesController@getPromoCodesDataTable')->name('getPromoCodesDataTable');
    Route::post('deletepromocodes', 'PromoCodesController@deletePromoCodes')->name('deletePromoCodes');
});

Route::group(['middleware' => 'AdminAuth', 'namespace' => SET, 'prefix' => AD], function () {
    Route::resource('settings', 'SettingsController',
        ['names' => [
            'index' => 'show settings',
            'create' => 'create settings',
            'show' => 'show settings',
            'edit' => 'edit settings',
            'destroy' => 'delete settings'
        ]]);
    Route::get('getPushType/{id}', 'SettingsController@getPushType');
});

Route::group(['middleware' => 'AdminAuth', 'namespace' => MRP, 'prefix' => AD], function () {
    Route::resource('medical_reports', 'MedicalReportController',
        ['names' => [
            'index' => 'show medical report',
            'create' => 'create medical report',
            'show' => 'show medical report',
            'edit' => 'edit medical report',
            'destroy' => 'delete medical report'
        ]]);
    Route::get('getmedicalreportsdatatable', 'MedicalReportController@getMedicalReportsDataTable')->name('getMedicalReportsDataTable');
    Route::post('deletemedicalreports', 'MedicalReportController@deleteMedicalReports')->name('deleteMedicalReports');
});

Route::group(['middleware' => 'AdminAuth', 'namespace' => MMRP, 'prefix' => AD], function () {
    Route::get('meetings/{id}/report', 'MeetingsMedicalReportController@index')->name('showMeetingReport');
    Route::get('meetings/{id}/report/create', 'MeetingsMedicalReportController@create')->name('createMeetingReport');
    Route::post('meetings/{id}/report/store', 'MeetingsMedicalReportController@store')->name('storeMeetingReport');
    Route::get('meetings/{id}/report/{reportId}/edit', 'MeetingsMedicalReportController@edit')->name('editMeetingReport');
    Route::post('meetings/{id}/report/{reportId}/update', 'MeetingsMedicalReportController@update')->name('updateMeetingReport');

    Route::get('meetings/{id}/reports/datatable', 'MeetingsMedicalReportController@getMedicalReportsDataTable')->name('getMeetingsMedicalReportsDataTable');
    Route::post('deleteMeetingReports', 'MeetingsMedicalReportController@deleteMedicalReports')->name('deleteMeetingsMedicalReports');
});

Route::group(['middleware' => 'AdminAuth', 'prefix' => AD], function () {
    Route::group(['namespace' => INVN], function () {
        Route::get('generate-invoice/{booking}', 'InvoicesController@index')->name('generate-invoice');
        Route::post('invoice-add-item', 'InvoicesController@addItemToInvoice')->name('add-item-to-invoice');
        Route::post('invoice-delete-item', 'InvoicesController@deleteItemToInvoice')->name('delete-item-to-invoice');
        Route::get('invoice-pay/{invoice}', 'InvoicesController@showPayInvoice')->name('show-pay-invoice');
        Route::post('invoice-pay', 'InvoicesController@storePayInvoice')->name('store-pay-invoice');
    });

    Route::group(['namespace' => CUSN], function () {
        Route::resource('customers', 'CustomersController',
            ['names' => [
                'index' => 'show_customers',
                'create' => 'add_customers',
                'show' => 'show_customers',
                'edit' => 'edit_customers',
                'destroy' => 'delete_customers'
            ]]);
        Route::get('get-customers-Datatable', 'CustomersController@getCustomersDataTable')->name('get-customers-Datatable');
        Route::get('get-customer-appointments-Datatable/{id}', 'CustomersController@getCustomerAppointmentsDataTable')->name('get-customer-appointments-Datatable');
    });

    Route::group(['namespace' => BSN], function () {
        Route::get('meetings/canceled', 'BookingServicesController@index')->name('meetings');
        Route::get('meetings/inprogress', 'BookingServicesController@index')->name('meetings');
        Route::get('meetings/confirmed', 'BookingServicesController@index')->name('meetings');
        Route::get('get-meetings-Datatable', 'BookingServicesController@getBookingServicesDataTable')->name('get-meetings-Datatable');
        Route::get('meetings/{booking}', 'BookingServicesController@show')->name('show-meeting-details');
        Route::post('meetings/{booking}/assign-provider', 'BookingServicesController@assignProviderToMeeting')->name('assign-provider-to-meeting');
    });
});

