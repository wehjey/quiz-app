<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{

    /**
     * User answer belongs to a user
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * A user has many options
     */
    public function options(){
        return $this->hasMany(QuizOption::class);
    }
}
