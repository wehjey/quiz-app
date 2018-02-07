<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends ApiController
{
    public function login(Request $request){

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']], true)) {    
            
            $user = User::where('email',$request['email'])->first();

            Auth::login($user, true); //Manaully log in user

            return $this->respondCreated('Login successful'); 
        }else{
            return $this->respondNotFound('Invalid email or password');
        }

    }
}
