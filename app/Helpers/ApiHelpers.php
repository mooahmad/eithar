<?php

namespace App\Helpers;

use phpDocumentor\Reflection\Types\Integer;

class ApiHelpers
{
    public static function success(Integer $status = 0, object $data = (object)[])
    {
        return json_encode(array("status" => $status, "data" => $data));
    }

    public static function fail(Integer $status = 0, String $message = "")
    {
        return json_encode(array("status" => $status, "message" => $message));
    }
}