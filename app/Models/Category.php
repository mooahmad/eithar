<?php

namespace App\Models;

use App\Helpers\Utilities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Passport\HasApiTokens;
use App\Traits\ModelDateTimeAccessors;

class Category extends Model
{
    use HasApiTokens, Notifiable, SoftDeletes;

    public $timestamps = true;
    protected $table = 'categories';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
    	'category_parent_id'=>'int',
    ];

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($this->getMutatedAttributes() as $key)
        {
            if ($this->hidden)
            {
                if (in_array($key, $this->hidden)) continue;
            }

            if($this->visible)
            {
                if (!in_array($key, $this->visible)) continue;
            }

            if (!array_key_exists($key, $attributes))
            {
                $attributes[$key] = $this->mutateAttribute($key, null);
            }
        }

        return $attributes;
    }

    public function getNameAttribute()
    {
        if(App::isLocale('en'))
        return $this->category_name_en;
        else
            return $this->category_name_ar;
    }

    public function getDescriptionAttribute()
    {
        if(App::isLocale('en'))
            return $this->description_en;
        else
            return $this->description_ar;
    }

    public function getProfilePicturePathAttribute($value)
    {
        if(in_array($this->id, [1, 2, 3, 4, 5]))
        $value = Utilities::getFileUrl($value, null, 'local', true);
        else
            $value = Utilities::getFileUrl($value, null, 'local', false);
        return $value;
    }

    public function services()
    {
        return $this->hasMany('App\Models\Service', 'category_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'category_parent_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_parent_id', 'id');
    }

    /**
     * @return mixed
     */
    public function scopeGetParentCategories()
    {
        return $this->whereNull('category_parent_id')->take(5);
    }

}
