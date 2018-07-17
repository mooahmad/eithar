<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'customers';
    protected $dateFormat = 'U';
}
