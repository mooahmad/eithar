<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use SoftDeletes;

    protected $table = 'contact_uses';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $dates =[
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
