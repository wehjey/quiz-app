<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Transformers\UserTransformer;
use Socialite;

class UserController extends ApiController
{
    /**
     * Authenticate user
     * return user data
     */
    public function login(Request $request){

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']], true)) {    
            
            $user = User::where('email',$request['email'])->first();

            Auth::login($user, true); //Manaully log in user

            $data = (new UserTransformer)->transform($user);

            return $this->respondCreated('Login successful', $data); 
        }else{
            return $this->respondNotFound('Invalid email or password');
        }

    }

    /**
     * Register user
     */
    public function register(Request $request){

        try{
            $user = new User;
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->save();
        }
        catch(Exception $e){
            return $this->respondInternalError('Error creating user');
        }

        $data = (new UserTransformer)->transform($user);
        
        return $this->respondCreated('User registered successfully', $data); 

    }

    /**
     * Redirect to facebook login page
     */
    public function redirectToProvider($provider){
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $providerUser = Socialite::driver($provider)->stateless()->user();
    
        $user = User::query()->firstOrNew(['email' => $providerUser->getEmail()]);
    
        if (!$user->exists) {
            $user->name = $providerUser->getName();
            $user->save(); 
        }

        $data = (new UserTransformer)->transform($user);
        
        return $this->respondCreated('User registered successfully', $data); 
    
    }

    /**
     * Fetch user information
     */
    public function getUserData($user_id){

        $user = User::find($user_id);

        if($user){
            $data = (new UserTransformer)->transform($user);
            return $this->respondCreated('User Data', $data); 
        }else{
            return $this->respondNotFound('No user found');
        }

    }

    /**
     * Upload user avatar
     */
    public function uploadAvatar(Request $request){

        $user = User::find($request['user_id']);

        if($request->hasFile('avatar'))
        {
            $image = $request['avatar'];
            
            $extension = $image->getClientOriginalExtension();
            $filename = str_random(13).'.'.$extension;

            $image->storeAs('avatars',$filename);
            
            $user->image_path = $filename;
            $user->save();
            
        }

        $data = (new UserTransformer)->transform($user);

        return $this->respondCreated('Login successful', $data); 

    }
}
