<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceBookingLap extends Model
{
    use SoftDeletes;

    public    $timestamps = true;
    protected $table      = 'service_booking_laps';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates      = ['created_at', 'updated_at', 'deleted_at'];

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id','id');
    }
}
