<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users_Roles extends Model
{
    use SoftDeletes;

    protected $table = 'users_roles';
    protected $dateFormat = 'U';
}
