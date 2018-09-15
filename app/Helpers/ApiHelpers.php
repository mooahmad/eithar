<?php

namespace App\Helpers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

/**
 * Class ApiHelpers
 * @package App\Helpers
 */
class ApiHelpers
{

    /**
     * this function for returning success response with a unified structure
     * @param int $status
     * @param $data json object
     * @return string
     */
    public static function success($status = 0, $data)
    {
        return response()->json(array("status" => $status, "data" => $data));
    }

    /**
     * this function for returning fail response with object of errors
     * @param int $status
     * MessageBag $message
     * @return string
     */
    public static function fail($status = 1,MessageBag $message)
    {
        return response()->json(array("status" => $status, "message" => $message));
    }

    /**
     * to classify request type whether it's web or api
     * @param Request $request
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function requestType(Request $request)
    {
        $uri = $request->path();
        if(str_contains($uri, 'api'))
            return config('constants.requestTypes.api');
        return config('constants.requestTypes.web');
    }

    public static function getCustomerWithToken(Customer $customer, $scopes = []){
        DB::table('oauth_access_tokens')->where('user_id', $customer->id)->delete();
        if(empty($scopes))
        $customer->access_token = $customer->createToken('customer')->accessToken;
        else
            $customer->access_token = $customer->createToken('customer', [])->accessToken;
        return $customer;
    }

    public static function getCustomerImages(Customer $customer){
        $customer->profile_picture_path = Utilities::getFileUrl($customer->profile_picture_path);
        $customer->nationality_id_picture = Utilities::getFileUrl($customer->nationality_id_picture);
        return $customer;
    }

    public static function reBuildCalendar($day, $calendar)
    {
        $dayDate = Carbon::parse($day)->format('Y-m-d');
        $morning = ["start" => "$dayDate 00:00:00", "end" => "$dayDate 12:00:00"];
        $afternoon = ["start" => "$dayDate 12:00:00", "end" => "$dayDate 17:00:00"];
        $evening = ["start" => "$dayDate 17:00:00", "end" => "$dayDate 23:59:59"];
        $reBuitCalendar = new \stdClass();
        $reBuitCalendar->day = $day;
        $reBuitCalendar->morning = [];
        $reBuitCalendar->afternoon = [];
        $reBuitCalendar->evening = [];
        $calendar->each(function ($calendar) use ($morning, $afternoon, $evening, &$reBuitCalendar) {
            $carbonStartDate = Carbon::parse($calendar->start_date);
            $slot = new \stdClass();
            $slot->id = $calendar->id;
            $slot->start_time = $carbonStartDate->format('g:i A');
            // lte $time >= start , gte $time <= end
            if (strtotime($calendar->start_date) >= strtotime($morning["start"]) && strtotime($calendar->start_date) <= strtotime($morning["end"])) {
                array_push($reBuitCalendar->morning, $slot);
            } elseif (strtotime($calendar->start_date) >= strtotime($afternoon["start"]) && strtotime($calendar->start_date) <= strtotime($afternoon["end"])) {
                array_push($reBuitCalendar->afternoon, $slot);
            } elseif (strtotime($calendar->start_date) >= strtotime($evening["start"]) && strtotime($calendar->start_date) <= strtotime($evening["end"])) {
                array_push($reBuitCalendar->evening, $slot);
            }
        });
        return $reBuitCalendar;
    }
}