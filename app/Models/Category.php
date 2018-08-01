<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Category extends Model
{
    use HasApiTokens, Notifiable, SoftDeletes;

    public $timestamps = false;
    protected $table = 'categories';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

}
