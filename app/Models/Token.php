<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'tokens';
    protected $dateFormat = 'U';
}
