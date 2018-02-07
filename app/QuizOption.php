<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizOption extends Model
{
    /**
     * An option belongs to a quiz
     */
    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
}
