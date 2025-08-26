<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ApiResponseTrait;

    public function getUserData($id){
        $user = User::where('id',$id)->first();
        if (!$user){
            return $this->ApiResponseTrait(null,"There is no user with this id",404);
        }
        return $this->ApiResponse(UserResource::collection($user),"user data returned successfully!",200);
    }
}
