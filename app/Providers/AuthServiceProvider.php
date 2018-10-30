<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Invoice;
use App\Models\MedicalReports;
use App\Models\PromoCode;
use App\Models\Provider;
use App\Models\Service;
use App\Models\Settings;
use App\Policies\AdminPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\DriverPolicy;
use App\Policies\FamilyMemberPolicy;
use App\Policies\InvoicesPolicy;
use App\Policies\MedicalReportPolicy;
use App\Policies\PromoCodesPolicy;
use App\Policies\ProviderGuardPolicy;
use App\Policies\ServicePolicy;
use App\Policies\SettingsPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => AdminPolicy::class,
        Category::class => CategoryPolicy::class,
        Service::class => ServicePolicy::class,
        PromoCode::class => PromoCodesPolicy::class,
        Invoice::class => InvoicesPolicy::class,
        Customer::class => CustomerPolicy::class,
        Customer::class => FamilyMemberPolicy::class,
        MedicalReports::class => MedicalReportPolicy::class,
        Settings::class => SettingsPolicy::class,
        Provider::class => ProviderGuardPolicy::class,
        Driver::class => DriverPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // policies admins
        Gate::define('admins.view', 'App\Policies\AdminPolicy@view');
        Gate::define('admins.create', 'App\Policies\AdminPolicy@create');
        Gate::define('admins.update', 'App\Policies\AdminPolicy@update');
        Gate::define('admins.delete', 'App\Policies\AdminPolicy@delete');

        // policies categories
        Gate::define('category.view', 'App\Policies\CategoryPolicy@view');
        Gate::define('category.create', 'App\Policies\CategoryPolicy@create');
        Gate::define('category.update', 'App\Policies\CategoryPolicy@update');
        Gate::define('category.delete', 'App\Policies\CategoryPolicy@delete');

        // policies services
        Gate::define('service.view', 'App\Policies\ServicePolicy@view');
        Gate::define('service.create', 'App\Policies\ServicePolicy@create');
        Gate::define('service.update', 'App\Policies\ServicePolicy@update');
        Gate::define('service.delete', 'App\Policies\ServicePolicy@delete');

        // policies providers
        Gate::define('provider.view', 'App\Policies\ProviderPolicy@view');
        Gate::define('provider.create', 'App\Policies\ProviderPolicy@create');
        Gate::define('provider.update', 'App\Policies\ProviderPolicy@update');
        Gate::define('provider.delete', 'App\Policies\ProviderPolicy@delete');

        //Policies Provider Guard
        Gate::define('provider_guard.view', 'App\Policies\ProviderGuardPolicy@view');
        Gate::define('provider_guard.update', 'App\Policies\ProviderGuardPolicy@update');
        Gate::define('provider_guard.create', 'App\Policies\ProviderGuardPolicy@create');
        Gate::define('provider_guard.delete', 'App\Policies\ProviderGuardPolicy@delete');

        // policies promoCodes
        Gate::define('promo_code.view', 'App\Policies\PromoCodesPolicy@view');
        Gate::define('promo_code.create', 'App\Policies\PromoCodesPolicy@create');
        Gate::define('promo_code.update', 'App\Policies\PromoCodesPolicy@update');
        Gate::define('promo_code.delete', 'App\Policies\PromoCodesPolicy@delete');

        // policies medical report
        Gate::define('medical_report.view', 'App\Policies\MedicalReportPolicy@view');
        Gate::define('medical_report.create', 'App\Policies\MedicalReportPolicy@create');
        Gate::define('medical_report.update', 'App\Policies\MedicalReportPolicy@update');
        Gate::define('medical_report.delete', 'App\Policies\MedicalReportPolicy@delete');

        // policies categories
        Gate::define('drivers.view', 'App\Policies\DriverPolicy@view');
        Gate::define('drivers.create', 'App\Policies\DriverPolicy@create');
        Gate::define('drivers.update', 'App\Policies\DriverPolicy@update');
        Gate::define('drivers.delete', 'App\Policies\DriverPolicy@delete');

        // policies settings
        Gate::define('settings.view', 'App\Policies\SettingsPolicy@view');
        Gate::define('settings.create', 'App\Policies\SettingsPolicy@create');
        Gate::define('settings.update', 'App\Policies\SettingsPolicy@update');
        Gate::define('settings.delete', 'App\Policies\SettingsPolicy@delete');

//        Invoices Policies
        Gate::resource('invoices', 'App\Policies\InvoicesPolicy');

        // policies Meetings
        Gate::define('meetings.view', 'App\Policies\BookingServicesPolicy@view');
        Gate::define('meetings.create', 'App\Policies\BookingServicesPolicy@create');
        Gate::define('meetings.update', 'App\Policies\BookingServicesPolicy@update');
        Gate::define('meetings.delete', 'App\Policies\BookingServicesPolicy@delete');

//        Customers Policies
        Gate::resource('customers', 'App\Policies\CustomerPolicy');

//        Family Members Policies
        Gate::resource('family_member', 'App\Policies\FamilyMemberPolicy');

//        Service Booking Policies
        Gate::define('meetings.view', 'App\Policies\BookingServicesPolicy@view');

        // passport
        Passport::routes();

        Passport::enableImplicitGrant();

        Passport::tokensExpireIn(now()->addMinutes(60));

        Passport::refreshTokensExpireIn(now()->addMinutes(50));

        // Middleware `oauth.providers` middleware defined on $routeMiddleware above
        Route::group(['middleware' => 'oauth.providers'], function () {
            Passport::routes(function ($router) {
                return $router->forAccessTokens();
            });
        });
    }
}
