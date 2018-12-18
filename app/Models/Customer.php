<?php

namespace App\Models;

use App\Helpers\Utilities;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\ModelDateTimeAccessors;

class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, ModelDateTimeAccessors;

    public $timestamps = true;
    protected $table = 'customers';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'mobile_number', 'password', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_code', 'mobile_code', 'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * @return array
     */
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

    /**
     * @return string
     */
    public function getMobileAttribute()
    {
        return str_after($this->mobile_number,config('constants.MobileNumberStart'));
    }

    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    /**
     * return active customers
     * @return mixed
     */
    public function scopeGetActiveCustomers()
    {
        return $this->where('mobile_verified', 1);
    }

    /**
     * return customer full name
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getProfileImageAttribute()
    {
        return Utilities::getFileUrl($this->profile_picture_path);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function servicesBooking()
    {
        return $this->hasMany('App\Models\ServiceBooking', 'customer_id', 'id');
    }

    public function pushNotification()
    {
        return $this->hasOne('App\Models\PushNotification', 'customer_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function family_members()
    {
        return $this->hasMany(FamilyMember::class,'user_parent_id','id');
    }
}
