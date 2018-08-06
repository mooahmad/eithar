<?php

namespace App\Models;

use App\Helpers\Utilities;
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

    public function getProfilePicturePathAttribute($value)
    {
        if(in_array($this->id, [1, 2, 3, 4, 5]))
        $value = Utilities::getFileUrl($value, null, 'local', true);
        else
            $value = Utilities::getFileUrl($value, null, 'local', false);
        return $value;
    }

}
