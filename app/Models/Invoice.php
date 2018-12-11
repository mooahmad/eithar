<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelDateTimeAccessors;

class Invoice extends Model
{
    use SoftDeletes, ModelDateTimeAccessors;

    protected $table = 'invoices';

    protected $primaryKey = 'id';

    protected $guarded =[];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at','invoice_date'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function booking_service()
    {
        return $this->belongsTo(ServiceBooking::class,'service_booking_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(InvoiceItems::class,'invoice_id','id');
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
    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id','id');
    }

    public function getInvoiceDateAttribute()
    {
        if (isset(request()->headers->all()['time-zone'])) {
            return Carbon::parse($this->attributes["invoice_date"])->timezone(request()->headers->all()['time-zone'][0])->format('Y-m-d H:m:s');
        } else {
            return $this->attributes["invoice_date"];
        }
    }
}
