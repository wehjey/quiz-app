<?php

namespace App\Transformers;

use App\Transformers\Transform;
use Illuminate\Database\Eloquent\Collection;

class OptionTransformer extends Transform {


    public function transform($option) {

        return [
            'option_id' => $option->id,
            'option' => $option->option,
            'is_correct' => $option->is_correct
        ];

    }
}