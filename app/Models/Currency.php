<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Currency extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $table = 'currencies';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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

    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        if (App::isLocale('en'))
            return $this->name_eng;
        else
            return $this->name_ara;
    }
}
