<?php

namespace App\Http\Services\Adminstrator\SendingEmailModule\ClassesReport;


use App\Helpers\Utilities;
use App\Mail\Invoice\AddItemToInvoice;
use App\Mail\Invoice\GenerateInvoice;
use App\Models\MedicalReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;

class SendingEmailClass
{

    /**
     * @param $customer
     * @param $notification
     * @return bool
     */
    public static function prepareEmail($customer,$notification)
    {
        $notification_data = json_decode(json_encode($notification->data));
        if (!$notification_data->notification_type || $notification_data->notification_type<1 || $notification_data->notification_type>7) return false;

        if ($notification_data->notification_type == config('constants.pushTypes.invoiceGenerated')){
            try{
                Mail::to($customer)->send(new GenerateInvoice($customer,$notification_data));
                return true;
            }catch (\Exception $exception){
                return false;
            }
        }

        if ($notification_data->notification_type == config('constants.pushTypes.addItemToInvoice')){
            try{
                Mail::to($customer)->send(new AddItemToInvoice($customer,$notification_data));
                return true;
            }catch (\Exception $exception){
                return false;
            }
        }
        return false;
    }
}