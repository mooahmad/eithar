<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use App\Traits\ModelDateTimeAccessors;

class MedicalReportsQuestions extends Model
{
    use SoftDeletes, ModelDateTimeAccessors;

    public $timestamps = true;
    protected $table = 'medical_reports_questions';
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

    public function getTitleAttribute()
    {
        if(App::isLocale('en'))
            return $this->title_en;
        else
            return $this->title_ar;
    }

    public function getSubtitleAttribute()
    {
        if(App::isLocale('en'))
            return $this->subtitle_en;
        else
            return $this->subtitle_ar;
    }

    public function getOptionsAttribute()
    {
        if(App::isLocale('en'))
            return $this->options_en;
        else
            return $this->options_ar;
    }
}
