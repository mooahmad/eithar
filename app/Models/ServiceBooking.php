<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelDateTimeAccessors;

class ServiceBooking extends Model
{
    use SoftDeletes, ModelDateTimeAccessors;

    public    $timestamps = true;
    protected $table      = 'service_bookings';
    protected $guarded    = [];
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates      = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promo_code()
    {
        return $this->belongsTo(PromoCode::class,'promo_code_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function family_member()
    {
        return $this->belongsTo(FamilyMember::class,'family_member_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function service_appointments()
    {
        return $this->hasMany(ServiceBookingAppointment::class,'service_booking_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function booking_lap_services()
    {
        return $this->hasMany(ServiceBookingLap::class,'service_booking_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assigned_provider()
    {
        return $this->belongsTo(Provider::class,'provider_id_assigned_by_admin','id');
    }

    public function medicalReports()
    {
        return $this->hasMany(BookingMedicalReports::class, 'service_booking_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class,'service_booking_id','id');
    }
}
