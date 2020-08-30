<?php

namespace App\Http\Services\Adminstrator\SendingSMSModule\ClassesReport;

use Illuminate\Support\Facades\Facade;

class HismsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hisms';
    }
}
