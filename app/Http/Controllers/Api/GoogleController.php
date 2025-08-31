<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Google\ApiCore\ArrayTrait;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Google\Client as GoogleClient;
use App\Models\User;

class GoogleController extends Controller
{
    use ApiResponseTrait;
     public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
     public function mobileLogin(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        $client = new GoogleClient(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $payload = $client->verifyIdToken($request->id_token);

        if ($payload) {
            $user = User::updateOrCreate(
                ['email' => $payload['email']],
                [
                    'name' => $payload['name'],
                    'google_id' => $payload['sub'],
                    'avatar' => $payload['picture'],
                    "phone"=>null
                ]
            );

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->ApiResponse(["user"=>$user,"token"=>$token],"User returned successfully!",200);
        }

        return $this->ApiResponse(null,"Invalid Google Token",401);
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]
        );

        $token = $user->createToken('auth_token')->plainTextToken;

         return $this->ApiResponse(["user"=>$user,"token"=>$token],"User returned successfully!",200);
    }
}
