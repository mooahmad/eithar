<?php

namespace App\Providers;

use App\Policies\AdminPolicy;
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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // policies
        Gate::define('admins.view', 'App\Policies\AdminPolicy@view');
        Gate::define('admins.create', 'App\Policies\AdminPolicy@create');
        Gate::define('admins.update', 'App\Policies\AdminPolicy@update');
        Gate::define('admins.delete', 'App\Policies\AdminPolicy@delete');

        // passport
        Passport::routes();

        Passport::enableImplicitGrant();

        Passport::tokensExpireIn(now()->addDays(15));

        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
