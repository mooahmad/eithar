<?php

namespace App\Listeners;

use App\Http\Services\Adminstrator\SendingSMSModule\ClassesReport\HismsClient;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Provider;
use App\Events\SendSMSEvent;
use Illuminate\Support\Facades\Schema;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Services\Adminstrator\SendingSMSModule\ClassesReport\SendingSMSClass;

class SendSMSEventListener implements ShouldQueue
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
        if (!Schema::hasTable('customers')) {
            return false;
        }
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
                if ($data->lang == 'en'){
                    $desc  = $data->desc_en;
                    $title = $data->title_en;
                }else{
                    $desc  = $data->desc_ar;
                    $title = $data->title_ar;
                }
                $message  = $title .'-'.$desc;
                $numbers = [$model->mobile_number];
                if (HismsClient::sendSMS($message,$numbers)) {
                    $notification->is_smsed = 1;
                    $notification->save();
                }
            }
        });
    }
}
