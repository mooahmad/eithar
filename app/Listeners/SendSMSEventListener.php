<?php

namespace App\Listeners;

use App\Events\SendSMSEvent;
use App\Http\Services\Adminstrator\SendingSMSModule\ClassesReport\SendingSMSClass;
use App\Models\Customer;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSMSEventListener
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
     * @param  SendSMSEvent  $event
     * @return void
     */
    public function handle(SendSMSEvent $event)
    {
        $customers = Customer::all();
        $providers = Provider::all();

        $customers->each(function ($customer) {
            self::fireSMS($customer);
        });

        $providers->each(function ($provider) {
            self::fireSMS($provider);
        });
    }

    /**
     * @param $model
     */
    public static function fireSMS($model)
    {
        $now = Carbon::now()->format('Y-m-d H:m:s');

        $model->notifications()->where('is_smsed', 0)->latest()->get()->each(function ($notification) use ($now, $model) {
            $data = json_decode(json_encode($notification->data));
            if (strtotime($data->send_at) <= strtotime($now)) {
                $message  = $data->{'title_'.$data->lang} .'-'.$data->{'desc_'.$data->lang};
                $numbers = [$model->mobile_number];
                if (SendingSMSClass::sendSMS($message,$numbers)) {
                    $notification->is_smsed = 1;
                    $notification->save();
                }
            }
        });
    }
}
