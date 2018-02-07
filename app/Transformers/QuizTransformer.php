<?php

namespace App\Transformers;

use App\Transformers\Transform;
use Illuminate\Database\Eloquent\Collection;
use App\Transformers\OptionTransformer;

class QuizTransformer extends Transform {


    public function transform($quiz) {

      $options =  (new OptionTransformer)->transformCollection($quiz->options->all());;

      return [
        'question_id' => $quiz->id,
        'question' => $quiz->question,
        'options' => $options
      ];

    }
}