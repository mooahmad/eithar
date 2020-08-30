<?php

namespace App\Http\Controllers\Administrator;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Services\Adminstrator\SendingSMSModule\ClassesReport\HismsClient;
use App\Http\Services\Adminstrator\SendingSMSModule\ClassesReport\SendingSMSClass;
use App\Listeners\SendSMSEventListener;
use App\Models\LapCalendar;
use App\Models\Customer;
use App\Models\MedicalReports;
use App\Models\Provider;
use App\Models\ProvidersCalendar;
use App\Models\PushNotificationsTypes;
use App\Models\ServiceBooking;
use App\Models\ServicesCalendar;
use App\Notifications\AssignProviderToMeeting;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class SmsController extends Controller
{
    public function forgetPassword($mobile)
    {
        $customer = Customer::where('mobile_number',$mobile)->first();

        $encrytedCode = Utilities::quickRandom(6, true);
        $customer->forget_password_code = $encrytedCode;
        $customer->save();
        $message_code = $customer->forget_password_code;
        $title = 'Eithar';
        $message  = $title .'-'.$message_code;
        $numbers = [$customer->mobile_number];

        $response = HismsClient::sendSMS($message,$numbers);

        return \response()->json($response);
            // Mail::to($customer->email)->send(new ForgetPasswordMail($customer));
  //   return \response()->json(HismsClient::sendSMS($message,$numbers));
        //    (new HismsClient())($customer->message,$customer->numbers);
//        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

}