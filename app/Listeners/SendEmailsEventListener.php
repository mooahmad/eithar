<?php

namespace App\Listeners;

use App\Events\SendEmailsEvent;
use App\Helpers\Utilities;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailsEventListener
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
     * @param  SendEmailsEvent  $event
     * @return void
     */
    public function handle(SendEmailsEvent $event)
    {
        $now = Carbon::now()->format('Y-m-d H:m:s');
        $customers = Customer::all();
        $customers->each(function ($customer) use ($now) {
            $customer->notifications->each(function ($notification) use ($now, $customer) {
                $data = json_decode(json_encode($notification->data));
                if ($data->is_mailed == 0 && $data->send_at <= $now) {
//                    $data->is_pushed = 1;
//                    $notification->data = $data;
//                    $notification->save();
                    $details = [
                        'notification_type' => $data->notification_type,
                        'related_id' => $data->related_id,
                        'send_at' => $data->send_at
                    ];

                    $tokens[] = $customer->pushNotification->token;
                    $pushData = Utilities::buildNotification($data->{'title_'.$data->lang}, $data->{'desc_'.$data->lang}, 0, $details);
                    Utilities::pushNotification($tokens, $pushData);
                }
            });
        });
        dd($customers);
    }
}
