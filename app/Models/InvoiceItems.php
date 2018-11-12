<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItems extends Model
{
    use SoftDeletes;

    protected $table = 'invoice_items';

    protected $primaryKey = 'id';

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $fillable = [
        'invoice_id','item_desc_appear_in_invoice','service_id','provider_id','status','price'
    ];

    /**
     * @return mixed
     */
    public function scopePendingItems()
    {
        return $this->where('status',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class,'invoice_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id','id');
    }
}
