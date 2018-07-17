<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'family_members';
    protected $dateFormat = 'U';
}
