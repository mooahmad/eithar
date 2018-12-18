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
define('DRV', 'Administrator\Drivers');


/*-------------------------------------
----------- Frontend Routes -----------
-------------------------------------*/
Route::group(['namespace' => FE], function () {
    Route::group(['middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],'prefix' => LaravelLocalization::setLocale()], function () {
        Route::get('/', 'FrontendController@index')->name('home');
        Route::get('about-us', 'FrontendController@AboutUs')->name('about_us');
        Route::get('privacy-and-conditions', 'FrontendController@PrivacyAndConditions')->name('privacy_and_conditions');

        Route::group(['namespace'=>'CustomerFront'],function (){
            Route::group(['prefix'=>'customer'], function (){
                Route::get('login', 'LoginFrontController@showCustomerLogin')->name('customer_login');
                Route::post('login', 'LoginFrontController@customerLogin')->name('customer_login_post');
                Route::get('sign-up', 'SignUpFrontController@showCustomerSignUp')->name('customer_sign_up');
                Route::post('sign-up', 'SignUpFrontController@saveCustomerSignUp')->name('customer_sign_up_post');
                Route::post('get-country-cities', 'SignUpFrontController@getCountryCities')->name('get_country_cities');
                Route::get('activate-account/{mobile}', 'SignUpFrontController@showCustomerVerifyMobileCode')->name('verify_sent_code');
                Route::get('resend-verify-code', 'SignUpFrontController@resendCustomerVerifyCode')->name('resend_verify_code');
                Route::post('resend-verify-code', 'SignUpFrontController@resendCustomerVerifyCodePost')->name('resend_verify_code_post');
                Route::get('reset-password', 'ResetPasswordFrontController@showCustomerResetPassword')->name('customer_reset_password');
                Route::post('reset-password', 'ResetPasswordFrontController@checkCustomerResetPassword')->name('customer_reset_password_post');
                Route::get('verify-reset-password/{mobile}', 'ResetPasswordFrontController@showVerifyCustomerResetPassword')->name('customer_reset_password_verify_code');
                Route::post('verify-reset-password', 'ResetPasswordFrontController@checkVerifyCustomerResetPassword')->name('customer_reset_password_verify_code_post');

                Route::group(['middleware'=>'CustomerWebAuth'],function (){
                    Route::get('logout', 'LoginFrontController@logoutCustomer')->name('customer_logout');
                    Route::get('profile/show/{id}/{name}', 'ProfileCustomerController@index')->name('show_customer_profile');
                    Route::get('profile/update/{id}/{name}', 'UpdateCustomerProfileController@showUpdateCustomerProfile')->name('customer_show_update_profile');
                    Route::post('profile/update/{id}/{name}', 'UpdateCustomerProfileController@storeUpdateCustomerProfile')->name('customer_update_profile_post');
                    Route::post('profile/update/password', 'UpdateCustomerProfileController@storeUpdateCustomerPassword')->name('customer_update_password_post');
                });

            });
        });

        Route::group(['namespace'=>'CategoriesFront'],function (){
            Route::group(['prefix'=>'categories'], function (){

                Route::get('doctors','CategoriesFrontController@showDoctorsSubCategories')->name('doctors_category');
                Route::group(['namespace'=>'Doctors'],function (){
                    Route::get('doctors/{subcategory_id}/{subcategory_name}/doctor/{provider_id}/{provider_name}','DoctorsCategoryController@showDoctorProfile')->name('doctor_profile');
                    Route::get('doctors/{subcategory_id}/{subcategory_name}/doctor/{provider_id}/{provider_name}/book','DoctorsCategoryController@showDoctorQuestionnaireCalendar')->name('doctor_booking_meeting');
                    Route::post('doctors/book-provider-meeting','DoctorsCategoryController@book')->name('book_provider_meeting');
                    Route::post('doctors/getCalendarDays','DoctorsCategoryController@getCalendarDays')->name('getCalendarDays');
                    Route::post('doctors/getAvailableSlots','DoctorsCategoryController@getAvailableSlots')->name('getAvailableSlots');
                    Route::post('doctors/checkPromoCode','DoctorsCategoryController@checkPromoCodeAndGetAmount')->name('checkPromoCode');
                    Route::post('doctors/like','DoctorsCategoryController@likeProvider')->name('like_provider_transaction');
                });

                Route::get('lap','CategoriesFrontController@showLapSubCategories')->name('lap_category');
                Route::get('physiotherapy','CategoriesFrontController@showPhysiotherapySubCategories')->name('physiotherapy_category');
                Route::get('nurse','CategoriesFrontController@showNurseSubCategories')->name('nurse_category');
                Route::get('women','CategoriesFrontController@showWomenSubCategories')->name('women_category');
                Route::post('subcategory-providers-list','CategoriesFrontController@getSubCategoryProvidersList')->name('get_subcategory_providers_list');

            });
//            Route::get('categories/{category}/{name}', 'CategoriesFrontController@showSubCategories')->name('show-subcategories');
        });
    });
});

Auth::routes();
Route::group(['namespace' => 'Auth'], function () {
    Route::get('login/provider', 'LoginController@showProviderLogin')->name('provider_login');
    Route::post('login/provider', 'LoginController@postLoginProvider')->name('post_provider_login');

    Route::group(['middleware'=>'ProviderAuth','prefix' => AD],function (){
        Route::get('logout/provider', 'LoginController@logoutProvider')->name('logout_provider');
    });
});

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
    Route::get('home', 'AdminsController@home')->name('Home');
    // admins
    Route::resource('admins', 'AdminsController',
        ['names' => [
            'index' => 'show_admins',
            'create' => 'create_admin',
            'show' => 'show_admin',
            'edit' => 'edit_admin',
            'destroy' => 'delete_admin'
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

Route::group(['namespace' => PRON, 'prefix' => AD], function () {
    Route::resource('providers', 'ProvidersController',
        ['names' => [
            'index' => 'show_providers',
            'create' => 'create_provider',
            'show' => 'show_provider',
            'edit' => 'edit_provider',
            'destroy' => 'delete_provider'
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
            'index' => 'show medical_reports',
            'create' => 'create medical_reports',
            'show' => 'show medical_reports',
            'edit' => 'edit medical_reports',
            'destroy' => 'delete medical_reports'
        ]]);

    // medical reports datatable
    Route::get('getmedicalreportsdatatable', 'MedicalReportController@getMedicalReportsDataTable')->name('getMedicalReportsDataTable');
    Route::post('deletemedicalreports', 'MedicalReportController@deleteMedicalReports')->name('deleteMedicalReports');

    // medical reports questions section
    Route::get('medical_reports/{id}/questions', 'MedicalReportController@showMedicalReportsQuestions')->name('showMedicalReportsQuestions');
    Route::get('medical_reports/{id}/questions/create', 'MedicalReportController@createMedicalReportsQuestions')->name('createMedicalReportsQuestions');
    Route::post('medical_reports/{id}/questions/store', 'MedicalReportController@storeMedicalReportsQuestions')->name('storeMedicalReportsQuestions');
    Route::get('medical_reports/{id}/questions/{medicalReportQuestionId}/edit', 'MedicalReportController@editMedicalReportsQuestions')->name('editMedicalReportsQuestions');
    Route::post('medical_reports/{id}/questions/{medicalReportQuestionId}/update', 'MedicalReportController@updateMedicalReportsQuestions')->name('updateMedicalReportsQuestions');
    Route::get('medical_reports/{id}/questions/{page}', 'MedicalReportController@getAvailableMedicalReportsQuestionsPageOrders')->name('getAvailableMedicalReportsQuestionsPageOrders');
    Route::post('medical_reports/questions/options', 'MedicalReportController@getMedicalReportsQuestionsOptions')->name('getMedicalReportsQuestionsOptions');

    // medical reports questions datatable
    Route::post('medical_reports/{id}/getmedicalreportsquestionsdatatable', 'MedicalReportController@getMedicalReportsQuestionsDataTable')->name('getMedicalReportsQuestionsDataTable');
    Route::post('deletemedicalreportsquestions', 'MedicalReportController@deleteMedicalReportsQuestions')->name('deleteMedicalReportsQuestions');

    // approve medical report
    Route::get('approve_medical_reports', 'MedicalReportController@indexApprove');
    Route::get('approve_medical_reports/{medicalReportId}/approve', 'MedicalReportController@approveReport');

    // approve medical report datatable
    Route::get('approve_medical_reports_datatable', 'MedicalReportController@getApproveMedicalReportsDataTable')->name('getApproveMedicalReportsDataTable');
    Route::post('deletemedicalreportsapprove', 'MedicalReportController@deleteMedicalReportsApprove')->name('deleteMedicalReportsApprove');

    // approve medical report questions answers
    Route::get('approve_medical_reports/{id}/questions_answers', 'MedicalReportController@showMedicalReportsApproveQuestions')->name('showMedicalReportsApproveQuestions');
    Route::get('approve_medical_reports/{id}/questions_answers/{medicalReportQuestionId}/edit', 'MedicalReportController@editMedicalReportsApproveQuestions')->name('editMedicalReportsApproveQuestions');
    Route::post('approve_medical_reports/{id}/questions_answers/{medicalReportQuestionId}/update', 'MedicalReportController@updateMedicalReportsApproveQuestions')->name('updateMedicalReportsApproveQuestions');
    Route::post('approve_medical_reports/questions_answers/options', 'MedicalReportController@getMedicalReportsApproveQuestionsOptions')->name('getMedicalReportsApproveQuestionsOptions');
    Route::get('approve_medical_reports/{id}/questions_answers/{page}', 'MedicalReportController@getAvailableMedicalReportsApproveQuestionsPageOrders')->name('getAvailableMedicalReportsApproveQuestionsPageOrders');

    // approve medical report questions answers datatable
    Route::post('approve_medical_reports/{id}/getmedicalreportsapprovequestionsdatatable', 'MedicalReportController@getMedicalReportsApproveQuestionsDataTable')->name('getMedicalReportsApproveQuestionsDataTable');
    Route::post('deletemedicalreportsapprovequestions', 'MedicalReportController@deleteMedicalReportsApproveQuestions')->name('deleteMedicalReportsApproveQuestions');


});

Route::group(['middleware' => 'AdminAuth', 'prefix' => AD], function () {
    Route::group(['namespace' => CUSN], function () {
        Route::resource('customers', 'CustomersController',
            ['names' => [
                'index' => 'show_customers',
                'create' => 'add_customers',
                'show' => 'profile_customers',
                'edit' => 'edit_customers',
                'update' => 'update_customers',
                'destroy' => 'delete_customers'
            ]]);
        Route::get('get-customers-Datatable', 'CustomersController@getCustomersDataTable')->name('get-customers-Datatable');
        Route::get('get-customer-appointments-Datatable/{id}', 'CustomersController@getCustomerAppointmentsDataTable')->name('get-customer-appointments-Datatable');
        Route::get('get-customer-notifications-Datatable/{id}', 'CustomersController@getCustomerNotificationsDataTable')->name('get-customer-notifications-Datatable');

        Route::resource('family-members', 'FamilyMemberController',
            ['names' => [
                'index' => 'all_family_members',
                'create' => 'add_family_members',
                'show' => 'show_family_members',
                'edit' => 'edit_family_members',
                'update' => 'update_family_members',
                'destroy' => 'delete_family_members'
            ]]);
        Route::get('get-family-members-Datatable', 'FamilyMemberController@getFamilyMembersDataTable')->name('get-family-members-Datatable');
        Route::post('delete-family-members', 'FamilyMemberController@deleteFamilyMembers')->name('deleteFamilyMembers');
    });
});

Route::group(['prefix' => AD], function () {
    Route::group(['namespace' => INVN], function () {
        Route::get('invoices/generate/{booking}', 'InvoicesController@generateInvoice')->name('generate-invoice');
        Route::post('invoices/add-item', 'InvoicesController@addItemToInvoice')->name('add-item-to-invoice');
        Route::post('invoices/delete-item', 'InvoicesController@deleteItemToInvoice')->name('delete-item-to-invoice');
        Route::get('invoices/pay/{invoice}', 'InvoicesController@showPayInvoice')->name('show-pay-invoice');
        Route::post('invoices/pay', 'InvoicesController@storePayInvoice')->name('store-pay-invoice');
        Route::get('invoices', 'InvoicesController@index')->name('show-invoices');
        Route::get('get-invoices-Datatable', 'InvoicesController@getInvoicesDatatable')->name('get-invoices-Datatable');
    });

    Route::group(['namespace' => BSN], function () {
        Route::get('meetings/canceled', 'BookingServicesController@index')->name('meetings');
        Route::get('meetings/inprogress', 'BookingServicesController@index')->name('meetings');
        Route::get('meetings/confirmed', 'BookingServicesController@index')->name('meetings');
        Route::get('meetings/approve_unlock/{id}', 'BookingServicesController@approveUnlock')->name('approve-unlock');
        Route::get('get-meetings-Dat    atable', 'BookingServicesController@getBookingServicesDataTable')->name('get-meetings-Datatable');
        Route::get('meetings/{booking}', 'BookingServicesController@show')->name('show-meeting-details');
        Route::post('meetings/{booking}/assign-provider', 'BookingServicesController@assignProviderToMeeting')->name('assign-provider-to-meeting');
    });

    Route::group(['namespace' => MMRP], function () {
        Route::get('meetings/{id}/report', 'MeetingsMedicalReportController@index')->name('showMeetingReport');
        Route::get('meetings/{id}/report/create', 'MeetingsMedicalReportController@create')->name('createMeetingReport');
        Route::post('meetings/{id}/report/store', 'MeetingsMedicalReportController@store')->name('storeMeetingReport');
        Route::get('meetings/{id}/report/{reportId}/edit', 'MeetingsMedicalReportController@edit')->name('editMeetingReport');
        Route::post('meetings/{id}/report/{reportId}/update', 'MeetingsMedicalReportController@update')->name('updateMeetingReport');

        Route::get('meetings/{id}/reports/datatable', 'MeetingsMedicalReportController@getMedicalReportsDataTable')->name('getMeetingsMedicalReportsDataTable');
        Route::post('deleteMeetingReports', 'MeetingsMedicalReportController@deleteMedicalReports')->name('deleteMeetingsMedicalReports');
    });
});

Route::group(['middleware' => 'AdminAuth', 'namespace' => DRV, 'prefix' => AD], function () {
    Route::resource('drivers', 'DriversController',
        ['names' => [
            'index' => 'show drivers',
            'create' => 'create drivers',
            'show' => 'show drivers',
            'edit' => 'edit drivers',
            'destroy' => 'delete drivers'
        ]]);
    Route::get('getdriversdatatable', 'DriversController@getDriversDataTable')->name('getDriversDatatable');
    Route::post('deletedrivers', 'DriversController@deleteDrivers')->name('deleteDrivers');
});
