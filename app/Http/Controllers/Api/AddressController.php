<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use ApiResponseTrait;

    public function userAddress($id){
        $address = Address::with(['user','country','city','region','governorate','zipcode'])->where('user_id',$id)->get();
        if ($address->isEmpty()){
             return $this->ApiResponse(null,"No user with this address!",404);
        }
        return $this->ApiResponse(AddressResource::collection($address),"Address returned successfully!",200);
    }

    public function addAddress(Request $request,$id){
        $request->validate([
            "street"=>"required|string|max:255",
            "house_no" =>"required|numeric",
            "type"=>"required|string|in:house,work"
        ]);

        $user = User::find($id);
        if (!$user){
            return $this->ApiResponse(null,"User is not authenticated",401);
        }
        $address = new Address();
        $address->user_id = $user->id;
        $address->house_no = $request->house_no;
        $address->street = $request->street;
        $address->type = $request->type;
        $address->save();
        return $this->ApiResponse(["id"=>$address->id,"street"=>$address->street,"house_no"=>$address->house_no],"Address added successfully!",200);




    }

    
}
