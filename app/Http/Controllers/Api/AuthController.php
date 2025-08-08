<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api',['except'=>['login','register']]);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            // "email"=>"required|email",
            "phone"=>"required|size:11",
            "password"=>"required|string|min:6"
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        if (! $token = auth()->attempt($validator->validated())){
            return response()->json(['errors'=>"unautherized"],401);
        }
        return $this->createNewToken($token);


    }

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            "name"=>"required|string|between:2,22",
            "email"=>"required|email|unique:users",
            "password"=>"required|string|min:6",
            "phone"=>"required|size:11"
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }    
        $user = User::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]
        ));

        return response()->json([
            "message"=>"user successfully registered",
            "user"=>$user
        ],201);
    }

    public function logout(){
        auth()->logout();
        return response()->json(["message"=>"user successfuly signed out"]);
    }

    public function refresh(){
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile(){
        return response()->json(auth()->user());
    }


    protected function createNewToken($token)
    {
    //     if (!is_string($token) || substr_count($token, '.') !== 2) {
    //     return response()->json(['error' => 'Invalid token format'], 500);
    // }
        // $user = auth('api')->setToken($token)->user();
        return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth('api')->factory()->getTTL() * 60,
        'user' => auth()->setToken($token)->user(),
    ]);
    }
}
