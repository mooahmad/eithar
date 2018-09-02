<?php

namespace App\Http\Services\WebApi\CommonTraits;

use App\Models\TransactionsUsers;
use Illuminate\Support\Facades\Auth;

trait Likes
{
    public function like($service_provider_id, $type, $transactionType, $transactionDescription)
    {
        $transaction = new TransactionsUsers();
        $transaction->user_id = Auth::id();
        $transaction->service_provider_id = $service_provider_id;
        $transaction->type = $type;
        $transaction->transaction_type = $transactionType;
        $transaction->transaction_description = $transactionDescription;
        return $transaction->save();
    }

    public function unlike($service_provider_id)
    {
        return TransactionsUsers::where([['user_id' => Auth::id()], ['service_provider_id' => $service_provider_id]])->delete();
    }
}