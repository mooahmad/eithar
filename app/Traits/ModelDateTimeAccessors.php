<?php
namespace App\Traits;

use Carbon\Carbon;

trait ModelDateTimeAccessors
{
    public function getDeletedAtAttribute()
    {
        if (isset(request()->headers->all()['time-zone']) && isset($this->attributes["deleted_at"])) {
            return Carbon::parse($this->attributes["deleted_at"])->timezone(request()->headers->all()['time-zone'][0])->format('Y-m-d H:m:s');
        } else {
            return $this->attributes["deleted_at"];
        }
    }

    public function getCreatedAtAttribute()
    {
        if (isset(request()->headers->all()['time-zone'])) {
            return Carbon::parse($this->attributes["created_at"])
                ->timezone(request()->headers->all()['time-zone'][0])->format('Y-m-d H:m:s');
        } else {
            return $this->attributes["created_at"];
        }
    }

    public function getUpdatedAtAttribute()
    {
        if (isset(request()->headers->all()['time-zone'])) {
            return Carbon::parse($this->attributes["updated_at"])->timezone(request()->headers->all()['time-zone'][0])->format('Y-m-d H:m:s');
        } else {
            return $this->attributes["updated_at"];
        }
    }
}
