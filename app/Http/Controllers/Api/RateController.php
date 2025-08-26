<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rate;
use App\Http\Resources\RateResource;
class RateController extends Controller
{
    use ApiResponseTrait;
    public function store(Request $request){
        $request->validate([
            "product_id"=>"required|exists:products,id",
            "stars"=>"required|integer|max:5|min:1"
        ]);

        $user = auth()->user();
        if (!$user){
            return $this->ApiResponse(null,"Unauthenticated",401);
        }

        $rate = Rate::Create([
            "user_id"=>$user->id,
            "product_id"=>$request->product_id,
            "stars"=>$request->stars
        ]);

        return $this->ApiResponse(new RateResource($rate),"Rate Created Succesfully!",200);
    }

    public function updateRate(Request $request,$rateId){
        $request->validate([
            "stars"=>"required|integer|min:1|max:5"
        ]);
        $user = auth()->user();
        if (!$user){
            return $this->ApiResponse(null."Unauthenticated",401);
        }
        $rate = Rate::find($rateId);
        if ($rate->user_id !== $user->id){
              return $this->ApiResponse(null, "Unauthorized", 403);
        }

        $rate->stars = $request->stars;
        $rate->save();
        return $this->ApiResponse(new RateResource($rate),"Rate updated Succesfully!",200);

    }

    public function destroyRate($rateId){
        $user = auth()->user();
        if (!$user){
            return $this->ApiResponse(null,"Unauthenticated",401);
        }
        $rate = Rate::find($rateId);
        if ($rate->user_id !== $user->id){
              return $this->ApiResponse(null, "Unauthorized", 403);
        }
        $rate->delete();
        return $this->ApiResponse(null, "Rate deleted successfully!", 200);

    }

    public function ratingStats($productId)
    {
    $ratings = Rate::where('product_id', $productId)->get();
    $stats = [];
    foreach (range(1, 5) as $star) {
        $stats[$star] = $ratings->where('stars', $star)->count();
    }

    return $this->ApiResponse($stats,"Rating stats returned Successfully!",200);
}



    public function productRates($productId){
        $rates = Rate::where("product_id",$productId)->get();
        if (!$rates){
            return $this->ApiResponse(null,"No Rates",404);
        }
         return $this->ApiResponse(RateResource::collection($rates),"Rates returned Succesfully!",200);        
    }
}
