<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Quiz;
use App\Transformers\QuizTransformer;
use App\UserAnswer;
use App\User;
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

        $user = User::find($request['user_id']);

        foreach($request['options'] as $option){
            $ua = new UserAnswer;
            $ua->user_id = $user->id;
            $ua->quiz_option_id = $option;
            $ua->save();
        }

        $passed = $this->getTotalCorrectAnswers($user->answers);

        $data = [
            'user_id' => $user->id,
            'total_questions' => Quiz::count(),
            'passed' => $passed
        ];

        return $this->respondCreated('Answers saved', $data);

    }

    /**
     * Get total number of questions user got right
     */
    public function getTotalCorrectAnswers($answers){

        $passed = 0;

        foreach($answers as $answer){

            if($answer->option->is_correct == 'yes'){
                $passed++;
            }

        }

        return $passed;
    }
}
