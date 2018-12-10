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
        $dayDates = [];
        for ($i = 0; $i < $numberOfWeeks; $i++) {
            $date = Carbon::parse("next monday");
            $date->addWeek($i);
            $dayDate = $date->toDateString();
            dd($dayDate);
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

}