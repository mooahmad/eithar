<?php

namespace App\Listeners;

use App\Events\PushNotificationEvent;
use App\Helpers\Utilities;
use App\Models\Customer;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

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
        if (!Schema::hasTable('customers')) {
            return false;
        }

        $customers = Customer::all();
        $providers = Provider::all();
        $customers->each(function ($customer) {
            self::fireOnModel(config('constants.customer_message_cloud'), $customer);
        });

        $providers->each(function ($provider) {
            self::fireOnModel(config('constants.provider_message_cloud'), $provider);
        });

    }

    public static function fireOnModel($serverCloudKey, $model)
    {
        $now = Carbon::now()->format('Y-m-d H:m:s');
        $model->notifications()->where('is_pushed', 0)->orderBy('created_at', 'asc')->get()->each(function ($notification) use ($serverCloudKey, $now, $model) {
            $data = json_decode(json_encode($notification->data));
            if (strtotime($data->send_at) <= strtotime($now)) {
                $details = [
                    'notification_type' => $data->notification_type,
                    'related_id' => $data->related_id,
                    'send_at' => $data->send_at,
                ];
                if (isset($data->service_type)) {
                    $details['service_type'] = $data->service_type;
                }
                if ($data->lang == 'en'){
                    $desc  = $data->desc_en;
                    $title = $data->title_en;
                }else{
                    $desc  = $data->desc_ar;
                    $title = $data->title_ar;
                }
                if (isset($data->appointment_date)) {
                    $day = Carbon::parse($data->appointment_date)->format('Y-m-d');
                    $time = Carbon::parse($data->appointment_date)->format('g:i A');
                    $desc = str_replace('@day', $day, $desc);
                    $desc = str_replace('@time', $time, $desc);
                }
                if ($model->pushNotification) {
                    $tokens[] = $model->pushNotification->token;
                    $pushData = Utilities::buildNotification($title, $desc, 0, $details);
                    Utilities::pushNotification($serverCloudKey, $tokens, $pushData);
                    $notification->is_pushed = 1;
                    $notification->save();
                }
            }
        });
    }
}
