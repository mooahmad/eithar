<?php

namespace App\Helpers;

use Illuminate\Http\Request;
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
        return json_encode(array("status" => $status, "data" => $data));
    }

    /**
     * this function for returning fail response with object of errors
     * @param int $status
     * MessageBag $message
     * @return string
     */
    public static function fail($status = 1,MessageBag $message)
    {
        return json_encode(array("status" => $status, "message" => $message));
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
}