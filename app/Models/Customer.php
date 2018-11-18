<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

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
