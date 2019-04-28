<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelDateTimeAccessors;

class JoinUs extends Model
{
    use SoftDeletes, ModelDateTimeAccessors;

    public    $timestamps = true;
    protected $table      = 'join_us';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates      = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class,'city_id','id');
    }
}
