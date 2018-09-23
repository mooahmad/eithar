<?php

namespace App\Listeners;

use App\Events\PushNotificationEvent;
use App\Helpers\Utilities;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PushNotificationEventListener
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
        $now = Carbon::now()->format('Y-m-d H:m:s');
        $customers = Customer::all();
        $customers->each(function ($customer) use ($now) {
            $customer->notifications->each(function ($notification) use ($now, $customer) {
                $data = json_decode(json_encode($notification->data));
                if ($data->is_pushed == 0 && strtotime($data->send_at) <= strtotime($now)) {
                    $data->is_pushed = 1;
                    $notification->data = $data;
                    $notification->save();
                    $details = [
                        'notification_type' => $data->notification_type,
                        'related_id' => $data->related_id
                    ];
                    $tokens[] = $customer->pushNotification->token;
                    $pushData = Utilities::buildNotification($data->{'title_'.$data->lang}, $data->{'desc_'.$data->lang}, 0, $details);
                    Utilities::pushNotification($tokens, $pushData);
                }
            });
        });
    }
}
