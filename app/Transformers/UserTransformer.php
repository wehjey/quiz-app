<?php

namespace App\Transformers;

use App\Transformers\Transform;
use Illuminate\Database\Eloquent\Collection;

class UserTransformer extends Transform {


    public function transform($user) {

      $avatarUrl = null;

      if($user->image_path){
        $avatarUrl = url('').storage_path() . '/app/images/' .$user->image_path;
      }
      
      return [
        'name' => $user->name,
        'email' => $user->email,
        'avatar' => $avatarUrl
      ];

    }
}