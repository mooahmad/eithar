<?php

namespace App\Http\Services\WebApi\CommonTraits;


use App\Models\TransactionsUsers;
use Illuminate\Support\Facades\Auth;

trait Follows
{
    public function follow($service_provider_id, $type, $transactionDescription)
    {
        $transaction = new TransactionsUsers();
        $transaction->user_id = Auth::id();
        $transaction->service_provider_id = $service_provider_id;
        $transaction->type = $type;
        $transaction->transaction_type = config('constants.transactions.follow');
        $transaction->transaction_description = $transactionDescription;
        return $transaction->save();
    }

    public function unFollow($service_provider_id)
    {
     return TransactionsUsers::where([['user_id' => Auth::id()], ['service_provider_id' => $service_provider_id]])->delete();
    }
}