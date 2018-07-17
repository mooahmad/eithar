<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'notifications';
    protected $dateFormat = 'U';
}
