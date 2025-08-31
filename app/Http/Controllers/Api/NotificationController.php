<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use App\Models\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FcmNotification;
use Illuminate\Support\Facades\Log;

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
        if ($user->device_token) {
            $this->sendFirebaseNotification(
                $user->device_token,
                "New Notification!",      // fixed title (you can customize it)
                $request->desc           // desc will be the body
            );
        }
        return $this->ApiResponse(new NotificationResource($notification), "Notification Created Successfully!", 200);

    }

    public function list(){
        $user = auth()->user();
        if (!$user ){
            return $this->ApiResponse(null,"Unauthenticated",401);
        }
        $notifications=Notification::Where('user_id',$user->id)->orderBy('created_at')->get();
        return $this->ApiResponse(NotificationResource::collection($notifications),"Notifications returned Succesfully!",200);

    }

    public function saveDeviceToken(Request $request)
    {
    $request->validate(['device_token' => 'required|string']);
    $user = auth()->user();
    $user->update(['device_token' => $request->device_token]);

    return $this->ApiResponse(null,"Device token saved successfully!",200);
    }

    function sendFirebaseNotification($deviceToken, $title, $body)
{
    $url = "https://fcm.googleapis.com/fcm/send";
    $serverKey = env('FIREBASE_SERVER_KEY'); // put in .env

    $data = [
        "to" => $deviceToken,
        "notification" => [
            "title" => $title,
            "body"  => $body,
            "sound" => "default"
        ]
    ];

    $headers = [
        "Authorization: key=" . $serverKey,
        "Content-Type: application/json"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

 public function testSendNotification(Request $request)
    {
        $request->validate([
            "device_token" => "required|string",
            "desc"         => "required|string"
        ]);

        $resp = $this->sendFirebaseNotification(
            $request->device_token,
            "Test Notification",
            $request->desc
        );

        return $this->ApiResponse('null',"Notification Sent!",200);
    }
   


}
