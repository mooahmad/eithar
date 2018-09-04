<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Invoices;
use App\Models\PromoCode;
use App\Models\Questionnaire;
use App\Models\Service;
use App\Policies\AdminPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\InvoicesPolicy;
use App\Policies\PromoCodesPolicy;
use App\Policies\QuestionnairePolicy;
use App\Policies\ServicePolicy;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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
        Invoices::class => InvoicesPolicy::class,
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

        // policies promoCodes
        Gate::define('promo_code.view', 'App\Policies\PromoCodesPolicy@view');
        Gate::define('promo_code.create', 'App\Policies\PromoCodesPolicy@create');
        Gate::define('promo_code.update', 'App\Policies\PromoCodesPolicy@update');
        Gate::define('promo_code.delete', 'App\Policies\PromoCodesPolicy@delete');

//        Invoices Policies
        Gate::define('invoices.view','App\Policies\InvoicesPolicy@view');
        Gate::define('invoices.create','App\Policies\InvoicesPolicy@create');
        Gate::define('invoices.update','App\Policies\InvoicesPolicy@update');
        Gate::define('invoices.delete','App\Policies\InvoicesPolicy@delete');
//        Gate::define('invoices.view','App\Policies\InvoicesPolicy@restore');
//        Gate::define('invoices.view','App\Policies\InvoicesPolicy@forceDelete');

        // passport
        Passport::routes();

        Passport::enableImplicitGrant();

        Passport::tokensExpireIn(now()->addMinutes(60));

        Passport::refreshTokensExpireIn(now()->addMinutes(50));
    }
}
