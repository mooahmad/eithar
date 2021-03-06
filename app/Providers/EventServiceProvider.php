<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\PushNotificationEvent' => [
            'App\Listeners\PushNotificationEventListener',
        ],
        'App\Events\SendEmailsEvent' => [
            'App\Listeners\SendEmailsEventListener',
        ],
        'App\Events\SendSMSEvent' => [
            'App\Listeners\SendSMSEventListener',
        ],
        'App\Events\UserTransactionsEvent' => [
            'App\Listeners\UserTransactionsEventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
