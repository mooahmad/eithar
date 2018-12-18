<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelDateTimeAccessors;
use App\Traits\ModelStartEndTimeAccessors;

class ProvidersCalendar extends Model
{
    use SoftDeletes, ModelDateTimeAccessors, ModelStartEndTimeAccessors;

    public $timestamps = true;
    protected $table = 'providers_calendars';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'provider_id', 'start_date', 'end_date', 'is_available'
    ];

    /**
     * @return array
     */
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

    public function getStartDayAttribute()
    {
        return Carbon::parse($this->start_date)->format('Y-m-d');
    }
}
