<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{

    /**
     * A quiz has many options
     */
    public function options(){
        return $this->hasMany(QuizOption::class);
    }
}
