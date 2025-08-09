<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Address;
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
}
