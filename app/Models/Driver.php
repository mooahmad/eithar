<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelDateTimeAccessors;

class Driver extends Model
{
    use SoftDeletes, ModelDateTimeAccessors;
    
    public $timestamps = true;
    protected $table = 'drivers';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
