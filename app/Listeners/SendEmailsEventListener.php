<?php

namespace App\Listeners;

use App\Events\SendEmailsEvent;
use App\Helpers\Utilities;
use App\Http\Services\Adminstrator\SendingEmailModule\ClassesReport\SendingEmailClass;
use App\Models\Customer;
use App\Models\Provider;
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
     * @param  SendEmailsEvent $event
     * @return void
     */
    public function handle(SendEmailsEvent $event)
    {
        $customers = Customer::all();
        $providers = Provider::all();

        $customers->each(function ($customer) {
            self::fireEmail($customer);
        });

        $providers->each(function ($provider) {
            self::fireEmail($provider);
        });
    }

    /**
     * @param $model
     */
    public static function fireEmail($model)
    {
        $now = Carbon::now()->format('Y-m-d H:m:s');

        $model->notifications()->where('is_emailed', 0)->latest()->get()->each(function ($notification) use ($now, $model) {
            $data = json_decode(json_encode($notification->data));
            if (strtotime($data->send_at) <= strtotime($now)) {
                if (SendingEmailClass::prepareEmail($model, $notification)) {
                    $notification->is_emailed = 1;
                    $notification->save();
                }
            }
        });
    }
}
