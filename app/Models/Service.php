<?php

namespace App\Models;

use App\Helpers\Utilities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use App\Traits\ModelDateTimeAccessors;
use Carbon\Carbon;

class Service extends Model
{
    use SoftDeletes;

    public    $timestamps = true;
    protected $table      = 'services';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates      = ['created_at', 'updated_at', 'deleted_at','expiry_date'];

	protected $casts = [
		'category_id'=>'int',
		'country_id'=>'int',
		'currency_id'=>'int',
		'type'=>'int',
		'no_of_visits'=>'int',
		'visits_per_week'=>'int',
		'visit_duration'=>'int',
		'time_before_next_visit'=>'int',
		'is_active_service'=>'int',
		'no_of_followers'=>'int',
		'no_of_likes'=>'int',
		'no_of_views'=>'int',
		'no_of_ratings'=>'int',
		'no_of_reviews'=>'int',
		'appear_on_website'=>'int',
		'price'=>'double',
	];
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
            return $this->desc_en;
        else
            return $this->desc_ar;
    }

    public function getBenefitsAttribute()
    {
        if (App::isLocale('en'))
            return $this->benefits_en;
        else
            return $this->benefits_ar;
    }

    public function providers()
    {
        return $this->belongsToMany('App\Models\Provider', 'provider_services', 'service_id', 'provider_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    /**
     * get Services that type is Item
     * @return mixed
     */
    public function scopeGetItemsServices()
    {
        return $this->where('type', 3);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendar()
    {
        return $this->hasMany('App\Models\ServicesCalendar', 'service_id', 'id');
    }

    public function medicalReports()
    {
        return $this->hasMany('App\Models\MedicalReports', 'service_id', 'id');
    }

    public function getProfilePicturePathAttribute($value)
    {
        return Utilities::getFileUrl($value, null, 'local', false);
    }

//    public function setExpiryDateAttribute()
//    {
//        if (isset(request()->headers->all()['time-zone'])) {
//            return Carbon::parse($this->expiry_date)->timezone(request()->headers->all()['time-zone'][0])->format('Y-m-d H:m:s');
//        } else {
//            return $this->expiry_date;
//        }
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionnaire()
    {
        return $this->hasMany(Questionnaire::class,'service_id','id');
    }
}
