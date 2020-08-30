<?php

namespace App\Http\Services\Adminstrator\DriversModule\ClassesDrivers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriversClass
{

    public static function CreateOrUpdate(Driver $driver, $name, $identity, $nationalId, $carType, $carColor, $carPlateNumber, $status)
    {
        $driver->name = $name;
        $driver->identity = $identity;
        $driver->national_id = $nationalId;
        $driver->car_type = $carType;
        $driver->car_color = $carColor;
        $driver->car_plate_number = $carPlateNumber;
        $driver->status = $status;
        return $driver->save();
    }
}