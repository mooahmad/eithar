<?php

namespace App\Models;

use App\Helpers\Utilities;
use App\Traits\ModelDateTimeAccessors;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Provider extends Authenticatable
{
    use SoftDeletes, Notifiable, HasMultiAuthApiTokens;

    public $timestamps = true;
    protected $table = 'providers';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at','last_login_date','contract_start_date','contract_expiry_date'];
    protected $hidden = [
        'password', 'remember_token', 'email_code', 'mobile_code', 'deleted_at', 'created_at', 'updated_at',
    ];

	protected $casts = [
		'no_of_visits'=>'int',
		'currency_id'=>'int',
		'email_verified'=>'int',
		'mobile_verified'=>'int',
		'no_of_followers'=>'int',
		'no_of_likes'=>'int',
		'no_of_views'=>'int',
		'no_of_ratings'=>'int',
		'no_of_reviews'=>'int',
		'is_active'=>'int',
		'is_doctor'=>'int',
		'visit_duration'=>'int',
		'time_before_next_visit'=>'int',
		'price'=>'double',
		'rating'=>'double',
	];

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($this->getMutatedAttributes() as $key) {
            if ($this->hidden) {
                if (in_array($key, $this->hidden)) {
                    continue;
                }

            }

            if ($this->visible) {
                if (!in_array($key, $this->visible)) {
                    continue;
                }

            }

            if (!array_key_exists($key, $attributes)) {
                $attributes[$key] = $this->mutateAttribute($key, null);
            }
        }

        return $attributes;
    }

    public function getTitleAttribute()
    {
        if (App::isLocale('en')) {
            return $this->title_en;
        } else {
            return $this->title_ar;
        }

    }

    public function getFirstNameAttribute()
    {
        if (App::isLocale('en')) {
            return $this->first_name_en;
        } else {
            return $this->first_name_ar;
        }

    }

    public function getLastNameAttribute()
    {
        if (App::isLocale('en')) {
            return $this->last_name_en;
        } else {
            return $this->last_name_ar;
        }

    }

    public function getSpecialityAreaAttribute()
    {
        if (App::isLocale('en')) {
            return $this->speciality_area_en;
        } else {
            return $this->speciality_area_ar;
        }

    }

    public function getAboutAttribute()
    {
        if (App::isLocale('en')) {
            return $this->about_en;
        } else {
            return $this->about_ar;
        }

    }

    public function getExperienceAttribute()
    {
        if (App::isLocale('en')) {
            return $this->experience_en;
        } else {
            return $this->experience_ar;
        }

    }

    public function getEducationAttribute()
    {
        if (App::isLocale('en')) {
            return $this->education_en;
        } else {
            return $this->education_ar;
        }

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

    public function calendarASC()
    {
        return $this->hasMany('App\Models\ProvidersCalendar', 'provider_id', 'id')->orderByDesc('start_date');
    }

    /**
     * get active providers and not expired contract
     * @return mixed
     */
    public function scopeGetActiveProviders()
    {
        return $this->where('is_active', config('constants.provider.active'))->where('contract_expiry_date', '>=', Carbon::now());
    }

    /**
     * @return mixed
     */
    public function scopeGetServiceProviders()
    {
        return $this->where('is_doctor', config('constants.provider.service_doctor'));
    }

    /**
     * get provider full name
     * @return string
     */
    public function getFullNameAttribute()
    {
        if (App::isLocale('en')) {
            return "{$this->title_en} {$this->first_name_en} {$this->last_name_en}";
        } else {
            return "{$this->title_ar} {$this->first_name_ar} {$this->last_name_ar}";
        }

    }

    public function pushNotification()
    {
        return $this->hasOne('App\Models\PushNotification', 'provider_id', 'id');
    }

    public function servicesBookings()
    {
        return $this->hasMany('App\Models\ServiceBooking', 'provider_id_assigned_by_admin', 'id');
    }

    public function servicesBookingsDesc()
    {
        return $this->hasMany('App\Models\ServiceBooking', 'provider_id_assigned_by_admin', 'id')->where('status_desc','!=','canceled')->orderByDesc('created_at');
    }
//    public function setContractStartDateAttribute()
//    {
//        if (isset(request()->headers->all()['time-zone'])) {
//            return Carbon::parse($this->attributes["contract_start_date"])->timezone(request()->headers->all()['time-zone'][0])->format('Y-m-d H:m:s');
//        } else {
//            return $this->attributes["contract_start_date"];
//        }
//    }

//    public function setContractExpiryDateAttribute()
//    {
//        if (isset(request()->headers->all()['time-zone'])) {
//            return Carbon::parse($this->attributes["contract_expiry_date"])->timezone(request()->headers->all()['time-zone'][0])->format('Y-m-d H:m:s');
//        } else {
//            return $this->attributes["contract_expiry_date"];
//        }
//    }

    public function setLastLoginDateAttribute()
    {
        if (isset(request()->headers->all()['time-zone'])) {
            return Carbon::parse($this->attributes["last_login_date"])->timezone(request()->headers->all()['time-zone'][0])->format('Y-m-d H:m:s');
        } else {
            return $this->attributes["last_login_date"];
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany(TransactionsUsers::class,'service_provider_id','id')
            ->where('type',config('constants.transactionsTypes.provider'))
            ->where('transaction_type',config('constants.transactions.rate'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id','id');
    }
}
