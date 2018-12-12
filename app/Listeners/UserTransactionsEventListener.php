<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionsUsers;

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

        $updateServicesTransactions = DB::raw('update services as service set
         service.no_of_followers = (select count(id) from transactions_users as transaction where transaction.service_provider_id = service.id and transaction.type = 1 and transaction.transaction_type = 1 )
         , service.no_of_likes = (select count(id) from transactions_users as transaction where transaction.service_provider_id = service.id and transaction.type = 1 and transaction.transaction_type = 2 ) 
         , service.no_of_views = (select count(id) from transactions_users as transaction where transaction.service_provider_id = service.id and transaction.type = 1 and transaction.transaction_type = 5 )');

         $updateProvidersTransactions = DB::raw('update providers as provider set
         provider.no_of_followers = (select count(id) from transactions_users as transaction where transaction.service_provider_id = provider.id and transaction.type = 2 and transaction.transaction_type = 1 )
         , provider.no_of_likes = (select count(id) from transactions_users as transaction where transaction.service_provider_id = provider.id and transaction.type = 2 and transaction.transaction_type = 2 ) 
         , provider.no_of_views = (select count(id) from transactions_users as transaction where transaction.service_provider_id = provider.id and transaction.type = 2 and transaction.transaction_type = 5 )');
    }

}
