<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Quiz;
use App\Transformers\QuizTransformer;
use App\UserAnswer;
use Illuminate\Support\Facades\Auth;

class QuizController extends ApiController
{
    /**
     * Display all questions
     */
    public function getQuizzes(){

        $quizzes = Quiz::all();

        $data = (new QuizTransformer)->transformCollection($quizzes->all());

        return $this->respondCreated('All Questions',$data);
    }

    /**
     * Confirm user answer to questions
     */
    public function confirmAnswers(Request $request){

        foreach($request['options'] as $option){

            $ua = new UserAnswer;
            $ua->user_id = Auth::id();
            $ua->quiz_option_id = $option;
            $ua->save();

        }

        return $this->respondCreated('Answers saved');

    }
}
