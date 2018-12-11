<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelDateTimeAccessors;
use App\Traits\ModelStartEndTimeAccessors;

class LapCalendar extends Model
{
   use SoftDeletes, ModelDateTimeAccessors, ModelStartEndTimeAccessors;

    public    $timestamps = true;
    protected $table      = 'lap_calendars';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates      = ['created_at', 'updated_at', 'deleted_at'];
}
