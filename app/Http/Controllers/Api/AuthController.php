<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class AuthController extends Controller
{
    use ApiResponseTrait;
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
            "fname"=>"required|string|between:2,22",
            "lname"=>"required|string|between:2,22",
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

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "old_password" => "required",
            "new_password" => "required|min:8|confirmed"
        ]);

        if ($validator->fails()) {
            return $this->ApiResponse(null, $validator->errors()->first(), 422);
        }

        $user = auth()->user();
        if (!$user) {
            return $this->ApiResponse(null, "Unauthenticated", 401);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return $this->ApiResponse(null, "Old password is incorrect", 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return $this->ApiResponse(null, "Password updated successfully!", 200);
    }

    public function sendOtp(Request $request){
        $request->validate([
            "phone"=>"required|exists:users,phone"
        ]);
        $user = User::where('phone',$request->phone)->first();
        $otp = rand(100000,999999);
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert(
            ['email'=>$user->email],
            [
            'otp' => $otp,
            'token' => $token,
            'created_at' => now()
            ]);

        Mail::raw("Your OTP code is :$otp",function($msg) use ($user){
            $msg->to($user->email)->subject('Password Reset OTP');
        });

        return $this->ApiResponse($token,"OTP sent to your email",200);


    }

    public function verifyOtp(Request $request){
        $request->validate([
            "phone" => "required|exists:users,phone",
            "otp" => "required|numeric|digits:6"
        ]);

        $user = User::where('phone', $request->phone)->first();

        $record = DB::table('password_resets')
            ->where('email', $user->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record || now()->diffInMinutes($record->created_at) > 10) {
            return $this->ApiResponse(null, "Invalid or expired OTP", 400);
        }

        // Generate token and store in cache
        $token = Str::random(60);
        Cache::put('password_reset_' . $token, $user->phone, now()->addMinutes(15));

        return $this->ApiResponse(['token' => $token], "OTP verified", 200);
    }


    public function resetPassword(Request $request){
        $request->validate([
            "token" => "required|string",
            "new_password" => "required|min:8|confirmed"
        ]);

        $phone = Cache::get('password_reset_'.$request->token);
        if (!$phone){
            return $this->ApiResponse(null,"Invalid or expired token",400);
        }
        $user = User::where('phone',$phone)->first();
        if (!$user) {
            return $this->ApiResponse(null, "User not found for this token", 404);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();

        Cache::forget('password_reset_'.$request->token);
         return $this->ApiResponse(null, "Password updated successfully!", 200);

    }

    public function guestLogin(Request $request){
        $request->validate(
            [
                "email"=>"nullable|email"
            ]);
        
            $token = Str::random(60);
            Cache::put('guest_checkout_'.$token,[
                "email"=>$request->email ?? null,
            ],now()->addHours(2));

            return $this->ApiResponse($token,"guest session started!");

    }
}
