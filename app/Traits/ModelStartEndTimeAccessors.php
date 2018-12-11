<?php
namespace App\Traits;

use Carbon\Carbon;

trait ModelStartEndTimeAccessors
{
    public function getStartDateAttribute()
    {
        if (isset(request()->headers->all()['time-zone'])) {
            return Carbon::parse($this->attributes["start_date"])->timezone(request()->headers->all()['time-zone'][0])->format('Y-m-d H:m:s');
        } else {
            return $this->attributes["start_date"];
        }
    }

    public function getEndDateAttribute()
    {
        if (isset(request()->headers->all()['time-zone'])) {
            return Carbon::parse($this->attributes["end_date"])->timezone(request()->headers->all()['time-zone'][0])->format('Y-m-d H:m:s');
        } else {
            return $this->attributes["end_date"];
        }
    }
}
