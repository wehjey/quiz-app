<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * User management routes
 */
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::get('user/{user_id}', 'UserController@getUserData');
Route::post('upload-avatar', 'UserController@uploadAvatar');

/**
 * Facebook login routes
 */
Route::get('auth/{provider}', 'UserController@redirectToProvider');
Route::get('auth/{provider}/callback', 'UserController@handleProviderCallback');

/**
 * Quiz routes
 */
Route::get('get-quiz', 'QuizController@getQuizzes');
Route::post('user-answers', 'QuizController@confirmAnswers');


