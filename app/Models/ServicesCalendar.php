<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicesCalendar extends Model
{
    use SoftDeletes;

    public    $timestamps = true;
    protected $table      = 'services_calendars';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates      = ['created_at', 'updated_at', 'deleted_at','start_date','end_date'];
}
