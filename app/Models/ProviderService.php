<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelDateTimeAccessors;

class ProviderService extends Pivot
{
    use SoftDeletes, ModelDateTimeAccessors;

    public $timestamps = true;
    protected $table = 'provider_services';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
