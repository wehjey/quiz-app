<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;

abstract class Transform {

    public abstract  function transform($item);

    public function transformCollection(array $item){

        return array_map([$this, 'transform'], $item);

    }

}