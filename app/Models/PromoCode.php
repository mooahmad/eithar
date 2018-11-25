<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $table = 'promo_codes';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeActivePromoCode()
    {
        return $this->where('is_approved',1)
            ->where('start_date','<=',Carbon::now())
            ->where('end_date','>=',Carbon::now());
    }
}
