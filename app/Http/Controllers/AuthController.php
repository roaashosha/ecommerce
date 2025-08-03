<?php

namespace App\Http\Controllers;

// use App\Models\Category;
use App\Models\OtpCode;
// use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function loginForm(){

        return view("auth.login");
    }

    public function signUpForm(){
        return view("auth.sign");
    }

    public function sign(Request $request){
        $request->validate(
            [
                "phone"=>"required|min:11|max:11|string",
                "password"=>"required|string|min:8|confirmed",
                'agree' => 'accepted'
            ]
            );
        
        $agreed = $request->has('agree');
        $user = User::create(
            [
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'agreement_policies'=>$agreed
            ]
            );
        Auth::login($user);
        return redirect()->route("home");

    }

    public function login(Request $request){
        $request->validate(
            [
                "phone"=>"required|size:11|string",
                "password"=>"required|string|min:8"
            ]
            );
        $remember = $request->has('remember');
            $isLogin = Auth::attempt(["phone"=>$request->phone,"password"=>$request->password],$remember);
            if ( !$isLogin){
                return back();
            }
            else{
                return redirect()->route("home");                
            }
    }

    public function forgetPasswordForm(){
        // $data['cats'] = Category::all();
        return view('auth/forgot-password');
    }

    
    public function resetForm(Request $request){
        $data['phone'] = $request->phone;
        $data['otp'] = $request->otp;
        // $data['cats']= Category::all();
        return view('auth.confirm-password')->with($data);
    }

    public function reset(Request $request){
        $request->validate([
        'phone' => 'required|exists:users,phone',
        'otp' => 'required|digits:6',
        'password' => 'required|confirmed|min:8',
    ]);

        $otpRecord = \App\Models\OtpCode::where('phone', $request->phone)
            ->where('code', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (! $otpRecord) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        $user = User::where('phone', $request->phone)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        $otpRecord->delete(); // Optional: clear used OTP

        return redirect()->route('login')->with('success', 'Password reset successfully.');
    }

    public function sendOtp(Request $request){
        $request->validate(
            [
                'phone'=>"required|size:11|exists:users,phone"
            ]
            );
        $otp = rand(100000,999999);
        OtpCode::updateOrCreate(
            ['phone'=>$request->phone],
            [
                'code'=>$otp,
                'expires_at' =>Carbon::now()->addMinutes(10)           
             ]
            );
        $user = User::where('phone', $request->phone)->first();

    // send OTP to user's email
        Mail::raw("Your OTP code is: $otp", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Your Password Reset OTP');
        });

        return redirect()->route('otp.form')->withInput(['phone' => $request->phone])->with('success', 'OTP sent to your email.');

    }

    public function verifyOtpForm(){
        // $data['cats'] = Category::all();
        return view('auth.OTP');
    }

    public function verifyOtp(Request $request){
        $request->validate(
            [
                "otp"=>"required|array|size:6",
                "otp.*"=>"required|digits:1",
                'phone' => 'required|exists:users,phone',
            ]
            );
        $enteredOtp = implode('',$request->otp);
        $record = OtpCode::where('phone',$request->phone)->where('code',$enteredOtp)->where('expires_at','>',now())->first();
        if (! $record){
            return back()->withErrors(['otp' => 'Invalid or expired OTP code.']);
        }
        return redirect()->route('password.reset', ['phone' => $request->phone,'otp' => implode('', $request->otp)]);

    }

            
    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('phone', $request->phone)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password changed successfully.');
    }

    public function changePasswordIndex($id){
        $data['user'] = User::findOrFail($id);
        // $data['cats'] = Category::all();
        return view('auth.change-password')->with($data);
    }

    public function changePassword(Request $request){
        $request->validate([
            "old_password"=>"required",
            "password"=>"required|string|min:8|confirmed"
        ]);
        $user = Auth::user();
        if (! Hash::check($request->old_password,$user->password)){
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        $user->password = Hash::make($request->password);
        $user->save();
         return back();
    }

    public function logout(Request $request){
        Auth::logout(); // Logs out the user
        $request->session()->invalidate(); // Invalidates the session
        $request->session()->regenerateToken(); // Regenerates CSRF token

        return redirect('/');
    }
}

