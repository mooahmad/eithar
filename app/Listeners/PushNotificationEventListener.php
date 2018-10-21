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
            $customer->notifications()->where('is_pushed', 0)->orderBy('created_at', 'asc')->get()->each(function ($notification) use ($now, $customer) {
                $data = json_decode(json_encode($notification->data));
                if (strtotime($data->send_at) <= strtotime($now)) {
                    $details = [
                        'notification_type' => $data->notification_type,
                        'related_id' => $data->related_id,
                        'send_at' => $data->send_at
                    ];
                    if (isset($data->service_type))
                        $details['service_type'] = $data->service_type;
                    if (isset($data->appointment_date)) {
                        $day = Carbon::parse($data->appointment_date)->format('Y-m-d');
                        $time = Carbon::parse($data->appointment_date)->format('g:i A');
                        $data->{'desc_' . $data->lang} = str_replace('@day', $day, $data->{'desc_' . $data->lang});
                        $data->{'desc_' . $data->lang} = str_replace('@time', $time, $data->{'desc_' . $data->lang});
                    }
                    if ($customer->pushNotification) {
                        $tokens[] = $customer->pushNotification->token;
                        $pushData = Utilities::buildNotification($data->{'title_' . $data->lang}, $data->{'desc_' . $data->lang}, 0, $details);
                        Utilities::pushNotification($tokens, $pushData);
                        $notification->is_pushed = 1;
                        $notification->save();
                    }
                }
            });
        });
    }
}
