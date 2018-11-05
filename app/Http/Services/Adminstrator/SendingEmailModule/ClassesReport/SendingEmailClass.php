<?php

namespace App\Http\Services\Adminstrator\SendingEmailModule\ClassesReport;


use App\Helpers\Utilities;
use App\Mail\Invoice\AddItemToInvoice;
use App\Mail\Invoice\GenerateInvoice;
use App\Mail\Meeting\AppointmentCanceled;
use App\Mail\Meeting\AppointmentConfirmed;
use App\Mail\Meeting\AppointmentReminder;
use App\Mail\Meeting\AssignProviderToMeeting;
use App\Mail\Meeting\MedicalReportAdded;
use App\Models\MedicalReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;

class SendingEmailClass
{

    /**
     * @param $model
     * @param $notification
     * @return bool
     */
    public static function prepareEmail($model,$notification)
    {
        $notification_data = json_decode(json_encode($notification->data));
        if (!$notification_data->notification_type || $notification_data->notification_type<1 || $notification_data->notification_type>10) return false;

//        Invoice Generated
        if ($notification_data->notification_type == config('constants.pushTypes.invoiceGenerated')){
            try{
                Mail::to($model)->send(new GenerateInvoice($model,$notification_data));
                return true;
            }catch (\Exception $exception){
                return false;
            }
        }

//        Add Item ToInvoice
        if ($notification_data->notification_type == config('constants.pushTypes.addItemToInvoice')){
            try{
                Mail::to($model)->send(new AddItemToInvoice($model,$notification_data));
                return true;
            }catch (\Exception $exception){
                return false;
            }
        }

//        Appointment Reminder
        if ($notification_data->notification_type == config('constants.pushTypes.appointmentReminder')){
            try{
                Mail::to($model)->send(new AppointmentReminder($model,$notification_data));
                return true;
            }catch (\Exception $exception){
                return false;
            }
        }
//        Appointment Confirmed
        if ($notification_data->notification_type == config('constants.pushTypes.appointmentConfirmed')){
            try{
                Mail::to($model)->send(new AppointmentConfirmed($model,$notification_data));
                return true;
            }catch (\Exception $exception){
                return false;
            }
        }
//        Appointment Canceled
        if ($notification_data->notification_type == config('constants.pushTypes.appointmentcanceled')){
            try{
                Mail::to($model)->send(new AppointmentCanceled($model,$notification_data));
                return true;
            }catch (\Exception $exception){
                return false;
            }
        }
//        Medical Report Added
        if ($notification_data->notification_type == config('constants.pushTypes.medicalReportAdded')){
            try{
                Mail::to($model)->send(new MedicalReportAdded($model,$notification_data));
                return true;
            }catch (\Exception $exception){
                return false;
            }
        }

//        Assign Provider To Meeting
        if ($notification_data->notification_type == config('constants.pushTypes.assignProviderToMeeting')){
            try{
                Mail::to($model)->send(new AssignProviderToMeeting($model,$notification_data));
                return true;
            }catch (\Exception $exception){
                return false;
            }
        }

        return false;
    }
}