<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use App\Models\Notification;
class NotificationController extends Controller
{
    use ApiResponseTrait;

    public function create(Request $request){
        $request->validate([
            "desc"=>"required|string",
            "img"=> 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ]);
        $user = auth()->user();
        if (!$user ){
            return $this->ApiResponse(null,"Unauthenticated",401);
        }
        $imagePath = null;
        if ($request->hasFile('img')) 
        {
            $imagePath = $request->file('img')->store('notifications', 'public');
        }

        $notification = Notification::create([
            "user_id"=>$user->id,
            "img"=>$imagePath,
            "desc"=>$request->desc
        ]);

        return $this->ApiResponse(new NotificationResource($notification),"Notification Created Succesfully!",200);

    }

    public function list(){
        $user = auth()->user();
        if (!$user ){
            return $this->ApiResponse(null,"Unauthenticated",401);
        }
        $notifications=Notification::Where('user_id',$user->id)->orderBy('created_at')->get();
        return $this->ApiResponse(NotificationResource::collection($notifications),"Notifications returned Succesfully!",200);

    }

}
