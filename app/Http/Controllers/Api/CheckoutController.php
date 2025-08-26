<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    use ApiResponseTrait;

        public function orderDetails(Request $request){
        $request->validate(
            [
                "username"=>"required|max:255|string",
                "street"=>"required|string|max:255",
                "house_no"=>"required|numeric",
                "zipcode"=>"required|string"
            ]);

        }
}
