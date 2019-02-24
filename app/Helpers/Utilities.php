<?php

namespace App\Helpers;


use App\Mail\Invoice\GenerateInvoice;
use Carbon\Carbon;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\MessageBag;

class Utilities
{
    public static function getValidationError($errorType = null, MessageBag $errorsBag)
    {
        return new ValidationError($errorType, $errorsBag);
    }

    /**
     * this function add and delete image
     *
     * @param $file
     * @param $path
     * @param null $old_image_path
     * @param string $disk
     * @return mixed
     */
    public static function UploadFile($file, $path, $oldImagePath = null, $disk = 'local')
    {
        //Delete old image
        if (!empty($oldImagePath))
            self::DeleteFile($oldImagePath);
        return $file->store($path, $disk);
    }


    /**
     *  this function take image path and cut string by storage as default
     * @param $imagePath
     * @param string $disk
     * @return bool
     */
    public static function DeleteFile($imagePath, $disk = 'local')
    {
        if (!empty($imagePath)) {
            if (Storage::disk($disk)->exists($imagePath)) {
                Storage::disk($disk)->delete($imagePath);
                return true;
            }
        }
        return false;
    }

    public static function validateImage(Request $request, $fileName)
    {
        if (empty($request->file($fileName)) || !$request->file($fileName)->isValid())
            return false;
        $request->validate([
            $fileName => 'image',
        ]);
        return true;
    }

    public static function getFileUrl($fullFilePath = null, $temporaryTimeMinutes = null, $disk = 'local', $isStatic = false)
    {
        if (empty($fullFilePath) || $isStatic)
            return $fullFilePath;
        $exists = Storage::disk($disk)->exists($fullFilePath);
        if (!$exists)
            return "";
        if ($temporaryTimeMinutes)
            $url = Storage::temporaryUrl(
                $fullFilePath, now()->addMinutes($temporaryTimeMinutes)
            );
        else
            $url = Storage::url($fullFilePath);
        return URL::to('/public/') . $url;
    }

    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param  int $length
     * @return string
     */
    public static function quickRandom($length = 6, $onlyDigits = false)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($onlyDigits)
            $pool = '0123456789';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    public static function forgetModelItems(&$model, Array $items = [])
    {
        foreach ($items as $item) {
            if (isset($model->{$item}) || $model->{$item} == null || empty($model->{$item}))
                unset($model->{$item});
        }
    }

    public static function calcPercentage($total, $percentage)
    {
        return $total * ($percentage / 100);
    }

    public static function getDayDatesOfWeeks($day = "monday", $numberOfWeeks = 0)
    {
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        Carbon::setWeekEndsAt(Carbon::SUNDAY);
        $daysMaped = [
            1 => "monday",
            2 => "tuesday",
            3 => "wednesday",
            4 => "thursday",
            5 => "friday",
            6 => "saturday",
            0 => "sunday"
        ]; 
        $dayDates = [];
        $todayOfWeek = $daysMaped[Carbon::now()->dayOfWeek];
        for ($i = 0; $i < $numberOfWeeks; $i++) {
            if($todayOfWeek == $day)
            $date = Carbon::now();
            else
            $date = Carbon::parse("next $day");
            $date->addWeek($i);
            $dayDate = $date->toDateString();
            array_push($dayDates, $dayDate);
        }
        return $dayDates;
    }

    public static function GenerateHours()
    {
        $times = [];
        for ($i = 0; $i < 24; $i++) {
            ($i < 10) ? $second_item = '0' : $second_item = '';
            $times[$second_item . $i . ':00'] = $second_item . $i . ':00';
            $times[$second_item . $i . ':30'] = $second_item . $i . ':30';
        }
        return $times;
    }

    public static function pushNotification($serverApiKey, $tokens, $data)
    {
        $push = new PushNotification('fcm');
        $push->setUrl(env('FIREBASE_URL', 'https://fcm.googleapis.com/fcm/send'));
        $push->setApiKey($serverApiKey);
        $push->setMessage($data);
        $push->setDevicesToken($tokens);
        return $push->send()->getFeedback();
    }

    public static function buildNotification($title, $message, $badge, $arrCustomData)
    {
        $arrCustomData['title'] = $title;
        $arrCustomData['body'] = $message;
        return [
            'notification' => [
                'title' => $title,
                'body' => $message,
                "badge" => $badge,
                'sound' => 'default'
            ],
            'data' => $arrCustomData
        ];
    }

    public static function prepareEmail($customer,$notification_data)
    {
        if (!$notification_data->notification_type || $notification_data->notification_type<1 || $notification_data->notification_type>7) return false;

//        check on notification type
        return Mail::to($customer)->send(new GenerateInvoice($customer,$notification_data));
    }

    /**
     * @param $message
     * @param $redirect_to
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function successMessageAndRedirect($message,$redirect_to)
    {
        session()->flash('success_msg', $message);
        return redirect($redirect_to);
    }

    /**
     * @param $message
     * @param $redirect_to
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function errorMessageAndRedirect($message,$redirect_to)
    {
        session()->flash('error_msg', $message);
        return redirect($redirect_to);
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function beautyName($name)
    {
        return str_replace(' ','-',$name);
    }

    /**
     * @param null $share_title
     * @param null $share_description
     * @param null $share_image
     */
    public static function setMetaTagsAttributes($share_title=null,$share_description=null,$share_image=null)
    {
        session()->flash('share_title',$share_title);
        session()->flash('share_description',strip_tags(str_limit($share_description,200)));
        session()->flash('share_image',$share_image);
    }

    /**
     * @param $number_views
     * @return string
     */
    public static function stars($number_views)
    {
        $whole = floor($number_views);
        $fraction = $number_views - $whole;

        $decimal=0;
        if($fraction < .25){
            $decimal=0;
        }elseif($fraction >= .25 && $fraction < .75){
            $decimal=.50;
        }elseif($fraction >= .75){
            $decimal=1;
        }
        $r = $whole + $decimal;

        //As we sometimes round up, we split again
        $stars="";
        $newwhole = floor($r);
        $fraction = $r - $newwhole;

        for($s=1;$s<=$newwhole;$s++){
            $stars .= '<li> <i class="fa fa-star fa-fw"></i> </li>';
        }
        if($fraction==.5){
            $stars .= '<li> <i class="fa fa-star-half fa-fw"></i> </li>';
        }
        return $stars;
    }

    /**
     * @return \Illuminate\Config\Repository|int|mixed
     */
    public static function GetCustomerVAT()
    {
        $vat = 0;
        if (auth()->guard('customer-web')->check()){
            if (auth()->guard('customer-web')->user()->is_saudi_nationality == 0){
                $vat = config('constants.vat_percentage');
            }
        }
        return $vat;
    }

    /**
     * @param $mobile
     * @return string
     */
    public static function AddCountryCodeToMobile($mobile)
    {
        return config('constants.MobileNumberStart').$mobile;
    }

    /**
     * @return array
     */
    public static function GetCustomerInfoByIp(){
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
        $result  = [
            'country'=>'',
            'city'=>'',
            'ip'=>'',
            'region'=>'',
            'country_code'=>'',
            'currency_code'=>'',
            'currency_symbol'=>'',
            'currency_converter'=>'',
            'timezone'=>config('app.timezone'),
            'latitude'=>'',
            'longitude'=>'',
        ];
        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }else{
            $ip = $remote;
        }
        $except_ips = ['localhost','127.0.0.1','::1'];
//          $ip = '156.222.135.29';
        if(! in_array($ip,$except_ips)){
            $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
            if($ip_data && $ip_data->geoplugin_countryName != null && $ip_data->geoplugin_status == 200)
            {
                $result['ip'] = $ip_data->geoplugin_request;
                $result['country'] = $ip_data->geoplugin_countryName;
                $result['city'] = $ip_data->geoplugin_city;
                $result['region'] = $ip_data->geoplugin_region;
                $result['country_code'] = $ip_data->geoplugin_countryCode;
                $result['currency_code'] = $ip_data->geoplugin_currencyCode;
                $result['currency_symbol'] = $ip_data->geoplugin_currencySymbol_UTF8;
                $result['currency_converter'] = $ip_data->geoplugin_currencyConverter;
                $result['timezone'] = $ip_data->geoplugin_timezone;
                $result['latitude'] = $ip_data->geoplugin_latitude;
                $result['longitude'] = $ip_data->geoplugin_longitude;
            }
        }
        return $result;
    }
}