<?php

namespace App\Http\Controllers;

use App\Models\Address;
// use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index($id){
        // $data['cats'] = Category::all();
        $data['addresses'] = Address::where('user_id',$id)->get();
        return view('user.address.address')->with($data);

    }

    public function addNewAddress(Request $request,$id){
        $request->validate([
            'house_no'=>"required|max:50",
            'street'=>"required|max:255",
            'type'=>"required|in:House,Work",
        ]);
        $user = User::findOrFail($id);
        $address = Address::create([
            'user_id'=>$user->id,
            'house_no' => $request->house_no,
            'street' => $request->street,
            'type' => $request->type,
            'country_id'=>1,
            'city_id'=>1,
            'governorate_id'=>1,
            "region_id"=>1,
            "zipcode_id"=>1,
        ]);

        $user->address_id = $address->id;
        $user->save();

        return redirect()->back();
    }
}
