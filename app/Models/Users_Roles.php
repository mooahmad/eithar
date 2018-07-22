<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users_Roles extends Pivot
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'users_roles';
    protected $dateFormat = 'Y-m-d H:m:s';

}
