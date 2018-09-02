<?php

namespace App\Http\Services\WebApi\CommonTraits;

use App\Models\TransactionsUsers;
use Illuminate\Support\Facades\Auth;

trait Ratings
{
    public function rate($service_provider_id, $type, $transactionType, $transactionDescription)
    {
        $transaction = new TransactionsUsers();
        $transaction->user_id = Auth::id();
        $transaction->service_provider_id = $service_provider_id;
        $transaction->type = $type;
        $transaction->transaction_type = $transactionType;
        $transaction->transaction_description = $transactionDescription;
        return $transaction->save();
    }
}