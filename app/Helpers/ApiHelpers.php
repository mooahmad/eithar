<?php

namespace App\Helpers;

use App\config\Config;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class ApiHelpers
{
    public static function success(Integer $status = 0, object $data = (object)[])
    {
        return json_encode(array("status" => $status, "data" => $data));
    }

    public static function fail(Integer $status = 1, Array $message = [])
    {
        return json_encode(array("status" => $status, "message" => $message));
    }

    public static function requestType(Request $request)
    {
        $uri = $request->path();
        if(str_contains($uri, '/api/'))
            return Config::getConfig('constants.requestTypes.api');
        return Config::getConfig('constants.requestTypes.web');
    }
}