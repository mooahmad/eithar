<?php

namespace App\Models;

use App\Traits\ModelDateTimeAccessors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceBookingAppointment extends Model
{
    use SoftDeletes, ModelDateTimeAccessors;

    public $timestamps = true;
    protected $table = 'service_booking_appointments';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servicesBooking()
    {
        return $this->belongsTo(ServiceBooking::class, 'service_booking_id', 'id');
    }

    public function lapCalendar()
    {
        return $this->belongsTo('App\Models\LapCalendar', 'slot_id', 'id');
    }

    public function providerCalendar()
    {
        return $this->belongsTo('App\Models\ProvidersCalendar', 'slot_id', 'id');
    }

    public function serviceCalendar()
    {
        return $this->belongsTo('App\Models\ServicesCalendar', 'slot_id', 'id');
    }
}
