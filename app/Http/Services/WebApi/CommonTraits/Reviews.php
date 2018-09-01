<?php

namespace App\Http\Services\WebApi\CommonTraits;


trait Reviews
{
    public function review($model)
    {
        $model->no_of_reviews = $model->no_of_reviews + 1;
        $model->save();
    }
}