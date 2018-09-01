<?php

namespace App\Http\Services\WebApi\CommonTraits;


trait Likes
{
  public function like($model)
  {
      $model->no_of_likes = $model->no_of_likes + 1;
      $model->save();
  }

    public function unlike($model)
    {
        $model->no_of_likes = $model->no_of_likes - 1;
        $model->save();
    }
}