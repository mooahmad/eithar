<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Schema;

class UserTransactionsEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(PushNotificationEvent $event)
    {
        if (!Schema::hasTable('customers')) {
            return false;
        }


    }

}
