<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Service extends Model
{
    use SoftDeletes;

    public    $timestamps = true;
    protected $table      = 'services';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates      = ['created_at', 'updated_at', 'deleted_at'];

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($this->getMutatedAttributes() as $key) {
            if ($this->hidden) {
                if (in_array($key, $this->hidden)) continue;
            }

            if ($this->visible) {
                if (!in_array($key, $this->visible)) continue;
            }

            if (!array_key_exists($key, $attributes)) {
                $attributes[$key] = $this->mutateAttribute($key, null);
            }
        }

        return $attributes;
    }

    public function getNameAttribute()
    {
        if (App::isLocale('en'))
            return $this->name_en;
        else
            return $this->name_ar;
    }

    public function getDescriptionAttribute()
    {
        if (App::isLocale('en'))
            return $this->description_en;
        else
            return $this->description_ar;
    }

    public function providers()
    {
        return $this->belongsToMany('App\Models\Provider', 'provider_services', 'service_id', 'provider_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }
}
