<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function updateProfile(Request $request,$id){
          $user = User::find($id);
          if (!$user){
            return $this->ApiResponse(null,"User not found!",404);
          }  

          $validator = Validator::make($request->all(),[
            "phone"=>"required|string",
            "name"=>"required|String|max:255",
            "lang"=>"required|in:en,ar"
          ]);

          if ($validator->fails()){
            return $this->ApiResponse(null,$validator->errors()->first(),422);
          }

          $user = auth()->user();

          if (!$user){
            return $this->ApiResponse(null,"User not authenticated",401);
          }

          $user->username = $request->name;
          $user->phone = $request->phone;
          $user->lang = $request->lang;
          $user->save();

          return $this->ApiResponse(["id"=>$user->id,"username"=>$user->username,"phone"=>$user->phone,"language"=>$user->lang],"User data updated successfully!",200);         

    }

    public function getUserData($id){
        $user = User::where('id',$id)->first();
        if (!$user){
            return $this->ApiResponse(null,"There is no user with this id",404);
        }
        return $this->ApiResponse(new UserResource($user),"user data returned successfully!",200);
    }

    public function SetPhoto(Request $request ,$id){
        $user = User::find($id);
        if (!$user){
          return $this->ApiResponse(null,"User not found",404);
        }  

        $authUser = auth()->user() ?? session('user');
        if (!$authUser || $authUser->id != $user->id){
          return $this->ApiResponse(null,"Unauthorized",403);
        }
        $request->validate(
            ["img" =>'required|image|mimes:jpeg,png,jpg,gif|max:2028']
            );
        $file = $request->file('img');
        $fileName = time().'_'.$file->getClientOriginalName();
        $path = $file->storeAs('uploads/profile_photo',$fileName,'public');
        $user->img = $path;
        $user->save();
        return $this->ApiResponse($fileName, "Profile photo updated successfully!", 200);
      
      }

      public function deleteUser(Request $request){
          $user =auth()->user();
          if (!$user ){
            return $this->ApiResponse(null, "Unauthenticated", 401);
          }

          $cart = $user->cart;
          if ($cart) {
              $cart->CartItems()->delete();
              $cart->delete();
          }

          if ($user->img){
            if (Storage::disk('public')->exists($user->img)){
              Storage::disk('public')->delete($user->img);
            }
          }

          $user->delete();
           return $this->ApiResponse(null, "Your account has been deleted successfully", 200);
      }

      public function setLanguage(Request $request){
        $user = auth()->user();
        if (!$user ){
            return $this->ApiResponse(null, "Unauthenticated", 401);
          }
        $request->validate([
          "lang"=>"required|in:en,ar"
        ]);
        $user->lang = $request->lang;
        $user->save();
        return $this->ApiResponse(['lang' => $user->lang], "Language updated successfully!", 200);
        

      }
}
