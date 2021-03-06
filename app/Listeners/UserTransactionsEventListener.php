<?php

namespace App\Listeners;

use App\Events\UserTransactionsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
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
    public function handle(UserTransactionsEvent $event)
    {
        if (!Schema::hasTable('customers')) {
            return false;
        }

        $updateServicesTransactions = DB::statement('update services as service set
         service.no_of_followers = (select count(id) from transactions_users as transaction where transaction.service_provider_id = service.id and transaction.type = 1 and transaction.transaction_type = 1 )
         , service.no_of_likes = (select count(id) from transactions_users as transaction where transaction.service_provider_id = service.id and transaction.type = 1 and transaction.transaction_type = 2 ) 
         , service.no_of_views = (select count(id) from transactions_users as transaction where transaction.service_provider_id = service.id and transaction.type = 1 and transaction.transaction_type = 5) 
         , service.no_of_ratings = (select count(id) from transactions_users as transaction where transaction.service_provider_id = service.id and transaction.type = 1 and transaction.transaction_type = 3)
        , service.no_of_reviews = (select count(id) from transactions_users as transaction where transaction.service_provider_id = service.id and transaction.type = 1 and transaction.transaction_type = 4 )');

        $updateProvidersTransactions = DB::statement('update providers as provider set
         provider.no_of_followers = (select count(id) from transactions_users as transaction where transaction.service_provider_id = provider.id and transaction.type = 2 and transaction.transaction_type = 1 )
         , provider.no_of_likes = (select count(id) from transactions_users as transaction where transaction.service_provider_id = provider.id and transaction.type = 2 and transaction.transaction_type = 2 ) 
         , provider.no_of_views = (select count(id) from transactions_users as transaction where transaction.service_provider_id = provider.id and transaction.type = 2 and transaction.transaction_type = 5 )
           , provider.no_of_ratings = (select count(id) from transactions_users as transaction where transaction.service_provider_id = provider.id and transaction.type = 2 and transaction.transaction_type = 3)
        , provider.no_of_reviews = (select count(id) from transactions_users as transaction where transaction.service_provider_id = provider.id and transaction.type = 2 and transaction.transaction_type = 4 )');

    }

}
