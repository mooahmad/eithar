<?php

namespace App\Models;

use App\Helpers\Utilities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'providers';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function getProfilePicturePathAttribute($value)
    {
     return Utilities::getFileUrl($value, null, 'local', false);
    }

    public function services()
    {
        return $this->belongsToMany('App\Models\Service', 'provider_services', 'provider_id', 'service_id');
    }
}
