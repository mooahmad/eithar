<?php

namespace App\Http\Services\WebApi\CommonTraits;


trait Follows
{
    public function follow($model)
    {
        $model->no_of_followers = $model->no_of_followers + 1;
        $model->save();
    }

    public function unFollow($model)
    {
        $model->no_of_followers = $model->no_of_followers - 1;
        $model->save();
    }
}