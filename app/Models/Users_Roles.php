<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users_Roles extends Pivot
{
    use SoftDeletes;

    protected $table = 'users_roles';
    protected $dateFormat = 'U';

}
