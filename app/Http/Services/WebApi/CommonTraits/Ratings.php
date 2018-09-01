<?php

namespace App\Http\Services\WebApi\CommonTraits;


trait Ratings
{
    public function rate($model)
    {
        $model->no_of_ratings = $model->no_of_ratings + 1;
        $model->save();
    }
}