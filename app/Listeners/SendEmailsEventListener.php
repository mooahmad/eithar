<?php

namespace App\Listeners;

use App\Events\SendEmailsEvent;
use App\Helpers\Utilities;
use App\Http\Services\Adminstrator\SendingEmailModule\ClassesReport\SendingEmailClass;
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
                    if (SendingEmailClass::prepareEmail($customer,$notification)){
                        $data->is_mailed    = 1;
                        $notification->data = $data;
                        $notification->save();
                    }
                }
            });
        });
    }
}
