<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProvidersCalendar extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'providers_calendars';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'provider_id', 'start_date', 'end_date', 'is_available'
    ];
}
