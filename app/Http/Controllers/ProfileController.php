<?php

namespace App\Http\Controllers;

// use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index($id){
        // $data['cats'] = Category::all();
        $data['user'] = User::findOrFail($id);
        return view('user.profile.profile')->with($data);
    }

    public function update (Request $request,$id){
        $request->validate([
            "name"=>"required|string|max:50",
            "phone"=>"required|size:11|string",
            "lang"=>"required|in:ar,en"
        ]);
        $user = User::findOrFail($id); ;
        $nameParts = explode(' ', trim($request->name), 2);
        $user->first_name = $nameParts[0];
        $user->last_name = $nameParts[1] ?? '';
        $user->phone = $request->phone;
        $user->lang = $request->lang;
        $user->save();
        $user = $user->fresh();
        return redirect()->back();
    
    }
}