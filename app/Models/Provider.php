<?php

namespace App\Models;

use App\Helpers\Utilities;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Provider extends Authenticatable
{
    use SoftDeletes, HasMultiAuthApiTokens;

    public $timestamps = true;
    protected $table = 'providers';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden = [
        'password', 'remember_token', 'email_code', 'mobile_code', 'deleted_at', 'created_at', 'updated_at'
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

    public function getTitleAttribute()
    {
        if(App::isLocale('en'))
            return $this->title_en;
        else
            return $this->title_ar;
    }

    public function getFirstNameAttribute()
    {
        if(App::isLocale('en'))
            return $this->first_name_en;
        else
            return $this->first_name_ar;
    }

    public function getLastNameAttribute()
    {
        if(App::isLocale('en'))
            return $this->last_name_en;
        else
            return $this->last_name_ar;
    }

    public function getSpecialityAreaAttribute()
    {
        if(App::isLocale('en'))
            return $this->speciality_area_en;
        else
            return $this->speciality_area_ar;
    }

    public function getAboutAttribute()
    {
        if(App::isLocale('en'))
            return $this->about_en;
        else
            return $this->about_ar;
    }

    public function getExperienceAttribute()
    {
        if(App::isLocale('en'))
            return $this->experience_en;
        else
            return $this->experience_ar;
    }

    public function getEducationAttribute()
    {
        if(App::isLocale('en'))
            return $this->education_en;
        else
            return $this->education_ar;
    }

    public function getProfilePicturePathAttribute($value)
    {
     return Utilities::getFileUrl($value, null, 'local', false);
    }

    public function services()
    {
        return $this->belongsToMany('App\Models\Service', 'provider_services', 'provider_id', 'service_id');
    }

    public function cities()
    {
        return $this->belongsToMany('App\Models\City', 'provider_cities', 'provider_id', 'city_id');
    }

    public function calendar()
    {
        return $this->hasMany('App\Models\ProvidersCalendar', 'provider_id', 'id');
    }
}
