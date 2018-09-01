<?php

namespace App\Http\Services\WebApi\CommonTraits;


trait Views
{
    public function view($model)
    {
        $model->no_of_views = $model->no_of_views + 1;
        $model->save();
    }
}